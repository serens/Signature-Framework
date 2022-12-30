<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Logging\Logger;

/**
 * Class NullLogger
 * @package Signature\Logging\Logger
 */
class NullLogger extends AbstractLogger
{
    /**
     * Logs a given message to... nothing.
     * @param string $message
     * @param int $priority
     * @param int $code
     * @return LoggerInterface
     */
    public function log(string $message, int $priority = LoggerInterface::PRIORITY_NORMAL, int $code = 0): LoggerInterface
    {
        parent::log($message, $priority, $code);
        return $this;
    }
}
