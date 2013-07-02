<?php

require 'global.php';
if (isset($_GET['msg'])) {

	$messages = array('confirmed' => array('Request has been confirmed', 'The request has been confirmed and the user has been notified.'),
					  'deleted' => array('Request has been deleted', 'The request has been deleted.'),
					  'approved' => array('Request has been approved', 'Your Request has been approved'),
					  'notfound' => array('Request was not found', 'Could not find a request with the specified id')
					  );
					  
	$key = strtolower(trim($_GET['msg']));
					
	if (in_array($key, array_keys($messages))) {
		
		$tpl->assign('title', $messages[$key][0]);
		$tpl->assign('msg', $messages[$key][1]);

		$tpl->display('message.tpl');
	

	} else {
		exit('unknown message');
	}

}




?>