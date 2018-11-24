<?php

/**
 * 快三和值
 *
 */
class WaySumK3combin extends WayBase {

//    public static function compileBetNumber(& $sBetNumber, & $sDisplayBetNumber) {
//        return ($aBetNumbers = self::isValid($sBetNumber)) ? implode(static::$splitChar, $aBetNumbers) : '';
//    }
    
    public static function count(& $sBetNumber, & $sDisplayBetNumber) {
        if ($aBetNumbers = self::isValid($sBetNumber)){
            return count($aBetNumbers);
        }
        return 0;
    }
    
    public static function checkPrize($sWnNumber, $sBetNumber) {
        ;
    }
    
    public static function isValid(& $sBetNumber, & $aBetNumberForDisplay = null){
        if (!$sBetNumber) return false;
        if (!$aBetNumbers = array_unique(explode(static::$splitChar, $sBetNumber))){
            return false;
        }
        $bValid = true;
        foreach($aBetNumbers as $sNumber){
            if (!$bValid = self::_isValid($sNumber)){
                break;
            }
        }
        sort($aBetNumbers);
        $sBetNumber = implode(static::$splitChar, $aBetNumbers);
        return $bValid ? $aBetNumbers : false;
    }
    
    protected static function _isValid(& $sBetNumber){
        $p = '/\d{1,2}/';
        if (!preg_match($p, $sBetNumber)){
            return false;
        }
        if ($sBetNumber < 3 || $sBetNumber > 18){
            return false;
        }
        return true;
    }
}
