<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Logging\Logger;

/**
 * Interface LoggerInterface
 * @package Signature\Logging\Logger
 */
interface LoggerInterface
{
    /**
     * Filtering is set to filter all messages.
     * @var int
     */
    const PRIORITY_ALL = 0;

    /**
     * Priority of a message.
     * @var int
     */
    const PRIORITY_NORMAL = 1;

    /**
     * Priority of a message.
     * @var int
     */
    const PRIORITY_NOTICE = 2;

    /**
     * Priority of a message.
     * @var int
     */
    const PRIORITY_WARNING = 4;

    /**
     * Priority of a message.
     * @var int
     */
    const PRIORITY_ERROR = 8;

    /**
     * Priority of a message.
     * @var int
     */
    const PRIORITY_CRITICAL = 16;

    /**
     * Logs a given message.
     * @param string $message
     * @param int $priority
     * @param int $code
     * @return LoggerInterface
     */
    public function log(string $message, int $priority = self::PRIORITY_NORMAL, int $code = 0): LoggerInterface;

    /**
     * Sets a filter-level.
     * @param int $filterMask
     * @return LoggerInterface
     */
    public function setLogFilter(int $filterMask): LoggerInterface;

    /**
     * Returns the actual filtering-level.
     * @return int
     */
    public function getLogFilter(): int;
}
