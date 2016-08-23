<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\ViewHelper;

/**
 * Class ArgumentDescription
 * @package Signature\ViewHelper
 */
class ArgumentDescription
{
    /**
     * @var string
     */
    protected $type = 'string';

    /**
     * @var string
     */
    protected $default = '';

    /**
     * @var boolean
     */
    protected $isRequired = false;

    /**
     * Creates an argument description.
     * @param boolean $isRequired
     * @param string $type
     * @param string $default
     */
    public function __construct($isRequired = false, $type = 'string', $default = '')
    {
        $type = trim(strtolower((string) $type));

        if ('float' === $type) {
            $type = 'double';
        } elseif ('int' === $type) {
            $type = 'integer';
        } elseif ('bool' === $type) {
            $type = 'boolean';
        }

        $this->isRequired = (boolean) $isRequired;
        $this->type       = strtolower((string) $type);
        $this->default    = (string) $default;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @return boolean
     */
    public function isRequired()
    {
        return $this->isRequired;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns true if the type must be a scalar type.
     * @return boolean
     */
    public function mustBeScalarType()
    {
        return in_array(strtolower($this->type), ['string', 'integer', 'boolean', 'double', 'array']);
    }
}
