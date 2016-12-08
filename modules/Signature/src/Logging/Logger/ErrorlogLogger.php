<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Logging\Logger;

/**
 * Class ErrorlogLogger
 * @package Signature\Logging\Logger
 */
class ErrorlogLogger extends AbstractLogger
{
    /**
     * Logs a given message to the PHP errorlog.
     * @param string $message
     * @param int $priority
     * @param int $code
     * @return LoggerInterface
     */
    public function log(string $message, int $priority = LoggerInterface::PRIORITY_NORMAL, int $code = 0): LoggerInterface
    {
        parent::log($message, $priority, $code);

        error_log($message);

        return $this;
    }
}
