{extends file="html.tpl"}

{block name="title"}
Manage Items
{/block}

{block name="content"}


<div id="header">

	<a href="/admin.php" title="Admin Overview"><img id="logo" src="assets/img/departmentlogo.gif"/></a>
</div>



<div id="request" class="search">

	{if $success}
	<div class="success">Quantities successfully changed</div><br/><br/>
	{/if}

	<form enctype="application/x-www-form-urlencoded" method="post" action="">

		<input type="hidden" name="sent" value="true"/>

		<div id="requestInformation" class="information">
			<fieldset>
				<h3>Manage Item Quantities</h3>
				<table>
					{foreach $items as $item}
					<tr>
						<td>
							<label style="margin-top: 0; padding-top: 0;" for="item[{$item.id}]">{$item.name|escape}</label>
						</td>
						<td>
							<input style="width: 80px;" type="number" name="item[{$item.id}]" id="item[{$item.id}]" value="{$item.available}"/>
						</td>
						<td>
							{if $item.description}
								<small class="notify" style="margin-left: 10px;">{$item.description|escape}</small>
							{/if}
						</td>
						</tr>
					{/foreach}
					<tr>
						<td colspan="3">
							<input style="float: right;" type="submit" value="Save Quantities &raquo;"/>
						</td>
					</tr>
				</table>
			</fieldset>
		</div>


	</form>

</div>


{/block}