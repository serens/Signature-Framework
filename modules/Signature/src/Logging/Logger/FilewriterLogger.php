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
     * @var string
     */
    private $logFile = null;

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
    public function __construct($logFile, $mode = 'a')
    {
        $logFile = (string) $logFile;
        $this->logFile = $logFile;

        if (!$this->fileResource = fopen($logFile, $mode, false)) {
            throw new \RuntimeException(sprintf(
                'File "%s" to write log-messages to could not be opened.',
                $logFile
            ));
        }
    }

    /**
     * Logs a given message to the output-stream.
     * @param string  $message
     * @param integer $priority
     * @param integer $code
     * @return LoggerInterface
     */
    public function log($message, $priority = LoggerInterface::PRIORITY_NORMAL, $code = 0)
    {
        parent::log($message, $priority, $code);

        $message = sprintf(
            '%s (%s): %s',
            date('Y-m-d, H:i:s'),
            $this->priority2String($message),
            $message
        );

        fwrite($this->fileResource, $message . PHP_EOL);

        return $this;
    }
}
