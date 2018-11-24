<?php

/**
 * 快三号码类
 *
 * @author white
 */
class XSSCNumber {

    public $number = '';
    private $attributes = [];
    private $digitals = [];
    private $uniqueDigitals = [];

    function __construct($sNumber) {
        $this->number = $sNumber;
        $this->compileAttributes();
    }

    function compileAttributes() {
        $this->digitals = str_split($this->number);
        $this->attributes['sum'] = $this->getSum();
//        $this->uniqueDigitals = array_unique($this->digitals);
//        $this->attributes['2diff'] = $this->is2Diff();
//        $this->attributes['2same'] = $this->is2same();
//        $this->attributes['3same'] = $this->is3same();
//        $this->attributes['odd'] = $this->isOdd();
//        $this->attributes['big'] = $this->isBig();
//        $this->attributes['ordered'] = $this->isOrdered();
//        $this->attributes['smallOdd'] = !$this->attributes['big'] && $this->attributes['odd'];
//        $this->attributes['smallEven'] = !$this->attributes['big'] && !$this->attributes['odd'];
//        $this->attributes['BigOdd'] = $this->attributes['big'] && $this->attributes['odd'];
//        $this->attributes['BigEven'] = $this->attributes['big'] && !$this->attributes['odd'];
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
        return $this->digitals[$iIndex] > 4;
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

    function getDXDS($iIndex) {
        return intval($this->isBig($iIndex)) . intval($this->isOdd($iIndex));
    }

    function getSumDXDS() {
        return intval($this->attributes['sum'] > 22) . intval($this->attributes['sum'] % 2 == 1);
    }

    function getDTS() {
        if ($this->digitals[0] > $this->digitals[4]) {
            return 0;
        } else if ($this->digitals[0] < $this->digitals[4]) {
            return 1;
        } else {
            return 2;
        }
    }

    function getSanXing($iIndex) {
        $aShunZi = ['012', '123', '234', '345', '456', '567', '678', '789', '089', '019'];
        $aBanShun = ['01', '12', '23', '34', '45', '56', '67', '78', '89', '09'];
        $aWnNumber = array_slice($this->digitals, $iIndex,3);
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
            } else if ($bWin = in_array(implode('', $aBanshunQianerWnDigitals), $aBanShun) 
                    || $bWin = in_array(implode('', $aBanshunHouerWnDigitals), $aBanShun)
                    || $bWin = in_array(implode('', $aBanshunYisanWnDigitals), $aBanShun)) {
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
