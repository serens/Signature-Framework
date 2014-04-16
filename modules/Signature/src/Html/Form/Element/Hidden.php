<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Html\Form\Element;

/**
 * Class Hidden
 * @package Signature\Html\Form\Element
 */
class Hidden extends Input
{
    /**
     * Sets name and value of the element.
     * @param string $name
     * @param string $value
     * @param array  $attributes
     */
    public function __construct($name, $value, array $attributes = [])
    {
        parent::__construct($name, $value, $attributes, 'hidden');
    }
}
