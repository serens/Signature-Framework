<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Configuration;

/**
 * Interface ConfigurationServiceInterface
 * @package Signature\Configuration
 */
interface ConfigurationServiceInterface
{
    /**
     * Sets the configuration for a specific module.
     * @param string $moduleName
     * @param array  $config
     * @return ConfigurationServiceInterface
     */
    public function setConfig($moduleName, array $config);

    /**
     * Returns the configuration for a specific module.
     *
     * If no configuration is set for the specified module, $default is returned.
     * @param string $moduleName
     * @param mixed  $default
     * @return mixed
     */
    public function getConfig($moduleName, $default = null);
}
