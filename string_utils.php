<?php
/*
 * Add as a helper to the CodeIgniter application/config/autoload.php e.g.
 * $autoload['helper'] = array('url', 'form', 'cookie', 'array', 'string', 'logging');
 */
/**
 * Takes a string and uppercases the first characters of each word.
 * Like ucwords except this works on hyphenated names or names with apostrophes in.
 * Also handles Mc and Mac.
 *
 * @param (string) $text
 * @return string
 */
function ucname($text) {
	return preg_replace_callback ( "/(\w+)/", function ($m) {
		$part = strtolower ( $m [0] );
		$ending = array ();
		if (preg_match ( "/^mc(.*)/", $part, $ending )) {
			return "Mc" . ucfirst ( $ending [1] );
		} elseif (preg_match ( "/^mac(.*)/", $part, $ending )) {
			return "Mac" . ucfirst ( $ending [1] );
		}
		return ucfirst ( $part );
	}, $text );
}
/**
 * Wrapper for str_pad().
 * Pads a string to a certain length using zeros.
 * See str_pad() PHP documentation for pad_type constants.
 *
 * @param string $str
 * @param int $len
 * @param int $pad_type
 * @return string
 */
function zero_pad($str, $len, $pad_type = NULL) {
	return str_pad ( $str, $len, "0", $pad_type );
}
/**
 * Returns true if arg1 contains null or is a zero-length string.
 * Differs from empty() in that it returns true for elements with value '0' or false.
 * If arg2 is true whitespace counts as blank.
 *
 * @param mixed $val
 * @param boolean $include_whitespace
 * @return array
 */
function is_blank($val, $include_whitespace = false) {
	return (is_null ( $val ) || $val === '' || ($include_whitespace && ctype_space ( $val )));
}
