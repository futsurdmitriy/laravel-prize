<?php


namespace App\Utility;


class RandomUtility
{
    // Create a function to generate a random float number
    static function random_float($start_number = 0,$end_number = 1,$mul = 1000000)
    {
        // If start number is greater than end number then return false
        if ($start_number > $end_number) return false;
        // Return random float number
        return round(
            mt_rand(
                $start_number * $mul,
                $end_number * $mul)/$mul,
            2
        );
    }
}
