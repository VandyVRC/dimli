<?php 

$action = $_POST['action'];


$_SESSION['cart'] = array();    

$images = explode(',', $_POST['images']);
 
foreach ($images as $image) {

	if ($action = 'add') {
	$_SESSION['cart'][] = $image;
	}	

	if ($action = 'remove') {
	$key=array_search($image, $_SESSION['cart']);
	    if($key!==false) unset($_SESSION['cart'][$key]);
	}
}

?> 