<?php

/**
 * 快三二同号复选
 *
 * @author white
 */
class WayConstitutedK3TwoSameMany extends WayBase {

    public static function count(& $sBetNumber, & $sDisplayBetNumber) {
        if ($aBetNumbers = self::isValid($sBetNumber)){
//            $sBetNumber = implode(static::$splitChar, $aBetNumbers);
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
        $aRealBetNumbers = [];
        foreach($aBetNumbers as $sNumber){
            if (!$bValid = self::_isValid($sNumber)){
                break;
            }
            $aRealBetNumbers[] = str_repeat($sNumber,2);
        }
        sort($aRealBetNumbers);
        $sBetNumber = implode(static::$splitChar, $aRealBetNumbers);
        return $bValid ? $aBetNumbers : false;
    }
    
    protected static function _isValid(& $sBetNumber){
        $sBetNumber = preg_replace('/[^1-6]/', '', $sBetNumber);
        return $sBetNumber >= 1 && $sBetNumber <= 6;
    }
}
