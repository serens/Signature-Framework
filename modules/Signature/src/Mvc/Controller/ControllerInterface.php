<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc\Controller;

use Signature\Mvc\RequestInterface;
use Signature\Mvc\ResponseInterface;

/**
 * Interface ControllerInterface
 * @package Signature\Mvc\Controller
 */
interface ControllerInterface
{
    /**
     * Returns true, if the supplied request can be handled by the controller.
     * @param RequestInterface $request
     * @return bool
     */
    public function canHandleRequest(RequestInterface $request): bool;

    /**
     * Handles the request.
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return void
     */
    public function handleRequest(RequestInterface $request, ResponseInterface $response);

    /**
     * Returns the module name this controller belongs to.
     * @return string
     */
    public function getModuleContext(): string;
}
