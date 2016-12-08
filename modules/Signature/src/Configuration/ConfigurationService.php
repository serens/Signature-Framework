<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Configuration;

/**
 * Class ConfigurationService
 * @package Signature\Configuration
 */
class ConfigurationService extends \Signature\Service\AbstractInjectableService implements ConfigurationServiceInterface
{
    /**
     * @var string
     */
    protected $pathSeparator = '.';

    /**
     * @var array
     */
    protected $config = [];

    /**
     * Returns a configuration by a given path.
     * @param string $moduleName
     * @param string $path
     * @param mixed  $default
     * @return mixed
     */
    public function getConfigByPath(string $moduleName, string $path, $default = null)
    {
        if (null === ($config = $this->getConfig($moduleName))) {
            return $default;
        }

        $found = false;

        foreach (explode($this->pathSeparator, $path) as $pathSegment) {
            $found = false;

            if (is_array($config) && array_key_exists($pathSegment, $config)) {
                $config = $config[$pathSegment];
                $found  = true;
            }
        }

        return $found ? $config : $default;
    }

    /**
     * Returns the configuration for a specific module.
     *
     * If no configuration is set for the specified module, $default is returned.
     * @param string $moduleName
     * @param mixed $default
     * @return mixed
     */
    public function getConfig(string $moduleName, $default = null)
    {
        return array_key_exists($moduleName, $this->config) ? $this->config[$moduleName] : $default;
    }

    /**
     * Sets the configuration for a specific module.
     * @param string $moduleName
     * @param array $config
     * @return ConfigurationServiceInterface
     */
    public function setConfig(string $moduleName, array $config): ConfigurationServiceInterface
    {
        if (!array_key_exists($moduleName, $this->config)) {
            $this->config[$moduleName] = $config;
        }

        $this->config[$moduleName] = $this->mergeArrayRecursive($this->config[$moduleName], $config);

        return $this;
    }

    /**
     * Merges two arrays together and takes care about already existing keys.
     * @param array $first
     * @param array $second
     * @return array
     */
    protected function mergeArrayRecursive(array $first, array $second): array
    {
        $merged = $first;

        foreach ($second as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = $this->mergeArrayRecursive($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }

    /**
     * Sets a configuration by a given path.
     * @param string $moduleName
     * @param string $path
     * @param mixed $config
     * @return ConfigurationServiceInterface
     */
    public function setConfigByPath(string $moduleName, string $path, $config): ConfigurationServiceInterface
    {
        if (!array_key_exists($moduleName, $this->config)) {
            $this->config[$moduleName] = [];
        }

        $pathSegments = explode($this->pathSeparator, $path);
        $result       = [];
        $current      = & $result;

        for ($i = 0; $i < count($pathSegments); $i++) {
            $pathSegment = $pathSegments[$i];

            if ($i == count($pathSegments) - 1) {
                $current[$pathSegment] = $config;
            } else {
                $current[$pathSegment] = [];
                $current               = & $current[$pathSegment];
            }
        }

        $this->config[$moduleName] = $this->mergeArrayRecursive($this->config[$moduleName], $result);

        return $this;
    }

    /**
     * Returns the symbol which is used to separate a configuration path.
     * @return string
     */
    public function getPathSeparator(): string
    {
        return $this->pathSeparator;
    }

    /**
     * Sets the symbol which is used to separate a configuration path.
     * @param string $pathSeparator
     * @return ConfigurationServiceInterface
     */
    public function setPathSeparator(string $pathSeparator): ConfigurationServiceInterface
    {
        $this->pathSeparator = $pathSeparator;

        return $this;
    }
}
