<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Core\Error;

/**
 * Interface ErrorHandlerInterface
 * @package Signature\Core\Error
 */
interface ErrorHandlerInterface
{
    /**
     * Handles an PHP-Error.
     * @param integer $errno
     * @param string  $errstr
     * @param string  $errfile
     * @param integer $errline
     * @param array   $context
     * @return boolean
     */
    public static function handleError($errno, $errstr, $errfile, $errline, $context);
}
