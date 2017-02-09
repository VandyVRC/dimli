<?php 

if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../_php/_config/session.php');
require_once(MAIN_DIR.'/../_php/_config/connection.php');
require_once(MAIN_DIR.'/../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_catalog'); ?>
 
<div class="cataloguingPane" 
	style="position: relative;">
	
	<div class="catFormWrapper">
		
		<!-- 
				Title
		 -->
		
		<div id="imageTitle_section" class="catSectionWrapper imageSection inUse">
		
			<?php
			// Count the number of rows that begin with 'titleType',
			// in order to determine how many times to iterate.
			// This is performed below for each type of data.
			$rows = 0;
			
			foreach ($_SESSION['image'] as $key=>$value) {
				if (startsWith($key, 'titleType')) {
					$rows++;
				} 
			}
			
			$i = 0;
			while ($i < $rows) { ?>

			<div class="clone_wrap">
		
				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText">Title</div>

						<input type="hidden"
							id="ItitleDisplay<?php echo $i; ?>"
							class="cat_display"
							name="ItitleDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['image']['titleDisplay'.$i])) 
								? $_SESSION['image']['titleDisplay'.$i] 
								: '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="ItitleType<?php echo $i; ?>" 
								name="ItitleType<?php echo $i; ?>" 
								title="Title type">
									
								<option id="blank" value="" <?php selectedOption($_SESSION['image']['titleType'.$i], ''); ?>
								>- Type -</option>
								
								<option id="brandName" value="Brand name" <?php selectedOption($_SESSION['image']['titleType'.$i], 'Brand name'); ?>
								>Brand name</option>
								
								<option id="cited" value="Cited" <?php selectedOption($_SESSION['image']['titleType'.$i], 'Cited'); ?>
								>Cited</option>
								
								<option id="creator" value="Creator" <?php selectedOption($_SESSION['image']['titleType'.$i], 'Creator'); ?>
								>Creator</option>
								
								<option id="descriptive" value="Descriptive" <?php selectedOption($_SESSION['image']['titleType'.$i], 'Descriptive'); ?>
								>Descriptive</option>
								
								<option id="former" value="Former" <?php selectedOption($_SESSION['image']['titleType'.$i], 'Former'); ?>
								>Former</option>
								
								<option id="inscribed" value="Inscribed" <?php selectedOption($_SESSION['image']['titleType'.$i], 'Inscribed'); ?>
								>Inscribed</option>
								
								<option id="owner" value="Owner" <?php selectedOption($_SESSION['image']['titleType'.$i], 'Owner'); ?>
								>Owner</option>
								
								<option id="popular" value="Popular" <?php selectedOption($_SESSION['image']['titleType'.$i], 'Popular'); ?>
								>Popular</option>
								
								<option id="repository" value="Repository" <?php selectedOption($_SESSION['image']['titleType'.$i], 'Repository'); ?>
								>Repository</option>
								
								<option id="translated" value="Translated" <?php selectedOption($_SESSION['image']['titleType'.$i], 'Translated'); ?>
								>Translated</option>
								
								<option id="other" value="Other" <?php selectedOption($_SESSION['image']['titleType'.$i], 'Other'); ?>
								>Other</option>
								
							</select>
							
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="Ititle<?php echo $i; ?>" 
								class="autoWidth"
								name="Ititle<?php echo $i; ?>" 
								placeholder="Title"
								value="<?php echo (isset($_SESSION['image'])) 
									? htmlspecialchars($_SESSION['image']['title'.$i]) 
									: ''; ?>">
						
						</div>
						
						<!-- end catCell -->
					</div> 
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
						
					<!-- end catRowWrapper -->
				</div> 

			</div>
		
			<?php $i++; } ?>
			
			<!-- end catSectionWrapper -->
		</div> 
		
		
		
		<!-- 
				Agent
		 -->
		
		<div class="catSectionWrapper imageSection">
		
			<?php
			$rows = 0;
			foreach ($_SESSION['image'] as $key=>$value) {
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
							id="IagentDisplay<?php echo $i; ?>"
							class="cat_display"
							name="IagentDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['image']['agentDisplay'.$i])) 
									? $_SESSION['image']['agentDisplay'.$i] 
									: '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="IagentAttribution<?php echo $i; ?>" 
								name="IagentAttribution<?php echo $i; ?>" 
								title="Agent attribution">
							
								<option id="blank" value="None" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentAttribution'.$i] == "None") 
										? 'selected="selected"' 
										: "" ;?>
									>None</option>
								
								<option id="after" value="After" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentAttribution'.$i] == "After") 
										? 'selected="selected"' 
										: "" ;?>
									>After</option>
								
								<option id="associateOf" value="Associate of" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentAttribution'.$i] == "Associate of") 
										? 'selected="selected"' 
										: "" ;?>
									>Associate of</option>
								
								<option id="circleOf" value="Circle of" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentAttribution'.$i] == "Circle of") 
										? 'selected="selected"' 
										: "" ;?>
									>Circle of</option>
								
								<option id="followerOf" value="Follower of" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentAttribution'.$i] == "Follower of") 
										? 'selected="selected"' 
										: "" ;?>
									>Follower of</option>
								
								<option id="forgeryOf" value="Forgery of" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentAttribution'.$i] == "Forgery of") 
										? 'selected="selected"' 
										: "" ;?>
									>Forgery of</option>
								
								<option id="officeOf" value="Office of" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentAttribution'.$i] == "Office of") 
										? 'selected="selected"' 
										: "" ;?>
									>Office of</option>
								
								<option id="pupilOf" value="Pupil of" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentAttribution'.$i] == "Pupil of") 
										? 'selected="selected"' 
										: "" ;?>
									>Pupil of</option>
								
								<option id="reworkingOf" value="Reworking of" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentAttribution'.$i] == "Reworking of") 
										? 'selected="selected"' 
										: "" ;?>
									>Reworking of</option>
								
								<option id="schoolOf" value="School of" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentAttribution'.$i] == "School of") 
										? 'selected="selected"' 
										: "" ;?>
									>School of</option>
								
								<option id="sealOf" value="Seal of" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentAttribution'.$i] == "Seal of") 
										? 'selected="selected"' 
										: "" ;?>
									>Seal of</option>
								
								<option id="studioOf" value="Studio of" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentAttribution'.$i] == "Studio of") 
										? 'selected="selected"' 
										: "" ;?>
									>Studio of</option>
								
								<option id="styleOf" value="Style of" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentAttribution'.$i] == "Style of") 
										? 'selected="selected"' 
										: "" ;?>
									>Style of</option>
								
								<option id="workshopOf" value="Workshop of" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentAttribution'.$i] == "Workshop of") 
										? 'selected="selected"' 
										: "" ;?>
									>Workshop of</option>
								
								<option id="copyOf" value="Copy of" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentAttribution'.$i] == "Copy of") 
										? 'selected="selected"' 
										: "" ;?>
									>Copy of</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="IagentRole<?php echo $i; ?>" 
								class="autoWidth"
								name="IagentRole<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['image'])) 
										? $_SESSION['image']['agentRole'.$i] 
										: ''; ?>"
								title="Agent role"
								placeholder="Agent role (e.g. 'artist; painter')">
						
						</div>
						
						<!-- end catCell -->
					</div> 
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
					<!-- end catRowWrapper -->
				</div> 
				
				
			
				<!-- 
						Agent 2
				 -->
				
				<div class="catRowWrapper">
				
					<div class="catRowTitle"></div>
					
					<div class="catCellWrapper">	
					
						<div class="catCell">
						
							<select id="IagentType<?php echo $i; ?>" 
								name="IagentType<?php echo $i; ?>" 
								title="Agent type">
							
								<option id="blank" value="" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentType'.$i] == "") 
										? 'selected="selected"' 
										: "" ;?>
									>- Type -</option>
								
								<option id="personal" value="Personal" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentType'.$i] == "Personal") 
										? 'selected="selected"' 
										: "" ;?>
									>Personal</option>
								
								<option id="corporate" value="Corporate" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentType'.$i] == "Corporate") 
										? 'selected="selected"' 
										: "" ;?>
									>Corporate</option>
								
								<option id="family" value="Family" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentType'.$i] == "Family") 
										? 'selected="selected"' 
										: "" ;?>
									>Family</option>
								
								<option id="other" value="Other" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['agentType'.$i] == "Other") 
										? 'selected="selected"' 
										: "" ;?>
									>Other</option>
							
							</select>
						
						</div>	
						
						<div class="catCell">
						
							<input type="text" 
								id="Iagent<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="Iagent<?php echo $i; ?>" 
								placeholder="Agent"
								value="<?php echo (isset($_SESSION['image'])) 
										? $_SESSION['image']['agent'.$i] 
										: ''; ?>">
						
						</div>
						
						<div class="catCell">

							<input type="hidden" 
								id="IagentId<?php echo $i; ?>"
								name="IagentId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['image'])) 
										? $_SESSION['image']['agentId'.$i] 
										: ''; ?>">
						
						</div>
						
						<!-- end catCell -->
					</div> 
					
					<!-- end catRowWrapper -->
				</div> 

			</div>
			
			<?php $i++; } ?>
			
			<!-- end catSectionWrapper -->
		</div> 
		
		
		
		<!-- 
				Date
		 -->
		
		<div class="catSectionWrapper imageSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['image'] as $key=>$value) {
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
							id="IdateDisplay<?php echo $i; ?>"
							class="cat_display"
							name="IdateDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['image']['dateDisplay'.$i])) 
									? $_SESSION['image']['dateDisplay'.$i] 
									: '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="IdateType<?php echo $i; ?>" 
								name="IdateType<?php echo $i; ?>" 
								title="Date type">
							
								<option id="blank" value="" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['dateType'.$i] == "") 
											? 'selected="selected"' 
											: "" ;?>
									>- Type -</option>
								
								<option id="alteration" value="Alteration" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['dateType'.$i] == "Alteration") 
											? 'selected="selected"' 
											: "" ;?>
									>Alteration</option>
								
								<option id="broadcast" value="Broadcast" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['dateType'.$i] == "Broadcast") 
											? 'selected="selected"' 
											: "" ;?>
									>Broadcast</option>
								
								<option id="bulk" value="Bulk" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['dateType'.$i] == "Bulk") 
											? 'selected="selected"' 
											: "" ;?>
									>Bulk</option>
								
								<option id="commission" value="Commission" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['dateType'.$i] == "Commission") 
											? 'selected="selected"' 
											: "" ;?>
									>Commission</option>
								
								<option id="creation" value="Creation" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['dateType'.$i] == "Creation") 
											? 'selected="selected"' 
											: "" ;?>
									>Creation</option>
								
								<option id="design" value="Design" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['dateType'.$i] == "Design") 
											? 'selected="selected"' 
											: "" ;?>
									>Design</option>
								
								<option id="destruction" value="Destruction" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['dateType'.$i] == "Destruction") 
											? 'selected="selected"' 
											: "" ;?>
									>Destruction</option>
								
								<option id="discovery" value="Discovery" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['dateType'.$i] == "Discovery") 
											? 'selected="selected"' 
											: "" ;?>
									>Discovery</option>
								
								<option id="exhibition" value="Exhibition" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['dateType'.$i] == "Exhibition") 
											? 'selected="selected"' 
											: "" ;?>
									>Exhibition</option>
								
								<option id="inclusive" value="Inclusive" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['dateType'.$i] == "Inclusive") 
											? 'selected="selected"' 
											: "" ;?>
									>Inclusive</option>
								
								<option id="performance" value="Performance" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['dateType'.$i] == "Performance") 
											? 'selected="selected"' 
											: "" ;?>
									>Performance</option>
								
								<option id="publication" value="Publication" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['dateType'.$i] == "Publication") 
											? 'selected="selected"' 
											: "" ;?>
									>Publication</option>
								
								<option id="restoration" value="Restoration" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['dateType'.$i] == "Restoration") 
											? 'selected="selected"' 
											: "" ;?>
									>Restoration</option>
								
								<option id="other" value="Other" 
									<?php echo(isset($_SESSION['image']) && $_SESSION['image']['dateType'.$i] == "Other") 
											? 'selected="selected"' 
											: "" ;?>
									>Other</option>
								
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<!-- "Range" checkbox -->

							<input type="checkbox" 
								id="IdateRange<?php echo $i; ?>" 
								class="checkbox"
								<?php echo (isset($_SESSION['image']['dateRange'.$i]) && !empty($_SESSION['image']['dateRange'.$i])) 
										? 'checked="checked"' 
										: "" ;?>
								name="IdateRange<?php echo $i; ?>" 
								value="range">Range
						
						</div>
						
						<div class="catCell">
						
							<!-- "ca." checkbox -->

							<input type="checkbox" 
								id="IcircaDate<?php echo $i; ?>" 
								class="checkbox"
								<?php echo (isset($_SESSION['image']['circaDate'.$i]) && !empty($_SESSION['image']['circaDate'.$i])) 
										? 'checked="checked"' 
										: "" ;?>
								name="IcircaDate<?php echo $i; ?>" 
								value="circa">ca.
						
						</div>

						<!-- end catCell -->
					</div>

					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>

					<!-- end catRowWrapper -->
				</div>

				<div class="catRowWrapper">
				
					<div class="catRowTitle">
					
						<div class="titleText"></div>
					
					</div>

					<div class="catCellWrapper">
						
						<div class="catCell">
						
							<!-- "startDate" text field -->

							<input type="text" 
								id="IstartDate<?php echo $i; ?>" 
								name="IstartDate<?php echo $i; ?>" 
								maxlength="5" 
								placeholder="Date"
								value="<?php echo (isset($_SESSION['image'])) 
										? $_SESSION['image']['startDate'.$i] 
										: ''; ?>" 
								style="width: 3em;">
						
						</div>
						
						<div class="catCell">
						
							<!-- "startDate" era selection -->

							<select id="IstartDateEra<?php echo $i; ?>" 
								name="IstartDateEra<?php echo $i; ?>">
							
								<option id="CE" value="CE" 
									<?php echo (isset($_SESSION['image']['startDateEra'.$i]) && $_SESSION['image']['startDateEra'.$i] == 'CE') 
											? 'selected="selected"' 
											: "" ;?>
									>CE</option>

								<option id="BCE" value="BCE" 
									<?php echo (isset($_SESSION['image']['startDateEra'.$i]) && $_SESSION['image']['startDateEra'.$i] == 'BCE') 
											? 'selected="selected"' 
											: "" ;?>
									>BCE</option>
							
							</select>
						
						</div>
						
						<div id="IdateRangeSpan<?php echo $i; ?>" 
							style="display: inline-block;">
						
							<div class="catCell">to</div>
							
							<div class="catCell">
							
								<!-- "endDate" text field -->

								<input type="text" 
									id="IendDate<?php echo $i; ?>" 
									name="IendDate<?php echo $i; ?>" 
									maxlength="5" 
									placeholder="Date"
									value="<?php echo (isset($_SESSION['image'])) 
											? $_SESSION['image']['endDate'.$i] 
											: ''; ?>" 
									style="width: 3em;">
								
							</div>
							
							<div class="catCell">
							
								<!-- "endDate" era selection -->

								<select id="IendDateEra<?php echo $i; ?>" 
									name="IendDateEra<?php echo $i; ?>">
							
									<option id="CE" value="CE" 
										<?php echo (isset($_SESSION['image']['endDateEra'.$i]) && $_SESSION['image']['endDateEra'.$i] == 'CE') 
												? 'selected="selected"' 
												: "" ;?>
										>CE</option>

									<option id="BCE" value="BCE" 
										<?php echo (isset($_SESSION['image']['endDateEra'.$i]) && $_SESSION['image']['endDateEra'.$i] == 'BCE') 
												? 'selected="selected"' 
												: "" ;?>
										>BCE</option>
								
								</select>
							
							</div>
						
							<!-- dateRangeSpan -->
						</div> 
					
						<!-- catCellWrapper -->
					</div> 
					
					<!-- catRowWrapper -->
				</div> 

			</div>
		
			<?php $i++; } ?>
		
			<!-- catSectionWrapper -->
		</div> 
		
		
		
		<!-- 
				Material
		 -->
		
		<div class="catSectionWrapper imageSection">
		
			<?php
			$rows = 0;
			foreach ($_SESSION['image'] as $key=>$value) {
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
							id="ImaterialDisplay<?php echo $i; ?>"
							class="cat_display"
							name="ImaterialDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['image']['materialDisplay'.$i])) 
									? $_SESSION['image']['materialDisplay'.$i] 
									: '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="ImaterialType<?php echo $i; ?>" 
								name="ImaterialType<?php echo $i; ?>" 
								title="Material type">
							
								<option id="blank" value="" 
									<?php echo (isset($_SESSION['image']['materialType'.$i]) && $_SESSION['image']['materialType'.$i] == '') 
											? 'selected="selected"' 
											: ''; ?>
									>- Type -</option>
								
								<option id="medium" value="Medium" 
									<?php echo (isset($_SESSION['image']['materialType'.$i]) && $_SESSION['image']['materialType'.$i] == 'Medium') 
											? 'selected="selected"' 
											: ''; ?>
									>Medium</option>
								
								<option id="support" value="Support" 
									<?php echo (isset($_SESSION['image']['materialType'.$i]) && $_SESSION['image']['materialType'.$i] == 'Support') 
											? 'selected="selected"' 
											: ''; ?>
									>Support</option>
								
								<option id="other" value="Other" 
									<?php echo (isset($_SESSION['image']['materialType'.$i]) && $_SESSION['image']['materialType'.$i] == 'Other') 
											? 'selected="selected"' 
											: ''; ?>
									>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="Imaterial<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="Imaterial<?php echo $i; ?>"
								placeholder="Material" 
								value="<?php echo (isset($_SESSION['image'])) 
										? $_SESSION['image']['material'.$i] 
										: ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="ImaterialId<?php echo $i; ?>"
								name="ImaterialId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['image'])) 
										? $_SESSION['image']['materialId'.$i] 
										: ''; ?>">
						
						</div>
					
						<!-- end catCell -->
					</div> 
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
					<!-- end catRowWrapper -->
				</div> 

			</div>
			
			<?php $i++; } ?>
		
			<!-- end catSectionWrapper -->
		</div> 
		
		
		
		<!-- 
				Technique
		 -->
		
		<div class="catSectionWrapper imageSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['image'] as $key=>$value) {
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
							id="ItechniqueDisplay<?php echo $i; ?>"
							class="cat_display"
							name="ItechniqueDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['image']['techniqueDisplay'.$i])) 
									? $_SESSION['image']['techniqueDisplay'.$i] 
									: '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="Itechnique<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="Itechnique<?php echo $i; ?>" 
								placeholder="Technique"
								value="<?php echo (isset($_SESSION['image'])) 
										? $_SESSION['image']['technique'.$i] 
										: ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="ItechniqueId<?php echo $i; ?>"
								name="ItechniqueId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['image'])) 
										? $_SESSION['image']['techniqueId'.$i] 
										: ''; ?>">
						
						</div>
					
						<!-- end catCell -->
					</div> 
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
					<!-- end catRowWrapper -->
				</div> 

			</div>
			
			<?php $i++; } ?>
			
			<!-- end catSectionWrapper -->
		</div> 
		
		
		
		<!-- 
				Work Type
		 -->
		
		<div class="catSectionWrapper imageSection">
		
			<?php
			$rows = 0;
			foreach ($_SESSION['image'] as $key=>$value) {
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
							id="IworkTypeDisplay<?php echo $i; ?>"
							class="cat_display"
							name="IworkTypeDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['image']['workTypeDisplay'.$i])) 
									? $_SESSION['image']['workTypeDisplay'.$i] 
									: '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="IworkType<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="IworkType<?php echo $i; ?>" 
								placeholder="Work Type"
								value="<?php echo (isset($_SESSION['image'])) 
										? $_SESSION['image']['workType'.$i] 
										: ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="IworkTypeId<?php echo $i; ?>"
								name="IworkTypeId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['image'])) 
										? $_SESSION['image']['workTypeId'.$i] 
										: ''; ?>">
						
						</div>
					
						<!-- row catCell -->
					</div>
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
					<!-- end catRowWrapper -->
				</div>

			</div>
		
			<?php $i++; } ?>
			
			<!-- end catSectionWrapper -->
		</div>
		
		
		
	<!-- 
				Measurements
		 -->
		
		<div class="catSectionWrapper imageSection">
		
			<?php
			$rows = 0;
			foreach ($_SESSION['image'] as $key=>$value) {
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
							id="ImeasurementDisplay<?php echo $i; ?>"
							class="cat_display"
							name="ImeasurementDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['image']['measurementDisplay'.$i])) 
									? $_SESSION['image']['measurementDisplay'.$i] 
									: '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="ImeasurementType<?php echo $i; ?>" 
								name="ImeasurementType<?php echo $i; ?>"
								title="Measurement type">
							
								<option id="blank" value="" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "") 
											? 'selected="selected"' 
											: "" ;?>
									>- Measurement -</option>
								
								<option id="area" value="Area" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "Area") 
											? 'selected="selected"' 
											: "" ;?>
									>Area</option>
								
								<option id="bitDepth" value="Bit depth" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "Bit depth") 
											? 'selected="selected"' 
											: "" ;?>
									>Bit depth</option>
								
								<option id="circumference" value="Circumference" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "Circumference") 
											? 'selected="selected"' 
											: "" ;?>
									>Circumference</option>
								
								<option id="count" value="Count" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "Count") 
											? 'selected="selected"' 
											: "" ;?>
									>Count</option>
								
								<option id="depth" value="Depth" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "Depth") 
											? 'selected="selected"' 
											: "" ;?>
									>Depth</option>
								
								<option id="diameter" value="Diameter" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "Diameter") 
											? 'selected="selected"' 
											: "" ;?>
									>Diameter</option>
								
								<option id="distanceBetween" value="Distance between" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "Distance between") 
											? 'selected="selected"' 
											: "" ;?>
									>Distance between</option>
								
								<option id="duration" value="Duration" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "Duration") 
											? 'selected="selected"' 
											: "" ;?>
									>Duration</option>
								
								<option id="fileSize" value="File size" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "File size") 
											? 'selected="selected"' 
											: "" ;?>
									>File size</option>
								
								<option id="height" value="Height" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "Height") 
											? 'selected="selected"' 
											: "" ;?>
									>Height</option>
								
								<option id="length" value="Length" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "Length") 
											? 'selected="selected"' 
											: "" ;?>
									>Length</option>
								
								<option id="resolution" value="Resolution" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "Resolution") 
											? 'selected="selected"' 
											: "" ;?>
									>Resolution</option>
								
								<option id="runningTime" value="Running time" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "Running time") 
											? 'selected="selected"' 
											: "" ;?>
									>Running time</option>
								
								<option id="scale" value="Scale" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "Scale") 
											? 'selected="selected"' 
											: "" ;?>
									>Scale</option>
								
								<option id="size" value="Size" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "Size") 
											? 'selected="selected"' 
											: "" ;?>
									>Size</option>
								
								<option id="weight" value="Weight" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "Weight") 
											? 'selected="selected"' 
											: "" ;?>
									>Weight</option>
								
								<option id="width" value="Width" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "Width") 
											? 'selected="selected"' 
											: "" ;?>
									>Width</option>
								
								<option id="other" value="Other" 
									<?php echo(isset($_SESSION['image']['measurementType'.$i]) && $_SESSION['image']['measurementType'.$i] == "Other") 
											? 'selected="selected"' 
											: "" ;?>
									>Other</option>
							
							</select>
						
						</div>
						
						<div id="IcountMeasurement<?php echo $i; ?>" class="catCell">
						
							Count:
						
						</div>
						
						<div id="ImeasurementFieldDiv1_<?php echo $i; ?>" class="catCell">
						
							<!-- Basic measurement text field -->
							
							<input type="text" 
								id="ImeasurementField1_<?php echo $i; ?>" 
								name="ImeasurementField1_<?php echo $i; ?>"
								placeholder="" 
								value="<?php echo $_SESSION['image']['measurementField1_'.$i]; ?>" 
								style="width: 2.25em;">
						
						</div>
						
						<div id="IbitMeasurement<?php echo $i; ?>" class="catCell">
						
							bit
						
						</div>
						
						<div id="IcommonMeasurement1_<?php echo $i; ?>" 
							class="catCell">
						
							<select id="IcommonMeasurementList1_<?php echo $i; ?>" 
								name="IcommonMeasurementList1_<?php echo $i; ?>">
								
								<option id="cm" value="cm" 
									<?php echo (isset($_SESSION['image']['commonMeasurementList1_'.$i]) && $_SESSION['image']['commonMeasurementList1_'.$i] == 'cm') 
											? 'selected="selected"' 
											: ''; ?>
									>cm</option>
								
								<option id="m" value="m" 
									<?php echo (isset($_SESSION['image']['commonMeasurementList1_'.$i]) && $_SESSION['image']['commonMeasurementList1_'.$i] == 'm') 
											? 'selected="selected"' 
											: ''; ?>
									>m</option>
								
								<option id="km" value="km" 
									<?php echo (isset($_SESSION['image']['commonMeasurementList1_'.$i]) && $_SESSION['image']['commonMeasurementList1_'.$i] == 'km') 
											? 'selected="selected"' 
											: ''; ?>
									>km</option>
								
								<option id="in" value="in" 
									<?php echo (isset($_SESSION['image']['commonMeasurementList1_'.$i]) && $_SESSION['image']['commonMeasurementList1_'.$i] == 'in') 
											? 'selected="selected"' 
											: ''; ?>
									>in</option>
								
								<option id="ft" value="ft" 
									<?php echo (isset($_SESSION['image']['commonMeasurementList1_'.$i]) && $_SESSION['image']['commonMeasurementList1_'.$i] == 'ft') 
											? 'selected="selected"' 
											: ''; ?>
									>ft</option>
							
							</select>
						
						</div>
						
						<div id="IinchesMeasurement<?php echo $i; ?>" 
							class="inline">
						
							<div class="catCell">,</div> <!-- comma -->
								
							<div class="catCell">
							
								<input type="text" 
									id="IinchesValue<?php echo $i; ?>" 
									name="IinchesValue<?php echo $i; ?>" 
									placeholder="in."
									value="<?php echo $_SESSION['image']['inchesValue'.$i]; ?>" 
									maxlength="5" 
									style="width: 2em;">
								
							</div>
							
						</div>
						
						<div id="IareaMeasurement<?php echo $i; ?>" 
							class="catCell">
						
							<select id="IareaMeasurementList<?php echo $i; ?>" 
								name="IareaMeasurementList<?php echo $i; ?>">
								
								<option id="cm2" value="cm2" 
									<?php echo (isset($_SESSION['image']['areaMeasurementList'.$i]) && $_SESSION['image']['areaMeasurementList'.$i] == 'cm2') 
											? 'selected="selected"' 
											: ''; ?>
									>sq. cm</option>
								
								<option id="m2" value="m2" 
									<?php echo (isset($_SESSION['image']['areaMeasurementList'.$i]) && $_SESSION['image']['areaMeasurementList'.$i] == 'm2') 
											? 'selected="selected"' 
											: ''; ?>
									>sq. m</option>
								
								<option id="km2" value="km2" 
									<?php echo (isset($_SESSION['image']['areaMeasurementList'.$i]) && $_SESSION['image']['areaMeasurementList'.$i] == 'km2') 
											? 'selected="selected"' 
											: ''; ?>
									>sq. km</option>
								
								<option id="in2" value="in2" 
									<?php echo (isset($_SESSION['image']['areaMeasurementList'.$i]) && $_SESSION['image']['areaMeasurementList'.$i] == 'in2') 
											? 'selected="selected"' 
											: ''; ?>
									>sq. in</option>
								
								<option id="ft2" value="ft2" <?php echo (isset($_SESSION['image']['areaMeasurementList'.$i]) && $_SESSION['image']['areaMeasurementList'.$i] == 'ft2') ? 'selected="selected"' : ''; ?>>sq. ft</option>
								
								<option id="acres" value="acres" <?php echo (isset($_SESSION['image']['areaMeasurementList'.$i]) && $_SESSION['image']['areaMeasurementList'.$i] == 'acres') ? 'selected="selected"' : ''; ?>>acre(s)</option>
							
							</select>
						
						</div>
						
						<div id="ItimeMeasurement<?php echo $i; ?>" class="inline">
						
							<div class="catCell">
							
								<input type="text" 
									id="Idays<?php echo $i; ?>" 
									name="Idays<?php echo $i; ?>"
									placeholder="Day" 
									value="<?php echo($_SESSION['image']['days'.$i]!='0')?$_SESSION['image']['days'.$i]:'';?>" 
									maxlength="10" 
									style="width: 1.7em;">
							
							</div>
							
							<div class="catCell">
							
								<input type="text" 
									id="Ihours<?php echo $i; ?>" 
									name="Ihours<?php echo $i; ?>"
									placeholder="Hrs" 
									value="<?php echo($_SESSION['image']['hours'.$i]!='0')?$_SESSION['image']['hours'.$i]:'';?>" 
									maxlength="10" 
									style="width: 1.7em;">
							
							</div>
							
							<div class="catCell">
							
								<input type="text" 
									id="Iminutes<?php echo $i; ?>" 
									name="Iminutes<?php echo $i; ?>" 
									placeholder="Min"
									value="<?php echo($_SESSION['image']['minutes'.$i]!='0')?$_SESSION['image']['minutes'.$i]:'';?>" 
									maxlength="10" 
									style="width: 1.7em;">
							
							</div>
							
							<div class="catCell">
							
								<input type="text" 
									id="Iseconds<?php echo $i; ?>" 
									name="Iseconds<?php echo $i; ?>" 
									placeholder="Sec"
									value="<?php echo($_SESSION['image']['seconds'.$i]!='0')?$_SESSION['image']['seconds'.$i]:'';?>" 
									maxlength="10" 
									style="width: 1.7em;">
						
							</div>
							
						</div>
						
						<div id="IfileMeasurement<?php echo $i; ?>" 
							class="catCell">
						
							<select id="IfileSize<?php echo $i; ?>" 
								name="IfileSize<?php echo $i; ?>">
								
								<option id="kb" value="kb" <?php echo (isset($_SESSION['image']['fileSize'.$i]) && $_SESSION['image']['fileSize'.$i] == 'kb') ? 'selected="selected"' : ''; ?>>KB</option>
								<option id="mb" value="mb" <?php echo (isset($_SESSION['image']['fileSize'.$i]) && $_SESSION['image']['fileSize'.$i] == 'mb') ? 'selected="selected"' : ''; ?>>MB</option>
								<option id="gb" value="gb" <?php echo (isset($_SESSION['image']['fileSize'.$i]) && $_SESSION['image']['fileSize'.$i] == 'gb') ? 'selected="selected"' : ''; ?>>GB</option>
								<option id="tb" value="tb" <?php echo (isset($_SESSION['image']['fileSize'.$i]) && $_SESSION['image']['fileSize'.$i] == 'tb') ? 'selected="selected"' : ''; ?>>TB</option>
							
							</select>
						
						</div>
						
						<div id="IresolutionMeasurement<?php echo $i; ?>" 
							class="inline">
						
							<div class="catCell">
							
								<input type="text" 
									id="IresolutionWidth<?php echo $i; ?>" 
									name="IresolutionWidth<?php echo $i; ?>" 
									placeholder="Width"
									maxlength="10" 
									value="<?php echo $_SESSION['image']['resolutionWidth'.$i]; ?>" 
									style="width: 3em;">
							
							</div>

							<div class="catCell">x</div> <!-- "x" -->

							<div class="catCell">
							
								<input type="text" 
									id="IresolutionHeight<?php echo $i; ?>" 
									name="IresolutionHeight<?php echo $i; ?>" 
									placeholder="Height"
									maxlength="10" 
									value="<?php echo $_SESSION['image']['resolutionHeight'.$i]; ?>" 
									style="width: 3em;">

							</div>
							
						</div>
						
						<div id="IweightMeasurement<?php echo $i; ?>" 
							class="catCell">
						
							<select id="IweightUnit<?php echo $i; ?>" 
								name="IweightUnit<?php echo $i; ?>">
								
								<option id="g" value="g" <?php selectedOption($_SESSION['image']['weightUnit'.$i], 'g'); ?>>g</option>

								<option id="kg" value="kg" <?php selectedOption($_SESSION['image']['weightUnit'.$i], 'kg'); ?>>kg</option>

								<option id="lb" value="lb" <?php selectedOption($_SESSION['image']['weightUnit'.$i], 'lb'); ?>>lb</option>
							
							</select>
						
						</div>
						
						<div id="IotherMeasurement<?php echo $i; ?>" class="inline">
						
							<!-- <div class="catCell">Description:</div> -->
							
							<!-- <div class="catCell">
							
								<input type="text" 
									id="IotherMeasurementDescription<?php //echo $i; ?>" 
									name="IotherMeasurementDescription<?php //echo $i; ?>" 
									placeholder="Description"
									maxlength="500" 
									value="<?php //echo $_SESSION['image']['otherMeasurementDescription'.$i]; ?>">
							
							</div> -->
						
						</div>
					
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->

				<div class ="catRowWrapper">

					<div class ="catCellWrapper">

						<div class="catRowTitle"></div> 

							<div id="ImeasurementFieldDiv2_<?php echo $i; ?>" 
								class="inline">
							
								<div class="catCell">equal to</div> <!--  "equal to" -->
								
								<div class="catCell">
								
									<input type="text" 
										id="ImeasurementField2_<?php echo $i; ?>" 
										name="ImeasurementField2_<?php echo $i; ?>" 
										value="<?php echo $_SESSION['image']['measurementField2_'.$i]; ?>"
										style="width: 5em;">
								
								</div>
							
							</div>
							
							<div id="IcommonMeasurement2_<?php echo $i; ?>" 
								class="catCell">
							
								<select id="IcommonMeasurementList2_<?php echo $i; ?>" 
									name="IcommonMeasurementList2_<?php echo $i; ?>">
									
									<option id="cm" value="cm" 
										<?php echo (isset($_SESSION['image']['commonMeasurementList2_'.$i]) && $_SESSION['image']['commonMeasurementList2_'.$i] == 'cm') 
												? 'selected="selected"' 
												: ''; ?>
										>cm</option>
									
									<option id="m" value="m" 
										<?php echo (isset($_SESSION['image']['commonMeasurementList2_'.$i]) && $_SESSION['image']['commonMeasurementList2_'.$i] == 'm') 
												? 'selected="selected"' 
												: ''; ?>
										>m</option>
									
									<option id="km" value="km" 
										<?php echo (isset($_SESSION['image']['commonMeasurementList2_'.$i]) && $_SESSION['image']['commonMeasurementList2_'.$i] == 'km') 
												? 'selected="selected"' 
												: ''; ?>
										>km</option>
									
									<option id="in" value="in" 
										<?php echo (isset($_SESSION['image']['commonMeasurementList2_'.$i]) && $_SESSION['image']['commonMeasurementList2_'.$i] == 'in') 
												? 'selected="selected"' 
												: ''; ?>
										>in</option>
									
									<option id="ft" value="ft" 
										<?php echo (isset($_SESSION['image']['commonMeasurementList2_'.$i]) && $_SESSION['image']['commonMeasurementList2_'.$i] == 'ft') 
												? 'selected="selected"' 
												: ''; ?>
										>ft</option>
								
								</select>
							
							</div>

						</div>
							
					</div> <!-- catRowWrapper -->

			</div>
			
			<?php $i++; } ?>
		
		</div> <!-- catSectionWrapper -->
		
		<!-- 
				Cultural Context
		 -->
		
		<div class="catSectionWrapper imageSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['image'] as $key=>$value) {
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
							id="IculturalContextDisplay<?php echo $i; ?>"
							class="cat_display"
							name="IculturalContextDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['image']['culturalContextDisplay'.$i])) 
									? $_SESSION['image']['culturalContextDisplay'.$i] 
									: '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="IculturalContext<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="IculturalContext<?php echo $i; ?>" 
								placeholder="Cultural Context"
								value="<?php echo (isset($_SESSION['image'])) 
										? $_SESSION['image']['culturalContext'.$i] 
										: ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="IculturalContextId<?php echo $i; ?>"
								name="IculturalContextId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['image'])) 
										? $_SESSION['image']['culturalContextId'.$i] 
										: ''; ?>">
						
						</div>
					
						<!-- catCellWrapper -->
					</div> 
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
					<!-- catRowWrapper -->
				</div> 

			</div>
		
			<?php $i++; } ?>
			
			<!-- catSectionWrapper -->
		</div> 

		<!-- 
				Style Period
		 -->
		
		<div class="catSectionWrapper imageSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['image'] as $key=>$value) {
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
							id="IstylePeriodDisplay<?php echo $i; ?>"
							class="cat_display"
							name="IstylePeriodDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['image']['stylePeriodDisplay'.$i])) 
									? $_SESSION['image']['stylePeriodDisplay'.$i] 
									: '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="IstylePeriod<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="IstylePeriod<?php echo $i; ?>" 
								placeholder="Style Period"
								value="<?php echo (isset($_SESSION['image'])) 
										? $_SESSION['image']['stylePeriod'.$i] 
										: ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="IstylePeriodId<?php echo $i; ?>"
								name="IstylePeriodId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['image'])) 
										? $_SESSION['image']['stylePeriodId'.$i] 
										: ''; ?>">
						
						</div>
					
						<!-- catCellWrapper -->
					</div> 
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
					<!-- catRowWrapper -->
				</div> 

			</div>
		
			<?php $i++; } ?>
			
			<!-- catSectionWrapper -->
		</div> 
		
		<!-- 
				Location 1
		 -->
		
		<div class="catSectionWrapper imageSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['image'] as $key=>$value) {
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
							id="IlocationDisplay<?php echo $i; ?>"
							class="cat_display"
							name="IlocationDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['image']['locationDisplay'.$i])) 
									? $_SESSION['image']['locationDisplay'.$i] 
									: '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="Ilocation<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="Ilocation<?php echo $i; ?>" 
								placeholder="Location"
								value="<?php echo (isset($_SESSION['image'])) 
										? $_SESSION['image']['location'.$i] 
										: ''; ?>">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="IlocationId<?php echo $i; ?>"
								name="IlocationId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['image'])) 
										? $_SESSION['image']['locationId'.$i] 
										: ''; ?>">
						
						</div>
					
						<!-- catCellWrapper -->
					</div> 
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
					<!-- catRowWrapper -->
				</div> 
				
				<!-- 
						Location 2
				 -->
				
				<div class="catRowWrapper" style="position: relative;">
				
					<div class="catRowTitle"></div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="IlocationType<?php echo $i; ?>" 
								name="IlocationType<?php echo $i; ?>"
								title="Location type">
							
								<option id="blank" value="" 
									<?php echo(isset($_SESSION['image']['locationType'.$i]) && $_SESSION['image']['locationType'.$i] == "") 
											? 'selected="selected"' 
											: "" ;?>
									>- Type -</option>
								
								<option id="creation" value="Creation" 
									<?php echo(isset($_SESSION['image']['locationType'.$i]) && $_SESSION['image']['locationType'.$i] == "Creation") 
											? 'selected="selected"' 
											: "" ;?>
									>Creation</option>
								
								<option id="discovery" value="Discovery" 
									<?php echo(isset($_SESSION['image']['locationType'.$i]) && $_SESSION['image']['locationType'.$i] == "Discovery") 
											? 'selected="selected"' 
											: "" ;?>
									>Discovery</option>
								
								<option id="exhibition" value="Exhibition" 
									<?php echo(isset($_SESSION['image']['locationType'.$i]) && $_SESSION['image']['locationType'.$i] == "Exhibition") 
											? 'selected="selected"' 
											: "" ;?>
									>Exhibition</option>
								
								<option id="formerOwner" value="Former owner" 
									<?php echo(isset($_SESSION['image']['locationType'.$i]) && $_SESSION['image']['locationType'.$i] == "Former owner") 
											? 'selected="selected"' 
											: "" ;?>
									>Former owner</option>
								
								<option id="formerRepository" value="Former repository" 
									<?php echo(isset($_SESSION['image']['locationType'.$i]) && $_SESSION['image']['locationType'.$i] == "Former repository") 
											? 'selected="selected"' 
											: "" ;?>
									>Former repository</option>
								
								<option id="formerSite" value="Former site" 
									<?php echo(isset($_SESSION['image']['locationType'.$i]) && $_SESSION['image']['locationType'.$i] == "Former site") 
											? 'selected="selected"' 
											: "" ;?>
									>Former site</option>
								
								<option id="installation" value="Installation" 
									<?php echo(isset($_SESSION['image']['locationType'.$i]) && $_SESSION['image']['locationType'.$i] == "Installation") 
											? 'selected="selected"' 
											: "" ;?>
									>Installation</option>
								
								<option id="intended" value="Intended" 
									<?php echo(isset($_SESSION['image']['locationType'.$i]) && $_SESSION['image']['locationType'.$i] == "Intended") 
											? 'selected="selected"' 
											: "" ;?>
									>Intended</option>
								
								<option id="owner" value="Owner" 
									<?php echo(isset($_SESSION['image']['locationType'.$i]) && $_SESSION['image']['locationType'.$i] == "Owner") 
											? 'selected="selected"' 
											: "" ;?>
									>Owner</option>
								
								<option id="performance" value="Performance" 
									<?php echo(isset($_SESSION['image']['locationType'.$i]) && $_SESSION['image']['locationType'.$i] == "Performance") 
											? 'selected="selected"' 
											: "" ;?>
									>Performance</option>
								
								<option id="publication" value="Publication" 
									<?php echo(isset($_SESSION['image']['locationType'.$i]) && $_SESSION['image']['locationType'.$i] == "Publication") 
											? 'selected="selected"' 
											: "" ;?>
									>Publication</option>
								
								<option id="repository" value="Repository" 
									<?php echo(isset($_SESSION['image']['locationType'.$i]) && $_SESSION['image']['locationType'.$i] == "Repository") 
											? 'selected="selected"' 
											: "" ;?>
									>Repository</option>
								
								<option id="site" value="Site" 
									<?php echo(isset($_SESSION['image']['locationType'.$i]) && $_SESSION['image']['locationType'.$i] == "Site") 
											? 'selected="selected"' 
											: "" ;?>
									>Site</option>
								
								<option id="other" value="Other" 
									<?php echo(isset($_SESSION['image']['locationType'.$i]) && $_SESSION['image']['locationType'.$i] == "Other") 
											? 'selected="selected"' 
											: "" ;?>
									>Other</option>
							
							</select>
						
						</div>

						<div class="catCell">
						
							<select id="IlocationNameType<?php echo $i; ?>" 
								name="IlocationNameType<?php echo $i; ?>" 
								title="Location name type">
							
								<option id="blank" value="" 
									<?php echo(isset($_SESSION['image']['locationNameType'.$i]) && $_SESSION['image']['locationNameType'.$i] == "") 
											? 'selected="selected"' 
											: "" ;?>
									>- Name Type -</option>
								
								<option id="corporate" value="Corporate" 
									<?php echo(isset($_SESSION['image']['locationNameType'.$i]) && $_SESSION['image']['locationNameType'.$i] == "Corporate") 
											? 'selected="selected"' 
											: "" ;?>
									>Corporate</option>
								
								<option id="geographic" value="Geographic" 
									<?php echo(isset($_SESSION['image']['locationNameType'.$i]) && $_SESSION['image']['locationNameType'.$i] == "Geographic") 
											? 'selected="selected"' 
											: "" ;?>
									>Geographic</option>
								
								<option id="personal" value="Personal" 
									<?php echo(isset($_SESSION['image']['locationNameType'.$i]) && $_SESSION['image']['locationNameType'.$i] == "Personal") 
											? 'selected="selected"' 
											: "" ;?>
									>Personal</option>
								
								<option id="other" value="Other" 
									<?php echo(isset($_SESSION['image']['locationNameType'.$i]) && $_SESSION['image']['locationNameType'.$i] == "Other") 
											? 'selected="selected"' 
											: "" ;?>
									>Other</option>
							
							</select>
						
						</div>
							
						<!-- end catCell -->
					</div>
						
					<!-- end catRowWrapper -->
				</div>

			</div>
		
			<?php $i++; } ?>
			
			<!-- catSectionWrapper -->
		</div>
		
		<!-- Specific Location -->
		
		<div class="catSectionWrapper image">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['image'] as $key=>$value) {
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
							id="IspecificLocationDisplay<?php echo $i; ?>"
							class="cat_display"
							name="IspecificLocationDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['image']['specificLocationDisplay'.$i])) ? $_SESSION['image']['specificLocationDisplay'.$i] : '1'; ?>">

						</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="IspecificLocationType<?php echo $i; ?>" 
								name="IspecificLocationType<?php echo $i; ?>" 
								title="Specific location type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['image']['specificLocationType'.$i]) && $_SESSION['image']['specificLocationType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Type -</option>
								
								<option id="Address" value="Address" <?php echo(isset($_SESSION['image']['specificLocationType'.$i]) && $_SESSION['image']['specificLocationType'.$i] == "Address") ? 'selected="selected"' : "" ;?>>Address</option>

								<option id="LatLng" value="LatLng" <?php echo(isset($_SESSION['image']['specificLocationType'.$i]) && $_SESSION['image']['specificLocationType'.$i] == "LatLng") ? 'selected="selected"' : "" ;?>>LatLng</option>
								
								<option id="Note" value="Note" <?php echo(isset($_SESSION['image']['specificLocationType'.$i]) && $_SESSION['image']['specificLocationType'.$i] == "Note") ? 'selected="selected"' : "" ;?>>Note</option>
							</select>
						
						</div>
					</div><!-- catCellWrapper -->

					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->	

						
				
				<div id="specificLocationRow" class="catRowWrapper">	
				
	
					<div class="catRowTitle"></div>				
					<div class="catCellWrapper">

							<div id="IspecificLocationAddress" class="catCell">
	
								<input type="text" 
									id="IspecificLocationAddress<?php echo $i; ?>" 
									style="width: 14em;"
									name="IspecificLocationAddress<?php echo $i; ?>" 
									placeholder="Street Address"
									value="<?php echo (isset($_SESSION['image']['specificLocationAddress'.$i])) ? $_SESSION['image']['specificLocationAddress'.$i] : ''; ?>" 
									title="Specific location address">
					
							</div><!-- catCell -->

							<div id="IspecificLocationZip" class="catCell">

								<input type="text" 
									id="IspecificLocationZip<?php echo $i; ?>" 
									style="width: 5.5em"
									name="IspecificLocationZip<?php echo $i; ?>" 
									placeholder="Postal Code"
									value="<?php echo (isset($_SESSION['image']['specificLocationZip'.$i])) ? $_SESSION['image']['specificLocationZip'.$i] : ''; ?>" 
									title="Specific location zip">

							</div><!-- catCell -->


						<div id="IspecificLocationLat" class="catCell">

							<input type="text" 
								id="IspecificLocationLat<?php echo $i; ?>" 
								style="width: 6.5em"
								name="IspecificLocationLat<?php echo $i; ?>" 
								placeholder="Latitude"
								value="<?php echo (isset($_SESSION['image']['specificLocationLat'.$i])) ? $_SESSION['image']['specificLocationLat'.$i] : ''; ?>" 
								title="Specific location latitude">

						</div><!-- catCell -->

						<div id="IspecificLocationLong" class="catCell">
				
							<input type="text"
								id="IspecificLocationLong<?php echo $i; ?>" 
								style="width: 6.5em"
								name="IspecificLocationLong<?php echo $i; ?>" 
								placeholder="Longitude"
								value="<?php echo (isset($_SESSION['image']['specificLocationLong'.$i])) ? $_SESSION['image']['specificLocationLong'.$i] : ''; ?>" 
								title="Specific location longitude"> 

		
						</div><!-- catCell -->

					</div><!-- catCellWrapper -->
				
				</div> <!-- catRowWrapper -->

				<div id="specificLocationNoteRow" class="catRowWrapper" style="height: 7em; padding-top: 3px; padding-bottom: 0; position: relative;">				

					<div class="catCellWrapper">

						<div  id="IspecificLocationNote" class="catCell">
							
							<textarea id="IspecificLocationNote<?php echo $i; ?>" 
							class="fixedWidth" 
							rows="2"
							style="height: 6.5em; width: 33em; overflow: hidden;"
							name="IspecificLocationNote<?php echo $i; ?>" 
							placeholder="Specific Location Note"><?php echo (isset($_SESSION['image']['specificLocationNote'.$i])) ? htmlspecialchars($_SESSION['image']['specificLocationNote'.$i]) : ''; ?></textarea>


						</div><!-- catCell -->

					</div><!-- catCellWrapper -->
				
				</div> <!-- catRowWrapper -->
			
			</div>
		
			<?php $i++; } ?>

			
		</div> <!-- catSectionWrapper -->

	<!-- Built Work -->
	
		<div class="catSectionWrapper  imageSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['image'] as $key=>$value) {
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
							id="IbuiltWorkDisplay<?php echo $i; ?>"
							class="cat_display"
							name="IbuiltWorkDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['image']['builtWorkDisplay'.$i])) ? $_SESSION['image']['builtWorkDisplay'.$i] : '1'; ?>">
					
					</div>
					
				<div class="catCellWrapper">
					
						<div class="catCell">
						
							<input type="text" 
								id="IbuiltWork<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="IbuiltWork<?php echo $i; ?>" 
								placeholder="Built Work"
								value="<?php echo (isset($_SESSION['image'])) ? $_SESSION['image']['builtWork'.$i] : ''; ?>">
						
						</div>	
						
						<div class="catCell">
						
							<input type="hidden" 
								id="IbuiltWorkId<?php echo $i; ?>"
								name="IbuiltWorkId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['image'])) ? $_SESSION['image']['builtWorkId'.$i] : ''; ?>">
						
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
						
							<select id="IbuiltWorkType<?php echo $i; ?>" 
								name="IbuiltWorkType<?php echo $i; ?>" 
								title="Location type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['image']['builtWorkType'.$i]) && $_SESSION['image']['builtWorkType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Type -</option>
								
								<option id="creation" value="Creation" <?php echo(isset($_SESSION['image']['builtWorkType'.$i]) && $_SESSION['image']['builtWorkType'.$i] == "Creation") ? 'selected="selected"' : "" ;?>>Creation</option>
								
								<option id="discovery" value="Discovery" <?php echo(isset($_SESSION['image']['builtWorkType'.$i]) && $_SESSION['image']['builtWorkType'.$i] == "Discovery") ? 'selected="selected"' : "" ;?>>Discovery</option>
								
								<option id="exhibition" value="Exhibition" <?php echo(isset($_SESSION['image']['builtWorkType'.$i]) && $_SESSION['image']['builtWorkType'.$i] == "Exhibition") ? 'selected="selected"' : "" ;?>>Exhibition</option>
								
								<option id="formerOwner" value="Former owner" <?php echo(isset($_SESSION['image']['builtWorkType'.$i]) && $_SESSION['image']['builtWorkType'.$i] == "Former owner") ? 'selected="selected"' : "" ;?>>Former owner</option>
								
								<option id="formerRepository" value="Former repository" <?php echo(isset($_SESSION['image']['builtWorkType'.$i]) && $_SESSION['image']['builtWorkType'.$i] == "Former repository") ? 'selected="selected"' : "" ;?>>Former repository</option>
								
								<option id="formerSite" value="Former site" <?php echo(isset($_SESSION['image']['builtWorkType'.$i]) && $_SESSION['image']['builtWorkType'.$i] == "Former site") ? 'selected="selected"' : "" ;?>>Former site</option>
								
								<option id="installation" value="Installation" <?php echo(isset($_SESSION['image']['builtWorkType'.$i]) && $_SESSION['image']['builtWorkType'.$i] == "Installation") ? 'selected="selected"' : "" ;?>>Installation</option>
								
								<option id="intended" value="Intended" <?php echo(isset($_SESSION['image']['builtWorkType'.$i]) && $_SESSION['image']['builtWorkType'.$i] == "Intended") ? 'selected="selected"' : "" ;?>>Intended</option>
								
								<option id="owner" value="Owner" <?php echo(isset($_SESSION['image']['builtWorkType'.$i]) && $_SESSION['image']['builtWorkType'.$i] == "Owner") ? 'selected="selected"' : "" ;?>>Owner</option>
								
								<option id="performance" value="Performance" <?php echo(isset($_SESSION['image']['builtWorkType'.$i]) && $_SESSION['image']['builtWorkType'.$i] == "Performance") ? 'selected="selected"' : "" ;?>>Performance</option>
								
								<option id="publication" value="Publication" <?php echo(isset($_SESSION['image']['builtWorkType'.$i]) && $_SESSION['image']['builtWorkType'.$i] == "Publication") ? 'selected="selected"' : "" ;?>>Publication</option>
								
								<option id="repository" value="Repository" <?php echo(isset($_SESSION['image']['builtWorkType'.$i]) && $_SESSION['image']['builtWorkType'.$i] == "Repository") ? 'selected="selected"' : "" ;?>>Repository</option>
								
								<option id="site" value="Site" <?php echo(isset($_SESSION['image']['builtWorkType'.$i]) && $_SESSION['image']['builtWorkType'.$i] == "Site") ? 'selected="selected"' : "" ;?>>Site</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['image']['builtWorkType'.$i]) && $_SESSION['image']['builtWorkType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
							
							</select>
						
						</div>

						<div class="catCell">
						
							<select id="IbuiltWorkNameType<?php echo $i; ?>" 
								name="IbuiltWorkNameType<?php echo $i; ?>" 
								title="Location name type">
							
								<option id="blank" value="" <?php echo(isset($_SESSION['image']['builtWorkNameType'.$i]) && $_SESSION['image']['builtWorkNameType'.$i] == "") ? 'selected="selected"' : "" ;?>>- Name Type -</option>
								
								<option id="corporate" value="Corporate" <?php echo(isset($_SESSION['image']['builtWorkNameType'.$i]) && $_SESSION['image']['builtWorkNameType'.$i] == "Corporate") ? 'selected="selected"' : "" ;?>>Corporate</option>
								
								<option id="geographic" value="Geographic" <?php echo(isset($_SESSION['image']['builtWorkNameType'.$i]) && $_SESSION['image']['builtWorkNameType'.$i] == "Geographic") ? 'selected="selected"' : "" ;?>>Geographic</option>
								
								<option id="personal" value="Personal" <?php echo(isset($_SESSION['image']['builtWorkNameType'.$i]) && $_SESSION['image']['builtWorkNameType'.$i] == "Personal") ? 'selected="selected"' : "" ;?>>Personal</option>
								
								<option id="other" value="Other" <?php echo(isset($_SESSION['image']['builtWorkNameType'.$i]) && $_SESSION['image']['builtWorkNameType'.$i] == "Other") ? 'selected="selected"' : "" ;?>>Other</option>
							
							</select>
						
						</div>
							
					</div> <!-- catCellWrapper -->
						
				</div> <!-- catRowWrapper -->

			</div>
		
			<?php $i++; } ?>
			
		</div> <!-- catSectionWrapper -->


		<!-- 
				State/Edition
		 -->
		
		<div class="catSectionWrapper imageSection">
		
			<?php
			$rows = 0;
			foreach ($_SESSION['image'] as $key=>$value) {
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
						
							<select id="IstateEditionType<?php echo $i; ?>" 
								name="IstateEditionType<?php echo $i; ?>" 
								title="State/Edition type">
							
								<option id="blank" value="" 
									<?php echo(isset($_SESSION['image']['stateEditionType'.$i]) && $_SESSION['image']['stateEditionType'.$i] == "") 
											? 'selected="selected"' 
											: "" ;?>
									>- Type -</option>
								
								<option id="edition" value="Edition" 
									<?php echo(isset($_SESSION['image']['stateEditionType'.$i]) && $_SESSION['image']['stateEditionType'.$i] == "Edition") 
											? 'selected="selected"' 
											: "" ;?>
									>Edition</option>
								
								<option id="impression" value="Impression" 
									<?php echo(isset($_SESSION['image']['stateEditionType'.$i]) && $_SESSION['image']['stateEditionType'.$i] == "Impression") 
											? 'selected="selected"' 
											: "" ;?>
									>Impression</option>
								
								<option id="state" value="State" 
									<?php echo(isset($_SESSION['image']['stateEditionType'.$i]) && $_SESSION['image']['stateEditionType'.$i] == "State") 
											? 'selected="selected"' 
											: "" ;?>
									>State</option>
								
								<option id="other" value="Other" 
									<?php echo(isset($_SESSION['image']['stateEditionType'.$i]) && $_SESSION['image']['stateEditionType'.$i] == "Other") 
											? 'selected="selected"' 
											: "" ;?>
									>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="IstateEdition<?php echo $i; ?>"
								class="autoWidth" 
								name="IstateEdition<?php echo $i; ?>" 
								placeholder="State/Edition"
								value="<?php echo (isset($_SESSION['image']['stateEdition'.$i])) 
										? $_SESSION['image']['stateEdition'.$i] 
										: ''; ?>" 
								title="State/Edition number">
						
						</div>
					
						<!-- end catCell -->
					</div> 
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
					<!-- end catRowWrapper -->
				</div>

			</div>
		
			<?php $i++; } ?>
			
			<!-- end catSectionWrapper -->
		</div>
		
		<!-- Inscription 1 -->
		
		<div class="catSectionWrapper imageSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['image'] as $key=>$value) {
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
							id="IinscriptionDisplay<?php echo $i; ?>"
							class="cat_display"
							name="IinscriptionDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['image']['inscriptionDisplay'.$i])) ? $_SESSION['image']['inscriptionDisplay'.$i] : '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="IinscriptionType<?php echo $i; ?>" 
								name="IinscriptionType<?php echo $i; ?>" 
								title="Inscription type">
							
								<option id="blank" value="" <?php selectedOption($_SESSION['image']['inscriptionType'.$i],''); ?>>- Type -</option>
								
								<option id="signature" value="Signature" <?php selectedOption($_SESSION['image']['inscriptionType'.$i],'Signature'); ?>>Signature</option>
								
								<option id="mark" value="Mark" <?php selectedOption($_SESSION['image']['inscriptionType'.$i],'Mark'); ?>>Mark</option>
								
								<option id="caption" value="Caption" <?php selectedOption($_SESSION['image']['inscriptionType'.$i],'Caption'); ?>>Caption</option>
								
								<option id="date" value="Date" <?php selectedOption($_SESSION['image']['inscriptionType'.$i],'Date'); ?>>Date</option>
								
								<option id="text" value="Text" <?php selectedOption($_SESSION['image']['inscriptionType'.$i],'Text'); ?>>Text</option>
								
								<option id="translation" value="Translation" <?php selectedOption($_SESSION['image']['inscriptionType'.$i],'Translation'); ?>>Translation</option>
								
								<option id="other" value="Other" <?php selectedOption($_SESSION['image']['inscriptionType'.$i],'Other'); ?>>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="IworkInscription<?php echo $i; ?>" 
								class="autoWidth"
								name="IworkInscription<?php echo $i; ?>" 
								placeholder="Inscription text"
								value="<?php echo htmlspecialchars($_SESSION['image']['workInscription'.$i]); ?>"
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
								id="IworkInscriptionAuthor<?php echo $i; ?>" 
								name="IworkInscriptionAuthor<?php echo $i; ?>" 
								placeholder="Inscription author"
								value="<?php echo htmlspecialchars($_SESSION['image']['workInscriptionAuthor'.$i]); ?>" 
								maxlength="500"
								style="width: 120px;">
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="IworkInscriptionLocation<?php echo $i; ?>" 
								name="IworkInscriptionLocation<?php echo $i; ?>" 
								placeholder="Inscription location"
								value="<?php echo htmlspecialchars($_SESSION['image']['workInscriptionLocation'.$i]); ?>" 
								maxlength="500">
						
						</div>
						
					</div> <!-- catCellWrapper -->
				
				</div> <!-- catRowWrapper -->

			</div>
		
			<?php $i++; } ?>
		
		</div> <!-- catSectionWrapper -->
		
		<!-- Subject -->
		
		<div id="imageSubject_section" class="catSectionWrapper imageSection">
		
			<?php
		
			$rows = 0;
			foreach ($_SESSION['image'] as $key=>$value) {
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
							id="IsubjectDisplay<?php echo $i; ?>"
							class="cat_display"
							name="IsubjectDisplay<?php echo $i; ?>"
							value="<?php echo (isset($_SESSION['image']['subjectDisplay'.$i])) ? $_SESSION['image']['subjectDisplay'.$i] : '1'; ?>">
					
					</div>
					
					<div class="catCellWrapper">
					
						<div class="catCell">
						
							<select id="IsubjectType<?php echo $i; ?>" 
								name="IsubjectType<?php echo $i; ?>" 
								title="Subject type">
							
								<option id="blank" value="" <?php selectedOption($_SESSION['image']['subjectType'.$i], ''); ?>>- Type -</option>
								
								<option id="conceptTopic" value="Topic: concept" <?php selectedOption($_SESSION['image']['subjectType'.$i], 'Topic: concept'); ?>>Topic: concept</option>
								
								<option id="descriptiveTopic" value="Topic: descriptive" <?php selectedOption($_SESSION['image']['subjectType'.$i], 'Topic: descriptive'); ?>>Topic: descriptive</option>
								
								<option id="iconographicTopic" value="Topic: iconographic" <?php selectedOption($_SESSION['image']['subjectType'.$i], 'Topic: iconographic'); ?>>Topic: iconographic</option>
								
								<option id="otherTopic" value="Topic: other" <?php selectedOption($_SESSION['image']['subjectType'.$i], 'Topic: other'); ?>>Topic: other</option>
								
								<option id="builtworkPlace" value="Place: built work" <?php selectedOption($_SESSION['image']['subjectType'.$i], 'Place: built work'); ?>>Place: built work</option>
								
								<option id="geographicPlace" value="Place: geographic" <?php selectedOption($_SESSION['image']['subjectType'.$i], 'Place: geographic'); ?>>Place: geographic</option>
								
								<option id="otherPlace" value="Place: other" <?php selectedOption($_SESSION['image']['subjectType'.$i], 'Place: other'); ?>>Place: other</option>
								
								<option id="corporateName" value="Name: corporate" <?php selectedOption($_SESSION['image']['subjectType'.$i], 'Name: corporate'); ?>>Name: corporate</option>
								
								<option id="personalName" value="Name: personal" <?php selectedOption($_SESSION['image']['subjectType'.$i], 'Name: personal'); ?>>Name: personal</option>
								
								<option id="scientificName" value="Name: scientific" <?php selectedOption($_SESSION['image']['subjectType'.$i], 'Name: scientific'); ?>>Name: scientific</option>
								
								<option id="familyName" value="Name: family" <?php selectedOption($_SESSION['image']['subjectType'.$i], 'Name: family'); ?>>Name: family</option>
								
								<option id="otherName" value="Name: other" <?php selectedOption($_SESSION['image']['subjectType'.$i], 'Name: other'); ?>>Name: other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="Isubject<?php echo $i; ?>" 
								class="autoWidth authoritySearch idMissing"
								name="Isubject<?php echo $i; ?>" 
								placeholder="Subject"
								value="<?php echo $_SESSION['image']['subject'.$i];?>" 
								maxlength="500">
						
						</div>
						
						<div class="catCell">
						
							<input type="hidden" 
								id="IsubjectId<?php echo $i; ?>" 
								name="IsubjectId<?php echo $i; ?>" 
								value="<?php echo (isset($_SESSION['image'])) ? $_SESSION['image']['subjectId'.$i] : ''; ?>">
						
						</div>
					
					</div> <!-- catCellWrapper -->
					
					<div class="removeButton"><img src="_assets/_images/trash_mac.png"></div>
					<div class="addButton"><img src="_assets/_images/plus.png"></div>
				
				</div> <!-- catRowWrapper -->

			</div>
		
			<?php $i++; } ?>
		
		</div> <!-- catSectionWrapper -->
		
		<!-- 
				Description
		 -->
		
		<div class="catSectionWrapper imageSection" 
			style="padding-top: 4px; padding-bottom: 0;">
		
			<div class="catRowWrapper" 
				style="height: 150px; position: relative;">
			
				<div class="catCellWrapper">
				
					<div class="catCell">
					
						<textarea id="Idescription" 
							class="fixedWidth" 
							rows="2" 
							name="Idescription0" 
							placeholder="Description"
							style="height: 140px; overflow: hidden;"
							><?php echo (isset($_SESSION['image']['description0'])) 
									? htmlspecialchars($_SESSION['image']['description0']) 
									: ''; ?></textarea>
					
					</div>
				
					<!-- end catCell -->
				</div> 
			
				<!-- end catRowWrapper -->
			</div> 
			
			<!-- end catSectionWrapper -->
		</div> 
		
		<!-- Rights 1 -->
		
		<div class="catSectionWrapper imageSection">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['image'] as $key=>$value) {
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
						
							<select id="IrightsType<?php echo $i; ?>" 
								name="IrightsType<?php echo $i; ?>" 
								title="Rights type">
							
								<option id="blank" value="" <?php selectedOption($_SESSION['image']['rightsType'.$i], ''); ?>>- Type -</option>
								
								<option id="copyrighted" value="Copyrighted" <?php selectedOption($_SESSION['image']['rightsType'.$i], 'copyrighted'); ?>>Copyrighted</option>
								
								<option id="publicDomain" value="Public domain" <?php selectedOption($_SESSION['image']['rightsType'.$i], 'Public domain'); ?>>Public domain</option>
								
								<option id="undetermined" value="Undetermined" <?php selectedOption($_SESSION['image']['rightsType'.$i], 'Undetermined'); ?>>Undetermined</option>
								
								<option id="other" value="Other" <?php selectedOption($_SESSION['image']['rightsType'.$i], 'Other'); ?>>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="IrightsHolder<?php echo $i; ?>" 
								class="autoWidth"
								name="IrightsHolder<?php echo $i; ?>" 
								placeholder="Rights holder"
								value="<?php echo htmlspecialchars($_SESSION['image']['rightsHolder'.$i]); ?>" 
								maxlength="500">
						
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
								id="IrightsText<?php echo $i; ?>" 
								class="autoWidth"
								name="IrightsText<?php echo $i; ?>" 
								placeholder="Rights text"
								value="<?php echo htmlspecialchars($_SESSION['image']['rightsText'.$i]); ?>" 
								maxlength="500">
						
						</div>
					
					</div> <!-- catCellWrapper -->
				
				</div> <!-- catRowWrapper -->

			</div>
			
			<?php $i++; } ?>
		
		</div> <!-- catSectionWrapper -->
		
		<!-- Source 1 -->
		
		<div class="catSectionWrapper imageSection"
			style="border-bottom: none;">
		
			<?php
			
			$rows = 0;
			foreach ($_SESSION['image'] as $key=>$value) {
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
						
							<select id="IsourceNameType<?php echo $i; ?>" 
								name="IsourceNameType<?php echo $i; ?>" 
								title="Source name type">
							
								<option id="blank" value="" <?php selectedOption($_SESSION['image']['sourceNameType'.$i], ''); ?>>- Name Type -</option>
								
								<option id="book" value="Book" <?php selectedOption($_SESSION['image']['sourceNameType'.$i], 'Book'); ?>>Book</option>
								
								<option id="catalogue" value="Catalogue" <?php selectedOption($_SESSION['image']['sourceNameType'.$i], 'Catalogue'); ?>>Catalogue</option>
								
								<option id="corpus" value="Corpus" <?php selectedOption($_SESSION['image']['sourceNameType'.$i], 'Corpus'); ?>>Corpus</option>
								
								<option id="donor" value="Donor" <?php selectedOption($_SESSION['image']['sourceNameType'.$i], 'Donor'); ?>>Donor</option>
								
								<option id="electronic" value="Electronic" <?php selectedOption($_SESSION['image']['sourceNameType'.$i], 'Electronic'); ?>>Electronic</option>
								
								<option id="serial" value="Serial" <?php selectedOption($_SESSION['image']['sourceNameType'.$i], 'Serial'); ?>>Serial</option>
								
								<option id="vendor" value="Vendor" <?php selectedOption($_SESSION['image']['sourceNameType'.$i], 'Vendor'); ?>>Vendor</option>
								
								<option id="other" value="Other" <?php selectedOption($_SESSION['image']['sourceNameType'.$i], 'Other'); ?>>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="IsourceName<?php echo $i; ?>" 
								class="autoWidth"
								name="IsourceName<?php echo $i; ?>" 
								placeholder="Source name"
								value="<?php echo htmlspecialchars($_SESSION['image']['sourceName'.$i]); ?>" 
								maxlength="500">
						
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
						
							<select id="IsourceType<?php echo $i; ?>" 
								name="IsourceType<?php echo $i; ?>" 
								title="Source type">
							
								<option id="blank" value="" <?php selectedOption($_SESSION['image']['sourceType'.$i], ''); ?>>- Type -</option>
								
								<option id="citation" value="Citation" <?php selectedOption($_SESSION['image']['sourceType'.$i], 'Citation'); ?>>Citation</option>
								
								<option id="ISBN" value="ISBN" <?php selectedOption($_SESSION['image']['sourceType'.$i], 'ISBN'); ?>>ISBN</option>
								
								<option id="ISSN" value="ISSN" <?php selectedOption($_SESSION['image']['sourceType'.$i], 'ISSN'); ?>>ISSN</option>

								<option id="ASIN" value="ASIN" <?php selectedOption($_SESSION['image']['sourceType'.$i], 'ASIN'); ?>>ASIN</option>
								
								<option id="openURL" value="Open URL" <?php selectedOption($_SESSION['image']['sourceType'.$i], 'Open URL'); ?>>Open URL</option>
								
								<option id="URI" value="URI" <?php selectedOption($_SESSION['image']['sourceType'.$i], 'URI'); ?>>URI</option>
								
								<option id="vendor" value="Vendor" <?php selectedOption($_SESSION['image']['sourceType'.$i], 'Vendor'); ?>>Vendor</option>
								
								<option id="other" value="Other" <?php selectedOption($_SESSION['image']['sourceType'.$i], 'Other'); ?>>Other</option>
							
							</select>
						
						</div>
						
						<div class="catCell">
						
							<input type="text" 
								id="Isource<?php echo $i; ?>" 
								class="autoWidth"
								name="Isource<?php echo $i; ?>" 
								placeholder="Source text" 
								value="<?php echo htmlspecialchars($_SESSION['image']['source'.$i]); ?>" 
								maxlength="500">
						
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
			id="catSubmitButton" 
			class="inline"
			name="catalog_saveChanges"
			style="font-size: 0.9em;">Save Changes</button>

	</div>

	<p class="clear"></p>
	
</div> <!-- cataloguingPane -->

<script>

	// Display only the appropriate measurement fields
	$('div#image_module select[id*=measurementType]')
		.each(displayMeasurements);
	$('div#image_module select[id*=measurementType]')
		.change(displayMeasurements);

	// Add & Remove cataloging rows
	$('div#image_module div.addButton').click(addRow_v2);
	$('div#image_module div.removeButton').click(removeRow_v2);

	catalogUI_prepFields();
	catalogUI_prepAddRemove();
	authorityIndicators();


	// Perform authority search
	$('div#image_module input.authoritySearch').keyup(debounce(
		function()
		{
			var term = $(this).val();
			if (term.length > 2 && $.trim(term) != '') {

				var fieldName = $(this).attr('name');

				var nearbyAuthorityFieldName = 
					$(this).parent('div.catRowWrapper')
						.find('input[type=hidden]')
						.attr('name');

				catalogUI_searchAuthority(fieldName, nearbyAuthorityFieldName);

				$('form#catalog_form input').not(this).focus(function() {
					$('div.resultsWrapper').remove();
				});
			}

		}, 1000));


	// Toggle date range
	$('div#image_module input[type=checkbox][id*=dateRange]').click(function() 
	{
		var endDate = $(this).parents('div#image_module div.catRowWrapper')
			.next('div.catRowWrapper')
			.find('div[id*=dateRangeSpan]');

		endDate.toggle();
	});

	// Show/hide date range on load
	$('div#image_module input[type=checkbox][id*=dateRange]')
		.each(catalogUI_dateRange_onLoad);

	$('div#image_module input.autoWidth').each(autoWidth);

	//Show and Toggle specific location row and fields
	$('select[id*=specificLocationType]').each(displaySpecificLocation);
	$('select[id*=specificLocationType]').change(displaySpecificLocation);

	// Adapt cataloging UI to the width of the browser window
	$(window).resize(function()
	{
		$('div#image_module input.autoWidth').each(autoWidth);
	});

	// RESET ALL FIELDS
	$('div#image_module button.catalogUI_clear')
		.click(promptToConfirm)
		.click(
			function()
			{
				$('button#conf_button')
					.click(
						function()
						{
							catalogUI_clearFields('image');
						});
			});

	//---------------------------
	//	Save Cataloging Changes
	//---------------------------

	// User clicks 'Save Changes'
	$('button#catSubmitButton')
		.click(promptToConfirm)
		.click(
			function()
			{
				$('button#conf_button').click(
					function()
					{
						$('button#conf_button').remove();

						$('button#catSubmitButton')
							.after('<img src="_assets/_images/loading.gif" style="margin: 0 0 -10px 10px;">');

						save_catalog_changes(
						'<?php echo $_SESSION['imageNum']; ?>',
						'<?php echo $_SESSION['workNum']; ?>');
					});
			});

	//Bind authority search color indicators
	$('div#image_module').click(authorityIndicators);

	// FADE TITLE TEXT FOR HIDDEN DATA
	$('.catRowTitle .cat_display')
		.each(
			function()
			{
				if ($(this).val()=='0')
				{
					$(this).prev('.titleText').addClass('ital lightGrey');
				}
			});


	// TOGGLE DATA DISPLAY
	$('#image_module .catRowTitle .titleText')
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