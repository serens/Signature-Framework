<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc\Routing\Matcher;

use Signature\Mvc\RequestInterface;

/**
 * Class UriMatcher
 * @package Signature\Mvc\Routing\Matcher
 */
class UriMatcher extends AbstractMatcher
{
    /**
     * @var string
     */
    const URI_PART_STRING = '$';

    /**
     * @var string
     */
    const URI_PART_NUMBER = '#';

    /**
     * @var string
     */
    const URI_PART_OBJECT = '(';

    /**
     * @var string
     */
    const URI_PART_ARRAY = '@';

    /**
     * @var array
     */
    protected $validUriPartIdentifierChars = [
        self::URI_PART_NUMBER,
        self::URI_PART_STRING,
        self::URI_PART_OBJECT,
        self::URI_PART_ARRAY,
    ];

    /**
     * Matches a given request to a controller and action.
     * @param RequestInterface $request
     * @return bool
     */
    public function match(RequestInterface $request): bool
    {
        foreach ($this->routeConfiguration as $routeConfiguration) {
            foreach ($routeConfiguration['Uris'] as $testUri) {
                if ($this->matchSingleUri($testUri, $request)) {
                    $request->setControllerName($routeConfiguration['ControllerClassname']);

                    if (!empty($routeConfiguration['ActionName'])) {
                        $request->setControllerActionName($routeConfiguration['ActionName']);
                    }

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Matches a given uri against a route-configuration.
     * @param string $uri
     * @param RequestInterface $request
     * @return bool
     */
    protected function matchSingleUri(string $uri, RequestInterface $request): bool
    {
        // First simple test: Given uri matches exact the configured route.
        $requestUri = $this->prepareUri($request->getRequestUri());

        if ($uri === $requestUri) {
            return true;
        }

        // Second test. Uri-Parts match configured route.
        $uriParts        = explode('/', $uri);
        $requestUriParts = explode('/', $requestUri);
        $parameters      = [];
        $matchCount      = 0;

        if (count($uriParts) != count($requestUriParts)) {
            return false;
        }

        for ($i = 0; $i < count($uriParts); $i++) {
            if ($this->matchUriPart($uriParts[$i], $requestUriParts[$i], $parameters)) {
                $matchCount++;
            } else {
                break;
            }
        }

        $request->setControllerActionParameters($parameters);

        return $matchCount == count($uriParts);
    }

    /**
     * Prepares a given url by decoding it and removing Uri-arguments from it.
     * @param string $uri
     * @return string
     */
    protected function prepareUri(string $uri): string
    {
        $uri = urldecode($uri);

        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }

        return $uri;
    }

    /**
     * @param string $uriPart
     * @param string $requestUriPart
     * @param array $parameters
     * @return bool
     */
    protected function matchUriPart(string $uriPart, string $requestUriPart, array &$parameters): bool
    {
        if ($uriPart == $requestUriPart) {
            return true;
        }

        if (($identChar = substr($uriPart, 0, 1)) && in_array($identChar, $this->validUriPartIdentifierChars)) {
            switch ($identChar) {
                case self::URI_PART_STRING:
                    $parameterName = substr($uriPart, 1);
                    $parameters[$parameterName] = $requestUriPart;

                    return true;

                case self::URI_PART_NUMBER:
                    if (is_numeric($requestUriPart)) {
                        $parameterName = substr($uriPart, 1);
                        $parameters[$parameterName] = (int) $requestUriPart;

                        return true;
                    }

                    break;

                case self::URI_PART_OBJECT:
                    if ($instance = $this->resolveObjectClass($uriPart, $requestUriPart)) {
                        $parameterName = substr($uriPart, strpos($uriPart, ')') + 1);
                        $parameters[$parameterName] = $instance;

                        return true;
                    }

                    break;

                case self::URI_PART_ARRAY:
                    $parameterName = substr($uriPart, 1);
                    $values        = [$requestUriPart];

                    foreach ([';', ',', ':', '|'] as $separator) {
                        if (false !== strpos($requestUriPart, $separator)) {
                            $values = explode($separator, $requestUriPart);
                            break;
                        }
                    }

                    $parameters[$parameterName] = $values;

                    return true;
            }
        }

        return false;
    }

    /**
     * Tries to parse an uri part in a form like "(DateTime)myParam".
     * @param string $uriPart
     * @param string $requestUriPart
     * @return object|null
     */
    protected function resolveObjectClass(string $uriPart, string $requestUriPart)
    {
        if (1 === preg_match('/\((.*?)\)/', $uriPart, $objectClassname)) {
            if (is_a($objectClassname[1], \Signature\Persistence\ActiveRecord\AbstractModel::class, true)) {
                $objectProviderService = \Signature\Object\ObjectProviderService::getInstance();

                /** @var \Signature\Persistence\ActiveRecord\AbstractModel $instance */
                $instance = $objectProviderService->create($objectClassname[1]);
                $instance->find((int) $requestUriPart);
            } else {
                $instance = new $objectClassname[1]($requestUriPart);
            }

            return $instance;
        }
    }
}
