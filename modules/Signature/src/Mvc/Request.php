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
     * @var boolean
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
     * @param boolean $dispatched
     * @return \Signature\Mvc\RequestInterface
     */
    public function setDispatched($dispatched)
    {
        $this->dispatched = (bool) $dispatched;

        return $this;
    }

    /**
     * Returns the current state of the request, whether it has already been dispatched or not.
     * @return boolean
     */
    public function isDispatched()
    {
        return $this->dispatched === true;
    }

    /**
     * Returns the current request method.
     * @return string
     */
    public function getMethod()
    {
        return !empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
    }

    /**
     * Gets the original request uri.
     * @return string
     */
    public function getRequestUri()
    {
        return $this->requestUri;
    }

    /**
     * Sets the original request-uri.
     * @param string $requestUri
     * @return \Signature\Mvc\Request
     */
    public function setRequestUri($requestUri)
    {
        $this->requestUri = (string) $requestUri;

        return $this;
    }

    /**
     * Gets the specified parameter from then request. If it not exists, null will be returned.
     * @param string $parameter
     * @return string|null
     */
    public function getParameter($parameter)
    {
        return $this->hasParameter((string) $parameter) ? $this->parameters[(string) $parameter] : null;
    }

    /**
     * Checks, if the given parameter exists in the request.
     * @param string $parameter
     * @return boolean
     */
    public function hasParameter($parameter)
    {
        return array_key_exists((string) $parameter, $this->parameters);
    }

    /**
     * Gets all parameters existing in this request.
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Sets a set of parameters to the request
     * @param array $parameters
     * @return \Signature\Mvc\RequestInterface
     */
    public function setParameters(array $parameters)
    {
        foreach ($parameters as $parameter => $value) {
            $this->setParameter($parameter, $value);
        }

        return $this;
    }

    /**
     * Sets a parameter to the request. An already existing parameter will be overwritten.
     * @param string $parameter
     * @param mixed $value
     * @return \Signature\Mvc\RequestInterface
     */
    public function setParameter($parameter, $value)
    {
        $this->parameters[(string) $parameter] = $value;

        return $this;
    }

    /**
     * Gets the classname of the controller which is handling this request.
     * @return string
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * Sets the classname of the controlle which is handling this request.
     * @param string $controllerName
     * @return \Signature\Mvc\RequestInterface
     */
    public function setControllerName($controllerName)
    {
        $this->controllerName = (string) $controllerName;

        return $this;
    }

    /**
     * Returns the current action name of the controller.
     * @return string
     */
    public function getControllerActionName()
    {
        return $this->controllerActionName;
    }

    /**
     * Sets the name of the current action of the controller.
     * @param string $controllerActionName
     * @return \Signature\Mvc\RequestInterface
     */
    public function setControllerActionName($controllerActionName)
    {
        $this->controllerActionName = strtolower((string) $controllerActionName);

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
     * @return \Signature\Mvc\RequestInterface
     */
    public function setControllerActionParameters(array $parameters)
    {
        $this->controllerActionParameters = $parameters;

        return $this;
    }

    /**
     * Returns true if current request method is POST.
     * @return boolean
     */
    public function isPost()
    {
        return ('POST' == $this->getMethod());
    }

    /**
     * Returns true if current request method is GET.
     * @return boolean
     */
    public function isGet()
    {
        return ('GET' == $this->getMethod());
    }

    /**
     * Returns true if current request method is PUT.
     * @return boolean
     */
    public function isPut()
    {
        return ('PUT' == $this->getMethod());
    }

    /**
     * Returns true if current request method is DELETE.
     * @return boolean
     */
    public function isDelete()
    {
        return ('DELETE' == $this->getMethod());
    }

    /**
     * Returns true if current request method is HEAD.
     * @return boolean
     */
    public function isHead()
    {
        return ('HEAD' == $this->getMethod());
    }

    /**
     * Returns true if current request method is OPTIONS.
     * @return boolean
     */
    public function isOptions()
    {
        return ('OPTIONS' == $this->getMethod());
    }
}
