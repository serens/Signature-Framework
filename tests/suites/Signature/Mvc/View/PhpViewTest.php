<?php

namespace Signature\Mvc\View;

use PHPUnit\Framework\TestCase;
use Signature\ViewHelper\ViewHelperInterface;

class PhpViewTest extends TestCase
{
    /** @var PhpView */
    private $view;

    protected function setUp(): void
    {
        $this->view = new PhpView();
    }

    public function testSettingAndGettingViewData()
    {
        $this->view->setViewData('test1', '123');
        $this->view->setViewData([
            'var1' => 'abc',
            'var2' => 123,
        ]);

        $this->assertEquals('123', $this->view->getViewData('test1'));
        $this->assertEquals('abc', $this->view->getViewData('var1'));
        $this->assertEquals(123, $this->view->getViewData('var2'));

        $this->assertEquals('123', $this->view->test1);
        $this->assertEquals('abc', $this->view->var1);
        $this->assertEquals(123, $this->view->var2);

        $this->expectException(\OutOfRangeException::class);
        $this->view->getViewData('failure');
    }

    public function testViewHelperInstantiationWithViewhelperNamespace()
    {
        $this->assertInstanceOf(
            ViewHelperInterface::class,
            $this->view->getViewHelperInstance('\Signature\Format\Crop')
        );
    }

    public function testViewHelperInstantiationWithoutViewhelperNamespace()
    {
        $this->assertInstanceOf(
            ViewHelperInterface::class,
            $this->view->getViewHelperInstance('\Signature\ViewHelper\Format\Crop')
        );
    }

    public function testSettingInvalidTemplate()
    {
        $this->expectExceptionMessage('Assigned template "invalid_template.phtml" cannot be loaded.');
        $this->view->setTemplate('invalid_template.phtml');
        $this->view->render();
    }

    public function testRender()
    {
        $this->view->setViewData('testName', get_class($this->view));
        $this->view->setTemplate(__DIR__ . '/../../../../helper/tpl/Templates/PhpViewTemplate.phtml');

        $this->assertEquals('This is a test of the Signature\Mvc\View\PhpView class.', $this->view->render());
    }
}