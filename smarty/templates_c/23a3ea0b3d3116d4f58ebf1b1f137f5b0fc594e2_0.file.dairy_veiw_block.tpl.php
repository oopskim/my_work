<?php
/* Smarty version 3.1.39, created on 2021-08-15 18:42:41
  from '/Applications/MAMP/htdocs/smarty/templates/dairy_veiw_block.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6118e191d73de5_27984798',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '23a3ea0b3d3116d4f58ebf1b1f137f5b0fc594e2' => 
    array (
      0 => '/Applications/MAMP/htdocs/smarty/templates/dairy_veiw_block.tpl',
      1 => 1628124273,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:page_header.tpl' => 1,
  ),
),false)) {
function content_6118e191d73de5_27984798 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo '<script'; ?>
 src="js/jquery-3.6.0.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/1.12.1/jquery-ui.min.js"><?php echo '</script'; ?>
>
    <link type="text/css" rel="stylesheet" href="css/jquery-ui.min.css"/>
    <link type="text/css" rel="stylesheet" href="css/common.css">
    <link type="text/css" rel="stylesheet" href="css/dairy_block.css?ver=0">
    <title>日記</title>
</head>
<body>
    <?php $_smarty_tpl->_subTemplateRender('file:page_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <div id="menu_arrow_box">
        <div id="menu_arrow"></div>
    </div>
    <div id="main_container">
        <div id="add_item_menu">
            <div id="disp_btn" class="top_menu">
            <?php if ($_smarty_tpl->tpl_vars['list']->value['dairy_view_flg'] == 0) {?>
                <img id="list" src="img/list.svg" data-typeflg=1 width="30">
            <?php } else { ?>
                <img id="block" src="img/block.svg" data-typeflg=0 width="30">
            <?php }?>
            </div>
            <div id="sorting" class="top_menu"></div>
            <button id="add_item_btn" class="btn top_menu"><span>新規登録</span></button>
        </div>
        <?php if ($_smarty_tpl->tpl_vars['list']->value['pagination'] == NULL) {?>
            <p id="no_data">該当するデータがありません。</p>
        <?php }?>
        <ul id="item_box">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value['result'], 'data', false, 'key', 'name', array (
));
$_smarty_tpl->tpl_vars['data']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->do_else = false;
?>            
            <li class="item">
                <h1 id="item_header"></h1>
                <input type="hidden" id="hidden_ins_date" name="ins_date" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['ins_date'];?>
">
                <div class="content_box">
                    <span class="delete_item"></span>
                    <a class="screen">
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['image_name'] == '') {?>
                        <img src="img/no_image.png" alt="" class="daily_pic">
                    <?php } else { ?>
                        <img src="model/image.php?id=<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
" alt="" class="daily_pic">
                    <?php }?>
                    </a>
                    <h3 class="item_title"><?php echo $_smarty_tpl->tpl_vars['data']->value['title'];?>
</h3>
                    <input type="hidden" id="hidden_title" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['title'];?>
">
                    <p class="item_content" title="<?php echo $_smarty_tpl->tpl_vars['data']->value['memo'];?>
"><?php echo nl2br($_smarty_tpl->tpl_vars['data']->value['memo']);?>
</p>
                    <input type="hidden" id="hidden_memo" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['memo'];?>
">
                    <input type="hidden" id="item_id" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
">
                    <input type="hidden" id="hidden_weather" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['weather'];?>
">
                    <input type="hidden" id="hidden_category" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['category'];?>
">
                    <input type="hidden" id="hidden_edited_date" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['edited_ins_date'];?>
">
                    <div class="edit_btn_box">
                        <div class="edit_btn">修正</div>
                    </div>
                </div>
            </li>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </ul>
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
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3068664186118e191d51102_19892290', "item_view");
?>

</body>
</html><?php }
/* {block "item_view"} */
class Block_3068664186118e191d51102_19892290 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'item_view' => 
  array (
    0 => 'Block_3068664186118e191d51102_19892290',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo '<script'; ?>
 type="text/javascript" src="common/base_setting.json"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
let dataFlg="new";
let pageHtml = "<?php echo $_smarty_tpl->tpl_vars['list']->value['pagination'];?>
";
let selected_cate = "<?php echo $_smarty_tpl->tpl_vars['list']->value['selected_cate'];?>
";
let allList = JSON.parse(category);
let dailog = JSON.parse(dialog_edit);

$(function(){

    $("#edit_modal").on("keypress", function(e){
        if(e.which===13){
            e.preventDefault();
        }
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


    $("#item_box li").each(function(k,v){
        let selected_catgory=$(v).find("#hidden_category").val();
        let selected_date=$(v).find("#hidden_edited_date").val();
        $.each(allList,function(k2,v2){
            let headLineHtml="";
            let color="color:white;";
            if(k2===selected_catgory){
                if(v2=="pink"||v2=="#e7b3ff" ){
                    color="color:black;";
                }
                headLineHtml+="<span class='cate_icon' style='background-color:"+v2+";"+color+"'>"+k2+"</span>"+selected_date;
            }
            $(v).find("#item_header").append(headLineHtml);
        });
    });
    $("#edit_modal").dialog({
        autoOpen: false,
        width:630,
        height:520,
        modal: true
    });
    $(".item")
        .mouseover(function(e){
            $(this).find(".delete_item").show();
        })
        .mouseout(function(e){
            $(this).find(".delete_item").hide();
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
        my: "center bottom-20",
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
        let allElement=$(this).parent().parent().parent();
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
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "item_view"} */
}
