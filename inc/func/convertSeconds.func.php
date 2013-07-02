<?php

/*
* @func: string convertSeconds(int $time)
* @desc: Converts seconds into a human readable format.
* @param: time: Number of seconds to convert.
* @ret: Returns the converted string.
*/

function convertSeconds($time) {
	$days    = floor($time / 86400);
	$hours   = floor(($time - $days * 86400) / 3600);
	$minutes = floor(($time - $days * 86400 - $hours * 3600) / 60);
	$seconds = floor($time - $days * 86400 - $hours * 3600 - $minutes * 60);

	$str = '';
	if($days)    $str .= $days.'d ';
	if($hours)   $str .= $hours.'h ';
	if($minutes) $str .= $minutes.'m ';
	if($seconds) $str .= $seconds.'s';

	if(empty($str)) $str = '00s';
	return $str;
}

?>