<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/1.12.1/jquery-ui.min.js"></script>
    <link type="text/css" rel="stylesheet" href="css/jquery-ui.min.css"/>
    <link type="text/css" rel="stylesheet" href="css/common.css">
    <link type="text/css" rel="stylesheet" href="css/dairy_list.css?ver=8">
    <title>日記</title>
</head>
<body>
    {include file='page_header.tpl'}
    <div id="menu_arrow_box">
        <div id="menu_arrow"></div>
    </div>
    <div id="main_container">
        <div id="add_item_menu">
            <div id="disp_btn" class="top_menu">
            {if $list['dairy_view_flg'] EQ 0}
                <img id="list" src="img/list.svg" data-typeflg=1 width="30">
            {else}
                <img id="block" src="img/block.svg" data-typeflg=0 width="30">
            {/if}
            </div>
            <div id="sorting" class="top_menu"></div>
            <button id="add_item_btn" class="btn top_menu"><span>新規登録</span></button>
        </div>
        {if $list['pagination'] EQ NULL}
            <p id="no_data">該当するデータがありません。</p>
        {/if}
        <table id="item_box">
        {if $list['pagination'] NEQ NULL}
            <tr><th>カテゴリ</th><th>作成日</th><th>件名</th><th>内容</th><th colspan="2">操作</th></tr>
        {/if}
        {foreach from=$list['result'] item=data key=key name=name}            
            <tr>
                <td class="list_cate"><span class="cate_txt">{$data['category']}</span></td>
                <td class="list_date">
                    <span class="date_css">{$data['edited_ins_date']}</span>
                </td>
                <td class="list_title">{$data['title']|truncate:22:'...'}</td>
                <input type="hidden" id="hidden_title" value="{$data['title']}">
                <td class="list_memo item_content" title="{$data['memo']}">{$data['memo']|truncate:40:'...'}</td>
                <input type="hidden" id="hidden_memo" value="{$data['memo']}">
                <input type="hidden" id="item_id" value="{$data['id']}">
                <input type="hidden" id="hidden_category" value="{$data['category']}">
                <input type="hidden" id="hidden_weather" value="{$data['weather']}">
                <input type="hidden" id="hidden_edited_date" value="{$data['edited_ins_date']}">
                <input type="hidden" id="hidden_ins_date" value="{$data['ins_date']}">
                <td class="btn_css"><input class="edit_btn row_btn" type="submit" value="編集"></td>
                <td class="btn_css"><input class="delete_item row_btn" type="submit" value="削除"></td>
            </tr>
        {/foreach}
        </table>
        <div id="pagination_box"></div>

    </div>
    <div id="edit_modal" title="日記更新">
        <table>
            <form id="dairy_data" name="dairy_data" method="post" enctype="multipart/form-data">
                <tr>
                    <td>カテゴリー選択</td><td id="category_box"></td>
                </tr>
                <tr>
                    <td>天気</td>
                    <td id="dialog_weather">
                        <input type="radio" id="sunny" name="weather" value="sunny" checked>
                        <label for="sunny"><img src="img/sunny.png" width="20"></label>
                        <input type="radio" id="cloudy" name="weather" value="cloudy">
                        <label for="cloudy"><img src="img/cloudy.png" width="20"></label>
                        <input type="radio" id="rainy" name="weather" value="rainy">
                        <label for="rainy"><img src="img/rainy.png" width="20"></label>
                    </td>
                </tr>
                <tr>
                    <td>タイトル入力</td><td><input type="text" id="dialog_title" name="dialog_title"></td>
                </tr>
                <tr>
                    <td>日記入力</td><td><textarea id="dialog_memo" name="dialog_memo" rows="5" cols="53"></textarea></td>
                </tr>
                <tr>
                    <td>入力日付</td><td><input type="date" id="dialog_ins_date" name="dialog_ins_date" name="ins_date"></td>
                </tr>
                <tr>
                    <td>イメージ添付</td>
                    <td id="img_view">
                        <input type="file" id="dialog_image" name="dialog_image" accept=".jpg, .jpeg, .png">
                        <img src="img/no_image.png" alt="" class="daily_pic" id="daily_pic">
                    </td>
                </tr>
                <input type="hidden" id="dialog_id" name="dialog_id">
                </form>
            </table>
            <div id="button_box">
                <button id="update_btn" class="btn">更新</button>
                <button id="cancel_btn" class="btn">キャンセル</button>
            </div>
        </div>
{block name="item_view"}
<script type="text/javascript" src="common/base_setting.json"></script>
<script type="text/javascript">
let dataFlg="new";
let pageHtml = "{$list['pagination']}";
let selected_cate = "{$list['selected_cate']}";
let allList = JSON.parse(category);
let dailog = JSON.parse(dialog_edit);

