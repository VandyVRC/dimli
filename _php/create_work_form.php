<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../_php/_config/session.php');
require_once(MAIN_DIR.'/../_php/_config/connection.php');
require_once(MAIN_DIR.'/../_php/_config/functions.php');

confirm_logged_in(); 
require_priv('priv_catalog');

if (!isset($_SESSION['createNewWork']))
{
	$_SESSION['createNewWork'] = array();
	
	$_SESSION['createNewWork']['titleType0'] = $NWtitle[0]['titleType'] =
	$_SESSION['createNewWork']['title0'] = $NWtitle[0]['title'] =
	$_SESSION['createNewWork']['agentAttribution0'] = $NWagent[0]['agentAttribution'] =
	$_SESSION['createNewWork']['agent0'] = $NWagent[0]['agent'] =
	$_SESSION['createNewWork']['agentType0'] = $NWagent[0]['agentType'] =
	$_SESSION['createNewWork']['agentRole0'] = $NWagent[0]['agentRole'] =
	$_SESSION['createNewWork']['agentId0'] = $NWagent[0]['agentId'] =
	$_SESSION['createNewWork']['dateType0'] = $NWdate[0]['dateType'] =
	$_SESSION['createNewWork']['dateRange0'] = $NWdate[0]['dateRange'] =
	$_SESSION['createNewWork']['circaDate0'] = $NWdate[0]['circaDate'] =
	$_SESSION['createNewWork']['startDate0'] = $NWdate[0]['startDate'] =
	$_SESSION['createNewWork']['startDateEra0'] = $NWdate[0]['startDateEra'] =
	$_SESSION['createNewWork']['endDate0'] = $NWdate[0]['endDate'] =
	$_SESSION['createNewWork']['endDateEra0'] = $NWdate[0]['endDateEra'] =
	$_SESSION['createNewWork']['materialType0'] = $NWmaterial[0]['materialType'] =
	$_SESSION['createNewWork']['material0'] = $NWmaterial[0]['material'] =
	$_SESSION['createNewWork']['materialId0'] = $NWmaterial[0]['materialId'] =
	$_SESSION['createNewWork']['technique0'] = $NWtechnique[0]['technique'] =
	$_SESSION['createNewWork']['techniqueId0'] = $NWtechnique[0]['techniqueId'] =
	$_SESSION['createNewWork']['workType0'] = $NWworkType[0]['workType'] =
	$_SESSION['createNewWork']['workTypeId0'] = $NWworkType[0]['workTypeId'] =	
	$_SESSION['createNewWork']['measurementType0'] = $NWmeasurements[0]['measurementType'] =
	$_SESSION['createNewWork']['measurementField1_0'] = $NWmeasurements[0]['measurementField1_'] =
	$_SESSION['createNewWork']['commonMeasurementList1_0'] = $NWmeasurements[0]['commonMeasurementList1_'] =
	$_SESSION['createNewWork']['measurementField2_0'] = $NWmeasurements[0]['measurementField2_'] =
	$_SESSION['createNewWork']['commonMeasurementList2_0'] = $NWmeasurements[0]['commonMeasurementList2_'] =
	$_SESSION['createNewWork']['inchesValue0'] = $NWmeasurements[0]['inchesValue'] =
	$_SESSION['createNewWork']['areaMeasurementList0'] = $NWmeasurements[0]['areaMeasurementList'] =
	$_SESSION['createNewWork']['days0'] = $NWmeasurementDisplayasurements[0]['days'] =
	$_SESSION['createNewWork']['hours0'] = $NWmeasurements[0]['hours'] =
	$_SESSION['createNewWork']['minutes0'] = $NWmeasurements[0]['minutes'] =
	$_SESSION['createNewWork']['seconds0'] = $NWmeasurements[0]['seconds'] =
	$_SESSION['createNewWork']['fileSize0'] = $NWmeasurements[0]['fileSize'] =
	$_SESSION['createNewWork']['resolutionWidth0'] = $NWmeasurements[0]['resolutionWidth'] =
	$_SESSION['createNewWork']['resolutionHeight0'] = $NWmeasurements[0]['resolutionHeight'] =
	$_SESSION['createNewWork']['weightUnit0'] = $NWmeasurements[0]['weightUnit'] =
	$_SESSION['createNewWork']['otherMeasurementDescription0'] = $NWmeasurements[0]['otherMeasurementDescription'] =
	$_SESSION['createNewWork']['culturalContext0'] = $NWculturalContext[0]['culturalContext'] =
	$_SESSION['createNewWork']['culturalContextId0'] = $NWculturalContext[0]['culturalContextId'] =
	$_SESSION['createNewWork']['stylePeriod0'] = $NWstylePeriod[0]['stylePeriod'] =
	$_SESSION['createNewWork']['stylePeriodId0'] = $NWstylePeriod[0]['stylePeriodId'] =
	$_SESSION['createNewWork']['location0'] = $NWlocation[0]['location'] =
	$_SESSION['createNewWork']['locationId0'] = $NWlocation[0]['locationId'] =
	$_SESSION['createNewWork']['locationNameType0'] = $NWlocation[0]['locationNameType'] =
	$_SESSION['createNewWork']['locationType0'] = $NWlocation[0]['locationType'] =
	$_SESSION['createNewWork']['specificLocationType0'] = $NWspecificLocation[0]['specificLocationType'] =
	$_SESSION['createNewWork']['specificLocationAddress0'] = $NWspecificLocation[0]['specificLocationAddress'] =
	$_SESSION['createNewWork']['specificLocationZip0'] = $NWspecificLocation[0]['specificLocationZip'] =
	$_SESSION['createNewWork']['specificLocationLat0'] = $NWspecificLocation[0]['specificLocationLat'] =
	$_SESSION['createNewWork']['specificLocationLong0'] = $NWspecificLocation[0]['specificLocationLong'] =
	$_SESSION['createNewWork']['specificLocationNote0'] = $NWspecificLocation[0]['specificLocationNote'] =
	$_SESSION['createNewWork']['builtWork0'] = $NWbuiltWork[0]['builtWork'] =
	$_SESSION['createNewWork']['builtWorkId0'] = $NWbuiltWork[0]['builtWorkId'] =
	$_SESSION['createNewWork']['builtWorkNameType0'] = $NWbuiltWork[0]['builtWorkNameType'] =
	$_SESSION['createNewWork']['builtWorkType0'] = $NWbuiltWork[0]['builtWorkType'] =
	$_SESSION['createNewWork']['relationType0'] = $NWrelation[0]['relationType'] =
	$_SESSION['createNewWork']['relatedTo0'] = $NWrelation[0]['relatedTo'] =
	$_SESSION['createNewWork']['relationImageId0'] = $NWrelation[0]['relationImageId'] =
	$_SESSION['createNewWork']['relationImage0'] = $NWrelation[0]['relationImage'] =
	$_SESSION['createNewWork']['relationTitle0'] = $NWrelation[0]['relationTitle'] =
	$_SESSION['createNewWork']['relationAgent0'] = $NWrelation[0]['relationAgent'] =
	$_SESSION['createNewWork']['stateEditionType0'] = $NWstateEdition[0]['stateEditionType'] =
	$_SESSION['createNewWork']['stateEdition0'] = $NWstateEdition[0]['stateEdition'] =
	$_SESSION['createNewWork']['inscriptionType0'] = $NWinscription[0]['inscriptionType'] =
	$_SESSION['createNewWork']['workInscription0'] = $NWinscription[0]['workInscription'] =
	$_SESSION['createNewWork']['workInscriptionAuthor0'] = $NWinscription[0]['workInscriptionAuthor'] =
	$_SESSION['createNewWork']['workInscriptionLocation0'] = $NWinscription[0]['workInscriptionLocation'] =
	$_SESSION['createNewWork']['subjectType0'] = $NWsubject[0]['subjectType'] =
	$_SESSION['createNewWork']['subject0'] = $NWsubject[0]['subject'] =
	$_SESSION['createNewWork']['subjectId0'] = $NWsubject[0]['subjectId'] =
	$_SESSION['createNewWork']['description0'] = $NWdescription =
	$_SESSION['createNewWork']['rightsType0'] = $NWrights[0]['rightsType'] =
	$_SESSION['createNewWork']['rightsHolder0'] = $NWrights[0]['rightsHolder'] =
	$_SESSION['createNewWork']['rightsText0'] = $NWrights[0]['rightsText'] =
	$_SESSION['createNewWork']['sourceNameType0'] = $NWsource[0]['sourceNameType'] =
	$_SESSION['createNewWork']['sourceName0'] = $NWsource[0]['sourceName'] =
	$_SESSION['createNewWork']['sourceType0'] = $NWsource[0]['sourceType'] =
	$_SESSION['createNewWork']['source0'] = $NWsource[0]['source'] =
	$_SESSION['createNewWork']['updated'] = '';
}

?>

