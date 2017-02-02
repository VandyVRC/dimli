<?php

if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../_php/_config/session.php');
require_once(MAIN_DIR.'/../_php/_config/connection.php');
require_once(MAIN_DIR.'/../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_catalog');

if (!isset($_SESSION['newRepositoryDetails']) || empty($_SESSION['newRepositoryDetails']))
// If there is not yet an array to store new repository data
{
	// Create empty array to store repository data
	$_SESSION['newRepositoryDetails']['museum'] =
	$_SESSION['newRepositoryDetails']['address'] =
	$_SESSION['newRepositoryDetails']['city'] =
	$_SESSION['newRepositoryDetails']['state'] =
	$_SESSION['newRepositoryDetails']['zip'] =
	$_SESSION['newRepositoryDetails']['region'] =
	$_SESSION['newRepositoryDetails']['country'] =
	$_SESSION['newRepositoryDetails']['phone'] =
	$_SESSION['newRepositoryDetails']['website'] =
	$_SESSION['newRepositoryDetails']['images'] = '';
}
?>
<div>

	<p class="instructions center_text">Enter the details of the new repository below</p>

	<form id="createRepository_form">

		<div class="inline label">Museum name:</div>

		<input type="text"
			name="museum"
			placeholder="Museum name"
			value="<?php echoValue($_SESSION['newRepositoryDetails']['museum']); ?>">

		<br>

		<div class="inline label">Street address:</div>

		<input type="text"
			name="address"
			placeholder="Street address"
			value="<?php echoValue($_SESSION['newRepositoryDetails']['address']); ?>">

		<br>

		<div class="inline label">City:</div>

		<input type="text"
			name="city"
			placeholder="City"
			value="<?php echoValue($_SESSION['newRepositoryDetails']['city']); ?>">

		<br>

		<div class="inline label">State (optional):</div>

		<input type="text"
			name="state"
			placeholder="State (if applicable)"
			value="<?php echoValue($_SESSION['newRepositoryDetails']['state']); ?>">

		<br>

		<div class="inline label">Zip code (optional):</div>

		<input type="text"
			name="zip"
			placeholder="Zip code (if applicable)"
			value="<?php echoValue($_SESSION['newRepositoryDetails']['zip']); ?>">

		<br>

		<div class="inline label">Region:</div>

		<input type="text"
			name="region"
			placeholder="Region"
			value="<?php echoValue($_SESSION['newRepositoryDetails']['region']); ?>">

		<br>

		<div class="inline label">Country:</div>

		<input type="text"
			name="country"
			placeholder="Country"
			value="<?php echoValue($_SESSION['newRepositoryDetails']['country']); ?>">

		<br>

		<div class="inline label">Phone number:</div>

		<input type="text"
			name="phone"
			placeholder="Phone number"
			value="<?php echoValue($_SESSION['newRepositoryDetails']['phone']); ?>">

		<br>

		<div class="inline label">Website:</div>

		<input type="text"
			name="website"
			placeholder="Website"
			value="<?php echo (!empty($_SESSION['newRepositoryDetails']['website'])) ? $_SESSION['newRepositoryDetails']['website'] : 'http://'; ?>">

		<p style="margin: 10px 0 15 0; font-size: 0.9em;">Images available on the museum's website?</p>

		<input type="radio"
			name="images"
			style="margin-left: 20px;"
			value="Yes">Yes&nbsp;

		<input type="radio"
			name="images"
			value="No"
			checked="checked">No

		<br>

		<button type="button" 
			id="createRepository_submit_button">Submit</button>

	</form>

</div>
<script>

	closeModule_button($('div#createRepository_module'));

	
	// SUBMIT NEW REPOSITORY

	$('button#createRepository_submit_button')
		.click(promptToConfirm)
		.click(
			function(event)
			{
				$('button#conf_button').click(
					function()
					{
						$('button#conf_button').remove();
						createRepository_submit();
					});
			});


	// Preserve "http://" in website field

	$('input[name=website]').blur(function()
	{
		var value = $(this).val();
		if (value == '' || value == 'Website')
		{
			$(this).val('http://').css({ color: '#000' });
		}
	}).keydown(function(event)
	{
		var value = $(this).val();
		if (((event.which && event.which == 8) || (event.keyCode && event.keyCode == 8))
			&& value == 'http://')
		{
			event.preventDefault();
		}
	});

</script>

