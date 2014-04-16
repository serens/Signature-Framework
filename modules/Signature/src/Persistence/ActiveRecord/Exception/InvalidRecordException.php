<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Persistence\ActiveRecord\Exception;

/**
 * Class InvalidRecordException
 * @package Signature\Persistence\ActiveRecord\Exception
 */
class InvalidRecordException extends \RuntimeException
{
    /**
     * Constructs the exception message.
     */
    public function __construct()
    {
        parent::__construct('This model is not yet loaded and thus cannot be deleted or updated.');
    }
}
