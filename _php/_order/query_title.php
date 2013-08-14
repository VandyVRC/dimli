<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/functions.php');

$sql = "SELECT title_text 
			FROM dimli.title 
			WHERE related_images = '{$imageId}' 
			ORDER BY id ASC 
			LIMIT 1 ";

$result_title = db_query($mysqli, $sql);

while ($title = $result_title->fetch_assoc()) { 
	$imageTitle = $title['title_text']; 
}

if (!empty($imageTitle)): ?>

	<span title="<?php echo (strlen($imageTitle) >= 40) ? $imageTitle : ''; ?>">

		<?php						
		echo (strlen($imageTitle) >= 40)
			? substr($imageTitle, 0, 40).'...'
			: $imageTitle; ?>
		
	</span>
	
	<?php $imageTitle = '';
	
elseif (empty($imageTitle)): ?>

	<span>--</span>
	
<?php endif; ?>