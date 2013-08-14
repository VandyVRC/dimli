<?php
$dev = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$dev);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_users_create'); ?>

<div>
	
	<p class="instructions center_text">Enter information about the new user</p>

	<form id="registerNewUser">

		<div class="inline label">First name:</div>

		<input type="text"
			name="first_name"
			placeholder="First name"
			value="">

	</form>

</div>