<?php 
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../_php/_config/session.php');
require_once(MAIN_DIR.'/../_php/_config/connection.php');
require_once(MAIN_DIR.'/../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_catalog');



// Find images that are depedent upon the current work record

$sql = "SELECT * 
			FROM $DB_NAME.image 
			WHERE related_works = '{$_SESSION['workNum']}' ";

$dependentImages = db_query($mysqli, $sql);

// Count number of images that are dependent upon the current work record
$dependentImages_c = $dependentImages->fetch_assoc();
?>

<div class="cataloguingPane" 
	style="position: relative;">
	
	<div class="catFormWrapper">

		<!-- Title -->
		
		<div id="workTitle_section" 
			class="catSectionWrapper workSection">
		
			<?php
			// Count the number of rows that begin with 'titleType'
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'titleType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) {
			?>
		
			<div class="clone_wrap">

				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Title</div>

						<input type="hidden"
							id="WtitleDisplay<?php echo $i; ?>"
							class="cat_display"
							name="WtitleDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['work']['titleDisplay'.$i])) ? $_SESSION['work']['titleDisplay'.$i] : '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="WtitleType<?php echo $i; ?>"
								name="WtitleType<?php echo $i; ?>" 
								title="Title type">
									
								<option id="blank" value="" <?php selectedOption($_SESSION['work']['titleType'.$i], ''); ?>>- Type -</option>
								
								<option id="brandName" value="Brand name" <?php selectedOption($_SESSION['work']['titleType'.$i], 'Brand name'); ?>>Brand name</option>
								
								<option id="cited" value="Cited" <?php selectedOption($_SESSION['work']['titleType'.$i], 'Cited'); ?>>Cited</option>
								
								<option id="creator" value="Creator" <?php selectedOption($_SESSION['work']['titleType'.$i], 'Creator'); ?>>Creator</option>
								
								<option id="descriptive" value="Descriptive" <?php selectedOption($_SESSION['work']['titleType'.$i], 'Descriptive'); ?>>Descriptive</option>
								
								<option id="former" value="Former" <?php selectedOption($_SESSION['work']['titleType'.$i], 'Former'); ?>>Former</option>
								
								<option id="inscribed" value="Inscribed" <?php selectedOption($_SESSION['work']['titleType'.$i], 'Inscribed'); ?>>Inscribed</option>
								
								<option id="owner" value="Owner" <?php selectedOption($_SESSION['work']['titleType'.$i], 'Owner'); ?>>Owner</option>
								
								<option id="popular" value="Popular" <?php selectedOption($_SESSION['work']['titleType'.$i], 'Popular'); ?>>Popular</option>
								
								<option id="repository" value="Repository" <?php selectedOption($_SESSION['work']['titleType'.$i], 'Repository'); ?>>Repository</option>
								
								<option id="translated" value="Translated" <?php selectedOption($_SESSION['work']['titleType'.$i], 'Translated'); ?>>Translated</option>
								
								<option id="other" value="Other" <?php selectedOption($_SESSION['work']['titleType'.$i], 'Other'); ?>>Other</option>
								
							</select>
							
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="Wtitle<?php echo $i; ?>" 
								class="autoWidth"
								name="Wtitle<?php echo $i; ?>" 
								placeholder="Title"
								value="<?php echo (isset($_SESSION['work'])) ? htmlspecialchars($_SESSION['work']['title'.$i]) : ''; ?>">
						
						</div>
						
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
										
				</div> <!-- catRowWrapper -->

			</div>
		
			<?php $i++; } ?>
			
		</div> <!-- catSectionWrapper -->
		
		
							
		<!-- Agent -->
		
		<div class="catSectionWrapper workSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'agentAttribution')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) {
			
			?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Agent</div>

						<input type="hidden"
							id="WagentDisplay<?php echo $i; ?>"
							class="cat_display"
							name="WagentDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['work']['agentDisplay'.$i])) ? $_SESSION['work']['agentDisplay'.$i] : '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="WagentAttribution<?php echo $i; ?>" 
									name="WagentAttribution<?php echo $i; ?>"
									title="Agent attribution">
							
								<option id="blank" value="None" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentAttribution'.$i] == "None") ? 'selected="selected"' : "" ;?>>None</option>
								
								<option id="after" value="After" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentAttribution'.$i] == "After") ? 'selected="selected"' : "" ;?>>After</option>
								
								<option id="associateOf" value="Associate of" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentAttribution'.$i] == "Associate of") ? 'selected="selected"' : "" ;?>>Associate of</option>
								
								<option id="circleOf" value="Circle of" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentAttribution'.$i] == "Circle of") ? 'selected="selected"' : "" ;?>>Circle of</option>
								
								<option id="followerOf" value="Follower of" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentAttribution'.$i] == "Follower of") ? 'selected="selected"' : "" ;?>>Follower of</option>
								
								<option id="forgeryOf" value="Forgery of" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentAttribution'.$i] == "Forgery of") ? 'selected="selected"' : "" ;?>>Forgery of</option>
								
								<option id="officeOf" value="Office of" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentAttribution'.$i] == "Office of") ? 'selected="selected"' : "" ;?>>Office of</option>
								
								<option id="pupilOf" value="Pupil of" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentAttribution'.$i] == "Pupil of") ? 'selected="selected"' : "" ;?>>Pupil of</option>
								
								<option id="reworkingOf" value="Reworking of" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentAttribution'.$i] == "Reworking of") ? 'selected="selected"' : "" ;?>>Reworking of</option>
								
								<option id="schoolOf" value="School of" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentAttribution'.$i] == "School of") ? 'selected="selected"' : "" ;?>>School of</option>
								
								<option id="sealOf" value="Seal of" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentAttribution'.$i] == "Seal of") ? 'selected="selected"' : "" ;?>>Seal of</option>
								
								<option id="studioOf" value="Studio of" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentAttribution'.$i] == "Studio of") ? 'selected="selected"' : "" ;?>>Studio of</option>
								
								<option id="styleOf" value="Style of" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentAttribution'.$i] == "Style of") ? 'selected="selected"' : "" ;?>>Style of</option>
								
								<option id="workshopOf" value="Workshop of" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentAttribution'.$i] == "Workshop of") ? 'selected="selected"' : "" ;?>>Workshop of</option>
								
								<option id="copyOf" value="Copy of" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentAttribution'.$i] == "Copy of") ? 'selected="selected"' : "" ;?>>Copy of</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="WagentRole<?php echo $i; ?>" 
								class="autoWidth"
								name="WagentRole<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['agentRole'.$i] : ''; ?>" 
								title="Agent role"
								placeholder="Agent role (e.g. 'artist; painter')">
						
						</div>
						
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
						
				</div> <!-- catRowWrapper -->
				
				
			
				<!-- Agent 2 -->
				
				<div class="catRowWrapper">
				
					<div class="catRowTitle"></div>
					
					<div class="catCellWrapper">	
					
						<div class="catCell">
						
							<select id="WagentType<?php echo $i; ?>" 
								name="WagentType<?php echo $i; ?>" 
								title="Agent type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Type -</option>
								
								<option id="personal" value="Personal" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentType'.$i] == "Personal") ? 'selected="selected"' : "" ;?>>Personal</option>
								
								<option id="corporate" value="Corporate" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentType'.$i] == "Corporate") ? 'selected="selected"' : "" ;?>>Corporate</option>
								
								<option id="family" value="Family" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentType'.$i] == "Family") ? 'selected="selected"' : "" ;?>>Family</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['agentType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
							
							</select>
						
						</div>	
						
						<div class="catCell">
						
							<input type="text" 
								id="Wagent<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="Wagent<?php echo $i; ?>" 
								placeholder="Agent"
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['agent'.$i] : ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="WagentId<?php echo $i; ?>"
								name="WagentId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['agentId'.$i] : ''; ?>">
						
						</div>
						
					</div> <!-- catCellWrapper -->
					
				</div> <!-- catRowWrapper -->

			</div>
			
			<?php $i++; } ?>
			
		</div> <!-- catSectionWrapper -->
		
		
		
		<!-- Date -->
		
		<div class="catSectionWrapper workSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'dateType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) {
			
			?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Date</div>

						<input type="hidden"
							id="WdateDisplay<?php echo $i; ?>"
							class="cat_display"
							name="WdateDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['work']['dateDisplay'.$i])) ? $_SESSION['work']['dateDisplay'.$i] : '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="WdateType<?php echo $i; ?>" 
								name="WdateType<?php echo $i; ?>" 
								title="Date type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['dateType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Type -</option>
								
								<option id="alteration" value="Alteration" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['dateType'.$i] == "Alteration") ? 'selected="selected"' : "" ;?>>Alteration</option>
								
								<option id="broadcast" value="Broadcast" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['dateType'.$i] == "Broadcast") ? 'selected="selected"' : "" ;?>>Broadcast</option>
								
								<option id="bulk" value="Bulk" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['dateType'.$i] == "Bulk") ? 'selected="selected"' : "" ;?>>Bulk</option>
								
								<option id="commission" value="Commission" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['dateType'.$i] == "Commission") ? 'selected="selected"' : "" ;?>>Commission</option>
								
								<option id="creation" value="Creation" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['dateType'.$i] == "Creation") ? 'selected="selected"' : "" ;?>>Creation</option>
								
								<option id="design" value="Design" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['dateType'.$i] == "Design") ? 'selected="selected"' : "" ;?>>Design</option>
								
								<option id="destruction" value="Destruction" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['dateType'.$i] == "Destruction") ? 'selected="selected"' : "" ;?>>Destruction</option>
								
								<option id="discovery" value="Discovery" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['dateType'.$i] == "Discovery") ? 'selected="selected"' : "" ;?>>Discovery</option>
								
								<option id="exhibition" value="Exhibition" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['dateType'.$i] == "Exhibition") ? 'selected="selected"' : "" ;?>>Exhibition</option>
								
								<option id="inclusive" value="Inclusive" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['dateType'.$i] == "Inclusive") ? 'selected="selected"' : "" ;?>>Inclusive</option>
								
								<option id="performance" value="Performance" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['dateType'.$i] == "Performance") ? 'selected="selected"' : "" ;?>>Performance</option>
								
								<option id="publication" value="Publication" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['dateType'.$i] == "Publication") ? 'selected="selected"' : "" ;?>>Publication</option>
								
								<option id="restoration" value="Restoration" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['dateType'.$i] == "Restoration") ? 'selected="selected"' : "" ;?>>Restoration</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['work']) && $_SESSION['work']['dateType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
								
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<!-- "Range" checkbox -->
							<input type="checkbox" 
								id="WdateRange<?php echo $i; ?>" 
								class="checkbox"
								<?php echo (isset($_SESSION['work']['dateRange'.$i]) && !empty($_SESSION['work']['dateRange'.$i])) ? 'checked="checked"' : "" ;?>
								name="WdateRange<?php echo $i; ?>" 
								value="range"/>Range
						
						</div>
						
						<div class="catCell">
						
							<!-- "ca." checkbox -->
							<input type="checkbox" 
								id="WcircaDate<?php echo $i; ?>" 
								class="checkbox"
								<?php echo (isset($_SESSION['work']['circaDate'.$i]) && !empty($_SESSION['work']['circaDate'.$i])) ? 'checked="checked"' : "" ;?>
								name="WcircaDate<?php echo $i; ?>" 
								value="circa"/>ca.
						
						</div>

					</div> <!-- catCellWrapper -->

					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>

				</div> <!-- catRowWrapper -->

				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText"></div>
					
					</div>

					<div class="catCellWrapper">
						
						<div class="catCell">
						
							<!-- "startDate" text field -->
							<input type="text" 
								id="WstartDate<?php echo $i; ?>" 
								name="WstartDate<?php echo $i; ?>" 
								maxlength="5"
								placeholder="Date" 
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['startDate'.$i] : ''; ?>" 
								style="width: 3em;">
						
						</div>
						
						<div class="catCell">
						
							<!-- "startDate" era selection -->
							<select id="WstartDateEra<?php echo $i; ?>" 
								name="WstartDateEra<?php echo $i; ?>">
							
								<option id="CE" value="CE" <?php echo (isset($_SESSION['work']['startDateEra'.$i]) && $_SESSION['work']['startDateEra'.$i] == 'CE') ? 'selected="selected"' : "" ;?>>CE</option>

								<option id="BCE" value="BCE" <?php echo (isset($_SESSION['work']['startDateEra'.$i]) && $_SESSION['work']['startDateEra'.$i] == 'BCE') ? 'selected="selected"' : "" ;?>>BCE</option>
							
							</select>
						
						</div>
						
						<div id="WdateRangeSpan<?php echo $i; ?>" style="display: inline-block;">
						
							<div class="catCell">
							
								to
								
							</div>
							
							<div class="catCell">
							
								<!-- "endDate" text field -->
								<input type="text" 
									id="WendDate<?php echo $i; ?>" 
									name="WendDate<?php echo $i; ?>" 
									maxlength="5" 
									placeholder="Date"
									value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['endDate'.$i] : ''; ?>" 
									style="width: 3em;">
								
							</div>
							
							<div class="catCell">
							
								<!-- "endDate" era selection -->
								<select id="WendDateEra<?php echo $i; ?>" 
									name="WendDateEra<?php echo $i; ?>">
							
									<option id="CE" value="CE" <?php echo (isset($_SESSION['work']['endDateEra'.$i]) && $_SESSION['work']['endDateEra'.$i] == 'CE') ? 'selected="selected"' : "" ;?>>CE</option>

									<option id="BCE" value="BCE" <?php echo (isset($_SESSION['work']['endDateEra'.$i]) && $_SESSION['work']['endDateEra'.$i] == 'BCE') ? 'selected="selected"' : "" ;?>>BCE</option>
								
								</select>
							
							</div>
						
						</div> <!-- dateRangeSpan -->
					
					</div> <!-- catCellWrapper -->
					
				</div> <!-- catRowWrapper -->

			</div>
		
			<?php $i++; } ?>
		
		</div> <!-- catSectionWrapper -->
		
		
		
		<!-- Material -->
		
		<div class="catSectionWrapper workSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'materialType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) {
			
			?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Material</div>

						<input type="hidden"
							id="WmaterialDisplay<?php echo $i; ?>"
							class="cat_display"
							name="WmaterialDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['work']['materialDisplay'.$i])) ? $_SESSION['work']['materialDisplay'.$i] : '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="WmaterialType<?php echo $i; ?>" 
								name="WmaterialType<?php echo $i; ?>"
								title="Material type">
							
								<option id="blank" value="" <?php echo (isset($_SESSION['work']['materialType'.$i]) && $_SESSION['work']['materialType'.$i] == '') ? 'selected="selected"' : ''; ?>>- Type -</option>
								
								<option id="medium" value="Medium" <?php echo (isset($_SESSION['work']['materialType'.$i]) && $_SESSION['work']['materialType'.$i] == 'Medium') ? 'selected="selected"' : ''; ?>>Medium</option>
								
								<option id="support" value="Support" <?php echo (isset($_SESSION['work']['materialType'.$i]) && $_SESSION['work']['materialType'.$i] == 'Support') ? 'selected="selected"' : ''; ?>>Support</option>
								
								<option id="other" value="Other" <?php echo (isset($_SESSION['work']['materialType'.$i]) && $_SESSION['work']['materialType'.$i] == 'Other') ? 'selected="selected"' : ''; ?>>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="Wmaterial<?php echo $i; ?>"
								class="autoWidth authoritySearch idMissing" 
								name="Wmaterial<?php echo $i; ?>" 
								placeholder="Material"
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['material'.$i] : ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="WmaterialId<?php echo $i; ?>"
								name="WmaterialId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['materialId'.$i] : ''; ?>">
						
						</div>
					
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->

			</div>
			
			<?php $i++; } ?>
		
		</div> <!-- catSectionWrapper -->


		
		<!-- Technique -->
		
		<div class="catSectionWrapper workSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'techniqueId')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) {
			
			?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Technique</div>

						<input type="hidden"
							id="WtechniqueDisplay<?php echo $i; ?>"
							class="cat_display"
							name="WtechniqueDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['work']['techniqueDisplay'.$i])) ? $_SESSION['work']['techniqueDisplay'.$i] : '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="Wtechnique<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="Wtechnique<?php echo $i; ?>" 
								placeholder="Technique"
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['technique'.$i] : ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="WtechniqueId<?php echo $i; ?>"
								name="WtechniqueId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['techniqueId'.$i] : ''; ?>">
						
						</div>
					
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->

			</div>
			
			<?php $i++; } ?>
			
		</div> <!-- catSectionWrapper -->
		
		
		
		<!-- Work Type -->
		
		<div class="catSectionWrapper workSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'workTypeId')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) {
			
			?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Work Type</div>

						<input type="hidden"
							id="WworkTypeDisplay<?php echo $i; ?>"
							class="cat_display"
							name="WworkTypeDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['work']['workTypeDisplay'.$i])) ? $_SESSION['work']['workTypeDisplay'.$i] : '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="WworkType<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="WworkType<?php echo $i; ?>" 
								placeholder="Work Type"
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['workType'.$i] : ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="WworkTypeId<?php echo $i; ?>"
								name="WworkTypeId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['workTypeId'.$i] : ''; ?>">
						
						</div>
					
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->

			</div>
		
			<?php $i++; } ?>
			
		</div> <!-- catSectionWrapper -->
		
		
		
	<!-- Measurements -->
		
		<div class="catSectionWrapper workSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'measurementType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) {
			
			?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Measure</div>

						<input type="hidden"
							id="WmeasurementDisplay<?php echo $i; ?>"
							class="cat_display"
							name="WmeasurementDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['work']['measurementDisplay'.$i])) ? $_SESSION['work']['measurementDisplay'.$i] : '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="WmeasurementType<?php echo $i; ?>" 
								name="WmeasurementType<?php echo $i; ?>"
								title="Measurement type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Measurement -</option>
								
								<option id="area" value="Area" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "Area") ? 'selected="selected"' : "" ;?>>Area</option>
								
								<option id="bitDepth" value="Bit depth" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "Bit depth") ? 'selected="selected"' : "" ;?>>Bit depth</option>
								
								<option id="circumference" value="Circumference" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "Circumference") ? 'selected="selected"' : "" ;?>>Circumference</option>
								
								<option id="count" value="Count" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "Count") ? 'selected="selected"' : "" ;?>>Count</option>
								
								<option id="depth" value="Depth" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "Depth") ? 'selected="selected"' : "" ;?>>Depth</option>
								
								<option id="diameter" value="Diameter" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "Diameter") ? 'selected="selected"' : "" ;?>>Diameter</option>
								
								<option id="distanceBetween" value="Distance between" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "Distance between") ? 'selected="selected"' : "" ;?>>Distance between</option>
								
								<option id="duration" value="Duration" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "Duration") ? 'selected="selected"' : "" ;?>>Duration</option>
								
								<option id="fileSize" value="File size" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "File size") ? 'selected="selected"' : "" ;?>>File size</option>
								
								<option id="height" value="Height" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "Height") ? 'selected="selected"' : "" ;?>>Height</option>
								
								<option id="length" value="Length" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "Length") ? 'selected="selected"' : "" ;?>>Length</option>
								
								<option id="resolution" value="Resolution" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "Resolution") ? 'selected="selected"' : "" ;?>>Resolution</option>
								
								<option id="runningTime" value="Running time" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "Running time") ? 'selected="selected"' : "" ;?>>Running time</option>
								
								<option id="scale" value="Scale" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "Scale") ? 'selected="selected"' : "" ;?>>Scale</option>
								
								<option id="size" value="Size" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "Size") ? 'selected="selected"' : "" ;?>>Size</option>
								
								<option id="weight" value="Weight" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "Weight") ? 'selected="selected"' : "" ;?>>Weight</option>
								
								<option id="width" value="Width" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "Width") ? 'selected="selected"' : "" ;?>>Width</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['work']['measurementType'.$i]) && $_SESSION['work']['measurementType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
							
							</select>
						
						</div>
						
						<div id="WcountMeasurement<?php echo $i; ?>" class="catCell">
						
							Count:
						
						</div>
						
						<div id="WmeasurementFieldDiv1_<?php echo $i; ?>" class="catCell">
						
							<!-- Basic measurement text field -->
							
							<input type="text" 
								id="WmeasurementField1_<?php echo $i; ?>" 
								name="WmeasurementField1_<?php echo $i; ?>"
								placeholder="" 
								style="width: 2.25em;"
								value="<?php echo $_SESSION['work']['measurementField1_'.$i]; ?>">
						
						</div>
						
						<div id="WbitMeasurement<?php echo $i; ?>" class="catCell">
						
							bit
						
						</div>
						
						<div id="WcommonMeasurement1_<?php echo $i; ?>" 
							class="catCell">
						
							<select id="WcommonMeasurementList1_<?php echo $i; ?>" 
								name="WcommonMeasurementList1_<?php echo $i; ?>">
								
								<option id="cm" value="cm" <?php echo (isset($_SESSION['work']['commonMeasurementList1_'.$i]) && $_SESSION['work']['commonMeasurementList1_'.$i] == 'cm') ? 'selected="selected"' : ''; ?>>cm</option>
								
								<option id="m" value="m" <?php echo (isset($_SESSION['work']['commonMeasurementList1_'.$i]) && $_SESSION['work']['commonMeasurementList1_'.$i] == 'm') ? 'selected="selected"' : ''; ?>>m</option>
								
								<option id="km" value="km" <?php echo (isset($_SESSION['work']['commonMeasurementList1_'.$i]) && $_SESSION['work']['commonMeasurementList1_'.$i] == 'km') ? 'selected="selected"' : ''; ?>>km</option>
								
								<option id="in" value="in" <?php echo (isset($_SESSION['work']['commonMeasurementList1_'.$i]) && $_SESSION['work']['commonMeasurementList1_'.$i] == 'in') ? 'selected="selected"' : ''; ?>>in</option>
								
								<option id="ft" value="ft" <?php echo (isset($_SESSION['work']['commonMeasurementList1_'.$i]) && $_SESSION['work']['commonMeasurementList1_'.$i] == 'ft') ? 'selected="selected"' : ''; ?>>ft</option>
							
							</select>
						
						</div>
						
						<div id="WinchesMeasurement<?php echo $i; ?>" 
							class="inline">
						
							<div class="catCell">,</div> <!-- comma -->
								
							<div class="catCell">
							
								<input type="text" 
									id="WinchesValue<?php echo $i; ?>" 
									name="WinchesValue<?php echo $i; ?>" 
									placeholder="in."
									value="<?php echo $_SESSION['work']['inchesValue'.$i]; ?>" 
									maxlength="5" 
									style="width: 2em;">
								
							</div>
							
						</div>
						
						<div id="WmeasurementFieldDiv2_<?php echo $i; ?>" 
							class="inline">
						
							<div class="catCell">equal to</div> <!-- "equal to" -->
							
							<div class="catCell">
							
								<input type="text" 
									id="WmeasurementField2_<?php echo $i; ?>" 
									name="WmeasurementField2_<?php echo $i; ?>" 
									value="<?php echo $_SESSION['work']['measurementField2_'.$i]; ?>" 
									style="width: 5em;">
							
							</div>
						
						</div>
						
						<div id="WcommonMeasurement2_<?php echo $i; ?>" 
							class="catCell">
						
							<select id="WcommonMeasurementList2_<?php echo $i; ?>" 
								name="WcommonMeasurementList2_<?php echo $i; ?>">
								
								<option id="cm" value="cm" <?php echo (isset($_SESSION['work']['commonMeasurementList2_'.$i]) && $_SESSION['work']['commonMeasurementList2_'.$i] == 'cm') ? 'selected="selected"' : ''; ?>>cm</option>
								
								<option id="m" value="m" <?php echo (isset($_SESSION['work']['commonMeasurementList2_'.$i]) && $_SESSION['work']['commonMeasurementList2_'.$i] == 'm') ? 'selected="selected"' : ''; ?>>m</option>
								
								<option id="km" value="km" <?php echo (isset($_SESSION['work']['commonMeasurementList2_'.$i]) && $_SESSION['work']['commonMeasurementList2_'.$i] == 'km') ? 'selected="selected"' : ''; ?>>km</option>
								
								<option id="in" value="in" <?php echo (isset($_SESSION['work']['commonMeasurementList2_'.$i]) && $_SESSION['work']['commonMeasurementList2_'.$i] == 'in') ? 'selected="selected"' : ''; ?>>in</option>
								
								<option id="ft" value="ft" <?php echo (isset($_SESSION['work']['commonMeasurementList2_'.$i]) && $_SESSION['work']['commonMeasurementList2_'.$i] == 'ft') ? 'selected="selected"' : ''; ?>>ft</option>
							
							</select>
						
						</div>
						
						<div id="WareaMeasurement<?php echo $i; ?>" 
							class="catCell">
						
							<select id="WareaMeasurementList<?php echo $i; ?>" 
								name="WareaMeasurementList<?php echo $i; ?>">
								
								<option id="cm2" value="cm2" <?php echo (isset($_SESSION['work']['areaMeasurementList'.$i]) && $_SESSION['work']['areaMeasurementList'.$i] == 'cm2') ? 'selected="selected"' : ''; ?>>sq. cm</option>
								
								<option id="m2" value="m2" <?php echo (isset($_SESSION['work']['areaMeasurementList'.$i]) && $_SESSION['work']['areaMeasurementList'.$i] == 'm2') ? 'selected="selected"' : ''; ?>>sq. m</option>
								
								<option id="km2" value="km2" <?php echo (isset($_SESSION['work']['areaMeasurementList'.$i]) && $_SESSION['work']['areaMeasurementList'.$i] == 'km2') ? 'selected="selected"' : ''; ?>>sq. km</option>
								
								<option id="in2" value="in2" <?php echo (isset($_SESSION['work']['areaMeasurementList'.$i]) && $_SESSION['work']['areaMeasurementList'.$i] == 'in2') ? 'selected="selected"' : ''; ?>>sq. in</option>
								
								<option id="ft2" value="ft2" <?php echo (isset($_SESSION['work']['areaMeasurementList'.$i]) && $_SESSION['work']['areaMeasurementList'.$i] == 'ft2') ? 'selected="selected"' : ''; ?>>sq. ft</option>
								
								<option id="acres" value="acres" <?php echo (isset($_SESSION['work']['areaMeasurementList'.$i]) && $_SESSION['work']['areaMeasurementList'.$i] == 'acres') ? 'selected="selected"' : ''; ?>>acre(s)</option>
							
							</select>
						
						</div>
						
						<div id="WtimeMeasurement<?php echo $i; ?>" class="inline">
						
							<div class="catCell">
							
								<input type="text" 
									id="Wdays<?php echo $i; ?>" 
									name="Wdays<?php echo $i; ?>" 
									placeholder="Day"
									value="<?php echo($_SESSION['work']['days'.$i]!='0')?$_SESSION['work']['days'.$i]:'';?>" 
									maxlength="10" 
									style="width: 1.7em;">
							
							</div>
							
							<div class="catCell">
							
								<input type="text" 
									id="Whours<?php echo $i; ?>" 
									name="Whours<?php echo $i; ?>" 
									placeholder="Hrs"
									value="<?php echo($_SESSION['work']['hours'.$i]!='0')?$_SESSION['work']['hours'.$i]:'';?>" 
									maxlength="10" 
								style="width: 1.7em;">
							
							</div>
							
							<div class="catCell">
							
								<input type="text" 
									id="Wminutes<?php echo $i; ?>" 
									name="Wminutes<?php echo $i; ?>" 
									placeholder="Min"
									value="<?php echo($_SESSION['work']['minutes'.$i]!='0')?$_SESSION['work']['minutes'.$i]:'';?>" 
									maxlength="10" 
									style="width: 1.7em;">
							
							</div>
							
							<div class="catCell">
							
								<input type="text" 
									id="Wseconds<?php echo $i; ?>" 
									name="Wseconds<?php echo $i; ?>" 
									placeholder="Sec"
									value="<?php echo($_SESSION['work']['seconds'.$i]!='0')?$_SESSION['work']['seconds'.$i]:'';?>" 
									maxlength="10" 
									style="width: 1.7em;">
						
							</div>
							
						</div>
						
						<div id="WfileMeasurement<?php echo $i; ?>" 
							class="catCell">
						
							<select id="WfileSize<?php echo $i; ?>" 
								name="WfileSize<?php echo $i; ?>">
								
								<option id="kb" value="kb" <?php echo (isset($_SESSION['work']['fileSize'.$i]) && $_SESSION['work']['fileSize'.$i] == 'kb') ? 'selected="selected"' : ''; ?>>KB (kilobyte)</option>

								<option id="mb" value="mb" <?php echo (isset($_SESSION['work']['fileSize'.$i]) && $_SESSION['work']['fileSize'.$i] == 'mb') ? 'selected="selected"' : ''; ?>>MB (megabyte)</option>

								<option id="gb" value="gb" <?php echo (isset($_SESSION['work']['fileSize'.$i]) && $_SESSION['work']['fileSize'.$i] == 'gb') ? 'selected="selected"' : ''; ?>>GB (gigabyte)</option>

								<option id="tb" value="tb" <?php echo (isset($_SESSION['work']['fileSize'.$i]) && $_SESSION['work']['fileSize'.$i] == 'tb') ? 'selected="selected"' : ''; ?>>TB (terabyte)</option>
							
							</select>
						
						</div>
						
						<div id="WresolutionMeasurement<?php echo $i; ?>" 
							class="inline">
						
							<div class="catCell">
							
								<input type="text" 
									id="WresolutionWidth<?php echo $i; ?>" 
									name="WresolutionWidth<?php echo $i; ?>" 
									placeholder="Width"
									maxlength="10" 
									value="<?php echo $_SESSION['work']['resolutionWidth'.$i]; ?>"
									style="width: 3em;">
							
							</div>

							<div class="catCell">x</div> <!-- "x" -->

							<div class="catCell">
							
								<input type="text" 
									id="WresolutionHeight<?php echo $i; ?>" 
									name="WresolutionHeight<?php echo $i; ?>"
									placeholder="Height" 
									maxlength="10" 
									value="<?php echo $_SESSION['work']['resolutionHeight'.$i]; ?>" 
									style="width: 3em;">

							</div>
							
						</div>
						
						<div id="WweightMeasurement<?php echo $i; ?>" 
							class="catCell">
						
							<select id="WweightUnit<?php echo $i; ?>" 
								name="WweightUnit<?php echo $i; ?>">
								
								<option id="g" value="g" <?php selectedOption($_SESSION['work']['weightUnit'.$i], 'g'); ?>>g</option>

								<option id="kg" value="kg" <?php selectedOption($_SESSION['work']['weightUnit'.$i], 'kg'); ?>>kg</option>

								<option id="lb" value="lb" <?php selectedOption($_SESSION['work']['weightUnit'.$i], 'lb'); ?>>lb</option>
							
							</select>
						
						</div>
						
						<div id="WotherMeasurement<?php echo $i; ?>" class="inline">
						
							<!-- <div class="catCell">Description:</div> -->
							
							<!-- <div class="catCell">
							
								<input type="text" 
									id="WotherMeasurementDescription<?php //echo $i; ?>" 
									name="WotherMeasurementDescription<?php //echo $i; ?>" 
									placeholder="Description"
									maxlength="500" 
									style="width: 100px;"
									value="<?php //echo $_SESSION['work']['otherMeasurementDescription'.$i]; ?>">
							
							</div> -->
						
						</div>
					
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->

			</div>
			
			<?php $i++; } ?>
		
		</div> <!-- catSectionWrapper -->

		<!-- Cultural Context -->
		
		<div class="catSectionWrapper workSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'culturalContextId')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) { ?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Culture</div>

						<input type="hidden"
							id="WculturalContextDisplay<?php echo $i; ?>"
							class="cat_display"
							name="WculturalContextDisplay<?php echo $i; ?>"
							value="1">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="WculturalContext<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="WculturalContext<?php echo $i; ?>" 
								placeholder="Cultural Context"
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['culturalContext'.$i] : ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="WculturalContextId<?php echo $i; ?>" 
								name="WculturalContextId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['culturalContextId'.$i] : ''; ?>">
											
						</div>
					
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->

			</div>
		
			<?php $i++; } ?>
			
		</div> <!-- catSectionWrapper -->
		
		<!-- Style Period -->
		
		<div class="catSectionWrapper workSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'stylePeriodId')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) {
			
			?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Style Period</div>

						<input type="hidden"
							id="WstylePeriodDisplay<?php echo $i; ?>"
							class="cat_display"
							name="WstylePeriodDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['work']['stylePeriodDisplay'.$i])) ? $_SESSION['work']['stylePeriodDisplay'.$i] : '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="WstylePeriod<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="WstylePeriod<?php echo $i; ?>" 
								placeholder="Style Period"
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['stylePeriod'.$i] : ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="WstylePeriodId<?php echo $i; ?>" 
								name="WstylePeriodId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['stylePeriodId'.$i] : ''; ?>">
						
						</div>
					
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->

			</div>
		
			<?php $i++; } ?>
			
		</div> <!-- catSectionWrapper -->
		
		<!-- Location 1 -->
		
		<div class="catSectionWrapper  workSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'locationNameType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) {
			
			?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Location</div>

						<input type="hidden"
							id="WlocationDisplay<?php echo $i; ?>"
							class="cat_display"
							name="WlocationDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['work']['locationDisplay'.$i])) ? $_SESSION['work']['locationDisplay'.$i] : '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="Wlocation<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="Wlocation<?php echo $i; ?>" 
								placeholder="Location"
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['location'.$i] : ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="WlocationId<?php echo $i; ?>"
								name="WlocationId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['locationId'.$i] : ''; ?>">
						
						</div>
					
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->

				<!-- Location 2 -->
				
				<div class="catRowWrapper" style="position: relative;">
				
					<div class="catRowTitle"></div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="WlocationType<?php echo $i; ?>" 
								name="WlocationType<?php echo $i; ?>" 
								title="Location type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['work']['locationType'.$i]) && $_SESSION['work']['locationType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Type -</option>
								
								<option id="creation" value="Creation" <?php echo(isset($_SESSION['work']['locationType'.$i]) && $_SESSION['work']['locationType'.$i] == "Creation") ? 'selected="selected"' : "" ;?>>Creation</option>
								
								<option id="discovery" value="Discovery" <?php echo(isset($_SESSION['work']['locationType'.$i]) && $_SESSION['work']['locationType'.$i] == "Discovery") ? 'selected="selected"' : "" ;?>>Discovery</option>
								
								<option id="exhibition" value="Exhibition" <?php echo(isset($_SESSION['work']['locationType'.$i]) && $_SESSION['work']['locationType'.$i] == "Exhibition") ? 'selected="selected"' : "" ;?>>Exhibition</option>
								
								<option id="formerOwner" value="Former owner" <?php echo(isset($_SESSION['work']['locationType'.$i]) && $_SESSION['work']['locationType'.$i] == "Former owner") ? 'selected="selected"' : "" ;?>>Former owner</option>
								
								<option id="formerRepository" value="Former repository" <?php echo(isset($_SESSION['work']['locationType'.$i]) && $_SESSION['work']['locationType'.$i] == "Former repository") ? 'selected="selected"' : "" ;?>>Former repository</option>
								
								<option id="formerSite" value="Former site" <?php echo(isset($_SESSION['work']['locationType'.$i]) && $_SESSION['work']['locationType'.$i] == "Former site") ? 'selected="selected"' : "" ;?>>Former site</option>
								
								<option id="installation" value="Installation" <?php echo(isset($_SESSION['work']['locationType'.$i]) && $_SESSION['work']['locationType'.$i] == "Installation") ? 'selected="selected"' : "" ;?>>Installation</option>
								
								<option id="intended" value="Intended" <?php echo(isset($_SESSION['work']['locationType'.$i]) && $_SESSION['work']['locationType'.$i] == "Intended") ? 'selected="selected"' : "" ;?>>Intended</option>
								
								<option id="owner" value="Owner" <?php echo(isset($_SESSION['work']['locationType'.$i]) && $_SESSION['work']['locationType'.$i] == "Owner") ? 'selected="selected"' : "" ;?>>Owner</option>
								
								<option id="performance" value="Performance" <?php echo(isset($_SESSION['work']['locationType'.$i]) && $_SESSION['work']['locationType'.$i] == "Performance") ? 'selected="selected"' : "" ;?>>Performance</option>
								
								<option id="publication" value="Publication" <?php echo(isset($_SESSION['work']['locationType'.$i]) && $_SESSION['work']['locationType'.$i] == "Publication") ? 'selected="selected"' : "" ;?>>Publication</option>
								
								<option id="repository" value="Repository" <?php echo(isset($_SESSION['work']['locationType'.$i]) && $_SESSION['work']['locationType'.$i] == "Repository") ? 'selected="selected"' : "" ;?>>Repository</option>
								
								<option id="site" value="Site" <?php echo(isset($_SESSION['work']['locationType'.$i]) && $_SESSION['work']['locationType'.$i] == "Site") ? 'selected="selected"' : "" ;?>>Site</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['work']['locationType'.$i]) && $_SESSION['work']['locationType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
							
							</select>
						
						</div>

						<div class="catCell">
						
							<select id="WlocationNameType<?php echo $i; ?>" 
								name="WlocationNameType<?php echo $i; ?>" 
								title="Location name type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['work']['locationNameType'.$i]) && $_SESSION['work']['locationNameType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Name Type -</option>
								
								<option id="corporate" value="Corporate" <?php echo(isset($_SESSION['work']['locationNameType'.$i]) && $_SESSION['work']['locationNameType'.$i] == "Corporate") ? 'selected="selected"' : "" ;?>>Corporate</option>
								
								<option id="geographic" value="Geographic" <?php echo(isset($_SESSION['work']['locationNameType'.$i]) && $_SESSION['work']['locationNameType'.$i] == "Geographic") ? 'selected="selected"' : "" ;?>>Geographic</option>
								
								<option id="personal" value="Personal" <?php echo(isset($_SESSION['work']['locationNameType'.$i]) && $_SESSION['work']['locationNameType'.$i] == "Personal") ? 'selected="selected"' : "" ;?>>Personal</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['work']['locationNameType'.$i]) && $_SESSION['work']['locationNameType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
							
							</select>
						
						</div>
							
					</div> <!-- catCellWrapper -->
						
				</div> <!-- catRowWrapper -->

			</div>
		
			<?php $i++; } ?>
			
		</div> <!-- catSectionWrapper -->

		<!-- Specific Location -->
		
		<div class="catSectionWrapper workSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'specificLocationType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) {
			
			?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Specific Location</div>

							<input type="hidden"
							id="WspecificLocationDisplay<?php echo $i; ?>"
							class="cat_display"
							name="WspecificLocationDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['work']['specificLocationDisplay'.$i])) ? $_SESSION['work']['specificLocationDisplay'.$i] : '1'; ?>">

						</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="WspecificLocationType<?php echo $i; ?>" 
								name="WspecificLocationType<?php echo $i; ?>" 
								title="Specific location type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['work']['specificLocationType'.$i]) && $_SESSION['work']['specificLocationType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Type -</option>
								
								<option id="Address" value="Address" <?php echo(isset($_SESSION['work']['specificLocationType'.$i]) && $_SESSION['work']['specificLocationType'.$i] == "Address") ? 'selected="selected"' : "" ;?>>Address</option>

								<option id="LatLng" value="LatLng" <?php echo(isset($_SESSION['work']['specificLocationType'.$i]) && $_SESSION['work']['specificLocationType'.$i] == "LatLng") ? 'selected="selected"' : "" ;?>>LatLng</option>
								
								<option id="Note" value="Note" <?php echo(isset($_SESSION['work']['specificLocationType'.$i]) && $_SESSION['work']['specificLocationType'.$i] == "Note") ? 'selected="selected"' : "" ;?>>Note</option>
							</select>
						
						</div>
					</div><!-- catCellWrapper -->

					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->	

						
				
				<div id="specificLocationRow" class="catRowWrapper">	
				
	
					<div class="catRowTitle"></div>				
					<div class="catCellWrapper">

							<div id="WspecificLocationAddress" class="catCell">
	
								<input type="text" 
									id="WspecificLocationAddress<?php echo $i; ?>" 
									style="width: 14em;"
									name="WspecificLocationAddress<?php echo $i; ?>" 
									placeholder="Street Address"
									value="<?php echo (isset($_SESSION['work']['specificLocationAddress'.$i])) ? $_SESSION['work']['specificLocationAddress'.$i] : ''; ?>" 
									title="Specific location address">
					
							</div><!-- catCell -->

							<div id="WspecificLocationZip" class="catCell">

								<input type="text" 
									id="WspecificLocationZip<?php echo $i; ?>" 
									style="width: 5.5em"
									name="WspecificLocationZip<?php echo $i; ?>" 
									placeholder="Postal Code"
									value="<?php echo (isset($_SESSION['work']['specificLocationZip'.$i])) ? $_SESSION['work']['specificLocationZip'.$i] : ''; ?>" 
									title="Specific location zip">

							</div><!-- catCell -->


						<div id="WspecificLocationLat" class="catCell">

							<input type="text" 
								id="WspecificLocationLat<?php echo $i; ?>" 
								style="width: 6.5em"
								name="WspecificLocationLat<?php echo $i; ?>" 
								placeholder="Temporarily"
								value="<?php echo (isset($_SESSION['work']['specificLocationLat'.$i])) ? $_SESSION['work']['specificLocationLat'.$i] : ''; ?>" 
								title="Specific location latitude" disabled>

						</div><!-- catCell -->

						<div id="WspecificLocationLong" class="catCell">
				
							<input type="text"
								id="WspecificLocationLong<?php echo $i; ?>" 
								style="width: 6.5em"
								name="WspecificLocationLong<?php echo $i; ?>" 
								placeholder="Disabled"
								value="<?php echo (isset($_SESSION['work']['specificLocationLong'.$i])) ? $_SESSION['work']['specificLocationLong'.$i] : ''; ?>" 
								title="Specific location longitude" disabled> 
		

						</div><!-- catCell -->

					</div><!-- catCellWrapper -->
				
				</div> <!-- catRowWrapper -->

				<div id="specificLocationNoteRow" class="catRowWrapper" style="height: 7em; padding-top: 3px; padding-bottom: 0; position: relative;">	
						
					<div class="catCellWrapper"> 

						<div  id="WspecificLocationNote" class="catCell">
							
							<textarea id="WspecificLocationNote<?php echo $i; ?>" 
							class="fixedWidth" 
							rows="2"
							style="height: 6.5em; width: 33em; overflow: hidden;"
							name="WspecificLocationNote<?php echo $i; ?>" 
							placeholder="Specific Location Note"><?php echo (isset($_SESSION['work']['specificLocationNote'.$i])) ? htmlspecialchars($_SESSION['work']['specificLocationNote'.$i]) : ''; ?></textarea>

	 				</div><!-- catCell -->

					</div><!-- catCellWrapper -->
				
				</div> <!-- catRowWrapper -->
			
			</div>
		
			<?php $i++; } ?>
			
		</div> <!-- catSectionWrapper -->

	<!-- Built Work -->
	
		<div class="catSectionWrapper  workSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'builtWorkNameType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) {

			?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Built Work</div>

						<input type="hidden"
							id="WbuiltWorkDisplay<?php echo $i; ?>"
							class="cat_display"
							name="WbuiltWorkDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['work']['builtWorkDisplay'.$i])) ? $_SESSION['work']['builtWorkDisplay'.$i] : '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="WbuiltWork<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="WbuiltWork<?php echo $i; ?>" 
								placeholder="Built Work"
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['builtWork'.$i] : ''; ?>">
						
						</div>	
						
						<div class="catCell">
						
							<input type="hidden" 
								id="WbuiltWorkId<?php echo $i; ?>"
								name="WbuiltWorkId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['builtWorkId'.$i] : ''; ?>">
						
						</div>
					
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->

				<!-- Built Work 2 -->
				
				<div class="catRowWrapper" style="position: relative;">
				
					<div class="catRowTitle"></div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="WbuiltWorkType<?php echo $i; ?>" 
								name="WbuiltWorkType<?php echo $i; ?>" 
								title="Location type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['work']['builtWorkType'.$i]) && $_SESSION['work']['builtWorkType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Type -</option>
								
								<option id="creation" value="Creation" <?php echo(isset($_SESSION['work']['builtWorkType'.$i]) && $_SESSION['work']['builtWorkType'.$i] == "Creation") ? 'selected="selected"' : "" ;?>>Creation</option>
								
								<option id="discovery" value="Discovery" <?php echo(isset($_SESSION['work']['builtWorkType'.$i]) && $_SESSION['work']['builtWorkType'.$i] == "Discovery") ? 'selected="selected"' : "" ;?>>Discovery</option>
								
								<option id="exhibition" value="Exhibition" <?php echo(isset($_SESSION['work']['builtWorkType'.$i]) && $_SESSION['work']['builtWorkType'.$i] == "Exhibition") ? 'selected="selected"' : "" ;?>>Exhibition</option>
								
								<option id="formerOwner" value="Former owner" <?php echo(isset($_SESSION['work']['builtWorkType'.$i]) && $_SESSION['work']['builtWorkType'.$i] == "Former owner") ? 'selected="selected"' : "" ;?>>Former owner</option>
								
								<option id="formerRepository" value="Former repository" <?php echo(isset($_SESSION['work']['builtWorkType'.$i]) && $_SESSION['work']['builtWorkType'.$i] == "Former repository") ? 'selected="selected"' : "" ;?>>Former repository</option>
								
								<option id="formerSite" value="Former site" <?php echo(isset($_SESSION['work']['builtWorkType'.$i]) && $_SESSION['work']['builtWorkType'.$i] == "Former site") ? 'selected="selected"' : "" ;?>>Former site</option>
								
								<option id="installation" value="Installation" <?php echo(isset($_SESSION['work']['builtWorkType'.$i]) && $_SESSION['work']['builtWorkType'.$i] == "Installation") ? 'selected="selected"' : "" ;?>>Installation</option>
								
								<option id="intended" value="Intended" <?php echo(isset($_SESSION['work']['builtWorkType'.$i]) && $_SESSION['work']['builtWorkType'.$i] == "Intended") ? 'selected="selected"' : "" ;?>>Intended</option>
								
								<option id="owner" value="Owner" <?php echo(isset($_SESSION['work']['builtWorkType'.$i]) && $_SESSION['work']['builtWorkType'.$i] == "Owner") ? 'selected="selected"' : "" ;?>>Owner</option>
								
								<option id="performance" value="Performance" <?php echo(isset($_SESSION['work']['builtWorkType'.$i]) && $_SESSION['work']['builtWorkType'.$i] == "Performance") ? 'selected="selected"' : "" ;?>>Performance</option>
								
								<option id="publication" value="Publication" <?php echo(isset($_SESSION['work']['builtWorkType'.$i]) && $_SESSION['work']['builtWorkType'.$i] == "Publication") ? 'selected="selected"' : "" ;?>>Publication</option>
								
								<option id="repository" value="Repository" <?php echo(isset($_SESSION['work']['builtWorkType'.$i]) && $_SESSION['work']['builtWorkType'.$i] == "Repository") ? 'selected="selected"' : "" ;?>>Repository</option>
								
								<option id="site" value="Site" <?php echo(isset($_SESSION['work']['builtWorkType'.$i]) && $_SESSION['work']['builtWorkType'.$i] == "Site") ? 'selected="selected"' : "" ;?>>Site</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['work']['builtWorkType'.$i]) && $_SESSION['work']['builtWorkType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
							
							</select>
						
						</div>

						<div class="catCell">
						
							<select id="WbuiltWorkNameType<?php echo $i; ?>" 
								name="WbuiltWorkNameType<?php echo $i; ?>" 
								title="Location name type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['work']['builtWorkNameType'.$i]) && $_SESSION['work']['builtWorkNameType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Name Type -</option>
								
								<option id="corporate" value="Corporate" <?php echo(isset($_SESSION['work']['builtWorkNameType'.$i]) && $_SESSION['work']['builtWorkNameType'.$i] == "Corporate") ? 'selected="selected"' : "" ;?>>Corporate</option>
								
								<option id="geographic" value="Geographic" <?php echo(isset($_SESSION['work']['builtWorkNameType'.$i]) && $_SESSION['work']['builtWorkNameType'.$i] == "Geographic") ? 'selected="selected"' : "" ;?>>Geographic</option>
								
								<option id="personal" value="Personal" <?php echo(isset($_SESSION['work']['builtWorkNameType'.$i]) && $_SESSION['work']['builtWorkNameType'.$i] == "Personal") ? 'selected="selected"' : "" ;?>>Personal</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['work']['builtWorkNameType'.$i]) && $_SESSION['work']['builtWorkNameType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
							
							</select>
						
						</div>
							
					</div> <!-- catCellWrapper -->
						
				</div> <!-- catRowWrapper -->
			
			</div>
		
			<?php $i++; } ?>
			
		</div> <!-- catSectionWrapper -->

		<!-- Related Works -->

		<div class="catSectionWrapper  workSection">
		
			<?php
	
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'relationType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) {
			
			?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Related Works</div>

						<input type="hidden"
							id="WrelationDisplay<?php echo $i; ?>"
							class="cat_display"
							name="WrelationDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['work']['relationDisplay'.$i])) ? $_SESSION['work']['relationDisplay'.$i] : '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
					
							<select id="WrelationType<?php echo $i; ?>"
								name="WrelationType<?php echo $i; ?>" 
								title="relationType">	
				
								<option id="blank" value="" <?php selectedOption($_SESSION['work']['relationType'.$i], ''); ?>>- Type -</option>
								
								<option id="relatedTo" value="relatedTo" <?php selectedOption($_SESSION['work']['relationType'.$i], 'relatedTo'); ?>>Related to</option>
								
								<option id="partOf" value="partOf" <?php selectedOption($_SESSION['work']['relationType'.$i], 'partOf'); ?>>Part of</option>
								
								<option id="formerlyPartOf" value="formerlyPartOf" <?php selectedOption($_SESSION['work']['relationType'.$i], 'formerlyPartOf'); ?>>Formerly part of</option>
								
								<option id="componentOf" value="componentOf" <?php selectedOption($_SESSION['work']['relationType'.$i], 'componentOf'); ?>>Component of</option>

								<option id="partnerInSetWith" value="partnerInSetWith" <?php selectedOption($_SESSION['work']['relationType'.$i], 'partnerInSetWith'); ?>>Partner in set with</option>

								<option id="preparatoryFor" value="preparatoryFor" <?php selectedOption($_SESSION['work']['relationType'.$i], 'preparatoryFor'); ?>>Preparatory for</option>
								
								<option id="studyFor" value="studyFor" <?php selectedOption($_SESSION['work']['relationType'.$i], 'studyFor'); ?>>Study for</option>
								
								<option id="cartoonFor" value="cartoonFor" <?php selectedOption($_SESSION['work']['relationType'.$i], 'cartoonFor'); ?>>Cartoon for</option>
								
								<option id="modelFor" value="modelFor" <?php selectedOption($_SESSION['work']['relationType'.$i], 'modelFor'); ?>>Model for</option>
								
								<option id="planFor" value="planFor" <?php selectedOption($_SESSION['work']['relationType'.$i], 'planFor'); ?>>Plan for</option>
								
								<option id="counterProofFor" value="counterProofFor" <?php selectedOption($_SESSION['work']['relationType'.$i], 'counterProofFor'); ?>>Counter proof for</option>
								
								<option id="printingPlateFor" value="printingPlateFor" <?php selectedOption($_SESSION['work']['relationType'.$i], 'printingPlateFor'); ?>>Printing plate for</option>
								
								<option id="reliefFor" value="reliefFor" <?php selectedOption($_SESSION['work']['relationType'.$i], 'reliefFor'); ?>>Relief for</option>
								
								<option id="prototypeFor" value="prototypeFor" <?php selectedOption($_SESSION['work']['relationType'.$i], 'prototypeFor'); ?>>Prototype for</option>

								<option id="designedFor" value="designedFor" <?php selectedOption($_SESSION['work']['relationType'.$i], 'designedFor'); ?>>Designed for</option>

								<option id="mateOf" value="mateOf" <?php selectedOption($_SESSION['work']['relationType'.$i], 'mateOf'); ?>>Mate of</option>

								<option id="pendantOf" value="pendantOf" <?php selectedOption($_SESSION['work']['relationType'.$i], 'pendantOf'); ?>>Pendant of</option>

								<option id="exhibitedAt" value="exhibitedAt" <?php selectedOption($_SESSION['work']['relationType'.$i], 'exhibitedAt'); ?>>Exhibited at</option>

								<option id="copyAfter" value="copyAfter" <?php selectedOption($_SESSION['work']['relationType'.$i], 'copyAfter'); ?>>Copy after</option>

								<option id="depicts" value="depicts" <?php selectedOption($_SESSION['work']['relationType'.$i], 'depicts'); ?>>Depicts</option>

								<option id="derivedFrom" value="derivedFrom" <?php selectedOption($_SESSION['work']['relationType'.$i], 'derivedFrom'); ?>>Derived from</option>

								<option id="facsimileOf" value="facsimileOf" <?php selectedOption($_SESSION['work']['relationType'.$i], 'facsimileOf'); ?>>Facsimile of</option>

								<option id="replicaOf" value="replicaOf" <?php selectedOption($_SESSION['work']['relationType'.$i], 'replicaOf'); ?>>Replica of</option>

								<option id="versionOf" value="versionOf" <?php selectedOption($_SESSION['work']['relationType'.$i], 'versionOf'); ?>>Version of</option>
								
								<option id="largerContextFor" value="largerContextFor" <?php selectedOption($_SESSION['work']['relationType'.$i], 'largerContextFor'); ?>>Larger Context For</option>

								<option id="formerlyLargerContextFor" value="formerlyLargerContextFor" <?php selectedOption($_SESSION['work']['relationType'.$i], 'formerlyLargerContextFor'); ?>>Formerly Larger Context For</option>
								
								<option id="componentIs" value="componentIs" <?php selectedOption($_SESSION['work']['relationType'.$i], 'componentIs'); ?>>Component Is</option>

								<option id="basedOn" value="basedOn" <?php selectedOption($_SESSION['work']['relationType'.$i], 'basedOn'); ?>>Based On</option>
								
								<option id="studyIs" value="studyIs" <?php selectedOption($_SESSION['work']['relationType'.$i], 'studyIs'); ?>>Study Is</option>

								<option id="cartoonIs" value="cartoonIs" <?php selectedOption($_SESSION['work']['relationType'.$i], 'cartoonIs'); ?>>Cartoon Is</option>
								
								<option id="modelIs" value="modelIs" <?php selectedOption($_SESSION['work']['relationType'.$i], 'modelIs'); ?>>Model Is</option>

								<option id="planIs" value="planIs" <?php selectedOption($_SESSION['work']['relationType'.$i], 'planIs'); ?>>Plan Is</option>
								
								<option id="counterProofIs" value="counterProofIs" <?php selectedOption($_SESSION['work']['relationType'.$i], 'counterProofIs'); ?>>Counter Proof Is</option>

								<option id="printingPlateIs" value="printingPlateIs" <?php selectedOption($_SESSION['work']['relationType'.$i], 'printingPlateIs'); ?>>Printing Plate Is</option>
								
								<option id="impressionIs" value="impressionIs" <?php selectedOption($_SESSION['work']['relationType'.$i], 'impressionIs'); ?>>Impression Is</option>

								<option id="prototypeIs" value="prototypeIs" <?php selectedOption($_SESSION['work']['relationType'.$i], 'prototypeIs'); ?>>Prototype Is</option>
								
								<option id="contextIs" value="contextIs" <?php selectedOption($_SESSION['work']['relationType'.$i], 'contextIs'); ?>>Context Is</option>

								<option id="venueFor" value="venueFor" <?php selectedOption($_SESSION['work']['relationType'.$i], 'venueFor'); ?>>Venue For</option>
								
								<option id="copyIs" value="copyIs" <?php selectedOption($_SESSION['work']['relationType'.$i], 'copyIs'); ?>>Copy Is</option>

								<option id="depictedIn" value="depictedIn" <?php selectedOption($_SESSION['work']['relationType'.$i], 'depictedIn'); ?>>Depicted In</option>
								
								<option id="sourceFor" value="sourceFor" <?php selectedOption($_SESSION['work']['relationType'.$i], 'sourceFor'); ?>>Source For</option>

								<option id="facsimileIs" value="facsimileIs" <?php selectedOption($_SESSION['work']['relationType'.$i], 'facsimileIs'); ?>>Facsimile Is</option>
								
								<option id="relplicaIs" value="relplicaIs" <?php selectedOption($_SESSION['work']['relationType'.$i], 'relplicaIs'); ?>>Replica Is</option>

								<option id="versionIs" value="versionIs" <?php selectedOption($_SESSION['work']['relationType'.$i], 'versionIs'); ?>>Version Is</option>
								
								<option id="imageIs" value="imageIs" <?php selectedOption($_SESSION['work']['relationType'.$i], 'imageIs'); ?>>Image Is</option>
			
							</select>
							
						</div>
		
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
		
				</div> <!-- catRowWrapper -->

						<div id="relationSearch" class="catRowWrapper" style="height: auto;">
				
							<div id="workAssoc_wrapper">
							
								<div id="workAssoc_searchFields">

									<p>Search existing works:</p>

									<input type="text" 
									id = "WsearchTitle<?php echo $i; ?>"
									name="WsearchTitle<?php echo $i; ?>"
									placeholder="Title">
									
									<br />

									<input type="text" 
									id = "WsearchAgent<?php echo $i; ?>"
									name="WsearchAgent<?php echo $i; ?>"
									placeholder="Agent">

									<br />
									
									<input type="button"
									id="WrelationSearch_submitButton<?php echo $i; ?>"
									name="WrelationSearch_submitButton<?php echo $i; ?>"
									value="Search">

								</div>

							</div>


				</div> <!-- catRowWrapper -->
				
				<?php 

				if (!empty($_SESSION['work']['relatedTo'.$i])) { ?>

						<div id="WshowRelatedTo<?php echo $i; ?>" class="catRowWrapper" style="height: auto; padding-top: 3px;">
									
							<div class="workAssoc_results_row" id="relationAsoc_results_row">
									
								<!--
								Preview thumbnail
								-->
								<?php 
								$relatedImageSrc = $image_dir.'/thumb/'.$_SESSION['work']['relationImage'.$i].'.jpg';	
								?>
								
								<div class="workAssoc_results_col1">
									<img src="<?php echo $relatedImageSrc; ?>"
									class="relationAssoc_thumb"
									title="Preview this image"
									style="display: inline-block; width: 92px; height: 72px;">
								
									<input type="hidden"
									id = "imageNum<?php echo $i; ?>" 
									name="imageNum<?php echo $i; ?>" 
									value="<?php echo (isset($_SESSION['work']['relationImageId'.$i])) ? $_SESSION['work']['relationImageId'.$i] : ''; ?>">

									<input type="hidden"
									id = "imageView<?php echo $i; ?>" 
									name="imageView<?php echo $i; ?>" 
									value="<?php echo (isset($_SESSION['work']['relationImage'.$i])) ? $_SESSION['work']['relationImage'.$i] : ''; ?>">
								</div>

							<div class="workAssoc_results_col2 defaultCursor">
							
								<!--
									Work title
								-->
								
							<div class="workAssoc_results_cell mediumWeight"
									style="line-height: 1.2em;">

									<?php 
									$relatedTitle = $_SESSION['work']['relationTitle'.$i]; 
									echo '<span title="'.$relatedTitle.'">';
									echo (strlen($relatedTitle) <= 46) 
										? $relatedTitle.'<br>'
										: substr($relatedTitle, 0, 43) . '...<br>';
									echo '</span>';
									?>
								
								</div>

									<!--
									Agent
									-->

								<div class="workAssoc_results_cell">
									<?php
									echo $_SESSION['work']['relationAgent'.$i];
									?>
								</div>	
	
							</div>

						</div> <!-- workAssoc_results_row -->

					</div>					

				<?php }?>
			
				<input type ="hidden"
				id= "WrelatedTo<?php echo $i; ?>"
				name = "WrelatedTo<?php echo $i; ?>"
				value ="<?php echo (isset($_SESSION['work']['relatedTo'.$i])) ? $_SESSION['work']['relatedTo'.$i] : ''; ?>"
				placehoder="Related To">

			</div> <!-- cloneWrap-->
		
			<?php $i++; } ?>

		</div> <!-- catSectionWrapper -->
		
		<!-- State / Edition -->
		
		<div class="catSectionWrapper workSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'stateEditionType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) {
			
			?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Edition</div>
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="WstateEditionType<?php echo $i; ?>" 
								name="WstateEditionType<?php echo $i; ?>" 
								title="State/Edition type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['work']['stateEditionType'.$i]) && $_SESSION['work']['stateEditionType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Type -</option>
								
								<option id="edition" value="Edition" <?php echo(isset($_SESSION['work']['stateEditionType'.$i]) && $_SESSION['work']['stateEditionType'.$i] == "Edition") ? 'selected="selected"' : "" ;?>>Edition</option>
								
								<option id="impression" value="Impression" <?php echo(isset($_SESSION['work']['stateEditionType'.$i]) && $_SESSION['work']['stateEditionType'.$i] == "Impression") ? 'selected="selected"' : "" ;?>>Impression</option>
								
								<option id="state" value="State" <?php echo(isset($_SESSION['work']['stateEditionType'.$i]) && $_SESSION['work']['stateEditionType'.$i] == "State") ? 'selected="selected"' : "" ;?>>State</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['work']['stateEditionType'.$i]) && $_SESSION['work']['stateEditionType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="WstateEdition<?php echo $i; ?>" 
								class="autoWidth"
								name="WstateEdition<?php echo $i; ?>" 
								placeholder="State/Edition"
								value="<?php echo (isset($_SESSION['work']['stateEdition'.$i])) ? $_SESSION['work']['stateEdition'.$i] : ''; ?>" 
								title="State/Edition number">
						
						</div>
					
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->

			</div>
		
			<?php $i++; } ?>
			
		</div> <!-- catSectionWrapper -->
		
		
		<!-- Inscription 1 -->
		
		<div class="catSectionWrapper workSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'inscriptionType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) {
			
			?>

			<div class="clone_wrap">
			
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Inscription</div>

						<input type="hidden"
							id="WinscriptionDisplay<?php echo $i; ?>"
							class="cat_display"
							name="WinscriptionDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['work']['inscriptionDisplay'.$i])) ? $_SESSION['work']['inscriptionDisplay'.$i] : '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="WinscriptionType<?php echo $i; ?>" 
								name="WinscriptionType<?php echo $i; ?>" 
								title="Inscription type">
							
								<option id="blank" value="" <?php selectedOption($_SESSION['work']['inscriptionType'.$i],''); ?>>- Type -</option>
								
								<option id="signature" value="Signature" <?php selectedOption($_SESSION['work']['inscriptionType'.$i],'Signature'); ?>>Signature</option>
								
								<option id="mark" value="Mark" <?php selectedOption($_SESSION['work']['inscriptionType'.$i],'Mark'); ?>>Mark</option>
								
								<option id="caption" value="Caption" <?php selectedOption($_SESSION['work']['inscriptionType'.$i],'Caption'); ?>>Caption</option>
								
								<option id="date" value="Date" <?php selectedOption($_SESSION['work']['inscriptionType'.$i],'Date'); ?>>Date</option>
								
								<option id="text" value="Text" <?php selectedOption($_SESSION['work']['inscriptionType'.$i],'Text'); ?>>Text</option>
								
								<option id="translation" value="Translation" <?php selectedOption($_SESSION['work']['inscriptionType'.$i],'Translation'); ?>>Translation</option>
								
								<option id="other" value="Other" <?php selectedOption($_SESSION['work']['inscriptionType'.$i],'Other'); ?>>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="WworkInscription<?php echo $i; ?>" 
								class="autoWidth"
								name="WworkInscription<?php echo $i; ?>" 
								placeholder="Inscription text"
								value="<?php echo htmlspecialchars($_SESSION['work']['workInscription'.$i]); ?>" 
								maxlength="500">
						
						</div>
					
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->
				
				<!-- Inscription 2 -->
				
				<div class="catRowWrapper">
				
					<div class="catRowTitle"></div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="WworkInscriptionAuthor<?php echo $i; ?>" 
								name="WworkInscriptionAuthor<?php echo $i; ?>" 
								value="<?php echo htmlspecialchars($_SESSION['work']['workInscriptionAuthor'.$i]); ?>" 
								maxlength="500"
								style="width: 120px;"
								placeholder="Inscription author">
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="WworkInscriptionLocation<?php echo $i; ?>" 
								name="WworkInscriptionLocation<?php echo $i; ?>" 
								value="<?php echo htmlspecialchars($_SESSION['work']['workInscriptionLocation'.$i]); ?>" 
								maxlength="500" 
								placeholder="Inscription location">
						
						</div>
						
					</div> <!-- catCellWrapper -->
				
				</div> <!-- catRowWrapper -->

			</div>
		
			<?php $i++; } ?>
		
		</div> <!-- catSectionWrapper -->

				<!-- Subject -->

		<div id="workSubject_section" class="catSectionWrapper workSection">
		
			<?php
		
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'subjectType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) {
			
			?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Subject</div>

						<input type="hidden"
							id="WsubjectDisplay<?php echo $i; ?>"
							class="cat_display"
							name="WsubjectDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['work']['subjectDisplay'.$i])) ? $_SESSION['work']['subjectDisplay'.$i] : '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="WsubjectType<?php echo $i; ?>" 
								name="WsubjectType<?php echo $i; ?>"
								title="Subject type">
							
								<option id="blank" value="" <?php selectedOption($_SESSION['work']['subjectType'.$i], ''); ?>>- Type -</option>
								
								<option id="conceptTopic" value="Topic: concept" <?php selectedOption($_SESSION['work']['subjectType'.$i], 'Topic: concept'); ?>>Topic: concept</option>
								
								<option id="descriptiveTopic" value="Topic: descriptive" <?php selectedOption($_SESSION['work']['subjectType'.$i], 'Topic: descriptive'); ?>>Topic: descriptive</option>
								
								<option id="iconographicTopic" value="Topic: iconographic" <?php selectedOption($_SESSION['work']['subjectType'.$i], 'Topic: iconographic'); ?>>Topic: iconographic</option>
								
								<option id="otherTopic" value="Topic: other" <?php selectedOption($_SESSION['work']['subjectType'.$i], 'Topic: other'); ?>>Topic: other</option>
								
								<option id="builtworkPlace" value="Place: built work" <?php selectedOption($_SESSION['work']['subjectType'.$i], 'Place: built work'); ?>>Place: built work</option>
								
								<option id="geographicPlace" value="Place: geographic" <?php selectedOption($_SESSION['work']['subjectType'.$i], 'Place: geographic'); ?>>Place: geographic</option>
								
								<option id="otherPlace" value="Place: other" <?php selectedOption($_SESSION['work']['subjectType'.$i], 'Place: other'); ?>>Place: other</option>
								
								<option id="corporateName" value="Name: corporate" <?php selectedOption($_SESSION['work']['subjectType'.$i], 'Name: corporate'); ?>>Name: corporate</option>
								
								<option id="personalName" value="Name: personal" <?php selectedOption($_SESSION['work']['subjectType'.$i], 'Name: personal'); ?>>Name: personal</option>
								
								<option id="scientificName" value="Name: scientific" <?php selectedOption($_SESSION['work']['subjectType'.$i], 'Name: scientific'); ?>>Name: scientific</option>
								
								<option id="familyName" value="Name: family" <?php selectedOption($_SESSION['work']['subjectType'.$i], 'Name: family'); ?>>Name: family</option>
								
								<option id="otherName" value="Name: other" <?php selectedOption($_SESSION['work']['subjectType'.$i], 'Name: other'); ?>>Name: other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="Wsubject<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="Wsubject<?php echo $i; ?>" 
								placeholder="Subject"
								value="<?php echo $_SESSION['work']['subject'.$i];?>" 
								maxlength="500">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="WsubjectId<?php echo $i; ?>"
								name="WsubjectId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['work'])) ? $_SESSION['work']['subjectId'.$i] : ''; ?>">
						
						</div>
					
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->

			</div>
		
			<?php $i++; } ?>
		
		</div> <!-- catSectionWrapper -->

		<!-- Description -->
		
		<div class="catSectionWrapper workSection" style="padding-top: 4px; padding-bottom: 0;">
		
			<div class="catRowWrapper" style="height: 150px; position: relative;">
			
				<div class="catCellWrapper">
				
					<div class="catCell">
					
						<textarea id="Wdescription" 
							class="fixedWidth" 
							rows="2" 
							name="Wdescription0" 
							placeholder="Description"
							style="height: 140px; overflow: hidden;"
							><?php echo (isset($_SESSION['work']['description0'])) ? htmlspecialchars($_SESSION['work']['description0']) : ''; ?></textarea>
					
					</div>
				
				</div> <!-- catCellWrapper -->
			
			</div> <!-- catRowWrapper -->
			
		</div> <!-- catSectionWrapper -->
		
		<!-- Rights 1 -->
		
		<div class="catSectionWrapper workSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'rightsType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) {
			
			?>

			<div class="clone_wrap">
			
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Rights</div>
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="WrightsType<?php echo $i; ?>" 
								name="WrightsType<?php echo $i; ?>" 
								title="Rights type">
							
								<option id="blank" value="" <?php selectedOption($_SESSION['work']['rightsType'.$i], ''); ?>>- Type -</option>
								
								<option id="copyrighted" value="Copyrighted" <?php selectedOption($_SESSION['work']['rightsType'.$i], 'Copyrighted'); ?>>Copyrighted</option>
								
								<option id="publicDomain" value="Public domain" <?php selectedOption($_SESSION['work']['rightsType'.$i], 'Public domain'); ?>>Public domain</option>
								
								<option id="undetermined" value="Undetermined" <?php selectedOption($_SESSION['work']['rightsType'.$i], 'Undetermined'); ?>>Undetermined</option>
								
								<option id="other" value="Other" <?php selectedOption($_SESSION['work']['rightsType'.$i], 'Other'); ?>>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="WrightsHolder<?php echo $i; ?>" 
								class="autoWidth"
								name="WrightsHolder<?php echo $i; ?>" 
								value="<?php echo htmlspecialchars($_SESSION['work']['rightsHolder'.$i]); ?>" 
								maxlength="500"
								placeholder="Rights holder">
						
						</div>
					
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->
				
				<!-- Rights 2 -->
				
				<div class="catRowWrapper">
				
					<div class="catRowTitle"></div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="WrightsText<?php echo $i; ?>" 
								class="autoWidth"
								name="WrightsText<?php echo $i; ?>" 
								value="<?php echo htmlspecialchars($_SESSION['work']['rightsText'.$i]); ?>" 
								maxlength="500"
								placeholder="Rights text">
						
						</div>
					
					</div> <!-- catCellWrapper -->
				
				</div> <!-- catRowWrapper -->

			</div>
			
			<?php $i++; } ?>
		
		</div> <!-- catSectionWrapper -->
	
		<!-- Source 1 -->
		
		<div class="catSectionWrapper workSection"
			style="border-bottom: none;">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['work'] as $key=>$value) {
				if (startsWith($key, 'sourceNameType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) {
			
			?>

			<div class="clone_wrap">
			
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Source</div>
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="WsourceNameType<?php echo $i; ?>" 
								name="WsourceNameType<?php echo $i; ?>" 
								title="Source name type">
							
								<option id="blank" value="" <?php selectedOption($_SESSION['work']['sourceNameType'.$i], ''); ?>>- Name Type -</option>
								
								<option id="book" value="Book" <?php selectedOption($_SESSION['work']['sourceNameType'.$i], 'Book'); ?>>Book</option>
								
								<option id="catalogue" value="Catalogue" <?php selectedOption($_SESSION['work']['sourceNameType'.$i], 'Catalogue'); ?>>Catalogue</option>
								
								<option id="corpus" value="Corpus" <?php selectedOption($_SESSION['work']['sourceNameType'.$i], 'Corpus'); ?>>Corpus</option>
								
								<option id="donor" value="Donor" <?php selectedOption($_SESSION['work']['sourceNameType'.$i], 'Donor'); ?>>Donor</option>
								
								<option id="electronic" value="Electronic" <?php selectedOption($_SESSION['work']['sourceNameType'.$i], 'Electronic'); ?>>Electronic</option>
								
								<option id="serial" value="Serial" <?php selectedOption($_SESSION['work']['sourceNameType'.$i], 'Serial'); ?>>Serial</option>
								
								<option id="vendor" value="Vendor" <?php selectedOption($_SESSION['work']['sourceNameType'.$i], 'Vendor'); ?>>Vendor</option>
								
								<option id="other" value="Other" <?php selectedOption($_SESSION['work']['sourceNameType'.$i], 'Other'); ?>>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="WsourceName<?php echo $i; ?>" 
								class="autoWidth"
								name="WsourceName<?php echo $i; ?>" 
								value="<?php echo htmlspecialchars($_SESSION['work']['sourceName'.$i]); ?>" 
								maxlength="500" 
								placeholder="Source name">
						
						</div>
					
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
					
				</div> <!-- catRowWrapper -->
			
				
				<!-- Source 2 -->
					
				<div class="catRowWrapper">
					
					<div class="catRowTitle roundBottomLeft"></div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="WsourceType<?php echo $i; ?>" 
								name="WsourceType<?php echo $i; ?>" 
								title="Source type">
							
								<option id="blank" value="" <?php selectedOption($_SESSION['work']['sourceType'.$i], ''); ?>>- Type -</option>
								
								<option id="citation" value="Citation" <?php selectedOption($_SESSION['work']['sourceType'.$i], 'Citation'); ?>>Citation</option>
								
								<option id="ISBN" value="ISBN" <?php selectedOption($_SESSION['work']['sourceType'.$i], 'ISBN'); ?>>ISBN</option>
								
								<option id="ISSN" value="ISSN" <?php selectedOption($_SESSION['work']['sourceType'.$i], 'ISSN'); ?>>ISSN</option>
								
								<option id="ASIN" value="ASIN" <?php selectedOption($_SESSION['work']['sourceType'.$i], 'ASIN'); ?>>ASIN</option>
								
								<option id="openURL" value="Open URL" <?php selectedOption($_SESSION['work']['sourceType'.$i], 'Open URL'); ?>>Open URL</option>
								
								<option id="URI" value="URI" <?php selectedOption($_SESSION['work']['sourceType'.$i], 'URI'); ?>>URI</option>
								
								<option id="vendor" value="Vendor" <?php selectedOption($_SESSION['work']['sourceType'.$i], 'Vendor'); ?>>Vendor</option>
								
								<option id="other" value="Other" <?php selectedOption($_SESSION['work']['sourceType'.$i], 'Other'); ?>>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="Wsource<?php echo $i; ?>" 
								class="autoWidth"
								name="Wsource<?php echo $i; ?>" 
								value="<?php echo htmlspecialchars($_SESSION['work']['source'.$i]); ?>" 
								maxlength="500" 
								placeholder="Source text">
						
						</div>
					
					</div> <!-- catCellWrapper -->
				
				</div> <!-- catRowWrapper -->

			</div>
			
			<?php $i++; } ?>
	 
		</div> <!-- catSectionWrapper -->

	</div> <!-- catFormWrapper -->

	<div style="margin-top: 10px;">
		
		<button type="button"
			class="catalogUI_clear inline"
			name="clearForm">Reset All</button>

	</div>

	<p class="clear"></p>
	
</div> <!-- cataloguingPane -->

<script>

	// Display only the appropriate measurement fields
	$('div#work_module select[id*=measurementType]')
		.each(displayMeasurements);
	$('div#work_module select[id*=measurementType]')
		.change(displayMeasurements);

	// Add & Remove cataloging rows
	$('div#work_module div.addButton').click(addRow_v2);
	$('div#work_module div.removeButton').click(removeRow_v2);

	catalogUI_prepFields();
	catalogUI_prepAddRemove();
	authorityIndicators();

	// Perform authority search
	$('div#work_module input.authoritySearch').keyup(debounce(
		function()
		{
			var term = $(this).val();

			if (term.length > 2 && $.trim(term) != '') 
			{
				var fieldName = $(this).attr('name');

				var nearbyAuthorityFieldName = 
					$(this).parent('div.catRowWrapper')
						.find('input[type=hidden]')
						.attr('name');

				catalogUI_searchAuthority(fieldName, nearbyAuthorityFieldName);

				$('form#catalog_form input').not(this).focus(
					function()
					{
						$('div.resultsWrapper').remove();
					});
			}
		}, 1000));

	// Toggle date range
	$('div#work_module input[type=checkbox][id*=dateRange]').click(
		function() 
		{
			var endDate = 
				$(this).parents('div#work_module div.catRowWrapper')
					.next('div.catRowWrapper')
					.find('div[id*=dateRangeSpan]');

			endDate.toggle();
		});

	// Show/hide date range on load
	$('div#work_module input[type=checkbox][id*=dateRange]')
		.each(catalogUI_dateRange_onLoad);

	$('div#work_module input.autoWidth').each(autoWidth);

	//Show and Toggle specific location row and fields
	$('select[id*=specificLocationType]').each(displaySpecificLocation);
	$('select[id*=specificLocationType]').change(displaySpecificLocation);

	// Adapt cataloging UI to the width of the browser window
	$(window).resize(
		function()
		{
			$('div#work_module input.autoWidth').each(autoWidth);
		});


	//Image viewer for related works
	$('img.relationAssoc_thumb').click(function(){
		var imageView = $(this).parent('div').find('input[name*=imageView]').val();
		image_viewer(imageView);	
	});

	//View related work record
	$('div.workAssoc_results_row').hover(
		function()
		{
			$(this).addClass('row_highlight');
		}, 
		function()
		{
			$(this).removeClass('row_highlight');
		});


   $('div.workAssoc_results_col2').click(function(event){
   	var workNum= $(this).parents('div.clone_wrap').find('input[name*=imageNum]').val();
   	view_relation_work_record(workNum);
   });

	//Hide the related works search/results and fill row
	$('div#work_module div[id=relationSearch]').hide();
	$('div#work_module select[id*=relationType]').change(displayRelationSearch);

	// SEARCH FOR RELATED WORK RECORDS (taken from work association)
	$('div#work_module input[id*=relationSearch_submitButton]').click(function(){
		var titleTerm = $(this).parent('div').find('input[id*=searchTitle]').val();
		var agentTerm = $(this).parent('div').find('input[id*=searchAgent]').val();
		var module = $(this).closest('div#workAssoc_wrapper');
		relationAssoc_search(titleTerm, agentTerm, module);

	});
	
	$('div#work_module div#workAssoc_searchFields input').keypress(function(e){
		if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)){
		var titleTerm = $(this).parent('div').find('input[id*=searchTitle]').val();
		var agentTerm = $(this).parent('div').find('input[id*=searchAgent]').val();
		var module = $(this).closest('div#workAssoc_wrapper');
		relationAssoc_search(titleTerm, agentTerm, module);
		}
	});

	// RESET ALL FIELDS
	$('div#work_module button.catalogUI_clear')
		.click(promptToConfirm)
		.click(
			function()
			{
				$('button#conf_button')
					.click(
						function()
						{
							catalogUI_clearFields('work');
						});
			});

	//Bind authority search color indicators
	$('div#work_module').click(authorityIndicators);


	// TOGGLE DATA DISPLAY
	$('#work_module .catRowTitle .titleText')
		.click(
			function()
			{
				var $disp = $(this).next('input.cat_display');
				var $status = $disp.val();
				// console.log('Old display status: '+$status); // Debug

				if ($status == '1') {
					$disp.val('0');
					$(this).addClass('ital lightGrey');
				}

				if ($status == '0') {
					$disp.val('1');
					$(this).removeClass('ital lightGrey');
				}
			});

</script>