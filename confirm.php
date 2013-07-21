<?php
require 'global.php';

if (empty($_SESSION['requestid'])) die('no id');

// if(!isset($_COOKIE['i'])) die('no direct access allowed');

// get actual request ID from cookie
//$db->query('SELECT * FROM `requests` WHERE SHA1(CONCAT(`id`, "%s")) = "%s"', HASH, $_COOKIE['i']);
//$row = $db->fetchAssoc();
$requestID = $_SESSION['requestid'];

// check if request exists and is pending
$request = $db->queryFirst('SELECT * FROM `requests` WHERE `id` = %d AND `pending` IS NOT NULL', $requestID);

if (empty($request)) {
	// invalid/expired request
	header('Location: index.php');
	exit();
} else {
	// refresh request
	$db->query('UPDATE `requests` SET `pending` = NOW() WHERE `id` = %d', $requestID);
	//setcookie('requestid', $requestID, time() + 60 * 15);
}

// get user info
$user = $db->queryFirst('SELECT u.* FROM `requests` r RIGHT JOIN users u ON u.id = r.userid WHERE r.id = %d', $requestID);


if (isset($_POST['sent'])) {
	
	$v = new RequestValidator();
	
	$v->notEmpty('toc', $_POST['toc'], 'You must accept our terms &amp; conditions to use this service.');
	$v->notEmpty('fees', $_POST['fees'], 'You must accept the calculated fees to use this service.');
	
	// set request to status awaiting_approval
	if ($v->isValid()) {
		// change request status and insert user comment
		$db->query('UPDATE `requests` SET `status` = "waiting", `comment_user` = "%s" WHERE `id` = %d', $requestID, $_POST['comment_user']);
		// send emails
		$tpl->assign('quickId', $request['quickid']);
		$tpl->display('confirmed.tpl');
		exit;
		
	} else {
		$tpl->assign('errors', $v->getErrors());
	}
}
	

// query items belonging to this request
$db->query('SELECT *
            FROM `requests` AS `r`
            INNER JOIN `requestItems` AS `ri` ON `ri`.`requestid` = `r`.`id`
            INNER JOIN `items` AS `i` ON `i`.`id` = `ri`.`itemid`
            WHERE `r`.`id` = %d', $requestID);


$items = array();
while ( $row = $db->fetchAssoc() ) {
	$items[$row['id']] = $row;
}

// calculate deposit and savings:

$value = 0;
$savings = 0;
$cleaningCosts = 0;


$valueItems = array();
// first, calculate value of the selected items
foreach ($items as $item) {
	
	
	$itemValue = $item['amount'] * $item['value'];
	$value += $itemValue;
	$valueItems[] = 'valued $' . number_format($itemValue, 2) . ' for ' . $item['amount'] . ' x ' . $item['name'] . ' valued at $' . number_format($item['value'], 2) . ' each';
	
	// dont add the value of autoadded items to the cleaning costs or savings
	if ($item['autoadded'] == 1) continue;
	
	switch ($request['cleaning']) {
		case 'user' :
			$valueItems[] = 'no additional cleaning cost';
			break; // no additional fee
		case 'facility' :
			$itemCleaningCosts = $item['amount'] * 0.03;
			$cleaningCosts += $itemCleaningCosts;
			$valueItems[] = '+ $' . number_format($itemCleaningCosts, 2) . ' for you cleaning ' . $item['amount'] . ' x ' . $item['name'] . ' at our facility at $0.03 each';
			break;
		case 'dirty' :
			$itemCleaningCosts = $item['amount'] * 0.05;
			$cleaningCosts += $itemCleaningCosts;
			$valueItems[] = '+ $' . number_format($itemCleaningCosts, 2) . ' for us cleaning ' . $item['amount'] . ' x ' . $item['name'] . ' at $0.05 each';
			break;
	}

	
	$savings += $item['amount'] * $item['savings'];
}

$valueItems[] = '===================================';

// 10 percent of all items value is the actual deposit
$deposit = 0.1 * $value;
$valueItems[] = 'deposit is $' . number_format($deposit, 2) . ' (10% of total dish value which is $' . number_format($value, 2) . ')';

// add 100% of cleaning costs
if ($cleaningCosts > 0) {
	$deposit += $cleaningCosts; 
	$valueItems[] = '+ cleaning cost of $' . number_format($cleaningCosts, 2);
}

// if non-concordia, add the savings fee and round
if ($user['concordia'] == 0) {
	// add off-campus fee
	$valueItems[] = '+ $' . number_format($savings, 2) . ' off-campus fee for non-concordia students';
	$deposit += $savings;
}



// round to the nearest 20 dollars
$deposit_rounded = round($deposit / 20) * 20;

if ($deposit_rounded < 20) {
	$deposit_rounded = 20;
}


$valueItems[] = '===================================';
$valueItems[] = 'rounding your total deposit of $' . number_format($deposit, 2) . ' to the nearest $20 which is $' . number_format($deposit_rounded, 2);

// save deposit etc to session!

// check for sent
// check if everything has been accepted
// update comment in database if present

// send email to user and admin (including quickid etc)

// show confirmed.tpl with information about depost (an email has been sent to ...)

// save deposit to db
$db->query('UPDATE `requests` SET `deposit` = %d', $deposit_rounded);

$tpl->assign('user', $user);
$tpl->assign('request', $request);
$tpl->assign('items', $items);

$tpl->assign('deposit_rounded', $deposit_rounded);
$tpl->assign('valueItems', $valueItems);
$tpl->assign('savings', number_format($savings, 2));
$tpl->display('confirm.tpl');


?>