<?php

require 'global.php';



// Update Request
if (isset($_POST['sent'])) {

	if (isset($_POST['delete'])) {
		$db->query('DELETE FROM `requests` WHERE `id` = %d', $_GET['id']);
		$db->query('DELETE FROM `requestItems` WHERE `requestid` = %d', $_GET['id']);
		header('location: message.php?msg=deleted');
		exit;
	}


	// update amounts for broken, returned etc for each borrowed item
	if (isset($_POST['item'])) {
	
	
		foreach ($_POST['item'] AS $itemid => $item) {
		
			foreach (array('amount_returned', 'amount_broken', 'amount_dirty') AS $field) {
				if (!empty($item[$field])) {
					$db->query('UPDATE `requestItems` SET `%s` = %d WHERE `requestid` = %d AND `itemid` = %d', $field, $item[$field], $_GET['id'], $itemid);
				}
			}
		}

	}


	// TODO here:
	// Rangetest for request, only approve if shit is still available, otherwise $tpl->assign(error, not available)

	$approved = (isset($_POST['approved'])) ? 1 : 0;
	$late = (isset($_POST['late'])) ? 1 : 0;
	$returned = (isset($_POST['returned'])) ? 1 : 0;
	$paid = (isset($_POST['paid'])) ? 1 : 0;
	$cancelled = (isset($_POST['cancelled'])) ? 1 : 0;


	try {
		$db->query('UPDATE `requests` SET `approved` = %d,
										  `late` = %d,
										  `returned` = %d,
										  `paid` = %d,
										  `cancelled` = %d,
										  `comment_admin` = "%s"', $approved, $late, $returned, $paid, $cancelled, $_POST['admin_comment']);
		$tpl->assign('success', 'Request was updated.');
	} catch (MySQLException $e) {
		$tpl->assign('error', $e->toString());
	}

}

// look at request

if (!empty($_GET['id'])) {
	
	// get requests
	$db->query('SELECT *, `r`.`id` AS `requestid` FROM `requests` AS `r`
					LEFT JOIN `users` AS `u` ON `u`.`id` = `r`.`userid`
					WHERE `r`.`id` = %d', (int) $_GET['id']);
	$request = $db->fetchAssoc();

	// not found
	if (empty($request)) {
		header('Location: message.php?msg=notfound');
		exit;
	}

	// query items belonging to this request
	$db->query('SELECT `i`.*, `ri`.`amount`, `ri`.`amount_returned`, `ri`.`amount_dirty`, `ri`.`amount_broken`
				FROM `requests` AS `r`
				INNER JOIN `requestItems` AS `ri` ON `ri`.`requestid` = `r`.`id`
				INNER JOIN `items` AS `i` ON `i`.`id` = `ri`.`itemid`
				WHERE `r`.`id`  = %d', $request['requestid']);
	while($row = $db->fetchAssoc()) {
		$request['items'][] = $row;
	}
	

} else {
	header('Location: message.php?msg=notfound');
	exit;
}

#echo "<pre>".print_r($request,1)."</pre>";


$tpl->assign(array(
    'amounts' => $amounts,
	'request' => $request
));


header('Content-Type: text/html; Charset=UTF-8');
$tpl->display('request.tpl');

?>