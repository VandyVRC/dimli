<?php

function check_required_fields($required_array) {
  $post_array = (isset($_POST['json'])) 
    ? $_POST['json'] 
    : $_POST;

  $field_errors = array();

  foreach($required_array as $fieldname) {

    if ((!isset($post_array[$fieldname]))
      || (empty($post_array[$fieldname])
        && !is_int($post_array[$fieldname])) 
      || (is_int($post_array[$fieldname])
        && ($post_array[$fieldname]) < 1 )) {

        $field_errors[] = $fieldname;
    }
  }
  return $field_errors;
}

function check_max_field_lengths($field_length_array) {
  $aPost = (isset($_POST['json']))
    ? $_POST['json'] 
    : $_POST;

  $field_errors = array();

  foreach($field_length_array as $fieldname => $maxlength) {

    if ((isset($aPost[$fieldname])) 
      && (strlen(trim($aPost[$fieldname])) > $maxlength)) {

      $field_errors[] = $fieldname;
    }
  }
  return $field_errors;
}

// TODO Remove the last vestiges of this function
// Performs query and returns result set, or reports error.
// Use only when it is not necessary to define the $connection parameter for mysql queries
function isnerQ($query) {
  $result = mysql_query($query);
  if ($result) {
    return $result;
  } else {
    $message = '<strong>Database query failed:</strong> '.mysql_error().'<br><br>';
    $message .= '<strong>Query: </strong>'.$query.'<br><br>';
    die($message);
  }
}

// Performs a database query using PHP's MYSQLI class
// Returns a result object if successful
// Else dies and displays the SQL error and the query string that failed
function db_query($mysqli, $sql) {

  $result = $mysqli->query($sql);
  if (!$result) {
    $message = 'SQL error: '.$mysqli->errno.' '.$mysqli->error.'<br>';
    $message.= 'Failed query: ' . $sql;
    die($message);
  } else {
    return $result;
  }
}

function create_four_digits($int) {
  $int_length = strlen((string)$int);
  if ($int_length == 1) {
    $int = "000" . $int;
  } elseif ($int_length == 2) {
    $int = "00" . $int;
  } elseif ($int_length == 3) {
    $int = "0" . $int;
  } elseif ($int_length == 4) {
    $int = $int;
  }
  return $int;
}

function create_six_digits($int) {
  $int_length = strlen((string)$int);
  if ($int_length == 1) {
    $int = "00000" . $int;
  } elseif ($int_length == 2) {
    $int = "0000" . $int;
  } elseif ($int_length == 3) {
    $int = "000" . $int;
  } elseif ($int_length == 4) {
    $int = "00" . $int;
  } elseif ($int_length == 5) {
    $int = "0" . $int;
  } elseif ($int_length == 6) {
    $int = $int;
  }
  return $int;
}

// Require specific privilege to access page
function require_priv($req_priv) {

  if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}

  if (logged_in() && $_SESSION[$req_priv] != '1') {
    exit();

  } elseif (logged_in() && $_SESSION[$req_priv] == '1') {
    return true;

  } elseif (!logged_in()) {
    header('Location: '.MAIN_DIR.'/login.php');
    exit();
  }
}

// String starts with
function startsWith($haystack, $needle) {

  $length = strlen($needle);
  return !strncmp($haystack, $needle, strlen($needle));
}

// return true if $str ends with $sub
function endsWith($str, $sub) {
  return (substr($str, strlen($str) - strlen($sub)) == $sub);
}

// Is set and equals
function setEqual($var, $value) {

  if (isset($var)) {
    if ($var == $value) {
      return TRUE;
    } else {
      return FALSE;
    }
  } else {
    return FALSE;
  }
}

// Echo if variable is set
function echoValue($var) {

  if (isset($var) && !empty($var)) {
    echo htmlentities(stripslashes($var));
  }
}

//----------------------------------------------------
// If a variable is SET and equals a specific value,
// Then echo: selected="selected"
// For PHP-driven default selections in lists
//----------------------------------------------------
function selectedOption($var, $value) {

  if (isset($var) && $var == $value) {
    echo 'selected="selected"';
  } else {
    echo '';
  }
}

