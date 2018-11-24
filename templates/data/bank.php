<?php

//获取用户银行卡信息

$id = $_REQUEST['id'];

$result = array(
	'isSuccess' => 1,
	'type' => 'success',
	'msg' => '数据请求成功',
	'data' => array()
);



$data = array(
	'id' => $id,
	'name' => '工商银行',
	//最小充值金额
	'min' => 100.00,
	//最大充值金额
	'max' => 50000.00,
	//说明
	'text' => '工商银行：当实际充值金额≥300时，平台根据用户实际消耗的手续费进行返送。',
	//用户对应的银行卡列表
	'userAccountList' => array()
);
$data['userAccountList'][] = array('id' => 1, 'name' => '刘德华', 'number' => '**** **** **** 3525', 'isdefault' => false);
$data['userAccountList'][] = array('id' => 2, 'name' => '张学友', 'number' => '**** **** **** 4877', 'isdefault' => true);
$data['userAccountList'][] = array('id' => 3, 'name' => '郭富城', 'number' => '**** **** **** 5569', 'isdefault' => false);
$data['userAccountList'][] = array('id' => 4, 'name' => '张曼玉', 'number' => '**** **** **** 4414', 'isdefault' => false);



$result['data'] = $data;
echo json_encode($result);


?>
