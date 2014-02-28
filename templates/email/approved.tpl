Dear Customer,

Your request with order number {$quickId} has been approved!

Items:
{foreach $items as $item}
		{$item.amount} x {$item.name} ({$item.description})
{/foreach}


Deposit: 	${$deposit}


Pick-up date:	{$date_from|date_format:"F j, Y, g:i a"}
Return date:	{$date_until|date_format:"F j, Y, g:i a"}

If you have any questions, please contact us at r4dishproject@gmail.com and specify your order number.