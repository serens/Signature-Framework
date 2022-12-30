<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Logging\Logger;

/**
 * Class FilewriterLogger
 * @package Signature\Logging\Logger
 */
class FilewriterLogger extends AbstractLogger
{
    /**
     * @var resource
     */
    private $fileResource = null;

    /**
     * Constructor. Takes a given filename as the target for logging-output.
     * @param string $logFile
     * @param string $mode
     * @throws \RuntimeException
     */
    public function __construct(string $logFile, string $mode = 'a')
    {
        if (!$this->fileResource = fopen($logFile, $mode, false)) {
            throw new \RuntimeException(sprintf(
                'File "%s" to write log-messages to could not be opened.',
                $logFile
            ));
        }
    }

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

        $message = sprintf(
            '%s (%s): %s',
            date('Y-m-d, H:i:s'),
            $this->priority2String($priority),
            $message
        );

        fwrite($this->fileResource, $message . PHP_EOL);

        return $this;
    }
}
