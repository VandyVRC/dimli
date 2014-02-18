<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_csv_export');

//--------------------------------------------------------------------
// Define first and last records to export and save values to SESSION
//--------------------------------------------------------------------

$_SESSION['firstExportRecord'] =
	(isset($_SESSION['firstExportRecord']))
	? $_SESSION['firstExportRecord']
	: '';
$_SESSION['lastExportRecord'] =
	(isset($_SESSION['lastExportRecord']))
	? $_SESSION['lastExportRecord']
	: '';
$_SESSION['exportFlagged_count'] =
	(isset($_SESSION['exportFlagged_count']))
	? $_SESSION['exportFlagged_count']
	: '';
$_SESSION['flaggedImages'] = array();

//----------------------------------
// Find "Flagged & Approved" images
//----------------------------------

// Fetch all flagged image records
$sql = "SELECT id FROM $DB_NAME.image 
			WHERE catalogued = 1 
			AND flagged_for_export = 1 ";
$result = db_query($mysqli, $sql);

// Put all flagged record ids in an array
$flaggedImages = array();
while ($row = $result->fetch_assoc()):
	$flaggedImages[] = $row['id'];
	endwhile;

foreach ($flaggedImages as $key=>$image):

	// Find the order id for the current image record
	$sql = "SELECT order_id 
				FROM $DB_NAME.image 
				WHERE id = {$image} ";
	$result = db_query($mysqli, $sql);
	while ($row = $result->fetch_assoc()):
		$order = ltrim($row['order_id'], '0');
		endwhile;

	// Find approved status of this order
	$sql = "SELECT cataloguing_approved 
				FROM $DB_NAME.order 
				WHERE id = {$order} ";
	$result = db_query($mysqli, $sql);
	while ($row = $result->fetch_assoc()):
		$approved = $row['cataloguing_approved'];
		endwhile;

	// If order is NOT approved, remove image from array
	if ($approved != 1):
		unset($flaggedImages[$key]);
		endif;

	endforeach;

// Eliminate duplicates and add to SESSION
$_SESSION['flaggedImages'] = array_unique($flaggedImages);
unset($flaggedImages);

?>

<div id="exportRange_form">

	<p class="instructions">a) Export specific image records (.csv)</p>

	<input type="text" 
		name="firstExportRecord" 
		value="<?php echoValue($_SESSION['firstExportRecord']); ?>"><!--

	-->&nbsp;&nbsp;to&nbsp;&nbsp;<!--

	--><input type="text" 
		name="lastExportRecord" 
		value="<?php echoValue($_SESSION['lastExportRecord']); ?>" style="margin-left: 0;">

	<button type="button"
		id="exportCsv"
		name="exportCsv">Download...</button>

	<p class="subtext">- Enter the first and last image record you wish to export</p>
	<p class="subtext">- For Dimli record numbers, you must include the leading zeros</p>
	<p class="subtext">- Limit export to 10,000 records</p>

</div>

<div id="exportAll_form" 
	style="border-top: 1px dotted #CCC; margin-top: 10px;">

	<p class="instructions">b) Export "Flagged &amp; Approved" image records (.csv)</p>

	<span style="padding-left: 10px;">

		<?php echo (isset($_SESSION['flaggedImages'])) 
					? count($_SESSION['flaggedImages']).' '
					: 'unknown '; ?>total records</span>

	<button type="text"
		id="exportCsv_allFlagged"
		name="exportCsv_allFlagged">Download...</button>

	<p class="subtext" style="margin-top: 10px;">"Flagged &amp; Approved" records include those that have been recently updated or manually flagged, and whose orders have been approved by the curator</p>

</div>

<script>

	// Add close button to module
	closeModule_button($('div#exportForm_module'));

	$('button#exportCsv').click(
		function()
		{
			query_export();
		});

	$('button#exportCsv_allFlagged')
		.click(promptToConfirm)
		.click(
			function()
			{
				$('button#conf_button').click(
					function()
					{
						export_flagged();
					});
			}
			);
</script>