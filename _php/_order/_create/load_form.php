<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_orders_create');

// If there is not yet an array to store new repository data
if (!isset($_SESSION['newOrderDetails']) || empty($_SESSION['newOrderDetails'])) {

	// Create empty array to store repository data
	// TODO: Revert the below values when done testing
	// $_SESSION['newOrderDetails']['patron'] = '';
	$_SESSION['newOrderDetails']['patron'] = 'Matt';
	// $_SESSION['newOrderDetails']['department'] = '';
	$_SESSION['newOrderDetails']['department'] = 'Other';
	// $_SESSION['newOrderDetails']['email'] = '';
	$_SESSION['newOrderDetails']['email'] = 'mail@web.com';
	// $_SESSION['newOrderDetails']['dateNeeded'] = '';
	$_SESSION['newOrderDetails']['dateNeeded'] = '2014-10-28';
	// $_SESSION['newOrderDetails']['imageCount'] = '1';
	$_SESSION['newOrderDetails']['imageCount'] = '3';
	// $_SESSION['newOrderDetails']['sourceName'] = '';
	$_SESSION['newOrderDetails']['sourceName'] = 'The Source';
	// $_SESSION['newOrderDetails']['sourceNameType'] = '';
	$_SESSION['newOrderDetails']['sourceNameType'] = 'Vendor';

	$_SESSION['newOrderDetails']['sourceType'] = '';
	// $_SESSION['newOrderDetails']['source'] = '';
	$_SESSION['newOrderDetails']['source'] = 'Archivision';
	$_SESSION['newOrderDetails'][''] = '';
}

//---------------------------------------------------------
//  Create array of all existing patrons and users for auto-suggest
//---------------------------------------------------------

$sql = "SELECT DISTINCT(display_name), (department), (email) 
		FROM dimli.user ";

	$result = db_query($mysqli, $sql);

	$user_arr = array();
	while ($user = $result->fetch_assoc()) 
	{
		$user_arr[] = $user['display_name'];

		$patron = $user['display_name'];

		$fill_arr[$patron] = array('department'=>$user['department'], 'email'=> $user['email']);
	}
?>

