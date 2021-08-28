<?php 
require('../common/DatabaseUtil.php');
$pdo=DatabaseUtil::connect();
$delete_id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
$sql="DELETE FROM planning_sheet.pagination where id=:id";
$stmt=$pdo->prepare($sql);
$stmt->bindParam(':id', $delete_id);
$stmt->execute();
?>