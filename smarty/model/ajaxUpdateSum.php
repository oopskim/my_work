<?php
require_once('../common/DatabaseUtil.php');
$pdo=DatabaseUtil::connect();
$daily = date('Y-m-d');
// echo json_encode($ins_date);
$sql="SELECT 
        (SELECT 
            CASE WHEN SUM(amount) IS NULL THEN 0
            ELSE SUM(amount)
            END AS daily_amount
            FROM
                planning_sheet.invest
            WHERE
                ins_date LIKE '".$daily."%') as daily_amount,
        (SELECT 
            CASE WHEN SUM(amount) IS NULL THEN 0
            ELSE SUM(amount)
            END AS daily_amount
            FROM
                planning_sheet.invest) as total_amount";
$stmt=$pdo->prepare($sql);
$stmt->execute();
$sumResult=$stmt->fetch(PDO::FETCH_ASSOC);
echo json_encode($sumResult);
?>