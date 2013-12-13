<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__').$urlpatch);}

require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');

confirm_logged_in();


// If control panel is being reloaded because user toggled
// between display modes, assign the new preferred display
// mode to the session.

if (isset($_POST['pref_lantern_view'])) {
	$_SESSION['pref_lantern_view'] = $_POST['pref_lantern_view'];
}


// If lantern filters have not been set or modified 
// yet this session, set their defaults

$_SESSION['lantern_filters'] = (!isset($_SESSION['lantern_filters']))
	? array(
		'lantern_show_works'=>true,
		'lantern_show_images'=>true,
		'lantern_filter_title'=>true,
		'lantern_filter_agent'=>true,
		'lantern_filter_date'=>true,
		'lantern_filter_material'=>true,
		'lantern_filter_technique'=>true,
		'lantern_filter_workType'=>true,
		'lantern_filter_culture'=>true,
		'lantern_filter_stylePeriod'=>true,
		'lantern_filter_location'=>true,
		'lantern_filter_subject'=>true,
		'lantern_filter_description'=>true,
		'lantern_filter_inscription'=>true,
		'lantern_filter_source'=>false,
		'lantern_filter_rights'=>false,
		'lantern_filter_idNumber'=>false
		)
	: $_SESSION['lantern_filters']; ?>

