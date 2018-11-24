<?php

/**
 * 快三三同号通选
 *
 * @author white
 */
class WayConstitutedK3SameAll extends WayBase {

    public static function count(& $sBetNumber, & $sDisplayBetNumber) {
        if (self::isValid($sBetNumber)){
            $sDisplayBetNumber = '三同号通选';
            return 1;
        }
        return 0;
    }
    
    public static function checkPrize($sWnNumber, $sBetNumber) {
        ;
    }
    
    public static function isValid(& $sBetNumber, & $aBetNumberForDisplay = null){
        $sBetNumber = '1';
        return true;
    }
    
    protected static function _isValid(& $sBetNumber){
        $sBetNumber = preg_replace('/[^1-6]/', '', $sBetNumber);
        return $sBetNumber >= 1 && $sBetNumber <= 6;
    }
}
