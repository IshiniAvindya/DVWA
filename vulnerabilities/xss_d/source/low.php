<?php



// Is there any input?
if ( array_key_exists( "default", $_GET ) && !is_null ($_GET[ 'default' ]) ) {

	# White list the allowable languages
	$allowed_languages = array("French", "English", "German", "Spanish");
	if (!in_array($_GET['default'], $allowed_languages)) {
		header ("location: ?default=English");
		exit;
	}
}

?>


