<?php

namespace Signature\ViewHelper\Format;

use PHPUnit\Framework\TestCase;

class CropViewHelperTest extends TestCase
{
    /** @var CropViewHelper */
    private $viewhelper;

    protected function setUp(): void
    {
        $this->viewhelper = new CropViewHelper();
    }

    public function testRender()
    {
        $this->viewhelper->setArguments([
            'subject' => 'This is a test of the crop viewhelper.',
            'length' => 14,
            'suffix' => '!',
        ]);

        $this->assertEquals('This is a test!', $this->viewhelper->render());
    }

    public function testInvalidArgumentsThrowException()
    {
        $this->expectExceptionMessage('The argument "invalid" is not registered on ViewHelper "Signature\ViewHelper\Format\CropViewHelper". Valid arguments are subject, length, suffix.');
        $this->viewhelper->setArguments(['invalid' => 'test']);
    }

    public function testMissingArgumentsThrowException()
    {
        $this->expectExceptionMessage('Required argument "subject" missing in ViewHelper "Signature\ViewHelper\Format\CropViewHelper".');
        $this->viewhelper->setArguments(['suffix' => '!']);
    }
}