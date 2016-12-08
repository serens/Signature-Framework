<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Html;

/**
 * Class Tag
 * @package Signature\Html
 */
class Tag implements TagInterface
{
    /**
     * @var string
     */
    protected $tagName = '';

    /**
     * @var string
     */
    protected $content = '';

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var bool
     */
    protected $forceUseClosingTag = false;

    /**
     * Sets the tagname, such as "form".
     * @param string $tagName
     * @param array $attributes
     */
    public function __construct(string $tagName, array $attributes = [])
    {
        $this
            ->setTagName($tagName)
            ->setAttributes($attributes);
    }

    /**
     * Sets some attributes of the tag.
     * @param array $attributes
     * @return TagInterface
     */
    public function setAttributes(array $attributes): TagInterface
    {
        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }

        return $this;
    }

    /**
     * Sets the type of the tag such as "form".
     * @param string $tagName
     * @return TagInterface
     */
    public function setTagName(string $tagName): TagInterface
    {
        $this->tagName = $tagName;

        return $this;
    }

    /**
     * Removes an attribute from the tag.
     * @param string $name
     * @return TagInterface
     */
    public function removeAttribute(string $name): TagInterface
    {
        if (array_key_exists($name, $this->attributes)) {
            unset($this->attributes[$name]);
        }

        return $this;
    }

    /**
     * Sets a attribute of this tag, such as "name".
     * @param string $name
     * @param string $value
     * @return TagInterface
     */
    public function setAttribute(string $name, string $value): TagInterface
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Returns the current value of the specified attribute.
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getAttribute(string $name, $default = '')
    {
        return array_key_exists($name, $this->attributes) ? $this->attributes[$name] : $default;
    }

    /**
     * Returns all attributes of this tag.
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Renders the tag with all attributes.
     * @return string
     */
    public function render(): string
    {
        $attributes = '';

        foreach ($this->attributes as $name => $value) {
            $attributes .= sprintf('%s="%s" ', $name, htmlspecialchars($value));
        }

        if ('' !== $this->content || $this->forceUseClosingTag) {
            return sprintf('<%s %s>%s</%s>', $this->tagName, $attributes, $this->content, $this->tagName);
        } else {
            return sprintf('<%s %s/>', $this->tagName, $attributes);
        }
    }

    /**
     * Returns the content of this tag.
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Sets content of this tag.
     * @param string $content
     * @return TagInterface
     */
    public function setContent(string $content): TagInterface
    {
        $this->content = $content;

        return $this;
    }
}
