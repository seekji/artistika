<?php

    namespace App\Controller;

    use App\Entity\Event;
    use App\Entity\EventSchedule;
    use App\Entity\Handbook\City;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
    use Symfony\Component\HttpFoundation\ResponseHeaderBag;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;

    /**
     * Class EventController
     * @package App\Controller
     * @Route("/event")
     */
    class EventController extends AbstractController
    {
        /**
         * @param Event $event
         * @param City $city
         *
         * @Route("/{city}/{event}/", name="app.event.show")
         *
         * @ParamConverter("city", options={"mapping": {"city": "slug"}})
         * @ParamConverter("event", options={"mapping": {"event": "slug"}})
         *
         * @return Response
         */
        public function show(City $city, Event $event)
        {
            return $this->render('event/index.html.twig', ['event' => $event]);
        }

        /**
         * @Route("/calendar/{event_id}/{schedule_id}/")
         *
         * @param Event $event
         * @param EventSchedule $eventSchedule
         *
         * @ParamConverter("event", options={"mapping": {"event_id": "id"}})
         * @ParamConverter("eventSchedule", options={"mapping": {"schedule_id": "id"}})
         *
         * @return Response
         */
        public function calendar(Event $event, EventSchedule $eventSchedule)
        {
            $filename = 'event.ics';
            $eventStartDate = date('Ymd\THis', strtotime($event->getStartedAt()->format('Ymd\T') . $eventSchedule->getTime()->format('Hi')));

            $content = $this->renderView('event/__ics.html.twig', [
                'event' => $event,
                'currentDate' => date('Ymd\THis'),
                'eventStartDate' => $eventStartDate,
                'uniqid' => uniqid()
            ]);

            $response = new Response($content);
            $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);

            $response->headers->set('Content-Disposition', $disposition);
            $response->headers->set('Content-type', 'text/plain');

            return $response;
        }
    }
