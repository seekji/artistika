<?php

namespace App\DataFixtures\ORM;

use App\Application\Sonata\MediaBundle\Entity\Media;
use App\Entity\Classification\Tag;
use App\Entity\Event;
use App\Entity\EventSchedule;
use App\Entity\Handbook\City;
use App\Entity\Handbook\Hall;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Faker\Generator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class LoadEventDataFixture
 * @package App\DataFixtures\ORM
 */
class LoadEventDataFixture extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    const COUNT_ELEMENTS = 50;

    /**
     * @var ContainerInterface
     */
    private $container;

    /** @var Generator */
    private $faker;

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create();

        $halls = $manager->getRepository(Hall::class)->findAll();
        $tags = $manager->getRepository(Tag::class)->findAll();
        $cities = $manager->getRepository(City::class)->findAll();

        $smallImage = new UploadedFile(__DIR__ . '/../static/event_small.png', basename(__DIR__ . '/../static/event_small.png'), null, null, null, true);
        $bigImage = new UploadedFile(__DIR__ . '/../static/event_big.png', basename(__DIR__ . '/../static/event_big.png'), null, null, null, true);
        $detailImage = new UploadedFile(__DIR__ . '/../static/detail_image.png', basename(__DIR__ . '/../static/detail_image.png'), null, null, null, true);

        $smallMedia = new Media();
        $smallMedia->setBinaryContent($smallImage);
        $smallMedia->setContext('events');
        $smallMedia->setProviderName('sonata.media.provider.image');

        $bigMedia = new Media();
        $bigMedia->setBinaryContent($bigImage);
        $bigMedia->setContext('events');
        $bigMedia->setProviderName('sonata.media.provider.image');

        $detailMedia = new Media();
        $detailMedia->setBinaryContent($detailImage);
        $detailMedia->setContext('events');
        $detailMedia->setProviderName('sonata.media.provider.image');

        for($i = 0; $i < self::COUNT_ELEMENTS; $i++) {
            $event = new Event();

            $event->setTitle($this->faker->firstName . ' ' . $this->faker->lastName);
            $event->setArtist($event->getTitle());
            $event->setSlug($event->getTitle());
            $event->setIsCanceled($this->faker->boolean(80));
            $event->setIsActive($this->faker->boolean(90));
            $event->setIsPreviewBig($this->faker->boolean(10));
            $event->setHall($halls[array_rand($halls)]);
            $event->setColor($this->faker->hexColor);
            $event->setDescription($this->faker->text(1500));
            $event->setStartedAt($this->faker->dateTimeBetween('-5 days', '+100 days'));
            $event->setCity($cities[array_rand($cities)]);
            $event->setAge($this->faker->randomDigit);
            $event->setAdditionalText($this->faker->text(100));
            $event->setDetailPicture($detailMedia);
            $event->setSocialLinks(['vk' => 'vk.com/some_event', 'facebook' => 'facebook.com/some_event']);

            $tagsRandomKeys = array_rand($tags, rand(2, 5));

            foreach ($tagsRandomKeys as $number => $tagKey) {
                $event->addTag($tags[$tagKey]);
            }

            if($event->getIsPreviewBig()) {
                $event->setBigPicture($bigMedia);
            } else {
                $event->setPicture($smallMedia);
            }

            $this->manager->persist($event);

            $this->createTicketTime($event);
        }

        $this->manager->flush();
    }

    public function createTicketTime(Event $event)
    {
        $ticketsCount = rand(1, 3);

        for($i = 0; $i < $ticketsCount; $i++) {
            $eventSchedule = new EventSchedule();

            $eventSchedule->setTickets($this->faker->url);
            $eventSchedule->setTime($this->faker->dateTimeThisMonth());
            $eventSchedule->setEvent($event);

            $this->manager->persist($eventSchedule);
        }

        $this->manager->flush();
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 50;
    }
}
