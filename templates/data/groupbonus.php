<?php

//获取奖金组配置信息

$usertype = $_REQUEST['usertype'];

$result = array(
	'isSuccess' => 1,
	'type' => 'success',
	'msg' => '数据请求成功',
	'data' => array(
		//当是自定义奖金组时，默认选中的彩系/游戏id
		'defaultGameId' => 2,
		//当是自定义奖金组时，默认选中的类型(彩系/游戏) 1 彩系 2 游戏
		'defaultGameType' => 1,
		//默认配置的奖金组
		'defaultGroup' => array(
			array(
				'id' => 1,
				'bonus' => '1950',
				'feedback' => 0.05
			),
			array(
				'id' => 2,
				'bonus' => '1960',
				'feedback' => 0.2
			),
			array(
				'id' => 3,
				'bonus' => '1980',
				'feedback' => 0.025
			)
		),
		//自定义的奖金组
		'gameTypes' => array(
			array(
				'id' => 1,
				'name' => '时时彩',
				//默认已设置的奖金组值
				'bonus' => 1800,
				'info' => array(
					//当前操作用户(代理)的奖金组
					'proxyBonus' => 1800,
					//当前彩系最低奖金玩法的奖金组
					'minMethodBonus' => 300,
					//当前彩系最高奖金玩法的奖金组
					'maxMethodBonus' => 1800,
					
					//默认已设置的奖金组值
					'bonus' => 1800,
					//可进行设置的最高/低值
					'min' => 1600,
					'max' => 1900,
					//单步允许拖动设置或输入的步长(最终数字不成倍数时使用ceil向上补全一位)
					'step' => 5
				),
				'games' => array(
					array(
						'id' => 1,
						'name' => '重庆时时彩',
						//默认已设置的奖金组值
						'bonus' => 1800,			
						'info' => array(
							//当前操作用户(代理)的奖金组
							'proxyBonus' => 1980,
							//当前游戏最低奖金玩法的奖金组
							'minMethodBonus' => 300,
							//当前游戏最高奖金玩法的奖金组
							'maxMethodBonus' => 1800,
							
							//默认已设置的奖金组值
							'bonus' => 1700,
							//可进行设置的最高/低值
							'min' => 1600,
							'max' => 1980,
							//单步允许拖动设置或输入的步长(最终数字不成倍数时使用ceil向上补全一位)
							'step' => 5
						)
					),
					array(
						'id' => 2,
						'name' => '天津时时彩',
						//默认已设置的奖金组值
						'bonus' => 1800,
						'info' => array(
							//当前操作用户(代理)的奖金组
							'proxyBonus' => 1800,
							//当前游戏最低奖金玩法的奖金组
							'minMethodBonus' => 300,
							//当前游戏最高奖金玩法的奖金组
							'maxMethodBonus' => 1800,
							
							//默认已设置的奖金组值
							'bonus' => 1800,
							//可进行设置的最高/低值
							'min' => 1600,
							'max' => 1900,
							//单步允许拖动设置或输入的步长(最终数字不成倍数时使用ceil向上补全一位)
							'step' => 5
						)
					),
					array(
						'id' => 3,
						'name' => '上海时时彩',
						//默认已设置的奖金组值
						'bonus' => 1800,
						'info' => array(
							//当前操作用户(代理)的奖金组
							'proxyBonus' => 1800,
							//当前游戏最低奖金玩法的奖金组
							'minMethodBonus' => 300,
							//当前游戏最高奖金玩法的奖金组
							'maxMethodBonus' => 1800,
							
							//默认已设置的奖金组值
							'bonus' => 1800,
							//可进行设置的最高/低值
							'min' => 1600,
							'max' => 1900,
							//单步允许拖动设置或输入的步长(最终数字不成倍数时使用ceil向上补全一位)
							'step' => 5
						)
					),
					array(
						'id' => 4,
						'name' => '黑龙江时时彩',
						//默认已设置的奖金组值
						'bonus' => 1800,
						'info' => array(
							//当前操作用户(代理)的奖金组
							'proxyBonus' => 1800,
							//当前游戏最低奖金玩法的奖金组
							'minMethodBonus' => 300,
							//当前游戏最高奖金玩法的奖金组
							'maxMethodBonus' => 1800,
							
							//默认已设置的奖金组值
							'bonus' => 1800,
							//可进行设置的最高/低值
							'min' => 1600,
							'max' => 1900,
							//单步允许拖动设置或输入的步长(最终数字不成倍数时使用ceil向上补全一位)
							'step' => 5
						)
					),
					array(
						'id' => 5,
						'name' => '江西时时彩',
						//默认已设置的奖金组值
						'bonus' => 1800,
						'info' => array(
							//当前操作用户(代理)的奖金组
							'proxyBonus' => 1800,
							//当前游戏最低奖金玩法的奖金组
							'minMethodBonus' => 300,
							//当前游戏最高奖金玩法的奖金组
							'maxMethodBonus' => 1800,
							
							//默认已设置的奖金组值
							'bonus' => 1800,
							//可进行设置的最高/低值
							'min' => 1600,
							'max' => 1900,
							//单步允许拖动设置或输入的步长(最终数字不成倍数时使用ceil向上补全一位)
							'step' => 5
						)
					),
				)
			),
			array(
				'id' => 2,
				'name' => '11选5',
				'info' => array(
					//当前操作用户(代理)的奖金组
					'proxyBonus' => 1900,
					//当前彩系最低奖金玩法的奖金组
					'minMethodBonus' => 300,
					//当前彩系最高奖金玩法的奖金组
					'maxMethodBonus' => 1800,
					
					//默认已设置的奖金组值
					'bonus' => 1800,
					//可进行设置的最高/低值
					'min' => 1600,
					'max' => 1900,
					//单步允许拖动设置或输入的步长(最终数字不成倍数时使用ceil向上补全一位)
					'step' => 5
				),
				'games' => array(
					array(
						'id' => 6,
						'name' => '上海11选5',
						//默认已设置的奖金组值
						'bonus' => 1800,
						'info' => array(
							//当前操作用户(代理)的奖金组
							'proxyBonus' => 1980,
							//当前游戏最低奖金玩法的奖金组
							'minMethodBonus' => 300,
							//当前游戏最高奖金玩法的奖金组
							'maxMethodBonus' => 1800,
							
							//默认已设置的奖金组值
							'bonus' => 1700,
							//可进行设置的最高/低值
							'min' => 1600,
							'max' => 1980,
							//单步允许拖动设置或输入的步长(最终数字不成倍数时使用ceil向上补全一位)
							'step' => 5
						)
					),
					array(
						'id' => 7,
						'name' => '山东11选5',
						//默认已设置的奖金组值
						'bonus' => 1800,
						'info' => array(
							//当前操作用户(代理)的奖金组
							'proxyBonus' => 1800,
							//当前游戏最低奖金玩法的奖金组
							'minMethodBonus' => 300,
							//当前游戏最高奖金玩法的奖金组
							'maxMethodBonus' => 1800,
							
							//默认已设置的奖金组值
							'bonus' => 1800,
							//可进行设置的最高/低值
							'min' => 1600,
							'max' => 1900,
							//单步允许拖动设置或输入的步长(最终数字不成倍数时使用ceil向上补全一位)
							'step' => 5
						)
					)
				)
			)
		) 
	)
);

if($usertype == '2'){
	$result['data']['defaultGroup'] = array(
			array(
				'id' => 1,
				'bonus' => '1650',
				'feedback' => 0.12
			),
			array(
				'id' => 2,
				'bonus' => '1760',
				'feedback' => 0.5
			),
			array(
				'id' => 3,
				'bonus' => '1880',
				'feedback' => 0.015
			)
	);
}


echo json_encode($result);


?>
