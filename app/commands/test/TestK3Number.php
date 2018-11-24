<?php

/**
 * 快3号码测试类
 *
 * @author white
 */
use Symfony\Component\Console\Input\InputArgument;

class TestK3Number extends BaseCommand {
    protected $sFileName = 'Test';
    protected $name = 'test:k3number';
    protected $description = 'test';

    public function doCommand(& $sMsg = null){
        $number = $this->argument('number');

        $oK3Number = new K3Number($number);
        pr($oK3Number->getDigitals());
        pr($oK3Number->getUniqueDigitals());
        pr($oK3Number->getAttributes());
    }
    
    protected function getArguments() {
        return array(
            array('number', InputArgument::REQUIRED, null),
        );
    }

}
