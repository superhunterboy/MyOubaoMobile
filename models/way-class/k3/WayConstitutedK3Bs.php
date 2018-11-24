<?php

/**
 * 快三大小
 *
 * @author white
 */
class WayConstitutedK3Bs extends WayBase {

    public static function count(& $sBetNumber, & $sDisplayBetNumber) {
        if ($aBetNumbers = self::isValid($sBetNumber,$aBetNumberForDisplay)){
            $sDisplayBetNumber = implode(static::$splitChar, $aBetNumberForDisplay);
            return count($aBetNumbers);
        }
        return 0;
    }
    
    public static function checkPrize($sWnNumber, $sBetNumber) {
        ;
    }
    
    public static function isValid(& $sBetNumber, & $aBetNumberForDisplay = null){
        if ($sBetNumber == '') return false;
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
            $aBetNumberForDisplay[] = $sNumber == 1 ? '大' : '小';
        }
        sort($aRealBetNumbers);
        $sBetNumber = implode(static::$splitChar, $aRealBetNumbers);
        return $bValid ? $aRealBetNumbers : false;

    }
    
    protected static function _isValid(& $sBetNumber){
        return in_array($sBetNumber, [0,1]);
    }
}