$(function(){
    $("#item_box").find(".cate_txt").each(function(k1,v1){
        let cate_text=$(v1).text();
        $.each(allList,function(k2,v2){
            if(cate_text===k2){
                let color_css="";
                if(v2=="pink"||v2=="#e7b3ff"){
                    color_css="black";
                } else {
                    color_css="white";
                }
                $(v1).css({
                    "background-color":v2,
                    "color":color_css
                });
            }
        });
    });
    $("#disp_btn>img").on("click", function(){
        let listType=$(this).data('typeflg');
        let viewType='dairy';
        $.ajax({
            type:'POST',
            url:'model/updDiaryViewFlg.php',
            data:{ listType:listType, viewType:viewType},
            success:function(result){
                location.reload();
                console.log("success");
                console.log(result);
            },
            done:function(response){
                console.log("done");

            }
        });
    });
    //sorting機能を画面に描画
    let cateSelectHtml="<label id='sort_label' for='cate_sort'>item整列</label><select id='cate_sort'>";
        cateSelectHtml+="<option value=''>-選択-</option>";
    $.each(allList,function(k, v){
        if(k===selected_cate){
            cateSelectHtml+="<option value="+k+" selected>"+k+"</option>";
        } else {
            cateSelectHtml+="<option value="+k+">"+k+"</option>";
        }
    });
    cateSelectHtml+="</select>";
    $("#sorting").html(cateSelectHtml);

    $("#cate_sort").on("change",function(){
        let cate=$(this).val();
        location.href="index.php?md=dairy&cate="+cate;
    });

    //paginationをphpで作成して実装
    $("#pagination_box").append(pageHtml);

    $("#pagination_box a").each(function(){
        if(selected_cate!==""){
            let hrefTag=$(this).attr("href");
                hrefTag=hrefTag+"&cate="+selected_cate;
                $(this).attr("href",hrefTag)
        }
    });
    $("#edit_modal").dialog({
        autoOpen: false,
        width:630,
        height:520,
        modal: true
    });
    $(document).on("click", ".delete_item", function(){
        //$(this).parent().parent().fadeOut("slow");
        //削除用のitem_id
        let param=$(this).parent().parent().find("#item_id").val();
        $.ajax({
            type:"POST",
            url:"model/ajaxDeleteItem.php",
            data:{ del_id:param },
            success:function(data){
                console.log(data);
                location.reload();
            },
            error: function(jqxhr, status, exception) {
                console.debug('jqxhr', jqxhr);
                console.debug('status', status);
                console.debug('exception', exception);
            }
        }).done(function(data) {
            console.log(data);
        });
    });

    $( document ).tooltip({
      position: {
        my: "center bottom-5",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      }
    });
    //item新規登録
    $("#add_item_btn").on("click",function(){
        //新規登録時の初期日付
        let date = new Date();
        let mm = toTwoDigits(date.getMonth()+1, 2)
        let dd = toTwoDigits(date.getDate(), 2)
        let nowDate=date.getFullYear()+"-"+mm+"-"+dd;
        //データタイプはnew,editがある
        dataFlg="new";
        $("#edit_modal").dialog("open");
        //初期化処理
        $.each(dailog, function(k,v){
            $("#dialog_"+v).val("");
        });
        $("#dialog_ins_date").val(nowDate);
        categorySelector(allList, "個人");

    });
    //修正、または新規登録ボタン押下時のダイアログ
    $(".edit_btn").on("click",function(){
        let allElement=$(this).parent().parent();
        let id = $(allElement).find("#item_id").val();
        let selected_category = $(allElement).find(".cate_icon").text();
        let title = $(allElement).find("#hidden_title").val();
        let memo = $(allElement).find("#hidden_memo").val();
        let weather = $(allElement).find("#hidden_weather").val();
        let insDate = $(allElement).find("#hidden_ins_date").val();
        //daily_pic
        let image_src = $(allElement).find(".daily_pic").attr("src");
        //item追加のフラグ、新規登録ではなく編集
        dataFlg="edit";
        //ダイアログ開く
        $("#edit_modal").dialog("open");
        //カテゴリ全体リスト
        let allList = JSON.parse(category);
        categorySelector(allList, selected_category);
        $("#dialog_title").focus();
        $("#dialog_title").val(title);
        $("#dialog_id").val(id);
        $("#dialog_memo").val(memo);
        $("#daily_pic").attr("src",image_src);
        $("input[type='radio']").each(function(k,radioEle){
            let weatherList=$(radioEle).val();
            if(weatherList===weather){
                $(radioEle).prop('checked', true);
            }
        });
        $("#dialog_ins_date").val(insDate.split(" ")[0]);

    });
    $("#cancel_btn").on("click", function(){
        $("#edit_modal").dialog("close");
    });
    //登録用のデータ入力後に更新ボタン押下
    $("#update_btn").on("click", function(event){
        event.preventDefault();
        let chkEle=$(this).parent().parent();
        //
        let errCnt=chkInputBox(chkEle);
        if(errCnt > 0){
            return false;
        }
        let selectUrl="";
        if(dataFlg==="new"){
            selectUrl='model/ajaxAddItem.php';
        } else {
            selectUrl='model/ajaxUpdateDiary.php';
        }
        //カテゴリ
        let category=$("#dialog_category option:selected").val();
        let weather=$("input[name='weather']:checked").val();
        var fData=new FormData($('#dairy_data').get(0));
            fData.append("dialog_category", category);
            fData.append("dialog_weather", weather);
        $.ajax({
            type:'POST',
            url:selectUrl,
            data:fData,
            cache       : false,
            contentType : false,
            processData : false,
            success: function(result){
                console.log("success");
                console.log(result);
                if(result){
                    location.reload();
                }
            },
            error: function(jqxhr, status, exception) {
              console.debug('jqxhr', jqxhr);
              console.debug('status', status);
              console.debug('exception', exception);
            }
        });
    });
});
function toTwoDigits (num, digit) {
    　//String型へ変換
      num += ''
      //今日の年月日がそれぞれの桁数より小さい場合0を頭に足す
      if (num.length < digit) {
        num = '0' + num
      }
      return num
    }
// カテゴリタグ生成と選択
function categorySelector(data, selected){
    let baseHTML="<select id='dialog_category' name='dialog_category'>";
    $.each(data,function(k,v){
        if(k===selected){
            baseHTML+="<option value='"+k+"'selected>"+k+"</option>";
        } else {
            baseHTML+="<option value='"+k+"'>"+k+"</option>";
        }
    });
    baseHTML+="</select>";
    $("#category_box").empty().append(baseHTML);
}
function chkInputBox(ele){
    //title
    let title=$(ele).find("#dialog_title").val();
    let memo=$(ele).find("#dialog_memo").val();
    let errCnt=0;
    if(title===""){
        $(ele).find("#dialog_title").addClass("alert");
        errCnt++;
    } else {
        $(ele).find("#dialog_title").removeClass("alert");
    }
    if(memo===""){
        $(ele).find("#dialog_memo").addClass("alert");
        errCnt++;
    } else {
        $(ele).find("#dialog_memo").removeClass("alert");
    }
    return errCnt;
}
</script>
{/block}
</body>
</html>