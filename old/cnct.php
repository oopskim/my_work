<?php
    $servername="localhost";
    $username="root";
    $password="root";
    $database="planning_sheet";
    $cnn = new mysqli($servername, $username, $password, $database);
    if($cnn->connect_error){
        die("Connection Failed ".$cnn->connect_error);
    }
    $cntSql="SELECT count(*) as cnt FROM pagination";
    $cntStmt=$cnn->query($cntSql);
    $allCnt=$cntStmt->fetch_all(MYSQLI_ASSOC)[0]['cnt'];

    $data_max_disp = 50;
    $max_page_cnt  = intval(ceil($allCnt / $data_max_disp));
    $page = (isset($_GET['page']) && !empty($_GET['page'])) ? intval($_GET['page']): 0;
    $direction = (isset($_GET['drct']) && !empty($_GET['drct'])) ? $_GET['drct']: "";

    if($page < 0){
        $page = 0;
    } elseif($page >= $max_page_cnt){
        $page = $max_page_cnt-1;
    }
    $limit_start   = $page * $data_max_disp;
    $limit_end     = $data_max_disp;
    $sql           = "SELECT * FROM pagination limit ".$limit_start.",".$limit_end;
    $stmt=$cnn->query($sql);
    $results=$stmt->fetch_all(MYSQLI_ASSOC);
    $output = array();
    $output['page']=$page;
    $output['results']=$results;
    $output['max_page_cnt']=$max_page_cnt;
    $output['direction']=$direction;
    $peoples = json_encode($output);
?>