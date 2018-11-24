<?php

/*
 * 重置支付账号当日充值金额
 *
 * @author white
 */

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ResetPaymentAccounts  extends BaseCommand {
    
    protected $name = 'fund:reset-payment-accounts';
    protected $description = 'reset payment accounts';

    public function doCommand(& $sMsg = null) {
        $oPAccounts = PaymentAccount::all();
        foreach($oPAccounts as $oPAccount){
            $oPAccount->resetCurrentTotalAmount();
        }
    }

}