<div class="cataloguingPane" style="position: relative;">
	
	<div class="catFormWrapper">

		<!-- Title -->
		
		<div id="workTitle_section" class="catSectionWrapper workSection">
		
			<?php
			// Count the number of rows that begin with 'titleType'
			$rows = 0;
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
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
							id="NWtitleDisplay<?php echo $i; ?>"
							class="cat_display"
							name="NWtitleDisplay<?php echo $i; ?>"
							value="1">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="NWtitleType<?php echo $i; ?>"
								name="NWtitleType<?php echo $i; ?>" 
								title="Title type">
									
								<option id="blank" value="" <?php selectedOption($_SESSION['createNewWork']['titleType'.$i], ''); ?>>- Type -</option>
								
								<option id="brandName" value="Brand name" <?php selectedOption($_SESSION['createNewWork']['titleType'.$i], 'Brand name'); ?>>Brand name</option>
								
								<option id="cited" value="Cited" <?php selectedOption($_SESSION['createNewWork']['titleType'.$i], 'Cited'); ?>>Cited</option>
								
								<option id="creator" value="Creator" <?php selectedOption($_SESSION['createNewWork']['titleType'.$i], 'Creator'); ?>>Creator</option>
								
								<option id="descriptive" value="Descriptive" <?php selectedOption($_SESSION['createNewWork']['titleType'.$i], 'Descriptive'); ?>>Descriptive</option>
								
								<option id="former" value="Former" <?php selectedOption($_SESSION['createNewWork']['titleType'.$i], 'Former'); ?>>Former</option>
								
								<option id="inscribed" value="Inscribed" <?php selectedOption($_SESSION['createNewWork']['titleType'.$i], 'Inscribed'); ?>>Inscribed</option>
								
								<option id="owner" value="Owner" <?php selectedOption($_SESSION['createNewWork']['titleType'.$i], 'Owner'); ?>>Owner</option>
								
								<option id="popular" value="Popular" <?php selectedOption($_SESSION['createNewWork']['titleType'.$i], 'Popular'); ?>>Popular</option>
								
								<option id="repository" value="Repository" <?php selectedOption($_SESSION['createNewWork']['titleType'.$i], 'Repository'); ?>>Repository</option>
								
								<option id="translated" value="Translated" <?php selectedOption($_SESSION['createNewWork']['titleType'.$i], 'Translated'); ?>>Translated</option>
								
								<option id="other" value="Other" <?php selectedOption($_SESSION['createNewWork']['titleType'.$i], 'Other'); ?>>Other</option>
								
							</select>
							
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="NWtitle<?php echo $i; ?>" 
								class="autoWidth"
								name="NWtitle<?php echo $i; ?>" 
								placeholder="Title"
								value="<?php echo (isset($_SESSION['createNewWork'])) ? htmlspecialchars($_SESSION['createNewWork']['title'.$i]) : ''; ?>">
						
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
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
				if (startsWith($key, 'agentAttribution')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) { ?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Agent</div>

						<input type="hidden"
							id="NWagentDisplay<?php echo $i; ?>"
							class="cat_display"
							name="NWagentDisplay<?php echo $i; ?>"
							value="1">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="NWagentAttribution<?php echo $i; ?>" 
									name="NWagentAttribution<?php echo $i; ?>"
									title="Agent attribution">
							
								<option id="blank" value="None" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentAttribution'.$i] == "None") ? 'selected="selected"' : "" ;?>>None</option>
								
								<option id="after" value="After" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentAttribution'.$i] == "After") ? 'selected="selected"' : "" ;?>>After</option>
								
								<option id="associateOf" value="Associate of" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentAttribution'.$i] == "Associate of") ? 'selected="selected"' : "" ;?>>Associate of</option>
								
								<option id="circleOf" value="Circle of" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentAttribution'.$i] == "Circle of") ? 'selected="selected"' : "" ;?>>Circle of</option>
								
								<option id="followerOf" value="Follower of" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentAttribution'.$i] == "Follower of") ? 'selected="selected"' : "" ;?>>Follower of</option>
								
								<option id="forgeryOf" value="Forgery of" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentAttribution'.$i] == "Forgery of") ? 'selected="selected"' : "" ;?>>Forgery of</option>
								
								<option id="officeOf" value="Office of" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentAttribution'.$i] == "Office of") ? 'selected="selected"' : "" ;?>>Office of</option>
								
								<option id="pupilOf" value="Pupil of" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentAttribution'.$i] == "Pupil of") ? 'selected="selected"' : "" ;?>>Pupil of</option>
								
								<option id="reworkingOf" value="Reworking of" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentAttribution'.$i] == "Reworking of") ? 'selected="selected"' : "" ;?>>Reworking of</option>
								
								<option id="schoolOf" value="School of" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentAttribution'.$i] == "School of") ? 'selected="selected"' : "" ;?>>School of</option>
								
								<option id="sealOf" value="Seal of" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentAttribution'.$i] == "Seal of") ? 'selected="selected"' : "" ;?>>Seal of</option>
								
								<option id="studioOf" value="Studio of" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentAttribution'.$i] == "Studio of") ? 'selected="selected"' : "" ;?>>Studio of</option>
								
								<option id="styleOf" value="Style of" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentAttribution'.$i] == "Style of") ? 'selected="selected"' : "" ;?>>Style of</option>
								
								<option id="workshopOf" value="Workshop of" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentAttribution'.$i] == "Workshop of") ? 'selected="selected"' : "" ;?>>Workshop of</option>
								
								<option id="copyOf" value="Copy of" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentAttribution'.$i] == "Copy of") ? 'selected="selected"' : "" ;?>>Copy of</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="NWagentRole<?php echo $i; ?>" 
								class="autoWidth"
								name="NWagentRole<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['agentRole'.$i] : ''; ?>" 
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
						
							<select id="NWagentType<?php echo $i; ?>" 
								name="NWagentType<?php echo $i; ?>" 
								title="Agent type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Type -</option>
								
								<option id="personal" value="Personal" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentType'.$i] == "Personal") ? 'selected="selected"' : "" ;?>>Personal</option>
								
								<option id="corporate" value="Corporate" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentType'.$i] == "Corporate") ? 'selected="selected"' : "" ;?>>Corporate</option>
								
								<option id="family" value="Family" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentType'.$i] == "Family") ? 'selected="selected"' : "" ;?>>Family</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['agentType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
							
							</select>
						
						</div>	
						
						<div class="catCell">
						
							<input type="text" 
								id="NWagent<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="NWagent<?php echo $i; ?>" 
								placeholder="Agent"
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['agent'.$i] : ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="NWagentId<?php echo $i; ?>" 
								name="NWagentId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['agentId'.$i] : ''; ?>">
												
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
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
				if (startsWith($key, 'dateType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) { ?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Date</div>

						<input type="hidden"
							id="NWdateDisplay<?php echo $i; ?>"
							class="cat_display"
							name="NWdateDisplay<?php echo $i; ?>"
							value="1">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="NWdateType<?php echo $i; ?>" 
								name="NWdateType<?php echo $i; ?>" 
								title="Date type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['dateType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Type -</option>
								
								<option id="alteration" value="Alteration" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['dateType'.$i] == "Alteration") ? 'selected="selected"' : "" ;?>>Alteration</option>
								
								<option id="broadcast" value="Broadcast" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['dateType'.$i] == "Broadcast") ? 'selected="selected"' : "" ;?>>Broadcast</option>
								
								<option id="bulk" value="Bulk" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['dateType'.$i] == "Bulk") ? 'selected="selected"' : "" ;?>>Bulk</option>
								
								<option id="commission" value="Commission" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['dateType'.$i] == "Commission") ? 'selected="selected"' : "" ;?>>Commission</option>
								
								<option id="creation" value="Creation" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['dateType'.$i] == "Creation") ? 'selected="selected"' : "" ;?>>Creation</option>
								
								<option id="design" value="Design" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['dateType'.$i] == "Design") ? 'selected="selected"' : "" ;?>>Design</option>
								
								<option id="destruction" value="Destruction" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['dateType'.$i] == "Destruction") ? 'selected="selected"' : "" ;?>>Destruction</option>
								
								<option id="discovery" value="Discovery" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['dateType'.$i] == "Discovery") ? 'selected="selected"' : "" ;?>>Discovery</option>
								
								<option id="exhibition" value="Exhibition" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['dateType'.$i] == "Exhibition") ? 'selected="selected"' : "" ;?>>Exhibition</option>
								
								<option id="inclusive" value="Inclusive" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['dateType'.$i] == "Inclusive") ? 'selected="selected"' : "" ;?>>Inclusive</option>
								
								<option id="performance" value="Performance" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['dateType'.$i] == "Performance") ? 'selected="selected"' : "" ;?>>Performance</option>
								
								<option id="publication" value="Publication" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['dateType'.$i] == "Publication") ? 'selected="selected"' : "" ;?>>Publication</option>
								
								<option id="restoration" value="Restoration" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['dateType'.$i] == "Restoration") ? 'selected="selected"' : "" ;?>>Restoration</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['createNewWork']) && $_SESSION['createNewWork']['dateType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
								
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<!-- "Range" checkbox -->
							<input type="checkbox" 
								id="NWdateRange<?php echo $i; ?>" 
								class="checkbox"
								<?php echo (isset($_SESSION['createNewWork']['dateRange'.$i]) && !empty($_SESSION['createNewWork']['dateRange'.$i])) ? 'checked="checked"' : "" ;?>
								name="NWdateRange<?php echo $i; ?>" 
								value="range"/>Range
						
						</div>
						
						<div class="catCell">
						
							<!-- "ca." checkbox -->
							<input type="checkbox" 
								id="NWcircaDate<?php echo $i; ?>" 
								class="checkbox"
								<?php echo (isset($_SESSION['createNewWork']['circaDate'.$i]) && !empty($_SESSION['createNewWork']['circaDate'.$i])) ? 'checked="checked"' : "" ;?>
								name="NWcircaDate<?php echo $i; ?>" 
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
								id="NWstartDate<?php echo $i; ?>" 
								name="NWstartDate<?php echo $i; ?>" 
								maxlength="5"
								placeholder="Date" 
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['startDate'.$i] : ''; ?>" 
								style="width: 3em;">
						
						</div>
						
						<div class="catCell">
						
							<!-- "startDate" era selection -->
							<select id="NWstartDateEra<?php echo $i; ?>" 
								name="NWstartDateEra<?php echo $i; ?>">
							
								<option id="CE" value="CE" <?php echo (isset($_SESSION['createNewWork']['startDateEra'.$i]) && $_SESSION['createNewWork']['startDateEra'.$i] == 'CE') ? 'selected="selected"' : "" ;?>>CE</option>

								<option id="BCE" value="BCE" <?php echo (isset($_SESSION['createNewWork']['startDateEra'.$i]) && $_SESSION['createNewWork']['startDateEra'.$i] == 'BCE') ? 'selected="selected"' : "" ;?>>BCE</option>
							
							</select>
						
						</div>
						
						<div id="NWdateRangeSpan<?php echo $i; ?>" style="display: inline-block;">
						
							<div class="catCell">
							
								to
								
							</div>
							
							<div class="catCell">
							
								<!-- "endDate" text field -->
								<input type="text" 
									id="NWendDate<?php echo $i; ?>" 
									name="NWendDate<?php echo $i; ?>" 
									maxlength="5" 
									placeholder="Date"
									value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['endDate'.$i] : ''; ?>" 
									style="width: 3em;">
								
							</div>
							
							<div class="catCell">
							
								<!-- "endDate" era selection -->
								<select id="NWendDateEra<?php echo $i; ?>" 
									name="NWendDateEra<?php echo $i; ?>">
							
									<option id="CE" value="CE" <?php echo (isset($_SESSION['createNewWork']['endDateEra'.$i]) && $_SESSION['createNewWork']['endDateEra'.$i] == 'CE') ? 'selected="selected"' : "" ;?>>CE</option>

									<option id="BCE" value="BCE" <?php echo (isset($_SESSION['createNewWork']['endDateEra'.$i]) && $_SESSION['createNewWork']['endDateEra'.$i] == 'BCE') ? 'selected="selected"' : "" ;?>>BCE</option>
								
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
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
				if (startsWith($key, 'materialType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) { ?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Material</div>

						<input type="hidden"
							id="NWmaterialDisplay<?php echo $i; ?>"
							class="cat_display"
							name="NWmaterialDisplay<?php echo $i; ?>"
							value="1">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="NWmaterialType<?php echo $i; ?>" 
								name="NWmaterialType<?php echo $i; ?>"
								title="Material type">
							
								<option id="blank" value="" <?php echo (isset($_SESSION['createNewWork']['materialType'.$i]) && $_SESSION['createNewWork']['materialType'.$i] == '') ? 'selected="selected"' : ''; ?>>- Type -</option>
								
								<option id="medium" value="Medium" <?php echo (isset($_SESSION['createNewWork']['materialType'.$i]) && $_SESSION['createNewWork']['materialType'.$i] == 'Medium') ? 'selected="selected"' : ''; ?>>Medium</option>
								
								<option id="support" value="Support" <?php echo (isset($_SESSION['createNewWork']['materialType'.$i]) && $_SESSION['createNewWork']['materialType'.$i] == 'Support') ? 'selected="selected"' : ''; ?>>Support</option>
								
								<option id="other" value="Other" <?php echo (isset($_SESSION['createNewWork']['materialType'.$i]) && $_SESSION['createNewWork']['materialType'.$i] == 'Other') ? 'selected="selected"' : ''; ?>>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="NWmaterial<?php echo $i; ?>"
								class="autoWidth authoritySearch idMissing" 
								name="NWmaterial<?php echo $i; ?>" 
								placeholder="Material"
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['material'.$i] : ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="NWmaterialId<?php echo $i; ?>" 
								name="NWmaterialId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['materialId'.$i] : ''; ?>">
											
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
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
				if (startsWith($key, 'techniqueId')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) { ?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Technique</div>

						<input type="hidden"
							id="NWtechniqueDisplay<?php echo $i; ?>"
							class="cat_display"
							name="NWtechniqueDisplay<?php echo $i; ?>"
							value="1">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="NWtechnique<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="NWtechnique<?php echo $i; ?>" 
								placeholder="Technique"
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['technique'.$i] : ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="NWtechniqueId<?php echo $i; ?>" 
								name="NWtechniqueId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['techniqueId'.$i] : ''; ?>">
											
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
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
				if (startsWith($key, 'workTypeId')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) { ?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Work Type</div>

						<input type="hidden"
							id="NWworkTypeDisplay<?php echo $i; ?>"
							class="cat_display"
							name="NWworkTypeDisplay<?php echo $i; ?>"
							value="1">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="NWworkType<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="NWworkType<?php echo $i; ?>" 
								placeholder= "Work Type"
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['workType'.$i] : ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="NWworkTypeId<?php echo $i; ?>" 
								name="NWworkTypeId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['workTypeId'.$i] : ''; ?>">
											
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
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
				if (startsWith($key, 'measurementType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) { ?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Measure</div>

						<input type="hidden"
							id="NWmeasurementDisplay<?php echo $i; ?>"
							class="cat_display"
							name="NWmeasurementDisplay<?php echo $i; ?>"
							value="1">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="NWmeasurementType<?php echo $i; ?>" 
								name="NWmeasurementType<?php echo $i; ?>"
								title="Measurement type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Measurement -</option>
								
								<option id="area" value="Area" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "Area") ? 'selected="selected"' : "" ;?>>Area</option>
								
								<option id="bitDepth" value="Bit depth" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "Bit depth") ? 'selected="selected"' : "" ;?>>Bit depth</option>
								
								<option id="circumference" value="Circumference" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "Circumference") ? 'selected="selected"' : "" ;?>>Circumference</option>
								
								<option id="count" value="Count" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "Count") ? 'selected="selected"' : "" ;?>>Count</option>
								
								<option id="depth" value="Depth" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "Depth") ? 'selected="selected"' : "" ;?>>Depth</option>
								
								<option id="diameter" value="Diameter" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "Diameter") ? 'selected="selected"' : "" ;?>>Diameter</option>
								
								<option id="distanceBetween" value="Distance between" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "Distance between") ? 'selected="selected"' : "" ;?>>Distance between</option>
								
								<option id="duration" value="Duration" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "Duration") ? 'selected="selected"' : "" ;?>>Duration</option>
								
								<option id="fileSize" value="File size" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "File size") ? 'selected="selected"' : "" ;?>>File size</option>
								
								<option id="height" value="Height" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "Height") ? 'selected="selected"' : "" ;?>>Height</option>
								
								<option id="length" value="Length" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "Length") ? 'selected="selected"' : "" ;?>>Length</option>
								
								<option id="resolution" value="Resolution" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "Resolution") ? 'selected="selected"' : "" ;?>>Resolution</option>
								
								<option id="runningTime" value="Running time" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "Running time") ? 'selected="selected"' : "" ;?>>Running time</option>
								
								<option id="scale" value="Scale" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "Scale") ? 'selected="selected"' : "" ;?>>Scale</option>
								
								<option id="size" value="Size" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "Size") ? 'selected="selected"' : "" ;?>>Size</option>
								
								<option id="weight" value="NWeight" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "Weight") ? 'selected="selected"' : "" ;?>>Weight</option>
								
								<option id="width" value="NWidth" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "Width") ? 'selected="selected"' : "" ;?>>Width</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['createNewWork']['measurementType'.$i]) && $_SESSION['createNewWork']['measurementType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
							
							</select>
						
						</div>
						
						<div id="NWcountMeasurement<?php echo $i; ?>" class="catCell">
						
							Count:
						
						</div>
						
						<div id="NWmeasurementFieldDiv1_<?php echo $i; ?>" class="catCell">
						
							<!-- Basic measurement text field -->
							
							<input type="text" 
								id="NWmeasurementField1_<?php echo $i; ?>" 
								name="NWmeasurementField1_<?php echo $i; ?>" 
								style="width: 2.5em;"
								placeholder=""
								value="<?php echo $_SESSION['createNewWork']['measurementField1_'.$i]; ?>">
						
						</div>
						
						<div id="NWbitMeasurement<?php echo $i; ?>" class="catCell">
						
							bit
						
						</div>
						
						<div id="NWcommonMeasurement1_<?php echo $i; ?>" 
							class="catCell">
						
							<select id="NWcommonMeasurementList1_<?php echo $i; ?>" 
								name="NWcommonMeasurementList1_<?php echo $i; ?>">
								
								<option id="cm" value="cm" <?php echo (isset($_SESSION['createNewWork']['commonMeasurementList1_'.$i]) && $_SESSION['createNewWork']['commonMeasurementList1_'.$i] == 'cm') ? 'selected="selected"' : ''; ?>>cm</option>
								
								<option id="m" value="m" <?php echo (isset($_SESSION['createNewWork']['commonMeasurementList1_'.$i]) && $_SESSION['createNewWork']['commonMeasurementList1_'.$i] == 'm') ? 'selected="selected"' : ''; ?>>m</option>
								
								<option id="km" value="km" <?php echo (isset($_SESSION['createNewWork']['commonMeasurementList1_'.$i]) && $_SESSION['createNewWork']['commonMeasurementList1_'.$i] == 'km') ? 'selected="selected"' : ''; ?>>km</option>
								
								<option id="in" value="in" <?php echo (isset($_SESSION['createNewWork']['commonMeasurementList1_'.$i]) && $_SESSION['createNewWork']['commonMeasurementList1_'.$i] == 'in') ? 'selected="selected"' : ''; ?>>in</option>
								
								<option id="ft" value="ft" <?php echo (isset($_SESSION['createNewWork']['commonMeasurementList1_'.$i]) && $_SESSION['createNewWork']['commonMeasurementList1_'.$i] == 'ft') ? 'selected="selected"' : ''; ?>>ft</option>
							
							</select>
						
						</div>
						
						<div id="NWinchesMeasurement<?php echo $i; ?>" 
							class="inline">
						
							<div class="catCell">,</div> <!-- comma -->
								
							<div class="catCell">
							
								<input type="text" 
									id="NWinchesValue<?php echo $i; ?>" 
									name="NWinchesValue<?php echo $i; ?>" 
									placeholder="in."
									value="<?php echo $_SESSION['createNewWork']['inchesValue'.$i]; ?>" 
									maxlength="5" 
									style="width: 2em;">
								
							</div>
							
						</div>

						<div id="NWareaMeasurement<?php echo $i; ?>" 
							class="catCell">
						
							<select id="NWareaMeasurementList<?php echo $i; ?>" 
								name="NWareaMeasurementList<?php echo $i; ?>">
								
								<option id="cm2" value="cm2" <?php echo (isset($_SESSION['createNewWork']['areaMeasurementList'.$i]) && $_SESSION['createNewWork']['areaMeasurementList'.$i] == 'cm2') ? 'selected="selected"' : ''; ?>>sq. cm</option>
								
								<option id="m2" value="m2" <?php echo (isset($_SESSION['createNewWork']['areaMeasurementList'.$i]) && $_SESSION['createNewWork']['areaMeasurementList'.$i] == 'm2') ? 'selected="selected"' : ''; ?>>sq. m</option>
								
								<option id="km2" value="km2" <?php echo (isset($_SESSION['createNewWork']['areaMeasurementList'.$i]) && $_SESSION['createNewWork']['areaMeasurementList'.$i] == 'km2') ? 'selected="selected"' : ''; ?>>sq. km</option>
								
								<option id="in2" value="in2" <?php echo (isset($_SESSION['createNewWork']['areaMeasurementList'.$i]) && $_SESSION['createNewWork']['areaMeasurementList'.$i] == 'in2') ? 'selected="selected"' : ''; ?>>sq. in</option>
								
								<option id="ft2" value="ft2" <?php echo (isset($_SESSION['createNewWork']['areaMeasurementList'.$i]) && $_SESSION['createNewWork']['areaMeasurementList'.$i] == 'ft2') ? 'selected="selected"' : ''; ?>>sq. ft</option>
								
								<option id="acres" value="acres" <?php echo (isset($_SESSION['createNewWork']['areaMeasurementList'.$i]) && $_SESSION['createNewWork']['areaMeasurementList'.$i] == 'acres') ? 'selected="selected"' : ''; ?>>acre(s)</option>
							
							</select>
						
						</div>
						
						<div id="NWtimeMeasurement<?php echo $i; ?>" class="inline">
						
							<div class="catCell">
							
								<input type="text" 
									id="NWdays<?php echo $i; ?>" 
									name="NWdays<?php echo $i; ?>" 
									placeholder="Day"
									value="" 
									maxlength="10" 
									style="width: 1.7em;">
							
							</div>
							
							<div class="catCell">
							
								<input type="text" 
									id="NWhours<?php echo $i; ?>" 
									name="NWhours<?php echo $i; ?>" 
									placeholder="Hrs"
									value="" 
									maxlength="10" 
									style="width: 1.7em;">
							
							</div>
							
							<div class="catCell">
							
								<input type="text" 
									id="NWminutes<?php echo $i; ?>" 
									name="NWminutes<?php echo $i; ?>" 
									placeholder="Min"
									value="" 
									maxlength="10" 
									style="width: 1.7em;">
							
							</div>
							
							<div class="catCell">
							
								<input type="text" 
									id="NWseconds<?php echo $i; ?>" 
									name="NWseconds<?php echo $i; ?>" 
									placeholder="Sec"
									value="" 
									maxlength="10" 
									style="width: 1.7em;">
						
							</div>
							
						</div>
						
						<div id="NWfileMeasurement<?php echo $i; ?>" 
							class="catCell">
						
							<select id="NWfileSize<?php echo $i; ?>" 
								name="NWfileSize<?php echo $i; ?>">
								
								<option id="kb" value="kb" <?php echo (isset($_SESSION['createNewWork']['fileSize'.$i]) && $_SESSION['createNewWork']['fileSize'.$i] == 'kb') ? 'selected="selected"' : ''; ?>>KB</option>

								<option id="mb" value="mb" <?php echo (isset($_SESSION['createNewWork']['fileSize'.$i]) && $_SESSION['createNewWork']['fileSize'.$i] == 'mb') ? 'selected="selected"' : ''; ?>>MB</option>

								<option id="gb" value="gb" <?php echo (isset($_SESSION['createNewWork']['fileSize'.$i]) && $_SESSION['createNewWork']['fileSize'.$i] == 'gb') ? 'selected="selected"' : ''; ?>>GB</option>

								<option id="tb" value="tb" <?php echo (isset($_SESSION['createNewWork']['fileSize'.$i]) && $_SESSION['createNewWork']['fileSize'.$i] == 'tb') ? 'selected="selected"' : ''; ?>>TB</option>
							
							</select>
						
						</div>
						
						<div id="NWresolutionMeasurement<?php echo $i; ?>" 
							class="inline">
						
							<div class="catCell">
							
								<input type="text" 
									id="NWresolutionWidth<?php echo $i; ?>" 
									name="NWresolutionWidth<?php echo $i; ?>" 
									placeholder="NWidth"
									maxlength="10" 
									value="<?php echo $_SESSION['createNewWork']['resolutionWidth'.$i]; ?>"
									style="width: 3em;">
							
							</div>

							<div class="catCell">x</div> <!-- "x" -->

							<div class="catCell">
							
								<input type="text" 
									id="NWresolutionHeight<?php echo $i; ?>" 
									name="NWresolutionHeight<?php echo $i; ?>"
									placeholder="Height" 
									maxlength="10" 
									value="<?php echo $_SESSION['createNewWork']['resolutionHeight'.$i]; ?>" 
									style="width: 3em;">

							</div>
							
						</div>
						
						<div id="NWweightMeasurement<?php echo $i; ?>" 
							class="catCell">
						
							<select id="NWweightUnit<?php echo $i; ?>" 
								name="NWweightUnit<?php echo $i; ?>">
								
								<option id="g" value="g" <?php selectedOption($_SESSION['createNewWork']['weightUnit'.$i], 'g'); ?>>g</option>

								<option id="kg" value="kg" <?php selectedOption($_SESSION['createNewWork']['weightUnit'.$i], 'kg'); ?>>kg</option>

								<option id="lb" value="lb" <?php selectedOption($_SESSION['createNewWork']['weightUnit'.$i], 'lb'); ?>>lb</option>
							
							</select>
						
						</div>
						
						<div id="NWotherMeasurement<?php echo $i; ?>" class="inline">
						
							<!-- <div class="catCell">Description:</div> -->
							
							<!-- <div class="catCell">
							
								<input type="text" 
									id="NWotherMeasurementDescription<?php //echo $i; ?>" 
									name="NWotherMeasurementDescription<?php //echo $i; ?>" 
									placeholder="Description"
									maxlength="500" 
									value="<?php //echo $_SESSION['createNewWork']['otherMeasurementDescription'.$i]; ?>">
							
							</div> -->
						
						</div>
					
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->

				<div class ="catRowWrapper">

					<div class ="catCellWrapper">

						<div class="catRowTitle"></div>

							<div id="NWmeasurementFieldDiv2_<?php echo $i; ?>" 
							class="inline">
						
								<div class="catCell">equal to</div> <!-- "equal to" -->
								
								<div class="catCell">
								
									<input type="text" 
										id="NWmeasurementField2_<?php echo $i; ?>" 
										name="NWmeasurementField2_<?php echo $i; ?>" 
										value="<?php echo $_SESSION['createNewWork']['measurementField2_'.$i]; ?>" 
										style="width: 5em;">
								
								</div>
							
							</div>
							
							<div id="NWcommonMeasurement2_<?php echo $i; ?>" 
								class="catCell">
							
								<select id="NWcommonMeasurementList2_<?php echo $i; ?>" 
									name="NWcommonMeasurementList2_<?php echo $i; ?>">
									
									<option id="cm" value="cm" <?php echo (isset($_SESSION['createNewWork']['commonMeasurementList2_'.$i]) && $_SESSION['createNewWork']['commonMeasurementList2_'.$i] == 'cm') ? 'selected="selected"' : ''; ?>>cm</option>
									
									<option id="m" value="m" <?php echo (isset($_SESSION['createNewWork']['commonMeasurementList2_'.$i]) && $_SESSION['createNewWork']['commonMeasurementList2_'.$i] == 'm') ? 'selected="selected"' : ''; ?>>m</option>
									
									<option id="km" value="km" <?php echo (isset($_SESSION['createNewWork']['commonMeasurementList2_'.$i]) && $_SESSION['createNewWork']['commonMeasurementList2_'.$i] == 'km') ? 'selected="selected"' : ''; ?>>km</option>
									
									<option id="in" value="in" <?php echo (isset($_SESSION['createNewWork']['commonMeasurementList2_'.$i]) && $_SESSION['createNewWork']['commonMeasurementList2_'.$i] == 'in') ? 'selected="selected"' : ''; ?>>in</option>
									
									<option id="ft" value="ft" <?php echo (isset($_SESSION['createNewWork']['commonMeasurementList2_'.$i]) && $_SESSION['createNewWork']['commonMeasurementList2_'.$i] == 'ft') ? 'selected="selected"' : ''; ?>>ft</option>
								
								</select>
							
							</div>
							
						</div>

					</div> <!-- catRowWrapper -->	

			</div>
			
			<?php $i++; } ?>
		
		</div> <!-- catSectionWrapper -->
		
		<!-- Cultural Context -->
		
		<div class="catSectionWrapper workSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
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
							id="NWculturalContextDisplay<?php echo $i; ?>"
							class="cat_display"
							name="NWculturalContextDisplay<?php echo $i; ?>"
							value="1">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="NWculturalContext<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="NWculturalContext<?php echo $i; ?>" 
								placeholder="Cultural Context"
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['culturalContext'.$i] : ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="NWculturalContextId<?php echo $i; ?>" 
								name="NWculturalContextId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['culturalContextId'.$i] : ''; ?>">
											
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
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
				if (startsWith($key, 'stylePeriodId')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) { ?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Style Period</div>

						<input type="hidden"
							id="NWstylePeriodDisplay<?php echo $i; ?>"
							class="cat_display"
							name="NWstylePeriodDisplay<?php echo $i; ?>"
							value="1">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="NWstylePeriod<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="NWstylePeriod<?php echo $i; ?>" 
								placeholder="Style Period"
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['stylePeriod'.$i] : ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="NWstylePeriodId<?php echo $i; ?>" 
								name="NWstylePeriodId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['stylePeriodId'.$i] : ''; ?>">
											
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
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
				if (startsWith($key, 'locationNameType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) { ?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Location</div>

						<input type="hidden"
							id="NWlocationDisplay<?php echo $i; ?>"
							class="cat_display"
							name="NWlocationDisplay<?php echo $i; ?>"
							value="1">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="NWlocation<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="NWlocation<?php echo $i; ?>" 
								placeholder="Location"
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['location'.$i] : ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="NWlocationId<?php echo $i; ?>" 
								name="NWlocationId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['locationId'.$i] : ''; ?>">
											
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
						
							<select id="NWlocationType<?php echo $i; ?>" 
								name="NWlocationType<?php echo $i; ?>" 
								title="Location type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['createNewWork']['locationType'.$i]) && $_SESSION['createNewWork']['locationType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Type -</option>
								
								<option id="creation" value="Creation" <?php echo(isset($_SESSION['createNewWork']['locationType'.$i]) && $_SESSION['createNewWork']['locationType'.$i] == "Creation") ? 'selected="selected"' : "" ;?>>Creation</option>
								
								<option id="discovery" value="Discovery" <?php echo(isset($_SESSION['createNewWork']['locationType'.$i]) && $_SESSION['createNewWork']['locationType'.$i] == "Discovery") ? 'selected="selected"' : "" ;?>>Discovery</option>
								
								<option id="exhibition" value="Exhibition" <?php echo(isset($_SESSION['createNewWork']['locationType'.$i]) && $_SESSION['createNewWork']['locationType'.$i] == "Exhibition") ? 'selected="selected"' : "" ;?>>Exhibition</option>
								
								<option id="formerOwner" value="Former owner" <?php echo(isset($_SESSION['createNewWork']['locationType'.$i]) && $_SESSION['createNewWork']['locationType'.$i] == "Former owner") ? 'selected="selected"' : "" ;?>>Former owner</option>
								
								<option id="formerRepository" value="Former repository" <?php echo(isset($_SESSION['createNewWork']['locationType'.$i]) && $_SESSION['createNewWork']['locationType'.$i] == "Former repository") ? 'selected="selected"' : "" ;?>>Former repository</option>
								
								<option id="formerSite" value="Former site" <?php echo(isset($_SESSION['createNewWork']['locationType'.$i]) && $_SESSION['createNewWork']['locationType'.$i] == "Former site") ? 'selected="selected"' : "" ;?>>Former site</option>
								
								<option id="installation" value="Installation" <?php echo(isset($_SESSION['createNewWork']['locationType'.$i]) && $_SESSION['createNewWork']['locationType'.$i] == "Installation") ? 'selected="selected"' : "" ;?>>Installation</option>
								
								<option id="intended" value="Intended" <?php echo(isset($_SESSION['createNewWork']['locationType'.$i]) && $_SESSION['createNewWork']['locationType'.$i] == "Intended") ? 'selected="selected"' : "" ;?>>Intended</option>
								
								<option id="owner" value="Owner" <?php echo(isset($_SESSION['createNewWork']['locationType'.$i]) && $_SESSION['createNewWork']['locationType'.$i] == "Owner") ? 'selected="selected"' : "" ;?>>Owner</option>
								
								<option id="performance" value="Performance" <?php echo(isset($_SESSION['createNewWork']['locationType'.$i]) && $_SESSION['createNewWork']['locationType'.$i] == "Performance") ? 'selected="selected"' : "" ;?>>Performance</option>
								
								<option id="publication" value="Publication" <?php echo(isset($_SESSION['createNewWork']['locationType'.$i]) && $_SESSION['createNewWork']['locationType'.$i] == "Publication") ? 'selected="selected"' : "" ;?>>Publication</option>
								
								<option id="repository" value="Repository" <?php echo(isset($_SESSION['createNewWork']['locationType'.$i]) && $_SESSION['createNewWork']['locationType'.$i] == "Repository") ? 'selected="selected"' : "" ;?>>Repository</option>
								
								<option id="site" value="Site" <?php echo(isset($_SESSION['createNewWork']['locationType'.$i]) && $_SESSION['createNewWork']['locationType'.$i] == "Site") ? 'selected="selected"' : "" ;?>>Site</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['createNewWork']['locationType'.$i]) && $_SESSION['createNewWork']['locationType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
							
							</select>
						
						</div>

						<div class="catCell">
						
							<select id="NWlocationNameType<?php echo $i; ?>" 
								name="NWlocationNameType<?php echo $i; ?>" 
								title="Location name type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['createNewWork']['locationNameType'.$i]) && $_SESSION['createNewWork']['locationNameType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Name Type -</option>
								
								<option id="corporate" value="Corporate" <?php echo(isset($_SESSION['createNewWork']['locationNameType'.$i]) && $_SESSION['createNewWork']['locationNameType'.$i] == "Corporate") ? 'selected="selected"' : "" ;?>>Corporate</option>
								
								<option id="geographic" value="Geographic" <?php echo(isset($_SESSION['createNewWork']['locationNameType'.$i]) && $_SESSION['createNewWork']['locationNameType'.$i] == "Geographic") ? 'selected="selected"' : "" ;?>>Geographic</option>
								
								<option id="personal" value="Personal" <?php echo(isset($_SESSION['createNewWork']['locationNameType'.$i]) && $_SESSION['createNewWork']['locationNameType'.$i] == "Personal") ? 'selected="selected"' : "" ;?>>Personal</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['createNewWork']['locationNameType'.$i]) && $_SESSION['createNewWork']['locationNameType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
							
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
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
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
							id="NWspecificLocationDisplay<?php echo $i; ?>"
							class="cat_display"
							name="NWspecificLocationDisplay<?php echo $i; ?>"
							value="1">

						</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="NWspecificLocationType<?php echo $i; ?>" 
								name="NWspecificLocationType<?php echo $i; ?>" 
								title="Specific location type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['createNewWork']['specificLocationType'.$i]) && $_SESSION['createNewWork']['specificLocationType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Type -</option>
								
								<option id="Address" value="Address" <?php echo(isset($_SESSION['createNewWork']['specificLocationType'.$i]) && $_SESSION['createNewWork']['specificLocationType'.$i] == "Address") ? 'selected="selected"' : "" ;?>>Address</option>

								<option id="LatLng" value="LatLng" <?php echo(isset($_SESSION['createNewWork']['specificLocationType'.$i]) && $_SESSION['createNewWork']['specificLocationType'.$i] == "LatLng") ? 'selected="selected"' : "" ;?>>LatLng</option>
								
								<option id="Note" value="Note" <?php echo(isset($_SESSION['createNewWork']['specificLocationType'.$i]) && $_SESSION['createNewWork']['specificLocationType'.$i] == "Note") ? 'selected="selected"' : "" ;?>>Note</option>
							</select>
						
						</div>
					</div><!-- catCellWrapper -->

					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->	

						
				
				<div id="specificLocationRow" class="catRowWrapper">	
				
	
					<div class="catRowTitle"></div>				
					<div class="catCellWrapper">

							<div id="NWspecificLocationAddress" class="catCell">
	
								<input type="text" 
									id="NWspecificLocationAddress<?php echo $i; ?>" 
									style="width: 14em;"
									name="NWspecificLocationAddress<?php echo $i; ?>" 
									placeholder="Street Address"
									value="<?php echo (isset($_SESSION['createNewWork']['specificLocationAddress'.$i])) ? $_SESSION['createNewWork']['specificLocationAddress'.$i] : ''; ?>" 
									title="Specific location address">
					
							</div><!-- catCell -->

							<div id="NWspecificLocationZip" class="catCell">

								<input type="text" 
									id="NWspecificLocationZip<?php echo $i; ?>" 
									style="width: 5.5em"
									name="NWspecificLocationZip<?php echo $i; ?>" 
									placeholder="Postal Code"
									value="<?php echo (isset($_SESSION['createNewWork']['specificLocationZip'.$i])) ? $_SESSION['createNewWork']['specificLocationZip'.$i] : ''; ?>" 
									title="Specific location zip">

							</div><!-- catCell -->


						<div id="NWspecificLocationLat" class="catCell">

							<input type="text" 
								id="NWspecificLocationLat<?php echo $i; ?>" 
								style="width: 7em"
								name="NWspecificLocationLat<?php echo $i; ?>" 
								placeholder="Latitude"
								value="<?php echo (isset($_SESSION['createNewWork']['specificLocationLat'.$i])) ? $_SESSION['createNewWork']['specificLocationLat'.$i] : ''; ?>" 
								title="Specific location latitude">

						</div><!-- catCell -->

						<div id="NWspecificLocationLong" class="catCell">
				
							<input type="text"
								id="NWspecificLocationLong<?php echo $i; ?>" 
								style="width: 7em"
								name="NWspecificLocationLong<?php echo $i; ?>" 
								placeholder="Longitude"
								value="<?php echo (isset($_SESSION['createNewWork']['specificLocationLong'.$i])) ? $_SESSION['createNewWork']['specificLocationLong'.$i] : ''; ?>" 
								title="Specific location longitude"> 

						</div><!-- catCell -->

					</div><!-- catCellWrapper -->
				
				</div> <!-- catRowWrapper -->

				<div id="specificLocationNoteRow" class="catRowWrapper" style="height: 7em; padding-top: 3px; padding-bottom: 0; position: relative;">				

					<div class="catCellWrapper">

						<div  id="NWspecificLocationNote" class="catCell">
							
							<textarea id="NWspecificLocationNote<?php echo $i; ?>" 
							class="fixedWidth" 
							rows="2"
							style="height: 6.5em; width: 33em; overflow: hidden;"
							name="NWspecificLocationNote<?php echo $i; ?>" 
							placeholder="Specific Location Note"><?php echo (isset($_SESSION['createNewWork']['specificLocationNote'.$i])) ? htmlspecialchars($_SESSION['createNewWork']['specificLocationNote'.$i]) : ''; ?></textarea>

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
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
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
							id="NWbuiltWorkDisplay<?php echo $i; ?>"
							class="cat_display"
							name="NWbuiltWorkDisplay<?php echo $i; ?>"
							value="1">
					
					</div>
					
			<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="NWbuiltWork<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="NWbuiltWork<?php echo $i; ?>" 
								placeholder="Built Work"
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['builtWork'.$i] : ''; ?>">
						
						</div>	
						
						<div class="catCell">
						
							<input type="hidden" 
								id="NWbuiltWorkId<?php echo $i; ?>"
								name="NWbuiltWorkId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['builtWorkId'.$i] : ''; ?>">
						
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
						
							<select id="NWbuiltWorkType<?php echo $i; ?>" 
								name="NWbuiltWorkType<?php echo $i; ?>" 
								title="Location type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['createNewWork']['builtWorkType'.$i]) && $_SESSION['createNewWork']['builtWorkType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Type -</option>
								
								<option id="creation" value="Creation" <?php echo(isset($_SESSION['createNewWork']['builtWorkType'.$i]) && $_SESSION['createNewWork']['builtWorkType'.$i] == "Creation") ? 'selected="selected"' : "" ;?>>Creation</option>
								
								<option id="discovery" value="Discovery" <?php echo(isset($_SESSION['createNewWork']['builtWorkType'.$i]) && $_SESSION['createNewWork']['builtWorkType'.$i] == "Discovery") ? 'selected="selected"' : "" ;?>>Discovery</option>
								
								<option id="exhibition" value="Exhibition" <?php echo(isset($_SESSION['createNewWork']['builtWorkType'.$i]) && $_SESSION['createNewWork']['builtWorkType'.$i] == "Exhibition") ? 'selected="selected"' : "" ;?>>Exhibition</option>
								
								<option id="formerOwner" value="Former owner" <?php echo(isset($_SESSION['createNewWork']['builtWorkType'.$i]) && $_SESSION['createNewWork']['builtWorkType'.$i] == "Former owner") ? 'selected="selected"' : "" ;?>>Former owner</option>
								
								<option id="formerRepository" value="Former repository" <?php echo(isset($_SESSION['createNewWork']['builtWorkType'.$i]) && $_SESSION['createNewWork']['builtWorkType'.$i] == "Former repository") ? 'selected="selected"' : "" ;?>>Former repository</option>
								
								<option id="formerSite" value="Former site" <?php echo(isset($_SESSION['createNewWork']['builtWorkType'.$i]) && $_SESSION['createNewWork']['builtWorkType'.$i] == "Former site") ? 'selected="selected"' : "" ;?>>Former site</option>
								
								<option id="installation" value="Installation" <?php echo(isset($_SESSION['createNewWork']['builtWorkType'.$i]) && $_SESSION['createNewWork']['builtWorkType'.$i] == "Installation") ? 'selected="selected"' : "" ;?>>Installation</option>
								
								<option id="intended" value="Intended" <?php echo(isset($_SESSION['createNewWork']['builtWorkType'.$i]) && $_SESSION['createNewWork']['builtWorkType'.$i] == "Intended") ? 'selected="selected"' : "" ;?>>Intended</option>
								
								<option id="owner" value="Owner" <?php echo(isset($_SESSION['createNewWork']['builtWorkType'.$i]) && $_SESSION['createNewWork']['builtWorkType'.$i] == "Owner") ? 'selected="selected"' : "" ;?>>Owner</option>
								
								<option id="performance" value="Performance" <?php echo(isset($_SESSION['createNewWork']['builtWorkType'.$i]) && $_SESSION['createNewWork']['builtWorkType'.$i] == "Performance") ? 'selected="selected"' : "" ;?>>Performance</option>
								
								<option id="publication" value="Publication" <?php echo(isset($_SESSION['createNewWork']['builtWorkType'.$i]) && $_SESSION['createNewWork']['builtWorkType'.$i] == "Publication") ? 'selected="selected"' : "" ;?>>Publication</option>
								
								<option id="repository" value="Repository" <?php echo(isset($_SESSION['createNewWork']['builtWorkType'.$i]) && $_SESSION['createNewWork']['builtWorkType'.$i] == "Repository") ? 'selected="selected"' : "" ;?>>Repository</option>
								
								<option id="site" value="Site" <?php echo(isset($_SESSION['createNewWork']['builtWorkType'.$i]) && $_SESSION['createNewWork']['builtWorkType'.$i] == "Site") ? 'selected="selected"' : "" ;?>>Site</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['createNewWork']['builtWorkType'.$i]) && $_SESSION['createNewWork']['builtWorkType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
							
							</select>
						
						</div>

						<div class="catCell">
						
							<select id="NWbuiltWorkNameType<?php echo $i; ?>" 
								name="NWbuiltWorkNameType<?php echo $i; ?>" 
								title="Location name type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['createNewWork']['builtWorkNameType'.$i]) && $_SESSION['createNewWork']['builtWorkNameType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Name Type -</option>
								
								<option id="corporate" value="Corporate" <?php echo(isset($_SESSION['createNewWork']['builtWorkNameType'.$i]) && $_SESSION['createNewWork']['builtWorkNameType'.$i] == "Corporate") ? 'selected="selected"' : "" ;?>>Corporate</option>
								
								<option id="geographic" value="Geographic" <?php echo(isset($_SESSION['createNewWork']['builtWorkNameType'.$i]) && $_SESSION['createNewWork']['builtWorkNameType'.$i] == "Geographic") ? 'selected="selected"' : "" ;?>>Geographic</option>
								
								<option id="personal" value="Personal" <?php echo(isset($_SESSION['createNewWork']['builtWorkNameType'.$i]) && $_SESSION['createNewWork']['builtWorkNameType'.$i] == "Personal") ? 'selected="selected"' : "" ;?>>Personal</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['createNewWork']['builtWorkNameType'.$i]) && $_SESSION['createNewWork']['builtWorkNameType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
							
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
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
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
							id="NWrelationDisplay<?php echo $i; ?>"
							class="cat_display"
							name="NWrelationDisplay<?php echo $i; ?>"
							value="1">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="NWrelationType<?php echo $i; ?>"
								name="NWrelationType<?php echo $i; ?>" 
								title="relationType">	
				
								<option id="blank" value="" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], ''); ?>>- Type -</option>
								
								<option id="relatedTo" value="relatedTo" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'relatedTo'); ?>>Related to</option>
								
								<option id="partOf" value="partOf" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'partOf'); ?>>Part of</option>
								
								<option id="formerlyPartOf" value="formerlyPartOf" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'formerlyPartOf'); ?>>Formerly part of</option>
								
								<option id="componentOf" value="componentOf" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'componentOf'); ?>>Component of</option>

								<option id="partnerInSetWith" value="partnerInSetWith" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'partnerInSetWith'); ?>>Partner in set with</option>

								<option id="preparatoryFor" value="preparatoryFor" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'preparatoryFor'); ?>>Preparatory for</option>
								
								<option id="studyFor" value="studyFor" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'studyFor'); ?>>Study for</option>
								
								<option id="cartoonFor" value="cartoonFor" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'cartoonFor'); ?>>Cartoon for</option>
								
								<option id="modelFor" value="modelFor" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'modelFor'); ?>>Model for</option>
								
								<option id="planFor" value="planFor" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'planFor'); ?>>Plan for</option>
								
								<option id="counterProofFor" value="counterProofFor" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'counterProofFor'); ?>>Counter proof for</option>
								
								<option id="printingPlateFor" value="printingPlateFor" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'printingPlateFor'); ?>>Printing plate for</option>
								
								<option id="reliefFor" value="reliefFor" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'reliefFor'); ?>>Relief for</option>
								
								<option id="prototypeFor" value="prototypeFor" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'prototypeFor'); ?>>Prototype for</option>

								<option id="designedFor" value="designedFor" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'designedFor'); ?>>Designed for</option>

								<option id="mateOf" value="mateOf" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'mateOf'); ?>>Mate of</option>

								<option id="pendantOf" value="pendantOf" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'pendantOf'); ?>>Pendant of</option>

								<option id="exhibitedAt" value="exhibitedAt" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'exhibitedAt'); ?>>Exhibited at</option>

								<option id="copyAfter" value="copyAfter" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'copyAfter'); ?>>Copy after</option>

								<option id="depicts" value="depicts" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'depicts'); ?>>Depicts</option>

								<option id="derivedFrom" value="derivedFrom" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'derivedFrom'); ?>>Derived from</option>

								<option id="facsimileOf" value="facsimileOf" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'facsimileOf'); ?>>Facsimile of</option>

								<option id="replicaOf" value="replicaOf" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'replicaOf'); ?>>Replica of</option>

								<option id="versionOf" value="versionOf" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'versionOf'); ?>>Version of</option>
								
								<option id="largerContextFor" value="largerContextFor" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'largerContextFor'); ?>>Larger Context For</option>

								<option id="formerlyLargerContextFor" value="formerlyLargerContextFor" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'formerlyLargerContextFor'); ?>>Formerly Larger Context For</option>
								
								<option id="componentIs" value="componentIs" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'componentIs'); ?>>Component Is</option>

								<option id="basedOn" value="basedOn" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'basedOn'); ?>>Based On</option>
								
								<option id="studyIs" value="studyIs" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'studyIs'); ?>>Study Is</option>

								<option id="cartoonIs" value="cartoonIs" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'cartoonIs'); ?>>Cartoon Is</option>
								
								<option id="modelIs" value="modelIs" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'modelIs'); ?>>Model Is</option>

								<option id="planIs" value="planIs" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'planIs'); ?>>Plan Is</option>
								
								<option id="counterProofIs" value="counterProofIs" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'counterProofIs'); ?>>Counter Proof Is</option>

								<option id="printingPlateIs" value="printingPlateIs" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'printingPlateIs'); ?>>Printing Plate Is</option>
								
								<option id="impressionIs" value="impressionIs" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'impressionIs'); ?>>Impression Is</option>

								<option id="prototypeIs" value="prototypeIs" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'prototypeIs'); ?>>Prototype Is</option>
								
								<option id="contextIs" value="contextIs" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'contextIs'); ?>>Context Is</option>

								<option id="venueFor" value="venueFor" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'venueFor'); ?>>Venue For</option>
								
								<option id="copyIs" value="copyIs" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'copyIs'); ?>>Copy Is</option>

								<option id="depictedIn" value="depictedIn" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'depictedIn'); ?>>Depicted In</option>
								
								<option id="sourceFor" value="sourceFor" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'sourceFor'); ?>>Source For</option>

								<option id="facsimileIs" value="facsimileIs" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'facsimileIs'); ?>>Facsimile Is</option>
								
								<option id="relplicaIs" value="relplicaIs" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'relplicaIs'); ?>>Replica Is</option>

								<option id="versionIs" value="versionIs" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'versionIs'); ?>>Version Is</option>
								
								<option id="imageIs" value="imageIs" <?php selectedOption($_SESSION['createNewWork']['relationType'.$i], 'imageIs'); ?>>Image Is</option>
							
							</select>

						</div>
			
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
						
						</div> <!-- catRowWrapper -->

						<div id="relationSearch" class="catRowWrapper" style="height: auto; padding-top: 6px; padding-bottom: 0; position: relative;">
				
							<div id="workAssoc_wrapper">
							
								<div id="workAssoc_searchFields">

									<p>Search existing works:</p>

									<input type="text" 
									id = "NWsearchTitle<?php echo $i; ?>"
									name="NWsearchTitle<?php echo $i; ?>"
									placeholder="Title">
									
									<br />

									<input type="text" 
									id = "NWsearchAgent<?php echo $i; ?>"
									name="NWsearchAgent<?php echo $i; ?>"
									placeholder="Agent">

									<br />
									
									<input type="button"
									id="NWrelationSearch_submitButton<?php echo $i; ?>"
									name="NWrelationSearch_submitButton<?php echo $i; ?>"
									value="Search">

								</div>

							</div>
							

				</div> <!-- catRowWrapper -->
				
				<?php 

				if (!empty($_SESSION['createNewWork']['relatedTo'.$i])) { ?>

						<div id="NWshowRelatedTo<?php echo $i; ?>"  class="catRowWrapper" style="height: auto;">
									
							<div class="workAssoc_results_row">
									
								<!--
								Preview thumbnail
								-->
								<?php 
								$relatedImageSrc = $image_dir.'/thumb/'.$_SESSION['createNewWork']['relationImage'.$i].'.jpg';	
								?>"	
								
							<div class="workAssoc_results_col1">
									<img src="<?php echo $relatedImageSrc; ?>"
									class="relationAssoc_thumb"
									title="Preview this image"
									style="display: inline-block; width: 92px; height: 72px;">
								
									<input type="hidden"
									id = "workNum<?php echo $i; ?>" 
									name="workNum<?php echo $i; ?>" 
									value="<?php echo (isset($_SESSION['createNewWork']['relationImageId'.$i])) ? $_SESSION['createNewWork']['relationImageId'.$i] : ''; ?>">

									<input type="hidden"
									id = "imageNum<?php echo $i; ?>" 
									name="imageNum<?php echo $i; ?>" 
									value="<?php echo (isset($_SESSION['createNewWork']['relationImage'.$i])) ? $_SESSION['createNewWork']['relationImage'.$i] : ''; ?>">

								</div>

							<div class="workAssoc_results_col2 defaultCursor">
							
								<!--
									Work title
								-->
								
							<div class="workAssoc_results_cell mediumWeight"
									style="line-height: 1.2em;">

									<?php 
									$relatedTitle = $_SESSION['createNewWork']['relationTitle'.$i]; 
									echo '<span title="'.$relatedTitle.'">';
									echo (strlen($relatedTitle) <= 46) 
										? $relatedTitle. '<br>'
										: substr($relatedTitle, 0, 43) . '...<br>';
									echo '</span>';
									?>
								
								</div>

									<!--
									Agent
									-->

								<div class="workAssoc_results_cell">
									<?php
									echo $_SESSION['createNewWork']['relationAgent'.$i];
									?>
								</div>	
	
							</div>

						</div> <!-- workAssoc_results_row -->

					</div>				
				
		<?php } else {?>

			
						<div id="NWfillRelatedTo<?php echo $i; ?>" hidden>
						
								<input type ="text"
								id= "NWrelatedTo<?php echo $i; ?>"
								name = "NWrelatedTo<?php echo $i; ?>"
								value =""
								placehoder="Related To">

						</div>	
										

				<?php }?>

			</div> <!-- cloneWrap-->
		
			<?php $i++; } ?>

		</div> <!-- catSectionWrapper -->	
				
		
		<!-- State / Edition -->
		
		<div class="catSectionWrapper workSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
				if (startsWith($key, 'stateEditionType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) { ?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Edition</div>
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="NWstateEditionType<?php echo $i; ?>" 
								name="NWstateEditionType<?php echo $i; ?>" 
								title="State/Edition type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['createNewWork']['stateEditionType'.$i]) && $_SESSION['createNewWork']['stateEditionType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Type -</option>
								
								<option id="edition" value="Edition" <?php echo(isset($_SESSION['createNewWork']['stateEditionType'.$i]) && $_SESSION['createNewWork']['stateEditionType'.$i] == "Edition") ? 'selected="selected"' : "" ;?>>Edition</option>
								
								<option id="impression" value="Impression" <?php echo(isset($_SESSION['createNewWork']['stateEditionType'.$i]) && $_SESSION['createNewWork']['stateEditionType'.$i] == "Impression") ? 'selected="selected"' : "" ;?>>Impression</option>
								
								<option id="state" value="State" <?php echo(isset($_SESSION['createNewWork']['stateEditionType'.$i]) && $_SESSION['createNewWork']['stateEditionType'.$i] == "State") ? 'selected="selected"' : "" ;?>>State</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['createNewWork']['stateEditionType'.$i]) && $_SESSION['createNewWork']['stateEditionType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="NWstateEdition<?php echo $i; ?>" 
								class="autoWidth"
								name="NWstateEdition<?php echo $i; ?>" 
								placeholder="State/Edition"
								value="<?php echo (isset($_SESSION['createNewWork']['stateEdition'.$i])) ? $_SESSION['createNewWork']['stateEdition'.$i] : ''; ?>" 
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
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
				if (startsWith($key, 'inscriptionType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) { ?>

			<div class="clone_wrap">
			
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Inscription</div>

						<input type="hidden"
							id="NWinscriptionDisplay<?php echo $i; ?>"
							class="cat_display"
							name="NWinscriptionDisplay<?php echo $i; ?>"
							value="1">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="NWinscriptionType<?php echo $i; ?>" 
								name="NWinscriptionType<?php echo $i; ?>" 
								title="Inscription type">
							
								<option id="blank" value="" <?php selectedOption($_SESSION['createNewWork']['inscriptionType'.$i],''); ?>>- Type -</option>
								
								<option id="signature" value="Signature" <?php selectedOption($_SESSION['createNewWork']['inscriptionType'.$i],'Signature'); ?>>Signature</option>
								
								<option id="mark" value="Mark" <?php selectedOption($_SESSION['createNewWork']['inscriptionType'.$i],'Mark'); ?>>Mark</option>
								
								<option id="caption" value="Caption" <?php selectedOption($_SESSION['createNewWork']['inscriptionType'.$i],'Caption'); ?>>Caption</option>
								
								<option id="date" value="Date" <?php selectedOption($_SESSION['createNewWork']['inscriptionType'.$i],'Date'); ?>>Date</option>
								
								<option id="text" value="Text" <?php selectedOption($_SESSION['createNewWork']['inscriptionType'.$i],'Text'); ?>>Text</option>
								
								<option id="translation" value="Translation" <?php selectedOption($_SESSION['createNewWork']['inscriptionType'.$i],'Translation'); ?>>Translation</option>
								
								<option id="other" value="Other" <?php selectedOption($_SESSION['createNewWork']['inscriptionType'.$i],'Other'); ?>>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="NWworkInscription<?php echo $i; ?>" 
								class="autoWidth"
								name="NWworkInscription<?php echo $i; ?>" 
								placeholder="Inscription text"
								value="<?php echo htmlspecialchars($_SESSION['createNewWork']['workInscription'.$i]); ?>" 
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
								id="NWworkInscriptionAuthor<?php echo $i; ?>" 
								name="NWworkInscriptionAuthor<?php echo $i; ?>" 
								value="<?php echo htmlspecialchars($_SESSION['createNewWork']['workInscriptionAuthor'.$i]); ?>" 
								maxlength="500"
								style="width: 120px;"
								placeholder="Inscription author">
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="NWworkInscriptionLocation<?php echo $i; ?>" 
								name="NWworkInscriptionLocation<?php echo $i; ?>" 
								value="<?php echo htmlspecialchars($_SESSION['createNewWork']['workInscriptionLocation'.$i]); ?>" 
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
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
				if (startsWith($key, 'subjectType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) { ?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Subject</div>

						<input type="hidden"
							id="NWsubjectDisplay<?php echo $i; ?>"
							class="cat_display"
							name="NWsubjectDisplay<?php echo $i; ?>"
							value="1">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="NWsubjectType<?php echo $i; ?>" 
								name="NWsubjectType<?php echo $i; ?>"
								title="Subject type">
							
								<option id="blank" value="" <?php selectedOption($_SESSION['createNewWork']['subjectType'.$i], ''); ?>>- Type -</option>
								
								<option id="conceptTopic" value="Topic: concept" <?php selectedOption($_SESSION['createNewWork']['subjectType'.$i], 'Topic: concept'); ?>>Topic: concept</option>
								
								<option id="descriptiveTopic" value="Topic: descriptive" <?php selectedOption($_SESSION['createNewWork']['subjectType'.$i], 'Topic: descriptive'); ?>>Topic: descriptive</option>
								
								<option id="iconographicTopic" value="Topic: iconographic" <?php selectedOption($_SESSION['createNewWork']['subjectType'.$i], 'Topic: iconographic'); ?>>Topic: iconographic</option>
								
								<option id="otherTopic" value="Topic: other" <?php selectedOption($_SESSION['createNewWork']['subjectType'.$i], 'Topic: other'); ?>>Topic: other</option>
								
								<option id="builtworkPlace" value="Place: built work" <?php selectedOption($_SESSION['createNewWork']['subjectType'.$i], 'Place: built work'); ?>>Place: built work</option>
								
								<option id="geographicPlace" value="Place: geographic" <?php selectedOption($_SESSION['createNewWork']['subjectType'.$i], 'Place: geographic'); ?>>Place: geographic</option>
								
								<option id="otherPlace" value="Place: other" <?php selectedOption($_SESSION['createNewWork']['subjectType'.$i], 'Place: other'); ?>>Place: other</option>
								
								<option id="corporateName" value="Name: corporate" <?php selectedOption($_SESSION['createNewWork']['subjectType'.$i], 'Name: corporate'); ?>>Name: corporate</option>
								
								<option id="personalName" value="Name: personal" <?php selectedOption($_SESSION['createNewWork']['subjectType'.$i], 'Name: personal'); ?>>Name: personal</option>
								
								<option id="scientificName" value="Name: scientific" <?php selectedOption($_SESSION['createNewWork']['subjectType'.$i], 'Name: scientific'); ?>>Name: scientific</option>
								
								<option id="familyName" value="Name: family" <?php selectedOption($_SESSION['createNewWork']['subjectType'.$i], 'Name: family'); ?>>Name: family</option>
								
								<option id="otherName" value="Name: other" <?php selectedOption($_SESSION['createNewWork']['subjectType'.$i], 'Name: other'); ?>>Name: other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="NWsubject<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="NWsubject<?php echo $i; ?>" 
								placeholder="Subject"
								value="<?php echo $_SESSION['createNewWork']['subject'.$i];?>" 
								maxlength="500">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="NWsubjectId<?php echo $i; ?>" 
								name="NWsubjectId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['createNewWork'])) ? $_SESSION['createNewWork']['subjectId'.$i] : ''; ?>">
											
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
					
						<textarea id="NWdescription" 
							class="fixedWidth" 
							rows="2" 
							name="NWdescription0" 
							placeholder="Description"
							style="height: 140px; overflow: hidden;"><?php echo (isset($_SESSION['createNewWork']['description0'])) ? htmlspecialchars($_SESSION['createNewWork']['description0']) : ''; ?></textarea>
					
					</div>
				
				</div> <!-- catCellWrapper -->
			
			</div> <!-- catRowWrapper -->
			
		</div> <!-- catSectionWrapper -->
		
		<!-- Rights 1 -->
		
		<div class="catSectionWrapper workSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
				if (startsWith($key, 'rightsType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) { ?>

			<div class="clone_wrap">
			
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Rights</div>
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="NWrightsType<?php echo $i; ?>" 
								name="NWrightsType<?php echo $i; ?>" 
								title="Rights type">
							
								<option id="blank" value="" <?php selectedOption($_SESSION['createNewWork']['rightsType'.$i], ''); ?>>- Type -</option>
								
								<option id="copyrighted" value="Copyrighted" <?php selectedOption($_SESSION['createNewWork']['rightsType'.$i], 'Copyrighted'); ?>>Copyrighted</option>
								
								<option id="publicDomain" value="Public domain" <?php selectedOption($_SESSION['createNewWork']['rightsType'.$i], 'Public domain'); ?>>Public domain</option>
								
								<option id="undetermined" value="Undetermined" <?php selectedOption($_SESSION['createNewWork']['rightsType'.$i], 'Undetermined'); ?>>Undetermined</option>
								
								<option id="other" value="Other" <?php selectedOption($_SESSION['createNewWork']['rightsType'.$i], 'Other'); ?>>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="NWrightsHolder<?php echo $i; ?>" 
								class="autoWidth"
								name="NWrightsHolder<?php echo $i; ?>" 
								value="<?php echo htmlspecialchars($_SESSION['createNewWork']['rightsHolder'.$i]); ?>" 
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
								id="NWrightsText<?php echo $i; ?>" 
								class="autoWidth"
								name="NWrightsText<?php echo $i; ?>" 
								value="<?php echo htmlspecialchars($_SESSION['createNewWork']['rightsText'.$i]); ?>" 
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
			foreach ($_SESSION['createNewWork'] as $key=>$value) {
				if (startsWith($key, 'sourceNameType')) {
					$rows++;
				}
			}
			
			$i = 0;
			while ($i < $rows) { ?>

			<div class="clone_wrap">
			
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Source</div>
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="NWsourceNameType<?php echo $i; ?>" 
								name="NWsourceNameType<?php echo $i; ?>" 
								title="Source name type">
							
								<option id="blank" value="" <?php selectedOption($_SESSION['createNewWork']['sourceNameType'.$i], ''); ?>>- Name Type -</option>
								
								<option id="book" value="Book" <?php selectedOption($_SESSION['createNewWork']['sourceNameType'.$i], 'Book'); ?>>Book</option>
								
								<option id="catalogue" value="Catalogue" <?php selectedOption($_SESSION['createNewWork']['sourceNameType'.$i], 'Catalogue'); ?>>Catalogue</option>
								
								<option id="corpus" value="Corpus" <?php selectedOption($_SESSION['createNewWork']['sourceNameType'.$i], 'Corpus'); ?>>Corpus</option>
								
								<option id="donor" value="Donor" <?php selectedOption($_SESSION['createNewWork']['sourceNameType'.$i], 'Donor'); ?>>Donor</option>
								
								<option id="electronic" value="Electronic" <?php selectedOption($_SESSION['createNewWork']['sourceNameType'.$i], 'Electronic'); ?>>Electronic</option>
								
								<option id="serial" value="Serial" <?php selectedOption($_SESSION['createNewWork']['sourceNameType'.$i], 'Serial'); ?>>Serial</option>
								
								<option id="vendor" value="Vendor" <?php selectedOption($_SESSION['createNewWork']['sourceNameType'.$i], 'Vendor'); ?>>Vendor</option>
								
								<option id="other" value="Other" <?php selectedOption($_SESSION['createNewWork']['sourceNameType'.$i], 'Other'); ?>>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="NWsourceName<?php echo $i; ?>" 
								class="autoWidth"
								name="NWsourceName<?php echo $i; ?>" 
								value="<?php echo htmlspecialchars($_SESSION['createNewWork']['sourceName'.$i]); ?>" 
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
						
							<select id="NWsourceType<?php echo $i; ?>" 
								name="NWsourceType<?php echo $i; ?>" 
								title="Source type">
							
								<option id="blank" value="" <?php selectedOption($_SESSION['createNewWork']['sourceType'.$i], ''); ?>>- Type -</option>
								
								<option id="citation" value="Citation" <?php selectedOption($_SESSION['createNewWork']['sourceType'.$i], 'Citation'); ?>>Citation</option>
								
								<option id="ISBN" value="ISBN" <?php selectedOption($_SESSION['createNewWork']['sourceType'.$i], 'ISBN'); ?>>ISBN</option>
								
								<option id="ISSN" value="ISSN" <?php selectedOption($_SESSION['createNewWork']['sourceType'.$i], 'ISSN'); ?>>ISSN</option>
								
								<option id="ASIN" value="ASIN" <?php selectedOption($_SESSION['createNewWork']['sourceType'.$i], 'ASIN'); ?>>ASIN</option>
								
								<option id="openURL" value="Open URL" <?php selectedOption($_SESSION['createNewWork']['sourceType'.$i], 'Open URL'); ?>>Open URL</option>
								
								<option id="URI" value="URI" <?php selectedOption($_SESSION['createNewWork']['sourceType'.$i], 'URI'); ?>>URI</option>
								
								<option id="vendor" value="Vendor" <?php selectedOption($_SESSION['createNewWork']['sourceType'.$i], 'Vendor'); ?>>Vendor</option>
								
								<option id="other" value="Other" <?php selectedOption($_SESSION['createNewWork']['sourceType'.$i], 'Other'); ?>>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="NWsource<?php echo $i; ?>" 
								class="autoWidth"
								name="NWsource<?php echo $i; ?>" 
								value="<?php echo htmlspecialchars($_SESSION['createNewWork']['source'.$i]); ?>" 
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

		<button type="button" 
			id="createNewWork_submit" 
			name="createNewWork_submit">Submit</button>

	</div>

	<p class="clear"></p>
	
</div> <!-- cataloguingPane -->

<script>

	// Display only the appropriate measurement fields
	$('div#createBuiltWork_module select[id*=measurementType]')
		.each(displayMeasurements);
	$('div#createBuiltWork_module select[id*=measurementType]')
		.change(displayMeasurements);

	// Add & Remove cataloging rows
	$('div#createBuiltWork_module div.addButton').click(addRow_v2);
	$('div#createBuiltWork_module div.removeButton').click(removeRow_v2);

	// Add a CLOSE button to the module
	closeModule_button($('div#createBuiltWork_module'));

	catalogUI_prepFields();
	catalogUI_prepAddRemove();
	authorityIndicators();

	// Perform authority search
	$('div#createBuiltWork_module input.authoritySearch').keyup(debounce(function()
	{
		var term = $(this).val();
		if (term.length > 2 && $.trim(term) != '')
		{
			var fieldName = $(this).attr('name');
			var nearbyAuthorityFieldName = $(this).parent('div.catRowWrapper')
												.find('input[type=hidden]')
												.attr('name');
			catalogUI_searchAuthority(fieldName, nearbyAuthorityFieldName);

			$('form#catalog_form input').not(this).focus(function()
			{
				$('div.resultsWrapper').remove();
			});
		}
	}, 1000));

	// Toggle date range
	$('div#createBuiltWork_module input[type=checkbox][id*=dateRange]').click(function() 
	{
		var endDate = $(this).parents('div#createBuiltWork_module div.catRowWrapper')
			.next('div.catRowWrapper')
			.find('div[id*=dateRangeSpan]');
		endDate.toggle();
	});
	
	// Show/hide date range on load
	$('div#createBuiltWork_module input[type=checkbox][id*=dateRange]')
		.each(catalogUI_dateRange_onLoad);

	$('div#createBuiltWork_module input.autoWidth').each(autoWidth);

	//Show and Toggle specific location row and fields
	$('select[id*=specificLocationType]').each(displaySpecificLocation);
	$('select[id*=specificLocationType]').change(displaySpecificLocation);

	// Adapt cataloging UI to the width of the browser window
	$(window).resize(function()
	{
		$('div#createBuiltWork_module input.autoWidth').each(autoWidth);
	});

	//Hide the related works search and results row
	$('div#createBuiltWork_module [id=relationSearch]').hide();
	$('div#createBuiltWork_module select[id*=relationType]').change(displayRelationSearch);

	// SEARCH FOR RELATED WORK RECORDS (taken from work association)
	$('div#createBuiltWork_module input[id*=relationSearch_submitButton]').click(function(){
		var titleTerm = $(this).parent('div').find('input[id*=searchTitle]').val();
		var agentTerm = $(this).parent('div').find('input[id*=searchAgent]').val();
		var module = $(this).closest('div#workAssoc_wrapper');
		relationAssoc_search(titleTerm, agentTerm, module);	
	});
	
	$('div#createBuiltWork_module div#workAssoc_searchFields input').keypress(function(e){
		if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)){
		var titleTerm = $(this).parent('div').find('input[id*=searchTitle]').val();
		var agentTerm = $(this).parent('div').find('input[id*=searchAgent]').val();
		var module = $(this).closest('div#workAssoc_wrapper');
		relationAssoc_search(titleTerm, agentTerm, module);
		}
	});

	// RESET ALL FIELDS
	$('div#createBuiltWork_module button.catalogUI_clear')
		.click(promptToConfirm)
		.click(
			function()
			{
				$('button#conf_button')
					.click(
						function()
						{
							catalogUI_clearFields('createBuiltWork');
						});
			});

	//Bind authority search color indicators
	$('div#createBuiltWork_module').click(authorityIndicators);

	// User clicks 'Submit'
	$('button#createNewWork_submit')
		.click(promptToConfirm)
		.click(
			function(event)
			{
				$('button#conf_button').click(
					function()
					{
						$('button#conf_button').remove();

						$('button#createNewWork_submit')
							.after('<img src="_assets/_images/loading.gif" style="margin: 0 0 -10px 10px;">');
							
								createBuiltWork_submit();
					});
			});
	

</script>