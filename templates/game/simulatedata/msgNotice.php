<?php
	//模拟通知栏提示效果
	$result  = array(
				'code' => 0,
				'msg' => 'ok',
				'data' => array(
						//数据信息
						array(
							'name' => 'messageNotice',
							'tplData' => array(
								array(
									'text' => '11111111111111111111111',
									'url' => '#'
								),
								array(
									'text' => '22222222222222222222222',
									'url' => '#'
								),
								array(
									'text' => '33333333333333333333333',
									'url' => '#'
								)
							)
						),
						//数据信息
						array(
							'name' => 'gameMessageNotice',
							'tplData' => array(
								array(
									'text' => '55555555555555555555555',
									'url' => '#'
								),
								array(
									'text' => '66666666666666666666666',
									'url' => '#'
								),
								array(
									'text' => '77777777777777777777777',
									'url' => '#'
								)
							)
						)
					)
				);

	echo json_encode($result);
?>