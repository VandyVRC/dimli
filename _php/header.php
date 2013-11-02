<!doctype html>
<html>

<head>

<?php
//
// Define directory root for use below, based on whether the app 
// is being run in the XAMPP development environment
//
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)
	?'/dimli'
	:'';
if (!defined('MAIN_DIR')) {
	define('MAIN_DIR', $_SERVER['DOCUMENT_ROOT'].$urlpatch);
}

header('Content-type: text/html; charset=utf-8'); ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<title>dimli</title>

<!-- Roboto font -->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,300' 
	rel='stylesheet' type='text/css'>

<!-- Favicon -->
<link href="_assets/_images/favicon.png" rel="icon" type="image/png">

<!-- Stylesheets -->
<link href="_stylesheets/hobblet.css?<?php echo date('His');?>" rel="stylesheet" type="text/css">

<!-- jQuery JS and CSS -->
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>

<!-- Bind jQuery Datepicker -->
<script>
$(function() {
	$('.date').datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>

<!-- Load UI-feedback functions for immediate use -->
<script src="_javascript/ui_feedback.js"></script>

</head>
<!--
#####################################################################
##########################  BEGIN BODY  #############################
#####################################################################
-->
<body>

<div id="header_wide">

	<div id="header">

		<ul id="nav_list">

			<a href="index.php">
				<li class="nav_item">dimli</li>
			</a>

		<?php if (logged_in() && strpos($_SERVER['REQUEST_URI'], 'import') === false) { ?>

			<?php if ($_SESSION['priv_users_read']=='1') { ?>

			<!-- 
				ADMIN
			 -->

			<li class="nav_item">admin
				<span>&nbsp;&#9660;</span>

				<div class="nav_dropdown">

					<?php if ($_SESSION['priv_users_read']=='1') { ?>

					<div id="nav_browseUsers"
						class="nav_dropdown_item">browse<br>users</div>

					<?php } ?>

					<?php if ($_SESSION['priv_users_create']=='1') { ?>

					<div id="nav_registerUser"
						class="nav_dropdown_item">register<br>user</div>

					<?php } ?>

				</div>

			</li>

			<?php } ?>

			<?php if ($_SESSION['pref_user_type'] === 'cataloger') { ?>

			<!-- 
				CURATE
			 -->

			<li class="nav_item">curate
				<span>&nbsp;&#9660;</span>

				<div class="nav_dropdown">

					<?php if ($_SESSION['priv_approve']=='1') { ?>

					<!-- <div class="nav_dropdown_item faded grey">approve<br>cataloging</div> -->

					<?php } ?>

					<?php if ($_SESSION['priv_csv_export']=='1') { ?>

					<div id="nav_export"
						class="nav_dropdown_item">export<br>records</div>

					<?php } ?>

					<?php if ($_SESSION['priv_catalog']=='1') { ?>

					<div id="nav_viewOrphanedWorks" 
						class="nav_dropdown_item">unused<br>works</div>

					<?php } ?>

					<?php if ($_SESSION['priv_catalog']=='1') { ?>

					<div id="nav_viewOrphanedImages" 
						class="nav_dropdown_item">parentless<br>images</div>

					<?php } ?>

					<?php if ($_SESSION['priv_csv_import']=='1') { ?>

					<div id="nav_import"
						class="nav_dropdown_item">import<br>records</div>

					<?php } ?>

				</div>

			</li>

			<?php } ?>

			<?php if ($_SESSION['priv_orders_read']=='1' || $_SESSION['priv_orders_create']=='1') { ?>

			<!-- 
				ORDERS
			 -->

			<li class="nav_item">orders
				<span>&nbsp;&#9660;</span>

				<div class="nav_dropdown">

					<?php if ($_SESSION['priv_orders_read']=='1') { ?>

					<div id="nav_findOrder" 
						class="nav_dropdown_item">view<br>orders</div>

					<?php } ?>

					<?php if ($_SESSION['priv_orders_create']=='1') { ?>

					<div id="nav_createOrder"
						class="nav_dropdown_item">create<br>order</div>

					<?php } ?>

				</div>

			</li>

			<?php } ?>

			<?php if ($_SESSION['priv_catalog']=='1') { ?>

			<!-- 
				CATALOG
			 -->

			<li class="nav_item">build
				<span>&nbsp;&#9660;</span>

				<div class="nav_dropdown">

					<?php if ($_SESSION['priv_catalog']=='1') { ?>

					<div id="nav_createRepository" 
						class="nav_dropdown_item">create<br>repository</div>

					<?php } ?>

					<?php if ($_SESSION['priv_catalog']=='1') { ?>

					<div id="nav_createWork" 
						class="nav_dropdown_item">create<br>work</div>

					<?php } ?>

				</div>

			</li>

			<?php } ?>

			<?php if ($_SESSION['priv_catalog']=='1') { ?>

			<!-- 
				LANTERN
			 -->

			<li id="nav_lantern">lantern
				
				<div class="nav_dropdown defaultPointer"
					style="margin-left: -100px; padding: 15px;">

					<div style="font-size: 0.8em; text-align: center;">Feature operable, but incomplete</div>

					<input type="search"
						id="lantern_search"
						placeholder="" autofocus
						style="margin: 0;"
						value="">

					<div style="margin: 20px 0 8px 0; font-size: 0.75em; color: #E6E6FA; position: relative;"
						title="Feature not yet available">

						<input type="checkbox"
							id="lantern_gettyToggle"
							style="margin: 0; vertical-align: bottom;"
							disabled class="fadedMore">

						<span class="fadedMore" style="font-size: 1.0em;">

							Extra kerosene! (takes much longer)

						</span>

						<button type="button"
							style="position: absolute; right: 0; margin: 0; padding: 2px 25px; margin-top: -7px; border-radius: 3px; font-size: 1.3em; font-weight: 400;"
							id="lantern_submit"
							name="lantern_submit">Go</button>

					</div>

				</div>

			</li>

			<?php } ?>

		<?php } // If logged in ?>

		</ul>

		<ul id="header_userInfo">

			<li>
				
				<?php if (logged_in()) { ?>

					<a href="logout.php">log out</a>

				<?php } else { ?>

					<a href="login.php">log in</a>

				<?php } ?>

			</li>

			<li class="defaultCursor">

				<?php if (logged_in() == true) {

					echo $_SESSION['display_name'];

				} ?>

			</li>

		</ul>

	</div> <!-- header -->

</div> <!-- header_wide -->

<div id="header_spacer"></div>

<div id="control_panel_wide">

	<div id="control_panel">

		<?php if (logged_in()) {

			include('_php/_lantern/lantern_control_panel.php');

		} ?>

	</div>

</div>

<div id="body_wide">

	<div id="body">