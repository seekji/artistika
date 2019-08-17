<?php

namespace App\EventListener;

use App\Entity\Event;
use App\Entity\Handbook\City;
use App\Entity\News;
use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

/**
 * Class SitemapSubscriber
 * @package App\EventListener
 */
class SitemapSubscriber implements EventSubscriberInterface
{

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, EntityManagerInterface $entityManager)
    {
        $this->urlGenerator = $urlGenerator;
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            SitemapPopulateEvent::ON_SITEMAP_POPULATE => 'populate',
        ];
    }

    /**
     * @param SitemapPopulateEvent $event
     */
    public function populate(SitemapPopulateEvent $event): void
    {
        $this->registerEventUrls($event->getUrlContainer());
        $this->registerNewsUrls($event->getUrlContainer());
        $this->registerCityUrls($event->getUrlContainer());
        $this->registerPageUrls($event->getUrlContainer());
    }

    /**
     * @param UrlContainerInterface $urls
     */
    public function registerEventUrls(UrlContainerInterface $urls): void
    {
        $events = $this->entityManager->getRepository(Event::class)->findBy([]);

        foreach($events as $event) {
            $urls->addUrl(
                new UrlConcrete(
                    $this->urlGenerator->generate(
                        'app.event.show',
                        ['event' => $event->getSlug(), 'city' => $event->getCity()->getSlug()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'events'
            );
        }

        $events = null;
    }

    /**
     * @param UrlContainerInterface $urls
     */
    public function registerNewsUrls(UrlContainerInterface $urls): void
    {
        $news = $this->entityManager->getRepository(News::class)->findBy(['isPublished' => true]);

        foreach($news as $post) {
            $urls->addUrl(
                new UrlConcrete(
                    $this->urlGenerator->generate(
                        'app.news.show',
                        ['slug' => $post->getSlug()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'news'
            );
        }

        $news = null;
    }

    /**
     * @param UrlContainerInterface $urls
     */
    public function registerCityUrls(UrlContainerInterface $urls): void
    {
        $cities = $this->entityManager->getRepository(City::class)->findAll();

        foreach($cities as $city) {
            $urls->addUrl(
                new UrlConcrete(
                    $this->urlGenerator->generate(
                        'app.city',
                        ['slug' => $city->getSlug()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'cities'
            );

            $urls->addUrl(
                new UrlConcrete(
                    $this->urlGenerator->generate(
                        'app.archive.city',
                        ['slug' => $city->getSlug()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'archive'
            );
        }

        $cities = null;
    }

    /**
     * @param UrlContainerInterface $urls
     */
    public function registerPageUrls(UrlContainerInterface $urls): void
    {
        $pages = $this->entityManager->getRepository(Page::class)->findBy(['isPublished' => true]);

        foreach($pages as $page) {
            $urls->addUrl(
                new UrlConcrete(
                    $this->urlGenerator->generate(
                        'app.page.show',
                        ['slug' => $page->getSlug()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'pages'
            );
        }

        $pages = null;
    }
}