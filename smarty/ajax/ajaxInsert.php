<?php
require('../db.php');
$updateArray = filter_input(INPUT_POST, 'updateValues', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$delete_id = $updateArray['dataId'];
$name = $updateArray['nameStr'];
$branch_cd = $updateArray['branchStr'];
$department = $updateArray['departmentStr'];
$age = $updateArray['ageStr'];
$sex = $updateArray['sexStr'];
$memo = $updateArray['memoStr'];
$img = $updateArray['imgStr'];
$category = $updateArray['categoryStr'];
$pdo->beginTransaction();
try{
    // 'name','branch_cd','department','age','memo','sex','img_file','category'
    $sql="INSERT INTO planning_sheet.pagination (name, branch_cd,department,age,memo,sex,img_file,category) 
            values (:name, :branch_cd,:department,:age,:memo,:sex,:img_file,:category)";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':branch_cd', $branch_cd);
    $stmt->bindParam(':department', $department);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':sex', $sex);
    $stmt->bindParam(':memo', $memo);
    $stmt->bindParam(':img_file', $img);
    $stmt->bindParam(':category', $category);
    $result=$stmt->execute();
    $pdo->commit();
    //echo json_encode($result);
} catch(Exception $e) {
    $pdo->rollBack();
    echo '捕捉した例外: ',  $e->getMessage(), "\n";
}
?>