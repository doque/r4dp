<?php /* Smarty version Smarty-3.1.7, created on 2012-02-20 20:57:56
         compiled from "templates/admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7275906954f42a5c4ead9d5-46050419%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cdbc753ec07d8d57d926d816f0e718758e490a1b' => 
    array (
      0 => 'templates/admin.tpl',
      1 => 1329764412,
      2 => 'file',
    ),
    'dfd9f1c2473f7f692ef79e64c96fa1bf1393cdc5' => 
    array (
      0 => 'templates/html.tpl',
      1 => 1328378915,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7275906954f42a5c4ead9d5-46050419',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f42a5c52490d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f42a5c52490d')) {function content_4f42a5c52490d($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/www/htdocs/w00b1742/htdocs/concordia/inc/classes/Smarty-3.1.7/libs/plugins/function.html_options.php';
if (!is_callable('smarty_modifier_date_format')) include '/www/htdocs/w00b1742/htdocs/concordia/inc/classes/Smarty-3.1.7/libs/plugins/modifier.date_format.php';
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
Manage Requests
</title>
	<link rel="stylesheet" href="assets/css/humanity/jquery-ui-1.8.17.custom.css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="assets/js/jquery-ui-1.8.17.custom.min.js"></script>
	<script type="text/javascript">
        
        

$(function() {


	$('.datepicker').datepicker({
		dateFormat: "dd/mm/yy"
	});

	$('.manageRequest').click(function() {
	
		var type = $(this).attr('role');
	
		$.ajax({
			dataType: 'json',
			type: 'post',
			url: 'admin.php',
			data: {role: type, requestId: $(this).parents('tr').attr('id').split('-')[1]},
			success: function(e) {
				if (e.success) {
					alert(e.msg);
				}
			}
		});
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

<div id="request" class="search">

	<form enctype="application/x-www-form-urlencoded" method="post" action="">

		<div id="userInformation" class="information">
			<fieldset>
				<h3>Request Information</h3>
				<label for="user_name">User Name:</label>
				<input type="text" name="user_name" value="<?php echo htmlspecialchars($_POST['user_name'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['errors']->value['user_name']){?>class="error"<?php }?>/>
				<label for="request_id">Request ID:</label>				
				<input type="text" name="request_id" value="<?php echo htmlspecialchars($_POST['request_id'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['errors']->value['request_id']){?>class="error"<?php }?>/>
				<label for="user_email">User E-Mail Address:</label>
				<input type="text" name="user_email" value="<?php echo htmlspecialchars($_POST['user_email'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['errors']->value['user_email']){?>class="error"<?php }?>/>
				
				
				<div class="requestStatus">
					<input type="checkbox" name="approved" id="approved" value="true"/>
					<label for="approved">Approved</label>
					<input type="checkbox" name="rejected" id="rejected" value="true"/>
					<label for="rejected">Rejected</label>
					<input type="checkbox" name="late" id="late" value="true"/>
					<label for="late">Late</label>
					<input type="checkbox" name="returned" id="returned" value="true"/>
					<label for="returned">Returned</label>
					<input type="checkbox" name="paid" id="paid" value="true"/>
					<label for="paid">Paid</label>
					<input type="checkbox" name="cancelled" id="cancelled" value="true"/>
					<label for="cancelled">Cancelled</label>
				</div>
			</fieldset>
		</div>
		
		<div id="statusInformation" class="information">
			<fieldset>
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
					<label for="amount">Requested Dishes:</label>
					<?php echo smarty_function_html_options(array('name'=>'item_id','options'=>$_smarty_tpl->tpl_vars['items']->value,'selected'=>$_smarty_tpl->tpl_vars['item']->value),$_smarty_tpl);?>

				</div>
				
			</fieldset>
		</div>

		<input type="submit" id="search" value="Filter &raquo;"/>
	</form>


</div>

<div id="requests">
	<form enctype="application/x-www-form-urlencoded" method="post" action="">
		<input type="hidden" name="sent" value="true"/>
		<table id="requests">
			<thead>
				<tr>
					<th>Student Name</th>
					<th>Student E-Mail</th>
					<th>Student ID</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Requested Items</th>
					<th>Approved</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php  $_smarty_tpl->tpl_vars['request'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['request']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['requests']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['request']->key => $_smarty_tpl->tpl_vars['request']->value){
$_smarty_tpl->tpl_vars['request']->_loop = true;
?>
					<tr id="request-<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
" class="<?php if ($_smarty_tpl->tpl_vars['iteration']->value%2==0){?>even<?php }?>">
						<td><?php echo $_smarty_tpl->tpl_vars['request']->value['name'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['request']->value['email'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['request']->value['studentId'];?>
</td>
						<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['request']->value['date_from'],"%d.%m.%Y");?>
</td>
						<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['request']->value['date_until'],"%d.%m.%Y");?>
</td>
						<td>
							<?php  $_smarty_tpl->tpl_vars['dish'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dish']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['request']->value['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dish']->key => $_smarty_tpl->tpl_vars['dish']->value){
$_smarty_tpl->tpl_vars['dish']->_loop = true;
?>
								<div><?php echo $_smarty_tpl->tpl_vars['dish']->value['amount'];?>
 <?php echo $_smarty_tpl->tpl_vars['dish']->value['name'];?>
</div>
							<?php } ?>
						</td>
						<td><?php if ($_smarty_tpl->tpl_vars['request']->value['approved']==0){?>No<?php }else{ ?>Yes<?php }?></td>
						<td class="actions">
							
							<div>
								<input type="checkbox" name="approved" class="approved" id="approved-<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
"/>
								<label for="approved-<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
">Approved</label>
							</div>
							<div>
								<input type="checkbox" name="rejected" class="rejected" id="rejected-<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
"/>
								<label for="rejected-<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
">Rejected</label>
							</div>
							<div>
								<input type="checkbox" name="late" class="late" id="late-<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
"/>
								<label for="late-<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
">Late</label>
							</div>
								<input type="checkbox" name="returned" class="returned" id="returned-<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
"/>
								<label for="returned-<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
">Returned</label>
							<div>
								<input type="checkbox" name="paid" class="paid" id="paid-<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
"/>
								<label for="paid-<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
">Paid</label>
							</div>
							<div>
								<input type="checkbox" name="cancelled" class="cancelled" id="cancelled-<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
"/>
								<label for="cancelled-<?php echo $_smarty_tpl->tpl_vars['request']->value['requestId'];?>
">Cancelled</label>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</form>

</div>


	</div>
</body>
</html>
<?php }} ?>