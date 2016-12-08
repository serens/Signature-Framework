<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Html;

/**
 * Interface TagInterface
 * @package Signature\Html
 */
interface TagInterface
{
    /**
     * Sets a attribute of this tag, such as "name".
     * @param string $name
     * @param string $value
     * @return TagInterface
     */
    public function setAttribute(string $name, string $value): TagInterface;

    /**
     * Sets some attributes of the tag.
     * @param array $attributes
     * @return TagInterface
     */
    public function setAttributes(array $attributes): TagInterface;

    /**
     * Returns the current value of the specified attribute.
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getAttribute(string $name, $default = '');

    /**
     * Returns all attributes of this tag.
     * @return array
     */
    public function getAttributes(): array;

    /**
     * Sets content of this tag.
     * @param string $content
     * @return TagInterface
     */
    public function setContent(string $content): TagInterface;

    /**
     * Returns the content of this tag.
     * @return string
     */
    public function getContent(): string;

    /**
     * Removes an attribute from the tag.
     * @param string $name
     * @return TagInterface
     */
    public function removeAttribute(string $name): TagInterface;

    /**
     * Renders the tag with all attributes.
     * @return string
     */
    public function render(): string;

    /**
     * Sets the type of the tag such as "form".
     * @param string $tagName
     * @return TagInterface
     */
    public function setTagName(string $tagName): TagInterface;
}
