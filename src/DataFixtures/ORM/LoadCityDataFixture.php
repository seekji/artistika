<?php

namespace App\DataFixtures\ORM;

use App\Entity\Handbook\City;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadCityDataFixture
 * @package App\DataFixtures\ORM
 */
class LoadCityDataFixture extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    const REFERENCE_SLUG = 'app.city.id.';

    /**
     * @var ContainerInterface
     */
    private $container;

    /** @var Generator */
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
        $defaultCityExists = false;

        for($i = 1; $i < 5; $i++) {
            $city = new City();

            $isDefaultCity = $this->faker->boolean;

            $city->setIsDefault($defaultCityExists === true ? false : $isDefaultCity);
            $city->setName($this->faker->city);
            $city->setIsMain($this->faker->boolean);
            $city->setSlug($city->getName());
            $city->setSubscribeText($this->faker->text(75));
            $city->setTagText($this->faker->text(15));

            $manager->persist($city);

            $this->setReference(self::REFERENCE_SLUG . $i, $city);

            if($defaultCityExists === false) {
                $defaultCityExists = $isDefaultCity;
            }
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
        return 20;
    }
}
