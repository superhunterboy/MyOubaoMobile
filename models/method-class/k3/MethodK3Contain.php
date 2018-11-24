<?php

/**
 * Description of MethodK3Contain
 *
 * @author white
 */
class MethodK3Contain extends MethodBase {
    public static function getWinningNumber($sBaseWinningNumber){
        $a = str_split($sBaseWinningNumber);
        return array_unique($a);
    }

    public static function getWonCount($oMethod, $aWinningNumber, $sBetNumber){
//        pr($aWinningNumber);
//        pr($sBetNumber);
//        exit;
        $aBetNums = explode(static::$splitChar, $sBetNumber);
        $aIntersects = array_intersect($aWinningNumber, $aBetNums);
//        pr(count($aIntersects));
//        exit;
        return count($aIntersects);

//        return intval($sWinningNumber == $sBetNumber);
    }

}
