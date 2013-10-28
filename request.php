<?php

require 'global.php';


if (!empty($_GET['id'])) {
	
	// get requests
	$db->query('SELECT *, `id` AS `requestid` FROM `requests` AS `r`
					WHERE `r`.`id` = %d', (int) $_GET['id']);
	$request = $db->fetchAssoc();
	// not found

	if (empty($request)) {
		header('Location: message.php?msg=notfound');
		exit;
	}
} else {
	header('Location: message.php?msg=notfound');
}

// Update Request
if (isset($_POST['sent'])) {

	$success = false;

	if (isset($_POST['delete'])) {
		$db->query('DELETE FROM requests WHERE id = %d', $_GET['id']);
		header('Location: message.php?msg=deleted');
		exit;
	}

	if (!empty($_POST['admin_comment'])) {
		$db->query('UPDATE `requests` SET `admin_comment` = "%s" WHERE `id` = %d', $_POST['admin_comment'], $_GET['id']);
		$success = true;

	}


	if (!empty($_POST['item'])) {
		foreach ($_POST['item'] as $itemid => $item) {
			if (!empty($item['borrowed'])) {
				$db->query('UPDATE requestitems SET amount = %d WHERE itemid = %d AND requestid = %d', $item['borrowed'], $itemid, $_GET['id']);
				$success = true;
			}
			if (!empty($item['amount_returned'])) {
				$db->query('UPDATE requestitems SET amount_returned = %d WHERE itemid = %d AND requestid = %d', $item['amount_returned'], $itemid, $_GET['id']);
				$success = true;
			}
		}
	}

	// changed status
	if (!empty($_POST['status']) && $_POST['status'] != $request['status']) {
		$db->query('UPDATE `requests` SET `status` = "%s" WHERE `id` = %d', $_POST['status'], $_GET['id']);
		if (in_array($_POST['status'], array('approved','declined','returned'))) {
			$user = $db->queryFirst('SELECT u.* FROM `requests` r RIGHT JOIN users u ON u.id = r.userid WHERE r.id = %d', $request['requestid']);
			//
			// query items and other information belonging to this request
			//

			$db->query('SELECT `i`.*, `ri`.`amount`
						FROM `requests` AS `r`
						INNER JOIN `requestitems` AS `ri` ON `ri`.`requestid` = `r`.`id`
						INNER JOIN `items` AS `i` ON `i`.`id` = `ri`.`itemid`
						WHERE `r`.`id`  = %d', $request['requestid']);
			$tplitems = array();
			while($row = $db->fetchAssoc()) {
				$tplitems[] = array("name" => $row['name'], "amount" => $row['amount'], "description" => $row['description']);
			}
			#print_r($user);
			

			// assign to template
			$tpl->assign('items', $tplitems);
			$tpl->assign('quickId', $request['quickid']);
			$tpl->assign('deposit', $request['deposit']);
			$tpl->assign('date_from', $request['date_from']);
			$tpl->assign('date_until', $request['date_until']);


			$email = new EMail();
			$email->setSubject('Your request for dishes has been approved!');
			$email->addRecipients(array($user['email'], 'r4dishproject@gmail.com', 'r4dp.adm@gmail.com'));
			
			#var_dump($email);
			if ($_POST['status'] === 'approved') {
				$email->setSubject('Your request for dishes has been approved!');
				$email->setMessage($tpl->fetch('email/approved.tpl'));
			} else if ($_POST['status'] === 'declined') {
				$email->setSubject('We were unable to approve your request.');
				$email->setMessage($tpl->fetch('email/declined.tpl'));
			} else {
				$email->setSubject('R4DP Order #' . $request['quickid']);
				$email->setMessage($tpl->fetch('email/returned.tpl'));
			}
			$email->send();
		}	
	}
}



	
// get requests
$db->query('SELECT *, `r`.`id` AS `requestid` FROM `requests` AS `r`
				LEFT JOIN `users` AS `u` ON `u`.`id` = `r`.`userid`
				WHERE `r`.`id` = %d', (int) $_GET['id']);
$request = $db->fetchAssoc();

// query items belonging to this request
$db->query('SELECT `i`.*, `ri`.`amount`, `ri`.`amount_returned`
			FROM `requests` AS `r`
			INNER JOIN `requestitems` AS `ri` ON `ri`.`requestid` = `r`.`id`
			INNER JOIN `items` AS `i` ON `i`.`id` = `ri`.`itemid`
			WHERE `r`.`id`  = %d', $request['requestid']);
while($row = $db->fetchAssoc()) {
	$request['items'][] = $row;
}


#echo "<pre>".print_r($request,1)."</pre>";

$tpl->assign(array(
    'amounts' => $amounts,
    'success' => $success,
	'request' => $request
));


header('Content-Type: text/html; Charset=UTF-8');
$tpl->display('request.tpl');

?>