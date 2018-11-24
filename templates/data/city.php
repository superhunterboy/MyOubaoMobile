<?php

//获取玩法

$id = $_REQUEST['id'];

$result = array(
	'isSuccess' => 1,
	'type' => 'success',
	'msg' => '数据请求成功',
	'data' => array()
);

$data = array();
$data[] = array('id' => 0, 'name' => '请选择城市', 'isdefault' => true);
$data[] = array('id' => 1, 'name' => '深圳', 'isdefault' => false);
$data[] = array('id' => 2, 'name' => '珠海', 'isdefault' => false);
$data[] = array('id' => 3, 'name' => '汕头', 'isdefault' => false);
$data[] = array('id' => 4, 'name' => '广州', 'isdefault' => false);
$data[] = array('id' => 5, 'name' => '深圳', 'isdefault' => false);
$data[] = array('id' => 6, 'name' => '珠海', 'isdefault' => false);
$data[] = array('id' => 7, 'name' => '汕头', 'isdefault' => false);
$data[] = array('id' => 8, 'name' => '广州', 'isdefault' => false);
$data[] = array('id' => 9, 'name' => '深圳', 'isdefault' => false);
$data[] = array('id' => 10, 'name' => '珠海', 'isdefault' => false);
$data[] = array('id' => 11, 'name' => '汕头', 'isdefault' => false);
$data[] = array('id' => 12, 'name' => '广州5', 'isdefault' => false);
$data[] = array('id' => 12, 'name' => '广州5', 'isdefault' => false);

$result['data'] = $data;
echo json_encode($result);


?>
