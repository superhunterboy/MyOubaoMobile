<?php

/**
 * 快三大小
 *
 * @author white
 */
class MethodK3Bs extends MethodBase {
    
    public static function getWinningNumber($sBaseWinningNumber){
        $a = str_split($sBaseWinningNumber);
        return intval(array_sum($a) > 10);
    }
    
    public static function getWonCount($oMethod, $sWinningNumber, $sBetNumber){
        return intval($sWinningNumber == $sBetNumber);
    }

}
