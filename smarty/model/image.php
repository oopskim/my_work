<?php
require_once('../common/DatabaseUtil.php');
$pdo=DatabaseUtil::connect();
$sql = 'SELECT image_name,image_type,image_content FROM planning_sheet.dairy where id= :id LIMIT 1';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', (int)$_GET['id'], PDO::PARAM_INT);
$stmt->execute();

$image = $stmt->fetchAll()[0];
//echo '<img src="data:image/gif;base64,' . base64_encode($stmt->fetchAll()[0]['image_content']) . '>';
// echo "<pre>";
// var_dump("__bere_");
// var_dump($stmt->fetchAll()[0]['image_content']);
// echo "</pre>";
header('Content-type: ' . $image['image_type']);
echo $image['image_content'];
exit();
?>