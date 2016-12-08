<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc;

/**
 * Class Request
 * @package Signature\Mvc
 */
class Request implements RequestInterface
{
    /**
     * @var bool
     */
    protected $dispatched = false;

    /**
     * @var string
     */
    protected $requestUri = '';

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var string
     */
    protected $controllerName = '';

    /**
     * @var string
     */
    protected $controllerActionName = 'index';

    /**
     * @var array
     */
    protected $controllerActionParameters = [];

    /**
     * Sets the actual dispatched state of the request.
     * @param bool $dispatched
     * @return RequestInterface
     */
    public function setDispatched(bool $dispatched): RequestInterface
    {
        $this->dispatched = $dispatched;

        return $this;
    }

    /**
     * Returns the current state of the request, whether it has already been dispatched or not.
     * @return bool
     */
    public function isDispatched(): bool
    {
        return $this->dispatched == true;
    }

    /**
     * Returns the current request method.
     * @return string
     */
    public function getMethod(): string
    {
        return !empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
    }

    /**
     * Gets the original request uri.
     * @return string
     */
    public function getRequestUri(): string
    {
        return $this->requestUri;
    }

    /**
     * Sets the original request-uri.
     * @param string $requestUri
     * @return RequestInterface
     */
    public function setRequestUri(string $requestUri): RequestInterface
    {
        $this->requestUri = $requestUri;

        return $this;
    }

    /**
     * Gets the specified parameter from then request. If it not exists, null will be returned.
     * @param string $parameter
     * @return string|null
     */
    public function getParameter(string $parameter)
    {
        return $this->hasParameter($parameter) ? $this->parameters[$parameter] : null;
    }

    /**
     * Checks, if the given parameter exists in the request.
     * @param string $parameter
     * @return bool
     */
    public function hasParameter(string $parameter): bool
    {
        return array_key_exists($parameter, $this->parameters);
    }

    /**
     * Gets all parameters existing in this request.
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Sets a set of parameters to the request
     * @param array $parameters
     * @return RequestInterface
     */
    public function setParameters(array $parameters): RequestInterface
    {
        foreach ($parameters as $parameter => $value) {
            $this->setParameter($parameter, (string) $value);
        }

        return $this;
    }

    /**
     * Sets a parameter to the request. An already existing parameter will be overwritten.
     * @param string $parameter
     * @param string $value
     * @return RequestInterface
     */
    public function setParameter(string $parameter, string $value): RequestInterface
    {
        $this->parameters[$parameter] = $value;

        return $this;
    }

    /**
     * Gets the classname of the controller which is handling this request.
     * @return string
     */
    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    /**
     * Sets the classname of the controlle which is handling this request.
     * @param string $controllerName
     * @return RequestInterface
     */
    public function setControllerName(string $controllerName): RequestInterface
    {
        $this->controllerName = $controllerName;

        return $this;
    }

    /**
     * Returns the current action name of the controller.
     * @return string
     */
    public function getControllerActionName(): string
    {
        return $this->controllerActionName;
    }

    /**
     * Sets the name of the current action of the controller.
     * @param string $controllerActionName
     * @return RequestInterface
     */
    public function setControllerActionName(string $controllerActionName): RequestInterface
    {
        $this->controllerActionName = strtolower($controllerActionName);

        return $this;
    }

    /**
     * Returns the parameters which have been passed to the called action-method.
     * @return array|null
     */
    public function getControllerActionParameters()
    {
        return $this->controllerActionParameters;
    }

    /**
     * Sets the parameters which should be passed to the action-method.
     * @param array $parameters
     * @return RequestInterface
     */
    public function setControllerActionParameters(array $parameters): RequestInterface
    {
        $this->controllerActionParameters = $parameters;

        return $this;
    }

    /**
     * Returns true if current request method is POST.
     * @return bool
     */
    public function isPost(): bool
    {
        return ('POST' == $this->getMethod());
    }

    /**
     * Returns true if current request method is GET.
     * @return bool
     */
    public function isGet(): bool
    {
        return ('GET' == $this->getMethod());
    }

    /**
     * Returns true if current request method is PUT.
     * @return bool
     */
    public function isPut(): bool
    {
        return ('PUT' == $this->getMethod());
    }

    /**
     * Returns true if current request method is DELETE.
     * @return bool
     */
    public function isDelete(): bool
    {
        return ('DELETE' == $this->getMethod());
    }

    /**
     * Returns true if current request method is HEAD.
     * @return bool
     */
    public function isHead(): bool
    {
        return ('HEAD' == $this->getMethod());
    }

    /**
     * Returns true if current request method is OPTIONS.
     * @return bool
     */
    public function isOptions(): bool
    {
        return ('OPTIONS' == $this->getMethod());
    }
}
