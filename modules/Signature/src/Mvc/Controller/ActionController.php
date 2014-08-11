<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc\Controller;

use \Signature\Mvc\RequestInterface;
use \Signature\Mvc\ResponseInterface;

/**
 * Class ActionController
 * @package Signature\Mvc\Controller
 */
class ActionController extends AbstractController
{
    use \Signature\Object\ObjectProviderServiceTrait;
    use \Signature\Configuration\ConfigurationServiceTrait;

    /**
     * @var \Signature\Mvc\View\ViewInterface
     */
    protected $view = null;

    /**
     * Starts handling the request. Will call initAction() before any other action will be called.
     * @param \Signature\Mvc\RequestInterface  $request
     * @param \Signature\Mvc\ResponseInterface $response
     * @throws \Signature\Mvc\Exception\ActionNotFoundException
     * @return void
     */
    public function handleRequest(RequestInterface $request, ResponseInterface $response)
    {
        parent::handleRequest($request, $response);

        $this->initAction();
        $this->initView();

        if (method_exists($this, $initAction = 'init' . ucfirst($this->request->getControllerActionName()) . 'Action')) {
            $this->$initAction();
        }

        if (!method_exists($this, $actionName = $this->request->getControllerActionName() . 'Action')) {
            throw new \Signature\Mvc\Exception\ActionNotFoundException(sprintf(
                'Controller "%s" does not have an action called "%s".',
                $this->request->getControllerName(),
                $this->request->getControllerActionName()
            ));
        }

        // Prepare and execute the action which has been called.
        $actionResult = call_user_func_array(array($this, $actionName), $request->getControllerActionParameters());

        if (null === $actionResult && $this->view instanceof \Signature\Mvc\View\ViewInterface) {
            if ('' === $this->view->getTemplate()) {
                $this->view->setTemplate($this->resolveViewTemplateName());
            }

            $this->response->appendContent($this->view->render());
        } elseif ($actionResult !== '') {
            $this->response->appendContent($actionResult);
        }
    }

    /**
     * Will be called before regular action.
     * @return void
     */
    protected function initAction()
    {
    }

    /**
     * Returns the view-object for this controller/action.
     * @throws \UnexpectedValueException
     * @return void
     */
    protected function initView()
    {
        $view = $this->objectProviderService->create($this->resolveViewClassName());

        if (!$view instanceof \Signature\Mvc\View\ViewInterface) {
            throw new \UnexpectedValueException(
                'View "' . get_class($view) . '" does not implement Signature\Mvc\View\ViewInterface.'
            );
        }

        $this->view = $view;
        $this->view->setTemplate($this->resolveViewTemplateName());

        // Assign basic view data
        $this->view->setViewData([
            'moduleContext' => $this->getModuleContext(),
            'config'        => $this->configurationService->getConfig($this->getModuleContext()),
            'resourceDir'   => $this->getResourceDir(),
            'templateDir'   => $this->getTemplateDir(),
        ]);
    }

    /**
     * Returns the path to the resources of the current module.
     * @return string
     */
    protected function getResourceDir()
    {
        return \Signature\Core\AutoloaderInterface::MODULES_PATHNAME . '/' . $this->getModuleContext() . '/res/';
    }

    /**
     * Returns the path to the templates of the current module.
     * @return string
     */
    protected function getTemplateDir()
    {
        return \Signature\Core\AutoloaderInterface::MODULES_PATHNAME . '/' . $this->getModuleContext() . '/tpl/';
    }

    /**
     * Returns the classname of a view implementation.
     * @return string
     */
    protected function resolveViewClassName()
    {
        return $this->configurationService->getConfigByPath('Signature', 'Mvc.View.DefaultViewClassname');
    }

    /**
     * Returns a view template name based on the current controller and action.
     * @return string
     */
    protected function resolveViewTemplateName()
    {
        $controllerName      = ltrim($this->request->getControllerName(), '\\');
        $namespaceParts      = explode('\\', $controllerName);
        $controllerClassName = array_pop($namespaceParts);

        // Get rid of module name
        array_shift($namespaceParts);

        if (strtolower($namespaceParts[0]) == 'mvc') {
            array_shift($namespaceParts);
        }

        if (strtolower($namespaceParts[0]) == 'controller') {
            array_shift($namespaceParts);
        }

        $controllerClassName = str_replace('Controller', '', $controllerClassName);

        return
            $this->getTemplateDir() . implode(DIRECTORY_SEPARATOR, [
                'Templates',
                implode('\\', $namespaceParts),
                ucfirst($controllerClassName),
                ucfirst($this->request->getControllerActionName())
            ]) . '.html';
    }
}