//--------------------------------------------------------
// Print Getty hierarchy with line indents, for tooltip
// $hierarchy [string]: The data from the hierarchy cell 
// of a parsed getty table.
// $tooltip [true/false]: TRUE if printing in a tooltip, 
// or FALSE if printing in html.
//--------------------------------------------------------
function printHierarchy($hierarchy, $tooltip) {
  $hierarchy = explode(' | ', $hierarchy);
  $hierarchy = array_reverse($hierarchy);
  $i = 0;
  $indent = '&nbsp;';
  foreach ($hierarchy as $string):
    if ($string != 'World') {
      echo str_repeat($indent, $i);
      echo (isset($tooltip) && $tooltip == true)
        ? htmlspecialchars($string) . '&#10;'
        : htmlspecialchars($string) . '<br>';
      $i++;
    }
  endforeach;
}

//----------------------------------------------------------------------
// Store the last digit of each string and find the largest
// Then calculate the number of cataloguing rows assigned to that type
//----------------------------------------------------------------------
function countCatRows($array) {

  $countTracker = array();

  foreach ($array as $key => $value) {
    $countTracker[] = $key[strlen($key)-1];
  }
  $numRows = max($countTracker) + 1;
  
  return $numRows;
}

function fieldEmpty() {

  echo '<span style="color: #ce7100">';
  echo '<i><strong>>Field empty or incomplete<</strong></i>';
  echo '</span>';
}

function fieldEmptyGentle() {

  echo '<span style="color: #ce7100">';
  echo '<i>None</i>';
  echo '</span>';
}

//-------------------------------------------
// Used with array_filter stock function to 
// omit useless search terms from an array
//-------------------------------------------
function filterNonSearchTerms($var) {

  if (
    empty($var)
    || strlen($var) <= 2
    || strtolower($var) == 'the'
    || strtolower($var) == 'and'
    || strtolower($var) == 'for'
    || strtolower($var) == 'with'
    || strtolower($var) == 'but'
  ) {
    return FALSE;
  } else {
    return TRUE;
  }
}

function notEmpty($var) {

  if (!empty($var) && trim($var) != '') {
    return TRUE;
  } else {
    return FALSE;
  }
}

//-----------------------------------------------------
//  CSV export function, from Ninsuo on Stack Overflow
//-----------------------------------------------------
function array2csv(&$array) {
   ob_start();
   $df = fopen("php://output", 'w');
   fputcsv($df, array_keys($array[0]));
   foreach ($array as $row) {
    fputcsv($df, $row);
   }
   fclose($df);
   return ob_get_clean();
}

//---------------------------------
//  Returns duplicate array values
//---------------------------------
function array_not_unique($raw_array) {
  $dupes = array();
  natcasesort($raw_array);
  reset ($raw_array);

   $old_key    = NULL;
   $old_value    = NULL;
  foreach ($raw_array as $key => $value) {
    if ($value === NULL) { continue; }
    if (strcasecmp($old_value, $value) === 0) {
      $dupes[$old_key]    = $old_value;
      $dupes[$key]        = $value;
    }
    $old_value    = $value;
    $old_key    = $key;
  }
  return $dupes;
}

function showGlobals($privilegedUser)
{
  if (isset($_SESSION['username']) 
    && $_SESSION['username'] == $privilegedUser
    && $_SERVER['SERVER_NAME'] == 'localhost'
  ) {
    echo '<pre>';
    print_r($GLOBALS);
    echo '</pre>';
  }
}

function setBlankIfNotSet($var)
{
  if (!isset($var) || empty($var))
  // Variable is either unset or empty
  {
    $var = '';
    // Set variable to blank
  }
  else
  // Variable has some content
  {
    $var = $var;
    // Leave variable unchanged
  }
}

function time_since($then)
{
  $secs = time() - strtotime($then);
  if ($secs == 1) 
  { 
    $int = 1;
    $unit = 'second';
  }
  elseif ($secs < 60) 
  { 
    $int = $secs;
    $unit = 'seconds';
  }
  elseif ($secs >= 60 && $secs < 120) 
  { 
    $int = 1;
    $unit = 'minute';
  }
  elseif ($secs >= 120 && $secs < 3600) 
  { 
    $int = $secs / 60;
    $unit = 'minutes';
  }
  elseif ($secs >= 3600 && $secs < 7200) 
  { 
    $int = 1;
    $unit = 'hour';
  }
  elseif ($secs >= 7200 && $secs < 86400) 
  { 
    $int = $secs / 60 / 60;
    $unit = 'hours';
  }
  elseif ($secs >= 86400 && $secs < 172800) 
  { 
    $int = 1;
    $unit = 'day';
  }
  elseif ($secs >= 172800) 
  { 
    $int = $secs / 60 / 60 / 24;
    $unit = 'days';
  }
  return round($int) . ' ' . $unit;
}

