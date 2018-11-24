<?php
/**
 * 当添加新的彩种时，更新所有的玩家开户链接的彩种奖金组字段
 */
class RegisterLinkPrizeGroupSetUpdator {
    const LOTTERY_TYPE_SSC = 1;
    const LOTTERY_TYPE_115 = 2;
    const LOTTERY_TYPE_K3 = 4;
    public function updatePrizeGroup () {
        // 先获取当前所有有效的彩种
        $aAllLotteries  = ManLottery::getAllLotteries();
        // pr($aAllLotteries);exit;
        $aAllLotteryIds = [];
        foreach ($aAllLotteries as $key => $value) {
            $aAllLotteryIds[]         = $value['id'];
            $aLotteries[$value['id']] = arrayToObject($value);
        }
        // 获取当前有效的开户链接
        $aAllInuseLinks = RegisterLink::where('status', '=', 0)->where('is_admin', '=', 0)->where('is_agent', '=', 0)
                        ->whereRaw(' (expired_at > ? or expired_at is null)', [Carbon::now()->toDateTimeString()])->get();
        // pr($aAllInuseLinks->toArray());exit;
        // pr($aLotteries);exit;
        $aSuccess = $aFailed = [];
        foreach($aAllInuseLinks as $key => $oRegisterLink) {
            $aExistLotteries  = json_decode($oRegisterLink->prize_group_sets);
            $aExistLotteryIds = [];
            $aRealLotteryPrizeGroups = [];
            // 获取每个开户链接的奖金组字段，并设置默认的时时彩或11选5的奖金组
            foreach($aExistLotteries as $key1 => $oPrizeGroup) {
                $aExistLotteryIds[] = $oPrizeGroup->lottery_id;
                if (! isset($aLotteries[$oPrizeGroup->lottery_id])) continue;
                $oLottery = $aLotteries[$oPrizeGroup->lottery_id];
                // if ($oPrizeGroup->lottery_id == 1) {
                if ($oLottery->type == static::LOTTERY_TYPE_SSC && (! isset($sCurrentSscLotteryId) || $oPrizeGroup->lottery_id < $sCurrentSscLotteryId)) {
                    $sDefaultSscPrizeGroup  = (string)$oPrizeGroup->prize_group;
                    $sCurrentSscLotteryId = $oPrizeGroup->lottery_id;
                }
                // } else if ($oPrizeGroup->lottery_id == 2) {
                if ($oLottery->type == static::LOTTERY_TYPE_115 && (! isset($sCurrent115LotteryId) || $oPrizeGroup->lottery_id < $sCurrent115LotteryId)) {
                    $sDefault11x5PrizeGroup = (string)$oPrizeGroup->prize_group;
                    $sCurrent115LotteryId = $oPrizeGroup->lottery_id;
                }
                // 剔除已删除的彩种的奖金组
                // if (in_array($oPrizeGroup->lottery_id, $aAllLotteryIds)) {
                    $aRealLotteryPrizeGroups[] = $oPrizeGroup;
                // }
            }
            // pr($sDefaultSscPrizeGroup);
            // pr($sDefault11x5PrizeGroup);
            // exit;
            // 获取新增的彩种id数组
            $aNotAddedLotteryIds = array_diff($aAllLotteryIds, $aExistLotteryIds);

            // pr($aNotAddedLotteryIds);
            // pr($aExistLotteries);
            // exit;
            // 添加新增的彩种的奖金组
            foreach($aNotAddedLotteryIds as $key3 => $value) {
                // pr(isset($aLotteries[$value]));exit;
                if (! isset($aLotteries[$value])) continue;
                $iLotteryType = $aLotteries[$value]->type;
                if ($iLotteryType == static::LOTTERY_TYPE_SSC) {
                    $sPrizeGroup = $sDefaultSscPrizeGroup;
                } else if ($iLotteryType == static::LOTTERY_TYPE_115) {
                    $sPrizeGroup = $sDefault11x5PrizeGroup;
                }
                $aRealLotteryPrizeGroups[] = ['lottery_id' => (int)$value, 'prize_group' => (string)($sPrizeGroup)];
            }
            // pr($aRealLotteryPrizeGroups);exit;
            $sNewPrizeGroupSet = json_encode($aRealLotteryPrizeGroups);
            if ($sNewPrizeGroupSet == $oRegisterLink->prize_group_sets) continue;
            if ($bSucc = $oRegisterLink->update(['prize_group_sets' => $sNewPrizeGroupSet]) ) {
                $aSuccess[] = $oRegisterLink->id;
            } else {
                $aFailed[] = $oRegisterLink->id;
            }
        }
        return ['succeed' => $aSuccess, 'failed' => $aFailed];
    }
}