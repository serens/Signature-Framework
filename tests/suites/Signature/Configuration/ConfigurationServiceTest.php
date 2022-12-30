<?php

namespace Signature\Configuration;

use PHPUnit\Framework\TestCase;

class ConfigurationServiceTest extends TestCase
{
    /** @var ConfigurationService */
    private $service;

    private const MODULENAME = 'Signature';

    protected function setUp(): void
    {
        $this->service = new ConfigurationService();
    }

    public function testSettingAndGettingASimpleConfiguration()
    {
        $config = [
            'value1' => true,
            'value2' => false,
        ];

        $this->assertInstanceOf(ConfigurationServiceInterface::class, $this->service->setConfig(self::MODULENAME, $config));
        $this->assertEquals($config, $this->service->getConfig(self::MODULENAME));
    }

    public function testGettingDefaultParameterIfConfigurationDoesNotExist()
    {
        $this->assertEquals('Default', $this->service->getConfig(self::MODULENAME, 'Default'));
    }

    public function testSettingAndGettingPathSeparator()
    {
        $this->service->setPathSeparator(';');
        $this->assertEquals(';', $this->service->getPathSeparator());
    }

    public function testSettingAndGettingConfigurationByPath()
    {
        $path = 'Level1.Level2.Level3';
        $config = [
            'value1' => true,
            'value2' => false,
        ];

        $this->assertInstanceOf(ConfigurationServiceInterface::class, $this->service->setConfigByPath(self::MODULENAME, $path, $config));
        $this->assertEquals($config, $this->service->getConfigByPath(self::MODULENAME, $path));
        $this->assertEquals(
            [
                'Level1' => [
                    'Level2' => [
                        'Level3' => $config
                    ]
                ]
            ],
            $this->service->getConfig(self::MODULENAME
        ));
    }

    public function testGettingDefaultParameterIfConfigurationIdentifiedByPathDoesNotExist()
    {
        $this->assertEquals(
            'Default',
            $this->service->getConfigByPath(self::MODULENAME,
            'Level1.Level2.Level3',
            'Default'
        ));
    }
}
