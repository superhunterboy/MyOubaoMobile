<?php

/**
 * 快三单双
 *
 * @author white
 */
class MethodK3Oe extends MethodBase {
    
    public static function getWinningNumber($sBaseWinningNumber){
        $a = str_split($sBaseWinningNumber);
        return array_sum($a) % 2;
    }

    public static function getWonCount($oMethod, $sWinningNumber, $sBetNumber){
        return intval($sWinningNumber == $sBetNumber);
    }

}
