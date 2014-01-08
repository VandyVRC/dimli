<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');

confirm_logged_in();

/*
If control panel is being reloaded because user toggled
between display modes, assign the new preferred display
mode to the session, and update the database
*/
if (isset($_POST['pref_lantern_view']))
{
	$_SESSION['pref_lantern_view'] = $_POST['pref_lantern_view'];
	$res = isnerQ("UPDATE $DB_NAME.user SET pref_lantern_view = '{$_SESSION['pref_lantern_view']}' WHERE id = '{$_SESSION['user_id']}'");
}

/*
	ASSIGN PAGE NUMBER
*/
$page = (isset($_POST['nextPage'])) 
	? $_POST['nextPage']
	: 1;

/*
	PREPARE SEARCH STRING
*/
$_SESSION['searchText'] = (isset($_POST['text']))
	? $_POST['text']
	: $_SESSION['searchText'];

$_SESSION['toggle'] = (isset($_POST['toggle']))
	? $_POST['toggle']
	: $_SESSION['toggle'];
// Variable to store user's raw search text

$seperators = array(' ', '"', '(', ')', '-', '&', '`', '%', ':', '+', '=', '/', '.', ',');
// Define list of characters that will be stripped from search string

$searchText = str_replace($seperators, ' ', trim($_SESSION['searchText']));
// Trim and strip special characters from search string

$searchText_arr = explode(' ', $searchText);
// Explode string into array

$_SESSION['lantern_terms_arr'] = $searchText_arr = array_filter($searchText_arr, 'filterNonSearchTerms');
// Apply filter to omit short and general search terms

/*
	PREPARE ARRAY OF SEARCHS TO PERFORM ON USER'S QUERY
*/
$searches_arr = array(
	'image_id' => array(
		'table' => 'image',
		'fields' => array(
			'id'
			),
		'relevance_val' => 1
		),
	'work_id' => array(
		'table' => 'work',
		'fields' => array(
			'id'
			),
		'relevance_val' => 1
		),
	'title' => array(
		'table' => 'title',
		'fields' => array(
			'title_text'
			),
		'relevance_val' => 7
		),
	'agent' => array(
		'table' => 'agent',
		'fields' => array(
			'agent_text'
			),
		'relevance_val' => 7
		),
	'date' => array(
		'table' => 'date',
		'fields' => array(
			'date_text',
			'enddate_text'
			),
		'relevance_val' => 4
		),
	'material' => array(
		'table' => 'material',
		'fields' => array(
			'material_text'
			),
		'relevance_val' => 3
		),
	'technique' => array(
		'table' => 'technique',
		'fields' => array(
			'technique_text'
			),
		'relevance_val' => 3
		),
	'work_type' => array(
		'table' => 'work_type',
		'fields' => array(
			'work_type_text'
			),
		'relevance_val' => 3
		),
	'cultural_context' => array(
		'table' => 'culture',
		'fields' => array(
			'culture_text'
			),
		'relevance_val' => 3
		),
	'style_period' => array(
		'table' => 'style_period',
		'fields' => array(
			'style_period_text'
			),
		'relevance_val' => 3
		),
	'location' => array(
		'table' => 'location',
		'fields' => array(
			'location_text'
			),
		'relevance_val' => 3
		),
	'subject' => array(
		'table' => 'subject',
		'fields' => array(
			'subject_text'
			),
		'relevance_val' => 2
		),
	'image_description' => array(
		'table' => 'image',
		'fields' => array(
			'description'
			),
		'relevance_val' => 2
		),
	'work_description' => array(
		'table' => 'work',
		'fields' => array(
			'description'
			),
		'relevance_val' => 2
		),
	'inscription' => array(
		'table' => 'inscription',
		'fields' => array(
			'inscription_text',
			'inscription_author',
			'inscription_location'
			),
		'relevance_val' => 4
		),
	'rights' => array(
		'table' => 'rights',
		'fields' => array(
			'rights_holder',
			'rights_text'
			),
		'relevance_val' => 1
		),
	'source' => array(
		'table' => 'source',
		'fields' => array(
			'source_name_text',
			'source_text'
			),
		'relevance_val' => 1
		)
	);

