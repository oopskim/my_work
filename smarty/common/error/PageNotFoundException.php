<?php 
class PageNotFoundException extends Exception{
    public function __construct($message="ページが見つかりません。"){
        parent::__construct($message, 0, null);
    }
}
?>