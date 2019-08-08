<?php

    namespace App\DataFixtures\ORM;

    use Doctrine\Common\DataFixtures\AbstractFixture;
    use Doctrine\Common\DataFixtures\FixtureInterface;
    use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
    use Doctrine\Common\Persistence\ObjectManager;
    use App\Application\Sonata\ClassificationBundle\Entity\Context;
    use App\Application\Sonata\ClassificationBundle\Entity\Category;

    /**
     * Class LoadContextDataFixture
     * @package App\DataFixtures\ORM
     */
    class LoadContextDataFixture extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
    {
        private $contexts = [
            'default',
            'events',
            'news',
            'static_pages',
            'slider',
        ];

        /**
         * Load data fixtures with the passed EntityManager.
         *
         * @param ObjectManager $manager
         */
        public function load(ObjectManager $manager)
        {
            foreach ($this->contexts as $contextName) {
                $context = new Context();
                $context->setId($contextName);
                $context->setName($contextName);
                $context->setEnabled(true);
                $manager->persist($context);

                $category = new Category();
                $category->setName($contextName);
                $category->setContext($context);
                $category->setEnabled(true);
                $manager->persist($category);
            }

            $manager->flush();
            $manager->clear();
        }

        /**
         * Get the order of this fixture.
         *
         * @return int
         */
        public function getOrder()
        {
            return 10;
        }
    }
