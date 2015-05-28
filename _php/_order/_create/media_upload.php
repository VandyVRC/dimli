<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../../_php/_config/session.php'); 
require_once(MAIN_DIR.'/../../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_orders_create');



function checkfile($name, $tmpnm, $type, $size){
	$target_dir = "../../../images/";
	$target_file = $target_dir . basename($name);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	// Check if image file is a actual image or fake image

    $check = getimagesize($tmpnm);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

	// Check if file already exists
	if (file_exists($target_file)) {
	    echo "Sorry, file already exists.";
	    $uploadOk = 0;
	}
	// Check file size
	if ($size > 50000000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "JPEG") {
	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($tmpnm, $target_file)) {
	        echo "The file ". basename($name). " has been uploaded.";
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}
}

if(isset($_POST['submit'])) {
	foreach($_FILES['media']['tmp_name'] as $key => $name_tmp){
		$name= $_FILES['media']['name'][$key];
		$tmpnm= $_FILES['media']['tmp_name'][$key];
		$type= $_FILES['media']['type'][$key];
		$size= $_FILES['media']['size'][$key];

		checkfile($name, $tmpnm, $type, $size);
	}

}

?>