$gettySearches_arr = array(
	'getty_aat' => array(
		'table' => 'getty_aat',
		'fields' => array(
			'english_pref_term',
			'pref_term_text',
			'nonpref_term_text'
			),
		'relevance_val' => 2
		),
	'getty_tgn' => array(
		'table' => 'getty_tgn',
		'fields' => array(
			'english_pref_term',
			'getty_pref_term',
			'nonpref_term'
			),
		'relevance_val' => 2
		),
	'getty_ulan' => array(
		'table' => 'getty_ulan',
		'fields' => array(
			'english_pref_term',
			'pref_term',
			'nonpref_term'
			),
		'relevance_val' => 2
		)
	);


/*
	INCLUDE GETTY SEARCHES, IF SELECTED
*/
if ($_SESSION['toggle'] == 1)
// User selected to include Getty authority searches
// So merge them onto searches array
{
	$searches_arr = array_merge_recursive($searches_arr, $gettySearches_arr);
}


/*
	PERFORM EACH SEARCH
*/
$results_arr = array();
// Initialize array to hold final results as ID#s

// Repeat for each search term entered by the user
foreach ($searchText_arr as $term)
{
	// echo '<br>'.$term.'<br><br>';

	// Repeat for each type of search to be performed
	foreach ($searches_arr as $search_name=>$arr)
	{

		// Repeat for each table invloved in the current search type
		foreach ($arr['fields'] as $field)
		{

			// Begin building query
			$sql = " SELECT * FROM $DB_NAME.".$arr['table']." WHERE ";
			
			// Customize query for Work and Image id searches
			if (in_array($search_name, array('image_id','work_id')))
			{
				$sql .= " lpad(".$field.", 6, '0') LIKE '%{$term}%' ";

				// Exclude Work records with no related Images
				if ($search_name=='work_id')
				{
					$sql .= " && related_images <> '' ";
				}
			}
			else
			{
				$sql .= $field." LIKE '%{$term}%' ";

				// Exclude Work records with no related Images
				if ($search_name=='work_description')
				{
					$sql .= " && related_images <> '' ";
				}
			}
				
			// echo $search_name.': '.$sql.'<br>'; // Debug
			// print_r($searchText_arr);echo '<br><br>'; // Debug

			$result = db_query($mysqli, $sql);


			/*
				ADD QUERY RESULTS TO RESULT ARRAY
			*/

			while ($row = $result->fetch_assoc())
			// Add results for this field search to final results array
			{

				// Term found in Work or Image ID
				if (in_array($search_name, array('image_id','work_id')))
				{
					// Designate result as Work or Image
					$results_arr[$arr['table'].create_six_digits($row['id'])]['type'] = $arr['table'];
					// 
					$results_arr[$arr['table'].create_six_digits($row['id'])]['search'][$term][] = $search_name;
				}

				// Term found in NORMAL DATA FIELD
				elseif (in_array($arr['table'], array('title','agent','date','material','technique','work_type','culture','style_period','location','subject','inscription','rights','source')))
				{
					if (!empty($row['related_works']))
					{
						$results_arr['work'.$row['related_works']]['type'] = 'work';
						$results_arr['work'.$row['related_works']]['search'][$term][] = $search_name;
					}
					elseif (!empty($row['related_images']))
					{
						$results_arr['image'.$row['related_images']]['type'] = 'image';
						$results_arr['image'.$row['related_images']]['search'][$term][] = $search_name;
					}
				}

				// Term found in Work or Image DESCRIPTION
				elseif (in_array($search_name, array('image_description','work_description')))
				{
					// Add 'description' as a successful search type
					$results_arr[$arr['table'].create_six_digits($row['id'])]['type'] = $arr['table'];
					$results_arr[$arr['table'].create_six_digits($row['id'])]['search'][$term][] = $search_name;
				}

				elseif ($arr['table'] == 'getty_aat')
				// Search performed on Getty AAT
				{
					$gid = $row['getty_id'];

					$tables = array('material','technique','work_type','culture','style_period','subject');

					foreach ($tables as $table)
					{
						$gq = "SELECT * 
								FROM $DB_NAME.".$table." 
								WHERE ".$table."_getty_id = '{$gid}' ";

						$g_result = db_query($mysqli, $gq);

						while ($aat_row = $g_result->fetch_assoc())
						{
							if (!empty($aat_row['related_works']))
							{
								$results_arr['work'.$aat_row['related_works']]['type'] = 'work';
								$results_arr['work'.$aat_row['related_works']]['search'][$term][] = $arr['table'];
							}
							elseif (!empty($aat_row['related_images']))
							{
								$results_arr['image'.$aat_row['related_images']]['type'] = 'image';
								$results_arr['image'.$aat_row['related_images']]['search'][$term][] = $arr['table'];
							}
						}
					}
				}

				elseif ($arr['table'] == 'getty_tgn')
				// Search performed on Getty AAT
				{
					$gid = $row['getty_id'];

					$tables = array('location');

					foreach ($tables as $table)
					{
						$gq = "SELECT * 
								FROM $DB_NAME.".$table." 
								WHERE ".$table."_getty_id = '{$gid}' ";

						$g_result = db_query($mysqli, $gq);

						while ($tgn_row = $g_result->fetch_assoc())
						{
							if (!empty($tgn_row['related_works']))
							{
								$results_arr['work'.$tgn_row['related_works']]['type'] = 'work';
								$results_arr['work'.$tgn_row['related_works']]['search'][$term][] = $arr['table'];
							}
							elseif (!empty($tgn_row['related_images']))
							{
								$results_arr['image'.$tgn_row['related_images']]['type'] = 'image';
								$results_arr['image'.$tgn_row['related_images']]['search'][$term][] = $arr['table'];
							}
						}
					}
				}

				elseif ($arr['table'] == 'getty_ulan')
				// Search performed on Getty AAT
				{
					$gid = $row['getty_id'];

					$tables = array('agent');

					foreach ($tables as $table)
					{
						$gq = "SELECT * 
								FROM $DB_NAME.".$table." 
								WHERE ".$table."_getty_id = '{$gid}' ";

						$g_result = db_query($mysqli, $gq);

						while ($ulan_row = $g_result->fetch_assoc())
						{
							if (!empty($ulan_row['related_works']))
							{
								$results_arr['work'.$ulan_row['related_works']]['type'] = 'work';
								$results_arr['work'.$ulan_row['related_works']]['search'][$term][] = $arr['table'];
							}
							elseif (!empty($ulan_row['related_images']))
							{
								$results_arr['image'.$ulan_row['related_images']]['type'] = 'image';
								$results_arr['image'.$ulan_row['related_images']]['search'][$term][] = $arr['table'];
							}
						}
					}
				}
			}
		}
	}
}

