<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc\Routing;

/**
 * Class LinkBuilder
 * @package Signature\Mvc
 */
class LinkBuilder
{
    use \Signature\Configuration\ConfigurationServiceTrait;

    /**
     * Generates an uri to a route by a given identifier.
     * @param string $routeIdentifier
     * @param array $arguments
     * @throws \Signature\Mvc\Routing\Exception\NoRouteFoundException
     * @throws \RuntimeException
     * @return string
     */
    public function build($routeIdentifier, array $arguments = [])
    {
        $configuration = $this->getMatcherConfiguration($routeIdentifier);
        $uri = array_shift($configuration[$routeIdentifier]['Uris']);

        if (count($arguments)) {
            $uriParts = explode('/', $uri);

            foreach ($arguments as $argument => $argumentValue) {
                if ($key = array_search($argument, $uriParts)) {
                    unset($arguments[$argument]);

                    $uriParts[$key] = $argumentValue;
                }
            }

            $uri = implode('/', $uriParts);
        }

        // Any remaining argument will be added to the final link.
        if (count($arguments)) {
            $uri .= '?' . http_build_query($arguments);
        }

        return $uri;
    }

    /**
     * Gets the matcher configuration for a given route and validates this configuration.
     * @param string $routeIdentifier
     * @throws \RuntimeException
     * @throws \Signature\Mvc\Routing\Exception\NoRouteFoundException
     * @return array
     */
    protected function getMatcherConfiguration($routeIdentifier)
    {
        $matcherConfiguration = $this->configurationService->getConfigByPath(
            'Signature',
            'Mvc.Routing.Matcher.Signature\Mvc\Routing\Matcher\UriMatcher.Routes'
        );

        if (!array_key_exists($routeIdentifier, $matcherConfiguration)) {
            throw new \Signature\Mvc\Routing\Exception\NoRouteFoundException(
                'A route identified by "' . (string) $routeIdentifier . '" does not exist in any configuration.'
            );
        }

        if (!array_key_exists('Uris', $matcherConfiguration[$routeIdentifier])) {
            throw new \RuntimeException(
                'Route configuration of "' . (string) $routeIdentifier . '" is invalid due to missing field "Uris".'
            );
        }

        if (!is_array($matcherConfiguration[$routeIdentifier]['Uris'])) {
            throw new \RuntimeException(
                'Route configuration of "' . (string) $routeIdentifier . '" is invalid.'
            );
        }

        return $matcherConfiguration;
    }
}
