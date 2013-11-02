<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_orders_read');

//--------------------------------------------------------------
//  Initialize SESSION variables, unless they are already set.
//  These hold the user-entered values for each input field.
//--------------------------------------------------------------

// Define list of input field names
$findOrders_inputNames = array('orderNum_start', 'orderNum_end', 'created_start', 'created_end', 'created_by', 'department', 'patron', 'updated_by');

foreach ($findOrders_inputNames as $inputName)
{
	$_SESSION['findOrders_'.$inputName] =
		(isset($_SESSION['findOrders_'.$inputName]))
		? $_SESSION['findOrders_'.$inputName]
		: '';
}

// Set orderNum_range to "no" by default
$_SESSION['findOrders_orderNum_range'] =
	(isset($_SESSION['findOrders_orderNum_range']))
	? $_SESSION['findOrders_orderNum_range']
	: 'no';

// Set showIncomplete to "yes" by default
$_SESSION['findOrders_showIncomplete'] =
	(isset($_SESSION['findOrders_showIncomplete']))
	? $_SESSION['findOrders_showIncomplete']
	: 'yes';

// Set showComplete to "no" by default
$_SESSION['findOrders_showComplete'] =
	(isset($_SESSION['findOrders_showComplete']))
	? $_SESSION['findOrders_showComplete']
	: 'no';

//---------------------------------------------------------
//  Create array of all existing patrons for auto-suggest
//---------------------------------------------------------

$sql = "SELECT DISTINCT(requestor) 
			FROM dimli.order ";

$result = db_query($mysqli, $sql);

$user_arr = array();
while ($patron = $result->fetch_assoc()) {
	$patron_arr[] = $patron['requestor'];
}

//--------------------------------------------------------
//  Create array of all existing users for auto-suggest
//--------------------------------------------------------

$sql = "SELECT DISTINCT(display_name) 
			FROM dimli.user ";

$result = db_query($mysqli, $sql);

$user_arr = array();
while ($user = $result->fetch_assoc()) {
	$user_arr[] = $user['display_name'];
}

?>

<div id="browseOrders_searchWrapper">

	<div class="mediumWeight">Order</div>

	<input type="text"
		name="orderNum_start"
		placeholder="Order Id"
		maxlength="4"
		value="<?php echo $_SESSION['findOrders_orderNum_start']; ?>">

	<input type="text"
		name="orderNum_end"
		placeholder="Through Order Id"
		maxlength="4"
		value="<?php echo $_SESSION['findOrders_orderNum_end']; ?>">

	<input type="checkbox"
		name="orderNum_range"
		<?php echo ($_SESSION['findOrders_orderNum_range'] == 'yes') 
			? 'checked="checked"' 
			: ''; ?>
		value="yes">&nbsp;Order Range<br>

	<hr />

	<input type="checkbox" 
		name="show_incomplete"
		<?php echo ($_SESSION['findOrders_showIncomplete'] == 'yes') 
			? 'checked="checked"' 
			: ''; ?>
		value="yes">&nbsp;Show incomplete<br>

	<input type="checkbox" 
		name="show_complete" 
		<?php echo ($_SESSION['findOrders_showComplete'] == 'yes') 
			? 'checked="checked"' 
			: ''; ?>
		value="yes">&nbsp;Show complete

	<hr />

	<div class="mediumWeight" style="margin-top: 15px;">Patron</div>

	<input type="text"
		id="patron"
		name="patron"
		placeholder="Patron"
		value="<?php echo $_SESSION['findOrders_patron']; ?>">

	<div id="suggestedPatrons" class="pointer"></div>

	<select class="blank" name="department">

		<option id="blank" value="">- Department -</option>

		<option id="historyOfArt" 
			value="History of Art" 
			<?php selectedOption($_SESSION['findOrders_department'], 'History of Art'); ?>
			>History of Art</option>

		<option id="classicalStudies" 
			value="Classical Studies" 
			<?php selectedOption($_SESSION['findOrders_department'], 'Classical Studies'); ?>
			>Classical Studies</option>

		<option id="other" 
			value="Other" 
			<?php selectedOption($_SESSION['findOrders_department'], 'Other'); ?>
			>Other</option>

	</select>

	<div class="mediumWeight" 
		style="margin-top: 15px;"
		>Created</div>

	<input type="text"
		name="created_by"
		placeholder="Created by"
		value="<?php echo $_SESSION['findOrders_created_by']; ?>">

	<div id="suggestedCreators" class="pointer"></div>

	<input type="text"
		id="datepicker1"
		class="date"
		name="created_start"
		placeholder="Created after"
		value="<?php echo $_SESSION['findOrders_created_start']; ?>">

	<input type="text"
		id="datepicker2"
		class="date"
		name="created_end"
		placeholder="Created before"
		value="<?php echo $_SESSION['findOrders_created_end']; ?>">

	<div class="mediumWeight" style="margin-top: 15px;">Updated</div>

	<input type="text"
		name="updated_by"
		placeholder="Updated by"
		value="<?php echo $_SESSION['findOrders_updated_by']; ?>">

	<div id="suggestedUpdaters" class="pointer"></div>

	<input type="button" 
		id="findOrders_reset" 
		value="Reset"
		onclick="findOrders_reset();"
		style="margin-top: 15px; display: inline-block;">

	<input type="button" 
		id="findOrders_submit" 
		value="Submit"
		onclick="findOrders_loadResults(1, 'date_needed', 'ASC');"
		style="margin-top: 15px; margin-left: 10px; display: inline-block;">

</div>
	
<div id="findOrders_resultsTable">

	<script>

		findOrders_loadResults(1, 'date_needed', 'ASC');

	</script>

</div>

<script>

	//--------------------------------------------
	//  Hide order number range input by default
	//--------------------------------------------
	$('input[name=orderNum_end]').hide();


	//-----------------------------------------------
	//  Call function to monitor order range toggle
	//-----------------------------------------------

	$(document).ready(order_range);
	$('input[name=orderNum_range]').click(order_range);

	// Load jQuery's datepicker widget
	$(function () {
		$('#datepicker1').datepicker({ dateFormat: 'yy-mm-dd' });
		$('#datepicker2').datepicker({ dateFormat: 'yy-mm-dd' });
	});

	//--------------------------------------------------------
	//  Prepare suggest_input function with array of patrons
	//--------------------------------------------------------

	var patron_a = <?php echo json_encode($patron_arr); ?>;

	$('input[id=patron]').keyup(
		function()
		{
			suggest_input('patron', 2, patron_a, 'suggestedPatrons');
		});

	//------------------------------------------------------------
	//  Prepare suggest_input function with array of Dimli users
	//------------------------------------------------------------

	var user_a = <?php echo json_encode($user_arr); ?>;

	$('input[name=created_by]').keyup(
		function()
		{
			suggest_input('created_by', 2, user_a, 'suggestedCreators');
		});

	$('input[name=updated_by]').keyup(
		function()
		{
			suggest_input('updated_by', 2, user_a, 'suggestedUpdaters');
		});


	//----------------------------------------------
	//  Bind 'Enter' keypress to perform order
	//  search if cursor is in a text input field
	//----------------------------------------------

	$('div#browseOrders_searchWrapper').keypress(
		function(event)
		{
			if ((event.which && event.which == 13) || (event.keycode && event.keycode == 13))
			{
				$('input#findOrders_submit').click();
				return false;
			}
			else
			{
				return true;
			}
		});

	$('select').click(
		function()
		{
			if ($(this).val() == '')
			{
				$(this).addClass('blank');
			}
			else
			{
				$(this).removeClass('blank');
			}
		});

</script>