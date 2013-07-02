<?php

require 'global.php';

//if(!isset($_COOKIE['i'])) die('no direct access allowed');


// get actual request ID from cookie
$db->query('SELECT `id` FROM `requests` WHERE SHA1(CONCAT(`id`, "%s")) = "%s"', HASH, $_COOKIE['i']);
$row = $db->fetchAssoc();

$requestID = $row['id'];

// check if request exists and is pending
$request = $db->queryFirst('SELECT * FROM `requests` WHERE `id` = %d AND `pending` IS NOT NULL', $requestID);
if(empty($request)) {
    // invalid/expired request
    header('Location: index.php');
    exit;
} else {
    // refresh request
    $db->query('UPDATE `requests` SET `pending` = NOW() WHERE `id` = %d', $requestID);
    setcookie('requestID', $requestID, time()+60*15);
}

// get user info
$user = $db->queryFirst('SELECT u.* FROM `requests` r RIGHT JOIN users u ON u.id = r.userid WHERE r.id = %d', $requestID);


// query items belonging to this request
$db->query('SELECT `i`.*, `ri`.`amount`, `ri`.`amount_returned`, `ri`.`amount_dirty`
            FROM `requests` AS `r`
            INNER JOIN `requestItems` AS `ri` ON `ri`.`requestid` = `r`.`id`
            INNER JOIN `items` AS `i` ON `i`.`id` = `ri`.`itemid`
            WHERE `r`.`id` = %d', $requestID);
$items = array();


while($row = $db->fetchAssoc()) {
    $items[$row['id']] = $row;
}

#print_r($items);



// get amount + savings
$monies = $db->queryFirst('SELECT SUM(`deposit`) AS `deposit`, SUM(`savings`) AS `savings` FROM `requestItems` `r` RIGHT JOIN `items` `i` ON `i`.`id` = `r`.`itemid` WHERE `requestid` = %d', $requestID);
$_SESSION['deposit'] = 20 * ($monies['deposit'] % 20); // round to nearest $20
$_SESSION['savings'] = $monies['savings'];


$tpl->assign('user', $user);
$tpl->assign('request', $request);
$tpl->assign('items', $items);

$tpl->display('confirm.tpl');

// header('Content-Type: text/plain');
// echo 'processing request ' . $requestID . ' in confirm.php' . "\n\n";
// echo '$request: ' . print_r($request, true);
// echo "\n" . '$items: ' . print_r($items, true);