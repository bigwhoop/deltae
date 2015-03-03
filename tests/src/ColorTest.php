<?php
namespace Bigwhoop\Test\DeltaE;

use Bigwhoop\DeltaE\Color;

class ColorTest extends \PHPUnit_Framework_TestCase
{
    public function testHexToRGB()
    {
        $this->assertSame([255, 255, 255], Color::fromHex('#ffffff')->toRGB());
        $this->assertSame([0, 0, 0], Color::fromHex('#000000')->toRGB());
        $this->assertSame([254, 129, 60], Color::fromHex('#fe813c')->toRGB());
    }

    public function testHexToLAB()
    {
        $this->assertSame([100, 0, 0], Color::fromHex('#ffffff')->toLab());
        $this->assertSame([0, 0, 0], Color::fromHex('#000000')->toLab());
        $this->assertSame([67, 43, 57], Color::fromHex('#fe813c')->toLab());
        $this->assertSame([37, 37, 10], Color::fromHex('#913c4a')->toLab());
    }
}
