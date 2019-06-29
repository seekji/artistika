<?php

namespace App\DataFixtures\ORM;

use App\Application\Sonata\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadAdminData.
 * Project symfony-next.
 *
 * @author Anton Prokhorov
 */
class LoadAdminDataFixture extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
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
        $admin = static::getFakeAdmin();
        $manager->persist($admin);

        $moderator = static::getFakeModerator();
        $manager->persist($moderator);

        $manager->flush();
    }

    public static function getFakeAdmin()
    {
        $admin = new User();
        $admin->setEmail('admin@symfony.com');
        $admin->setUsername('admin');
        $admin->setPlainPassword('admin');
        $admin->setEnabled(true);
        $admin->setSuperAdmin(true);

        return $admin;
    }

    public static function getFakeModerator()
    {
        $moderator = (new User())
            ->setEmail('moderator@symfony.com')
            ->setUsername('moderator')
            ->setPlainPassword('moderator')
            ->setEnabled(true)
            ->setRoles([
                'ROLE_ADMIN',
            ]);

        return $moderator;
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 0;
    }
}
