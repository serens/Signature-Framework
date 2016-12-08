<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc\Routing\Matcher;

use Signature\Mvc\RequestInterface;

/**
 * Class DefaultMatcher
 * @package Signature\Mvc\Routing\Matcher
 */
class DefaultMatcher extends AbstractMatcher
{
    /**
     * Matches a given request to a controller and action.
     * @param RequestInterface $request
     * @return bool
     */
    public function match(RequestInterface $request): bool
    {
        $matched = false;

        if ($request->getParameter('controller') !== null) {
            $matched = true;
            $request->setControllerName($request->getParameter('controller'));
        }

        if ($request->getParameter('action') !== null) {
            $request->setControllerActionName($request->getParameter('action'));
        }

        return $matched;
    }
}
