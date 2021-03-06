<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Module;

/**
 * Class ModuleService
 * @package Signature\Module
 */
class ModuleService extends \Signature\Service\AbstractService
{
    /**
     * @var array
     */
    protected $registeredModules = [];

    /**
     * Registers a module by a given identigiername.
     * @param string $moduleIdentifier
     * @param ModuleInterface $module
     * @return ModuleService
     */
    public function registerModule(string $moduleIdentifier, ModuleInterface $module): ModuleService
    {
        $this->registeredModules[$moduleIdentifier] = $module;

        return $this;
    }

    /**
     * Returns all registered modules.
     * @return array
     */
    public function getRegisteredModules(): array
    {
        return $this->registeredModules;
    }

    /**
     * Returns a single module identified by a given name.
     * @param string $moduleIdentifier
     * @return ModuleInterface
     * @throws \OutOfBoundsException
     */
    public function getModule(string $moduleIdentifier): ModuleInterface
    {
        if (array_key_exists($moduleIdentifier, $this->registeredModules)) {
            return $this->registeredModules[$moduleIdentifier];
        }

        throw new \OutOfBoundsException(
            'A module identified by "' . $moduleIdentifier . '" has not been registered.'
        );
    }
}
