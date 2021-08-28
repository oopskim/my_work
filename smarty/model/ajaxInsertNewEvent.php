<?php
ini_set('display_errors', "On");
require_once('../common/DatabaseUtil.php');
require_once('../model/getInvestData.php');

$pdo=DatabaseUtil::connect();
$event_name=filter_input(INPUT_POST, 'event_name', FILTER_DEFAULT);
$event_start=filter_input(INPUT_POST, 'event_start', FILTER_DEFAULT);
$event_end=!empty(filter_input(INPUT_POST, 'event_end', FILTER_DEFAULT)) ? filter_input(INPUT_POST, 'event_end', FILTER_DEFAULT) : null;
try{
    $pdo->beginTransaction();
    $sql="INSERT INTO planning_sheet.invest_calendar (event_name, event_start, event_end) values (:event_name, :event_start, :event_end)";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam( ':event_name', $event_name);
    $stmt->bindParam( ':event_start', $event_start);
    $stmt->bindParam( ':event_end', $event_end);
    $stmt->execute();
    $pdo->commit();
}catch(Exception $e){
    $pdo->rollback();
}


//echo json_encode($graphResult);

?>