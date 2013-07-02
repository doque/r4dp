{extends file="html.tpl"}

{block name="title"}
Submit new Request
{/block}

{block name='head.scripts' append}
	$(function() {
		$('.datepicker').datepicker({
			dateFormat: "dd/mm/yy",
			minDate: 7 // one week in advance
		});
        
		var items = 1;
        $('a#more_items').click(function(e) {
            e.preventDefault();
			var n = $('#option_preset').clone().addClass('more').attr('id', 'option_preset'+(items++)).appendTo('.items').find("small").remove();
            n.find('option:selected').removeAttr('selected');
			
        });
	});
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
				<h3>Personal Information</h3>
				
				

				{if $errors}
				<div class="error">

					{foreach $errors AS $k=>$v}
					<ul>
						<li>{$errors[$k]}</li>
					</ul>
					{/foreach}
				</div>
				{/if}
			
				<label for="user_name">Your Name: *</label>
				<input type="text" id="user_name" name="user_name" value="{$smarty.post.user_name|escape}" {if $errors.user_name}class="error"{/if}/>

				<label for="user_email">Your E-Mail Address: *</label>
				<input type="text" id="user_email" name="user_email" value="{$smarty.post.user_email|escape}" {if $errors.user_email}class="error"{/if}/>

				<label for="user_phone">Your Phone Number: *</label>
				<input type="text" id="user_phone" name="user_phone" value="{$smarty.post.user_phone|escape}" {if $errors.user_phone}class="error"{/if}/>
				
				<label for="user_department">Department/Organization: *</label>
				<input type="text" id="user_department" name="user_department" value="{$smarty.post.user_department|escape}" {if $errors.user_department}class="error"{/if}/>
				
				<label for="user_concordiaid">Your Concordia ID:</label>
				<input type="text" id="user_concordiaid" name="user_concordiaid" value="{$smarty.post.user_concordiaid|escape}"/>
				
				<label for="user_comment">Comment:</label>
				<textarea class="comment text" id="user_comment" name="user_comment" {if $errors.user_comment}class="error"{/if}>{$smarty.post.user_comment|escape}</textarea>
				
				<small id="required_notice">* required fields</small>
			</fieldset>
		</div>

		<div id="requestInformation" class="information">
			<fieldset>
				<h3>Reservation Information</h3>

				<label for="date_from">Date of Reservation:</label>
				<div class="options">
					<input type="text" class="datepicker{if $errors.date_from} error{/if}" name="date_from" id="date_from" value="{$smarty.post.date_from|escape}"/>
					<label for="date_until">until</label>
					<input type="text" class="datepicker{if $errors.date_until} error{/if}" name="date_until" id="date_until" value="{$smarty.post.date_until|escape}"/>
				</div>


				<div class="items clearfix">
					<label for="amount">Dishes to Reserve:</label>
                    {foreach $selectedItems key=item item=amount}
                        {* generate selects from submitted data (user has submitted the form) *}
                        <div class="options {if $amount@iteration > 1}more{/if}" {if $amount@iteration == 1}id="option_preset"{/if}>
                            {html_options name='item_amount[]' options=$amounts selected=$amount}
                            {html_options name='item_id[]' options=$items selected=$item}
                            {if !empty($itemsAvailable)} {* if this is empty, other fields are invalid (like date, which would render the available amount calculation useless) *}
                                {if $itemsAvailable[$item] < $amount}
                                    <small class="error">
                                        {if $itemsAvailable[$item] == 0}
											These are not available for the selected dates.
                                        {else}
                                            Only {$itemsAvailable[$item]} available.
                                        {/if}
                                    </small>
                                {else}
                                    <small class="success">These are available.</small>
                                {/if}
                            {/if}
                        </div>
                    {foreachelse}
                        {* generate initial form to show to the user *}
                        <div class="options" id="option_preset">
                            {html_options name='item_amount[]' options=$amounts}
                            {html_options name='item_id[]' options=$items}
                        </div>
						<div class="options more" id="">
                            {html_options name='item_amount[]' options=$amounts}
                            {html_options name='item_id[]' options=$items}
                        </div>
						<div class="options more" id="">
                            {html_options name='item_amount[]' options=$amounts}
                            {html_options name='item_id[]' options=$items}
                        </div>
                    {/foreach}

				</div>
					<a href="#" id="more_items">Reserve another item</a>
			</fieldset>
		</div>
		

			
			<input type="submit" id="submit" value="Reserve Items &raquo;"/>
	</form>

</div>

{/block}