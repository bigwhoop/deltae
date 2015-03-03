<?php
namespace Bigwhoop\DeltaE;

class Color
{
    /** @var int */
    private $r = 0;

    /** @var int */
    private $g = 0;

    /** @var int */
    private $b = 0;

    /**
     * @param string $hex
     *
     * @return Color
     */
    public static function fromHex($hex)
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) < 6) {
            throw new \InvalidArgumentException("Hex string must be at least 6 digits without a leading #.");
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return new self($r, $g, $b);
    }

    /**
     * @param int $r
     * @param int $g
     * @param int $b
     */
    public function __construct($r, $g, $b)
    {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
    }

    /**
     * The Rgb color space consists of all possible colors that can be made by the combination of red, green, and blue
     * light. It's a popular model in photography, television, and computer graphics.
     *
     * @return array
     */
    public function toRGB()
    {
        return [$this->r, $this->g, $this->b];
    }

    /**
     * Cie-L*ab is defined by lightness and the color-opponent dimensions a and b, which are based on the compressed
     * Xyz color space coordinates.
     *
     * @return array
     */
    public function toLab()
    {
        $xyz = $this->toXYZ();

        return $this->xyz2lab($xyz);
    }

    /**
     * @return array
     */
    public function toXYZ()
    {
        $r = $this->r / 255;
        $g = $this->g / 255;
        $b = $this->b / 255;

        $r = $r <= 0.04045 ? $r / 12.92 : pow(($r + 0.055) / 1.055, 2.4);
        $g = $g <= 0.04045 ? $g / 12.92 : pow(($g + 0.055) / 1.055, 2.4);
        $b = $b <= 0.04045 ? $b / 12.92 : pow(($b + 0.055) / 1.055, 2.4);

        $r *= 100;
        $g *= 100;
        $b *= 100;

        $x = $r * 0.412453 + $g * 0.357580 + $b * 0.180423;
        $y = $r * 0.212671 + $g * 0.715160 + $b * 0.072169;
        $z = $r * 0.019334 + $g * 0.119193 + $b * 0.950227;

        return [$x, $y, $z];
    }

    /**
     * @param array $xyz
     *
     * @return array
     */
    private function xyz2lab(array $xyz)
    {
        list($x, $y, $z) = $xyz;

        $x /= 95.047;
        $y /= 100;
        $z /= 108.883;

        $x = $x > 0.008856 ? pow($x, 1 / 3) : $x * 7.787 + 16 / 116;
        $y = $y > 0.008856 ? pow($y, 1 / 3) : $y * 7.787 + 16 / 116;
        $z = $z > 0.008856 ? pow($z, 1 / 3) : $z * 7.787 + 16 / 116;

        $l = $y * 116 - 16;
        $a = ($x - $y) * 500;
        $b = ($y - $z) * 200;

        return [(int) round($l), (int) round($a), (int) round($b)];
    }
}
