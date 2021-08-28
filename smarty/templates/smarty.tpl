<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link type="text/css" rel="stylesheet" href="css/jquery-ui.min.css"/>
    <link type="text/css" rel="stylesheet" href="css/keijiban.css">
    <title>Document</title>
</head>
<body>
    <input type="hidden" id="myChoiceRow" value="">
    <div><input type="button" id="add_event" value="新規追加"></div>
    <div id="disp_view">
        <table>
            <tr>
                <td>カテゴリ</td>
                <td id="select_category"></td>
            </tr>
            <tr><td>イベント名</td><td><input id="dia_name" type="text" value=""></td></tr>
            <tr><td>支店コード</td><td><input id="dia_branch" type="text" value=""></td></tr>
            <tr><td>支店名</td><td><input id="dia_department" type="text" value=""></td></tr>
            <tr><td>年齢</td><td><input id="dia_age" type="text" value=""></td></tr>
            <tr><td>性別</td><td><input id="dia_sex" type="text" value=""></td></tr>
            <tr><td>メモ</td><td><textarea id="dia_memo" rows="5" cols="33"></textarea></td></tr>
            <tr><td>作業日</td><td><input id="dia_img" type="text" value=""></td></tr>
        </table>
        <input type='hidden' id="update_id" value="">
        <div class="btn_box"><input type="button" id="update_btn_dia" value="更新"></div>
    </div>
    <div id="main_container">
        <div id="list_header">
            <table border="1">
                <tr>
                    <td class="category">カテゴリ</td>
                    <td class="name">イベント名</td>
                    <td class="branch_cd">部店コード</td>
                    <td class="department">部署</td>
                    <td class="age">年齢</td>
                    <td class="sex">性別</td>
                    <td class="memo">メモ</td>
                    <td class="btn_title">イメージファイル</td>
                    <td class="btn_title">編集</td>
                    <td class="btn_title">削除</td>
                </tr>
            </table>
        </div>
        <div id="list_contents">
            <table border="1">
            {if empty($list)}
                <tr>
                    <td style="width:909px;" colspan="10">データがありません。</td>
                </tr>
            {else}
                {foreach from=$list item=v key=k}
                    <tr>
                        <td class="list category">{$v['category']}</td>
                        <td class="list name">{$v['name']}</td>
                        <td class="list branch_cd">{$v['branch_cd']}</td>
                        <td class="list department">{$v['department']}</td>
                        <td class="list age">{$v['age']}</td>
                        <td class="list sex">{$v['sex']}</td>
                        <td class="list memo">{$v['memo']}</td>
                        <td class="list img_file">{$v['img_file']}</td>
                        <td class="list"><input type="button" class="btn_css edit" data-id="{$v['id']}" value="編集"></td>
                        <td class="list"><input type="button" class="btn_css delete" data-id="{$v['id']}" value="削除"></td>
                    </tr>
                {/foreach}
            {/if}
            </table>
        </div>
    </div>
