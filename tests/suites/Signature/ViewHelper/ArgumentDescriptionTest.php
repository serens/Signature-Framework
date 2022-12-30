<?php

namespace Signature\ViewHelper;

use PHPUnit\Framework\TestCase;

class ArgumentDescriptionTest extends TestCase
{
    public function testConstructorArgumentsGetSanitized()
    {
        $description = new ArgumentDescription(false, 'Bool');
        $this->assertEquals('boolean', $description->getType());

        $description = new ArgumentDescription(false, 'Float');
        $this->assertEquals('double', $description->getType());

        $description = new ArgumentDescription(false, 'Int');
        $this->assertEquals('integer', $description->getType());
    }

    public function testScalarTypesAreSupported()
    {
        foreach (['string', 'integer', 'boolean', 'double', 'array', 'object'] as $scalarType) {
            $description = new ArgumentDescription(false, $scalarType);
            $this->assertEquals(true, $description->mustBeScalarType());
        }
    }
}