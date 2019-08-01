<?php

namespace App\Serializer;

use App\Application\Sonata\MediaBundle\Entity\Media;
use App\Entity\Event;
use JMS\Serializer\JsonSerializationVisitor;
use Symfony\Component\Routing\Router;
use Sonata\MediaBundle\Provider\ImageProvider;
use Sonata\MediaBundle\Provider\FileProvider;

/**
 * Class EventHandler
 * @package App\Serializer
 */
class EventHandler
{
    /**
     * @var ImageProvider
     */
    private $imageProvider;

    /**
     * @var FileProvider
     */
    private $fileProvider;

    /**
     * @var Router
     */
    private $router;

    /**
     * EventHandler constructor.
     * @param ImageProvider $imageProvider
     * @param FileProvider $fileProvider
     * @param Router $router
     */
    public function __construct(ImageProvider $imageProvider, FileProvider $fileProvider, Router $router)
    {
        $this->imageProvider = $imageProvider;
        $this->fileProvider = $fileProvider;
        $this->router = $router;
    }

    public function serializeEvent(JsonSerializationVisitor $visitor, Event $event)
    {
        $ticketsCollection = $event->getTickets();
        $tickets = [];

        foreach($ticketsCollection as $key => $ticket) {
            $tickets[$key] = [
                'ticket' => $ticket->getTickets(),
                'time' => $ticket->getTime()->format('H:i'),
                'id' => $ticket->getId(),
            ];
        }

        $tagsCollection = $event->getTags();
        $tags = [];

        foreach ($tagsCollection as $key => $tag) {
            $tags[$key] = [
                'title' => $tag->getTitle(),
                'slug' => $tag->getSlug(),
                'id' => $tag->getId(),
            ];
        }

        $serialization = [
            'id' => $event->getId(),
            'is_canceled' => $event->getIsCanceled(),
            'is_active' => $event->getIsActive(),
            'is_element_big' => $event->getIsPreviewBig(),
            'started_at' => $event->getStartedAt()->format('d M'),
            'title' => $event->getTitle(),
            'slug' => $event->getSlug(),
            'artist' => $event->getArtist(),
            'hall' => $event->getHall()->getTitle(),
            'hall_address' => $event->getHall()->getAddress(),
            'tickets' => $tickets,
            'tags' => $tags,
            'city' => $event->getCity()->getName(),
            'url' => $this->router->generate('app.event.show', ['city' => $event->getCity()->getSlug(), 'event' => $event->getSlug()]),
            'description' => $event->getDescription(),
            'updated_at' => $event->getUpdatedAt()->format('d F Y'),
            'created_at' => $event->getCreatedAt()->format('d F Y'),
        ];

        if($event->getPicture() instanceof Media) {
            $serialization['picture'] = $this->serializeMedia($event->getPicture());
        }

        if($event->getBigPicture() instanceof Media) {
            $serialization['bigPicture'] = $this->serializeMedia($event->getBigPicture());
        }

        if ($visitor->getRoot() === null) {
            $visitor->setRoot($serialization);
        }

        return $serialization;
    }

    public function serializeMedia(Media $media)
    {
        switch ($media->getProviderName()) {
            case 'sonata.media.provider.file':
                $serialization = $this->serializeFile($media);
                break;

            case 'sonata.media.provider.image':
                $serialization = $this->serializeImage($media);
                break;

            default:
                throw new \RuntimeException("Serialization media provider not recognized.");
        }

        return $serialization;
    }

    private function serializeImage(Media $media)
    {
        $small = $this->imageProvider->generatePublicUrl($media, $media->getContext() . '_small');

        return [
            'name'         => $media->getName(),
            'size'         => sprintf("%.1f kB", $media->getSize() / 1000),
            'smallSrc'     => $small,
            'copyright'    => $media->getCopyright(),
            'author'       => $media->getAuthorName(),
            'description'  => $media->getDescription(),
            'src'          => $this->imageProvider->generatePublicUrl($media, 'reference'),
            'created_at'   => $media->getCreatedAt()->format('Y/m/d H:i'),
            'updated_at'   => $media->getUpdatedAt()->format('Y/m/d H:i'),
            'height'       => $media->getHeight(),
            'width'        => $media->getWidth(),
            'context'      => $media->getContext(),
            'id'           => $media->getId(),
        ];
    }

    private function serializeFile(Media $media)
    {
        return [
            'name'         => $media->getName(),
            'size'         => sprintf("%.1f kB", $media->getSize() / 1000),
            'copyright'    => $media->getCopyright(),
            'author'       => $media->getAuthorName(),
            'description'  => $media->getDescription(),
            'src'          => $this->imageProvider->generatePublicUrl($media, 'reference'),
            'created_at'   => $media->getCreatedAt()->format('Y/m/d H:i'),
            'updated_at'   => $media->getUpdatedAt()->format('Y/m/d H:i'),
            'height'       => $media->getHeight(),
            'width'        => $media->getWidth(),
            'context'      => $media->getContext(),
        ];
    }
}