<script>
$(function(){
    let eleIndex;
    let selectMode;
    let selectMenu={
        "movie": "映画","drama": "ドラマ","music":"音楽",
        "food":"食品","tour":"旅行","america":"アメリカ","politic":"政治"};
    let selectHtml = "<select id='category_select'>";
        selectHtml+="<option value=''>-選択-</option>";
    $.each(selectMenu, function(key, val){
        selectHtml+="<option value="+key+">"+val+"</option>";
    });
        selectHtml+="</select>";
        $("#select_category").append(selectHtml);
    $(document).on("click",".delete",function(){
        let dispValues = setDispList($(this));
        $(this).parent().parent().hide();
        let dispText = "「名前:"+dispValues.nameStr+" / 支店名:"+dispValues.branchStr+" / 支店名:"+dispValues.departmentStr;
        let yourChoice = confirm(dispText + "」を本当に削除しても良いですか？");
        $.ajax({
            url: 'ajax/ajaxDelete.php',
            type:'POST',
            data:{ id: dispValues.dataId},
            success: function(){
                console.log("_OK_");
            }
        });
    });
    //add_event
    $(document).on("click","#add_event",function(){
        selectMode="new";
        $("#disp_view").dialog({
            modal:true, //モーダル表示
            width:500,
            title:"イベント新規登録", //タイトル
            open:function(){
                $(".ui-dialog-titlebar").css({
                    "background-color":"#b32038",
                    "color":"white"
                });
                $("#dia_name").val(null);
                $("#dia_branch").val(null);
                $("#dia_department").val(null);
                $("#dia_age").val(null);
                $("#dia_sex").val(null);
                $("#dia_img").val(null);
                $("#update_id").val(null);
                $("#dia_memo").val(null);
            }
        });

    });
    $(document).on("click",".edit",function(){
        selectMode="update";
        // 選択したリスト順番
        eleIndex = $(this).parent().parent().index();
        let dispValues = setDispList($(this));
        //$("#myChoiceRow").val($(this));
        $("#disp_view").dialog({
            modal:true, //モーダル表示
            width:500,
            title:"入力内容編集", //タイトル
            open:function(){
                $(".ui-dialog-titlebar").css({
                    "background-color":"#b32038",
                    "color":"white"
                    });
                $("#dia_name").val(dispValues.nameStr);
                $("#dia_branch").val(dispValues.branchStr);
                $("#dia_department").val(dispValues.departmentStr);
                $("#dia_age").val(dispValues.ageStr);
                $("#dia_sex").val(dispValues.sexStr);
                $("#dia_memo").val(dispValues.memoStr);
                $("#dia_img").val(dispValues.imgStr);
                $("#update_id").val(dispValues.dataId);
                $("#select_category select option").each(function(){
                    let allOption=$(this).val();
                    if(dispValues.cateStr === allOption){
                        $(this).removeAttr("selected");
                        $(this).attr("selected","selected");
                    }
                });
                $("#dia_cate").val(dispValues.cateStr);
            }
        });
    });
    $(document).on("click","#update_btn_dia",function(){
        if(selectMode==="update"){
            urlStr="ajaxUpdate.php";
        } else {
            urlStr="ajaxInsert.php";
        }
        let dispValues = new Object();
        dispValues.nameStr = $("#dia_name").val();
        dispValues.branchStr = $("#dia_branch").val();
        dispValues.departmentStr = $("#dia_department").val();
        dispValues.ageStr = $("#dia_age").val();
        dispValues.sexStr = $("#dia_sex").val();
        dispValues.memoStr = $("#dia_memo").val();
        dispValues.imgStr = $("#dia_img").val();
        dispValues.dataId = $("#update_id").val();
        dispValues.categoryStr = $("#category_select option:selected").val();
        $.ajax({
            url:"ajax/"+urlStr,
            type:"POST",
            data:{ updateValues:dispValues},
            dataType: 'text',
            success: function(response){
                if(selectMode==="update"){
                    let tdElement = $("#list_contents table tr:nth-child("+(eleIndex+1)+") td");
                    $(tdElement).eq(0).text(dispValues.categoryStr);
                    $(tdElement).eq(1).text(dispValues.nameStr);
                    $(tdElement).eq(2).text(dispValues.branchStr);
                    $(tdElement).eq(3).text(dispValues.departmentStr);
                    $(tdElement).eq(4).text(dispValues.ageStr);
                    $(tdElement).eq(5).text(dispValues.sexStr);
                    $(tdElement).eq(6).text(dispValues.memoStr);
                    $(tdElement).eq(7).text(dispValues.imgStr);
                } else {
                    location.reload();
                }
                $("#disp_view").dialog("close");
            },
            error: function(response){
                console.log("_error_");
                console.log(response);
            }
        });
    });
});
function setDispList(ele){
    let dispValues = new Object();
    trEle = $(ele).parent().parent();
    dispValues.dataId = $(ele).data("id");
    dispValues.nameStr = $(trEle).find(".name").text();
    dispValues.branchStr = $(trEle).find(".branch_cd").text();
    dispValues.departmentStr = $(trEle).find(".department").text();
    dispValues.ageStr = $(trEle).find(".age").text();
    dispValues.sexStr = $(trEle).find(".sex").text();
    dispValues.memoStr = $(trEle).find(".memo").text();
    dispValues.imgStr = $(trEle).find(".img_file").text();
    dispValues.cateStr = $(trEle).find(".category").text();
    return dispValues;
}
</script>
</body>
</html>