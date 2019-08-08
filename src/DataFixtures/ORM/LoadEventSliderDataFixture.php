<?php

namespace App\DataFixtures\ORM;

use App\Application\Sonata\MediaBundle\Entity\Media;
use App\Entity\Event;
use App\Entity\EventSlider;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class LoadEventSliderDataFixture
 * @package App\DataFixtures\ORM
 */
class LoadEventSliderDataFixture extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    const REFERENCE_SLUG = 'app.slide.id.';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Generator;
     */
    private $faker;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        $events = $manager->getRepository(Event::class)->findBy([], [], 3);

        $image = new UploadedFile(__DIR__ . '/../static/slide.png', basename(__DIR__ . '/../static/slide.png'), null, null, null, true);

        $media = new Media();
        $media->setBinaryContent($image);
        $media->setContext('slider');
        $media->setProviderName('sonata.media.provider.image');

        for($i = 0; $i < 3; $i++) {
            $slide = new EventSlider();

            $slide->setTitle($this->faker->title);
            $slide->setPicture($media);
            $slide->setIsActive(true);
            $slide->setSort(rand(0, 50));
            $slide->setEvent($events[array_rand($events)]);

            $manager->persist($slide);

            $this->setReference(self::REFERENCE_SLUG . $i, $slide);
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 80;
    }
}
