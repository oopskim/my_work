<?php 

require_once('smarty_base_setting.php');
require_once('common/BaseController.php');
require_once('common/DatabaseUtil.php');
require_once('model/getFamilyData.php');

class familyController extends BaseController{
    private $pdo;
    private $spouse_id=array();
    public function __construct(){
        $this->pdo=DatabaseUtil::connect();
    }
    public function indexAction(){
        $profile=new getFamilyData($this->pdo);
        //親族のプロファイル情報
        $profileResult=$profile->getFamilyData("tbl_family_profile");
        //親族の関係情報
        $relationResult=$profile->getFamilyData("tbl_family_relation");
        //親族のプロファイル情報と関係情報を融合して出力用の配列を作成
        $viewResult=$this->generateView($profileResult, $relationResult);

        $smarty = new Smarty;
        $smarty->assign('list',json_encode($viewResult));
        $smarty->display('family_view.tpl');
    }
    public function generateView($profiles,$relations){
        $view_array=array();
        foreach($profiles as $key1=>$profile){
            $view_array[$key1]['id']=$profile['relative_id'];
            //配偶者の初期値をnullに指定
            $view_array[$key1]['partner']=null;
            $view_array[$key1]['parent_id']=null;
            $view_array[$key1]['child_id']=null;
            $view_array[$key1]['generation_num']=$profile['generation_num'];
            $view_array[$key1]['name']=$profile['name'];
            $view_array[$key1]['gender']=$profile['gender'];

            foreach($relations as $key2=>$relation){
                if($relation['partner_shu']=="1" 
                    && $profile['relative_id']==$relation['from_relative_id']){
                    $view_array[$key1]['partner']=$relation['to_relative_id'];
                    $this->spouse_id[$key1]['id']=$profile['relative_id'];
                    $this->spouse_id[$key1]['spouse_id']=$relation['to_relative_id'];
                }
            }
            foreach($relations as $key2=>$relation){
                //親のIDを確定
                if($relation['child_shu']=="1" && $profile['relative_id']==$relation['from_relative_id']){
                    $view_array[$key1]['parent_id'][]=$relation['to_relative_id'];
                }
                //子供のIDを確定
                if($relation['child_shu']=="1" && $profile['relative_id']==$relation['to_relative_id']){
                    $view_array[$key1]['child_id'][]=$relation['from_relative_id'];
                }
            }
            //var_dump($view_array[$key1]['parent']."<br>");
            //配偶者はいるが、情報がないデータを探して入れる。
            foreach($this->spouse_id as $key2=>$spouse){
                if($view_array[$key1]['id']===$spouse['spouse_id']){
                    $view_array[$key1]['partner']=$spouse['id'];
                }
            }
        }
        return $view_array;
    }
}
?>