<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Core\Error;

/**
 * Interface ExceptionHandlerInterface
 * @package Signature\Core\Error
 */
interface ExceptionHandlerInterface
{
    /**
     * Handles a given exception.
     * @param \Exception $e
     * @return boolean
     */
    public static function handleException(\Exception $e);
}
