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
     * @var integer
     */
    const PRIORITY_ALL = 0;

    /**
     * Priority of a message.
     * @var integer
     */
    const PRIORITY_NORMAL = 1;

    /**
     * Priority of a message.
     * @var integer
     */
    const PRIORITY_NOTICE = 2;

    /**
     * Priority of a message.
     * @var integer
     */
    const PRIORITY_WARNING = 4;

    /**
     * Priority of a message.
     * @var integer
     */
    const PRIORITY_ERROR = 8;

    /**
     * Priority of a message.
     * @var integer
     */
    const PRIORITY_CRITICAL = 16;

    /**
     * Logs a given message.
     * @param string $message
     * @param integer $priority
     * @param integer $code
     * @return LoggerInterface
     */
    public function log($message, $priority = LoggerInterface::PRIORITY_NORMAL, $code = 0);

    /**
     * Sets a filter-level.
     * @param integer $filterMask
     * @return LoggerInterface
     */
    public function setLogFilter($filterMask);

    /**
     * Returns the actual filtering-level.
     * @return integer
     */
    public function getLogFilter();
}
