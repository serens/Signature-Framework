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
     * Adds header information to the response.
     * @param string $header
     * @param string $content
     * @return \Signature\Mvc\ResponseInterface
     */
    public function addToHeader($header, $content);

    /**
     * Returns the specified header of the response-object.
     * @param string $header
     * @return string
     */
    public function getHeader($header);

    /**
     * Returns all header information.
     * @return array
     */
    public function getHeaders();

    /**
     * Removes a header entry.
     * @param string $header
     * @return \Signature\Mvc\ResponseInterface
     */
    public function removeFromHeader($header);

    /**
     * Sets a new status code for the response object.
     * @param integer $statusCode
     * @return \Signature\Mvc\ResponseInterface
     */
    public function setStatusCode($statusCode);

    /**
     * Returns the current status code of the response object.
     * @return integer
     */
    public function getStatusCode();

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

    /**
     * Renders all headers and the content of the response object.
     * @return void
     */
    public function output();
}
