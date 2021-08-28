<?php
class getFamilyData {
    private $pdo;
    public function __construct($pdo){
        $this->pdo = $pdo;
    }
    public function getFamilyData($table_name){
        $sql="SELECT 
                *
            FROM
                planning_sheet.".$table_name;
        $stmt=$this->pdo->prepare($sql);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}