<?php
$dev = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$dev);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_catalog');

// --------------------------------
// Create arrays of each data type
// --------------------------------

$_SESSION['titleArray']=$_SESSION['agentArray']=$_SESSION['dateArray']=
$_SESSION['materialArray']=$_SESSION['techniqueArray']=$_SESSION['workTypeArray']=
$_SESSION['culturalContextArray']=$_SESSION['stylePeriodArray']=$_SESSION['locationArray']=
$_SESSION['descriptionArray']=$_SESSION['stateEditionArray']=$_SESSION['measurementsArray']=
$_SESSION['subjectArray']=$_SESSION['inscriptionArray']=$_SESSION['rightsArray']= 
$_SESSION['sourceArray']= array();

foreach ($_POST['json'] as $key => $value) {

	if (preg_match('/title/', $key)) {
	
		if (substr($key, 0, 1) == 'W') {
			$_SESSION['titleArray']['work'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 1) == 'I') {
			$_SESSION['titleArray']['image'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 2) == 'NW') {
			$_SESSION['titleArray']['createNewWork'][$key] = trim($mysqli->real_escape_string($value));
		}
		
	} elseif (preg_match('/agent/', $key)) {
	
		if (substr($key, 0, 1) == 'W') {
			$_SESSION['agentArray']['work'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 1) == 'I') {
			$_SESSION['agentArray']['image'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 2) == 'NW') {
			$_SESSION['agentArray']['createNewWork'][$key] = trim($mysqli->real_escape_string($value));
		}
		
	} elseif (preg_match('/(Date|date)/', $key)) {
	
		if (substr($key, 0, 1) == 'W') {
			$_SESSION['dateArray']['work'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 1) == 'I') {
			$_SESSION['dateArray']['image'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 2) == 'NW') {
			$_SESSION['dateArray']['createNewWork'][$key] = trim($mysqli->real_escape_string($value));
		}
		
	} elseif (preg_match('/material/', $key)) {
	
		if (substr($key, 0, 1) == 'W') {
			$_SESSION['materialArray']['work'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 1) == 'I') {
			$_SESSION['materialArray']['image'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 2) == 'NW') {
			$_SESSION['materialArray']['createNewWork'][$key] = trim($mysqli->real_escape_string($value));
		}
		
	} elseif (preg_match('/technique/', $key)) {
	
		if (substr($key, 0, 1) == 'W') {
			$_SESSION['techniqueArray']['work'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 1) == 'I') {
			$_SESSION['techniqueArray']['image'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 2) == 'NW') {
			$_SESSION['techniqueArray']['createNewWork'][$key] = trim($mysqli->real_escape_string($value));
		}
		
	} elseif (preg_match('/workType/', $key)) {
	
		if (substr($key, 0, 1) == 'W') {
			$_SESSION['workTypeArray']['work'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 1) == 'I') {
			$_SESSION['workTypeArray']['image'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 2) == 'NW') {
			$_SESSION['workTypeArray']['createNewWork'][$key] = trim($mysqli->real_escape_string($value));
		}
		
	} elseif (preg_match('/culturalContext/', $key)) {
	
		if (substr($key, 0, 1) == 'W') {
			$_SESSION['culturalContextArray']['work'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 1) == 'I') {
			$_SESSION['culturalContextArray']['image'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 2) == 'NW') {
			$_SESSION['culturalContextArray']['createNewWork'][$key] = trim($mysqli->real_escape_string($value));
		}
		
	} elseif (preg_match('/stylePeriod/', $key)) {
	
		if (substr($key, 0, 1) == 'W') {
			$_SESSION['stylePeriodArray']['work'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 1) == 'I') {
			$_SESSION['stylePeriodArray']['image'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 2) == 'NW') {
			$_SESSION['stylePeriodArray']['createNewWork'][$key] = trim($mysqli->real_escape_string($value));
		}
		
	} elseif (preg_match('/location/', $key)) {
	
		if (substr($key, 0, 1) == 'W') {
			$_SESSION['locationArray']['work'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 1) == 'I') {
			$_SESSION['locationArray']['image'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 2) == 'NW') {
			$_SESSION['locationArray']['createNewWork'][$key] = trim($mysqli->real_escape_string($value));
		}
		
	} elseif (preg_match('/description/', $key)) {
	
		if (substr($key, 0, 1) == 'W') {
			$_SESSION['descriptionArray']['work'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 1) == 'I') {
			$_SESSION['descriptionArray']['image'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 2) == 'NW') {
			$_SESSION['descriptionArray']['createNewWork'][$key] = trim($mysqli->real_escape_string($value));
		}
		
	} elseif (preg_match('/stateEdition/', $key)) {
	
		if (substr($key, 0, 1) == 'W') {
			$_SESSION['stateEditionArray']['work'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 1) == 'I') {
			$_SESSION['stateEditionArray']['image'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 2) == 'NW') {
			$_SESSION['stateEditionArray']['createNewWork'][$key] = trim($mysqli->real_escape_string($value));
		}
		
	} elseif (preg_match('/(Measure|measure|inches|days|hours|minutes|seconds|fileSize|resolution|weight)/', $key)) {
	
		if (substr($key, 0, 1) == 'W') {
			$_SESSION['measurementsArray']['work'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 1) == 'I') {
			$_SESSION['measurementsArray']['image'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 2) == 'NW') {
			$_SESSION['measurementsArray']['createNewWork'][$key] = trim($mysqli->real_escape_string($value));
		}
		
	} elseif (preg_match('/subject/', $key)) {
	
		if (substr($key, 0, 1) == 'W') {
			$_SESSION['subjectArray']['work'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 1) == 'I') {
			$_SESSION['subjectArray']['image'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 2) == 'NW') {
			$_SESSION['subjectArray']['createNewWork'][$key] = trim($mysqli->real_escape_string($value));
		}
		
	} elseif (preg_match('/(Inscription|inscription)/', $key)) {
	
		if (substr($key, 0, 1) == 'W') {
			$_SESSION['inscriptionArray']['work'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 1) == 'I') {
			$_SESSION['inscriptionArray']['image'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 2) == 'NW') {
			$_SESSION['inscriptionArray']['createNewWork'][$key] = trim($mysqli->real_escape_string($value));
		}
		
	} elseif (preg_match('/rights/', $key)) {
	
		if (substr($key, 0, 1) == 'W') {
			$_SESSION['rightsArray']['work'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 1) == 'I') {
			$_SESSION['rightsArray']['image'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 2) == 'NW') {
			$_SESSION['rightsArray']['createNewWork'][$key] = trim($mysqli->real_escape_string($value));
		}
		
	} elseif (preg_match( '/source/', $key )) {
	
		if (substr($key, 0, 1) == 'W') {
			$_SESSION['sourceArray']['work'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 1) == 'I') {
			$_SESSION['sourceArray']['image'][$key] = trim($mysqli->real_escape_string($value));
		} elseif (substr($key, 0, 2) == 'NW') {
			$_SESSION['sourceArray']['createNewWork'][$key] = trim($mysqli->real_escape_string($value));
		}
		
	}

}

