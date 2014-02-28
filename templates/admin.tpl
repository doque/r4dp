{extends file="html.tpl"}

{block name="title"}
Manage Requests
{/block}

{block name='head.scripts' append}
{literal}
$(function() {


	$('.datepicker').datepicker({
		dateFormat: "dd.mm.yy"
	});
	
});

{/literal}
{/block}


{block name="content"}


<div id="header">
	<a href="/admin.php" title="Admin Overview"><img id="logo" src="assets/img/departmentlogo.gif"/></a>
</div>

<div id="request" class="search">

	<form enctype="application/x-www-form-urlencoded" method="post" action="">

		<div id="requestInformation" class="information">
			<fieldset>
				<h3>Search for Requests</h3>
				<label for="quickid">Request ID:</label>				
				<input type="text" name="quickid" value="{$smarty.post.quickid|escape}" {if $errors.quickid}class="error"{/if}/>
				<label for="user_name">User Name:</label>
				<input type="text" name="user_name" value="{$smarty.post.user_name|escape}" {if $errors.user_name}class="error"{/if}/>
				<label for="user_email">User E-Mail Address:</label>
				<input type="text" name="user_email" value="{$smarty.post.user_email|escape}" {if $errors.user_email}class="error"{/if}/>
				
				<label for="status">Request Status:</label>
				<div id="status" class="requestStatus">
					<select name="status">
						<option value="">Any</option>
						<option {if $smarty.post.status == "pending"}selected{/if} value="pending">Pending</option>
						<option {if $smarty.post.status == "received"}selected{/if} value="received">Received</option>
						<option {if $smarty.post.status == "approved"}selected{/if} value="approved">Approved</option>
						<option {if $smarty.post.status == "declined"}selected{/if} value="declined">Declined</option>
						<option {if $smarty.post.status == "delivered"}selected{/if}  value="delivered">Delivered</option>
						<option {if $smarty.post.status == "returned"}selected{/if}  value="returned">Returned</option>
						<option {if $smarty.post.status == "followup"}selected{/if}  value="followup">Follow-Up</option>
					</select>
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
				{*

				<div class="items clearfix">
					<label for="item_id">Requested Dishes:</label>
					<select name="item_id" id="item_id">
						{foreach $items as $itemid => $itemname}
							<option value="{$itemid}" {if $smarty.post.itemid == $itemid}selected{/if}>{$itemname|escape}</option>
						{/foreach}
					</select>
				</div>
			*}
				
			</fieldset>
		</div>

		<input type="submit" name="lookup" id="lookup" value="Look Up &raquo;"/>
	</form>


	{if count($requests) > 0}
	<br/>
	<br/>
	<br/>
		<h3>These Requests were found:</h3>
		<div id="requests">
			<table>
				<thead>
					<tr>
						<th>Reference Number</th>
						<th>Client Information</th>
						<th>Dates</th>
						<th>Requested Items</th>
						<th>Request Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					{foreach $requests as $request}
						{assign var="class" value={cycle values="even, odd"}}
						<tr id="request-{$request.requestid}" class="{$class}">
							<td class="request-quickid">
								{$request.quickid}
							</td>
							<td class="request-userinformation">
								<div><strong>{$request.name}</strong></div>
								<div><a href="mailto:{$request.email}">{$request.email}</a></div>
								{if $request.concordiaid}
									<div>Concordia-ID: {$request.concordiaid	}</div>
								{/if}
							</td>
							<td class="request-dates">{$request.date_from|date_format:"%d.%m.%Y %H:%M:%S"} until {$request.date_until|date_format:"%d.%m.%Y %H:%M:%S"}</td>
							<td class="request-items">
								<ul>
									{foreach $request.items as $dish}
										<li>{$dish.amount} {$dish.name}</li>
									{/foreach}
								</ul>
							</td>
							<td class="request-status">
								<div class="status status-{$request.status}">{$request.status}</div>
							</td>
							<td class="actions">
								<a href="request.php?id={$request.requestid}">Edit this Request</a>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	{else}
		<h2>No requests were found, please try some other search parameters.</h2>
	{/if}

</div>

{/block}