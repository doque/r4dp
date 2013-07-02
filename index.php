<?php

require_once 'global.php';




if (isset($_POST['sent'])) {
	
	require_once 'inc/classes/RequestValidator.class.php';

	$v = new RequestValidator();
    
	$v->notEmpty('user_name', $_POST['user_name'], 'Please enter your name');
	//$v->notEmpty('user_email', $_POST['user_email'], 'Please supply a valid email address');
    if(!$v->validateEmail($_POST['user_email'])) {
		$v->triggerError('user_email', 'Please supply a valid email address');
    }
	$v->notEmpty('user_phone', $_POST['user_phone'], 'Please supply a phone number');
	
	$v->notEmpty('user_department', $_POST['user_department'], 'Please supply your Department/Organization');
    
    if(false === ($from  = strptime($_POST['date_from'], '%d/%m/%Y'))) {
		$v->triggerError('date_from', 'Please enter a valid start date in the format dd.mm.YYYY');
    }
    else {
        $date_from = mktime(0, 0, 0, $from['tm_mon']+1, $from['tm_mday'], $from['tm_year']+1900);
        if($date_from < (time() + 3600*24*6)) { // less than 6 days in future
            $v->triggerError('date_from', 'Reservations have to be made at least 7 days prior to the reservation start');
        }
    }
    
    if(false === ($until = strptime($_POST['date_until'], '%d/%m/%Y'))) {
		$v->triggerError('date_until', 'Please enter a valid end date for your reservation');
    }
    else {
        $date_until = mktime(23, 59, 59, $until['tm_mon']+1, $until['tm_mday'], $until['tm_year']+1900);
        if(!$v->hasError('date_from')) {
            if($date_until < $date_from) {
				$v->triggerError('date_until', 'Reservation end date has to be later than start date');
            } 
        }
    }


    $selectedItems = array();
    foreach(array_keys($_POST['item_id']) AS $i) {
        $item   = (int) $_POST['item_id'][$i];
        $amount = (int) $_POST['item_amount'][$i];
        if($item === 0 || $amount === 0) continue;
        
        if(isset($selectedItems[$item])) {
            $selectedItems[$item] += $amount;
        }
        else {
            $selectedItems[$item] = $amount;
        }
    }
	
	
    
    if(!$v->hasError('date_from') && !$v->hasError('date_until')) {
        // delete timed out pending requests
        $db->query('DELETE FROM `requests` WHERE `pending` IS NOT NULL AND `pending` < NOW() - INTERVAL %d MINUTE', REQUEST_TIMEOUT_MINUTES);
        
		require_once('inc/classes/RangeTest.class.php');
        $test = new RangeTest(new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME));
        $test->ignoreApproved = RESPECT_APPROVED_ON_AVI_CALC;
        
        $itemsAvailable = array();
        foreach ($selectedItems AS $item => $amount) {
            $itemsAvailable[$item] = $test->availableInRange($item, $date_from, $date_until);
            if ($itemsAvailable[$item] < $amount) {
				// wat?
                $v->triggerError('item_amount', 'The amount you requested is not available for the specified date range');
            }
        }
        $tpl->assign('itemsAvailable', $itemsAvailable);
    }
    
	if ($v->isValid()) {
		$concordia = ('concordia.ca' === substr(trim($_POST['user_email']), - strlen('concordia.ca'))); // fixme, check for correct string
		
		$user = $db->queryFirst('SELECT `id` FROM `users` WHERE `email` = "%s"', $_POST['user_email']);
		if (empty($user)) {
			$db->query('
				INSERT INTO `users` SET `name` = "%s",
										`concordia` = %d,
										`concordiaid` = %d,
										`email`     = "%s",
										`phone`     = "%s",
										`department` = "%s"
			', $_POST['user_name'], ($concordia ? 1 : 0), $_POST['user_concordiaid'], $_POST['user_email'], $_POST['user_phone'], $_POST['user_department']);
			$user = array('id' => $db->insertID());
		} else {
			$db->query('
				UPDATE `users` SET `name` = "%s",
										`concordia` = %d,
										`concordiaid` = %d,
										`phone`     = "%s",
										`department` = "%s"
									WHERE `email` = "%s"
			', $_POST['user_name'], ($concordia ? 1 : 0), $_POST['user_concordiaid'], $_POST['user_phone'], $_POST['user_department'], $_POST['user_email']);

		}
		
		$quickId = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 7)), 0, 7);
		
		$db->query('
			INSERT INTO `requests` SET `userid`     = %d,
									   `quickid`   = "%s", -- used for quick access
									   `confirmauth` = "%s", -- used for approve auth
									   `date`       = NOW(),
									   `date_from`  = FROM_UNIXTIME(%d),
									   `date_until` = FROM_UNIXTIME(%d),
									   `pending`    = NOW(),
									   `comment_user` = "%s"
		', $user['id'], $quickId, sha1(microtime(true).'BACON'), $date_from, $date_until, trim($_POST['user_comment']));

		$requestID = $db->insertID();
		
		foreach($selectedItems AS $item => $amount) {


			$db->query('INSERT INTO `requestItems` SET `requestid` = %d,
													   `itemid`    = %d,
													   `amount`    = %d,
													   `deposit`   = %d * 0.1 * (SELECT `value` FROM `items` WHERE `id` = %d)
			', $requestID, $item, $amount, $amount, $item);
		}
		
		// store user infos
		setcookie('u', sha1($user['id'].HASH), strtotime('+1 year'));
		setcookie('i', sha1($requestID.HASH), time()+60*15);

		// write shit to session!
		$_SESSION['requestId'] = $requestID;


		header('Location: confirm.php');
		exit;
		
	} else {
		$tpl->assign('errors', $v->getErrors());
		#echo '<pre>'.print_r($v->getErrors(true), 1).'</pre>';
        $tpl->assign('selectedItems', $selectedItems);
    }
} else {
	// empty POST, but maybe the User has a cookie
	$hash = $_COOKIE['u'];
	$db->query('SELECT * FROM `users` WHERE SHA1(CONCAT(`id`, "%s")) = "%s"', HASH, $hash);
	$user = $db->fetchAssoc();
	if (!empty($user)) {
		// prefilled values in the form
		$_POST['user_name'] = $user['name'];
		$_POST['user_email'] = $user['email'];
		$_POST['user_phone'] = $user['phone'];
		$_POST['user_department'] = $user['department'];
		$_POST['user_concordiaid'] = $user['concordiaid'];
	}
}


// listing for <select>
$db->query('SELECT `id`, `name` FROM `items` ORDER BY `name` ASC');
$items = array();
while ($row = $db->fetchAssoc()) {
	$items[$row['id']] = $row['name'];
}

// only allow multiples of 6 as amounts
$amounts = array();
for($i = 1; $i <= 10; $i++) {
    $x = 6 * $i;
    $amounts[$x] = $x;
}

$tpl->assign(array(
	'items' => $items,
    'amounts' => $amounts,
));

header('Content-Type: text/html; Charset=UTF-8');
$tpl->display('form.tpl');


?>