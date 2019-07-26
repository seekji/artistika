<?php

namespace App\Admin\Controller;

use App\Form\Type\SettingsForm;
use App\Service\SettingsService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sonata\AdminBundle\Admin\Pool;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class SiteController
 * @package App\Admin\Controller
 * @Route("/admin/site/settings")
 */
class SiteController extends AbstractController
{
    const SETTINGS_YAML_PATH = '/../config/settings.yaml';

    /**
     * @var Pool $sonataPool
     */
    protected $sonataPool;

    /**
     * @var SettingsService $settingsService
     */
    protected $settingsService;

    /**
     * SiteController constructor.
     * @param Pool $pool
     * @param SettingsService $settingsService
     */
    public function __construct(Pool $pool, SettingsService $settingsService)
    {
        $this->sonataPool = $pool;
        $this->settingsService = $settingsService;
    }

    /**
     * @Route("/edit", name="admin.site.settings.edit")
     * @Template("admin/site/settings/edit.html.twig")
     *
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function edit(Request $request)
    {
        $formValues = $this->settingsService->getValues();
        $form       = $this->createForm(SettingsForm::class, $formValues);

        if ($request->getMethod() === Request::METHOD_POST) {
            $form->handleRequest($request);
            $this->settingsService->saveValues($form->getData());

            return $this->redirectToRoute('admin.site.settings.edit');
        }

        return [
            'admin_pool' => $this->sonataPool,
            'base_template' => $this->getParameter('sonata.admin.configuration.templates')['layout'],
            'edit_template' => $this->getParameter('sonata.admin.configuration.templates')['edit'],
            'form' => $form->createView(),
        ];
    }
}