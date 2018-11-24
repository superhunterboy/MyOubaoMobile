<?php

class Withdraw extends BaseTask {

    protected $a_do_list = null;

    protected function doCommand()
    {
        return self::TASK_SUCCESS;
        $a_processling_list = $this->data;
        var_dump($this->data);

        $o_mc_order = new McOrder();
        $return = $o_mc_order->_doWithdrawOrderCliProcess($a_processling_list);

        echo "--------最终结果------\n";
        var_dump($return);
        echo "----------------------\n";

        return $return;

        return $return ? self::TASK_SUCCESS : self::TASK_KEEP;
    }

}
