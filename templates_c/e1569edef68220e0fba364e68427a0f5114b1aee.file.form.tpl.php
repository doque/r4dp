<?php /* Smarty version Smarty-3.1.7, created on 2013-07-04 20:18:03
         compiled from "templates\form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2764451d5bc5b89c032-88357754%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e1569edef68220e0fba364e68427a0f5114b1aee' => 
    array (
      0 => 'templates\\form.tpl',
      1 => 1372961798,
      2 => 'file',
    ),
    '86c1854c7ae34b9409258038b632df35d264d682' => 
    array (
      0 => 'templates\\html.tpl',
      1 => 1372961044,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2764451d5bc5b89c032-88357754',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_51d5bc5bc2a43',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d5bc5bc2a43')) {function content_51d5bc5bc2a43($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'C:\\Dropbox\\Apps\\xampp\\htdocs\\concordia\\inc\\classes\\Smarty-3.1.7\\libs\\plugins\\function.html_options.php';
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
Submit new Request
</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="assets/js/jquery.timepicker.js"></script>
	<script type="text/javascript">
        
        

	$(function() {
	
		$('.tooltip').tooltip();
	
		$('.datepicker').datepicker({
			//dateFormat: "d.m.Y",
			beforeShowDay: function(date) {
				 return [(date.getDay() != 6 && date.getDay() != 0), ""]
			}, // only allow weekdays
			minDate: 7 // one week in advance
		});
		$('.timepicker').timepicker({
			minTime: "9:00am",
			maxTime: "5:00pm",
			timeFormat: "H:i",
			step: 15 // 15 minute increments
		});
        
        $('.selectitems option').click(function() {
        	// selectable amounts for this items
        	var amounts = $.parseJSON($(this).attr('data-amounts'));
        	console.log(amounts);
        	var availables = $(this).parent().prev().children().each(function() {
        		if (amounts.indexOf(parseInt(this.value)) == -1) {
        			$(this).hide();
        		} else {
        			$(this).show();
        		}
        	});
        	
        });
        
		var items = 1;
        $('a#more_items').click(function(e) {
            e.preventDefault();
			var n = $('#option_preset').clone().addClass('more').attr('id', 'option_preset'+(items++)).appendTo('.items').find("small").remove();
            n.find('option:selected').removeAttr('selected');
			
        });
	});


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
				<h3>Personal Information</h3>
				
				

				<?php if ($_smarty_tpl->tpl_vars['errors']->value){?>
				<div class="error">

					<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['errors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
					<ul>
						<li><?php echo $_smarty_tpl->tpl_vars['errors']->value[$_smarty_tpl->tpl_vars['k']->value];?>
</li>
					</ul>
					<?php } ?>
				</div>
				<?php }?>
			
				<label for="user_name">Full Name: *</label>
				<input type="text" id="user_name" name="user_name" value="<?php echo htmlspecialchars($_POST['user_name'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['errors']->value['user_name']){?>class="error"<?php }?>/>

				<label for="user_address">Address: *</label>
				<textarea class="comment text<?php if ($_smarty_tpl->tpl_vars['errors']->value['user_address']){?> error<?php }?>" id="user_address" name="user_address"><?php echo htmlspecialchars($_POST['user_address'], ENT_QUOTES, 'UTF-8', true);?>
</textarea>

				<label for="user_email">E-Mail Address: *</label>
				<input type="text" id="user_email" name="user_email" value="<?php echo htmlspecialchars($_POST['user_email'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['errors']->value['user_email']){?>class="error"<?php }?>/>

				<label for="user_phone">Phone Number: *</label>
				<input type="text" id="user_phone" name="user_phone" value="<?php echo htmlspecialchars($_POST['user_phone'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['errors']->value['user_phone']){?>class="error"<?php }?>/>
				
				<label for="user_department">Department/Organization: *</label>
				<input type="text" id="user_department" name="user_department" value="<?php echo htmlspecialchars($_POST['user_department'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['errors']->value['user_department']){?>class="error"<?php }?>/>
				
				<label for="user_concordiaid">Your Concordia ID:</label>
				<input type="text" class="tooltip" title="A valid Concordia alumni, staff or student ID must be presented at pick-up.
				An off-campus fee applies otherwise. Non-Concordia community members must show a government-issued ID." id="user_concordiaid" name="user_concordiaid" value="<?php echo htmlspecialchars($_POST['user_concordiaid'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['errors']->value['user_concordiaid']){?>class="error"<?php }?>/>
				
				<label for="user_comment">Comment:</label>
				<textarea class="comment text" id="user_comment" name="user_comment" <?php if ($_smarty_tpl->tpl_vars['errors']->value['user_comment']){?>class="error"<?php }?>><?php echo htmlspecialchars($_POST['user_comment'], ENT_QUOTES, 'UTF-8', true);?>
</textarea>
				
				<small id="required_notice">* required fields</small>
			</fieldset>
		</div>

		<div id="requestInformation" class="information">
			<fieldset>
				<h3>Reservation Information</h3>

				<label for="date_from">Date of Reservation:</label>
				<div class="options">
					<input type="text" class="datepicker<?php if ($_smarty_tpl->tpl_vars['errors']->value['date_from']){?> error<?php }?>" name="date_from" id="date_from" value="<?php echo htmlspecialchars($_POST['date_from'], ENT_QUOTES, 'UTF-8', true);?>
"/>
					<input type="text" class="timepicker<?php if ($_smarty_tpl->tpl_vars['errors']->value['date_from']){?> error<?php }?>" name="time_from" id="time_from" value="<?php echo htmlspecialchars($_POST['time_from'], ENT_QUOTES, 'UTF-8', true);?>
"/>
					<label for="date_until">until</label>
					<input type="text" class="datepicker<?php if ($_smarty_tpl->tpl_vars['errors']->value['date_until']){?> error<?php }?>" name="date_until" id="date_until" value="<?php echo htmlspecialchars($_POST['date_until'], ENT_QUOTES, 'UTF-8', true);?>
"/>
					<input type="text" class="timepicker<?php if ($_smarty_tpl->tpl_vars['errors']->value['date_until']){?> error<?php }?>" name="time_until" id="time_until" value="<?php echo htmlspecialchars($_POST['time_until'], ENT_QUOTES, 'UTF-8', true);?>
"/>
					
				</div>
				
				<br/>
				<label for="">Cleaning Preference:</label>
				<div class="options more">
				<input type="radio" name="cleaning" id="cleaning-user" value="user" <?php if (empty($_POST['cleaning'])||$_POST['cleaning']=="user"){?> checked<?php }?>/> 
				<label for="cleaning-user">I will return all dishes clean and dry.</label><br/>
				<input type="radio" name="cleaning" id="cleaning-facility" value="facility" <?php if ($_POST['cleaning']=="facility"){?>checked<?php }?>/>
				<label for="cleaning-facility">I will clean the dishes myself in your facility. ($0.03/piece)</label><br/>
				<input type="radio" name="cleaning" id="cleaning-dirty" value="dirty" <?php if ($_POST['cleaning']=="dirty"){?>checked<?php }?>>
				<label for="cleaning-dirty">I will return the dishes dirty, please clean them for me. ($0.05/piece)</label>
				</div>

				<br/>
				
				
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
											These are not available for the selected dates.
                                        <?php }else{ ?>
                                            Only <?php echo $_smarty_tpl->tpl_vars['itemsAvailable']->value[$_smarty_tpl->tpl_vars['item']->value];?>
 available.
                                        <?php }?>
                                    </small>
                                <?php }else{ ?>
                                    <small class="success">These are available.</small>
                                <?php }?>
                            <?php }?>
                        </div>
                    <?php }
if (!$_smarty_tpl->tpl_vars['amount']->_loop) {
?>
                        
                        <div class="options" id="option_preset">
                        	<select class="selectamounts" name="item_amounts[]">
                        		<?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['maxAvailable']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
?>
                        			<option value="<?php echo $_smarty_tpl->tpl_vars['a']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['a']->value;?>
</option>
                        		<?php } ?>
                        	</select>
                        	<select class="selectitems" name="item_id[]">
                        		<option value="">Please select a dish</option>
                        		<option value="">--</option>
	                        	<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
	                        		<option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" data-amounts="<?php echo json_encode($_smarty_tpl->tpl_vars['item']->value['amounts']);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
	                        	<?php } ?>
                        	</select>
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