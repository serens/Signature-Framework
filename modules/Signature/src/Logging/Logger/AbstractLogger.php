<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Logging\Logger;

/**
 * Class AbstractLogger
 * @package Signature\Logging\Logger
 */
abstract class AbstractLogger implements LoggerInterface
{
    /**
     * @var int
     */
    private $filterMask = LoggerInterface::PRIORITY_ALL;

    /**
     * Returns a string-representation of a given priority.
     * @param int $priority
     * @return string
     */
    public function priority2String(int $priority): string
    {
        switch ($priority) {
            case LoggerInterface::PRIORITY_NORMAL:
                return 'NORMAL';

            case LoggerInterface::PRIORITY_NOTICE:
                return 'NOTICE';

            case LoggerInterface::PRIORITY_WARNING:
                return 'WARNING';

            case LoggerInterface::PRIORITY_ERROR:
                return 'ERROR';

            case LoggerInterface::PRIORITY_CRITICAL:
                return 'CRITICAL';

            default:
                return 'UNKNOWN PRIORITY';
        }
    }

    /**
     * Sets a filter-level.
     * @param int $filterMask
     * @return LoggerInterface
     */
    public function setLogFilter(int $filterMask): LoggerInterface
    {
        $this->filterMask = $filterMask;

        return $this;
    }

    /**
     * Returns the actual filtering-level.
     * @return int
     */
    public function getLogFilter(): int
    {
        return $this->filterMask;
    }

    /**
     * Logs a given message.
     * @param string $message
     * @param int $priority
     * @param int $code
     * @throws \InvalidArgumentException
     * @return LoggerInterface
     */
    public function log(string $message, int $priority = LoggerInterface::PRIORITY_NORMAL, int $code = 0): LoggerInterface
    {
        if ($priority <= 0)
            throw new \InvalidArgumentException('Invalid value for Argument $priority.');

        return $this;
    }
}
