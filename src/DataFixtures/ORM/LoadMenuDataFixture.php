<?php

namespace App\DataFixtures\ORM;

use App\Entity\Menu;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadMenuDataFixture
 * @package App\DataFixtures\ORM
 */
class LoadMenuDataFixture extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    const REFERENCE_SLUG = 'app.menu.id.';

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

        for($i = 0; $i < 5; $i++) {
            $menu = new Menu();

            $menu->setTitle($this->faker->text(7));
            $menu->setSort($this->faker->randomDigit);
            $menu->setIsActive(true);
            $menu->setLink($this->faker->url);

            $manager->persist($menu);

            $this->setReference(self::REFERENCE_SLUG . $i, $menu);
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
        return 70;
    }
}
