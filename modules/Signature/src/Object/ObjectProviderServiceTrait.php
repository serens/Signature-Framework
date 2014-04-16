<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Object;

/**
 * Trait ObjectProviderServiceTrait
 * @package Signature\Object
 */
trait ObjectProviderServiceTrait
{
    /**
     * @var ObjectProviderService
     */
    protected $objectProviderService;

    /**
     * Sets the Object-Provider Service via Dependency Injection.
     * @param $objectProviderService $objectProviderService
     * @return void
     */
    public function setObjectProviderService(ObjectProviderService $objectProviderService)
    {
        $this->objectProviderService = $objectProviderService;
    }
}
