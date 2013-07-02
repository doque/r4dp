{extends file="html.tpl"}

{block name=title}Title{/block}

{block name=content}
<pre>
{foreach from=$items item=dish}
	{$dish["name"]} (available: {$dish["amount_available"]})
{/foreach}
</pre>
{/block}