// echo '<pre>';
// print_r($results_arr);
// echo '</pre>';

/*
	Remove Images results whose Work record is already represented
*/
foreach ($results_arr as $id=>$arr)
{
	if ($arr['type']=='work')
	{
		$id = substr($id, -6);

		$sql = "SELECT related_images 
				FROM $DB_NAME.work 
				WHERE id = {$id} ";

		$r = db_query($mysqli, $sql);
		
		while ($work = $r->fetch_assoc())
		{ 
			$assocImgs = $work['related_images'];
		}
		$assocImgs = explode(',', $assocImgs);
		foreach ($assocImgs as $img)
		{
			if (array_key_exists('image'.$img, $results_arr))
			{
				unset($results_arr['image'.$img]);
			}
		}
	}
}

/*
	Remove duplicate search types within each term's results
*/
foreach ($results_arr as $id=>$arr)
{
	foreach ($arr['search'] as $term=>$arr)
	{
		$results_arr[$id]['search'][$term] = array_unique($results_arr[$id]['search'][$term]);
	}
}

/* 
	Calculate relevance score for each result
*/
foreach ($results_arr as $id=>$arr)
{
	$rel = 0;
	foreach ($arr['search'] as $term=>$arr)
	{
		foreach ($arr as $index=>$search)
		{
			$rel = $rel + $searches_arr[$search]['relevance_val'];
		}
	}
	$results_arr[$id]['rel'] = $rel*count($results_arr[$id]['search']);
}


/*
	Reorder the results array in order of relevance
	Function by Tom Haigh on Stackoverflow.com
	http://stackoverflow.com/questions/2699086/sort-multidimensional-array-by-value-2
*/
function array_sort_by_column(&$arr, $col, $dir = SORT_DESC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}
array_sort_by_column($results_arr, 'rel');

// echo '<pre>';
// print_r($results_arr);
// echo '</pre>';

// If this is a fresh search, create a result wrapper
if (isset($_POST['page']) && $_POST['page']==1) { ?>

	<div id="lantern_results_list">

<?php
}
?>

	<?php 
	include_once('lantern_results_'.$_SESSION['pref_lantern_view'].'.php');

// If this is a fresh search, close the wrapper
if (isset($_POST['page']) && $_POST['page']==1) { ?>

	</div>

<?php
}

if ($page==1)
{
?>

<script id="lantern_search_script">

	// var res_ct = <?php echo count($results_arr); ?>;
	// msg([res_ct+' results found'], 'success'); // Might be unnecessary

</script>

<?php
}
?>
