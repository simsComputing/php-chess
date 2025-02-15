<?php

namespace Chess\Variant\Capablanca100\PGN\AN;

use Chess\Variant\Classical\PGN\AN\Square as ClassicalSquare;

/**
 * Square.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Square extends ClassicalSquare
{
    const REGEX = '[a-j]{1}(10|[1-9]?)';

    const SIZE = [
        'files' => 10,
        'ranks' => 10,
    ];

    const EXTRACT = '/[^a-j0-9 "\']/';
}
