<?php
require_once 'global.php';


if (isset($_POST['sent'])) {
	
	
	$v = new RequestValidator();
	
	$v->notEmpty('user_name', $_POST['user_name'], 'Please enter your name');
	$v->notEmpty('user_address', $_POST['user_address'], 'Please enter your address');
	
	if (!$v->validateEmail($_POST['user_email'])) {
		$v->triggerError('user_email', 'Please supply a valid email address');
	}
	
	$v->notEmpty('user_phone', $_POST['user_phone'], 'Please supply a phone number');
	
	$v->notEmpty('user_department', $_POST['user_department'], 'Please supply your Department/Organization');
	
	if (!empty($_POST['user_concordiaid']) && (!$v->numeric('user_concordiaid', $_POST['user_concordiaid']) || strlen($_POST['user_concordiaid']) != 7)) {
		$v->triggerError('user_concordiaid', 'Your Concordia ID seems invalid');
	}
	
	if (false === ($date_from = strtotime($_POST['date_from'] . " " . $_POST['time_from']))) {
		$v->triggerError('date_from', 'Please enter a start date and timefor your reservation');
	} else {
		if ($date_from < (time() + 3600 * 24 * 6)) { // less than 6 days in future
			$v->triggerError('date_from', 'Reservations have to be made at least 7 days prior to the reservation start');
		}
	}



	if (false === ($date_until = strtotime($_POST['date_until'] . " " . $_POST['time_until']))) {
		$v->triggerError('date_until', 'Please enter an end date and time for your reservation');
	} else {
		if (! $v->hasError('date_from')) {
			if ($date_until < $date_from) {
				$v->triggerError('date_until', 'Reservation end date has to be later than start date');
			}
		}
	}
	
	// cleaning
	$v->notEmpty('cleaning', $_POST['cleaning'], 'Please select a cleaning choice');
	
	$selectedItems = array();
	

	// merge items for doubly selected 
	foreach (array_keys($_POST['item_id']) as $i) {
		$item = (int) $_POST['item_id'][$i];
		$amount = (int) $_POST['item_amount'][$i];
		if ($item === 0 || $amount === 0)
			continue;
		
		if (isset($selectedItems[$item])) {
			$selectedItems[$item] += $amount;
		} else {
			$selectedItems[$item] = $amount;
		}
	}
	#print_r($selectedItems);
	// validate that items are within range!
	
	
	// request with empty items
	if (empty($selectedItems)) {
		$v->triggerError('item_id', 'Please select at least one item.');
	}
	
	
	if (! $v->hasError('date_from') && ! $v->hasError('date_until')) {
		// delete timed out pending requests
		$db->query('DELETE FROM `requests` WHERE `status` = "pending" AND `pending` IS NOT NULL AND `pending` < NOW() - INTERVAL %d MINUTE', REQUEST_TIMEOUT_MINUTES);
		
		$test = new RangeTest(new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME));
		$test->ignoreApproved = RESPECT_APPROVED_ON_AVI_CALC;
		
		$itemsAvailable = array();


		foreach ($selectedItems as $item => $amount) {
			$itemsAvailable[$item] = $test->availableInRange($item, $date_from, $date_until);
			if ($itemsAvailable[$item] < $amount) {
				$v->triggerError('item_amount', 'The amount you requested is not available for the specified date range');
			}
		}
		$tpl->assign('itemsAvailable', $itemsAvailable);

	}


	#exit;
	
	if ($v->isValid()) {

		// concordia user
		$concordia = (strlen($_POST['user_concordiaid']) === 7 && $v->numeric($_POST['user_concordiaid']));
		$user = $db->queryFirst('SELECT `id` FROM `users` WHERE `email` = "%s"', $_POST['user_email']);
		if (empty($user)) {
			$db->query('
				INSERT INTO `users` SET `name` = "%s",
										`concordia` = %d,
										`concordiaid` = %d,
										`email`     = "%s",
										`phone`     = "%s",
										`department` = "%s",
										`address` = "%s"
			', $_POST['user_name'], ($concordia ? 1 : 0), $_POST['user_concordiaid'], $_POST['user_email'], $_POST['user_phone'], $_POST['user_department'], $_POST['user_address']);
			$user = array(
					'id' => $db->insertID(),
					'email' => $_POST['user_email'],
					'name' => $_POST['user_name']
			);
		} else {
			$db->query('
				UPDATE `users` SET `name` = "%s",
										`concordia` = %d,
										`concordiaid` = %d,
										`phone`     = "%s",
										`department` = "%s",
										`address` = "%s"
									WHERE `email` = "%s"
			', $_POST['user_name'], ($concordia ? 1 : 0), $_POST['user_concordiaid'], $_POST['user_phone'], $_POST['user_department'], $_POST['user_email'], $_POST['user_address']);
		}
		
		// used by user to access a request. should be random enough
		$quickId = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 7)), 0, 7);
		
		$db->query('
			INSERT INTO `requests` SET `userid`     = %d,
									   `quickid`   = "%s", -- used for quick access
									   `confirmauth` = "%s", -- used for approve auth
									   `date`       = NOW(),
									   `date_from`  = FROM_UNIXTIME(%d),
									   `date_until` = FROM_UNIXTIME(%d),
									   `pending`    = NOW(),
									   `user_comment` = "%s",
									   `status` = "unconfirmed",
									   `cleaning` = "%s"
		', $user['id'], $quickId, sha1(microtime(true) . HASH), $date_from, $date_until, trim($_POST['user_comment']), $_POST['cleaning']);
		
		$requestID = $db->insertID();
		
		// auto added items
		$amount_lg_boxes = 0;
		$amount_sm_boxes = 0;
		$amount_wine_racks = 0;
		$amount_water_racks = 0;		
		// special case for bowls (etc) and cutlery, is calculated below
		$amount_bowls = 0;
		$amount_cutlery = 0;
		
		foreach ($selectedItems as $item => $amount) {
			
			switch((int) $item) {
				// for every 24 plates, add 1 LG storage box
				case 1:
					$amount_lg_boxes += ceil($amount/24);
					break;
			
				// for every 24 bowls, cups or saucers: add 1SM Storage Box
				case 8:
				case 9:
				case 10:
					$amount_bowls += $amount;
					break;
						
					// for every set of 25 wine glasses, add 1 wine glass rack
				case 13:
					$amount_wine_racks += ceil($amount/25);
					break;
			
					// for every set of 25 water glasses, add 1 water glass rack
				case 12:
					$amount_water_racks += ceil($amount/25);
					break;
			
				// for every set of 24 cutlery (of any kind), up to 192, add 1 cutlery rack
				case 2:
				case 3:
				case 4:
				case 5:
				case 6:
				case 7:
					// someone getting 24 knives, 24 spoons and 24 forks only gets one box
					$amount_cutlery += $amount;
						
			}
			
			// add the actual item
			$db->query('INSERT INTO `requestitems` SET `requestid` = %d,
													   `itemid`    = %d,
													   `amount`    = %d', $requestID, $item, $amount);
		}
		// insert additional items here
		if ($amount_lg_boxes > 0) {
			$db->query('INSERT INTO `requestitems` SET `autoadded` = 1,
													   `requestid` = %d,
													   `itemid` = 26, -- LG Storage Box ID
													   `amount` = %d', $requestID, $amount_lg_boxes);
		}
		
		if ($amount_wine_racks > 0) {
			$db->query('INSERT INTO `requestitems` SET `autoadded` = 1,
													   `requestid` = %d,
													   `itemid` = 28, -- Wine Glass Rack ID
													   `amount` = %d', $requestID, $amount_wine_racks);
		}
		if ($amount_water_racks > 0) {
		
			$db->query('INSERT INTO `requestitems` SET `autoadded` = 1,
													   `requestid` = %d,
													   `itemid` = 27, -- Water Glass Rack ID
													   `amount` = %d', $requestID, $amount_water_racks);
		
		}
		// sets of 24 get one box
		if ($amount_bowls > 0) {
			$amount_sm_boxes = ceil($amount_bowls/24);
			$db->query('INSERT INTO `requestitems` SET `autoadded` = 1,
													   `requestid` = %d,
													   `itemid` = 25, -- SM Storage Box ID
													   `amount` = %d', $requestID, $amount_sm_boxes);
		}
		// sets of 192 get one rack
		if ($amount_cutlery > 0) {
			$amount_cutlery_racks = ceil($amount_cutlery/192);
			$db->query('INSERT INTO `requestitems` SET `autoadded` = 1,
													   `requestid` = %d,
													   `itemid` = 29, -- Cutlery Rack ID
													   `amount` = %d', $requestID, $amount_cutlery_racks);
		}
		
		
		// store user infos
		setcookie('u', sha1($user['id'] . HASH), strtotime('+1 year'));
		//setcookie('i', sha1($requestID . HASH), time() + 60 * 15);
		
		// write shit to session!
		$_SESSION['requestid'] = $requestID;
		
		header('Location: confirm.php');
		exit();
	} else {
		$tpl->assign('errors', $v->getErrors());
		// echo '<pre>'.print_r($v->getErrors(true), 1).'</pre>';
		$tpl->assign('selectedItems', $selectedItems);
	}
} else {
	// empty POST, but maybe the User has a cookie
	$hash = $_COOKIE['u'];
	$db->query('SELECT * FROM `users` WHERE SHA1(CONCAT(`id`, "%s")) = "%s"', HASH, $hash);
	$user = $db->fetchAssoc();
	if (! empty($user)) {
		// prefilled values in the form
		$_POST['user_name'] = $user['name'];
		$_POST['user_email'] = $user['email'];
		$_POST['user_phone'] = $user['phone'];
		$_POST['user_address'] = $user['address'];
		$_POST['user_department'] = $user['department'];
		$_POST['user_concordiaid'] = (string) $user['concordiaid'];
	}
}

/**
 * selectable items
 * steps consider the factor attribute which is unique to each item
 */
$db->query('SELECT * FROM `items` ORDER BY `name` ASC');
$items = array();
while ( $row = $db->fetchAssoc() ) {
	
	$items[$row['id']] = $row;
}

$maxAvailable = array_shift($db->queryFirst('SELECT MAX(available) FROM items'));

$tpl->assign(array(
		'items' => $items,
		'maxAvailable' => range(1, $maxAvailable)
));

header('Content-Type: text/html; Charset=UTF-8');
$tpl->display('form.tpl');

?>