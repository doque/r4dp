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
					{foreach $items as $item}
						<div class="options">
							<input type="text" style="width: 20px;" readonly value="{$item.amount}  {$item.name}"/>
						</div>
					{/foreach}
				</div>

				<label for="das">Deposit</label>
				<input readonly type="text" value="{$smarty.session.deposit}"/>

				<label for="">Savings</label>
				<input readonly type="text" value="{$smarty.session.savings}"/>

			</fieldset>
		</div>

		<input type="checkbox" id="toc" name="toc" value="true"/>
		<label for="toc">I accept the terms &amp; conditions</label>

		<input type="checkbox" id="fees" name="fees" value="true"/>
		<label for="fees">I agree to the specified fees</label>
			
		<input type="submit" id="submit" value="Submit Request &raquo;"/>
	</form>





<pre style="font-size: 12px; white-space: pre; font-family: Consolas;">
{$request|print_r}



{$items|print_r}
</pre>


</div>

{/block}