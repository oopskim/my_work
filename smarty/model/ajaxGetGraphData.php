<?php
ini_set('display_errors', "On");
require_once('../common/DatabaseUtil.php');
require_once('../model/getGraphData.php');

$pdo=DatabaseUtil::connect();
$month=filter_input(INPUT_POST, 'month', FILTER_DEFAULT);

$graph=new getGraphData($pdo);
$graphResult=$graph->getGraphJson($month);
echo json_encode($graphResult);

?>