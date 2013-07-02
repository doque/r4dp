{extends file="html.tpl"}

{block name="title"}
Manage Request
{/block}

{block name='head.scripts' append}
{literal}

	$(function() {
		$("#delete").click(function(e) {
			if (confirm('Are you sure you want to delete this request? This operation can not be undone.')) return true;
			return false;
		});
	});

{/literal}
{/block}


{block name="content"}


<div id="header">
	<img id="logo" src="assets/img/departmentlogo.gif"/>
</div>

<div id="request" class="search">

	{if $success}
		<div class="success">{$success|escape}</div>
		<br/>
		<br/>
	{/if}
	
	{if $error}
		<div class="error">{$error|escape}</div>
		<br/>
		<br/>
	{/if}

	<form enctype="application/x-www-form-urlencoded" method="post" action="">

		<input type="hidden" name="sent" value="true"/>


		<div id="userInformation" class="information">
			<fieldset>
				<h3>Request Information</h3>
				
				<label for="request_id">Request Id:</label>
				<input type="text" name="request_id" value="{$request.quickid}" readonly="true"/>
				
				<label for="user_name">Name: *</label>
				<input type="text" name="user_name" value="{$request.name|escape}" readonly="true"/>

				<label for="user_email">E-Mail Address: *</label>
				<input type="text" name="user_email" value="{$request.email|escape}" readonly="true"/>

				<label for="user_phone">Phone Number: *</label>
				<input type="text" name="user_phone" value="{$request.phone|escape}" readonly="true" />
				
				<label for="user_department">Department/Organization: *</label>
				<input type="text" name="user_department" value="{$request.department|escape}" readonly="true"/>
				
				<label for="user_studentId">Concordia ID:</label>
				<input type="text" name="user_concordiaid" value="{$request.concordiaid|escape}" readonly="true"/>
				
				<label for="user_comment">Comment:</label>
				<textarea id="user_comment" class="comment" name="comment" {if $errors.user_comment}class="error"{/if} readonly="true">{$request.comment_user|escape}</textarea>
				
				
			</fieldset>
		</div>
		
		<div id="requestInformation" class="information">
			<fieldset>
				<h3>Reservation Information</h3>

				<label for="date_from">Date of Reservation:</label>
				<div class="options">
					<input type="text" readonly="true" class="datepicker{if $errors.date_from} error{/if}" name="date_from" id="date_from" value="{$request.date_from|date_format:"%d.%m.%Y"}"/>
					<label for="date_until">until</label>
					<input type="text" readonly="true" class="datepicker{if $errors.date_until} error{/if}" name="date_until" id="date_until" value="{$request.date_until|date_format:"%d.%m.%Y"}"/>
				</div>

				<label for="date_from">Dishes:</label>
				<div class="options" id="dishlist">
					{foreach $request.items as $dish}
						<div class="dishamounts">
							<strong>{$dish.name}:</strong><br/>
							
							<label for="item[{$dish.id}][borrowed]">borrowed:</label>
							<input type="text" readonly="true" class="smalltext" id="item[{$dish.id}][borrowed]" name="item[{$dish.id}][borrowed]" value="{$dish.amount}"/>

							<div class="dishamounts-returns">
								<label for="item[{$dish.id}][amount_returned]">returned:</label>
								<input type="text"  class="smalltext" id="item[{$dish.id}][amount_returned]" name="item[{$dish.id}][amount_returned]" value="{$dish.amount_returned}"/>
								
								<label for="item[{$dish.id}][amount_dirty]">returned dirty:</label>
								<input type="text"  class="smalltext" id="item[{$dish.id}][amount_dirty]" name="item[{$dish.id}][amount_dirty]" value="{$dish.amount_dirty}"/>
								
								<label for="item[{$dish.id}][amount_broken]">returned broken:</label>
								<input type="text" class="smalltext" id="item[{$dish.id}][amount_broken]" name="item[{$dish.id}][amount_broken]" value="{$dish.amount_broken}"/>
							</div>
						</div>
						
					{/foreach}
				</div>
					
			</fieldset>
		</div>

		<div id="administrationInformation" class="information">
			<fieldset>
				<h3>Administration</h3>
			
				<label for="admin_comment"><b>Comment:</b></label>
				<textarea name="admin_comment" class="comment">{$request.comment_admin|escape}</textarea>
			
				<br/>
			
				<label for="admin_status">Edit Request Status:</label>
						
				<div class="request-status">
					<div>
						<input type="checkbox" name="approved" {if $request.approved}checked="true"{/if} id="approved" value="true"/>
						<label for="approved">Approved</label>
						<small class="notify">User will be notified</small>
					</div>
										
					<div>
						<input type="checkbox" name="late" {if $request.late}checked="true"{/if} id="late" value="true"/>
						<label for="late">Late</label>
					</div>
					
					<div>
						<input type="checkbox" name="returned" {if $request.returned}checked="true"{/if} id="returned" value="true"/>
						<label for="returned">Returned</label>
					</div>
					
					<div>
						<input type="checkbox" name="paid" {if $request.paid}checked="true"{/if} id="paid" value="true"/>
						<label for="paid">Paid</label>
					</div>
					
					<div>
						<input type="checkbox" name="cancelled" {if $request.cancelled}checked="true"{/if} id="cancelled" value="true"/>
						<label for="cancelled">Cancelled</label>
					</div>
				</div>
			</fieldset>
		
		</div>

		<input type="submit" id="update" name="update" value="Update Request &raquo;"/> <input type="submit" id="delete" name="delete" value="Delete Request &raquo;"/>
	</form>


</div>
{/block}