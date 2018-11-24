<?php
if($_POST['type']){
	$rs = array('date' => '20130811-011', 'lotter' => array(1,2,3,4,5));
}else{
	die('');
}
//这里是你要执行的业务逻辑，再次省略，你也可以打印出结果。
echo json_encode($rs);
?>