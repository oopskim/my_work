<?php
require_once('../common/DatabaseUtil.php');
$pdo=DatabaseUtil::connect();
$id=filter_input(INPUT_POST, 'id', FILTER_DEFAULT);

try {
    $pdo->beginTransaction();
    //$updSql="UPDATE planning_sheet.dairy SET category=:category, title=:title, memo=:memo, ins_date=:ins_date WHERE id=:id";
    $updSql="DELETE FROM planning_sheet.invest WHERE id=:id";
    $stmt = $pdo->prepare($updSql);
    $stmt->bindParam( ':id', $id, PDO::PARAM_INT);
    $result=$stmt->execute();
    $pdo->commit();
} catch(Exception $e) {
    $pdo->rollBack();
}

?>