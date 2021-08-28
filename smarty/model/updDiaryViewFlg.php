<?php
require_once('../common/DatabaseUtil.php');
$pdo=DatabaseUtil::connect();

$listType=filter_input(INPUT_POST, 'listType', FILTER_DEFAULT);
$viewType=filter_input(INPUT_POST, 'viewType', FILTER_DEFAULT);

try {
    $pdo->beginTransaction();
    $updSql="UPDATE planning_sheet.setting 
                SET 
                    list_view = :listView
                WHERE
                    type = :viewType";
    $stmt = $pdo->prepare($updSql);
    $stmt->bindParam( ':listView', $listType);
    $stmt->bindParam( ':viewType', $viewType);
    $updFlg=$result=$stmt->execute();
    if($updFlg){
        echo json_encode("data updated!!");
    } else {
        echo json_encode("data updat failed!!");
    }
    $pdo->commit();
} catch(Exception $e) {
    $pdo->rollBack();
}


?>