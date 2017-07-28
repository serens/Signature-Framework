<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Logging;

use \Signature\Logging\Logger\LoggerInterface;

/**
 * Class LoggingService
 * @package Signature\Logging
 */
class LoggingService extends \Signature\Service\AbstractService
{
    /**
     * @var array
     */
    protected $registeredLoggers = [];

    /**
     * Logs a given message to all registered loggers.
     * @param string $message
     * @param int $priority
     * @param int $code
     * @return LoggingService
     */
    public function log(string $message, int $priority = LoggerInterface::PRIORITY_NORMAL, int $code = 0): LoggingService
    {
        /* @var $logger LoggerInterface */
        foreach ($this->registeredLoggers as $logger) {
            if ($logger->getLogFilter() & $priority || $logger->getLogFilter() == LoggerInterface::PRIORITY_ALL) {
                $logger->log($message, $priority, $code);
            }
        }

        return $this;
    }

    /**
     * Adds a logger to the list of loggers.
     * @param LoggerInterface $logger
     * @return LoggingService
     */
    public function registerLogger(LoggerInterface $logger): LoggingService
    {
        $this->registeredLoggers[] = $logger;

        return $this;
    }

    /**
     * Returns the list of currently registered loggers.
     * @return array
     */
    public function getRegisteredLoggers(): array
    {
        return $this->registeredLoggers;
    }

    /**
     * Returns a specific logger named by its classname.
     * @param string $loggerClassname
     * @throws \OutOfBoundsException
     * @return LoggerInterface
     */
    public function getLogger(string $loggerClassname): LoggerInterface
    {
        foreach ($this->registeredLoggers as $logger) {
            if (get_class($logger) == $loggerClassname) {
                return $logger;
            }
        }

        throw new \OutOfBoundsException('A logger "' . $loggerClassname . '" has not been registered to this service.');
    }
}
