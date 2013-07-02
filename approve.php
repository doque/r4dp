<?php

require_once 'global.php';

// approve request

if (!empty($_GET['q']) && !empty($_GET['a'])) {
	try {
		$db->query('UPDATE `requests`
						SET 
							`approved` = 1
						WHERE 
							`quickid` = "%s"
							AND
							`confirmauth` = "%s"', $_GET['q'], $_GET['a']);
		// send email
		
		// redirect to some shit site
		header('Location: message.php?msg=approved');
	} catch (MySQLException $e) {
		die($e->toString());
	}
} else {
	exit;// or sth like that
}

?>