<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Html\Form\Element;

/**
 * Class Checkbox
 * @package Signature\Html\Form\Element
 */
class Checkbox extends Input
{
    /**
     * @var Hidden
     */
    protected $helperInput = null;

    /**
     * @var string
     */
    protected $checkedValue = '1';

    /**
     * @var string
     */
    protected $uncheckedValue = '0';

    /**
     * Sets name and value of the element.
     * @param string $name
     * @param bool $checked
     * @param array $attributes
     */
    public function __construct(string $name, bool $checked = false, array $attributes = [])
    {
        parent::__construct($name, $checked ? $this->checkedValue : $this->uncheckedValue, $attributes, 'checkbox');

        $this->helperInput = new Hidden($name, $this->uncheckedValue);
    }

    /**
     * Retrieves the current checked state of the checkbox.
     * @return bool
     */
    public function isChecked(): bool
    {
        return $this->getAttribute('checked') === 'checked';
    }

    /**
     * Sets the value if the checkbox.
     * @param string $value
     * @return ElementInterface
     */
    public function setValue(string $value): ElementInterface
    {
        // checked="" won't work. Thus, we remove the hole attribute.
        (bool) $value ? $this->setAttribute('checked', 'checked') : $this->removeAttribute('checked');

        return parent::setValue($this->checkedValue);
    }

    /**
     * Returns checked or unchecked value of the checkbox.
     * @return string
     */
    public function getValue(): string
    {
        return 'checked' == $this->getAttribute('checked') ? $this->checkedValue : $this->uncheckedValue;
    }

    /**
     * Renders the checkbox with its hidden helper element.
     * @return string
     */
    public function render(): string
    {
        return $this->helperInput->render() . parent::render();
    }
}
