<?php
//模拟手续费获取结果
$amout = $_GET['amout'];

$num = $amout * 0.6;

$result = array(
			'isSuccess' => 1,
			'msg' => 'success',
			'data' => array(
					'handingcharge' => $num
				)
		);

echo json_encode($result)
?>