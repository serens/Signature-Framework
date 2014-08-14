<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc\Controller;

/**
 * Class AboutConfigController
 * @package Signature\Mvc\Controller
 */
class AboutConfigController extends \Signature\Mvc\Controller\ActionController
{
    use \Signature\Module\ModuleServiceTrait;

    /**
     * Assigns variables to the view.
     * @return void
     */
    public function indexAction()
    {
        $this->view->setViewData([
            'routes'        => $this->getRoutingInformation(),
            'activemodules' => $this->getActiveModules(),
            'persistence'   => $this->getPersistenceInformation(),
        ]);
    }

    /**
     * Gets information about the current routing configuration.
     * @return array
     */
    protected function getRoutingInformation()
    {
        return $this->configurationService->getConfigByPath('Signature', 'Mvc.Routing.Matcher');
    }

    /**
     * Returns an array of active modules.
     * @return array
     */
    protected function getActiveModules()
    {
        return $this->moduleService->getRegisteredModules();
    }

    /**
     * Returns information about the current persistence settings.
     * @return array
     */
    protected function getPersistenceInformation()
    {
        return $this->configurationService->getConfigByPath('Signature', 'Service.Persistence');
    }

    /**
     * Set a layout-template for the view.
     * @return void
     */
    protected function initView()
    {
        parent::initView();

        $this->view->setLayout($this->getTemplateDir() . 'Layouts/Default.html');
    }
}
