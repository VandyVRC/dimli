	<p class="clear"></p>

</div> <!-- body -->
</div> <!-- body_wide -->
<div id="footer_wide">
<a href="http://vanderbilt.edu" target="_blank">Created by Vanderbilt University</a><br /><br />
<a href="http://form.jotform.us/form/40855277993167" target="_blank" style ="margin-left: 3%">Submit a Bug Report</a>	
</div>
<p class="clear"></p>

<!--
	Call scripts
-->
<script src="_javascript/sorttable.js?<?php echo date('His'); ?>"></script>
<script src="_javascript/docready.js?<?php echo date('His'); ?>"></script>
<script src="_javascript/functions.js?<?php echo date('His'); ?>"></script>
<script src="_plugins/highlight/jquery.highlight-4.js?<?php echo date('His'); ?>"></script>

</body>
</html>

<?php
if (isset($connection)) {
	// Close connection
	mysql_close($connection);
}

if (isset($mysqli)) {
	// Close database connection
	$mysqli->close();
}

// Show GLOBAL array, if username = "isnerms"
// showGlobals('isnerms');
?> 