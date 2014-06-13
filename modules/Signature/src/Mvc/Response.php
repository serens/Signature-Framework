<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc;

/**
 * Class Response
 * @package Signature\Mvc
 */
class Response implements ResponseInterface
{
    /**
     * @var string
     */
    protected $content = '';

    /**
     * Sets the full content of the reponse-object.
     * @param string $content
     * @return \Signature\Mvc\ResponseInterface
     */
    public function setContent($content)
    {
        $this->content = (string) $content;

        return $this;
    }

    /**
     * Returns the actual contained content in the reponse-object.
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Adds additional content to the already existing content.
     * @param string $content
     * @return \Signature\Mvc\ResponseInterface
     */
    public function appendContent($content)
    {
        $this->content .= (string) $content;

        return $this;
    }

    /**
     * Adds additional content to the beginning of the already existing content.
     * @param string $content
     * @return \Signature\Mvc\ResponseInterface
     */
    public function prependContent($content)
    {
        $this->content = (string) $content . $this->content;

        return $this;
    }
}
