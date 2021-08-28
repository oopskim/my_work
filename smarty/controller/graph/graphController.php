<?php 

require_once('smarty_base_setting.php');
require_once('common/BaseController.php');
require_once('common/DatabaseUtil.php');
require_once('model/getGraphData.php');
class graphController extends BaseController{
    private $pdo;
    public function __construct(){
        $this->pdo=DatabaseUtil::connect();
    }
    public function indexAction(){
        $month=!empty(filter_input(INPUT_POST, "month")) ? filter_input(INPUT_POST, "month"):date('m');
        $graph=new getGraphData($this->pdo);
        $graphResult=$graph->getGraphJson($month);
        $fxResult=$graph->getFXresult($month);
        $smarty = new Smarty;
        $smarty->assign('list',json_encode($graphResult));
        $smarty->assign('fxList',json_encode($fxResult));
//var_dump(json_encode($fxResult));
        $smarty->display('graph_view.tpl');
    }
}
?>