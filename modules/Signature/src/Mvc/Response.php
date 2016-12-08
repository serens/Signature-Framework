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
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @var array
     */
    protected $validStatusCodes = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Request Range Not Satisfiable',
        417 => 'Expectation Failed',
        422 => 'Unprocessable Entity',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
    ];

    /**
     * Sets the full content of the reponse-object.
     * @param string $content
     * @return ResponseInterface
     */
    public function setContent(string $content): ResponseInterface
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Adds header information to the response.
     * @param string $header
     * @param string $content
     * @return ResponseInterface
     */
    public function addToHeader(string $header, string $content): ResponseInterface
    {
        $this->header[$header] = $content;

        return $this;
    }

    /**
     * Returns the specified header of the response-object.
     * @param string $header
     * @return string
     */
    public function getHeader(string $header): string
    {
        return array_key_exists($header, $this->header)
            ? $this->header[$header]
            : '';
    }

    /**
     * Returns all header information.
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->header;
    }

    /**
     * Removes a header entry.
     * @param string $header
     * @return ResponseInterface
     */
    public function removeFromHeader(string $header): ResponseInterface
    {
        if (array_key_exists($header, $this->header)) {
            unset($this->header[$header]);
        }

        return $this;
    }

    /**
     * Sets a new status code for the response object.
     * @param int $statusCode
     * @return ResponseInterface
     */
    public function setStatusCode(int $statusCode): ResponseInterface
    {
        if (!array_key_exists($statusCode, $this->validStatusCodes)) {
            user_error('Unknown HTTP status code "' . $statusCode . '" given.', E_USER_WARNING);
        }

        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Returns the current status code of the response object.
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Returns the actual contained content in the reponse-object.
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Adds additional content to the already existing content.
     * @param string $content
     * @return ResponseInterface
     */
    public function appendContent(string $content): ResponseInterface
    {
        $this->content .= $content;

        return $this;
    }

    /**
     * Adds additional content to the beginning of the already existing content.
     * @param string $content
     * @return ResponseInterface
     */
    public function prependContent(string $content): ResponseInterface
    {
        $this->content = $content . $this->content;

        return $this;
    }

    /**
     * Renders all headers and the content of the response object.
     * @return void
     */
    public function output()
    {
        if (!headers_sent()) {
            if (array_key_exists($this->statusCode, $this->validStatusCodes)) {
                header(
                    $_SERVER['SERVER_PROTOCOL'] . ' ' .
                    $this->statusCode . ' ' .
                    $this->validStatusCodes[$this->statusCode]
                );
            }

            foreach ($this->header as $header => $value) {
                header($header . ': ' . $value);
            }
        }

        echo $this->content;
    }
}
