<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Module;

/**
 * Trait ModuleServiceTrait
 * @package Signature\Module
 */
trait ModuleServiceTrait
{
    /**
     * @var ModuleService
     */
    protected $moduleService;

    /**
     * Sets the Module Service via Dependency Injection.
     * @param ModuleService $moduleService
     * @return void
     */
    public function setModuleService(ModuleService $moduleService)
    {
        $this->moduleService = $moduleService;
    }
}
