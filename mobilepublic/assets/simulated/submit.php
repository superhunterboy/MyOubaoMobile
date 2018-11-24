<?php

sleep(2);

$result = array(
	'{"isSuccess":1,"type":"success","Msg":"\u6295\u6ce8\u6210\u529f","data":{"tplData":{"msg":"\u6295\u6ce8\u6210\u529f","link":"http:\/\/u.ds.com\/boughts"}}}',
	'{"isSuccess":0,"type":"bet_failed","Msg":"\u6295\u6ce8\u5931\u8d25","errno":502,"data":{"tplData":{"msg":"\u6295\u6ce8\u5931\u8d25","successful":[],"failed":[{"way":"69","way_name":"\u540e\u4e09\u76f4\u9009\u590d\u5f0f","ball":"0123456789|0123456789|0123456789","reason":"\u5bf9\u4e0d\u8d77\uff0c\u8be5\u53f7\u7801\u5355\u671f\u6295\u6ce8\u5956\u91d1\u9650\u989d1,000,000\u5143\uff0c\u8bf7\u91cd\u65b0\u9009\u62e9\u53f7\u7801\u6295\u6ce8"}]}}}'
);

$obj = json_encode($result[rand(0,1)]);

echo $obj;


?>