<?php

/**
 * 快三和值
 *
 * @author white
 */
class MethodK3Sum extends MethodBase {
    
    public static function getWinningNumber($sBaseWinningNumber){
        $a = str_split($sBaseWinningNumber);
        return array_sum($a);
    }
    
    public static function getWonCount($oMethod, $sWinningNumber, $sBetNumber){
        $aBetSums = explode(static::$splitChar, $sBetNumber);
        return intval(in_array($sWinningNumber, $aBetSums));
    }
}
