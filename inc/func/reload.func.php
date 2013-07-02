<?php

/*
* @func: void reload([string $anchor])
* @desc: reloads the current page with all current request params - useful to empty $_POST for example
* @param: anchor: #anchor being attached to the uri. Optional.
*/

function reload($anchor = '') {
	header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $anchor);
	exit;
}

?> 