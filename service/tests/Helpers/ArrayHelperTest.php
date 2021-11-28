<?php

namespace Helpers;

use App\Helpers\ArrayHelper;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Helpers\ArrayHelper
 * Class ArrayHelperTest
 */
class ArrayHelperTest extends TestCase
{
    /**
     * @covers \App\Helpers\ArrayHelper::findValue
     */
    public function testFindValue()
    {
        $orderedFields = ['general', 'invalid'];
        $value = [
            'general' => [
                'invalid' => 'x',
                'test' => 'y'
            ]
        ];

        $value = ArrayHelper::findValue($orderedFields, $value);

        $this->assertEquals('x', $value);
    }

}