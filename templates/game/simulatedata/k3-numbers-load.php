<?php

$json = '{"issues":[{"issue":"20150608062","wn_number":"214","offical_time":1433760600},{"issue":"20150608061","wn_number":"246","offical_time":1433760000},{"issue":"20150608060","wn_number":"134","offical_time":1433759400},{"issue":"20150608059","wn_number":"455","offical_time":1433758800},{"issue":"20150608058","wn_number":"244","offical_time":1433758200}],"last_number":{"issue":"20150608062","wn_number":"214","offical_time":1433486400},"current_issue":"20150608063"}';

$obj = json_encode($json);

echo $obj;

?>