<?php

// Is there any input?
if ( array_key_exists( "default", $_GET ) && !is_null ($_GET[ 'default' ]) ) {
	$default = htmlspecialchars($_GET['default']);
	
	# White list the allowable languages
	switch ($default) {
		case "French":
		case "English":
		case "German":
		case "Spanish":
			# ok
			break;
		default:
			header ("location: ?default=English");
			exit;
	}
}

?>
