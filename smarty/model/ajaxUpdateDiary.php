<?php
require_once('../common/DatabaseUtil.php');
$pdo=DatabaseUtil::connect();
$category=filter_input(INPUT_POST, 'dialog_category', FILTER_DEFAULT);
$title=filter_input(INPUT_POST, 'dialog_title', FILTER_DEFAULT);
$memo=filter_input(INPUT_POST, 'dialog_memo', FILTER_DEFAULT);
$ins_date=filter_input(INPUT_POST, 'dialog_ins_date', FILTER_DEFAULT);
$weather=filter_input(INPUT_POST, 'dialog_weather', FILTER_DEFAULT);
$id=filter_input(INPUT_POST, 'dialog_id', FILTER_DEFAULT);

$imginfo = getimagesize($_FILES['dialog_image']['tmp_name']);
if($imginfo['mime'] == 'image/jpeg'){ $extension = ".jpg"; }
if($imginfo['mime'] == 'image/png'){ $extension = ".png"; }
if($imginfo['mime'] == 'image/gif'){ $extension = ".gif"; }
$image_name = $image_type = $image_content = "";
/* 拡張子存在チェック */
if(!empty($extension)){
    /* 画像登録処理 */
    $file_tmp = $_FILES['dialog_image']['tmp_name'];
    $file_name = "sample" . $extension; // アップロード時のファイル名を設定
    $file_save = "../tmp/" . $file_name; // アップロード対象のディレクトリを指定
    move_uploaded_file($file_tmp, $file_save); // アップロードしたファイルをサバーのtmpフォルダに移動
    $image_name = $_FILES['dialog_image']['name'];
    $image_type = $_FILES['dialog_image']['type'];
    // $image_content = file_get_contents($_FILES['dialog_image']['tmp_name']);
    $image_content = file_get_contents($file_save);
}

try {
    $pdo->beginTransaction();
    if($image_name===""){
        $updSql="UPDATE planning_sheet.dairy SET category=:category, title=:title, memo=:memo, weather=:weather, upd_date=now(), ins_date=:ins_date WHERE id=:id";
    } else {
        $updSql="UPDATE planning_sheet.dairy SET category=:category, title=:title, memo=:memo, image_name=:image_name, image_content=:image_content, weather=:weather, upd_date=now(), ins_date=:ins_date WHERE id=:id";
    }
    $stmt = $pdo->prepare($updSql);
    $stmt->bindParam( ':id', $id, PDO::PARAM_INT);
    $stmt->bindParam( ':category', $category);
    $stmt->bindParam( ':title', $title);
    $stmt->bindParam( ':memo', $memo);
    $stmt->bindParam( ':ins_date', $ins_date);
    $stmt->bindParam( ':weather', $weather);
    if($image_name!==""){
        $stmt->bindParam( ':image_name', $image_name);
        $stmt->bindParam( ':image_content', $image_content);
    }
    $result=$stmt->execute();
    $pdo->commit();
} catch(Exception $e) {
    $pdo->rollBack();
}

//配列をJSON形式に変換
echo json_encode($category);

?>