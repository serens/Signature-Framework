<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc;

/**
 * Class ResponseInterface
 * @package Signature\Mvc
 */
interface ResponseInterface
{
    /**
     * Sets the full content of the reponse-object.
     * @param string $content
     * @return \Signature\Mvc\ResponseInterface
     */
    public function setContent($content);

    /**
     * Returns the actual contained content in the reponse-object.
     * @return string
     */
    public function getContent();

    /**
     * Adds additional content to the already existing content.
     * @param string $content
     * @return \Signature\Mvc\ResponseInterface
     */
    public function appendContent($content);

    /**
     * Adds additional content to the beginning of the already existing content.
     * @param string $content
     * @return \Signature\Mvc\ResponseInterface
     */
    public function prependContent($content);
}
