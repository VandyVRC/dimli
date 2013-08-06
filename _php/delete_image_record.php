<?php
$dev = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$dev);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_images_delete');

//----------------------------------------
//
//		DELETE AN INDIVIDUAL IMAGE
//
//----------------------------------------

if (isset($_GET['deadImage']))
// User clicked & confirmed that they wish to delete an image
{

	$associatedOrderId = $_SESSION['order'];
	$deadImageId = $_GET['deadImage'];
	
	// Verify that order has at least 2 images
	$query = " SELECT * FROM dimli.image WHERE order_id = '{$associatedOrderId}' ";
	$result = mysql_query($query, $connection); confirm_query($result);
	$numImages = mysql_num_rows($result);
	
	if ($numImages >= 2)
	// Order has at least 2 images remaining,
	// so user CAN delete an individual image
	{
		//echo 'The script would have deleted ' . $deadImageId . ' from Order ' . $associatedOrderId;
		$imageId_six = create_six_digits($deadImageId);
		// Create six-digit image id to compare against 'related_images' fields

		// Delete the image from the IMAGE table
		$query = " DELETE FROM dimli.image WHERE id = '{$deadImageId}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		
		// Determine the order's new image count, after the deletion
		$query = " SELECT * FROM dimli.image WHERE order_id = '{$associatedOrderId}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		$newImageCount = mysql_num_rows($result);

		// Update the order's image count
		$query = " UPDATE dimli.order SET image_count = '{$newImageCount}' WHERE id = '{$associatedOrderId}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		
		//----------------------------------------------
		// 	Remove the deleted image's cataloging info
		//----------------------------------------------
		
		$query = " DELETE FROM dimli.agent WHERE related_images = '{$imageId_six}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		// Delete associated agent info
		
		$query = " DELETE FROM dimli.culture WHERE related_images = '{$imageId_six}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		// Delete associated cultural context info
		
		$query = " DELETE FROM dimli.date WHERE related_images = '{$imageId_six}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		// Delete associated date info
		
		$query = " DELETE FROM dimli.edition WHERE related_images = '{$imageId_six}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		// Delete associated state/edition info
		
		$query = " DELETE FROM dimli.inscription WHERE related_images = '{$imageId_six}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		// Delete associated inscription info
		
		$query = " DELETE FROM dimli.location WHERE related_images = '{$imageId_six}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		// Delete associated location info
		
		$query = " DELETE FROM dimli.material WHERE related_images = '{$imageId_six}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		// Delete associated material info
		
		$query = " DELETE FROM dimli.measurements WHERE related_images = '{$imageId_six}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		// Delete associated measurements info
		
		$query = " DELETE FROM dimli.rights WHERE related_images = '{$imageId_six}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		// Delete associated rights info
		
		$query = " DELETE FROM dimli.source WHERE related_images = '{$imageId_six}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		// Delete associated source info
		
		$query = " DELETE FROM dimli.style_period WHERE related_images = '{$imageId_six}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		// Delete associated style_period info
		
		$query = " DELETE FROM dimli.subject WHERE related_images = '{$imageId_six}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		// Delete associated subject info
		
		$query = " DELETE FROM dimli.technique WHERE related_images = '{$imageId_six}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		// Delete associated technique info
		
		$query = " DELETE FROM dimli.title WHERE related_images = '{$imageId_six}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		// Delete associated title info
		
		$query = " DELETE FROM dimli.work_type WHERE related_images = '{$imageId_six}' ";
		$result = mysql_query($query, $connection); confirm_query($result);
		// Delete associated work type info

		/*
		LOG ACTION
		*/
		$UnixTime = time(TRUE);
		$log = isnerQ("INSERT INTO dimli.Activity
							SET 
								UserID = '{$_SESSION['user_id']}',
								RecordType = 'Image',
								RecordNumber = {$deadImageId},
								ActivityType = 'deleted',
								UnixTime = '{$UnixTime}'
							");
		
	}
	elseif ($numImages == 1)
	{
	// This order only has ONE image remaining,
	// so user must delete the entire order instead
	
		
	
	}

}

?>