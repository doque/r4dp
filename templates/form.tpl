{extends file="html.tpl"}

{block name="title"}
Submit new Request
{/block}

{block name='head.scripts' append}
{literal}
	$(function() {
	
		$('.datepicker').datepicker({
			dateFormat: "dd.mm.yy",
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
        
		$('.more').live('click', function() {
			var factor = parseInt($(':selected', $(this).parent()).attr('data-factor'));
			var available = parseInt($(':selected', $(this).parent()).attr('data-available'))
			if (factor) { // shouldnt be empty except if a non-item is selected
				var amounts = parseInt( ($(this).prev().val() || 0) );
				amounts += factor;
				if (amounts > available) {
					return false;
				}
				$(this).prev().val(amounts);
			}
		});
		
		 
		$('.less').live('click', function() {
			var factor = parseInt($(':selected', $(this).parent()).attr('data-factor'));
			if (factor) { // shouldnt be empty except if a non-item is selected
				var amounts = parseInt( ($(this).prev().prev().val() || 0) );
				amounts -= factor;
				if (amounts < 0) {
					return false;
				}
				$(this).prev().prev().val(amounts);
			}
		});
		
		
		$('.selectitems').live('change', function() {
			$(this).next().val($(':selected', this).attr('data-factor'));
		});
       
		var items = 1;
        $('a#more_items').click(function(e) {
            e.preventDefault();
            var n = $('#options_preset').clone(true).addClass('more').attr('id', 'options_preset'+(items++)).appendTo('.items');
            n.find("small").remove();
            n.find(".selectedamounts").val("");
            n.find('option:selected').removeAttr('selected');
			
        });
	});
{/literal}
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
			
				<label for="user_name">Full Name: *</label>
				<input type="text" id="user_name" name="user_name" value="{$smarty.post.user_name|escape}" {if $errors.user_name}class="error"{/if}/>

				<label for="user_address">Address: *</label>
				<textarea class="comment text{if $errors.user_address} error{/if}" id="user_address" name="user_address">{$smarty.post.user_address|escape}</textarea>

				<label for="user_email">E-Mail Address: *</label>
				<input type="text" id="user_email" name="user_email" value="{$smarty.post.user_email|escape}" {if $errors.user_email}class="error"{/if}/>

				<label for="user_phone">Phone Number: *</label>
				<input type="text" id="user_phone" name="user_phone" value="{$smarty.post.user_phone|escape}" {if $errors.user_phone}class="error"{/if}/>
				
				<label for="user_department">Department/Organization: *</label>
				<input type="text" id="user_department" name="user_department" value="{$smarty.post.user_department|escape}" {if $errors.user_department}class="error"{/if}/>
				
				<label for="user_concordiaid">Your <a href="#" title="A valid Concordia alumni, staff or student ID must be presented at pick-up. An off-campus fee applies otherwise. Non-Concordia community members must show a government-issued ID.">Concordia ID</a>:</label>
				<input type="text"  id="user_concordiaid" name="user_concordiaid" value="{$smarty.post.user_concordiaid|escape}" {if $errors.user_concordiaid}class="error"{/if}/>
				
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
					<input type="text" class="timepicker{if $errors.date_from} error{/if}" name="time_from" id="time_from" value="{$smarty.post.time_from|escape}"/>
					<label for="date_until">until</label>
					<input type="text" class="datepicker{if $errors.date_until} error{/if}" name="date_until" id="date_until" value="{$smarty.post.date_until|escape}"/>
					<input type="text" class="timepicker{if $errors.date_until} error{/if}" name="time_until" id="time_until" value="{$smarty.post.time_until|escape}"/>
					
				</div>
				
				<br/>
				<label for="">Cleaning Preference:</label>
				<div class="options more">
				<input type="radio" name="cleaning" id="cleaning-user" value="user" {if empty($smarty.post.cleaning) || $smarty.post.cleaning == "user"} checked{/if}/> 
				<label for="cleaning-user">I will return all dishes clean and dry.</label><br/>
				<input type="radio" name="cleaning" id="cleaning-facility" value="facility" {if $smarty.post.cleaning == "facility"}checked{/if}/>
				<label for="cleaning-facility">I will clean the dishes myself in your facility. ($0.03/piece)</label><br/>
				<input type="radio" name="cleaning" id="cleaning-dirty" value="dirty" {if $smarty.post.cleaning == "dirty"}checked{/if}>
				<label for="cleaning-dirty">I will return the dishes dirty, please clean them for me. ($0.05/piece)</label>
				</div>

				<br/>
				
				
				<div class="items clearfix">
					<label for="amount">Dishes to Reserve:</label>
					{if !empty($selectedItems)}
		                {foreach $selectedItems key=selectedItem item=selectedAmount}
		                <div class="options more">
		                	<select class="selectitems" name="item_id[]">
                        		<option value="">Please select a dish</option>
                        		<option value="">--</option>
	                        	{foreach $items as $item}
	                        		<option value="{$item.id}" data-available="{$item.available}" data-factor="{$item.factor}"{if $item.id == $selectedItem}selected{/if}>{$item.name|escape}</option>
	                        	{/foreach}
	                        </select>
	                        <input readonly class="selectedamounts" name="item_amount[]" type="text" value="{$selectedAmount}"/>
	                        <a class="more" href="javascript:void(0)">more</a> | <a class="less" href="javascript:void(0)">less</a>
							{if $itemsAvailable[$selectedItem] < $selectedAmount}
								<small class="error">
							    {if $itemsAvailable[$selectedItem] == 0}
									These are not available for the selected dates.
							    {else}
							    	Only {$itemsAvailable[$selectedItem]} available.
							    {/if}
							    </small>
							{else}
								<small class="success">These are available.</small>
							{/if}
						</div>
						{/foreach}
					
					{/if}
					<div class="options more" id="options_preset">
						<select class="selectitems" name="item_id[]">
                       		<option value="">Please select a dish</option>
                       		<option value="">--</option>
                        	{foreach $items as $item}
                        		<option value="{$item.id}" data-available="{$item.available}" data-factor="{$item.factor}">{$item.name|escape}</option>
                        	{/foreach}
                        </select>
                        <input readonly class="selectedamounts" name="item_amount[]" type="text"/>
                        <a class="more" href="javascript:void(0)">more</a> | <a class="less" href="javascript:void(0)">less</a>
                    </div>
				</div>
					<a href="#" id="more_items">Reserve another item</a>
			</fieldset>
		</div>
		
		<input type="submit" id="submit" value="Reserve Items &raquo;"/>
	</form>

</div>

{/block}