<?php /* Smarty version Smarty-3.1.7, created on 2012-01-22 19:05:02
         compiled from "tpl\list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:165624f1c4fce519583-40620495%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8254efe0cba1a8fff264b1e5350e2472617465ee' => 
    array (
      0 => 'tpl\\list.tpl',
      1 => 1327255497,
      2 => 'file',
    ),
    '8e66305ba4bb7982307a893e4dba8f87e18e007f' => 
    array (
      0 => 'tpl\\header.tpl',
      1 => 1327255372,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '165624f1c4fce519583-40620495',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f1c4fce59749',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f1c4fce59749')) {function content_4f1c4fce59749($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Title</title>
	<link rel="stylesheet" href="assets/css/redmond/jquery-ui-1.8.17.custom.css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
	<script type="text/javascript">
	$(function() {
		$('.datepicker').datepicker();
	});
	</script>
	<link rel="stylesheet" href="assets/style.css">
	
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