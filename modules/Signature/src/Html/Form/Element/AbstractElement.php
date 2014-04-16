<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Html\Form\Element;

/**
 * Class AbstractElement
 * @package Signature\Html\Form\Element
 */
abstract class AbstractElement extends \Signature\Html\Tag implements ElementInterface
{
    /**
     * @var \Signature\Html\Form\FormInterface
     */
    protected $form = null;

    /**
     * Sets name and value of the element.
     * @param string $name
     * @param string $value
     * @param array  $attributes
     */
    public function __construct($name, $value, array $attributes = [])
    {
        $attributes['name'] = (string) $name;

        $this
            ->setValue($value)
            ->setAttributes($attributes);
    }

    /**
     * Sets the current value of the form element.
     * @param string $value
     * @return ElementInterface
     */
    public function setValue($value)
    {
        $this->setAttribute('value', $value);

        return $this;
    }

    /**
     * Returns the current value of the form element.
     * @return string
     */
    public function getValue()
    {
        return $this->getAttribute('value');
    }

    /**
     * Returns the current form this element belongs to.
     * @return \Signature\Html\Form\FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Sets the form this element belongs to.
     * @param \Signature\Html\Form\FormInterface $form
     * @return ElementInterface
     */
    public function setForm(\Signature\Html\Form\FormInterface $form)
    {
        $this->form = $form;

        return $this;
    }
}
