<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc;

/**
 * Class Dispatcher
 * @package Signature\Mvc
 */
class Dispatcher
{
    use \Signature\Object\ObjectProviderServiceTrait;

    /**
     * @var integer
     */
    const DISPATCH_ITERATION_LIMIT = 50;

    /**
     * Handles the given request.
     * @param \Signature\Mvc\Request  $request
     * @param \Signature\Mvc\Response $response
     * @throws \RuntimeException
     * @throws \UnexpectedValueException
     * @return void
     */
    public function dispatch(Request $request, Response $response)
    {
        $dispatchIterationCount = 0;

        while (!$request->isDispatched()) {
            if ($dispatchIterationCount++ > self::DISPATCH_ITERATION_LIMIT) {
                throw new \RuntimeException (sprintf(
                    'The request took more than %d iterations to dispatch. Giving up.',
                    self::DISPATCH_ITERATION_LIMIT
                ));
            }

            $controllerName = $request->getControllerName();
            $controller = $this->objectProviderService->create($controllerName);

            if (!$controller instanceof \Signature\Mvc\Controller\ControllerInterface) {
                throw new \UnexpectedValueException(
                    'Invalid controller. Controller "' . $controllerName . '" must implement \Signature\Mvc\Controller\ControllerInterface.'
                );
            }

            $controller->handleRequest($request, $response);
        }
    }
}
