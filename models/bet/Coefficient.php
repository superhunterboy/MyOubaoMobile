<?php

class Coefficient {

    public static $coefficients = [
        '1.00' => '2元',
        '0.50' => '1元',
        '0.10' => '2角',
        '0.05' => '1角',
        '0.01' => '2分',
        '0.001' => '2厘'
    ];
    public static $MMCCoefficients = [
        '1.00' => '2元',
        '0.50' => '1元',
        '0.10' => '2角',
        '0.05' => '1角',
    ];
    public static $MobileCoefficients = [
        '1.00' => '2元',
        '0.10' => '2角',
        '0.01' => '2分',
    ];

    public static function getValidCoefficientValues() {
        return array_keys(self::$coefficients);
    }

    public static function getCoefficientText($key) {
        return static::$coefficients[formatNumber($key, 3)];
    }

}
