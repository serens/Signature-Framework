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
     * @var integer
     */
    private $filterMask = LoggerInterface::PRIORITY_ALL;

    /**
     * Returns a string-representation of a given priority.
     * @param integer $priority
     * @return string
     */
    public function priority2String($priority)
    {
        switch ((int) $priority) {
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
     * @param integer $filterMask
     * @return LoggerInterface
     */
    public function setLogFilter($filterMask)
    {
        $this->filterMask = (int) $filterMask;

        return $this;
    }

    /**
     * Returns the actual filtering-level.
     * @return integer
     */
    public function getLogFilter()
    {
        return $this->filterMask;
    }

    /**
     * Logs a given message.
     * @param string  $message
     * @param integer $priority
     * @param integer $code
     * @throws \InvalidArgumentException
     * @return LoggerInterface
     */
    public function log($message, $priority = LoggerInterface::PRIORITY_NORMAL, $code = 0)
    {
        if ($priority <= 0)
            throw new \InvalidArgumentException('Invalid value for Argument $priority.');

        return $this;
    }
}