function human_timestamp($ts)
{
  $now = new DateTime(date('Y-m-d H:i:s'));
  $then = new DateTime($ts);
  $interval = $now->diff($then);
  if ($interval->format('%a') < 1) {
    return date('\T\o\d\a\y, g:i a', strtotime($ts));
  } elseif($interval->format('%a') < 7) {
    return date('l, g:i a', strtotime($ts));
  } else {
    return date('M j, g:i a', strtotime($ts));
  }
}

function printAltNames($altNames_array)
{
  $display = '';
  foreach ($altNames_array as $name)
  {
    if (!empty($name) && $name != ',' && $name != ', ')
    {
      $display .= $name.'&#10;';
    }
  }
  if (empty($display))
  {
    $display = '- None -';
  }
  echo $display;
}

function list_privileges()
{
  $privs = array(
    'priv_digitize'=>'digitize',
    'priv_edit'=>'retouch',
    'priv_exportImages'=>'archive image files',
    'priv_deliver'=>'deliver orders to patron',
    'priv_catalog'=>'catalog',
    'priv_approve'=>'approve cataloging',
    'priv_users_read'=>'view users',
    'priv_users_create'=>'create users',
    'priv_users_delete'=>'delete users',
    'priv_orders_read'=>'view orders',
    'priv_orders_create'=>'submit orders',
    'priv_orders_confirmCreation'=>'confirm order creation',
    'priv_orders_download'=>'download orders',
    'priv_orders_delete'=>'delete orders',
    'priv_csv_import'=>'import csv data',
    'priv_csv_export'=>'export csv data',
    'priv_image_ids_edit' => 'edit image ids',
    'priv_images_delete'=>'delete images',
    'priv_images_flag4Export'=>'flag images for export'
    );
  $list = '';
  foreach ($privs as $priv=>$text)
  {
    if ($_SESSION[$priv]=='1')
    {
      $list .= ($list != '')
        ? ', '.$text
        : $text;
    }
  }
  echo $list;
}

function url_exists($url)
{
  $a_url = parse_url($url);
  if (!isset($a_url['port'])) $a_url['port'] = 80;
  $errno = 0;
  $errstr = '';
  $timeout = 30;
  if(isset($a_url['host']) && $a_url['host']!=gethostbyname($a_url['host'])){
  $fid = fsockopen($a_url['host'], $a_url['port'], $errno, $errstr, $timeout);
  if (!$fid) return false;
  $page = isset($a_url['path']) ?$a_url['path']:'';
  $page .= isset($a_url['query'])?'?'.$a_url['query']:'';
  fputs($fid, 'HEAD '.$page.' HTTP/1.0'."\r\n".'Host: '.$a_url['host']."\r\n\r\n");
  $head = fread($fid, 4096);
  fclose($fid);
  return preg_match('#^HTTP/.*\s+[200|302]+\s#i', $head);
  }
  else
  {
    return false;
  }
}

function checkRemoteFile($url)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  // don't download content
  curl_setopt($ch, CURLOPT_NOBODY, 1);
  curl_setopt($ch, CURLOPT_FAILONERROR, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  if(curl_exec($ch)!==FALSE)
  {
    return true;
  }
  else
  {
    return false;
  }
}

