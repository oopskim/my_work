<?php
/* Smarty version 3.1.39, created on 2021-08-12 08:38:28
  from '/Applications/MAMP/htdocs/smarty/templates/page_header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_61145f749eaa07_28610901',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '71803728dacca4e8162954bb48c8e278245a547f' => 
    array (
      0 => '/Applications/MAMP/htdocs/smarty/templates/page_header.tpl',
      1 => 1627304631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61145f749eaa07_28610901 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_174148185061145f749e95c0_55032657', "header");
}
/* {block "header"} */
class Block_174148185061145f749e95c0_55032657 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'header' => 
  array (
    0 => 'Block_174148185061145f749e95c0_55032657',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="header">
    <ul id="navi_menu_box">
        <li id="family_map"><a href="index.php?md=family">親族関係図</a></li>
        <li id="dairy_view"><a href="index.php?md=dairy">日記</a></li>
        <li id="invest_view"><a href="index.php?md=invest">投資日記</a></li>
        <li id="graph_view"><a href="index.php?md=graph">パターン分析</a></li>
    </ul>
</div>
<?php
}
}
/* {/block "header"} */
}
