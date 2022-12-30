<?php

namespace Signature\Mvc\Controller;

use PHPUnit\Framework\TestCase;
use Signature\Configuration\ConfigurationService;
use Signature\Module;
use Signature\Mvc\Request;
use Signature\Mvc\Response;
use Signature\Object\ObjectProviderService;

class ErrorControllerTest extends TestCase
{
    /** @var ErrorController */
    private $controller;

    protected function setUp(): void
    {
        $module = new Module();
        $configurationService = new ConfigurationService();
        $configurationService->setConfig('Signature', $module->getConfig());

        $this->controller = new ErrorController();
        $this->controller->setConfigurationService($configurationService);
        $this->controller->setObjectProviderService(ObjectProviderService::getInstance());
    }

    public function testReturns404StatusCode()
    {
        $request = new Request();
        $response = new Response();

        $request->setControllerName(get_class($this->controller));
        $request->setControllerActionName('noRouteFound');

        $this->controller->handleRequest($request, $response);

        $this->assertEquals(404, $response->getStatusCode());
    }
}
