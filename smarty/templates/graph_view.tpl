<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/1.12.1/jquery-ui.min.js"></script>
    <script src="common/amcharts4/core.js"></script>
    <script src="common/amcharts4/charts.js"></script>
    <script src="common/amcharts4/themes/animated.js"></script>
    <script src="common/amcharts4/themes/material.js"></script>

    <link type="text/css" rel="stylesheet" href="css/common.css">
    <link type="text/css" rel="stylesheet" href="css/graph.css?ver=3">
    <link type="text/css" rel="stylesheet" href="css/jquery-ui.min.css"/>
    <title>パターン分析</title>
</head>
<body>
    {include file='page_header.tpl'}
    <div id="menu_arrow_box">
        <div id="menu_arrow"></div>
    </div>    
    <div id="main_container">
      <div id="content_box">
        <div class="item_title">月単位の日記作成報告
          <select id="month_selector"></select>
        </div>
        <div id="chartdiv" style="width:1080px; height: 250px;"></div>
        <div class="item_title">FX投資の成績
          <select id="fx_month_selector"></select>
        </div>
        <div id="investCalendar" style="width:1080px;"></div>
      </div>
    </div>
{block name="family_view"}
<script type="text/javascript" src="common/base_setting.json"></script>
<script type="text/javascript">
//let allList = JSON.parse(category);
//let dailog = JSON.parse(dialog_edit);

$(function(){
  let now = new Date();
  let thisMonth=(now.getMonth() + 1);
  let monthHtml="";
  for(let i=1;i<13;i++){
    if(thisMonth===i){
      monthHtml+="<option value='"+i+"' selected>"+i+"月</option>";
    } else {
      monthHtml+="<option value='"+i+"'>"+i+"月</option>";
    }
  }
  $("#month_selector").html(monthHtml);
  $("#fx_month_selector").html(monthHtml);
  let ajaxResult="";
  $("#month_selector").on("change",function(){
    let selectedValue=$("#month_selector > option:selected").val();
    if(selectedValue < 10){
      selectedValue="0"+selectedValue;
    }
    $.ajax({
      url:"model/ajaxGetGraphData.php",
      type:"POST",
      data:{ month:selectedValue},
      success:function(result){
        generateTotalGrap($.parseJSON(result));
      },
      done:function(response){
        console.log("done");
      }
    });
  });
  $("#fx_month_selector").on("change",function(){
    let selectedValue=$("#fx_month_selector > option:selected").val();
    if(selectedValue < 10){
      selectedValue="0"+selectedValue;
    }
    $.ajax({
      url:"model/ajaxGetFxGraphData.php",
      type:"POST",
      data:{ month:selectedValue},
      success:function(result){
        getCalendarForFX($.parseJSON(result));
      },
      done:function(response){
        console.log("done");
      }
    });
  });
  generateTotalGrap({$list});
  //getGraphForFX({$fxList});
  getCalendarForFX({$fxList});
});
function getCalendarForFX(monthly_data){
  let _date = new Date();
  //システムの日付
  let _month = _date.getMonth()+1 < 10 ? "0"+(_date.getMonth()+1) : _date.getMonth()+1;
  //システムの今日（　MM-DD　）　
  let this_day=_month+"-"+_date.getDate();
  //ユーザの選択による月情報
  let selected_=$("#fx_month_selector option:selected").val();
  let month_=selected_ < 10 ? "0"+selected_ : selected_;
  let total_days=monthly_data.length;
  let total_weeks= Math.ceil(total_days/7);
  let start_day=monthly_data[0]['yobi'];
  let week_list=['日','月','火','水','木','金','土'];
  let start_num=0;
  $.each(week_list, function(k1,v2){
      if(start_day===v2){
        start_num=k1;
      }
  });
  let cal_html="<ul>";
      $.each(week_list, function(key0, val0){
        let style="";
        if(key0===0){
            style=" style='background-color:rgb(253, 232, 232);'";
        }
        if(key0===6){
            style=" style='background-color:rgb(236, 236, 255);'";
        }        
        cal_html+="<li class='week_title'"+style+">"+val0+"曜日</li>";
      });
      for(let i=0;i<start_num;i++){
        cal_html+="<li class='no_data'></li>";
      }
      $.each(monthly_data, function(key1, val1){
        console.log(val1['main_memo']);
        let class_css="";
        if(val1['day_sum'] > 0){
          class_css=" day_sum_plus";
        } 
        if(val1['day_sum'] < 0){
          class_css=" day_sum_min";
        }
        //今日を表示する
        if(this_day==(month_+"-"+val1['day'])){
          class_css+=" today_css";
        }
        cal_html+="<li title='"+val1['main_memo']+"' class='week_day"+class_css+"'><div><span class='cal_day'>"+val1['day']+"</span></div><div class='cal_amount_box'><span class='cal_amount'>"+numberFormat(val1['day_sum'])+"</span></div></li>";
      });
      cal_html+="</ul>";

  $("#investCalendar").html(cal_html);
}
//
function getGraphForFX(data){
  // Themes begin
  am4core.useTheme(am4themes_material);
  am4core.useTheme(am4themes_animated);
  // Themes end

  // Create chart instance
  var chart = am4core.create("investChart", am4charts.XYChart);
  //chart.legend.position = "right";

  // Add data
  chart.data=data;
  // Create axes
  var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
  categoryAxis.dataFields.category = "day";
  categoryAxis.renderer.grid.template.location = 0;
  categoryAxis.title.text = "日付";
  categoryAxis.renderer.minGridDistance = 25;

  var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
  valueAxis.renderer.inside = false;
  valueAxis.title.text = "金額";
  //valueAxis.renderer.labels.template.disabled = false;
  //valueAxis.min = 0;
  valueAxis.renderer.minGridDistance = 25;

  createSeries("day_sum", "FX投資-儲け額-");

  // Legend
  chart.legend = new am4charts.Legend();
  chart.legend.position = "top";

  // Create series
  function createSeries(field, name) {
    
    // Set up series
    var series = chart.series.push(new am4charts.ColumnSeries());
    series.name = name;
    series.dataFields.valueY = field;
    series.dataFields.categoryX = "day";
    series.dataFields.memo = "main_memo";
    series.sequencedInterpolation = true;
    series.strokeWidth = 0;

    //値がマイナスの場合はバーグラフの色が変わる。
    series.columns.template.adapter.add("fill", function(fill, target) {
      if (target.dataItem && (target.dataItem.valueY < 0)) {
        return am4core.color("red");
      } else {
        return am4core.color("#82c3ff");
      }
    });

    // Make it stacked
    series.stacked = true;
    
    // Configure columns
    series.columns.template.width = am4core.percent(60);
    {literal} 
      series.columns.template.tooltipText = "[bold]{memo}[/]\n[font-size:14px]{valueY}円";
    {/literal}
    
    // Add label
    var labelBullet = series.bullets.push(new am4charts.LabelBullet());
    labelBullet.label.text = "{ valueY }";
    labelBullet.locationY = 1;
    labelBullet.label.hideOversized = true;
    return series;
  }
}



