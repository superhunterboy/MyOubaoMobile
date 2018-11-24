<?php

/**
 * 快三二同号
 *
 * @author white
 */
class MethodK3TwoSameMany extends MethodBase {
    
    public static function getWinningNumber($sBaseWinningNumber){
        $a = str_split($sBaseWinningNumber);
        $aValues = array_count_values($a);
//        pr($aValues);
        if (count($aValues) < 3){
            arsort($aValues);
            list($iDoubleNum, $iCount) = each($aValues);
            return $iDoubleNum . $iDoubleNum;
        }
        return false;
    }

    public static function getWonCount($oMethod, $sWinningNumber, $sBetNumber){
        $sPattern = '/' . $sWinningNumber . '/';
        return preg_match($sPattern, $sBetNumber);
    }
    
}
