<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Module;

/**
 * Interface ModuleInterface
 * @package Signature\Module
 */
interface ModuleInterface
{
    /**
     * @var string
     */
    const CONFIG_FILENAME = 'Config.php';

    /**
     * @var string
     */
    const MODULE_FILENAME = 'Module.php';

    /**
     * Returns a configuration-array of this module.
     * @return array
     */
    public function getConfig(): array;

    /**
     * Initializes this module.
     * @return bool
     */
    public function init(): bool;

    /**
     * Starts the module.
     * @return bool
     */
    public function start(): bool;

    /**
     * Returns information about the author of the module.
     * @return string
     */
    public function getAuthor(): string;

    /**
     * Returns a description of the module.
     * @return string
     */
    public function getDescription(): string;

    /**
     * Returns a copyright notive of the module.
     * @return string
     */
    public function getCopyright(): string;

    /**
     * Returns the current version of the module.
     * @return string
     */
    public function getVersion(): string;

    /**
     * Returns the website of the module.
     * @return string
     */
    public function getUrl(): string;

    /**
     * Returns the name of the module.
     *
     * The module name must match the directory name in which the module resides.
     * @return string
     */
    public function getModuleName(): string;
}
