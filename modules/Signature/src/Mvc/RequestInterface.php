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
     * @param bool $dispatched
     * @return RequestInterface
     */
    public function setDispatched(bool $dispatched): RequestInterface;

    /**
     * Returns the current state of the request, whether it has already been dispatched or not.
     * @return bool
     */
    public function isDispatched(): bool;

    /**
     * Checks, if the given parameter exists in the request.
     * @param string $parameter
     * @return bool
     */
    public function hasParameter(string $parameter): bool;

    /**
     * Sets a parameter to the request. An already existing parameter will be overwritten.
     * @param string $parameter
     * @param mixed $value
     * @return RequestInterface
     */
    public function setParameter(string $parameter, $value): RequestInterface;

    /**
     * Gets the specified parameter from then request. If it not exists, null will be returned.
     * @param string $parameter
     * @return mixed|null
     */
    public function getParameter(string $parameter);

    /**
     * Sets a set of parameters to the request
     * @param array $parameters
     * @return RequestInterface
     */
    public function setParameters(array $parameters): RequestInterface;

    /**
     * Gets all parameters existing in this request.
     * @return array
     */
    public function getParameters(): array;

    /**
     * Sets the classname of the controlle which is handling this request.
     * @param string $controllerName
     * @return RequestInterface
     */
    public function setControllerName(string $controllerName): RequestInterface;

    /**
     * Gets the classname of the controller which is handling this request.
     * @return string
     */
    public function getControllerName(): string;

    /**
     * Returns the current action name of the controller.
     * @return string
     */
    public function getControllerActionName(): string;

    /**
     * Sets the name of the current action of the controller.
     * @param string $controllerActionName
     * @return RequestInterface
     */
    public function setControllerActionName(string $controllerActionName): RequestInterface;

    /**
     * Returns the parameters which have been passed to the called action-method.
     * @return array|null
     */
    public function getControllerActionParameters();

    /**
     * Sets the parameters which should be passed to the action-method.
     * @param array $parameters
     * @return RequestInterface
     */
    public function setControllerActionParameters(array $parameters): RequestInterface;

    /**
     * Gets the original request uri.
     * @return string
     */
    public function getRequestUri(): string;

    /**
     * Sets the original request-uri.
     * @param string $requestUri
     * @return RequestInterface
     */
    public function setRequestUri(string $requestUri): RequestInterface;

    /**
     * Returns the current request method.
     * @return string
     */
    public function getMethod(): string;
}
