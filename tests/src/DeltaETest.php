<?php
namespace Bigwhoop\Test\DeltaE;

use Bigwhoop\DeltaE\Color;
use Bigwhoop\DeltaE\DeltaE;

class DeltaETest extends \PHPUnit_Framework_TestCase
{
    public function testCIE2000Values()
    {
        $deltaE = new DeltaE();

        $c1 = Color::fromHex('#333333');
        $c2 = Color::fromHex('#333333');
        $this->assertSame(0.0000, $deltaE->cie2000($c1, $c2));

        $c1 = Color::fromHex('#333333');
        $c2 = Color::fromHex('#444444');
        $this->assertSame(5.8431, $deltaE->cie2000($c1, $c2));

        $c1 = Color::fromHex('#444444');
        $c2 = Color::fromHex('#333333');
        $this->assertSame(5.8431, $deltaE->cie2000($c1, $c2));

        $c1 = Color::fromHex('#333333');
        $c2 = Color::fromHex('#555555');
        $this->assertSame(11.4004, $deltaE->cie2000($c1, $c2));
    }

    public function testCIE200Comparisions()
    {
        $deltaE = new DeltaE();

        $this->assertGreaterThan(
            $deltaE->cie2000(Color::fromHex('#333333'), Color::fromHex('#333333')),
            $deltaE->cie2000(Color::fromHex('#333333'), Color::fromHex('#333334'))
        );
        $this->assertGreaterThan(
            $deltaE->cie2000(Color::fromHex('#333333'), Color::fromHex('#444444')),
            $deltaE->cie2000(Color::fromHex('#333333'), Color::fromHex('#555555'))
        );
        $this->assertGreaterThan(
            $deltaE->cie2000(Color::fromHex('#333333'), Color::fromHex('#444444')),
            $deltaE->cie2000(Color::fromHex('#555555'), Color::fromHex('#333333'))
        );
    }
}
