<?php

/**
 * 快三二同号单选
 *
 * @author white
 */
class WayConstitutedK3TwoSame extends WayBase {

    public static function count(& $sBetNumber, & $sDisplayBetNumber) {
        return ($iCount = self::isValid($sBetNumber)) ? $iCount : 0;
    }
    
    public static function isValid(& $sBetNumber, & $aBetNumberForDisplay = null){
        if (!$sBetNumber) return false;
        if (!$aBetNumbers = explode(static::$splitChar, $sBetNumber)){
            return false;
        }
        if (count($aBetNumbers) != 2){
            return false;
        }
        list($sDoubleNums, $sSingleNums) = $aBetNumbers;
        $sDoubleNums = preg_replace('/[^1-6]/', '', $sDoubleNums);
        $sSingleNums = preg_replace('/[^1-6]/', '', $sSingleNums);
        $aDoubleNums = array_unique(str_split($sDoubleNums, 1));
        $aSingleNums = array_unique(str_split($sSingleNums, 1));
        $iDoubleCount = count($aDoubleNums);
        $iSingleCount = count($aSingleNums);
        $iRepeatCount = count(array_intersect($aDoubleNums, $aSingleNums));
        $iCount = $iDoubleCount * $iSingleCount - $iRepeatCount;
        
        sort($aDoubleNums);
        sort($aSingleNums);
        $sDoubleNums = implode($aDoubleNums);
        $sSingleNums = implode($aSingleNums);
        $sBetNumber = $sDoubleNums . static::$splitChar . $sSingleNums;
        return $iCount;
    }
    
    public static function checkPrize($sWnNumber, $sBetNumber) {
        ;
    }

}
