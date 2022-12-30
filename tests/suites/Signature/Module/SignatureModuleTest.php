<?php

namespace Signature\Module;

use PHPUnit\Framework\TestCase;
use Signature\Configuration\ConfigurationService;
use Signature\Module;

class SignatureModuleTest extends TestCase
{
    public function testSignatureModuleHasDefaultConfiguration()
    {
        $module = 'Signature';
        $service = new ConfigurationService();
        $service->setConfig($module, (new Module())->getConfig());

        $this->assertIsArray($service->getConfigByPath($module, 'Service'));
        $this->assertIsArray($service->getConfigByPath($module, 'Mvc.Controller'));
        $this->assertIsArray($service->getConfigByPath($module, 'Mvc.Controller.NoRouteFoundHandling'));
        $this->assertIsArray($service->getConfigByPath($module, 'Mvc.View'));
        $this->assertIsArray($service->getConfigByPath($module, 'Mvc.Routing'));
    }

    public function testSignatureModuleHasWritePermissionsInCacheDirectory()
    {
        $this->assertDirectoryIsWritable(__DIR__ . '/../../../../cache');
    }
}