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
$data[] = array('id' => 0, 'name' => '所有玩法', 'isdefault' => true);
$data[] = array('id' => 1, 'name' => '复式', 'isdefault' => false);
$data[] = array('id' => 2, 'name' => '单式', 'isdefault' => false);
$data[] = array('id' => 3, 'name' => '组合', 'isdefault' => false);

$result['data'] = $data;
echo json_encode($result);


?>
