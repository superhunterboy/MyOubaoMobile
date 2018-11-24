<?php

/**
 * 快三大小
 *
 * @author white
 */
class MethodK3Diff extends MethodBase {
    
    public static function getWinningNumber($sBaseWinningNumber){
        $a = array_unique(str_split($sBaseWinningNumber));
        sort($a);
        return count($a) == 3 ? implode($a) : false;
    }
    
    public static function getWonCount($oMethod, $sWinningNumber, $sBetNumber){
        $aBetNums = explode(static::$splitChar, $sBetNumber);
        $aWonNums = str_split($sWinningNumber);
        $aIntersects = array_intersect($aWonNums, $aBetNums);
        return intval(count($aIntersects) == 3);
    }

}
