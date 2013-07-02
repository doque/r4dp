<?php

/*
* @func: string stripToAlpha(string $string [, bool $whiteSpaces])
* @desc: strips all non-alphanumeric chars from the string
* @param: string: The string that should be stripped
* @param: whiteSpaces: If true, also whitespaces will be stripped. Default is false (so whitespaces don't get stripped)
* @ret: No value is returned
*/

function stripToAlpha(&$string, $whiteSpaces = false) {
	if(!$whiteSpaces) {
		$search = '/[^a-zA-Z0-9\s]/';
	} else {
		$search = '/[^a-zA-Z0-9]/';
	}
	$string = preg_replace($search, '', $string);
}

?> 