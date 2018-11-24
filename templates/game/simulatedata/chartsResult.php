<?php
//模拟期数统计结果数据
$type = $_GET['type'];
$count = intval($_GET['count']);

if(empty($type) || empty($count)){
	exit();
};

$arrayName = array(
		'30' => array(
					array(
						array('上', 'shang', 56, 'red'),
						array('中', 'zhong', 50, 'green'),
						array('下', 'xia', 18, 'blue'),
					),
					array(
						array('奇', 'ji', 28, 'red'),
						array('和', 'he', 18, 'blue'),
						array('偶', 'ou', 10, 'green'),
					),
					array(
						array('单', 'dan', 8, 'red'),
						array('双', 'shuang', 37, 'blue'),
					),
					array(
						array('大', 'da', 16, 'red'),
						array('小', 'xiao', 39, 'blue'),
					),
					array(
						array('大单', 'dadan', 25, 'red'),
						array('大双', 'dashuang', 18, 'Purple'),
						array('小单', 'xiaodan', 10, 'yellow'),
						array('小双', 'xiaoshuang', 39, 'blue'),
					)
				),
		'50' => array(
					array(
						array('上', 'shang', 26, 'red'),
						array('中', 'zhong', 60, 'green'),
						array('下', 'xia', 11, 'blue'),
					),
					array(
						array('奇', 'ji', 58, 'red'),
						array('和', 'he', 18, 'blue'),
						array('偶', 'ou', 10, 'green'),
					),
					array(
						array('单', 'dan', 9, 'red'),
						array('双', 'shuang', 41, 'blue'),
					),
					array(
						array('大', 'da', 25, 'red'),
						array('小', 'xiao', 25, 'blue'),
					),
					array(
						array('大单', 'dadan', 10, 'red'),
						array('大双', 'dashuang', 18, 'Purple'),
						array('小单', 'xiaodan', 10, 'yellow'),
						array('小双', 'xiaoshuang', 8, 'blue'),
					)
				),
		'100' => array(
					array(
						array('上', 'shang', 56, 'red'),
						array('中', 'zhong', 40, 'green'),
						array('下', 'xia', 11, 'blue'),
					),
					array(
						array('奇', 'ji', 68, 'red'),
						array('和', 'he', 18, 'blue'),
						array('偶', 'ou', 20, 'green'),
					),
					array(
						array('单', 'dan', 20, 'red'),
						array('双', 'shuang', 81, 'blue'),
					),
					array(
						array('大', 'da', 65, 'red'),
						array('小', 'xiao', 35, 'blue'),
					),
					array(
						array('大单', 'dadan', 20, 'red'),
						array('大双', 'dashuang', 18, 'Purple'),
						array('小单', 'xiaodan', 10, 'yellow'),
						array('小双', 'xiaoshuang', 44, 'blue'),
					)
				),
		'200' =>  array(
					array(
						array('上', 'shang', 126, 'red'),
						array('中', 'zhong', 50, 'green'),
						array('下', 'xia', 61, 'blue'),
					),
					array(
						array('奇', 'ji', 158, 'red'),
						array('和', 'he', 28, 'blue'),
						array('偶', 'ou', 10, 'green'),
					),
					array(
						array('单', 'dan', 80, 'red'),
						array('双', 'shuang', 41, 'blue'),
					),
					array(
						array('大', 'da', 75, 'red'),
						array('小', 'xiao', 35, 'blue'),
					),
					array(
						array('大单', 'dadan', 20, 'red'),
						array('大双', 'dashuang', 18, 'Purple'),
						array('小单', 'xiaodan', 10, 'yellow'),
						array('小双', 'xiaoshuang', 78, 'blue'),
					)
				));

echo json_encode($arrayName[$count]);

?>