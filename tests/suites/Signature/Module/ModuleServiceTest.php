<?php

namespace Signature\Module;

use PHPUnit\Framework\TestCase;
use Signature\Module;

class ModuleServiceTest extends TestCase
{
    /** @var ModuleService */
    private $service;

    protected function setUp(): void
    {
        $this->service = new ModuleService();
    }

    public function testChainability()
    {
        $this->assertInstanceOf(
            ModuleService::class,
            $this->service->registerModule('module', new Module())
        );
    }

    public function testRegisteringModules()
    {
        $this->service->registerModule('module1', new Module());
        $this->assertCount(1, $this->service->getRegisteredModules());

        $this->service->registerModule('module2', new Module());
        $this->assertCount(2, $this->service->getRegisteredModules());

        // Registering a module with the same identifier overwrites the existing module
        $this->service->registerModule('module2', new Module());
        $this->assertCount(2, $this->service->getRegisteredModules());
    }

    public function testGettingAModule()
    {
        $this->service->registerModule('module', new Module());
        $this->assertInstanceOf(ModuleInterface::class, $this->service->getModule('module'));

        $this->expectException(\OutOfBoundsException::class);
        $this->service->getModule('test2');
    }

    public function testGettingAnInvalidModule()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->service->getModule('unknownmodule');
    }
}