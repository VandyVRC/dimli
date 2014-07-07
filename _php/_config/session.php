<?php
//-------------------------------------------------------------
// Set lifetime of cookie to 1 year
// Cookie lifetime determines length of php session
// Must be called BEFORE session_start();
// To retrieve this value: ini_get('session.cookie_lifetime');
//-------------------------------------------------------------
session_set_cookie_params(31536000);

session_start();

// Verify that the current session is logged in
function logged_in() {
	return isset($_SESSION['user_id']);
}

// Reroute to the login screen if session is not logged in
function confirm_logged_in() {
	if (!logged_in()) {
		header('Location: login.php');
	}
}
?>