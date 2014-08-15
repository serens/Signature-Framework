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
     * @var boolean
     */
    protected $forceUseClosingTag = false;

    /**
     * Sets the tagname, such as "form".
     * @param string $tagName
     * @param array $attributes
     */
    public function __construct($tagName, array $attributes = [])
    {
        $this
            ->setTagName((string) $tagName)
            ->setAttributes($attributes);
    }

    /**
     * Sets some attributes of the tag.
     * @param array $attributes
     * @return TagInterface
     */
    public function setAttributes(array $attributes)
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
    public function setTagName($tagName)
    {
        $this->tagName = (string) $tagName;

        return $this;
    }

    /**
     * Removes an attribute from the tag.
     * @param string $name
     * @return TagInterface
     */
    public function removeAttribute($name)
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
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = (string) $value;

        return $this;
    }

    /**
     * Returns the current value of the specified attribute.
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getAttribute($name, $default = '')
    {
        return array_key_exists($name, $this->attributes) ? $this->attributes[$name] : $default;
    }

    /**
     * Returns all attributes of this tag.
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Renders the tag with all attributes.
     * @return string
     */
    public function render()
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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets content of this tag.
     * @param string $content
     * @return TagInterface
     */
    public function setContent($content)
    {
        $this->content = (string) $content;

        return $this;
    }
}
