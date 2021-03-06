<?php

	$showUpdateButtonInAdminBarChecked = (MCEasyPublisherSettingsManager::GetSetting(
			MCEasyPublisherSettingsManager::SETTING_SHOW_UPDATE_BUTTON_IN_ABAR)) ? 
			'checked="checked"' :'';
	
	$showPreviewButtonInAdminBarChecked = (MCEasyPublisherSettingsManager::GetSetting(
			MCEasyPublisherSettingsManager::SETTING_SHOW_PREVIEW_BUTTON_IN_ABAR)) ? 
			'checked="checked"' :'';

	$showTitleInAdminBarChecked = (MCEasyPublisherSettingsManager::GetSetting(
			MCEasyPublisherSettingsManager::SETTING_SHOW_TITLE_IN_ABAR)) ?
			'checked="checked"' :'';	

	$keepFSToolbarVisibleChecked = (MCEasyPublisherSettingsManager::GetSetting(
			MCEasyPublisherSettingsManager::SETTING_KEEP_FS_TOOLBAR_VISIBLE)) ?
			'checked="checked"' :'';
	
	$showPreviewButtonInFullscreenChecked = (MCEasyPublisherSettingsManager::GetSetting(
			MCEasyPublisherSettingsManager::SETTING_SHOW_PREVIEW_BUTTON_IN_FS)) ?
			'checked="checked"' :'';

	$showViewPostButtonInFullscreenChecked = (MCEasyPublisherSettingsManager::GetSetting(
			MCEasyPublisherSettingsManager::SETTING_SHOW_VIEWPOST_BUTTON_IN_FS)) ?
			'checked="checked"' :'';
	
	$showAdminBarInFullscreenChecked = (MCEasyPublisherSettingsManager::GetSetting(
			MCEasyPublisherSettingsManager::SETTING_SHOW_ADMINBAR_IN_FULLSCREEN)) ?
			'checked="checked"' :'';

	$viewPostInNewTabChecked = (MCEasyPublisherSettingsManager::GetSetting(
			MCEasyPublisherSettingsManager::SETTING_VIEW_POST_IN_NEW_TAB)) ?
			'checked="checked"' :'';
	
	$messages = $this->controller->messages;
	$errors = $this->controller->errors;
	
	// The fullscreen options are obsolete as of version 4.1
	// so hide them.
	$versionArray = explode('.', get_bloginfo('version'));
	$versionMajor = intval($versionArray[0]);
	$versionMinor = intval($versionArray[1]);
	$hideFullscreenOptions = ($versionMajor >= 4 && $versionMinor >= 0);
