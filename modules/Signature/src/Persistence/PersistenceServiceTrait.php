<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Persistence;

/**
 * Trait PersistenceServiceTrait
 * @package Signature\Persistence
 */
trait PersistenceServiceTrait
{
    /**
     * @var PersistenceService
     */
    protected $persistenceService;

    /**
     * Sets the Persistence Service via Dependency Injection.
     * @param PersistenceService $persistenceService
     * @return void
     */
    public function setPersistenceService(PersistenceService $persistenceService)
    {
        $this->persistenceService = $persistenceService;
    }
}
