<?php

namespace Signature\Mvc\Routing\Matcher;

use PHPUnit\Framework\TestCase;
use Signature\Mvc\Request;

class DefaultMatcherTest extends TestCase
{
    public function testControllerAndActionParametersGetResolved()
    {
        $request = (new Request())->setParameters(['controller' => 'TestController', 'action' => 'Test']);
        $matcher = new DefaultMatcher();

        $matcher->match($request);

        $this->assertEquals('TestController', $request->getControllerName());
        $this->assertEquals('test', $request->getControllerActionName());
    }

    public function testMissingActionParameterGetsMatchedToIndexAction()
    {
        $request = (new Request())->setParameters(['controller' => 'TestController']);
        $matcher = new DefaultMatcher();

        $matcher->match($request);

        $this->assertEquals('TestController', $request->getControllerName());
        $this->assertEquals('index', $request->getControllerActionName());
    }
}