function lantern_list_display_date($mysqli, $recordType, $recordNum, $parent, DB_NAME)
{

  $arr = array();

  $sql = "SELECT * 
        FROM $DB_NAME.date 
        WHERE related_".$recordType."s = '{$recordNum}' ";

  $res = db_query($mysqli, $sql);
  
  if ($res->num_rows > 0)
  {
    while ($row = $res->fetch_assoc())
    {
      $str = '';

      $str .= ($row['date_circa'] == 1) 
        ? 'ca. ' 
        : '';

      $str .= (!empty($row['date_text'])) 
        ? $row['date_text'] 
        : '';

      $str .= ($row['date_range'] == 1 && $row['date_era'] != $row['enddate_era'])
          ? ' ' . $row['date_era']
          : '';

      $str .= ($row['date_range'] == 1) 
        ? ' - ' 
        : ' ' . $row['date_era'];

      $str .= ($row['date_range'] == 1 && !empty($row['enddate_text'])) 
        ? $row['enddate_text'] . ' ' . $row['enddate_era'] 
        : '';

      $str .= ($row['date_type'] != '' && !empty($row['date_type'])) 
        ? ' (' . $row['date_type'] . ')' 
        : '';

      if (trim($str) == '--' || trim($str) == 'CE' || trim($str) == 'BCE' || empty($str))
      { 
        $str = '';
      }

      $arr[] = $str;
    }
  }
  else
  {
    $arr[] = '';
  }
    
  if ($arr[0] != '' && !empty($arr[0]))
  {
    echo trim(implode(', ', $arr), ', ');
  }
  elseif (
    ($arr[0] == '' || empty($arr[0])) && 
    $recordType == 'image' &&
    $parent != 'none'
    )
  {
    $arr = array();

    $sql = "SELECT * 
          FROM $DB_NAME.date 
          WHERE related_works = '{$parent}' ";

    $res = db_query($mysqli, $sql);

    while ($row = $res->fetch_assoc())
    {
      $str = '';

      $str .= ($row['date_circa'] == 1) 
        ? 'ca. ' 
        : '';

      $str .= (!empty($row['date_text'])) 
        ? $row['date_text'] 
        : '';

      $str .= ($row['date_range'] == 1 && $row['date_era'] != $row['enddate_era'])
          ? ' ' . $row['date_era']
          : '';

      $str .= ($row['date_range'] == 1) 
        ? ' - ' 
        : ' ' . $row['date_era'];

      $str .= ($row['date_range'] == 1 && !empty($row['enddate_text'])) 
        ? $row['enddate_text'] . ' ' . $row['enddate_era'] 
        : '';

      $str .= ($row['date_type'] != '' && !empty($row['date_type'])) 
        ? ' (' . $row['date_type'] . ')' 
        : '';

      if (trim($str) == '--' || trim($str) == 'CE' || trim($str) == 'BCE' || empty($str))
      { 
        $str = '';
      }

      $arr[] = $str;
    }
    echo trim(implode(', ', $arr), ', ');
  }
  elseif (
    ($arr[0] == '' || empty($arr[0])) && 
    $recordType == 'image' &&
    $parent == 'none'
    )
  {
    echo 'none available';
  }
}

function lantern_list_display_material($mysqli, $recordType, $recordNum, DB_NAME)
{
  $arr = array();

  $sql = "SELECT * 
        FROM $DB_NAME.material 
        WHERE related_".$recordType."s = '{$recordNum}' ";

  $res = db_query($mysqli, $sql);

  while ($row = $res->fetch_assoc())
  {
    $str = '';
    $str .= (!empty($row['material_text'])) ? $row['material_text'] : '';
    $str .= (!empty($row['material_type'])) ? ' (' . $row['material_type'] . ')' : '';

    $arr[] = $str;
  }
  echo trim(implode(', ', $arr), ', ');
}

function lantern_list_display_technique($mysqli, $recordType, $recordNum, DB_NAME)
{
  $arr = array();

  $sql = "SELECT * 
        FROM $DB_NAME.technique 
        WHERE related_".$recordType."s = '{$recordNum}' ";

  $res = db_query($mysqli, $sql);
  
  while ($row = $res->fetch_assoc())
  {
    $str = '';
    $str .= (!empty($row['technique_text'])) ? $row['technique_text'] : '';
    
    $arr[] = $str;
  }
  echo trim(implode(', ', $arr), ', ');
}

function lantern_list_display_work_type($mysqli, $recordType, $recordNum, DB_NAME)
{
  $arr = array();

  $sql = "SELECT * 
        FROM $DB_NAME.work_type 
        WHERE related_".$recordType."s = '{$recordNum}' ";

  $res = db_query($mysqli, $sql);
  
  while ($row = $res->fetch_assoc())
  {
    $str = '';
    $str .= (!empty($row['work_type_text'])) ? $row['work_type_text'] : '';
    
    $arr[] = $str;
  }
  echo trim(implode(', ', $arr), ', ');
}

function lantern_list_display_cultural_context($mysqli, $recordType, $recordNum, DB_NAME)
{
  $arr = array();

  $sql = "SELECT * 
        FROM $DB_NAME.culture 
        WHERE related_".$recordType."s = '{$recordNum}' ";

  $res = db_query($mysqli, $sql);
  
  while ($row = $res->fetch_assoc())
  {
    $str = '';
    $str .= (!empty($row['culture_text'])) ? $row['culture_text'] : '';
    
    $arr[] = $str;
  }
  echo trim(implode(', ', $arr), ', ');
}

