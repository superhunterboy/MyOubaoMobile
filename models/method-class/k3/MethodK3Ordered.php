<?php

/**
 * 快三三连号
 *
 * @author white
 */
class MethodK3Ordered extends MethodBase {
    
    public static function getWinningNumber($sBaseWinningNumber){
        $a = str_split($sBaseWinningNumber);
        sort($a);
        return ($a[2] - $a[0] == 2 && $a[1] - $a[0] == 1) ? 1 : false;
    }
    
    public static function getWonCount($oMethod, $sWinningNumber, $sBetNumber){
        return intval($sWinningNumber == $sBetNumber);
    }
    
}
