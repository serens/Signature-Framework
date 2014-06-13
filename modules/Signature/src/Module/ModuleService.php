<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Module;

/**
 * Class ModuleService
 * @package Signature\Persistence
 */
/**
 * Class ModuleService
 * @package Signature\Module
 */
class ModuleService extends \Signature\Service\AbstractInjectableService
{
    /**
     * @var array
     */
    protected $registeredModules = [];

    /**
     * Registers a module by a given identigiername.
     * @param string          $moduleIdentifier
     * @param ModuleInterface $module
     * @return ModuleService
     */
    public function registerModule($moduleIdentifier, ModuleInterface $module)
    {
        $this->registeredModules[$moduleIdentifier] = $module;

        return $this;
    }

    /**
     * Returns all registered modules.
     * @return array
     */
    public function getRegisteredModules()
    {
        return $this->registeredModules;
    }

    /**
     * Returns a single module identified by a given name.
     * @param string $moduleIdentifier
     * @return ModuleInterface
     * @throws \OutOfBoundsException
     */
    public function getModule($moduleIdentifier)
    {
        if (array_key_exists($moduleIdentifier, $this->registeredModules)) {
            return $this->registeredModules[$moduleIdentifier];
        }

        throw new \OutOfBoundsException(
            'A module identified by "' . $moduleIdentifier . '" has not been registered.'
        );
    }
}
