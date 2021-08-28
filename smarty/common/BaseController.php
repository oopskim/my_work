<?php
require_once('common/DatabaseUtil.php');
require_once('common/Config.php');
require_once('common/Logger.php');
require_once('common/error/PageNotFoundException.php');
class BaseController{
    private $actionName = null;
    protected $actionMethodSuffix = "Action";
    public function action($action){
        $actionMethod="{$action}{$this->actionMethodSuffix}";
        if(!method_exists($this, $actionMethod)){
            throw new PageNotFoundException(get_class($this)."::$actionMethod not found");
        }
        $tmp = $this->actionName;
        $this->actionName = $action;
        $this->$actionMethod();
        $this->actionName = $tmp;
    }
}
?>