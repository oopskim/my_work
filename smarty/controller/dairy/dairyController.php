<?php 

require_once('smarty_base_setting.php');
require_once('common/BaseController.php');
require_once('model/getDairyData.php');
require_once('common/DatabaseUtil.php');
class dairyController extends BaseController{
    private $pdo;
    public function __construct(){
        $this->pdo=DatabaseUtil::connect();
    }
    public function indexAction(){
        $pageNo=!empty(filter_input(INPUT_GET, "page")) ? filter_input(INPUT_GET, "page"):0;
        $pageDrct=!empty(filter_input(INPUT_GET, "drct")) ? filter_input(INPUT_GET, "drct"):"";
        $pageCate=!empty(filter_input(INPUT_GET, "cate")) ? filter_input(INPUT_GET, "cate"):"";
        $dataSet=new getDairyData($this->pdo);
        $result=$dataSet->getItems($pageNo, $pageDrct, $pageCate);
        $smarty = new Smarty;
        $smarty->assign('list',$result);
        if($result['dairy_view_flg']==="0"){
            $smarty->display('dairy_veiw_block.tpl');
        } else {
            $smarty->display('dairy_veiw_list.tpl');
        }
    }
}
?>