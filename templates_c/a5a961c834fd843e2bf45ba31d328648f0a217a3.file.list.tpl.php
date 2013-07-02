<?php /* Smarty version Smarty-3.1.7, created on 2012-01-17 21:37:29
         compiled from "html\list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:126464f15c24a42d325-44560513%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a5a961c834fd843e2bf45ba31d328648f0a217a3' => 
    array (
      0 => 'html\\list.tpl',
      1 => 1326832648,
      2 => 'file',
    ),
    '46655248a542182a188b08f8e102d818e46c7e8e' => 
    array (
      0 => 'html\\header.tpl',
      1 => 1326832628,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '126464f15c24a42d325-44560513',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f15c24a4cb38',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f15c24a4cb38')) {function content_4f15c24a4cb38($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Title</title>
	<link rel="stylesheet" href="css/style.css">
	
</head>
<body>
	
<pre>
<?php  $_smarty_tpl->tpl_vars['dish'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dish']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dish']->key => $_smarty_tpl->tpl_vars['dish']->value){
$_smarty_tpl->tpl_vars['dish']->_loop = true;
?>
	<?php echo $_smarty_tpl->tpl_vars['dish']->value["name"];?>
 (available: <?php echo $_smarty_tpl->tpl_vars['dish']->value["amount_available"];?>
)
<?php } ?>
</pre>

</body>
</html>
<?php }} ?>