<?php

/**
 * 快三号码类
 *
 * @author white
 */
class K3Number {
    
    public $number = '';
    private $attributes = [];
    private $digitals = [];
    private $uniqueDigitals = [];
    
    function __construct($sNumber) {
        $this->number = $sNumber;
        $this->compileAttributes();
    }
    
    function compileAttributes(){
        $this->digitals = str_split($this->number);
        $this->uniqueDigitals = array_unique($this->digitals);
        $this->attributes['3diff'] = $this->is3Diff();
        $this->attributes['2diff'] = $this->is2Diff();
        $this->attributes['2same'] = $this->is2same();
        $this->attributes['3same'] = $this->is3same();
        $this->attributes['odd'] = $this->isOdd();
        $this->attributes['big'] = $this->isBig();
        $this->attributes['sum'] = $this->getSum();
        $this->attributes['ordered'] = $this->isOrdered();
        $this->attributes['smallOdd'] = !$this->attributes['big'] && $this->attributes['odd'];
        $this->attributes['smallEven'] = !$this->attributes['big'] && !$this->attributes['odd'];
        $this->attributes['BigOdd'] = $this->attributes['big'] && $this->attributes['odd'];
        $this->attributes['BigEven'] = $this->attributes['big'] && !$this->attributes['odd'];
    }
    
    function is3Diff(){
        return count($this->uniqueDigitals) == 3;
    }
    
    function is2Diff(){
        return count($this->uniqueDigitals) >= 2;
    }
    
    function is2same(){
        return count($this->uniqueDigitals) <= 2;
    }

    function is3same(){
        return count($this->uniqueDigitals) == 1;
    }
    
    function isBig(){
        return array_sum($this->digitals) > 10;
    }

    function isOdd(){
        return array_sum($this->digitals) % 2 == 1;
    }

    function isOrdered(){
        return max($this->digitals) - min($this->digitals) == 2 && count($this->uniqueDigitals) == 3;
    }
    
    function getSum(){
        return array_sum($this->digitals);
    }
    
    function getAttributes(){
        return $this->attributes;
    }
    
    function getDigitals(){
        return $this->digitals;
    }

    function getUniqueDigitals(){
        return $this->uniqueDigitals;
    }
    
    static function compileNumber(){
        for($i = 0,$a = []; $i < 3; $a[$i++] = mt_rand(1,6));
        sort($a);
        return implode($a);
    }
}
