<?php

/**
 * 快三三连号
 *
 * @author white
 */
class WayConstitutedK3Ordered extends WayBase {

    public static function count(& $sBetNumber, & $sDisplayBetNumber) {
        $sBetNumber = 1;
        $sDisplayBetNumber = '三连号通选';
        return 1;
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
            $aRealBetNumbers[] = $sNumber;
        }
        sort($aRealBetNumbers);
        $sBetNumber = implode(static::$splitChar, $aRealBetNumbers);
        return $bValid ? $aRealBetNumbers : false;
    }
    
    protected static function _isValid(& $sBetNumber){
        $sBetNumber = preg_replace('/[^1-6]/', '', $sBetNumber);
        return $sBetNumber >= 1 && $sBetNumber <= 6;
    }
}
