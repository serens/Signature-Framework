<?php

namespace Signature\Object;

use PHPUnit\Framework\TestCase;
use Signature\Configuration\ConfigurationService;
use Signature\Mvc\Routing\LinkBuilder;

class ObjectProviderServiceTest extends TestCase
{
    /** @var ObjectProviderService */
    private $service;

    protected function setUp(): void
    {
        $this->service = ObjectProviderService::getInstance();
    }

    public function testChainability()
    {
        $this->assertInstanceOf(
            ObjectProviderService::class,
            $this->service->register('test', \DateTime::class)
        );
    }

    public function testSettingAndGettingRegisteredObjects()
    {
        $this->service->register('someobject', \DateTime::class);

        $this->assertInstanceOf(
            \DateTime::class,
            $this->service->get('someobject')
        );
    }

    public function testGettingNotRegisteredObjects()
    {
        $this->assertInstanceOf(
            \DateTime::class,
            $this->service->get(\DateTime::class)
        );
    }

    public function testDependencyInjection()
    {
        $this->service->register('ConfigurationService', ConfigurationService::class);

        /** @var LinkBuilder $linkBuilder */
        $linkBuilder = $this->service->get(LinkBuilder::class);

        $reflection = new \ReflectionClass($linkBuilder);
        $property = $reflection->getProperty('configurationService');

        $this->assertInstanceOf(ConfigurationService::class, $property->getValue($linkBuilder));
    }
}