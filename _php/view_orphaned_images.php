<?php
$dev = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$dev);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_catalog');

?>

<div style="margin: -10px -5px 5px -5px; padding: 7px 10px 3px 10px; background-color: #FAFAFA; border-bottom: 1px dashed #CCC;">

	<p class="mediumWeight">A parentless image record belongs to an order that has been completely cataloged, yet it has no parent work record.<br>Please use the order number supplied below to track down each parentless image record and associate it with a work.</p>

</div>

<?php

$images = array();
$loners = array();

$images_res = isnerQ("SELECT * FROM dimli.image WHERE related_works = ''");

while ($row = mysql_fetch_assoc($images_res))
{
	$images_a[str_pad($row['id'],6,'0',STR_PAD_LEFT)]['order'] = $row['order_id'];
}

$i = 0;
foreach ($images_a as $image=>$arr)
{
	$complete_boo = mysql_result(isnerQ("SELECT images_catalogued FROM dimli.order WHERE id = {$arr['order']}"), 0);
	if ($complete_boo == 1 || $complete_boo == '1' || $complete_boo == true)
	{
		$loners[$i]['image'] = $image;
		$loners[$i]['order'] = $arr['order'];
	}
$i++;
}

if (count($loners) >= 1)
{
	print_r_pre($loners);
}
else
{
	echo 'No parentless image records were found. All image records are associated with works and accounted for!';
}
?>