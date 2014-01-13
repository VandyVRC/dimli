<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_orders_create');

	// Does the user want to use legacy identifiers/filenames?
$useLegacyIds = $_POST['legacyIds'] === 'true';

	// Instructional text
$instructionHeading1 = $useLegacyIds
	? 'Enter unique identifiers and, optionally, a filename for each image included with this order'
	: 'Enter page and figure numbers, or brief instructions, for each image included with this order';
$instructionHeading2 = $useLegacyIds
	? ''
	: 'Do <em>NOT</em> include abbreviations such as "pg", "p.", or "fig."';

	// Define placeholder text for inputs based on whether the user
	// elected to use legacy identifiers for this order
$placeholderVal1 = $useLegacyIds
	? 'identifier'
	: 'page';
$placeholderVal2 = $useLegacyIds
	? 'filename/other'
	: 'fig/instructions';
?>

<div>

	<p class="instructions center_text"><?php echo $instructionHeading1; ?></p>

	<p class="instructions center_text" style="font-size: 0.8em;"><?php echo $instructionHeading2; ?></p>

	<form id="createOrderFigs_form">

		<div class="pageFig_row"
			style="line-height: 16px;">

			<div class="pageFig_row_number"
				style="display: inline-block; width: 30px; font-size: 1.1em; font-weight: 400; color: #CCC; text-align: right; vertical-align: middle; margin-right: 5px;">1</div>

			<input type="text"
				placeholder="<?php echo $placeholderVal1; ?>"
				style="width: 80px; margin-left: 0; margin-bottom: 5px;"
				value="">

			<input type="text"
				placeholder="<?php echo $placeholderVal2; ?>"
				style="width: 235px; margin-left: 5px; margin-bottom: 5px;"
				value="">

			<img src="_assets/_images/plus.png"
				class="pageFig_addRow pointer"
				title="Insert a new row"
				style="height: 18px; opacity: 0.8; vertical-align: middle;">

			<img src="_assets/_images/trash_mac.png"
				class="pageFig_removeRow pointer"
				title="Remove this row"
				style="height: 18px; opacity: 0.8; vertical-align: middle;">

		</div>

		<button id="createOrder_back_button"
			type="button"
			>Back</button>

		<button id="createOrder_submit_button"
			style="margin-left: 5px;"
			type="button"
			>Submit</button>

	</form>

</div>

<script>

	closeModule_button($('div#createOrderFigs_module'));

	$('div#createOrderFigs_module img[class*=closeButton]').click(
		function () {
			$('div#createOrder_module').remove();
		});


	//  User clicks add

	$('img.pageFig_addRow').click(
		function () {
			var row = $(this).parents('div.pageFig_row').clone(true);
			$(row).find('input').val('');
			$(row).hide().insertAfter($(this).parent()).slideDown(200);

			$('div.pageFig_row').each(
				function () {
					$(this).find('div.pageFig_row_number')
						.text($(this).parent().children().index(this)+1);
				});

			$('div#createOrder_module input[name=imageCount]')
				.val(Number($('div#createOrder_module input[name=imageCount]').val())+1);
		});


	// User clicks trash

	$('img.pageFig_removeRow').click(
		function () {

				// If this is NOT the last remaining row
			if ($('div.pageFig_row').length > 1) {

				var row = $(this).parents('div.pageFig_row');

				$(row).slideUp(200, function () {

					$(this).remove();
					
					$('div.pageFig_row').each(
						function () {
							$(this).find('div.pageFig_row_number')
								.text($(this).parent().children().index(this)+1);
						});
				});

				$('div#createOrder_module input[name=imageCount]')
					.val(Number($('div#createOrder_module input[name=imageCount]').val())-1);

			}

		});


	//  User clicks "Submit" and "Confirm"

	$('button#createOrder_submit_button')
		.click(promptToConfirm)
		.click(
			function () {
				$('button#conf_button').click(createOrder_newUser);
			});

	
	//  User clicks "Back" to return to first step

	$('button#createOrder_back_button').click(
		function () {

				// Remove the Page/Fig module
			$('div#createOrderFigs_module').remove();

				// Show the "Continue" button in the New Order module
			$('button#createOrder_continue_button').show();

				// Enable the inputs in the New Order module
			$('form#createOrder_form').find('input[type=text], input[type=checkbox], select')
				.attr('disabled', false);

				// Bind event for "Continue" button in New Order module
			$('button#createOrder_continue_button')
				.click(createOrder_continue);

				// Scroll to top of document
			$(document).scrollTop($('body').offset().top);
		});


	var imageCount = $('div#createOrder_module input[name=imageCount]').val();
	var row = $('div.pageFig_row:eq(0)');

	for (var i = 1; i < imageCount; i++) {

		console.log('cloned');

		$(row).clone(true).insertAfter('div.pageFig_row:last');
		
		$('div.pageFig_row').each(
			function () {

				$(this).find('div.pageFig_row_number')
					.text($(this).parent().children().index(this)+1);

			});
	}

</script>