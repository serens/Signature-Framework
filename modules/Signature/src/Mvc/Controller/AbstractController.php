<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc\Controller;

use Signature\Mvc\RequestInterface;
use Signature\Mvc\ResponseInterface;

/**
 * Class AbstractController
 * @package Signature\Mvc\Controller
 */
abstract class AbstractController implements ControllerInterface
{
    /**
     * @var \Signature\Mvc\Request
     */
    protected $request;

    /**
     * @var \Signature\Mvc\Response
     */
    protected $response;

    /**
     * @var string
     */
    protected $moduleContext = null;

    /**
     * Returns true, if the supplied request can be handled by the controller.
     * @param \Signature\Mvc\RequestInterface $request
     * @return boolean
     */
    public function canHandleRequest(RequestInterface $request)
    {
        return true;
    }

    /**
     * Handles the request.
     * @param \Signature\Mvc\RequestInterface  $request
     * @param \Signature\Mvc\ResponseInterface $response
     * @return void
     */
    public function handleRequest(RequestInterface $request, ResponseInterface $response)
    {
        $this->request  = $request;
        $this->response = $response;

        $this->request->setDispatched(true);
    }

    /**
     * Returns the module name this controller belongs to.
     *
     * Via convention the first part of a namespaced class if also the modules name.
     * @return string
     */
    public function getModuleContext()
    {
        if (null === $this->moduleContext) {
            $parts = explode('\\', get_class($this));
            $this->moduleContext = array_shift($parts);
        }

        return $this->moduleContext;
    }

    /**
     * Forwards to another action or controller.
     * @param string $actionName
     * @param string $controllerName
     * @param array  $parameters
     * @throws \Signature\Mvc\Exception\ForwardedRequestException
     * @return void
     */
    public function forward($actionName, $controllerName = null, array $parameters = null)
    {
        $this->request->setDispatched(false);
        $this->request->setControllerActionName($actionName);

        if (null !== $controllerName) {
            $this->request->setControllerName($controllerName);
        }

        if (is_array($parameters)) {
            $this->request->setParameters($parameters);
        }

        // Stop this dispatch-cycle by throwing an exception
        throw new \Signature\Mvc\Exception\ForwardedRequestException();
    }

    /**
     * Redirects to another uri by setting new header-information to the response.
     * @param string $uri
     * @param integer $statusCode
     * @throws \Signature\Mvc\Exception\RedirectedRequestException
     * @return void
     */
    public function redirect($uri, $statusCode = 302)
    {
        $this->response
            ->setContent('')
            ->setStatusCode($statusCode)
            ->addToHeader('Location', $uri);

        // Stop this dispatch-cycle by throwing an exception
        throw new \Signature\Mvc\Exception\RedirectedRequestException();
    }
}
