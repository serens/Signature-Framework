<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc\Routing\Matcher;

/**
 * Class AbstractMatcher
 * @package Signature\Mvc\Routing\Matcher
 */
abstract class AbstractMatcher implements MatcherInterface
{
    /**
     * @var array
     */
    protected $routeConfiguration = [];

    /**
     * Adds a routing configuration to this type of matcher.
     * @param array $uris
     * @param string $controllerClassname
     * @param string $actionName
     * @return MatcherInterface
     */
    public function addRouteConfiguration(array $uris, string $controllerClassname, string $actionName): MatcherInterface
    {
        $this->routeConfiguration[] = [
            'Uris'                => $uris,
            'ControllerClassname' => $controllerClassname,
            'ActionName'          => $actionName
        ];

        return $this;
    }
}
