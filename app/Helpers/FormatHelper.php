<?php

if (! function_exists('shorten_number')) {
    function shorten_number($number, $precision = 3, $divisors = null): string
    {
        if (!isset($divisors)) {
            $divisors = array(
                1000 ** 0 => '', // 1000^0 == 1
                1000 ** 1 => 'K', // Thousand
                1000 ** 2 => 'M', // Million
                1000 ** 3 => 'B', // Billion
                1000 ** 4 => 'T', // Trillion
                1000 ** 5 => 'Qa', // Quadrillion
                1000 ** 6 => 'Qi', // Quintillion
            );
        }

        foreach ($divisors as $divisor => $shorthand) {
            if (abs($number) < ($divisor * 1000)) {
                break;
            }
        }

        if (strlen($number) <= 3) {
            $precision = 0;
        }

        return number_format($number / $divisor, $precision, ',', '.') . $shorthand;
    }
}
