<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Application\Model;

/**
 * Class User
 * @package Application\Model
 */
class User extends \Signature\Persistence\ActiveRecord\AbstractModel
{
    /**
     * Returns the username.
     * @return string
     */
    public function getUsername()
    {
        return ucfirst($this->getFieldValue('username'));
    }
}
