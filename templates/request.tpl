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
	<a href="/admin.php" title="Admin Overview"><img id="logo" src="assets/img/departmentlogo.gif"/></a>
</div>

<div id="request" class="search">

	{if $success}
		<div class="success">Request was updated.</div>
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
		<input type="hidden" name="id" value="{$request.id}"/>

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
							<input type="text" class="smalltext" id="item[{$dish.id}][borrowed]" name="item[{$dish.id}][borrowed]" value="{$dish.amount}"/>

							<label for="item[{$dish.id}][amount_returned]">returned:</label>
							<input type="text"  class="smalltext" id="item[{$dish.id}][amount_returned]" name="item[{$dish.id}][amount_returned]" value="{$dish.amount_returned}"/>
						</div>
						
					{/foreach}
				</div>
					
			</fieldset>
		</div>

		<div id="administrationInformation" class="information">
			<fieldset>
				<h3>Administration</h3>
			
				<label for="admin_comment"><b>Comment:</b></label>
				<textarea name="admin_comment" class="comment">{$request.admin_comment|escape}</textarea>
			
				<br/>

				<label for="admin_deposit_text"><b>Deposit Calculation:</b></label>
				<div id="dishlist" class="options">
					<ul id="deposit_information" class="paddedList">
						{$request.deposit_text}
					</ul>
				</div>
			
				<br/>
				<br/>

				<label for="admin_status">Edit Request Status:</label>
						
				<div class="request-status">
					<div>
						<select name="status" onchange="if($(this).val() == 'approved' || $(this).val() == 'declined') $('.notify').show(); else $('.notify').hide();">
							<option {if $request.status == "pending"}selected{/if} value="pending">Pending</option>
							<option {if $request.status == "received"}selected{/if} value="received">Received</option>
							<option {if $request.status == "approved"}selected{/if} value="approved">Approved</option>
							<option {if $request.status == "declined"}selected{/if} value="declined">Declined</option>
							<option {if $request.status == "delivered"}selected{/if}  value="delivered">Delivered</option>
							<option {if $request.status == "returned"}selected{/if}  value="returned">Returned</option>
							<option {if $request.status == "followup"}selected{/if}  value="followup">Follow-Up</option>
						</select>
						<small class="notify hide">User will be notified</small>
					</div>
				</div>
			</fieldset>
		
		</div>

		<input type="submit" id="update" name="update" value="Update Request &raquo;"/> <input type="submit" id="delete" style="float: right;" name="delete" value="Delete Request &raquo;"/>
	</form>


</div>
{/block}