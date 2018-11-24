<?php
/**
 * @version $Id$
 */


//临时使用
$lenth = $_GET['lenth'];
$line = $_GET['line'];

/**
 * [请求数据类型]
 * @var [yilou] [遗漏数据类型]
 * @var [lengre] [冷热数据类型]
 */
$type = $_GET['type'];
//请求数据时间
$extent = $_GET['extent'];
//游戏类型列表

//仅测试使用
if($extent == 'currentFre'){
	$extent = 30;
}
if($extent == 'maxFre'){
	$extent = 100;
}

/**
 * 加工数据
 * num需要模拟的数据数量
 * 此函数为随机数据仅为开发使用
 */
function makeData($num, $len, $li) {
	$i = 0;
	$result = array();
	
	for(; $i<$li; $i++){
		$j = 0;
		$result[$i] = array();
		for(; $j<$len; $j++){
			$nums = rand(0, $num/2);
			$result[$i][$j+1] = array('pinlv' => $nums, 'currentNum' => $j);
		}
	}
	return $result;
}

if(isset($_GET['gameMode'])){
//输出JSON格式
echo json_encode(makeData($extent, $lenth, $line));
}
?>