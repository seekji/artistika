<?php

namespace App\Controller\Api;

use App\Service\EventService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializerInterface;

/**
 * Class EventController
 * @package App\Controller\Api
 * @Rest\Route("/api/event")
 */
class EventController extends AbstractFOSRestController
{
    /**
     * @var EventService $eventService
     */
    protected $eventService;

    /**
     * @var SerializerInterface $serializer
     */
    protected $serializer;

    /**
     * EventController constructor.
     * @param EventService $eventService
     * @param SerializerInterface $serializer
     */
    public function __construct(EventService $eventService, SerializerInterface $serializer)
    {
        $this->eventService = $eventService;
        $this->serializer   = $serializer;
    }

    /**
     * @Rest\Route("/list/", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function events(Request $request)
    {
        $offset = (int) $request->get('offset', 0);
        $limit  = (int) $request->get('limit', 20);
        $tags   = (array) $request->get('tags', []);
        $city   = $request->get('city', null);

        $events = $this->eventService->getEventsByFilter($offset, $limit, $tags, $city);
        $eventsCount = $this->eventService->getEventsCountByFilter($tags, $city);

        $json = $this->serializer->serialize([ 'events' => $this->renderView('event/__events_list.html.twig', ['events' => $events]), 'limit' => $limit, 'offset' => $offset, 'total' => $eventsCount, 'is_done' => ($offset + count($events) >= $eventsCount)], 'json');

        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }
}