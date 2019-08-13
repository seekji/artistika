<?php

namespace App\Command;

use App\Application\Sonata\MediaBundle\Entity\Media;
use App\Service\SettingsService;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\MediaBundle\Document\MediaManager;
use Sonata\MediaBundle\Provider\FileProvider;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpClient\HttpClient;

class InstagramCommand extends Command
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var SettingsService
     */
    private $settingsService;

    /**
     * InstagramCommand constructor.
     * @param SettingsService $settingsService
     * @param string|null $name
     */
    public function __construct(SettingsService $settingsService, ?string $name = null)
    {
        parent::__construct($name);

        $this->settingsService = $settingsService;
        $this->token = getenv('INSTAGRAM_TOKEN');
        $this->userId = getenv('INSTAGRAM_USER_ID');
    }

    protected function configure()
    {
        $this
            ->setName('artistika:instagram:last-photo')
            ->setDescription('Getting last photo from instagram profile.')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return bool|int|null
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if(empty($this->token) || empty($this->userId)) {
            $output->writeln('Setup instagram credentials in .evn file before use this command.');

            return false;
        }

        $output->writeln('Trying to update last photo.');

        try {
            $httpClient = HttpClient::create();
            $response = $httpClient->request('GET','https://api.instagram.com/v1/users/' . $this->userId . '/media/recent/', ['query' => [
                'access_token' => $this->token,
                'count' => 1,
            ]]);

            $content = json_decode($response->getContent(false), 1);
            $this->settingsService->saveValue('instagram_last_photo', $content['data'][0]['images']['standard_resolution']['url']);

            $output->writeln('Picture successfully saved/updated to site settings file.');
        } catch (\Exception $exception) {
            $output->writeln(sprintf('Got error: %s', $exception->getMessage()));
        }
    }
}