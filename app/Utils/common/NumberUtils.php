<?php
/**
 * User: ricardo
 * Date: 21/02/18
 */

namespace App\Utils;


final class NumberUtils {


    public static function sum($number1, $number2) {
        if(empty($number1) || empty($number2)) {
            throw new \Exception('Invalid Numbers');
        }
        return floatval($number1) + floatval($number2);
    }

}