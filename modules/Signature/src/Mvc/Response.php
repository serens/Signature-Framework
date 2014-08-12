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
     * @var array
     */
    protected $header = [];

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
     * Adds header information to the response.
     * @param string $header
     * @param string $content
     * @return \Signature\Mvc\ResponseInterface
     */
    public function addToHeader($header, $content)
    {
        $this->header[(string) $header] = (string) $content;

        return $this;
    }

    /**
     * Returns the header of the response-object.
     * @return array
     */
    public function getHeader()
    {
        return $this->header;
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
