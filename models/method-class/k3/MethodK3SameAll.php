<?php

/**
 * 快三三同号
 *
 * @author white
 */
class MethodK3SameAll extends MethodBase {
    
    public static function getWinningNumber($sBaseWinningNumber){
        $a = str_split($sBaseWinningNumber);
        return max($a) == min($a) ? 1 : false;
    }
    
    public static function getWonCount($oMethod, $sWinningNumber, $sBetNumber){
        return intval($sWinningNumber == $sBetNumber);
    }

}
