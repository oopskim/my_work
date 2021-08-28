<?php
class DatabaseUtil {
    public static function connect(){
        $dsn = 'mysql:dbname=planning_sheet;host=localhost';
        $user = 'root';
        $password = 'root';
        try{
            $pdo = new PDO($dsn, $user, $password);
            return $pdo;
        }catch (PDOException $e){
            print('Connection failed:'.$e->getMessage());
            die();
        }
    }
}
?>