<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Configuration;

/**
 * Trait ConfiguationServiceTrait
 * @package Signature\Configuration
 */
trait ConfigurationServiceTrait
{
    /**
     * @var ConfigurationService
     */
    protected $configurationService;

    /**
     * Sets the Configuration Service via Dependency Injection.
     * @param ConfigurationService $configurationService
     * @return void
     */
    public function setConfigurationService(ConfigurationService $configurationService)
    {
        $this->configurationService = $configurationService;
    }
}
