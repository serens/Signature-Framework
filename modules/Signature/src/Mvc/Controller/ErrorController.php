<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc\Controller;

/**
 * Class ErrorController
 * @package Signature\Mvc\Controller
 */
class ErrorController extends ActionController
{
    /**
     * Set a layout-template for the view.
     * @return void
     */
    protected function initView()
    {
        parent::initView();

        $this->view->setLayout($this->getTemplateDir() . 'Layouts/Default.html');
    }

    /**
     * This action is called, when no route could be matched by the router.
     * @return void
     */
    public function noRouteFoundAction()
    {
        $this->response->setStatusCode(404);
        $this->view->setViewData('originalRequestUri', $this->request->getRequestUri());
    }
}
