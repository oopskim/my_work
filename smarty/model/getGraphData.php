<?php
class getGraphData {
    private $pdo;
    public function __construct($pdo){
        $this->pdo = $pdo;
    }
    public function getGraphJson($thisMonth){
        $categoryList=["private"=>"個人","study"=>"学習","work"=>"業務","homework"=>"宿題","invest"=>"投資"];
        $thisYear=date('Y');
        //該当月の日数
        $oneMonthDay=date( 't' , strtotime($thisYear ."/" . $thisMonth . "/01"));

        $finalResult=array();
        for($i=1;$i<=$oneMonthDay;$i++){
            if(strlen(strval($i))<2){
                $targetDay="0".$i;
            } else {
                $targetDay=$i;
            }
            $sql="SELECT '".$targetDay."' as day";
            foreach($categoryList as $key=>$val){
                $sql.=", (SELECT 
                        COUNT(category)
                    FROM
                        planning_sheet.dairy
                    WHERE
                        category = '".$val."'
                            AND ins_date LIKE '2021-".$thisMonth."-".$targetDay."%') AS ".$key;
            }
            $stmt=$this->pdo->prepare($sql);
            $stmt->execute();
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            array_push($finalResult,$result);
        }
        return $finalResult;
    }
    public function getFXresult($thisMonth){
        $thisYear=date('Y');
        //該当月の日数
        $oneMonthDay=date( 't' , strtotime($thisYear ."/" . $thisMonth . "/01"));

        $finalResult=array();
        for($i=1;$i<=$oneMonthDay;$i++){
            if(strlen(strval($i))<2){
                $targetDay="0".$i;
            } else {
                $targetDay=$i;
            }
            $sql="SELECT '".$targetDay."' as day";
            $sql.=", ".ceil($targetDay/7)." as week";
            $sql.=", case dayofweek('".$thisYear."-".$thisMonth."-".$targetDay."')
                    when 1 then '日'
                    when 2 then '月'
                    when 3 then '火'
                    when 4 then '水'
                    when 5 then '木'
                    when 6 then '金'
                    when 7 then '土'
                    end as yobi";
            $sql.=", (SELECT 
                        GROUP_CONCAT(memo)
                    FROM
                        planning_sheet.invest
                    WHERE
                        ins_date LIKE '".$thisYear."-".$thisMonth."-".$targetDay."%'
                            AND memo <> ''
                            AND main_flg = 1
                    ORDER BY ins_date DESC) as main_memo";
            $sql.=", (SELECT 
                        CASE
                            WHEN SUM(amount) IS NULL THEN 0
                            ELSE SUM(amount)
                        END
                    FROM
                        planning_sheet.invest
                    WHERE
                        ins_date LIKE '".$thisYear."-".$thisMonth."-".$targetDay."%') AS day_sum";
            $stmt=$this->pdo->prepare($sql);
            $stmt->execute();
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            array_push($finalResult,$result);
        }
        return $finalResult;
    } 

}