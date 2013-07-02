<?php /* Smarty version Smarty-3.1.7, created on 2012-02-20 20:57:47
         compiled from "templates/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10460329424f42a5bbe6bae2-01303460%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b1cc25f7bdc74e91c9dac81e0f2bf6636b66dc12' => 
    array (
      0 => 'templates/form.tpl',
      1 => 1329766051,
      2 => 'file',
    ),
    'dfd9f1c2473f7f692ef79e64c96fa1bf1393cdc5' => 
    array (
      0 => 'templates/html.tpl',
      1 => 1328378915,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10460329424f42a5bbe6bae2-01303460',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f42a5bc1b92f',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f42a5bc1b92f')) {function content_4f42a5bc1b92f($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/www/htdocs/w00b1742/htdocs/concordia/inc/classes/Smarty-3.1.7/libs/plugins/function.html_options.php';
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
			dateFormat: "dd/mm/yy",
			minDate: 7 // one week in advance
		});
        
		var items = 1;
        $('a#more_items').click(function(e) {
            e.preventDefault();
			var n = $('#option_preset').clone().addClass('more').attr('id', 'option_preset'+(items++)).appendTo('.items');
            n.find('option:selected').removeAttr('selected');
			
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
				
				<label for="user_studentId">Your Student ID:</label>
				<input type="text" name="user_studentId" value="<?php echo htmlspecialchars($_POST['user_studentId'], ENT_QUOTES, 'UTF-8', true);?>
"/>
				
				<label for="user_department">Department/Organization:</label>
				<input type="text" name="user_department" value="<?php echo htmlspecialchars($_POST['user_department'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['errors']->value['user_department']){?>class="error"<?php }?>/>
				
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
                    <?php  $_smarty_tpl->tpl_vars['amount'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['amount']->_loop = false;
 $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['selectedItems']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['amount']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['amount']->key => $_smarty_tpl->tpl_vars['amount']->value){
$_smarty_tpl->tpl_vars['amount']->_loop = true;
 $_smarty_tpl->tpl_vars['item']->value = $_smarty_tpl->tpl_vars['amount']->key;
 $_smarty_tpl->tpl_vars['amount']->iteration++;
?>
                        
                        <div class="options <?php if ($_smarty_tpl->tpl_vars['amount']->iteration>1){?>more<?php }?>" <?php if ($_smarty_tpl->tpl_vars['amount']->iteration==1){?>id="option_preset"<?php }?>>
                            <?php echo smarty_function_html_options(array('name'=>'item_amount[]','options'=>$_smarty_tpl->tpl_vars['amounts']->value,'selected'=>$_smarty_tpl->tpl_vars['amount']->value),$_smarty_tpl);?>

                            <?php echo smarty_function_html_options(array('name'=>'item_id[]','options'=>$_smarty_tpl->tpl_vars['items']->value,'selected'=>$_smarty_tpl->tpl_vars['item']->value),$_smarty_tpl);?>

                            <?php if (!empty($_smarty_tpl->tpl_vars['itemsAvailable']->value)){?> 
                                <?php if ($_smarty_tpl->tpl_vars['itemsAvailable']->value[$_smarty_tpl->tpl_vars['item']->value]<$_smarty_tpl->tpl_vars['amount']->value){?>
                                    <small class="error">
                                        <?php if ($_smarty_tpl->tpl_vars['itemsAvailable']->value[$_smarty_tpl->tpl_vars['item']->value]==0){?>
                                            There are none available.
                                        <?php }else{ ?>
                                            There are only <?php echo $_smarty_tpl->tpl_vars['itemsAvailable']->value[$_smarty_tpl->tpl_vars['item']->value];?>
 availabe.
                                        <?php }?>
                                    </small>
                                <?php }else{ ?>
                                    <small class="success">These are available!</small>
                                <?php }?>
                            <?php }?>
                        </div>
                    <?php }
if (!$_smarty_tpl->tpl_vars['amount']->_loop) {
?>
                        
                        <div class="options" id="option_preset">
                            <?php echo smarty_function_html_options(array('name'=>'item_amount[]','options'=>$_smarty_tpl->tpl_vars['amounts']->value),$_smarty_tpl);?>

                            <?php echo smarty_function_html_options(array('name'=>'item_id[]','options'=>$_smarty_tpl->tpl_vars['items']->value),$_smarty_tpl);?>

                        </div>
                    <?php } ?>

				</div>
					<a href="#" id="more_items">Reserve another item</a>
			</fieldset>
		</div>
		

			
			<input type="submit" id="submit" value="Reserve Items &raquo;"/>
	</form>

</div>


	</div>
</body>
</html>
<?php }} ?>