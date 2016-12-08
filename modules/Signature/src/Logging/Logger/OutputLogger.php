<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Logging\Logger;

/**
 * Class OutputLogger
 * @package Signature\Logging\Logger
 */
class OutputLogger extends AbstractLogger
{
    /**
     * Logs a given message to the output-stream.
     * @param string $message
     * @param int $priority
     * @param int $code
     * @return LoggerInterface
     */
    public function log(string $message, int $priority = LoggerInterface::PRIORITY_NORMAL, int $code = 0): LoggerInterface
    {
        parent::log($message, $priority, $code);

        echo '<!-- ' . $message . ' -->';

        return $this;
    }
}
