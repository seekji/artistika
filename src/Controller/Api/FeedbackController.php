<?php

namespace App\Controller\Api;

use App\Form\Type\FeedbackForm;
use App\Log\FeedbackLogger;
use App\Service\SettingsService;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swift_Mailer;

/**
 * Class FormController
 * @package App\Controller\Api
 * @Route("/api/feedback")
 */
class FeedbackController extends AbstractFOSRestController
{
    /**
     * @var SettingsService
     */
    private $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * @Rest\Post("/send/", name="api.feedback.add")
     *
     * @param Request $request
     *
     * @param Swift_Mailer $mailer
     * @param FeedbackLogger $logger
     * @return JsonResponse
     */
    public function send(Request $request, Swift_Mailer $mailer, FeedbackLogger $logger)
    {
        $form = $this->createForm(FeedbackForm::class);
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

        try {
            $emailTo = $this->settingsService->getValue('email_send_to');
            $emailFrom = $this->settingsService->getValue('email_send_from');

            $message = (new \Swift_Message('Artistika.show: новое сообщение с формы обратной связи.'))
                ->setFrom($emailFrom)
                ->setTo($emailTo)
                ->setBody(
                    $this->renderView(
                        'emails/feedback.html.twig',
                        ['data' => $form->getData()]
                    ),
                    'text/html'
                )
            ;

            $mailer->send($message);
        } catch(\Exception $exception) {
            $logger->log(LogLevel::INFO, sprintf('Sending mail failed, exception message: %s', $exception->getMessage()));
        }

        $logger->log(LogLevel::INFO, 'submitted data: ' . serialize($form->getData()));

        return new JsonResponse([ 'status' => 'success' ], JsonResponse::HTTP_CREATED);
    }
}
