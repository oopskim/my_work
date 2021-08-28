<?php
require_once('smarty_base_setting.php');
//require_once('smarty_base_setting.php');
require_once('common/error/PageNotFoundException.php');

try{
    routeController();
} catch (AppException $ex){
    header("HTTP/1.1 404 Not Found");
    $smarty->display('page_not_found.tpl');
}

function routeController(){
    $inputType=$_SERVER["REQUEST_METHOD"]==="GET" ? INPUT_GET : INPUT_POST;
    $route=explode('-', filter_input($inputType, "md"));
    $crtl_name=$route[0] !== '' ? $route[0] : "navigation";
    $action=isset($route[1]) && $route[1] !== "" ? $route[1]:"index";
    $controller= createController($crtl_name);
    $controller->action($action);
}
function createController($crtl_name){
    $className="{$crtl_name}Controller";
    $file=__DIR__."/controller/$crtl_name/$className.php";
    if(file_exists($file)){
        include_once $file;
        return new $className();
    } else {
        throw new PageNotFoundException("$crtl_name controller not found");
    }
}
// $smarty->assign('name','kino2pyo!');
// $smarty->display('smarty.tpl');


?>

