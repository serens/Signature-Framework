<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Persistence\ActiveRecord\Exception;

/**
 * Class InvalidFieldException
 * @package Signature\Persistence\ActiveRecord\Exception
 */
class InvalidFieldException extends \InvalidArgumentException
{
    /**
     * Constructs the exception message.
     * @param string $field
     */
    public function __construct($field)
    {
        parent::__construct('The field "' . $field . '" does not exist on this record.');
    }
}
