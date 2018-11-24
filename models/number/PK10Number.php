<?php

class PK10Number {

    public $number = '';
    private $attributes = [];
    private $digitals = [];
    private $uniqueDigitals = [];

    function __construct($sNumber) {
        $this->number = $sNumber;
        $this->compileAttributes();
    }

    function compileAttributes() {
        $this->digitals = explode(" ", $this->number);
    }

    function is3Diff() {
        return count($this->uniqueDigitals) == 3;
    }

    function is2Diff() {
        return count($this->uniqueDigitals) >= 2;
    }

    function is2same() {
        return count($this->uniqueDigitals) <= 2;
    }

    function is3same() {
        return count($this->uniqueDigitals) == 1;
    }

    function isBig($iIndex) {
        return $this->digitals[$iIndex] > 5;
    }

    function isOdd($iIndex) {
        return $this->digitals[$iIndex] % 2 == 1;
    }

    function isOrdered() {
        return max($this->digitals) - min($this->digitals) == 2 && count($this->uniqueDigitals) == 3;
    }

    function getSum() {
        return array_sum($this->digitals);
    }

    function getAttributes() {
        return $this->attributes;
    }

    function getDX($iIndex) {
        return intval($this->isBig($iIndex));
    }

    function getDS($iIndex) {
        return intval($this->isOdd($iIndex));
    }

    function getSumDXDS() {
        return intval($this->attributes['sum'] > 22) . intval($this->attributes['sum'] % 2 == 1);
    }

    function getDTS($firstIndex, $endIndex) {
        if ($this->digitals[$firstIndex] > $this->digitals[$endIndex]) {
            return 0;
        } else if ($this->digitals[$firstIndex] < $this->digitals[$endIndex]) {
            return 1;
        } else {
            return 2;
        }
    }

    function getSanXing($iIndex) {
        $aShunZi = ['012', '123', '234', '345', '456', '567', '678', '789', '089', '019'];
        $aBanShun = ['01', '12', '23', '34', '45', '56', '67', '78', '89', '09'];
        $aWnNumber = array_slice($this->digitals, $iIndex, 3);
        $aWnDigitals = array_unique($aWnNumber);

        $iCount = count($aWnDigitals);
        if ($iCount == 1) {
            //豹子
            return 4;
        } else if ($iCount == 2) {
            //对子
            return 1;
        } else if ($iCount == 3) {
            sort($aWnDigitals);
            $aBanshunQianerWnDigitals = [$aWnDigitals[0], $aWnDigitals[1]];
            $aBanshunHouerWnDigitals = [$aWnDigitals[1], $aWnDigitals[2]];
            $aBanshunYisanWnDigitals = [$aWnDigitals[0], $aWnDigitals[2]];
            if ($bWin = in_array(implode('', $aWnDigitals), $aShunZi)) {
                return 0;
            } else if ($bWin = in_array(implode('', $aBanshunQianerWnDigitals), $aBanShun) || $bWin = in_array(implode('', $aBanshunHouerWnDigitals), $aBanShun) || $bWin = in_array(implode('', $aBanshunYisanWnDigitals), $aBanShun)) {
                return 2;
            } else {
                return 3;
            }
        }
    }

    function getDigitals() {
        return $this->digitals;
    }

    function getUniqueDigitals() {
        return $this->uniqueDigitals;
    }

    static function compileNumber() {
        for ($i = 0, $a = []; $i < 3; $a[$i++] = mt_rand(1, 6))
            ;
        sort($a);
        return implode($a);
    }

}
