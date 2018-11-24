<?php

/**
 * 快三二不同号
 *
 * @author white
 */
class MethodK3TwoDiff extends MethodBase {
    
    public static function getWinningNumber($sBaseWinningNumber){
        $a = array_unique(str_split($sBaseWinningNumber));
        return (count($a) > 1) ? $a : false;
    }

    public static function getWonCount($oMethod, $aWinningNumber, $sBetNumber){
//        pr($aWinningNumber);
//        pr($sBetNumber);
//        exit;
        $aBetNums = explode(static::$splitChar, $sBetNumber);
        $aIntersects = array_intersect($aWinningNumber, $aBetNums);
        return Math::combin(count($aIntersects),2);
    }

}
