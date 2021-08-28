<?php include "cnct.php";?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <div id="pagination_box"></div>
    <div id="peoples_list"></div>
<script>
    var p_start="";
    var p_end="";
    var waru="";
    var p_max=5;
    $(function(){
        var peoples = JSON.parse('<?php echo $peoples; ?>');
        //データ全体の数
        var dataCnt = peoples.results.length;
        //max_page_cnt
        var maxPage = peoples.max_page_cnt;
        var p_now = peoples.page;
        var p_drct = peoples.direction;
        var dispHtml="<table border=1>";
        for(var i=0;i<dataCnt;i++){
            dispHtml+="<tr>";
                dispHtml+="<td>"+peoples.results[i].id+"</td>";
                dispHtml+="<td>"+peoples.results[i].name+"</td>";
                dispHtml+="<td>"+peoples.results[i].age+"</td>";
                dispHtml+="<td>"+peoples.results[i].sex+"</td>";
                dispHtml+="<td>"+peoples.results[i].memo+"</td>";
            dispHtml+="</tr>";
        }
        dispHtml+="</table>";
        $("#peoples_list").empty().append(dispHtml);

        if(p_start === ""||p_end === ""){
            p_start=0;
            p_end=p_max;
        }
        var p_now = parseInt(p_now);
        waru = Math.floor(p_now / p_max);

        if(p_drct === "next"){
            //最後の最後でnextボタン押した場合
            if(p_now === (maxPage-1)){
                p_start = waru * p_max;
            } else {
                p_start = p_now;
            }
        } else if(p_drct === "prev"){
            //urlでマイナスを入力してもPHPで「０」に処理してくれる。
            if(p_now === 0){
                p_start = 0;
            } else {
                p_start = p_now - p_max + 1;
            }
        } else {
            //normal処理
            p_start = waru * p_max;
        }
        p_end = p_start + p_max;
        //paginationがデータの最大数を超えないように調整
        if(maxPage < p_end){
            p_end = maxPage;
        }

        var pageHtml="<a href='index.php?page="+(p_start-1)+"&drct=prev'>prev</a>";
        for(var i=p_start;i<p_end;i++){
            if(i===p_now){
                pageHtml+="<a style='background-color:red;' href='index.php?page="+i+"'>"+(i+1)+"</a>";
            } else {
                pageHtml+="<a href='index.php?page="+i+"'>"+(i+1)+"</a>";
            }
        }
            pageHtml+="<a href='index.php?page="+p_end+"&drct=next'>next</a>";
        $("#pagination_box").append(pageHtml);
    });
</script>
</body>
</html>