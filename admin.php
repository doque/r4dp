<?php

require_once 'global.php';

// filtering
$filters = array();

$requests = array();

// search for requests matching criteria
if (!empty($_POST['search'])) {
	
	$filters = "";
	
	// get requests
	$db->query('SELECT *, `r`.`id` AS `requestid` FROM `requests` AS `r`
					LEFT JOIN `users` AS `u` ON `u`.`id` = `r`.`userid`
					WHERE %s', $filters);
	
	while ($row = $db->fetchAssoc()) {
		$requests[$row['requestid']] = $row;
	}
	
	
	
// this is for looking up request per item id
} else if (isset($_POST['lookup'])) {
	if (!empty($_POST['date_from'])) {
		$filters[] = mysql_real_escape_string($_POST['date_from']) . ' BETWEEN `date_from` AND `date_until`'; // TODO: remove mysql injection pretty
	}
	if (!empty($_POST['date_until'])) {
		$filters[] = mysql_real_escape_string($_POST['date_until']) . ' BETWEEN `date_from` AND `date_until`';
	}
	
	if (!empty($_POST['item_id'])) {
		$filters[] = '`ri`.`itemid` = '. (int) $_POST['item_id'];
	}
	
	// get requests
	$db->query('SELECT *, `r`.`id` AS `requestid` FROM `requests` AS `r`
					LEFT JOIN `users` AS `u` ON `u`.`id` = `r`.`userid`
					INNER JOIN `requestitems` AS `ri` ON `ri`.`requestid` = `r`.`id`
					WHERE %s', implode(' AND ', $filters));
	while ($row = $db->fetchAssoc()) {
		$requests[$row['requestid']] = $row;
	}
	
	
}

// default filter is non-approved
else  {	
	$db->query('SELECT *, `r`.`id` AS `requestid` FROM `requests` AS `r`
					LEFT JOIN `users` AS `u` ON `u`.`id` = `r`.`userid`
					WHERE `status` = "waiting"');
	while ($row = $db->fetchAssoc()) {
		$requests[$row['requestid']] = $row;
	}
}




// get request items as a single array as field of each request
foreach ($requests as $key=>$value) {

	// query items belonging to this request
	$db->query('SELECT `i`.*, `ri`.`amount`
				FROM `requests` AS `r`
				INNER JOIN `requestitems` AS `ri` ON `ri`.`requestid` = `r`.`id`
				INNER JOIN `items` AS `i` ON `i`.`id` = `ri`.`itemid`');
	while($row = $db->fetchAssoc()) {
		#echo "<pre>".print_r($row,1)."</pre>";
		$requests[$key]['items'][] = $row;
	}
}


#echo '<pre>'.print_r($requests, 1),'</pre>';



$db->query('SELECT `id`, `name` FROM `items`');
$items = array();
while ($row = $db->fetchAssoc()) {
	$items[$row['id']] = $row['name'];
}
$tpl->assign('item', $_POST['item_id']); // preselected item on dropdown
$tpl->assign('items', $items);

#echo '<pre>'.print_r($requests, 1),'</pre>';

$tpl->assign('requests', $requests);
$tpl->display('admin.tpl');


?>