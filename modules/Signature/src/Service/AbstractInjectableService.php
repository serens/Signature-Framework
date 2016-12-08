<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Service;

/**
 * Class AbstractInjectableService
 * @package Signature\Service
 */
abstract class AbstractInjectableService implements InjectableServiceInterface
{
    /**
     * Return true, if this Service should only be created once by the Service Locator.
     * @return bool
     */
    public function threatAsSingleton(): bool
    {
        return true;
    }

    /**
     * Will be called from the Object Provider to initialize this service.
     * @return void
     */
    public function init()
    {
    }
}
