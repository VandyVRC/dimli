<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/functions.php');


$sql = "SELECT title_text 
			FROM $DB_NAME.title 
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
