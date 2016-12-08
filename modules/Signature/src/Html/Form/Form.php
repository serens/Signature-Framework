<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Html\Form;

use Signature\Html\Form\Element\ElementInterface;
use Signature\Html\Tag;
use Signature\Mvc\RequestInterface;

/**
 * Class Form
 * @package Signature\Html\Form
 */
class Form extends Tag implements FormInterface
{
    /**
     * @var bool
     */
    protected $forceUseClosingTag = true;

    /**
     * @var array
     */
    protected $elements = [];

    /**
     * @var RequestInterface
     */
    protected $request = null;

    /**
     * Sets a request-object to the form.
     * @param RequestInterface $request
     * @param array $attributes
     * @param array $elements
     */
    public function __construct(RequestInterface $request, array $attributes = [], array $elements = [])
    {
        if (!array_key_exists('action', $attributes)) {
            $attributes['action'] = $request->getRequestUri();
        }

        if (!array_key_exists('method', $attributes)) {
            $attributes['method'] = self::METHOD_POST;
        }

        parent::__construct('form', $attributes);

        $this->request = $request;

        $this->addElements($elements);
    }

    /**
     * Adds several elements to the form at once.
     * @param array $elements
     * @return Form
     */
    public function addElements(array $elements): Form
    {
        foreach ($elements as $element) {
            $this->addElement($element);
        }

        return $this;
    }

    /**
     * Adds a single element to this form.
     * @param ElementInterface $element
     * @return Form
     */
    public function addElement(ElementInterface $element): Form
    {
        $element->setForm($this);

        if ($this->request->hasParameter($parameter = $element->getAttribute('name'))) {
            $element->setValue($this->request->getParameter($parameter));
        }

        $this->elements[] = $element;

        return $this;
    }

    /**
     * Returns all elements in the form.
     * @return array
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    /**
     * Returns the value of the element specified.
     * @param string $name
     * @throws \RuntimeException If the specified element does not exist in this form.
     * @return string
     */
    public function getElementValue(string $name): string
    {
        return $this->getElement($name)->getValue();
    }

    /**
     * Returns an element specified by its name.
     * @param string $name
     * @throws \RuntimeException If the specified element does not exist in this form.
     * @return ElementInterface
     */
    public function getElement(string $name): ElementInterface
    {
        /** @var ElementInterface $element */
        foreach ($this->elements as $element) {
            if ($element->getAttribute('name') == $name) {
                return $element;
            }
        }

        throw new \RuntimeException('No element "' . $name . '" found.');
    }

    /**
     * Returns a serialized string of the form.
     * @return string
     */
    public function getSerializedData(): string
    {
        $data = array_map(
            function ($element) {
                /** @var \Signature\Html\Form\Element\AbstractElement $element */
                return urlencode($element->getAttribute('name')) . '=' . urlencode($element->getValue());
            },
            $this->elements
        );

        return implode('&', $data);
    }

    /**
     * Renders the form with all its elements.
     * @return string
     */
    public function render(): string
    {
        $content = '';

        array_map(
            function ($element) use (&$content) {
                /** @var \Signature\Html\Form\Element\AbstractElement $element */
                $content .= $element->render();
            },
            $this->elements
        );

        $this->setContent($content);

        return parent::render();
    }

    /**
     * Validates the form and its elements.
     * @return bool
     */
    public function validate(): bool
    {
        return true;
    }
}
