<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/1.12.1/jquery-ui.min.js"></script>
    <link type="text/css" rel="stylesheet" href="css/common.css">
    <link type="text/css" rel="stylesheet" href="css/jquery-ui.min.css"/>
    <link type="text/css" rel="stylesheet" href="css/invest.css?v=15">
    <title>投資日記</title>
</head>
<body>
    {include file='page_header.tpl'}
    <div id="menu_arrow_box">
        <div id="menu_arrow"></div>
    </div>
    <div id="add_event_container" title="経済イベント登録">
        <form method="post" id="event_register" name="event_register">
        <p id="event_name_input">
            <div id="event_name_title">イベント名</div>
            <input type="text" id="event_name" name="event_name">
        </p>
        <div>
            <label for="start_date">イベント開始日</label>
            <input type="datetime-local" id="start_date" name="event_start">
            <label for="end_date">イベント終了日</label>
            <input type="datetime-local" id="end_date" name="event_end">
        </div>
        </form>
        <div id="button_box"><input type="submit" id="event_info_send" value="登録"></div>
    </div>
    <div id="main_container">
        <div id="content_box">
            <div id="left_menu">
                <div id="today"></div>
                <div id="disp_sum">
                    <div id="total_sum" class="sum_box">
                        <span>全体の合計:</span>
                        <div id="total_sum_txt"></div>
                    </div>
                    <div id="daily_sum" class="sum_box">
                        <span>今日の合計:</span>
                        <div id="daily_sum_txt"></div>
                    </div>
                </div>
                <div id="event_calendar">
                    <div id="event_head">イベント案内(2021年)<span id="add_event">追加<span></div>
                    <div id="event_content">
                        <ul id="event_list">
                        {if count($evenList) EQ 0}
                            <div id="nothing_msg">登録されているイベントがありません。</div>
                        {/if}
                        {foreach from=$evenList item=event}
                            <li><span class="event_date">{$event['event_start']}</span><span class="event_detail">{$event['event_name']}</span></li>
                        {{/foreach}}
                        </ul>
                    </div>
                </div>
            </div>
            <div id="disp_content">
                <div id="new_input">
                    <span class="memo_txt">※金額入力後にENTERキーを押すと登録されます（メモは必須ではありません）</span>
                <form id="short_input" method="POST" name="short_input" enctype="multipart/form-data">
                    <input type="radio" name="trade_type" value="long" checked>ロング
                    <input type="radio" name="trade_type" value="short">ショット
                    <input type="number" name="amount" placeholder="金額入力" value="">
                    <input type="text" name="memo" placeholder="ショットメモ入力" value="">
                </form>
                </div>
                <div id="data_list">
                    <table id="invest_history">
                    {foreach from=$list item=data}
                        <tr>
                            <td class="date_css">{$data['ins_date']}</td>
                            <td class="type_css" data-id="{$data['id']}"><span class="{$data['trade_type']}"></span></td>
                            <td class="amnt_css">
                            {if $data['amount'] >= 0}
                                <input type="text" class="input_amount" name="disp_amount" value="{$data['amount']|number_format}">
                            {else}
                                <input type="text" class="input_amount minus_amount" name="disp_amount" value="{$data['amount']|number_format}">
                            {/if}
                            </td>
                            {if $data['main_flg'] EQ 1}
                            <td class="main_flg"><span class="main_flg_txt">대표메모</span><input type="checkbox" name="main_flg" checked></td>
                            {else}
                            <td class="main_flg"><span class="main_flg_txt">대표메모</span><input type="checkbox" name="main_flg"></td>
                            {/if}
                            <td class="memo_css">
                                <input type="text" class="input_memo" name="disp_memo" value="{$data['memo']}">
                            </td>
                            <td class="btn_css">
                                <img class="original" src="img/delete.png" width="20px">
                            </td>
                        </tr>
                    {/foreach}
                    </table>
                </div>
            </div>
        </div>
    </div>
{block name="invest_view"}
<script type="text/javascript" src="common/base_setting.json"></script>
<script type="text/javascript">
//let allList = JSON.parse(category);
//let dailog = JSON.parse(dialog_edit);

