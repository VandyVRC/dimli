<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();


$imageView = $_POST['imageView'];

?>

<form id="edit_id_form" style ="margin-left: 26%; font-size : 65%;"><input type="text" id="edit_id" style ="width: 120px; height: 20px;" value="<?php echo $imageView;?>"><input type="button" id="edit_id_submit" value="Submit"><input type="button" id="edit_id_cancel" value="Cancel"></form>

<script>
	
	//Disable enter key within form 

	$(document).keypress(
    function(event){
     if (event.which == '13') {
        event.preventDefault();
      }
});


	var orderNum = '<?php echo $_POST['orderNum'];?>';
	var imageNum = '<?php echo $_POST['imageNum'];?>';

	$('input#edit_id_submit').click(function() {	
		 editImage_id(imageNum);
		 open_order(orderNum);	
		 findOrders_loadResults(1, 'date_needed', 'ASC');
		});
	

	$('input#edit_id_cancel').click(function() {	
		$('form#edit_id_form').remove();
		$('div#imageId').show();
		});


</script>