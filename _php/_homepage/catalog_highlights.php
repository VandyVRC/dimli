<?php 
$dev = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$dev);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();

for ($i=0; $i<1000; $i++):
	$id = rand(1, 70000);
	$sql = "SELECT * FROM dimli.image 
				WHERE id = {$id} ";
	$result = db_query($mysqli, $sql);
	if ($result->num_rows > 0):
		while ($row = $result->fetch_assoc()):
			$id = str_pad($row['id'], 6, '0', STR_PAD_LEFT);
			$catd = $row['catalogued'];
		endwhile;
		if ($catd == 1) break;
	endif;
endfor;

$sql = "SELECT image.id, 
				image.related_works, 
				title.related_works, 
				title.title_text, 
				agent.related_works, 
				agent.agent_text 
			FROM dimli.image 
			INNER JOIN dimli.title 
			ON image.id = {$id}
				AND image.related_works = title.related_works 
			INNER JOIN dimli.agent 
			ON image.id = {$id} 
				AND image.related_works = agent.related_works
			LIMIT 1 ";

$title_res = db_query($mysqli, $sql);

while ($row = $title_res->fetch_assoc()):

	$title = $row['title_text'];
	$agent = $row['agent_text'];

endwhile;

$title_res->free();

?>

<div id="home_right_pane">

<div id="catalog_highlights">

	<h3>Catalog Highlight</h3>

	<div class="outer_wrapper" hidden>

		<div class="inner_wrapper">

			<img class="highlight_image" src="http://dimli.library.vanderbilt.edu/_plugins/timthumb/timthumb.php?src=mdidimages/HoAC/medium/<?php echo$id;?>.jpg&amp;h=400&amp;q=90">

			<div class="banner">

				<div class="banner_text">
					<span class="title"><?php echo htmlentities($title); ?></span><br>
					<span class="agent"><?php echo htmlentities($agent); ?></span>
				</div>

			</div>

		</div>

	</div>

</div>

<script>

	$('div#catalog_highlights .outer_wrapper').delay(400).fadeIn(800);

</script>