$(function(){
    getToday();
    $("#event_info_send").on("click", function(){
        let event_name=$("#event_name").val();
        let event_start=$("#start_date").val();
        if(event_name===""||event_start===""){
            alert("※イベント名とイベント開始日は必須項目です。");
            return false;
        }
        let send_data = new FormData($("#event_register").get(0));
        updNewEventInfo(send_data);
        $("#add_event_container").dialog("close");
    });
    $("#add_event_container").dialog({
        autoOpen: false,
        width:650,
        height:250,
        modal: true
    });
    $("#add_event").on("click", function(){
        $("#add_event_container").dialog("open");
    });

    $("input[name='trade_type']:eq(0)").focus();
    //全体の合計、今日の合計を更新
    updTotalSum();
    //リストの最後にあるばつボタン削除する
    $(document).on("click",".btn_css", function(){
        let delete_id=$(this).parent().find('.type_css').data('id');
        $(this).parent().fadeOut("slow");
        $.ajax({
            type:'POST',
            url:'model/ajaxDeleteInvestItem.php',
            data:{ id:delete_id},
            success:function(result){
                console.log("delete complete");
                //全体の合計、今日の合計を更新
                updTotalSum();
            },
            done:function(response){
                console.log("success");
            }
        });
    });
    $("#short_input").on("keydown", function(e){
        //ENTERキーを押すときの対応
        if(e.which===13){
            let chkAmount = $("input[name='amount']").val();
            if(chkAmount===""){
                alert("金額を必ず入力してください。");
                return false;
            }
            let tradeType=$("input[type='radio']:checked").val();
            let formData = new FormData($("#short_input").get(0));
                formData.append("trade_type", tradeType);
            $.ajax({
                type:'POST',
                url:'model/ajaxUpdateShortData.php',
                data:formData,
                contentType : false,
                processData : false,
                success:function(result){
                    //入力後の初期化
                    $("input[name='amount']").val("");
                    $("input[name='memo']").val("");

                    let dispResult=$.parseJSON(result);
                    let addHtml="<tr>";
                        addHtml+="<td class='date_css'>"+dispResult.ins_date+"</td>";
                        addHtml+="<td class='type_css' data-id='"+dispResult.id+"'>";
                            addHtml+="<span class='"+dispResult.trade_type+"'></span>";
                        addHtml+="</td>";
                        let minus_css="";
                        if(dispResult.amount<0){
                            minus_css=" minus_amount";
                        }
                        addHtml+="<td class='amnt_css'>";
                            addHtml+="<input type='text' class='input_amount"+minus_css+"' name='disp_amount' value='"+numberFormat(dispResult.amount)+"'";
                        addHtml+="</td>";
                        addHtml+="<td class='main_flg'><span class='main_flg_txt'>대표메모</span><input type='checkbox' name='main_flg'></td>";
                        addHtml+="<td class='memo_css'>";
                            addHtml+="<input type='text' class='input_memo' name='disp_memo' value='"+dispResult.memo+"'>";
                        addHtml+="</td>";
//<td class="main_flg"><span class="main_flg_txt">대표메모</span><input type="checkbox" name="main_flg"></td>
                        addHtml+="<td class='btn_css'>";
                            addHtml+="<img class='original' src='img/delete.png' width='20px'>";
                        addHtml+="</td>";
                    addHtml+="</tr>";
                    //要素が始まる前の高さ
                    let elementPosi=$("#invest_history").offset().top;
                    //要素の高さ
                    let elementHeight=$("#invest_history").height();
                    //１行の高さ
                    let trHeight=33;
                    let bottomPosi=elementPosi + elementHeight + trHeight;
                    let addRow = $(addHtml).hide().fadeIn('slow');
                    $("#invest_history").append(addRow);
                    $("#data_list").scrollTop(bottomPosi);
                    //全体の合計、今日の合計を更新
                    updTotalSum();
                },            
                error: function(jqxhr, status, exception) {
                    console.debug('jqxhr', jqxhr);
                    console.debug('status', status);
                    console.debug('exception', exception);
                },
                done:function(response){
                    console.log("done");
                }
            });
        }
    });
    let change_element={
        'amount':'.input_amount',
        'main_flg':'input[name="main_flg"]',
        'memo':'.input_memo'
    };
    $.each(change_element, function(col,ele){
        $(document).on("change", ele,function(){
            let rowIndex=$(this).parent().parent().index();
            let update_id=$(this).parent().parent().find(".type_css").data("id");
            let changed_val=$(this).val();
            if(col==="main_flg"){
                if($(this).prop('checked')){
                    changed_val=1;
                } else {
                    changed_val=0;
                }
            }
            if(col==="amount" && changed_val===""){
                $(this).val(0);
                changed_val=0;
            }
            let param={ id:update_id, change_col:col, changed_val:changed_val};
            $.ajax({
                type:'POST',
                url:'model/ajaxUpdateInputedData.php',
                data:param,
                success:function(result){
                    console.log("success");
                    let after_val = $("#invest_history tr:eq("+rowIndex+")").find('.input_amount').val();
                    if(parseInt(after_val) < 0){
                        $("#invest_history tr:eq("+rowIndex+")").find('.input_amount').addClass('minus_amount');
                    } else {
                        $("#invest_history tr:eq("+rowIndex+")").find('.input_amount').removeClass('minus_amount');
                    }
                },
                done:function(response){
                    console.log("done");

                }
            });
        });
    });
    function getToday(){
        //今日の日付データを変数hidukeに格納
        var my_day=new Date(); 

        //年・月・日・曜日を取得する
        var year = my_day.getFullYear();
        var month = my_day.getMonth()+1;
        var week = my_day.getDay();
        var day = my_day.getDate();

        var yobi= new Array("日","月","火","水","木","金","土");

        $("#today").text(year+"年"+month+"月"+day+"日("+yobi[week]+")");
    }
    function updNewEventInfo(form_data){
        $.ajax({
            type:'POST',
            url:'model/ajaxInsertNewEvent.php',
            data:form_data,
            contentType : false,
            processData : false,
            success:function(result){
                console.log("success");
                location.reload();
            },
            done:function(response){
                console.log("done");

            }
        });
    }
    function numberFormat(num){
        let formatted_num=String(num).replace(/(\d)(?=(\d\d\d)+$)/g, '$1,');
        return formatted_num;
    }
    //合計値を更新する
    function updTotalSum(){
        $.ajax({
            type:'POST',
            url:'model/ajaxUpdateSum.php',
            success:function(result){
                let dispResult=$.parseJSON(result);
                //合計の処理
                $("#total_sum_txt").text(numberFormat(dispResult.total_amount));
                $("#daily_sum_txt").text(numberFormat(dispResult.daily_amount));
            },
            done:function(response){
                console.log("done");
            }

        });
    }
});

</script>
{/block}
</body>
</html>