{extends file="html.tpl"}

{block name="title"}
	{$title}
{/block}


{block name="content"}


<div id="header">
	<a href="/admin.php" title="Admin Overview"><img id="logo" src="assets/img/departmentlogo.gif"/></a>
</div>

<div id="request">

	<div class="success">{$msg|escape}</div>

</div>

{/block}