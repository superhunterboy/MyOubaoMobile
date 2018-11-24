<?php

/**
 * 快三二同号
 *
 * @author white
 */
class MethodK3TwoSame extends MethodBase {
    
    public static function getWinningNumber($sBaseWinningNumber){
        $a = str_split($sBaseWinningNumber);
        $aValues = array_count_values($a);
        if (count($aValues) == 2){
            arsort($aValues);
            list($iDoubleNum, $iCount) = each($aValues);
//            if (count($aValues) == 2){
                list($iSingleNum, $iCount) = each($aValues);
//            }
//            else{
//                $iSingleNum = $iDoubleNum;
//            }
            return [$iDoubleNum, $iSingleNum];
        }
        return false;
    }

    public static function getWonCount($oMethod, $aWinningNumber, $sBetNumber){
        $sPattern = '/' . $aWinningNumber[0] . '{1}.*\|.*' . $aWinningNumber[1] . '{1}.*/';
        return preg_match($sPattern, $sBetNumber);
    }
    
}