function lantern_list_display_style_period($mysqli, $recordType, $recordNum, DB_NAME)
{
  $arr = array();

  $sql = "SELECT * 
        FROM $DB_NAME.style_period 
        WHERE related_".$recordType."s = '{$recordNum}' ";

  $res = db_query($mysqli, $sql);
  
  while ($row = $res->fetch_assoc())
  {
    $str = '';
    $str .= (!empty($row['style_period_text'])) ? $row['style_period_text'] : '';
    
    $arr[] = $str;
  }
  echo trim(implode(', ', $arr), ', ');
}

function lantern_list_display_location($mysqli, $recordType, $recordNum, DB_NAME)
{
  $arr = array();

  $sql = "SELECT * 
        FROM $DB_NAME.location 
        WHERE related_".$recordType."s = '{$recordNum}' ";

  $res = db_query($mysqli, $sql);
  
  while ($row = $res->fetch_assoc())
  {
    $str = '';
    $str .= (!empty($row['location_type'])) ? $row['location_type'] . ': ' : '';
    $str .= (!empty($row['location_text'])) ? $row['location_text'] : '';
    $str .= (!empty($row['location_name_type'])) ? ' (' . $row['location_name_type'] . ')' : '';
    
    $arr[] = $str;
  }
  echo trim(implode(', ', $arr), ', ');
}

function lantern_list_display_subject($mysqli, $recordType, $recordNum, DB_NAME)
{
  $arr = array();

  $sql = "SELECT * 
        FROM $DB_NAME.subject 
        WHERE related_".$recordType."s = '{$recordNum}' ";

  $res = db_query($mysqli, $sql);
  
  while ($row = $res->fetch_assoc())
  {
    $str = '';
    $str .= (!empty($row['subject_text'])) ? $row['subject_text'] : '';
    $str .= (!empty($row['subject_type'])) ? ' (' . $row['subject_type'] . ')' : '';
    
    $arr[] = $str;
  }
  echo trim(implode(', ', $arr), ', ');
}

function lantern_list_display_inscription($mysqli, $recordType, $recordNum, DB_NAME)
{

  $arr = array();

  $sql = "SELECT * 
        FROM $DB_NAME.inscription 
        WHERE related_".$recordType."s = '{$recordNum}' ";

  $res = db_query($mysqli, $sql);
  
  while ($row = $res->fetch_assoc())
  {
    $str = '';
    $str .= (!empty($row['inscription_type'])) ? $row['inscription_type'] . ': ' : '';
    $str .= (!empty($row['inscription_text'])) ? '"' . $row['inscription_text'] . '"' : '';
    $str .= (!empty($row['inscription_author'])) ? ' by ' . $row['inscription_author'] : '';
    $str .= (!empty($row['inscription_location'])) ? '; Location: ' . $row['inscription_location'] : '';
    
    $arr[] = $str;
  }
  echo trim(implode(', ', $arr), ', ');
}

function lantern_list_display_rights($mysqli, $recordType, $recordNum, DB_NAME)
{
  $arr = array();

  $sql = "SELECT * 
        FROM $DB_NAME.rights 
        WHERE related_".$recordType."s = '{$recordNum}' ";

  $res = db_query($mysqli, $sql);
  
  while ($row = $res->fetch_assoc())
  {
    $str = '';
    $str .= (!empty($row['rights_holder'])) ? $row['rights_holder'] . ' ' : '';
    $str .= (!empty($row['rights_type'])) ? '(' . $row['rights_type'] . ')' : '';
    $str .= (!empty($row['rights_text'])) ? ', ' . $row['rights_text'] : '';
    
    $arr[] = $str;
  }
  echo trim(implode(', ', $arr), ', ');
}

function lantern_list_display_source($mysqli, $recordType, $recordNum, DB_NAME)
{
  $arr = array();

  $sql = "SELECT * 
        FROM $DB_NAME.source 
        WHERE related_".$recordType."s = '{$recordNum}' ";

  $res = db_query($mysqli, $sql);
  
  while ($row = $res->fetch_assoc())
  {
    $str = '';
    $str .= (!empty($row['source_name_text'])) ? $row['source_name_text'] : '';
    $str .= (!empty($row['source_name_type'])) ? ' (' . $row['source_name_type'] . ')' : '';
    $str .= (!empty($row['source_type'])) ? ', ' . $row['source_type'] . ': ' : '';
    $str .= (!empty($row['source_text'])) ? $row['source_text'] : '';
    
    $arr[] = $str;
  }
  echo trim(implode(', ', $arr), ', ');
}

