<?php
class getInvestData {
    private $pdo;
    public function __construct($pdo){
        $this->pdo = $pdo;
    }
    public function getData($thisMonth){
        $rightNow=date("Y-m-d");
        $sql="SELECT 
                    *
                FROM
                    planning_sheet.invest
                WHERE
                    ins_date LIKE '".$rightNow."%'";
        $stmt=$this->pdo->prepare($sql);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }    
    public function getEventData(){
        $rightNow=date("Y-m-d");
        $afterOneWeek=date('Y-m-d', strtotime('+1 week'));
        $sql="SELECT 
                    event_name,
                    CASE dayofweek(event_start)
                    WHEN 1 THEN concat(DATE_FORMAT(event_start, '%y年%m月%d日'),'(日)',DATE_FORMAT(event_start,' %H時'))
                    WHEN 2 THEN concat(DATE_FORMAT(event_start, '%y年%m月%d日'),'(月)',DATE_FORMAT(event_start,' %H時'))
                    WHEN 3 THEN concat(DATE_FORMAT(event_start, '%y年%m月%d日'),'(火)',DATE_FORMAT(event_start,' %H時'))
                    WHEN 4 THEN concat(DATE_FORMAT(event_start, '%y年%m月%d日'),'(水)',DATE_FORMAT(event_start,' %H時'))
                    WHEN 5 THEN concat(DATE_FORMAT(event_start, '%y年%m月%d日'),'(木)',DATE_FORMAT(event_start,' %H時'))
                    WHEN 6 THEN concat(DATE_FORMAT(event_start, '%y年%m月%d日'),'(金)',DATE_FORMAT(event_start,' %H時'))
                    WHEN 7 THEN concat(DATE_FORMAT(event_start, '%y年%m月%d日'),'(土)',DATE_FORMAT(event_start,' %H時'))
                    END AS event_start
                FROM
                    planning_sheet.invest_calendar
                WHERE
                    event_start between :start and :end 
                ORDER BY event_start";
        $stmt=$this->pdo->prepare($sql);
        $stmt->bindValue(':start',$rightNow);
        $stmt->bindValue(':end',$afterOneWeek);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } 
}