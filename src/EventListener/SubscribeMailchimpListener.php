<?php

namespace App\EventListener;

use App\Entity\Subscribe;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;

/**
 * Class SubscribeMailchimpListener
 * @package App\EventListener
 */
class SubscribeMailchimpListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SubscribeMailchimpListener constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param LifecycleEventArgs $args
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $apiKey = getenv('MAILCHIMP_API_KEY');
        $listId = getenv('MAILCHIMP_LIST_ID');

        if (!$entity instanceof Subscribe || empty($apiKey) || empty($listId)) {
            return;
        }

        try {
            $httpClient = HttpClient::create();
            $response = $httpClient->request('POST',"https://us3.api.mailchimp.com/3.0/lists/{$listId}/members/", [
                'headers' => [
                    'Authorization' => 'apikey ' . $apiKey,
                ],
                'json' => [
                    'email_address' => $entity->getEmail(),
                    'status' => 'subscribed',
                ]
            ]);

            $content = json_decode($response->getContent(false),1);

            $this->logger->info(sprintf('Saving email %s. Response code: %s, Response content %s', $entity->getEmail(), $response->getStatusCode(), serialize($response->toArray(false))));

            if($response->getStatusCode() === 400) {
                $entity->setMailchimpId($content['detail']);
            }

            if(isset($content['id'])) {
                $entity->setMailchimpId($content['id']);
            }

        } catch (\Exception $exception) {
            $this->logger->critical(sprintf('Error while submitting email %s to mailchimp: %s', $entity->getEmail(), $exception->getMessage()));
        }
    }
}
