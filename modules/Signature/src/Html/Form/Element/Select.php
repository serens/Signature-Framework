<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Html\Form\Element;

/**
 * Class Select
 * @package Signature\Html\Form\Element
 */
class Select extends AbstractElement
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var string
     */
    protected $value = '';

    /**
     * @var bool
     */
    protected $forceUseClosingTag = true;

    /**
     * Sets name, value, options and type.
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @param array $options
     */
    public function __construct(string $name, string $value = '', array $attributes = [], array $options = [])
    {
        parent::__construct($name, $value, $attributes);

        $this
            ->setOptions($options)
            ->setTagName('select');
    }

    /**
     * Returns the value of the selectbox.
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Sets the value of the selectbox.
     * @param string $value
     * @return ElementInterface
     */
    public function setValue(string $value): ElementInterface
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Returns the currently set options.
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Sets the option-Tags for the select-input.
     * @param array $options
     * @return Select
     */
    public function setOptions(array $options): Select
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Renders the selectbox.
     * @return string
     */
    public function render(): string
    {
        $this->setContent($this->renderOptions());

        return parent::render();
    }

    /**
     * Renders the options-elements of the selectbox.
     * @return string
     */
    protected function renderOptions(): string
    {
        $optionsHtml = '';

        foreach ($this->options as $key => $options) {
            if (is_array($options)) {
                $optionsHtml .= ('<optgroup label="' . $key . '">');

                foreach ($options as $key => $caption) {
                    $optionsHtml .= sprintf(
                        '<option value="%s"%s>%s</option>',
                        htmlspecialchars($key),
                        ((string) $key === $this->getValue()) ? ' selected="selected"' : '',
                        $caption
                    );
                }

                $optionsHtml .= '</optgroup>';
            } else {
                $optionsHtml .= sprintf(
                    '<option value="%s"%s>%s</option>',
                    htmlspecialchars($key),
                    ((string) $key === $this->getValue()) ? ' selected="selected"' : '',
                    $options
                );
            }
        }

        return $optionsHtml;
    }
}
