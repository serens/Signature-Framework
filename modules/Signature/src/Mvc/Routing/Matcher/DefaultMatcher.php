<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc\Routing\Matcher;

/**
 * Class DefaultMatcher
 * @package Signature\Mvc\Routing\Matcher
 */
class DefaultMatcher extends AbstractMatcher
{
    /**
     * Matches a given request to a controller and action.
     * @param \Signature\Mvc\RequestInterface $request
     * @return boolean
     */
    public function match(\Signature\Mvc\RequestInterface $request)
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
