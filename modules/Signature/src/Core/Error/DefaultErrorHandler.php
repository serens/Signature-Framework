<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Core\Error;

/**
 * Class DefaultErrorHandler
 * @package Signature\Core\Error
 */
class DefaultErrorHandler implements \Signature\Core\Error\ErrorHandlerInterface
{
    /**
     * Handles the given error.
     * @param integer $errno
     * @param string  $errstr
     * @param string  $errfile
     * @param integer $errline
     * @param array   $context
     * @return boolean
     */
    public static function handleError($errno, $errstr, $errfile, $errline, $context)
    {
        ob_clean();

        print('<div style="border:1px solid #FF4949; background-color:#FF4949; padding:0; margin:0; font-family:\'Courier New\'; font-size:12px; color:white;">');
        print('<p style="padding:5px 10px 7px 10px; margin:0;">Error: <strong> ' . $errstr . '</strong></p>');
        print('<pre style="background-color:#F3B6B6; padding:5px 10px; margin:0; color:red; overflow:auto;">');
        print('<strong>Where:</strong> ' . $errfile . '<br />');
        print('<strong>Line:</strong>  ' . $errline . '<br />');

        if ($context !== null && is_string($context)) {
            print('<strong>Trace:</strong><br /><br />');
            print($context);
        }

        print('</pre>');
        print('</div>');

        return true;
    }
}
