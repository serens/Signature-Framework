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
     * @var bool
     */
    protected $isRequired = false;

    /**
     * @var string[]
     */
    protected $scalarTypes = ['string', 'integer', 'boolean', 'double', 'array', 'object'];

    /**
     * Creates an argument description.
     * @param bool $isRequired
     * @param string $type
     * @param string $default
     */
    public function __construct(bool $isRequired = false, string $type = 'string', string $default = '')
    {
        $sanitizedType = trim(strtolower($type));

        if ('float' === $sanitizedType) {
            $sanitizedType = 'double';
        } elseif ('int' === $sanitizedType) {
            $sanitizedType = 'integer';
        } elseif ('bool' === $sanitizedType) {
            $sanitizedType = 'boolean';
        } else {
            $sanitizedType = trim($type);
        }

        $this->isRequired = $isRequired;
        $this->type       = $sanitizedType;
        $this->default    = $default;
    }

    /**
     * @return string
     */
    public function getDefault(): string
    {
        return $this->default;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->isRequired;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Returns true if the type must be a scalar type.
     * @return bool
     */
    public function mustBeScalarType(): bool
    {
        return in_array($this->type, $this->scalarTypes);
    }
}