?>
<div class="wrap" id="EasyPublisherSettingsPage">

	<?php 
		if (count($errors) > 0) {
			foreach($errors as $error) {
	?>
	<div class="errorMessage message"><strong>Error: </strong><?php echo $error ?></div>
	<?php 
			}
		}
	?>
	<?php 
		if (count($messages) > 0) {
			foreach($messages as $message) {
	?>
	<div class="successMessage message"><strong>Message: </strong><?php echo $message ?></div>
	<?php 
			}
		}
	?>
	
	<div id="icon-plugins" class="icon32"></div>
	<h2>Easy Publisher</h2>
	
	<p>This plugin was developed and is maintained by 
	<a href="http://marketingclique.com" target="newWindow">Marketing 
	Clique.</a></p> 
	<p>Please <a href="mailto:ep@marketingclique.com">email us</a> for feature requests.</p>
	<p>Thanks for using Easy Publisher!</p>
	
	<h3>Main Admin Bar Settings</h3>
	
	<form id="easyUpdaterSettingsForm" name="easyUpdaterSettingsForm" 
		action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
		
		<?php wp_nonce_field('mcep-save-settings'); ?>
		
		<input type="hidden" name="mcepAction" value="SaveSettings" />
		
		<div class="checkboxItem">
			<input type="checkbox" name="<?php echo MCEasyPublisherSettingsManager::SETTING_SHOW_PREVIEW_BUTTON_IN_ABAR ?>"
				id="showPreviewABButtonCheckbox" value="1" <?php echo $showPreviewButtonInAdminBarChecked ?> />
			<label for="showPreviewABButtonCheckbox">Show "Preview" button</label>
		</div>
		
		<div class="checkboxItem">
			<input type="checkbox" name="<?php echo MCEasyPublisherSettingsManager::SETTING_SHOW_UPDATE_BUTTON_IN_ABAR ?>"
				id="showABUpdateButtonCheckbox" value="1" <?php echo $showUpdateButtonInAdminBarChecked ?> />
			<label for="showABUpdateButtonCheckbox">Show "Update" button</label>
		</div>
		
		<div class="checkboxItem">
			<input type="checkbox" name="<?php echo MCEasyPublisherSettingsManager::SETTING_SHOW_TITLE_IN_ABAR ?>"
				id="showABTitleCheckbox" value="1" <?php echo $showTitleInAdminBarChecked ?> />
			<label for="showABTitleCheckbox">Show "Post/Page Title"</label>
		</div>
		
		<hr />
		
		<?php 
			$displayCSS = ($hideFullscreenOptions) ? 'style="display: none;"' : '';
		?>
		<div class="fullScreenOptions" <?= $displayCSS ?>>
			<h3>Fullscreen Admin Bar Settings</h3>
			
			<div class="checkboxItem">
				<input type="checkbox" name="<?php echo MCEasyPublisherSettingsManager::SETTING_KEEP_FS_TOOLBAR_VISIBLE ?>"
					id="keepFSToolbarVisibleCheckbox" value="1" <?php echo $keepFSToolbarVisibleChecked ?> />
				<label for="keepFSToolbarVisibleCheckbox">Always show "Fullscreen Admin Bar" (don't auto hide)</label>
			</div>
			
			<div class="checkboxItem">
				<input type="checkbox" name="<?php echo MCEasyPublisherSettingsManager::SETTING_SHOW_VIEWPOST_BUTTON_IN_FS ?>"
					id="showFSViewPostwButtonCheckbox" value="1" <?php echo $showViewPostButtonInFullscreenChecked ?> />
				<label for="showFSViewPostwButtonCheckbox">Show "View Post" button</label>
			</div>
			
			<div class="checkboxItem">
				<input type="checkbox" name="<?php echo MCEasyPublisherSettingsManager::SETTING_SHOW_PREVIEW_BUTTON_IN_FS ?>"
					id="showFSPreviewButtonCheckbox" value="1" <?php echo $showPreviewButtonInFullscreenChecked ?> />
				<label for="showFSPreviewButtonCheckbox">Show "Preview" button</label>
			</div>
			
			<div class="checkboxItem">
				<input type="checkbox" name="<?php echo MCEasyPublisherSettingsManager::SETTING_SHOW_ADMINBAR_IN_FULLSCREEN ?>"
					id="showAdminBarInFullscreenCheckbox" value="1" <?php echo $showAdminBarInFullscreenChecked ?> />
				<label for="showAdminBarInFullscreenCheckbox">Don't hide "Main Admin Bar" in Fullscreen</label>
			</div>
			
			<hr />
		</div>
		
		<h3>General Settings</h3>
		
		<div class="checkboxItem">
			<input type="checkbox" name="<?php echo MCEasyPublisherSettingsManager::SETTING_VIEW_POST_IN_NEW_TAB ?>"
				id="viewPostInNewTabCheckbox" value="1" <?php echo $viewPostInNewTabChecked ?> />
			<label for="viewPostInNewTabCheckbox">Make all "View Post" links open up the link in a new tab</label>
		</div>
		
		<div class="buttonPanel">
			<input type="submit" id="submitChangesButton"
				name="saveChanges" value="Save Changes" />
		</div>
	
	</form>
	
</div>