<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>{block name=title}{/block}</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="assets/js/jquery.timepicker.js"></script>
	<script type="text/javascript">
        {block name='head.scripts'}
        {/block}
	</script>
	<link rel="stylesheet" href="assets/css/reset.css"/>
	<link rel="stylesheet" href="assets/css/pepper-grinder/jquery-ui-1.8.18.custom.css"/>
	<link rel="stylesheet" href="assets/css/jquery.timepicker.css"/>
	<link rel="stylesheet" href="assets/css/style.css"/>
	<link rel="stylesheet" href="assets/css/tooltip.css"/>

	{block name=header}{/block}
</head>
<body>
	<div id="content">
		{block name=content}{/block}
	</div>
</body>
</html>
