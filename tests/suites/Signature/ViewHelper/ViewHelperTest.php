<?php

namespace Signature\ViewHelper;

use PHPUnit\Framework\TestCase;

class ViewHelperTest extends TestCase
{
    public function testCustomViewHelperWithValidObjectAsArgument()
    {
        $output = (new MockViewHelper())
            ->setArguments(['date' => new \DateTime('1977-12-26')])
            ->render();

        $this->assertEquals('Date: 26.12.1977', $output);
    }

    public function testCustomViewHelperWithInvalidObjectAsArgumentThrowsException()
    {
        $viewhelper = new MockViewHelper();

        $this->expectExceptionMessage('Argument "date" must be of type "DateTime", but "DateInterval" given in ViewHelper "Signature\ViewHelper\MockViewHelper".');

        $viewhelper->setArguments([
            'date' => new \DateInterval('P1Y')
        ]);
    }
}

class MockViewHelper extends AbstractViewHelper
{
    public function __construct()
    {
        $this->argumentDescriptions = [
            'date' => new ArgumentDescription(true, \DateTime::class),
        ];

        parent::__construct();
    }

    public function render(): string
    {
        return 'Date: ' . date('d.m.Y', $this->getArgument('date')->getTimestamp());
    }
}