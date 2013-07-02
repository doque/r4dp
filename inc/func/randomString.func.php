<?php

/*
* @func: string randomStrin(int $length [, string $pool])
* @desc: generates a random string with variable length.
* @param: length: length of the randomly generated string.
* @param: pool: char pool from which single chars are taken to generate the random string. Default is [a-z0-9]
* @ret: Returns a random string with the given length.
*/

function randomString($length, $pool = 'abcdefghijklmnopqrstuvwxyz0123456789') {
	srand();
	$string = '';
	for($i = 0; $i < $length; $i++) {
		$pos = rand() % strlen($pool);
		$string .= $pool{$pos};
	}
	return $string;
}

?> 