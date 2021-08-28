function displayFamily(list){
    let personList={};
    personList['2']=new Array;
    personList['1']=new Array;
    personList['0']=new Array;
    personList['-1']=new Array;
    personList['-2']=new Array;
    $.each(personList, function(k1, v1){
        $.each(list, function(k2, v2){
            if(k1===v2['generation_num']){
                personList[k1].push(v2);
            }
        });
    });
    console.log(personList);
    let html="";

    $.each(personList,function(_key1,_val1){
        $.each(_val1,function(_key2,_val2){
            let style="";
            let base_left=200;

            if(_val2['gender']==="1"){
                style=" background-color:#24448f;"
            } else {
                style=" background-color:#e61ebe;"
            }
            //_key1:generation_num
            switch(_key1){
                case '0':
                    left_start=100;
                    for(let i=0;i<_val1.length;i++){
                        style+="top:90px;"
                        if(_key2===i){
                            style+=" left:"+(left_start + (base_left * i))+"px'";
                            break;
                        }
                    }
                    if(_val2['partner']!==null && _key2===0){
                        html+="<div id='partner0' class='person_box' style='width:50px; top:90px; left:225px; background-color:red;'>--a--</div>";
                    }
                    break;
                case '1':
                    left_start=0;
                    for(let i=0;i<_val1.length;i++){
                        style+="top:10px;"
                        if(_key2===i){
                            style+=" left:"+(base_left * i)+"px'";
                            break;
                        }
                    }
                    if(_val2['partner']!==null && _key2===0){
                        html+="<div id='partner1' class='person_box' style='width:50px; top:10px; left:125px; background-color:pink;'>--b--</div>";
                    }
                    break;
                case '-1':
                    left_start=0;
                    for(let i=0;i<_val1.length;i++){
                        style+="top:170px;"
                        if(_key2===i){
                            style+=" left:"+(base_left * i)+"px'";
                            break;
                        }
                    }
                    if(_val2['partner']!==null && _key2===0){
                        html+="<div id='partner_m1' class='person_box' style='width:50px; top:170px; left:200px; background-color:purple;'>--b--</div>";
                    }
                    break;
                case '-2':
                    left_start=150;
                    for(let i=0;i<_val1.length;i++){
                        style+="top:250px;"
                        if(_key2===i){
                            style+=" left:"+(base_left * i)+"px'";
                            break;
                        }
                    }
                    if(_val2['partner']!==null && _key2===0){
                        html+="<div id='partner_m2' class='person_box' style='width:50px; top:150px; left:200px; background-color:pink;'>--b--</div>";
                    }
                    break;
                default:
                    style="";
                    break;
            }
            html+="<div id='person_"+_val2['id']+"' class='person_box' style='"+style+"'>"+_val2['name']+"</div>";
        });
    });
    $("#content_box").html(html);
    jsPlumb.ready(function() {
        jsPlumb.importDefaults({ 
            Anchors : [ "BottomCenter", "TopCenter" ],
            ConnectionsDetachable:false,
            EndpointStyle:{ fill: "transparent" },
            Connector:"Flowchart"
        });
        $.each(list,function(_key3,_val3){
            let from_id="partner"+_val3['generation_num'];
            if(_val3['generation_num']==='-1'){
                from_id="partner_m1";
            }
            if(_val3['generation_num']==='-2'){
                from_id="partner_m2";
            }
            $.each(_val3['child_id'],function(_key4,_val4){
                let to_id="person_"+_val4;
                jsPlumb.connect({
                    source:from_id, 
                    target:to_id
                });
            });
        });
    });
}