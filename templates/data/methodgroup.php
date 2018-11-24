<?php

//获取玩法群

$id = $_REQUEST['id'];

$result = array(
	'isSuccess' => 1,
	'type' => 'success',
	'msg' => '数据请求成功',
	'data' => array()
);

$data = array();
$data[] = array('id' => 0, 'name' => '所有玩法群', 'isdefault' => true);
$data[] = array('id' => 1, 'name' => '五星直选', 'isdefault' => false);
$data[] = array('id' => 2, 'name' => '五星组选', 'isdefault' => false);

$result['data'] = $data;
echo json_encode($result);


?>
