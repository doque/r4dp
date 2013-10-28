<?php

require_once 'global.php';

// filtering
$filters = array();

$requests = array();

// search for requests matching criteria
if (!empty($_POST['search'])) {
	
	// get requests
	$query = 'SELECT *, `r`.`id` AS `requestid` FROM `requests` AS `r`
			  LEFT JOIN `users` AS `u` ON `u`.`id` = `r`.`userid`';
	$filters = array();

	if (!empty($_POST['quickid'])) {
		$filters[] = '`r`.`quickid` = "'. mysql_real_escape_string($_POST['quickid']).'"';
	}

	if (!empty($_POST['user_name'])) {
		$filters[] = '`u`.`name` LIKE "%%'.mysql_real_escape_string($_POST['user_name']).'%%"';
	}

	if (!empty($_POST['user_email'])) {
		$filters[] = '`u`.`email` LIKE "%%'.mysql_real_escape_string($_POST['user_email']).'%%"';	
	}

	if (!empty($_POST['status'])) {
		$filters[] = '`r`.`status` = "'.mysql_real_escape_string($_POST['status']).'"';
	}
	
	if (count($filters) > 0) {
		$query .= ' WHERE ' . implode(' AND ', $filters);
	}

#	print $query;

	$db->query($query);

	while ($row = $db->fetchAssoc()) {
		$requests[$row['requestid']] = $row;
	}
	
	
	
// this is for looking up request per item id
} else if (!empty($_POST['lookup'])) {

	$filters = array(true);

	if (!empty($_POST['date_from'])) {

#		var_dump(strtotime($_POST['date_from'] . ' 00:00:00'));
#		exit;

		$filters[] = '(FROM_UNIXTIME(' . strtotime($_POST['date_from']) . ') BETWEEN `date_from` AND `date_until`)';
	}
	if (!empty($_POST['date_until'])) {
		$filters[] = '(FROM_UNIXTIME(' . strtotime($_POST['date_until']) . ') BETWEEN `date_from` AND `date_until`)';
	}

#	print_r($filters);

	/*
	if (!empty($_POST['item_id'])) {
		$filters[] = '`ri`.`itemid` = '. (int) $_POST['item_id'];
	}
	*/
	
	// get requests
	$db->query('SELECT *, `r`.`id` AS `requestid` FROM `requests` AS `r`
					LEFT JOIN `users` AS `u` ON `u`.`id` = `r`.`userid`
					INNER JOIN `requestitems` AS `ri` ON `ri`.`requestid` = `r`.`id`
					WHERE %s', implode(' AND ', $filters));
	while ($row = $db->fetchAssoc()) {
		$requests[$row['requestid']] = $row;
	}
	
	
} // default filter is non-approved
else  {	
	$db->query('SELECT *, `r`.`id` AS `requestid` FROM `requests` AS `r`
					LEFT JOIN `users` AS `u` ON `u`.`id` = `r`.`userid`
					WHERE `status` = "received"');
	while ($row = $db->fetchAssoc()) {
		$requests[$row['requestid']] = $row;
	}
}



#echo '<pre>'.print_r($requests, 1),'</pre>';

// get request items as a single array as field of each request
foreach ($requests as $requestid=>$request) {

	// query items belonging to this request
	$db->query('SELECT `i`.*, `ri`.`amount`
				FROM `requests` AS `r`
				INNER JOIN `requestitems` AS `ri` ON `ri`.`requestid` = `r`.`id`
				INNER JOIN `items` AS `i` ON `i`.`id` = `ri`.`itemid` WHERE `r`.`id` = %d', $requestid);
	while($row = $db->fetchAssoc()) {
		#echo "<pre>".print_r($row,1)."</pre>";
		$requests[$requestid]['items'][] = $row;
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