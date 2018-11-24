<?php

/**
 * 快三三同号
 *
 * @author white
 */
class MethodK3Same extends MethodBase {
    
    public static function getWinningNumber($sBaseWinningNumber){
        $a = str_split($sBaseWinningNumber);
        return max($a) == min($a) ? $sBaseWinningNumber : false;
    }
    
    public static function getWonCount($oMethod, $sWinningNumber, $sBetNumber){
//        pr($sWinningNumber);
//        pr($sBetNumber);
//        exit;
        $aBetNums = explode(static::$splitChar, $sBetNumber);
        return intval(in_array($sWinningNumber, $aBetNums));

//        return intval($sWinningNumber == $sBetNumber);
    }

}
