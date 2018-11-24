<?php

// 延迟效果
sleep(2);

$output = array(
	'isSuccess' => 1,
	'type' => 'info',
	'data' => array(
		'team_turnover' => rand(0,100),
		'available' => rand(100000, 999999999) / 100
	)
);

echo json_encode($output);

?>