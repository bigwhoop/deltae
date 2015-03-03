# Delta E color closeness algorithm

[![Build Status](https://travis-ci.org/bigwhoop/deltae.svg?branch=master)](https://travis-ci.org/bigwhoop/deltae)
[![Code Coverage](https://scrutinizer-ci.com/g/bigwhoop/deltae/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/bigwhoop/deltae/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bigwhoop/deltae/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bigwhoop/deltae/?branch=master)

Composer-ready port of https://github.com/renasboy/php-color-difference with some more sugar.

## Installation

    composer require "bigwhoop/deltae":"~1"

## Usage

    use Bigwhoop\DeltaE\Color;
    use Bigwhoop\DeltaE\DeltaE;
    
    $deltaE = new DeltaE();
    
    $c1 = Color::fromHex('#333333');
    $c2 = Color::fromHex('#666666');
    $closeness = $deltaE->cie2000($c1, $c2);
    var_dump($closeness);

## License

See LICENSE file.