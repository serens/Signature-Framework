<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Html\Form\Element;

/**
 * Class Radio
 * @package Signature\Html\Form\Element
 */
class Radio extends Select
{
    /**
     * Renders a single option of the set of options.
     * @throws \OutOfRangeException
     * @param string $value
     * @return string
     */
    public function renderOption(string $value): string
    {
        if (!$this->isValidValue($value)) {
            throw new \OutOfRangeException('Value "' . $value . '" does not exist in the set of options.');
        }

        $checked = $value == $this->getValue() ? ['checked' => 'checked'] : [];
        $radio   = new Input($this->getAttribute('name'), $value, $checked, 'radio');

        return $radio->render();
    }

    /**
     * Renders the set of radio inputs.
     * @return string
     */
    public function render(): string
    {
        $options = '';

        foreach ($this->options as $option) {
            $options .= $this->renderOption($option);
        }

        return $options;
    }

    /**
     * Returns true, if the given value does exist in the set of options.
     * @param string $value
     * @return bool
     */
    protected function isValidValue(string $value): bool
    {
        foreach ($this->options as $option) {
            if ((string) $option === $value) {
                return true;
            }
        }

        return false;
    }
}