//dairyの作成統計
function generateTotalGrap(data){
  // Themes begin
  am4core.useTheme(am4themes_material);
  am4core.useTheme(am4themes_animated);
  // Themes end

  // Create chart instance
  var chart = am4core.create("chartdiv", am4charts.XYChart);
  //chart.legend.position = "right";

  // Add data
  chart.data=data;
  // Create axes
  var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
  categoryAxis.dataFields.category = "day";
  categoryAxis.renderer.grid.template.location = 0;
  categoryAxis.title.text = "日付";
  categoryAxis.renderer.minGridDistance = 25;

  var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
  valueAxis.renderer.inside = false;
  valueAxis.title.text = "作成回数";
  //valueAxis.renderer.labels.template.disabled = false;
  valueAxis.min = 0;
  valueAxis.renderer.minGridDistance = 25;

  createSeries("private", "個人");
  createSeries("work", "業務");
  createSeries("homework", "宿題");
  createSeries("invest", "投資");
  createSeries("study", "学習");

  // Legend
  chart.legend = new am4charts.Legend();
  chart.legend.position = "top";

  // Create series
  function createSeries(field, name) {
    
    // Set up series
    var series = chart.series.push(new am4charts.ColumnSeries());
    series.name = name;
    series.dataFields.valueY = field;
    series.dataFields.categoryX = "day";
    series.sequencedInterpolation = true;
    series.strokeWidth = 0;

    // Make it stacked
    series.stacked = true;
    
    // Configure columns
    series.columns.template.width = am4core.percent(60);
    {literal} 
      series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:14px]{categoryX}日:{valueY}件";
    {/literal}
    
    // Add label
    var labelBullet = series.bullets.push(new am4charts.LabelBullet());
    labelBullet.label.text = "{ valueY }";
    labelBullet.locationY = 1;
    labelBullet.label.hideOversized = true;
    return series;
  }
}
function numberFormat(num){
  let formatted_num=String(num).replace(/(\d)(?=(\d\d\d)+$)/g, '$1,');
  return formatted_num;
}
</script>

{/block}
</body>
</html>