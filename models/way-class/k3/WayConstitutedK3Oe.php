<?php

/**
 * 快三单双
 *
 * @author white
 */
class WayConstitutedK3Oe extends WayBase {

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
            $aBetNumberForDisplay[] = $sNumber == 1 ? '单' : '双';
        }
        sort($aRealBetNumbers);
        $sBetNumber = implode(static::$splitChar, $aRealBetNumbers);
        return $bValid ? $aRealBetNumbers : false;

    }
    
    protected static function _isValid(& $sBetNumber){
        return in_array($sBetNumber, [0,1]);
    }
}
