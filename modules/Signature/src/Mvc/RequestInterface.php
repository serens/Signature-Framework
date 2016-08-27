<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc;

/**
 * Class RequestInterface
 * @package Signature\Mvc
 */
interface RequestInterface
{
    /**
     * Sets the actual dispatched state of the request.
     * @param boolean $dispatched
     * @return \Signature\Mvc\RequestInterface
     */
    public function setDispatched($dispatched);

    /**
     * Returns the current state of the request, whether it has already been dispatched or not.
     * @return boolean
     */
    public function isDispatched();

    /**
     * Checks, if the given parameter exists in the request.
     * @param string $parameter
     * @return boolean
     */
    public function hasParameter($parameter);

    /**
     * Sets a parameter to the request. An already existing parameter will be overwritten.
     * @param string $parameter
     * @param string $value
     * @return \Signature\Mvc\RequestInterface
     */
    public function setParameter($parameter, $value);

    /**
     * Gets the specified parameter from then request. If it not exists, null will be returned.
     * @param string $parameter
     * @return string|null
     */
    public function getParameter($parameter);

    /**
     * Sets a set of parameters to the request
     * @param array $parameters
     * @return \Signature\Mvc\RequestInterface
     */
    public function setParameters(array $parameters);

    /**
     * Gets all parameters existing in this request.
     * @return array
     */
    public function getParameters();

    /**
     * Sets the classname of the controlle which is handling this request.
     * @param string $controllerName
     * @return \Signature\Mvc\RequestInterface
     */
    public function setControllerName($controllerName);

    /**
     * Gets the classname of the controller which is handling this request.
     * @return string
     */
    public function getControllerName();

    /**
     * Returns the current action name of the controller.
     * @return string
     */
    public function getControllerActionName();

    /**
     * Sets the name of the current action of the controller.
     * @param string $controllerActionName
     * @return \Signature\Mvc\RequestInterface
     */
    public function setControllerActionName($controllerActionName);

    /**
     * Returns the parameters which have been passed to the called action-method.
     * @return array|null
     */
    public function getControllerActionParameters();

    /**
     * Sets the parameters which should be passed to the action-method.
     * @param array $parameters
     * @return \Signature\Mvc\RequestInterface
     */
    public function setControllerActionParameters(array $parameters);

    /**
     * Gets the original request uri.
     * @return string
     */
    public function getRequestUri();

    /**
     * Sets the original request-uri.
     * @param string $requestUri
     * @return \Signature\Mvc\Request
     */
    public function setRequestUri($requestUri);

    /**
     * Returns the current request method.
     * @return string
     */
    public function getMethod();
}
