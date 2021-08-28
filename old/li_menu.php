<?php include "cnct.php";?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/list_menu.css">
    <title>Document</title>
</head>
<body>
<div id="front_btn">
    <a href="#" class="arrow arrow_css_left"></a>
</div>
<div id="menu_list">
</div>
<div id="next_btn">
    <a href="#" class="arrow arrow_css_right"></a>
</div>
<script>
$(function(){
    var peoples = JSON.parse('<?php echo $peoples; ?>');
    var menu_array = ["food","cookie","政治","車","旅行","映画","韓国ドラマ","アメリカ","ファッション"];
    var menu_cnt = menu_array.length;
    var menu_li_width = 200;
    var list_html="<ul>";
    $.each(menu_array, function(k,v){
        list_html += "<li>"+v+"</li>";
    });
        list_html+="</ul>";
    $("#menu_list").append(list_html);
    var ul_width = (menu_cnt * menu_li_width) + 100;
    $("#menu_list ul").css("width", ul_width);
    $("#menu_list ul li").css("width", menu_li_width);

});
</script>
</body>
</html>