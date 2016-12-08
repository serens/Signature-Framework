<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc\Routing\Matcher;

use Signature\Mvc\RequestInterface;

/**
 * Interface MatcherInterface
 * @package Signature\Mvc\Routing\Matcher
 */
interface MatcherInterface
{
    /**
     * Matches a given request to a controller and action.
     * @param RequestInterface $request
     * @throws \Signature\Mvc\Routing\Exception\NoRouteFoundException When no route could be matched.
     * @return bool
     */
    public function match(RequestInterface $request): bool;

    /**
     * Adds a routing configuration to this type of matcher.
     * @param array $uris
     * @param string $controller
     * @param string $actionName
     * @return MatcherInterface
     */
    public function addRouteConfiguration(array $uris, string $controller, string $actionName): MatcherInterface;
}
