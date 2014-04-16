<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Core\Error;

/**
 * Class DefaultExceptionHandler
 * @package Signature\Core\Error
 */
class DefaultExceptionHandler implements \Signature\Core\Error\ExceptionHandlerInterface
{
    /**
     * Handles the given exception and displays a stacktrace.
     * @param \Exception $e
     * @return boolean
     */
    public static function handleException(\Exception $e)
    {
        ob_clean();

        print('<div style="border:1px solid #FF4949; background-color:#FF4949; padding:0; margin:0; font-family:\'Courier New\'; font-size:12px; color:white;">');
        print('<p style="padding:5px 10px 7px 10px; margin:0;">Uncaught Exception: <strong>' . get_class($e) . '</strong></p>');
        print('<pre style="background-color:#F3B6B6; padding:5px 10px; margin:0; color:red; overflow:auto;">');
        print('<strong>Message:</strong> ' . $e->getMessage() . '<br />');
        print('<strong>Where:</strong>   ' . $e->getFile() . '<br />');
        print('<strong>Line:</strong>    ' . $e->getLine() . '<br />');
        print('<strong>Trace:</strong><br /><br />');

        print($e->getTraceAsString());

        print('</pre>');
        print('</div>');

        // Allow other handlers to do their work.
        return true;
    }
}
