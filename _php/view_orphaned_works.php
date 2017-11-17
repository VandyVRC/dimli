<?php

if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../_php/_config/session.php');
require_once(MAIN_DIR.'/../_php/_config/connection.php');
require_once(MAIN_DIR.'/../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_catalog');

?>

<div style="margin: -10px -5px 5px -5px; padding: 7px 10px 3px 10px; background-color: #FAFAFA; border-bottom: 1px dashed #CCC;">

	<p class="mediumWeight">Unused work records do not currently function as the parent to any images records at all.<br>This may be the case for one of two reasons:</p>

	<div>
		<div class="inline" style="height: 25px; width: 30px; border: 1px solid #669; background-color: #F5F5F5; margin: 0 0 0 10px; vertical-align: middle;"></div>
		<p class="inline" style="font-size: 0.9em;"><span class="mediumWeight">"Built Works"</span> are currently being used by at least one work or image record as a location. They should remain in the catalog.</p>
	</div>

	<div>
		<div class="inline" style="height: 25px; width: 30px; border: 1px solid #F58C00; background-color: #FFFBF2; margin: 0 0 0 10px; vertical-align: middle;"></div>
		<p class="inline" style="font-size: 0.9em;"><span class="mediumWeight">"Unused Works"</span> are no longer in use by any records in the catalog. They can generally be safely deleted.</p>
	</div>

</div>

<?php

$works = array();

$sql = "SELECT * 
			FROM DB_NAME.work 
			WHERE related_images = '' ";

$result = db_query($mysqli, $sql);

while ($row = $result->fetch_assoc())
{
	$works[] = $row['id'];
}

foreach ($works as $workNum)
{
	/*
	Find 
	*/
	$sql = "SELECT title_text 
				FROM DB_NAME.title 
				WHERE related_works = {$workNum} LIMIT 1 ";

	$title_res = db_query($mysqli, $sql);

	if ($title_res->num_rows >= 1)
	{
		while ($row = $title_res->fetch_assoc())
		{
			$title = ($row['title_text'] != '')
				? $row['title_text']
				: 'blank entry';
		}
	} 
	else 
	{
		$title = '[data missing]';
	}


	$sql = "SELECT agent_text 
				FROM DB_NAME.agent 
				WHERE related_works = {$workNum} LIMIT 1 ";

	$agent_res = db_query($mysqli, $sql);

	if ($agent_res->num_rows >= 1) 
	{
		while ($row = $agent_res->fetch_assoc()) 
		{
			$agent = ($row['agent_text'] != '')
				? $row['agent_text']
				: 'blank entry';
		}
	} 
	else 
	{
		$agent = '[data missing]';
	}
		

	$workNum6 = str_pad($workNum, 6, '0', STR_PAD_LEFT);

	$sql = "SELECT * 
				FROM DB_NAME.location 
				WHERE location_getty_id = 'work{$workNum6}' ";

	$used_res = db_query($mysqli, $sql);

	if ($used_res->num_rows <= 0) 
	{
		$used = false;
	} 
	else 
	{
		$used = true;
	}

	?><div class="pane<?php echo($used==false)?' unused':'';?>">

		<div class="record_number">

			<span class="workNum"><?php

				echo str_pad($workNum, 6, '0', STR_PAD_LEFT);

			?></span>

			<a id="delete_work" class="floatRight"
				title="Delete work record">

				<img src="_assets/_images/bin_closed.png" 
					style="height: 14px; width: 14px;">

			</a>

		</div>

		<div class="title"><?php echo $title; ?></div>

		<div class="agent"><?php echo $agent; ?></div>

	</div><?php
}
?>
<script>

	closeModule_button($('div#viewOrphanedWorks_module'));

	/*
	Permanently delete Work record
	*/
	$('a#delete_work').click(
		function()
		{
			if (confirm('Are you sure you wish to permanently delete this work record?'))
			{
				var workNum = $(this).siblings('span.workNum').text();
				console.log('User confirmed deletion of Work '+workNum);
				delete_work_record(workNum);
			}
		});

</script>

