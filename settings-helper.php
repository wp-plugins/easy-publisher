<?php

	class MCEasyPublisherSettingsManager {
		
		const WP_OPTION_NAME = 'mc_easy_publisher_settings';
		
		const SETTING_SHOW_UPDATE_BUTTON_IN_ABAR = 'showUpdateButtonInAdminBar';
		const SETTING_SHOW_PREVIEW_BUTTON_IN_ABAR = 'showPreviewButtonInAdminBar';
		const SETTING_SHOW_TITLE_IN_ABAR = 'showTitleInAdminBar';
		const SETTING_KEEP_FS_TOOLBAR_VISIBLE = 'keepFullscreenBarVisible';
		const SETTING_SHOW_PREVIEW_BUTTON_IN_FS = 'showPreviewButtonInFullscreenBar';
		const SETTING_SHOW_VIEWPOST_BUTTON_IN_FS = 'showViewPostButtonInFullscreenBar';
		const SETTING_SHOW_ADMINBAR_IN_FULLSCREEN = 'showAdminBarInFullscreen';
		const SETTING_VIEW_POST_IN_NEW_TAB = 'viewPostInNewTab';
		
		private static $settings = null;
		
		public static function SetSetting($settingName, $settingValue) {
			
			self::GetSettings();
			
			self::$settings->$settingName = $settingValue;
				
		}
		
		public static function GetSetting($settingName) {
			
			self::GetSettings();
			
			return self::$settings->$settingName;
		}

		private static function GetSettings() {
			
			if (self::$settings == null) {
				$result = get_option(self::WP_OPTION_NAME);
				
				if ($result == false) {
					self::$settings = new MCEasyPublisherSettings();
				} else {
					self::$settings = json_decode($result);
					
					if (json_last_error() != JSON_ERROR_NONE) {
						self::$settings = new MCEasyPublisherSettings();
					}
				}
			}
			
		}

		public static function SaveSettings() {
			
			$originalJSON = get_option(self::WP_OPTION_NAME);
			
			$settingsJSON = json_encode(self::$settings);
			
			if ($originalJSON == $settingsJSON) {
				// Nothing changed
				return;
			}
			
			$result = update_option(self::WP_OPTION_NAME, $settingsJSON);
			
			if ($result === false) {
				throw new Exception('Settings could not be saved.');
			}
			
		}
		
	}
	
	class MCEasyPublisherSettings {
		
		public $showUpdateButtonInAdminBar = true;
		public $showPreviewButtonInAdminBar = true;
		public $showTitleInAdminBar = true;
		public $keepFullscreenBarVisible = true;
		public $showPreviewButtonInFullscreenBar = true;
		public $showViewPostButtonInFullscreenBar = true;
		public $showAdminBarInFullscreen = false;
		public $viewPostInNewTab = true;
		
	}

?>