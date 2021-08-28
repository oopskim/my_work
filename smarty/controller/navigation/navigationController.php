<?php 

require_once('smarty_base_setting.php');
require_once('model/keijiban.php');
require_once('common/BaseController.php');

class navigationController extends BaseController{
    private $pdo;
    public function __construct(){
        $this->pdo=DatabaseUtil::connect();
    }
    public function indexAction(){
        $this->getDataFromKeijiban();
    }
    public function getDataFromKeijiban(){
        $keijiban = new keijiban($this->pdo);
        $list = $keijiban->getList();
        $smarty = new Smarty;
        $smarty->assign('list',$list);
        $smarty->display('navi_first.tpl');
    }
}
?>