<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Html\Form\Element;

/**
 * Class Input
 * @package Signature\Html\Form\Element
 */
class Input extends AbstractElement
{
    /**
     * Sets name, value and type.
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @param string $type The type of the input, eg "text", "password", "submit" ...
     */
    public function __construct($name, $value, array $attributes = [], $type = 'text')
    {
        $attributes['type'] = (string) $type;

        parent::__construct($name, $value, $attributes);

        $this->setTagName('input');
    }
}
