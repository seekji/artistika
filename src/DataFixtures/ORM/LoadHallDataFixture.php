<?php

namespace App\DataFixtures\ORM;

use App\Entity\Handbook\Hall;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadHallDataFixture
 * @package App\DataFixtures\ORM
 */
class LoadHallDataFixture extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    const REFERENCE_SLUG = 'app.hall.id.';

    /**
     * @var ContainerInterface
     */
    private $container;

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
        for($i = 1; $i < 10; $i++) {
            $hall = new Hall();

            $hall->setTitle('Тег номер - ' . $i);
            $hall->setAddress('Адрес йоло, ' . $i);
            $hall->setPhone('+7(911)000-00-0' . $i);

            $manager->persist($hall);

            $this->setReference(self::REFERENCE_SLUG . $i, $hall);
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
