<?php
require_once('../common/DatabaseUtil.php');
$pdo=DatabaseUtil::connect();
$trade_type=filter_input(INPUT_POST, 'trade_type', FILTER_DEFAULT);
$amount=filter_input(INPUT_POST, 'amount', FILTER_DEFAULT);
$memo=filter_input(INPUT_POST, 'memo', FILTER_DEFAULT);
$ins_date = date('Y-m-d H:i:s');
$daily_dt = date('Y-m-d');
// echo json_encode($ins_date);
try {
    $pdo->beginTransaction();
    $updSql="INSERT INTo planning_sheet.invest (trade_type, amount, memo, ins_date) VALUES (:trade_type, :amount, :memo, :ins_date)";
    $stmt = $pdo->prepare($updSql);
    $stmt->bindParam( ':trade_type', $trade_type);
    $stmt->bindParam( ':amount', $amount);
    $stmt->bindParam( ':memo', $memo);
    $stmt->bindParam( ':ins_date', $ins_date);
    $result=$stmt->execute();
    if($result){
        $resultSql="SELECT 
                        *
                    FROM
                        planning_sheet.invest
                    WHERE
                        ins_date LIKE :ins_date
                            AND amount = :amount";
        $getStmt=$pdo->prepare($resultSql);
        $getStmt->bindParam( ':ins_date', $ins_date);
        $getStmt->bindParam( ':amount', $amount);
        $getStmt->execute();
        $dispResult=$getStmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($dispResult);
    }
    $pdo->commit();
} catch(Exception $e) {
    $pdo->rollBack();
}
?>