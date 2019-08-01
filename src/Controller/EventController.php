<?php

    namespace App\Controller;

    use App\Entity\Event;
    use App\Entity\Handbook\City;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
    }
