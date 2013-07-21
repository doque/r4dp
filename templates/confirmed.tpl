{extends file="html.tpl"}

{block name="title"}
Request Successful
{/block}

{block name='head.scripts' append}
	
{/block}


{block name="content"}


<div id="header">
	<img id="logo" src="assets/img/departmentlogo.gif"/>
</div>


<div id="request">
	
		
			<fieldset>
				<h3 class="success">Thank you! Your Request has been placed.</h3>
			<br/>
				<div>
					<p>
						A dish project coordinator will review and approve your request within three (3) business days.
						<br/>
						<br/>
						In the meantime, you can e-mail r4dishproject@gmail.com and specify your order number
						<br/>
						<br/>
						<strong style="font-size: 20px;">{$quickId}</strong>,
						should you have any further questions.
					</p>
			
				</div>
			
			</fieldset>			
			


</div>

{/block}