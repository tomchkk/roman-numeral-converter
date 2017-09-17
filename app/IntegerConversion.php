<?php

namespace App;

use App\IntegerConversionInterface;

class IntegerConversion implements IntegerConversionInterface
{
    /**
     * Individual characters representing Roman numerals.
     *
     * @var array
     */
    const NUMERALS = array('I', 'V', 'X', 'L', 'C', 'D', 'M');

    /**
     * Converts a given integer value into its Roman numeral equivalent.
     *
     * The current implementation only supports integers ranging from 1 to 3999
     * (the counting system changes in the thousands).
     *
     * @param  int $integer The integer to convert
     *
     * @return null|string  Roman numerals representing the given integer value,
     *                      or null, if $integer is out of range
     */
    public function toRomanNumerals($integer)
    {
        // current requirement precludes conversion outside this range
        if ($integer < 1 || $integer > 3999) {
            return;
        }

        // reverse the order of digits in the given integer, so conversion is done
        // low to high - i.e.: in the order ones, tens, hundreds, thousands
        $digits = array_reverse(str_split($integer));

        // index of current base NUMERALS element - i.e. 'I', 'X', 'C' or 'M'
        $n = 0;

        // convert each $digit of $digits into its numeral representation
        $numerals = array_map(function (int $digit) use (&$n) {
            switch ($digit) {
                case 1: case 2: case 3:
                    $numeral = str_repeat(self::NUMERALS[$n], $digit);
                    break;
                case 4:
                    $numeral = self::NUMERALS[$n] . self::NUMERALS[$n + 1];
                    break;
                case 5:
                    $numeral = self::NUMERALS[$n + 1];
                    break;
                case 6: case 7: case 8:
                    $numeral = self::NUMERALS[$n + 1] . str_repeat(self::NUMERALS[$n], $digit - 5);
                    break;
                case 9:
                    $numeral = self::NUMERALS[$n] . self::NUMERALS[$n + 2];
                    break;
                default:
                    $numeral = '';
            }

            // increment NUMERALS index to next base
            $n += 2;

            return $numeral;
        }, $digits);

        return implode('', array_reverse($numerals));
    }
}
