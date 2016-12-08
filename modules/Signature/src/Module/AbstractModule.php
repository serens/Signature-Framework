<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Module;

/**
 * Class AbstractModule
 * @package Signature\Module
 */
abstract class AbstractModule implements ModuleInterface
{
    use \Signature\Configuration\ConfigurationServiceTrait;

    /**
     * @var string
     */
    protected $author = '';

    /**
     * @var string
     */
    protected $copyright = '';

    /**
     * @var string
     */
    protected $version = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $url = '';

    /**
     * @var string
     */
    protected $moduleName = null;

    /**
     * Returns a configuration-array of this module.
     *
     * If a file called Config.php exists, then this file will be included. Otherwise, an empty array will be returned.
     * @return array
     */
    public function getConfig(): array
    {
        $file = implode(DIRECTORY_SEPARATOR, [
            \Signature\Core\AutoloaderInterface::MODULES_PATHNAME,
            $this->getModuleName(),
            \Signature\Core\AutoloaderInterface::SOURCES_PATHNAME,
            self::CONFIG_FILENAME
        ]);

        if (file_exists($file)) {
            $config = require_once $file;

            if (!is_array($config)) {
                $config = [];
            }

            return $config;
        } else {
            return [];
        }
    }

    /**
     * Initializes this module.
     * @return bool
     */
    public function init(): bool
    {
        return true;
    }

    /**
     * Starts the module.
     * @return bool
     */
    public function start(): bool
    {
        return true;
    }

    /**
     * Returns information about the author of the module.
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Returns a description of the module.
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Returns a copyright notive of the module.
     * @return string
     */
    public function getCopyright(): string
    {
        return $this->copyright;
    }

    /**
     * Returns the current version of the module.
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Returns the website of the module.
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Returns the name of the module.
     *
     * The module name must match the directory name in which the module resides.
     * @return string
     */
    public function getModuleName(): string
    {
        if (null === $this->moduleName) {
            $parts = explode('\\', get_class($this));
            $this->moduleName = array_shift($parts);
        }

        return $this->moduleName;
    }
}
