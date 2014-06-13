<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc\Controller;

/**
 * Interface ControllerInterface
 * @package Signature\Mvc\Controller
 */
interface ControllerInterface
{
    /**
     * Returns true, if the supplied request can be handled by the controller.
     * @param \Signature\Mvc\RequestInterface $request
     * @return boolean
     */
    public function canHandleRequest(\Signature\Mvc\RequestInterface $request);

    /**
     * Handles the request.
     * @param \Signature\Mvc\RequestInterface  $request
     * @param \Signature\Mvc\ResponseInterface $response
     * @return void
     */
    public function handleRequest(\Signature\Mvc\RequestInterface $request, \Signature\Mvc\ResponseInterface $response);

    /**
     * Returns the module name this controller belongs to.
     * @return string
     */
    public function getModuleContext();
}
