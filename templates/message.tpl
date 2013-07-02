{extends file="html.tpl"}

{block name="title"}
	{$title}
{/block}


{block name="content"}


<div id="header">
	<img id="logo" src="assets/img/departmentlogo.gif"/>
</div>

<div id="request">

	<div class="success">{$msg|escape}</div>

</div>

{/block}