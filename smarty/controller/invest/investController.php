<?php 

require_once('smarty_base_setting.php');
require_once('common/BaseController.php');
require_once('common/DatabaseUtil.php');
require_once('model/getInvestData.php');
class investController extends BaseController{
    private $pdo;
    public function __construct(){
        $this->pdo=DatabaseUtil::connect();
    }
    public function indexAction(){
        //$month=!empty(filter_input(INPUT_POST, "month")) ? filter_input(INPUT_POST, "month"):date('m');
        $invest=new getInvestData($this->pdo);
        $dairyResult=$invest->getData($month);
        //getEventData()
        $evenList=$invest->getEventData();
        $smarty = new Smarty;
        $smarty->assign('list',$dairyResult);
        $smarty->assign('evenList',$evenList);
        $smarty->display('invest_view.tpl');
    }
}
?>