<div id="lantern_controls" class="faded">

	<div style="position: absolute; top: 0; left: 0; width: 90%; height: 100%; z-index: 10; background-color: #000; opacity: 0.8; color: #FFF; text-align: center; line-height: 80px; font-size: 1.5em;">

		<span style="vertical-align: middle;"
			>Search filters are incomplete</span>

	</div>

	<div id="lantern_controls_show">

		<input type="checkbox" 
			id="lantern_show_works" 
			name="lantern_show_works"
			<?php echo($_SESSION['lantern_filters']['lantern_show_works']==true)
					? 'checked'
					: ''; ?>>

		<label for="lantern_show_works">

			<span>Work records</span>

		</label><br>

		<input type="checkbox" 
			id="lantern_show_images" 
			name="lantern_show_images"
			<?php echo($_SESSION['lantern_filters']['lantern_show_images']==true)
					? 'checked'
					: ''; ?>>

		<label for="lantern_show_images">

			<span>Image records</span>

		</label>

	</div>

	<div id="lantern_controls_filter">

		<div class="inline">

			<input type="checkbox" 
				id="lantern_filter_title" 
				name="lantern_filter_title"
				<?php echo($_SESSION['lantern_filters']['lantern_filter_title']==true)
						? 'checked'
						: ''; ?>>

			<label for="lantern_filter_title">

				<span>Title</span>

			</label><br>

			<input type="checkbox" 
				id="lantern_filter_agent" 
				name="lantern_filter_agent"
				<?php echo($_SESSION['lantern_filters']['lantern_filter_agent']==true)
						? 'checked'
						: ''; ?>>

			<label for="lantern_filter_agent">

				<span>Agent</span>

			</label><br>

			<input type="checkbox" id="lantern_filter_date" name="lantern_filter_date"
			<?php echo($_SESSION['lantern_filters']['lantern_filter_date']==true)?'checked':'';?>>
			<label for="lantern_filter_date">
				<span>Date</span>
			</label>

		</div>

		<div class="inline">

			<input type="checkbox" 
				id="lantern_filter_material" 
				name="lantern_filter_material"
				<?php echo($_SESSION['lantern_filters']['lantern_filter_material']==true)
						? 'checked'
						: ''; ?>>

			<label for="lantern_filter_material">

				<span>Material</span>

			</label><br>

			<input type="checkbox" 
				id="lantern_filter_technique" 
				name="lantern_filter_technique"
				<?php echo($_SESSION['lantern_filters']['lantern_filter_technique']==true)
						? 'checked'
						: ''; ?>>

			<label for="lantern_filter_technique">

				<span>Technique</span>

			</label><br>

			<input type="checkbox" 
				id="lantern_filter_workType" 
				name="lantern_filter_workType"
				<?php echo($_SESSION['lantern_filters']['lantern_filter_workType']==true)
						? 'checked'
						: ''; ?>>

			<label for="lantern_filter_workType">

				<span>Work type</span>

			</label>

		</div>

		<div class="inline">

			<input type="checkbox" 
				id="lantern_filter_culture" 
				name="lantern_filter_culture"
				<?php echo($_SESSION['lantern_filters']['lantern_filter_culture']==true)
						? 'checked'
						: ''; ?>>

			<label for="lantern_filter_culture">

				<span>Cultural context</span>

			</label><br>

			<input type="checkbox" 
				id="lantern_filter_stylePeriod" 
				name="lantern_filter_stylePeriod"
				<?php echo($_SESSION['lantern_filters']['lantern_filter_stylePeriod']==true)
						? 'checked'
						: ''; ?>>

			<label for="lantern_filter_stylePeriod">

				<span>Style period</span>

			</label><br>

			<input type="checkbox" 
				id="lantern_filter_location" 
				name="lantern_filter_location"
				<?php echo($_SESSION['lantern_filters']['lantern_filter_location']==true)
						? 'checked'
						: ''; ?>>

			<label for="lantern_filter_location">

				<span>Location</span>

			</label>

		</div>

		<div class="inline">

			<input type="checkbox" 
				id="lantern_filter_subject" 
				name="lantern_filter_subject"
				<?php echo($_SESSION['lantern_filters']['lantern_filter_subject']==true)
						? 'checked'
						: ''; ?>>

			<label for="lantern_filter_subject">

				<span>Subject</span>

			</label><br>

			<input type="checkbox" 
				id="lantern_filter_description" 
				name="lantern_filter_description"
				<?php echo($_SESSION['lantern_filters']['lantern_filter_description']==true)
						? 'checked'
						: ''; ?>>

			<label for="lantern_filter_description">

				<span>Description</span>

			</label><br>

			<input type="checkbox" 
				id="lantern_filter_inscription" 
				name="lantern_filter_inscription"
				<?php echo($_SESSION['lantern_filters']['lantern_filter_inscription']==true)
						? 'checked'
						: ''; ?>>

			<label for="lantern_filter_inscription">

				<span>Inscription</span>

			</label>

		</div>

		<div class="inline">

			<input type="checkbox" 
				id="lantern_filter_source" 
				name="lantern_filter_source"
				<?php echo($_SESSION['lantern_filters']['lantern_filter_source']==true)
						? 'checked'
						: ''; ?>>

			<label for="lantern_filter_source">

				<span>Source</span>

			</label><br>

			<input type="checkbox" 
				id="lantern_filter_rights" 
				name="lantern_filter_rights"
				<?php echo($_SESSION['lantern_filters']['lantern_filter_rights']==true)
						? 'checked'
						: ''; ?>>

			<label for="lantern_filter_rights">

				<span>Rights</span>

			</label><br>

			<input type="checkbox" 
				id="lantern_filter_idNumber" 
				name="lantern_filter_idNumber"
				<?php echo($_SESSION['lantern_filters']['lantern_filter_idNumber']==true)
						? 'checked'
						: ''; ?>>

			<label for="lantern_filter_idNumber">

				<span>ID number</span>

			</label>

		</div>

		<div class="inline" style="vertical-align: top;">

			<button type="button" id="reset_filters">Reset</button>

			<br>

			<button type="button" id="apply_filters">Apply</button>

		</div>

	</div>

	<!-- 
			List & Grid toggles
	 -->

	<div id="lantern_controls_view" class="inline">

		<span id="lantern_list_toggle"
			class="<?php echo ($_SESSION['pref_lantern_view']=='list')
				? 'opaque defaultCursor mediumWeight'
				: 'fadedMore pointer'; ?>"
			>List</span>

		<span id="lantern_grid_toggle"
			class="<?php echo ($_SESSION['pref_lantern_view']=='grid')
				? 'opaque defaultCursor mediumWeight'
				: 'fadedMore pointer'; ?>"
			style="margin-left: 5px;"
			>Grid</span>

	</div>

	<p class="clear"></p>

	<script>

		//  Toggle List view
		
		$('span#lantern_list_toggle').click(
			function()
			{
				if ($(this).hasClass('fadedMore'))
				{
					lantern_list_view();
				}
			});


		//  Toggle Grid view
		
		$('span#lantern_grid_toggle').click(
			function()
			{
				if ($(this).hasClass('fadedMore'))
				{
					lantern_grid_view();
				}
			});

		
		//  Reset filters
		
		$('#reset_filters').click(
			function()
			{
				$('div#lantern_controls input[type=checkbox]')
					.prop('checked', true);
			});
		
	</script>

</div>

