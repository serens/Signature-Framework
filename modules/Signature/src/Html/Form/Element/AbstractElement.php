<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Html\Form\Element;

use Signature\Html\Form\FormInterface;

/**
 * Class AbstractElement
 * @package Signature\Html\Form\Element
 */
abstract class AbstractElement extends \Signature\Html\Tag implements ElementInterface
{
    /**
     * @var FormInterface
     */
    protected $form = null;

    /**
     * Sets name and value of the element.
     * @param string $name
     * @param string $value
     * @param array $attributes
     */
    public function __construct(string $name, string $value = '', array $attributes = [])
    {
        $attributes['name'] = $name;

        $this
            ->setValue($value)
            ->setAttributes($attributes);
    }

    /**
     * Sets the current value of the form element.
     * @param string $value
     * @return ElementInterface
     */
    public function setValue(string $value): ElementInterface
    {
        $this->setAttribute('value', $value);

        return $this;
    }

    /**
     * Returns the current value of the form element.
     * @return string
     */
    public function getValue(): string
    {
        return $this->getAttribute('value');
    }

    /**
     * Returns the current form this element belongs to.
     * @return FormInterface
     */
    public function getForm(): FormInterface
    {
        return $this->form;
    }

    /**
     * Sets the form this element belongs to.
     * @param FormInterface $form
     * @return ElementInterface
     */
    public function setForm(FormInterface $form): ElementInterface
    {
        $this->form = $form;

        return $this;
    }
}