$title = $agent = $date = $material = $technique = $workType = $culturalContext = $stylePeriod = $location = $description = $stateEdition = $measurements = $subject = $inscription = $rights = $source = array();

$dataTypes = array('title','agent','date','material','technique','workType','culturalContext','stylePeriod','location','description','stateEdition','measurements','subject','inscription','rights','source');

$work = $image = $createNewWork = array();

ini_set('display_errors', '0');

foreach ($dataTypes as $dataType) {

	if (isset($_POST['json']['newWork']) 
	&& $_POST['json']['newWork'] == true)
	// A new work was created, not a normal catalog update
	{
		$i = 0; $type = 'createNewWork';

		while ($i < countCatRows($_SESSION[$dataType .'Array'][$type])) {
		
			foreach ($_SESSION[$dataType .'Array'][$type] as $key=>$value) {
			
				// if (endsWith($key, $i) && !preg_match('/description/', $key)) {
				
					${$type}[$i][substr_replace(substr_replace($key, '', -1), '', 0, 1)] = $value;
				
				// }
			
			}
			$i ++;
		}
	}
	else
	{
		$i = 0; $type = 'work';

		while ($i < countCatRows($_SESSION[$dataType .'Array'][$type])) {
		
			foreach ($_SESSION[$dataType .'Array'][$type] as $key=>$value) {
			
				// if (endsWith($key, $i) && !preg_match('/description/', $key)) {
				
					${$type}[$i][substr_replace(substr_replace($key, '', -1), '', 0, 1)] = $value;
				
				// }
			
			}
			$i ++;
		}

		$i = 0; $type = 'image';

		while ($i < countCatRows($_SESSION[$dataType .'Array'][$type])) {
		
			foreach ($_SESSION[$dataType .'Array'][$type] as $key=>$value) {
			
				// if (endsWith($key, $i) && !preg_match('/description/', $key)) {
				
					${$type}[$i][substr_replace(substr_replace($key, '', -1), '', 0, 1)] = $value;
				
				// }
			
			}
			$i ++;
		}
	}

	${$dataType}[] = array_merge( array( 'work'=>$work ), array( 'image'=>$image ) );
	
	$work = $image = $createNewWork = array();
	
}

ini_set('display_errors', '1');

if (isset($_POST['json']['newWork']) 
&& $_POST['json']['newWork'] == true)
// A new work was created, not a normal catalog update
{
	require_once('../_php/create_work_script.php');
}
else
{
	require_once('../_php/updateWork_script.php');

	require_once('../_php/updateImage_script.php');
}