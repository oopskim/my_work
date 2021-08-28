<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/1.12.1/jquery-ui.min.js"></script>
    <link type="text/css" rel="stylesheet" href="css/common.css">
    <link type="text/css" rel="stylesheet" href="css/family.css?ver=2">
    <link type="text/css" rel="stylesheet" href="css/jquery-ui.min.css"/>
    <title>親族関係図</title>
</head>
<body>
    {include file='page_header.tpl'}
    <div id="menu_arrow_box">
        <div id="menu_arrow"></div>
    </div>    
    <div id="main_container">
        <div id="content_box"></div>
    </div>
{block name="family_view"}
<script type="text/json" src="common/base_setting.json"></script>
<script type="text/javascript" src="js/family/family.js?ver=0"></script>
<script type="text/javascript" src="js/jquery.jsPlumb.min.js"></script>

<script type="text/javascript">
$(function(){
    let person={$list};
    displayFamily(person);
});
</script>
{/block}
</body>
</html>