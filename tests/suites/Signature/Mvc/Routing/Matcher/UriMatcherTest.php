<?php

namespace Signature\Mvc\Routing\Matcher;

use PHPUnit\Framework\TestCase;
use Signature\Mvc\Request;

class UriMatcherTest extends TestCase
{
    /** @var UriMatcher */
    private $matcher;

    protected function setUp(): void
    {
        $this->matcher = new UriMatcher();
        $this->matcher->addRouteConfiguration(['/static'], 'StaticController', 'static');
        $this->matcher->addRouteConfiguration(['/test/number/#param'], 'NumberController', 'number');
        $this->matcher->addRouteConfiguration(['/test/array/@params'], 'ArrayController', 'array');
        $this->matcher->addRouteConfiguration(['/test/string/$param'], 'StringController', 'string');
        $this->matcher->addRouteConfiguration(['/test/combined/#param1/$param2/@param3'], 'CombinedController', 'combined');
    }

    public function testStaticUriMatched()
    {
        $request = (new Request())->setRequestUri('/static');
        $matched = $this->matcher->match($request);

        $this->assertEquals('StaticController', $request->getControllerName());
        $this->assertEquals('static', $request->getControllerActionName());
        $this->assertEquals(true, $matched);
    }

    public function testUriWithCombinedPlaceholdersMatched()
    {
        $request = (new Request())->setRequestUri('/test/combined/272123/TheTestString/a;b;c;d');
        $matched = $this->matcher->match($request);

        $this->assertEquals('CombinedController', $request->getControllerName());
        $this->assertEquals('combined', $request->getControllerActionName());
        $this->assertEquals('272123', $request->getControllerActionParameters()['param1']);
        $this->assertEquals('TheTestString', $request->getControllerActionParameters()['param2']);
        $this->assertIsArray($request->getControllerActionParameters()['param3']);
        $this->assertEquals('a', $request->getControllerActionParameters()['param3'][0]);
        $this->assertEquals('b', $request->getControllerActionParameters()['param3'][1]);
        $this->assertEquals('c', $request->getControllerActionParameters()['param3'][2]);
        $this->assertEquals('d', $request->getControllerActionParameters()['param3'][3]);
        $this->assertEquals(true, $matched);
    }

    public function testUriWithStringPlaceholderMatched()
    {
        $request = (new Request())->setRequestUri('/test/string/TheTestString');
        $matched = $this->matcher->match($request);

        $this->assertEquals('StringController', $request->getControllerName());
        $this->assertEquals('string', $request->getControllerActionName());
        $this->assertEquals('TheTestString', $request->getControllerActionParameters()['param']);
        $this->assertEquals(true, $matched);
    }

    public function testUriWithNumberPlaceholderMatched()
    {
        $request = (new Request())->setRequestUri('/test/number/21567283');
        $matched = $this->matcher->match($request);

        $this->assertEquals('NumberController', $request->getControllerName());
        $this->assertEquals('number', $request->getControllerActionName());
        $this->assertEquals('21567283', $request->getControllerActionParameters()['param']);
        $this->assertEquals(true, $matched);
    }

    public function testUriWithArrayPlaceholderMatched()
    {
        $requestUris = ['/test/array/a;b;c;d', '/test/array/a,b,c,d', '/test/array/a:b:c:d', '/test/array/a|b|c|d'];

        foreach ($requestUris as $requestUri) {
            $this->processSingleArrayRequestUri($requestUri);
        }
    }

    public function testUnknownUriNotMatched()
    {
        $request = (new Request())->setRequestUri('/unknownuri');
        $matched = $this->matcher->match($request);

        $this->assertEquals(false, $matched);
    }

    private function processSingleArrayRequestUri(string $requestUri)
    {
        $request = (new Request())->setRequestUri($requestUri);
        $matched = $this->matcher->match($request);

        $this->assertEquals('ArrayController', $request->getControllerName());
        $this->assertEquals('array', $request->getControllerActionName());
        $this->assertIsArray($request->getControllerActionParameters()['params']);
        $this->assertEquals('a', $request->getControllerActionParameters()['params'][0]);
        $this->assertEquals('b', $request->getControllerActionParameters()['params'][1]);
        $this->assertEquals('c', $request->getControllerActionParameters()['params'][2]);
        $this->assertEquals('d', $request->getControllerActionParameters()['params'][3]);
        $this->assertEquals(true, $matched);
    }
}