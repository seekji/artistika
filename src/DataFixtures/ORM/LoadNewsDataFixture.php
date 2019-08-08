<?php

namespace App\DataFixtures\ORM;

use App\Application\Sonata\MediaBundle\Entity\Media;
use App\Entity\News;
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
 * Class LoadNewsDataFixture
 * @package App\DataFixtures\ORM
 */
class LoadNewsDataFixture extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    const REFERENCE_SLUG = 'app.news.id.';

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

        $image = new UploadedFile(__DIR__ . '/../static/news.png', basename(__DIR__ . '/../static/news.png'), null, null, null, true);

        $media = new Media();
        $media->setBinaryContent($image);
        $media->setContext('news');
        $media->setProviderName('sonata.media.provider.image');

        for($i = 0; $i < 20; $i++) {
            $news = new News();

            $news->setTitle($this->faker->title);
            $news->setDescription($this->faker->realText(600));
            $news->setSlug($news->getTitle());
            $news->setIsPublished($this->faker->boolean(90));
            $news->setPreviewDescription($this->faker->text(150));

            if($this->faker->boolean(70)) {
                $news->setPicture($media);
            }

            $manager->persist($news);

            $this->setReference(self::REFERENCE_SLUG . $i, $news);
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
        return 90;
    }
}
