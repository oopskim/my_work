<?php 
// load Smarty library
require('Smarty.class.php');

$smarty = new Smarty;
$smarty->template_dir = '/Applications/MAMP/htdocs/smarty/templates';
$smarty->config_dir = ' /Applications/MAMP/htdocs/smarty/config';
$smarty->cache_dir = '/Applications/MAMP/htdocs/etc/cache';
$smarty->compile_dir = '/Applications/MAMP/htdocs/etc/templates_c';

?>