<?php
class keijiban {
    private $pdo;
    public function __construct($pdo){
        $this->pdo = $pdo;
    }
    public function getList(){
        $sql="SELECT * FROM planning_sheet.pagination";
        $stmt=$this->pdo->prepare($sql);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>