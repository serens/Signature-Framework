<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Logging;

/**
 * Trait LoggingServiceTrait
 * @package Signature\Logging
 */
trait LoggingServiceTrait
{
    /**
     * @var LoggingService
     */
    protected $loggingService;

    /**
     * Sets the Logging Service via Dependency Injection.
     * @param LoggingService $loggingService
     * @return void
     */
    public function setLoggingService(LoggingService $loggingService)
    {
        $this->loggingService = $loggingService;
    }
}
