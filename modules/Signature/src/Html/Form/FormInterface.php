<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Html\Form;

use Signature\Html\Form\Element\ElementInterface;
use Signature\Mvc\RequestInterface;

/**
 * Interface FormInterface
 * @package Signature\Html\Form
 */
interface FormInterface extends \Signature\Html\TagInterface
{
    /**
     * @var string
     */
    const METHOD_POST = 'post';

    /**
     * @var string
     */
    const METHOD_GET = 'get';

    /**
     * Sets a request-object to the form.
     * @param RequestInterface $request
     * @param array $attributes
     * @param array $elements
     */
    public function __construct(RequestInterface $request, array $attributes = [], array $elements = []);

    /**
     * Adds a single element to this form.
     * @param ElementInterface $element
     * @return Form
     */
    public function addElement(ElementInterface $element): Form;

    /**
     * Adds several elements to the form at once.
     * @param array $elements
     * @return Form
     */
    public function addElements(array $elements): Form;

    /**
     * Returns an element specified by its name.
     * @param string $elementName
     * @throws \RuntimeException If the specified element does not exist in this form.
     * @return ElementInterface
     */
    public function getElement(string $elementName): ElementInterface;

    /**
     * Returns all elements in the form.
     * @return array
     */
    public function getElements(): array;

    /**
     * Returns the value of the element specified.
     * @param string $name
     * @throws \RuntimeException If the specified element does not exist in this form.
     * @return string
     */
    public function getElementValue(string $name): string;

    /**
     * Returns a serialized string of the form.
     * @return string
     */
    public function getSerializedData(): string;

    /**
     * Validates the form and its elements.
     * @return bool
     */
    public function validate(): bool;
}