<div>

	<p class="instructions center_text">Enter general information about the order.</p>

	<form id="createOrder_form">

		<div class="inline label">Patron:</div>

		<input type="text"
			name="patron"
			placeholder='e.g. "John Doe"'
			style="width: 220px;"
			value="<?php echoValue($_SESSION['newOrderDetails']['patron']); ?>">
			<div id="suggestedPatrons" class="pointer"></div>

		<br>

		<div class="inline label">Department:</div>

		<select name="department" id="department">

			<option value=""></option>

			<option value="History of Art"
				<?php selectedOption($_SESSION['newOrderDetails']['department'], 'History of Art'); ?>
				>History of Art</option>

			<option value="Classical Studies"
				<?php selectedOption($_SESSION['newOrderDetails']['department'], 'Classical Studies'); ?>
				>Classical Studies</option>

			<option value="Other"
				<?php selectedOption($_SESSION['newOrderDetails']['department'], 'Other'); ?>
				>Other</option>

		</select>

		<br>

		<div class="inline label">Email address:</div>

		<input type="text"
			name="email"
			style="width: 220px;"
			value="<?php echoValue($_SESSION['newOrderDetails']['email']); ?>">

		<br>

		<div style="position: relative;">

			<div class="inline label">Date needed:</div>

			<input type="text"
				id="datepicker3"
				class="date"
				name="dateNeeded"
				style="width: 90px;"
				value="<?php echoValue($_SESSION['newOrderDetails']['dateNeeded']); ?>">

			<div style="position: absolute; left: 150px; bottom: -7px; font-size: 0.8em; font-style: italic;">
				Allow a minimum of 2 weeks
			</div>

		</div>

		<br>

		<div class="inline label">Source name:</div>

		<input type="text"
			name="sourceName"
			style="width: 220px;"
			value="<?php echoValue($_SESSION['newOrderDetails']['sourceName']); ?>">

		<br>

		<div class="inline label">Source type:</div>

		<select name="sourceNameType">
							
			<option value=""></option>

			<option value="Book" 
				<?php selectedOption($_SESSION['newOrderDetails']['sourceNameType'], 'Book'); ?>
				>Book</option>

			<option value="Catalogue" 
				<?php selectedOption($_SESSION['newOrderDetails']['sourceNameType'], 'Catalogue'); ?>
				>Catalogue</option>

			<option value="Corpus" 
				<?php selectedOption($_SESSION['newOrderDetails']['sourceNameType'], 'Corpus'); ?>
				>Corpus</option>

			<option value="Donor" 
				<?php selectedOption($_SESSION['newOrderDetails']['sourceNameType'], 'Donor'); ?>
				>Donor</option>

			<option value="Electronic" 
				<?php selectedOption($_SESSION['newOrderDetails']['sourceNameType'], 'Electronic'); ?>
				>Electronic</option>

			<option value="Serial" 
				<?php selectedOption($_SESSION['newOrderDetails']['sourceNameType'], 'Serial'); ?>
				>Serial</option>

			<option value="Vendor" 
				<?php selectedOption($_SESSION['newOrderDetails']['sourceNameType'], 'Vendor'); ?>
				>Vendor</option>

			<option value="Other" 
				<?php selectedOption($_SESSION['newOrderDetails']['sourceNameType'], 'Other'); ?>
				>Other</option>
		
		</select>

		<br>

		<div id="createOrder_imageCount_div"
			style="position: relative;">

			<div class="inline label">Image count:</div>

			<input type="text"
				name="imageCount"
				maxlength="3"
				style="width: 3em;"
				value="<?php echoValue($_SESSION['newOrderDetails']['imageCount']); ?>">

			<span style="font-size: 0.8em; font-style: italic;">Max: 200</span>

			<br>

		</div>

		<div class="inline label">Source info:</div>

		<select name="sourceType">
							
			<option value=""></option>

			<option value="Citation" 
				<?php selectedOption($_SESSION['newOrderDetails']['sourceType'], 'Citation'); ?>
				>Citation</option>

			<option value="ISBN" 
				<?php selectedOption($_SESSION['newOrderDetails']['sourceType'], 'ISBN'); ?>
				>ISBN</option>

			<option value="ISSN" 
				<?php selectedOption($_SESSION['newOrderDetails']['sourceType'], 'ISSN'); ?>
				>ISSN</option>

			<option value="ASIN" 
				<?php selectedOption($_SESSION['newOrderDetails']['sourceType'], 'ASIN'); ?>
				>ASIN</option>

			<option value="Open URL" 
				<?php selectedOption($_SESSION['newOrderDetails']['sourceType'], 'Open URL'); ?>
				>Open URL</option>

			<option value="URI" 
				<?php selectedOption($_SESSION['newOrderDetails']['sourceType'], 'URI'); ?>
				>URI</option>

			<option value="Vendor" 
				<?php selectedOption($_SESSION['newOrderDetails']['sourceType'], 'Vendor'); ?>
				>Vendor</option>

			<option value="Other" 
				<?php selectedOption($_SESSION['newOrderDetails']['sourceType'], 'Other'); ?>
				>Other</option>
		
		</select>

		<br>

		<div id="createOrder_otherInfo_text" style="display: none;">

			<div class="inline label"></div>

			<input type="text"
				name="source"
				style="width: 200px;"
				value="<?php echoValue($_SESSION['newOrderDetails']['source']); ?>">

			<br>

		</div>

		<div class="legacy_wrap">

			<input type="checkbox" id="legacyIds" name="legacyIds">
			<label for="legacyIds">I would like to specify an existing identifier for each image record</label>

		</div>

		<button type="button"
			id="createOrder_continue_button"
			>Continue</button>

		<span id="createOrder_errors"></span>

	</form>

</div>

<script>

	//  Add Close button to module

	closeModule_button($('div#createOrder_module'));
	$('div#createOrder_module img[class*="closeButton"]').click(
		function()
		{
			$('div#createOrderFigs_module').remove();
		});

//--------------------------------------------------------
	//  Prepare suggest_input function with arrays of users
	//--------------------------------------------------------

	var user_a = <?php echo json_encode($user_arr); ?>;
	var filler_a = <?php echo json_encode($fill_arr); ?>;

	$('input[name=patron]').keyup(
		function()
		{
			
		suggest_inputFill('patron', 2,  user_a, 'suggestedPatrons', filler_a);
		});

	//  Load jQuery's datepicker widget

	 $(function () {
   	 $('.date').datepicker({ dateFormat: 'yy-mm-dd' });
   	});

	//  Prohibit "Image count" higher than 200

	$('input[name=imageCount]').keyup(
		function()
		{
			var count = $(this).val();

			if (count > 200)
			{
				$('span#createOrder_errors').text('200 is the maximum number of images allowed');
				$(this).val('');
			}
			
			else if (count >= 1)
				$('span#createOrder_errors').text('');
	});

	//  Display text input field when "Source info" has been selected

	$('select[name=sourceType]').change(
		function()
		{
			var selected = $('select[name=sourceType] option:selected').val();

			if (selected != '')
			{
				$('div#createOrder_otherInfo_text').show();
				$('div#createOrder_otherInfo_text div.label').text(selected+':');
			}
			else
			{
				$('div#createOrder_otherInfo_text').hide();
				$('div#createOrder_otherInfo_text div.label').text('');
			}
		});

//----------------------------------------------------------
//  Check for user existence using suggest_input array
// Create new user or continue to page and figure assignment
//-----------------------------------------------------------

	$('button#createOrder_continue_button')
		.click(createOrder_continue);
		

</script>