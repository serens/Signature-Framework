<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc\Routing;

use Signature\Mvc\Routing\Matcher\MatcherInterface;

/**
 * Class Router
 * @package Signature\Mvc\Routing
 */
class Router
{
    use \Signature\Object\ObjectProviderServiceTrait;

    /**
     * @var array
     */
    protected $matchers = null;

    /**
     * @var array
     */
    protected $matcherConfig = [];

    /**
     * Accepts an array with matchers and their assigned routes.
     * @param array $matcherConfig
     */
    public function __construct(array $matcherConfig)
    {
        $this->matcherConfig = $matcherConfig;
    }

    /**
     * Matches a given request to a controller and action.
     * @param \Signature\Mvc\RequestInterface $request
     * @throws \Signature\Mvc\Routing\Exception\NoRouteFoundException When no route could be matched.
     * @return boolean
     */
    public function match(\Signature\Mvc\RequestInterface $request)
    {
        /** @var $matcher Matcher\MatcherInterface */
        foreach ($this->getMatchers() as $matcher) {
            if ($matcher->match($request)) {
                return true;
            }
        }

        throw new Exception\NoRouteFoundException();
    }

    /**
     * Returns the registered and already configured matchers.
     * @throws \UnexpectedValueException When a configured route or matcher is not valid.
     * @return array
     */
    protected function getMatchers()
    {
        if (null === $this->matchers) {
            foreach ($this->matcherConfig as $matcherClassname => $matcherConfiguration) {
                $matcherInstance = $this->objectProviderService->create($matcherClassname);

                if (!$matcherInstance instanceof MatcherInterface) {
                    throw new \UnexpectedValueException(
                        'Registered matcher "' . $matcherClassname . '" does not implement \Signature\Mvc\Routing\Matcher\MatcherInterface.'
                    );
                }

                $configuredRoutes
                    = array_key_exists('Routes', $matcherConfiguration) ? $matcherConfiguration['Routes'] : [];

                foreach ($configuredRoutes as $routeName => $routeConfiguration) {
                    $this->validateRouteConfiguration($routeName, $routeConfiguration);

                    $matcherInstance->addRouteConfiguration(
                        $routeConfiguration['Uris'],
                        $routeConfiguration['ControllerClassname'],
                        $routeConfiguration['ActionName']
                    );
                }

                $this->matchers[] = $matcherInstance;
            }
        }

        return $this->matchers;
    }

    /**
     * Validates a given route configuration an returns an array with invalid field, when found.
     * @param string $routeName
     * @param array $routeConfiguration
     * @throws \InvalidArgumentException When a configured route or matcher is not valid.
     * @return void
     */
    protected function validateRouteConfiguration($routeName, array $routeConfiguration)
    {
        foreach (['Uris', 'ControllerClassname', 'ActionName'] as $field) {
            if (empty($routeConfiguration[$field])) {
                throw new \InvalidArgumentException(sprintf(
                    'Route "%s" is not configured well. Field "%s" is missing or empty.',
                    $routeName,
                    $field
                ));
            }
        }
    }
}
