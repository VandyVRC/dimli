<?php
$dev = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$dev);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();


###########################################################
##################  BEGIN CLIENT-SIDE  ####################
###########################################################
require("_php/header.php");
?>

<div id="message_wrapper">
	<div id="message_text"></div>
</div>

<div id="module_tier5"><p class="clear_module"></p></div>

<div id="module_tier4"><p class="clear_module"></p></div>

<form method="post" 
	id="catalog_form"
	action="">

<div id="module_tier3"><p class="clear_module"></p></div>

</form>

<div id="module_tier2a"><p class="clear_module"></p></div>

<div id="module_tier2"><p class="clear_module"></p></div>

<div id="module_tier1a"><p class="clear_module"></p></div>

<div id="module_tier1">

	<div id="user_module" class="module double">

		<h1>Welcome<?php echo ' '.$_SESSION['first_name'];?></h1>

		<?php if ($_SESSION['pref_user_type'] == 'cataloger'): ?>

			<!-- 
					Activity Log (Curators & Catalogers)
			 -->
			<div class="floatLeft">
				<?php include('_php/_homepage/activity_log.php'); ?>
			</div>

		<?php endif; ?>

		<?php if ($_SESSION['pref_user_type'] == 'cataloger'): ?>

			<!-- 
					To-Do List (Curators & Catalogers)
			 -->
			<div class="floatLeft">
				<?php include('_php/_homepage/todo_list.php'); ?>
			</div>

		<?php elseif ($_SESSION['pref_user_type'] == 'end_user'): ?>

			<!-- 
					Download Your Orders (Faculty & Patrons)
			 -->
			<div class="floatLeft">
				<?php include('_php/_homepage/your_orders.php'); ?>
			</div>

		<?php endif; ?>

		<!-- 
				Catalog Highlight (Visible to all)
		 -->
		<div class="floatLeft">
			<?php include('_php/_homepage/catalog_highlights.php'); ?>
		</div>
		
	</div>

	<p class="clear_module"></p>

</div>

<?php require("_php/footer.php"); ?>