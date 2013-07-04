<?php /* Smarty version Smarty-3.1.7, created on 2013-07-04 20:16:52
         compiled from "templates\confirm.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2979651d5bc146e1c15-84695252%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5ce0602380d6c6fbd661c43fb1c422ccefc97757' => 
    array (
      0 => 'templates\\confirm.tpl',
      1 => 1372785156,
      2 => 'file',
    ),
    '86c1854c7ae34b9409258038b632df35d264d682' => 
    array (
      0 => 'templates\\html.tpl',
      1 => 1372961044,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2979651d5bc146e1c15-84695252',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_51d5bc148027b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d5bc148027b')) {function content_51d5bc148027b($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
Confirm Your Request
</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="assets/js/jquery.timepicker.js"></script>
	<script type="text/javascript">
        
        
	

	</script>
	<link rel="stylesheet" href="assets/css/reset.css"/>
	<link rel="stylesheet" href="assets/css/pepper-grinder/jquery-ui-1.8.18.custom.css"/>
	<link rel="stylesheet" href="assets/css/jquery.timepicker.css"/>
	<link rel="stylesheet" href="assets/css/style.css"/>

	
</head>
<body>
	<div id="content">
		


<div id="header">
	<img id="logo" src="assets/img/departmentlogo.gif"/>
</div>

<div id="request">
	<form enctype="application/x-www-form-urlencoded" method="post" action="">


		<input type="hidden" name="sent" value="true"/>


		<div id="userInformation" class="information">
			<fieldset>
				<h3>Your Information:</h3>


				<label for="">Your Name:</label>
				<input readonly type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['user']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
"/>

				<label for="">Your E-Mail Address:</label>
				<input readonly type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['user']->value['email'], ENT_QUOTES, 'UTF-8', true);?>
"/>
				

				<h3>Request Information:</h3>

				<label for="">Date Range:</label>
				<input readonly class="datepicker" type="text" value="<?php echo $_smarty_tpl->tpl_vars['request']->value['date_from'];?>
"/> until <input readonly class="datepicker" type="text" value="<?php echo $_smarty_tpl->tpl_vars['request']->value['date_until'];?>
"/>

				<div class="items clearfix">
					<label for="items">Selected Items:</label>
					<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
						<div class="options">
							<input type="text" style="width: 20px;" readonly value="<?php echo $_smarty_tpl->tpl_vars['item']->value['amount'];?>
  <?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
"/>
						</div>
					<?php } ?>
				</div>

				<label for="das">Deposit</label>
				<input readonly type="text" value="<?php echo $_SESSION['deposit'];?>
"/>

				<label for="">Savings</label>
				<input readonly type="text" value="<?php echo $_SESSION['savings'];?>
"/>

			</fieldset>
		</div>

		<input type="checkbox" id="toc" name="toc" value="true"/>
		<label for="toc">I accept the terms &amp; conditions</label>

		<input type="checkbox" id="fees" name="fees" value="true"/>
		<label for="fees">I agree to the specified fees</label>
			
		<input type="submit" id="submit" value="Submit Request &raquo;"/>
	</form>





<pre style="font-size: 12px; white-space: pre; font-family: Consolas;">
<?php echo print_r($_smarty_tpl->tpl_vars['request']->value);?>




<?php echo print_r($_smarty_tpl->tpl_vars['items']->value);?>

</pre>


</div>


	</div>
</body>
</html>
<?php }} ?>