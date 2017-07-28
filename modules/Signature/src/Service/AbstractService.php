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
abstract class AbstractService implements ServiceInterface
{
    /**
     * Will be called from the Object Provider to initialize this service.
     * @return void
     */
    public function init()
    {
    }
}
