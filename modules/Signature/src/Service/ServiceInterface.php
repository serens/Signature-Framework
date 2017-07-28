<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Service;

use \Signature\Object\SingletonInterface;

/**
 * Interface InjectableServiceInterface
 * @package Signature\Service
 */
interface ServiceInterface extends SingletonInterface
{
    /**
     * Will be called from the Object Provider to initialize this service.
     * @return void
     */
    public function init();
}
