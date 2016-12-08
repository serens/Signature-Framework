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
     * @return ResponseInterface
     */
    public function setContent(string $content): ResponseInterface;

    /**
     * Adds header information to the response.
     * @param string $header
     * @param string $content
     * @return ResponseInterface
     */
    public function addToHeader(string $header, string $content): ResponseInterface;

    /**
     * Returns the specified header of the response-object.
     * @param string $header
     * @return string
     */
    public function getHeader(string $header): string;

    /**
     * Returns all header information.
     * @return array
     */
    public function getHeaders(): array;

    /**
     * Removes a header entry.
     * @param string $header
     * @return ResponseInterface
     */
    public function removeFromHeader(string $header): ResponseInterface;

    /**
     * Sets a new status code for the response object.
     * @param int $statusCode
     * @return ResponseInterface
     */
    public function setStatusCode(int $statusCode): ResponseInterface;

    /**
     * Returns the current status code of the response object.
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * Returns the actual contained content in the reponse-object.
     * @return string
     */
    public function getContent(): string;

    /**
     * Adds additional content to the already existing content.
     * @param string $content
     * @return ResponseInterface
     */
    public function appendContent(string $content): ResponseInterface;

    /**
     * Adds additional content to the beginning of the already existing content.
     * @param string $content
     * @return ResponseInterface
     */
    public function prependContent(string $content): ResponseInterface;

    /**
     * Renders all headers and the content of the response object.
     * @return void
     */
    public function output();
}
