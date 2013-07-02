<?php /* Smarty version Smarty-3.1.7, created on 2012-01-30 02:05:14
         compiled from "tpl\form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:191644f1c51484824d1-81087372%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f5f8e8cd5954398323f6fb233ca2a097b1526a6d' => 
    array (
      0 => 'tpl\\form.tpl',
      1 => 1327885511,
      2 => 'file',
    ),
    '73b8ba1aa7070f96acb3ffc5d0b6b0c927673882' => 
    array (
      0 => 'tpl\\html.tpl',
      1 => 1327883595,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '191644f1c51484824d1-81087372',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f1c51484b060',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f1c51484b060')) {function content_4f1c51484b060($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'D:\\Dropbox\\Apps\\xampp\\htdocs\\concordia\\inc\\classes\\Smarty-3.1.7\\libs\\plugins\\function.html_options.php';
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
Submit new Request
</title>
	<link rel="stylesheet" href="assets/css/humanity/jquery-ui-1.8.17.custom.css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="assets/js/jquery-ui-1.8.17.custom.min.js"></script>
	<script type="text/javascript">
	$(function() {
		$('.datepicker').datepicker({
			dateFormat: "dd/mm/yy"
		});
	});
	</script>
	<link rel="stylesheet" href="assets/css/reset.css"/>
	<link rel="stylesheet" href="assets/css/style.css"/>

	
</head>
<body>
	<div id="content">
		


<div id="header">
	<img id="logo" src="assets/img/logo.jpg"/>
</div>

<div id="request">
	<form enctype="application/x-www-form-urlencoded" method="post" action="">


		<input type="hidden" name="sent" value="true"/>


		<?php if ($_smarty_tpl->tpl_vars['errors']->value){?>
		<div class="error">
			Please fill out all of the required information.
		</div>
		<br/>
		<?php }?>

		<div id="userInformation" class="information">
			<fieldset>
				<h3>Personal Information</h3>
				<label for="user_name">Your Name:</label>
				<input type="text" name="user_name" value="<?php echo htmlspecialchars($_POST['user_name'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['errors']->value['user_name']){?>class="error"<?php }?>/>

				<label for="user_email">Your E-Mail Address:</label>
				<input type="text" name="user_email" value="<?php echo htmlspecialchars($_POST['user_email'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['errors']->value['user_email']){?>class="error"<?php }?>/>

				<label for="user_phone">Your Phone Number:</label>
				<input type="text" name="user_phone" value="<?php echo htmlspecialchars($_POST['user_phone'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['errors']->value['user_phone']){?>class="error"<?php }?>/>
			</fieldset>
		</div>

		<div id="requestInformation" class="information">
			<fieldset>
				<h3>Reservation Information</h3>

				<label for="date_from">Date of Reservation:</label>
				<div class="options">
					<input type="text" class="datepicker<?php if ($_smarty_tpl->tpl_vars['errors']->value['date_from']){?> error<?php }?>" name="date_from" id="date_from" value="<?php echo htmlspecialchars($_POST['date_from'], ENT_QUOTES, 'UTF-8', true);?>
"/>
					<label for="date_until">until</label>
					<input type="text" class="datepicker<?php if ($_smarty_tpl->tpl_vars['errors']->value['date_until']){?> error<?php }?>" name="date_until" id="date_until" value="<?php echo htmlspecialchars($_POST['date_until'], ENT_QUOTES, 'UTF-8', true);?>
"/>
				</div>


				<div class="items clearfix">
					<label for="amount">Dishes to Reserve:</label>
					<div class="options">
						<?php echo smarty_function_html_options(array('name'=>'item_amount','options'=>$_smarty_tpl->tpl_vars['amount']->value,'selected'=>$_smarty_tpl->tpl_vars['selectedAmount']->value),$_smarty_tpl);?>

						<?php echo smarty_function_html_options(array('name'=>'item_id','options'=>$_smarty_tpl->tpl_vars['items']->value,'selected'=>$_smarty_tpl->tpl_vars['selectedItem']->value),$_smarty_tpl);?>

						<small class="success">These are available!</small>
					</div>

					<div class="options more">
						<?php echo smarty_function_html_options(array('name'=>'item_amount','options'=>$_smarty_tpl->tpl_vars['amount']->value,'selected'=>$_smarty_tpl->tpl_vars['selectedAmount']->value),$_smarty_tpl);?>

						<?php echo smarty_function_html_options(array('name'=>'item_id','options'=>$_smarty_tpl->tpl_vars['items']->value,'selected'=>$_smarty_tpl->tpl_vars['selectedItem']->value),$_smarty_tpl);?>

						<small class="notice">There are none available.</small>
					</div>

					<div class="options more">
						<?php echo smarty_function_html_options(array('name'=>'item_amount','options'=>$_smarty_tpl->tpl_vars['amount']->value,'selected'=>$_smarty_tpl->tpl_vars['selectedAmount']->value),$_smarty_tpl);?>

						<?php echo smarty_function_html_options(array('name'=>'item_id','options'=>$_smarty_tpl->tpl_vars['items']->value,'selected'=>$_smarty_tpl->tpl_vars['selectedItem']->value),$_smarty_tpl);?>

						<small class="notice">There are only 12 available.</small>
					</div>
					<a href="#" id="more_items">Reserve another item</a>
				</div>


			</fieldset>
		</div>
		

			
			<input type="submit" id="submit" value="Reserve Items &raquo;"/>
	</form>

</div>


	</div>
</body>
</html>
<?php }} ?>