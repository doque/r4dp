{extends file="html.tpl"}

{block name="title"}
Confirm Your Request
{/block}

{block name='head.scripts' append}
	
{/block}


{block name="content"}


<div id="header">
	<img id="logo" src="assets/img/departmentlogo.gif"/>
</div>



	

<div id="request">
	{if $errors}
		<div class="error">

			{foreach $errors AS $k=>$v}
			<ul>
				<li>{$errors[$k]}</li>
			</ul>
			{/foreach}
		</div>
	{/if}

	<form enctype="application/x-www-form-urlencoded" method="post" action="">


		<input type="hidden" name="sent" value="true"/>


	
		<div id="userInformation" class="information">
		
			
			<fieldset>
				<h3>Your Information:</h3>


				<label for="">Your Name:</label>
				<input readonly type="text" value="{$user.name|escape}"/>

				<label for="">Your E-Mail Address:</label>
				<input readonly type="text" value="{$user.email|escape}"/>
				

				<h3>Request Information:</h3>

				<label for="">Date Range:</label>
				<input readonly class="datepicker" type="text" value="{$request.date_from}"/> until <input readonly class="datepicker" type="text" value="{$request.date_until}"/>

				<div class="items clearfix">
					<label for="items">Selected Items:</label>
					<div class="options more">
						<div>
							<u>You selected the following items:</u>
							<ul>
								{foreach $items as $item}
									{if $item.autoadded == 1} {continue} {/if} {* only show user-added items here*}
									<li style="margin-top: 5px;">
										<strong style="font-size: 20px">{$item.amount}</strong> x {$item.name}
									</li>
								{/foreach}
							</ul>
							<br/>
							
							<u>We added the following items for your convenience:</u><br/>
							<ul>
								{foreach $items as $item}
									{if $item.autoadded == 0} {continue} {/if} {* now only show auto-added items here*}
									<li>
										<strong style="font-size: 20px">{$item.amount}</strong> x {$item.name}
									</li>
								{/foreach}
							</ul>
						</div>
					</div>
				</div>
				
				
				<br/>

				<label for="deposit">Deposit:</label>
				<div class="options more">

					<div>
						<u>Your deposit comes to:</u>
						<br/>
						<br/>
						<strong style="font-size: 20px;">${$deposit_rounded}</strong> 
						(<a href="javascript:void(0)" id="view_deposit">Show calculation</a>)
					</div>
					
						<div style="padding-left: 10px;">
							<ul id="deposit_information" class="paddedList">
								<li>{$valueItems|implode:"</li><li>"}
							</ul>
						</div>

				</div>

				<label for="deposit">Savings:</label>
				<div class="options more">
					<div>
						<u>By using Sustainable Concordia's Dish Service, you saved:</u>
						<br/><br/>
						<strong style="font-size: 20px;">${$savings}</strong>
					</div>
				</div>

				<label for="comment_user">Comments:</label>
				<div class="options more">
					<div>
						<p>Do you have any additional comments?</p>
						
						<textarea name="comment_user" rows="5" cols="50">{$smarty.post.comment_user|escape}</textarea>
					</div>
				</div>

				<label for="terms">Terms &amp; Conditions:</label>
				<div class="options more">
					<div>
						
						<p>Once you submit your request, an administrator will review it. If your request is approved, you will receive an e-mail at the specified address with further instructions.</p>
						<br/>
						<p>Thank you for being sustainable!</p>
						
						<div>
							<input type="checkbox" id="toc" name="toc" value="true" {if isset($smarty.post.toc)}checked{/if}/>
							<label for="toc">I accept the <a href="#">terms &amp; conditions.</a></label>
						</div>
				
				
						<div>
							<input type="checkbox" id="fees" name="fees" value="true"{if isset($smarty.post.fees)}checked{/if}/>
							<label for="fees">I agree to the specified fees.</label>
						</div>
						<input type="submit" id="submit" value="Submit Request &raquo;"/>
					</div>
				</div>

			</fieldset>
		</div>
	</form>


<script>
{literal}
$(function() {
	$('#deposit_information').hide();
	$('#view_deposit').click(function() {
		$('#deposit_information').toggle();
	});
});

{/literal}
</script>



</div>

{/block}