<?php

//输出后台相关配置和最新开奖等数据

$config = array(
	//用户名称
	'username' => 'doudou',
	//是否暂停销售
	'isstop' => 0,
	//当前期号
	'number' => '201301021216',
	//当前期预计开奖时间
	'resulttime' => '2013/12/10 08:15:35',
	//当前服务器时间
	'nowtime' => '2013/12/10 08:15:35',
	//当前期投注结束时间
	'nowstoptime' => '2013/12/10 08:45:40',
	//上期期号
	'lastnumber' => '2013021215',
	//上期开奖号码
	'lastballs' => '7,0,2,7,5',
	//可追号的最大期数((重庆时时彩最大360期)
	'tracemaxtimes' => 360,
	//游戏期号列表
	//载入期号数(重庆时时彩载入360期)
	'gamenumbers' => array(
			array(
				'number' => '201301021216',
				'time' => '2013/12/11 08:14:23'
			),
			array(
				'number' => '201301021217',
				'time' => '2013/12/12 08:14:23'
			),
			array(
				'number' => '201301021218',
				'time' => '2013/12/13 08:14:23'
			),
			array(
				'number' => '201301021219',
				'time' => '2013/12/14 08:14:23'
			),
			array(
				'number' => '201301021220',
				'time' => '2013/12/11 08:14:23'
			),
			array(
				'number' => '201301021221',
				'time' => '2013/12/12 08:14:23'
			),
			array(
				'number' => '201301021222',
				'time' => '2013/12/13 08:14:23'
			),
			array(
				'number' => '201301021223',
				'time' => '2013/12/14 08:14:23'
			),
			array(
				'number' => '201301021224',
				'time' => '2013/12/11 08:14:23'
			),
			array(
				'number' => '201301021225',
				'time' => '2013/12/12 08:14:23'
			),
			array(
				'number' => '201301021226',
				'time' => '2013/12/13 08:14:23'
			),
			array(
				'number' => '201301021227',
				'time' => '2013/12/14 08:14:23'
			),
			array(
				'number' => '201301021228',
				'time' => '2013/12/15 08:14:23'
			),
			array(
				//期号
				'number' => '201301021229',
				//预计开奖时间
				'time' => '2013/12/15 08:14:23'
			)
	),
	//游戏玩法限制
	'gamelimit' => array(
		'wuxing.zhixuan.fushi' => array(
			//最大可选倍数(-1表示无限制)
			'maxmultiple' => -1,
			//用户奖金组
			'usergroupmoney' => 10
		),
		'wuxing.zhixuan.danshi' => array(
			'maxmultiple' => 200,
			'usergroupmoney' => 2000
		),
		'wuxing.zuxuan.zuxuan120' => array(
			'maxmultiple' => 300,
			'usergroupmoney' => 3000
		),
		'wuxing.zuxuan.zuxuan60' => array(
			'maxmultiple' => 90,
			'usergroupmoney' => 3000
		),
		'wuxing.zuxuan.zuxuan30' => array(
			'maxmultiple' => 20,
			'usergroupmoney' => 3000
		)
	)
	
	
	
);

$result = array(
	'isSuccess' => 1,
	'msg' => '请求成功',
	'data' => $config
);

echo json_encode($result);


?>