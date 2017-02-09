<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');

//  Find the session (done above in _php/_config/session.php)

//  Unset all the session variables
$_SESSION = array();

//  Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-86400, '/');
}

//  Destroy the session
session_destroy();

header('Location: login.php');
die();