<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/functions.php');


$sql = "SELECT agent_text 
			FROM $DB_NAME.agent 
			WHERE related_images = '{$imageId}' ";

$result_c = db_query($mysqli, $sql);

if ($result_c->num_rows > 0)
// Image record has been catalogued and some 
// kind of agent entry exists (blank or not)
{
	while ($row_agent = $result_c->fetch_assoc()) {
		$agent_text = $row_agent['agent_text'];
	}

	$imageAgent = ($agent_text != '')
		? $agent_text
		: 'none';
}
else
// Image record has not been catalogued yet, 
// so has no agent entry at all
{
	$imageAgent = 'none';
}


//----------------------------------------------------------------
//  Retrieve the work ID associated with this row's image record
//----------------------------------------------------------------

$trimmed_imageId = ltrim($imageId, '0');

$sql = "SELECT related_works 
			FROM $DB_NAME.image 
			WHERE id = '{$trimmed_imageId}' 
			LIMIT 1 ";

$result_work = db_query($mysqli, $sql);

if ($result_work->num_rows > 0) {
// If an associated work exists

	// Define associated work ID
	while ($row_workId = $result_work->fetch_assoc()) {
		$assoc_work = $row_workId['related_works'];
	}

} else {
// No work is associated with this row's image record

	$assoc_work = 'Work not found';
	
}

if ($assoc_work != 'Work not found') {
// If an associated work was found

	//------------------------------------------------------------
	//  Retrieve the agent information associated with this work
	//------------------------------------------------------------

	$assoc_work = create_six_digits($assoc_work);

	$sql = "SELECT * 
				FROM $DB_NAME.agent 
				WHERE related_works = '{$assoc_work}' ";

	$result_agent = db_query($mysqli, $sql);
	
	// Initialize array to store short display versions of agents' names
	// Only the first will be used
	$agent_display_array = array();
	
	while ($agent = $result_agent->fetch_assoc()) { 
	// For each agent associated with this row's image record
	
		$agent_attr = $agent['agent_attribution'];
		$agent_text = $agent['agent_text'];
		$agent_type = $agent['agent_type'];
		$agent_role = $agent['agent_role'];
		
		$agent_display_temp = '';
		$agent_display_temp .= ($agent_attr != 'None') ? $agent_attr . ' ' : '';
		$agent_display_temp .= (!empty($agent_text)) ? $agent_text : '';
		$agent_display_array[] = $agent_display_temp;
	
	}
	$agent_display_short = '';
	
	if (!empty($agent_display_array)) {

		// Define display value for this agent
		$agent_display_short = (strlen($agent_display_array[0]) >= 40)
			? substr($agent_display_array[0], 0, 40) . '...'
			: $agent_display_array[0];

	}

}
else
{
	// Define display value for this agent
	$agent_display_short = '';
	
}

echo ($imageAgent == 'none') 
	? $agent_display_short 
	: $imageAgent;

$agent_display_short = '';
