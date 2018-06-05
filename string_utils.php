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
/**
 * Return the string truncated to the given number of characters, and if truncated then append "..." (or append the string given in the 3rd arg).
 *
 * @param string $str
 * @param int $len
 * @param string $append
 * @return string
 */
function struncate($str, $len, $append = "...") {
	$strLen = strlen ( $str );
	if ($strLen > $len) {
		$str = substr ( $str, 0, $len ) . $append;
	}
	return $str;
}
/**
 * Modify the string truncated to the given number of characters, and if truncated then append "..." (or append the string given in the 3rd arg).
 *
 * @param string $str
 * @param int $len
 * @param string $append
 * @return string
 */
function struncate_(&$str, $len, $append = NULL) {
	return $str = struncate ( $str, $len, $append );
}
/**
 * Turn email address data into an array of separate email addresses, splitting strings on ; or , or whitespace, remove duplicates and blanks
 *
 * @param array $emails
 * @return string[]:
 *
 */
function split_emails($emails) {
	// Emails might be supplied as an array, or a string, so we'll cope with both.
	flatten_ ( $emails );
	$newemails = array ();
	foreach ( $emails as $email ) {
		// Get rid of any whitespace and double quotes
		$email = preg_replace ( '/(?:\"|\s)+/', '', $email );
		// Replace semi-colons with commas
		$email = preg_replace ( '/;/', ',', $email );
		// Split string on commas
		$email = explode ( ",", $email );
		$newemails = array_merge ( $newemails, $email );
	}
	// Remove duplicates and blanks
	$newemails = array_unique ( $newemails );
	remove_blanks_ ( $newemails );
	
	$emails = $newemails ? $newemails : NULL; // Set to NULL if there are no emails
	return $emails;
}
/**
 * By reference, turn email address data into an array of separate email addresses, splitting strings on ; or , or whitespace, remove duplicates and blanks
 *
 * @param array $emails
 * @return string[]:
 *
 */
function split_emails_(&$emails) {
	return $emails = split_emails ( $emails );
}
/**
 * A wrapper for "implode_neatly ( '/', ...$paths )" (sourced in array_utils.php).
 * Join url strings together with a '/' but first removing any leading or trailing delimiter characters..
 * The start of the first string will not have the delimiter removed or added (so absolute/relative paths remain so).
 * The end of the last string will not have the delimiter removed or added.
 *
 * @param string[] ...$paths
 * @return string
 */
function url_join(...$paths) {
	return implode_neatly ( '/', ...$paths );
}
/**
 * A wrapper for "implode_neatly ( DIRECTORY_SEPARATOR, ...$paths )"
 * Join path strings together with a '/' but first removing any leading or trailing delimiter characters..
 * The start of the first string will not have the delimiter removed or added (so absolute/relative paths remain so).
 * The end of the last string will not have the delimiter removed or added.
 *
 * @param string[] ...$paths
 * @return string
 */
function path_join(...$paths) {
	return implode_neatly ( DIRECTORY_SEPARATOR, ...$paths );
}
