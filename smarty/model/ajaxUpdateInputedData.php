<?php
require_once('../common/DatabaseUtil.php');
$pdo=DatabaseUtil::connect();
$id=filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
$change_col=filter_input(INPUT_POST, 'change_col', FILTER_DEFAULT);
$changed_val=filter_input(INPUT_POST, 'changed_val', FILTER_DEFAULT);
//echo json_encode($changed_val);
try {
    $pdo->beginTransaction();
    $updSql="UPDATE planning_sheet.invest SET ".$change_col."='".$changed_val."' where id=:id";
    $stmt = $pdo->prepare($updSql);
    $stmt->bindParam( ':id', $id);
    $result=$stmt->execute();
    $pdo->commit();
} catch(Exception $e) {
    $pdo->rollBack();
    echo $e->getMessage();
}
?>