<?php
//bjkl8各等级奖金
$type = $_GET['type'];

$bonusList = array(
				'renxuan1' => array(
					'1' => 6.4
				),
				'renxuan2' => array(
					'1' => 25.00
				),
				'renxuan3' => array(
					'1' => 45.00,
					'2' => 6.00
				),
				'renxuan4' => array(
					'1' => 110.00,
					'2' => 12.00,
					'3' => 3.00
				),
				'renxuan5' => array(
					'1' => 600.00,
					'2' => 50.00,
					'3' => 6.00
				),
				'renxuan6' => array(
					'1' => 1000.00,
					'2' => 70.00,
					'3' => 10.00,
					'4' => 6.00
				),
				'renxuan7' => array(
					'1' => 10000.00, 
					'2' => 230.00, 
					'3' => 30.00, 
					'4' => 6.00, 
					'5' => 3.00
				)
			);

$result = array(
		'isSuccess'=> 1,
		'msg' =>'success',
		'data' => $bonusList[$type]
	);

echo json_encode($result); 
?>