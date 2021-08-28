<?php
/* Smarty version 3.1.39, created on 2021-08-13 08:12:25
  from '/Applications/MAMP/htdocs/smarty/templates/family_view.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6115aad9b4a237_23114471',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3fee5054a379461b8cc1bf2bd9225efb433d0a06' => 
    array (
      0 => '/Applications/MAMP/htdocs/smarty/templates/family_view.tpl',
      1 => 1628509976,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:page_header.tpl' => 1,
  ),
),false)) {
function content_6115aad9b4a237_23114471 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo '<script'; ?>
 src="js/jquery-3.6.0.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/1.12.1/jquery-ui.min.js"><?php echo '</script'; ?>
>
    <link type="text/css" rel="stylesheet" href="css/common.css">
    <link type="text/css" rel="stylesheet" href="css/family.css?ver=2">
    <link type="text/css" rel="stylesheet" href="css/jquery-ui.min.css"/>
    <title>親族関係図</title>
</head>
<body>
    <?php $_smarty_tpl->_subTemplateRender('file:page_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <div id="menu_arrow_box">
        <div id="menu_arrow"></div>
    </div>    
    <div id="main_container">
        <div id="content_box"></div>
    </div>
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4721656326115aad9b42c10_95129950', "family_view");
?>

</body>
</html><?php }
/* {block "family_view"} */
class Block_4721656326115aad9b42c10_95129950 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'family_view' => 
  array (
    0 => 'Block_4721656326115aad9b42c10_95129950',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo '<script'; ?>
 type="text/json" src="common/base_setting.json"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="js/family/family.js?ver=0"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="js/jquery.jsPlumb.min.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript">
$(function(){
    let person=<?php echo $_smarty_tpl->tpl_vars['list']->value;?>
;
    displayFamily(person);
});
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "family_view"} */
}
