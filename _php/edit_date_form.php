<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../_php/_config/session.php');
require_once(MAIN_DIR.'/../_php/_config/connection.php');
require_once(MAIN_DIR.'/../_php/_config/functions.php');
confirm_logged_in();

$dateNeeded = $_POST['dateNeeded'];


?>

<form id="edit_date_form" style ="margin-left: 50%; font-size : 85%;"><input type="text" id="datepicker3" class="date" name="dateNeeded" style="width: 90px;" value="<?php echo $dateNeeded;?>">
<input type="button" id="edit_date_submit" value="Submit"><input type="button" id="edit_date_cancel" value="Cancel"></form>


<script>
	
	//Disable enter key within form 

	$(document).keypress(
    function(event){
     if (event.which == '13') {
        event.preventDefault();
      }
});


	var orderNum = '<?php echo $_POST['orderNum'];?>';
	var dateNeeded ='<?php echo $_POST['dateNeeded'];?>';
	
	
		$('input#edit_date_submit').click(function() {	
			updateOrderDueDate(orderNum);
			findOrders_loadResults(1, 'date_needed', 'ASC');
		});


		$('input#edit_date_cancel').click(function() {	
			$('form#edit_date_form').remove();
			$('span#orderDueClickable').show();
		});

	//  Load jQuery's datepicker widget

	$(function () {
	   $('.date').datepicker({ dateFormat: 'yy-mm-dd' });
	});

</script>