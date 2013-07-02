{extends file="html.tpl"}

{block name="title"}
Manage Requests
{/block}

{block name='head.scripts' append}
{literal}
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
			data: {role: type, requestid: $(this).parents('tr').attr('id').split('-')[1]},
			success: function(e) {
				if (e.success) {
					alert(e.msg);
				}
			}
		});
	});
	
	
});

{/literal}
{/block}


{block name="content"}


<div id="header">
	<img id="logo" src="assets/img/departmentlogo.gif"/>
</div>

<div id="request" class="search">

	<form enctype="application/x-www-form-urlencoded" method="post" action="">

		<div id="requestInformation" class="information">
			<fieldset>
				<h3>Search for Requests</h3>
				<label for="request_id">Request ID:</label>				
				<input type="text" name="request_id" value="{$smarty.post.request_id|escape}" {if $errors.request_id}class="error"{/if}/>
				<label for="user_name">User Name:</label>
				<input type="text" name="user_name" value="{$smarty.post.user_name|escape}" {if $errors.user_name}class="error"{/if}/>
				<label for="user_email">User E-Mail Address:</label>
				<input type="text" name="user_email" value="{$smarty.post.user_email|escape}" {if $errors.user_email}class="error"{/if}/>
				
				<label for="requestStatus">Request Status:</label>
				<div id="requestStatus" class="requestStatus">
					<input type="checkbox" name="approved" id="approved" value="true"/>
					<label for="approved">Approved</label>
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
			
			
			<input type="submit" name="search" id="search" value="Search &raquo;"/>
			
		</div>
		

		<div id="requestInformation" class="information">
			<fieldset>
				<h3>Look up Reservations</h3>

				<label for="date_from">Date of Reservation:</label>
				<div class="options">
					<input type="text" class="datepicker{if $errors.date_from} error{/if}" name="date_from" id="date_from" value="{$smarty.post.date_from|escape}"/>
					<label for="date_until">until</label>
					<input type="text" class="datepicker{if $errors.date_until} error{/if}" name="date_until" id="date_until" value="{$smarty.post.date_until|escape}"/>
				</div>


				<div class="items clearfix">
					<label for="amount">Requested Dishes:</label>
					{html_options name='item_id' options=$items selected=$item}
				</div>
				
			</fieldset>
		</div>

		<input type="submit" name="lookup" id="lookup" value="Look Up &raquo;"/>
	</form>


	{if $requests}
	<br/>
	<br/>
	<br/>
		<h3>These Requests were found:</h3>
		<div id="requests">
			<table>
				<thead>
					<tr>
						<th>Request ID</th>
						<th>Student Information</th>
						<th>Dates</th>
						<th>Requested Items</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					{foreach $requests as $request}
						{assign var="class" value={cycle values="even, odd"}}
						<tr id="request-{$request.requestid}" class="{$class}">
							<td class="request-quickid">{$request.quickID}</td>
							<td class="request-userinformation">
								<div>{$request.name}</div>
								<div>{$request.email}</div>
								<div>{$request.studentId}</div>
							</td>
							<td class="request-dates">{$request.date_from|date_format:"%d.%m.%Y"} until {$request.date_until|date_format:"%d.%m.%Y"}</td>
							<td class="request-items">
								{foreach $request.items as $dish}
									<div>{$dish.amount} {$dish.name}</div>
								{/foreach}
							</td>
							<td class="actions">
								<a href="request.php?id={$request.requestid}">Edit this Request</a>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	{/if}

</div>

{/block}