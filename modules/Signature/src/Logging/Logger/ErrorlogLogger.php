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
     * @param string  $message
     * @param integer $priority
     * @param integer $code
     * @return LoggerInterface
     */
    public function log($message, $priority = LoggerInterface::PRIORITY_NORMAL, $code = 0)
    {
        parent::log($message, $priority, $code);

        error_log($message);

        return $this;
    }
}