function lantern_list_display_titles($mysqli, $title_arr, $searches_arr, DB_NAME)
{

  ?><div class="highlightable" style="margin-bottom: 2px; padding-left: 15px; text-indent: -15px;"><?php

    // Display first listed title no matter what
    echo $title_arr[0];
    
  ?></div><?php

  // Display additional titles if they contain a search term
  $title_done = false;
  foreach ($searches_arr as $search)
  {
    if ($search == 'title' && !$title_done)
    {
      if (count($title_arr) < 2)
        continue; // Break if fewer than 2 Titles

      foreach ($title_arr as $title)
      {
        if ($title == $title_arr[0])
          continue; // Ignore the primary title (already displayed)

        foreach ($_SESSION['lantern_terms_arr'] as $term)
        {
          if (stristr($title, $term) && !$title_done)
          {
          ?><div class="highlightable" style="margin-bottom: 2px; padding-left: 15px; text-indent: -15px;"><?php
           
            echo $title;
            
          ?></div><?php
          break;
          }
        }
      }
      $title_done = true;
    }
  }
}

function lantern_list_display_agents($mysqli, $recordType, $recordNum, $searches_arr, $parent, DB_NAME)
{
	$agent_arr = array();

	$sql = "SELECT agent_text 
				FROM $DB_NAME.agent 
				WHERE related_".$recordType."s = '{$recordNum}' ";

	$res = db_query($mysqli, $sql);

	while ($row = $res->fetch_assoc())
	{
		$agent_arr[] = $row['agent_text'];
	}

	if ($recordType == 'work')
	{
		echo ($agent_arr[0] != '') ? $agent_arr[0].'<br>' : 'Unknown Agent';
	}
	elseif ($recordType == 'image')
	{
		if (!empty($agent_arr[0]))
		{
			echo $agent_arr[0].'<br>';
		}
		elseif  (empty($agent_arr[0]))
		{
			if ($parent != 'none')
			{
				$agent_arr = array();

				$sql = "SELECT agent_text 
							FROM $DB_NAME.agent 
							WHERE related_works = {$parent} ";

				$res2 = db_query($mysqli, $sql);

				while ($row = $res2->fetch_assoc())
				{
					$agent_arr[] = $row['agent_text'];
				}
				echo $agent_arr[0].'<br>';
			}
			else
			{
				echo 'unknown';
			}	
		}
	}

	// If Agent is one of the field types that returned a result
	if (in_array('agent', $searches_arr))
	{
		// Display additional agents if they contain a search term
		$agent_done = false;
		foreach ($searches_arr as $search)
		{
			if ($search == 'agent' && !$agent_done)
			{
				if (count($agent_arr) < 2)
					continue; // Break if fewer than 2 Agents

				foreach ($agent_arr as $agent)
				{
					if ($agent == $agent_arr[0])
						continue; // Ignore the primary agent (already displayed)

					foreach ($_SESSION['lantern_terms_arr'] as $term)
					{
						if (stristr($agent, $term) && !$agent_done)
						{
							echo $agent.'<br>';
						}
					}
				}
				$agent_done = true;
			}
		}
	}
}

function get_related_images($mysqli, $workNum, DB_NAME, $webroot, $image_src)
{
  $workNum = str_pad((string)$workNum,6,'0',STR_PAD_LEFT);
  $rel_images = array();

	$sql = "SELECT legacy_id 
				FROM $DB_NAME.image 
				WHERE related_works = '{$workNum}' ";

  $res = db_query($mysqli, $sql);

	while ($row = $res->fetch_assoc())
	{
		$rel_images[] = $row['legacy_id'];
	}

	foreach ($rel_images as $img) { 

    		  $src = $webroot."/_plugins/timthumb/timthumb.php?src=".$image_src."thumb/".$img.".jpg&amp;h=42&amp;w=42&amp;q=60";?>

        <img src="<?php echo $src; ?>"
            class="related_thumb"
            title="Click to preview"
            data-image="<?php echo $img; ?>">

	<?php
	}

}

function print_r_pre($array)
{
  echo '<pre>';
  print_r($array);
  echo '</pre>';
}
?>