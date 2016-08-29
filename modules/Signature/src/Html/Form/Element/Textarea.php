<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Html\Form\Element;

/**
 * Class Textarea
 * @package Signature\Html\Form\Element
 */
class Textarea extends AbstractElement
{
    /**
     * @var boolean
     */
    protected $forceUseClosingTag = true;

    /**
     * Sets name, value and type.
     * @param string $name
     * @param string $value
     * @param array  $attributes
     */
    public function __construct($name, $value = '', array $attributes = [])
    {
        parent::__construct($name, $value, $attributes);

        $this->setTagName('textarea');
    }

    /**
     * Returns the current value of the textarea.
     * @return string
     */
    public function getValue()
    {
        return $this->getContent();
    }

    /**
     * Sets the current value of the textarea.
     * @param string $value
     * @return ElementInterface
     */
    public function setValue($value)
    {
        return $this->setContent($value);
    }
}
