<?php
namespace Bigwhoop\DeltaE;

class DeltaE
{
    /**
     * @param Color $c1
     * @param Color $c2
     *
     * @return float
     */
    public function cie2000(Color $c1, Color $c2, $scale = 4)
    {
        list($l1, $a1, $b1) = $c1->toLAB();
        list($l2, $a2, $b2) = $c2->toLAB();

        $avg_lp     = ($l1 + $l2) / 2;
        $c1         = sqrt(pow($a1, 2) + pow($b1, 2));
        $c2         = sqrt(pow($a2, 2) + pow($b2, 2));
        $avg_c      = ($c1 + $c2) / 2;
        $g          = (1 - sqrt(pow($avg_c, 7) / (pow($avg_c, 7) + pow(25, 7)))) / 2;
        $a1p        = $a1 * (1 + $g);
        $a2p        = $a2 * (1 + $g);
        $c1p        = sqrt(pow($a1p, 2) + pow($b1, 2));
        $c2p        = sqrt(pow($a2p, 2) + pow($b2, 2));
        $avg_cp     = ($c1p + $c2p) / 2;
        $h1p        = rad2deg(atan2($b1, $a1p));
        if ($h1p < 0) {
            $h1p    += 360;
        }
        $h2p        = rad2deg(atan2($b2, $a2p));
        if ($h2p < 0) {
            $h2p    += 360;
        }
        $avg_hp     = abs($h1p - $h2p) > 180 ? ($h1p + $h2p + 360) / 2 : ($h1p + $h2p) / 2;
        $t          = 1 - 0.17 * cos(deg2rad($avg_hp - 30)) + 0.24 * cos(deg2rad(2 * $avg_hp)) + 0.32 * cos(deg2rad(3 * $avg_hp + 6)) - 0.2 * cos(deg2rad(4 * $avg_hp - 63));
        $delta_hp   = $h2p - $h1p;
        if (abs($delta_hp) > 180) {
            if ($h2p <= $h1p) {
                $delta_hp += 360;
            } else {
                $delta_hp -= 360;
            }
        }
        $delta_lp   = $l2 - $l1;
        $delta_cp   = $c2p - $c1p;
        $delta_hp   = 2 * sqrt($c1p * $c2p) * sin(deg2rad($delta_hp) / 2);

        $s_l        = 1 + ((0.015 * pow($avg_lp - 50, 2)) / sqrt(20 + pow($avg_lp - 50, 2)));
        $s_c        = 1 + 0.045 * $avg_cp;
        $s_h        = 1 + 0.015 * $avg_cp * $t;

        $delta_ro   = 30 * exp(-(pow(($avg_hp - 275) / 25, 2)));
        $r_c        = 2 * sqrt(pow($avg_cp, 7) / (pow($avg_cp, 7) + pow(25, 7)));
        $r_t        = -$r_c * sin(2 * deg2rad($delta_ro));

        $kl = $kc = $kh = 1;

        $delta_e    = sqrt(pow($delta_lp / ($s_l * $kl), 2) + pow($delta_cp / ($s_c * $kc), 2) + pow($delta_hp / ($s_h * $kh), 2) + $r_t * ($delta_cp / ($s_c * $kc)) * ($delta_hp / ($s_h * $kh)));

        return round($delta_e, $scale);
    }
}
