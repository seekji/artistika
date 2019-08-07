<?php

    namespace App\Controller\Api;

    use App\Entity\Subscribe;
    use App\Form\Type\SubscribeForm;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use FOS\RestBundle\Controller\AbstractFOSRestController;
    use FOS\RestBundle\Controller\Annotations as Rest;
    use Symfony\Component\HttpFoundation\JsonResponse;

    /**
     * Class SubscribeController
     * @package App\Controller\Api
     * @Route("/api/subscribe")
     */
    class SubscribeController extends AbstractFOSRestController
    {
        /**
         * @var EntityManagerInterface
         */
        private $entityManager;

        public function __construct(EntityManagerInterface $entityManager)
        {
            $this->entityManager = $entityManager;
        }

        /**
         * @Rest\Post("/add", name="api.subscribe.add")
         *
         * @param Request $request
         *
         * @return \Symfony\Component\HttpFoundation\JsonResponse
         */
        public function add(Request $request)
        {
            $subscribe = new Subscribe();

            $form = $this->createForm(SubscribeForm::class, $subscribe);
            $form->submit($request->request->all());

            if (false === $form->isValid()) {
                $errors = [];

                foreach ($form->getErrors(true) as $error) {
                    $errors[] = $error->getMessage();
                }

                return new JsonResponse(
                    [
                        'status' => 'error',
                        'errors' => $errors,
                    ], JsonResponse::HTTP_BAD_REQUEST
                );
            }

            $this->entityManager->persist($form->getData());
            $this->entityManager->flush();

            return new JsonResponse([ 'status' => 'success' ], JsonResponse::HTTP_CREATED);
        }
    }
