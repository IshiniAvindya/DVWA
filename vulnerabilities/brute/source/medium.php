<?php

// Number of allowed login attempts
$max_attempts = 5;

// Time to lock the account (in seconds)
$lockout_time = 600;

// Check if the user's account is locked
if (isset($_SESSION['locked']) && $_SESSION['locked'] > time()) {
  die('Your account is locked. Please try again in ' . ($_SESSION['locked'] - time()) . ' seconds.');
}

// Check if the user has exceeded the number of allowed login attempts
if (isset($_SESSION['attempts']) && $_SESSION['attempts'] >= $max_attempts) {
  $_SESSION['locked'] = time() + $lockout_time;
  die('You have exceeded the number of allowed login attempts. Your account is now locked for ' . $lockout_time . ' seconds.');
}


if( isset( $_GET[ 'Login' ] ) ) {
	// Sanitise username input-Check the user's credentials
	$user = $_GET[ 'username' ];
	$user = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $user ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

	// Sanitise password input-Check the user's credentials
	$pass = $_GET[ 'password' ];
	$pass = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $pass ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
	$pass = md5( $pass );

	// Validate the credentials against the database
	$query  = "SELECT * FROM `users` WHERE user = '$user' AND password = '$pass';";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );

	if( $result && mysqli_num_rows( $result ) == 1 ) {
		// Get users details
		$row    = mysqli_fetch_assoc( $result );
		$avatar = $row["avatar"];

		// Login successful
		$html .= "<p>Welcome to the password protected area {$user}</p>";
		$html .= "<img src=\"{$avatar}\" />";
	}
	else {
    // Increment the number of login attempts
    if (!isset($_SESSION['attempts'])) {
      $_SESSION['attempts'] = 1;
    } else {
      $_SESSION['attempts']++;
    }
    die('Incorrect username or password. You have ' . ($max_attempts - $_SESSION['attempts']) . ' attempts remaining.');
  }

	((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
}

?>
