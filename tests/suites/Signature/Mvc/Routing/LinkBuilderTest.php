<?php

namespace Signature\Mvc\Routing;

use PHPUnit\Framework\TestCase;
use Signature\Configuration\ConfigurationService;
use Signature\Mvc\Routing\Exception\NoRouteFoundException;

class LinkBuilderTest extends TestCase
{
    public function testBuildingLinksBasedOnRoutesConfiguration()
    {
        $linkBuilder = new LinkBuilder();
        $configurationService = (new ConfigurationService())->setConfigByPath(
            'Signature',
            'Mvc.Routing.Matcher.Signature\Mvc\Routing\Matcher\UriMatcher.Routes',
            [
                'test:static' => [
                    'Uris' => ['/test'],
                ],
                'test:withParam' => [
                    'Uris' => ['/test/$param'],
                ],
                'test:withMoreParams' => [
                    'Uris' => ['/test/$param1/#param2'],
                ],
            ]
        );

        $linkBuilder->setConfigurationService($configurationService);

        $this->assertEquals('/test', $linkBuilder->build('test:static'));
        $this->assertEquals('/test?a=b&c=d', $linkBuilder->build('test:static', ['a' => 'b', 'c' => 'd']));
        $this->assertEquals('/test?a%5Bb%5D=c', $linkBuilder->build('test:static', ['a' => [ 'b' => 'c' ]]));
        $this->assertEquals('/test?slug=%2Fslug%2Fshouldbe%2Fescaped%2F', $linkBuilder->build('test:static', ['slug' => '/slug/shouldbe/escaped/']));
        $this->assertEquals('/test/TestParam', $linkBuilder->build('test:withParam', ['$param' => 'TestParam']));
        $this->assertEquals('/test/TestParam?a=b', $linkBuilder->build('test:withParam', ['$param' => 'TestParam', 'a' => 'b']));
        $this->assertEquals('/test/String/344634', $linkBuilder->build('test:withMoreParams', ['$param1' => 'String', '#param2' => '344634']));

        $this->expectException(NoRouteFoundException::class);
        $linkBuilder->build('invalididentifier');
    }
}