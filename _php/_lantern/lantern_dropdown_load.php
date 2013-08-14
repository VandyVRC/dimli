<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();

// print_r($_POST); // Debug

$workNum = $_POST['workNum'];
$imageNum = $_POST['imageNum'];


// Should script search for a Work or Image record?
$recordType = ($workNum == 'None') ? 'image' : 'work';

// Define a list of searches to perform
$searches_arr = array(
	'title' => array(
		'table' => 'title',
		'fields' => array(
			'title_type',
			'title_text'
			)
		),
	'agent' => array(
		'table' => 'agent',
		'fields' => array(
			'agent_attribution',
			'agent_text',
			'agent_role'
			)
		),
	'date' => array(
		'table' => 'date',
		'fields' => array(
			'date_type',
			'date_range',
			'date_circa',
			'date_text',
			'date_era',
			'enddate_text',
			'enddate_era'
			)
		),
	'material' => array(
		'table' => 'material',
		'fields' => array(
			'material_type',
			'material_text'
			)
		),
	'technique' => array(
		'table' => 'technique',
		'fields' => array(
			'technique_text'
			)
		),
	'work_type' => array(
		'table' => 'work_type',
		'fields' => array(
			'work_type_text'
			)
		),
	'cultural_context' => array(
		'table' => 'culture',
		'fields' => array(
			'culture_text'
			)
		),
	'style_period' => array(
		'table' => 'style_period',
		'fields' => array(
			'style_period_text'
			)
		),
	'location' => array(
		'table' => 'location',
		'fields' => array(
			'location_text',
			'location_name_type',
			'location_type'
			)
		),
	'subject' => array(
		'table' => 'subject',
		'fields' => array(
			'subject_type',
			'subject_text'
			)
		),
	'inscription' => array(
		'table' => 'inscription',
		'fields' => array(
			'inscription_text',
			'inscription_author',
			'inscription_location'
			)
		),
	'rights' => array(
		'table' => 'rights',
		'fields' => array(
			'rights_type',
			'rights_holder',
			'rights_text'
			)
		),
	'source' => array(
		'table' => 'source',
		'fields' => array(
			'source_name_type',
			'source_name_text',
			'source_type',
			'source_text'
			)
		)
	);

// Initialize array to store record information
$recordInfo = array();

foreach ($searches_arr as $search)
// Perform a search for each data type to be displayed
{
	foreach ($search['fields'] as $field)
	// Perform search on each field within this search type
	{
		$recordNum = ${$recordType.'Num'};

		$sql = "SELECT * 
					FROM dimli.".$search['table']." 
					WHERE related_".$recordType."s = {$recordNum} ";

		$result = db_query($mysqli, $sql);

		$i = 0;
		while ($row = $result->fetch_assoc())
		{
			$recordInfo[$field][$i] = $row[$field];
			$i++;
		}
	}
}
?>
<div class="grid_dropdown_imgWrapper">

	<img src="http://dimli.library.vanderbilt.edu/_plugins/timthumb/timthumb.php?src=mdidimages/HoAC/medium/<?php echo $imageNum; ?>.jpg&amp;h=300&amp;q=80">

</div>

<div class="grid_dropdown_infoWrapper">

	<!-- 
		TITLE
	 -->

	<div class="grid_dropdown_title">

		<?php 
		echo $recordInfo['title_text']['0']; 
		?>

	</div>

	<!-- 
		AGENT
	 -->

	<div class="grid_dropdown_agent">

		<?php 
		echo (!in_array($recordInfo['agent_attribution']['0'], array('None','')))
			? $recordInfo['agent_attribution']['0'].' '
			: '';
		echo $recordInfo['agent_text']['0']; 
		?>

	</div>

	<!-- 
		DATE
	 -->

	<div class="grid_dropdown_date">

		<?php 
		echo $recordInfo['date_text']['0'];
		echo (
			($recordInfo['date_range']['0'] == '1' &&
			$recordInfo['date_era']['0'] != $recordInfo['enddate_era']['0']) ||
			$recordInfo['date_range']['0'] != '1'
			)
			? ' '.$recordInfo['date_era']['0']
			: '';
		echo ($recordInfo['date_range']['0'] == '1')
			? ' - '.$recordInfo['enddate_text']['0'].' '.$recordInfo['enddate_era']['0']
			: '';
		?>

	</div>

	<!-- 
		CULTURAL CONTEXT
	 -->

	<div class="grid_dropdown_culture">

		<?php
		$i = 0;
		foreach ($recordInfo['culture_text'] as $culture)
		{
			echo ($i != 0)?'; ':'';
			echo $culture;
			$i++;
		}
		?>

	</div>

	<!-- 
		MATERIAL
	 -->

	<div class="grid_dropdown_material">

		<?php
		$i = 0;
		foreach ($recordInfo['material_text'] as $material)
		{
			echo ($i != 0)?'; ':'';
			echo $material;
			// echo ' ('.$recordInfo['material_type'][$i].')';
			$i++;
		}
		?>

	</div>

	<!-- 
		LOCATION
	 -->

	<div class="grid_dropdown_location">

		<?php
		$i = 0;
		foreach ($recordInfo['location_text'] as $location)
		{
			echo $recordInfo['location_type'][$i].': ';
			echo $location.'<br>';
			$i++;
		}
		?>

	</div>

	<div><pre><?php //print_r($recordInfo);?></pre></div>

</div>

<p class="clear"></p>

<script>

	$('div.grid_dropdown_imgWrapper img').click(
		function()
		{
			image_viewer('<?php echo $imageNum;?>');
		});

</script>

