<?php

	class MCEasyPublisherController {

		public $viewName = 'views/welcome';
		public $settings = Array();
		public $errors = Array();
		public $messages = Array();

		function __construct() {

		}

		public function ViewSettings() {

			$this->viewName = 'views/settings';

		}

		public function SaveSettings() {

			$this->viewName = 'views/settings';

			if (wp_verify_nonce( $_REQUEST['_wpnonce'], 'mcep-save-settings' ) == false) {
				
				$this->errors[] = 'NONCE did not verify';
				
				throw new Exception('NONCE did not verify');
			}

			MCEasyPublisherSettingsManager::SetSetting(
				MCEasyPublisherSettingsManager::SETTING_SHOW_UPDATE_BUTTON_IN_ABAR,
				isset($_REQUEST[MCEasyPublisherSettingsManager::SETTING_SHOW_UPDATE_BUTTON_IN_ABAR]));

			MCEasyPublisherSettingsManager::SetSetting(
				MCEasyPublisherSettingsManager::SETTING_SHOW_PREVIEW_BUTTON_IN_ABAR,
				isset($_REQUEST[MCEasyPublisherSettingsManager::SETTING_SHOW_PREVIEW_BUTTON_IN_ABAR]));

			MCEasyPublisherSettingsManager::SetSetting(
				MCEasyPublisherSettingsManager::SETTING_SHOW_TITLE_IN_ABAR,
				isset($_REQUEST[MCEasyPublisherSettingsManager::SETTING_SHOW_TITLE_IN_ABAR]));

			MCEasyPublisherSettingsManager::SetSetting(
				MCEasyPublisherSettingsManager::SETTING_KEEP_FS_TOOLBAR_VISIBLE,
				isset($_REQUEST[MCEasyPublisherSettingsManager::SETTING_KEEP_FS_TOOLBAR_VISIBLE]));

			MCEasyPublisherSettingsManager::SetSetting(
				MCEasyPublisherSettingsManager::SETTING_SHOW_PREVIEW_BUTTON_IN_FS,
				isset($_REQUEST[MCEasyPublisherSettingsManager::SETTING_SHOW_PREVIEW_BUTTON_IN_FS]));

			MCEasyPublisherSettingsManager::SetSetting(
				MCEasyPublisherSettingsManager::SETTING_SHOW_VIEWPOST_BUTTON_IN_FS,
				isset($_REQUEST[MCEasyPublisherSettingsManager::SETTING_SHOW_VIEWPOST_BUTTON_IN_FS]));
			
			MCEasyPublisherSettingsManager::SetSetting(
				MCEasyPublisherSettingsManager::SETTING_SHOW_ADMINBAR_IN_FULLSCREEN,
				isset($_REQUEST[MCEasyPublisherSettingsManager::SETTING_SHOW_ADMINBAR_IN_FULLSCREEN]));

			try {
				MCEasyPublisherSettingsManager::SaveSettings();
			} catch (Exception $ex) {
				$this->errors[] = $ex->getMessage();
				
				throw new Exception($ex->getMessage());;
			}
			
			$this->messages[] = 'Save Changes was successful.';
		}

		public function DoDisplayButtons() {

			global $pagenow;
			global $id;
			global $wp_admin_bar;

			if (in_array( $pagenow, array( 'post-new.php' ))) {

				if (isset($_REQUEST['post_type'])) {
					$postType = ucfirst($_REQUEST['post_type']);
				} else {
					$postType = 'Post';
				}

				$showPreviewButton = MCEasyPublisherSettingsManager::GetSetting(
						MCEasyPublisherSettingsManager::SETTING_SHOW_PREVIEW_BUTTON_IN_ABAR);

				if ($showPreviewButton) {
					$wp_admin_bar->add_menu( array(
						'id'   => 'MCEUPreviewPost',
						'meta' => array(),
						'title' => __( 'Preview' ) . ' ' . $postType,
						'href' => get_site_url() . '?p=' . get_the_ID() . '&preview=true' ) );
				}

				$showPublishButton = MCEasyPublisherSettingsManager::GetSetting(
						MCEasyPublisherSettingsManager::SETTING_SHOW_UPDATE_BUTTON_IN_ABAR);

				if ($showPublishButton) {
					$wp_admin_bar->add_menu( array(
							'id'   => 'MCEUUpdatePost',
							'meta' => array('onclick' => 'MCEasyPublisher.UpdatePost(); return false;'),
							'title' => __( 'Publish' ) . ' ' . $postType,
							'href' => '#' ) );
				}

				$showTitle = MCEasyPublisherSettingsManager::GetSetting(
						MCEasyPublisherSettingsManager::SETTING_SHOW_TITLE_IN_ABAR);

				if ($showTitle) {
					$wp_admin_bar->add_menu( array(
							'id'   => 'MCEPostTitle',
							'meta' => array('id' => 'MCEPostTitle'),
							'title' => '',
							'href' => '' ) );
				}

			}

			if (in_array( $pagenow, array( 'post.php' ))) {

				$postType = ucfirst(get_post_type(get_the_ID()));

				$showPreviewButton = MCEasyPublisherSettingsManager::GetSetting(
						MCEasyPublisherSettingsManager::SETTING_SHOW_PREVIEW_BUTTON_IN_ABAR);

				if ($showPreviewButton) {
					$wp_admin_bar->add_menu( array(
						'id'   => 'MCEUPreviewPost',
						'meta' => array('target' => 'newWindow'),
						'title' => __( 'Preview Changes' ),
						'href' => get_site_url() . '?p=' . get_the_ID() . '&preview=true' ) );
				}

				$showUpdateButton = MCEasyPublisherSettingsManager::GetSetting(
						MCEasyPublisherSettingsManager::SETTING_SHOW_UPDATE_BUTTON_IN_ABAR);

				if ($showUpdateButton) {
					$wp_admin_bar->add_menu( array(
						'id'   => 'MCEUUpdatePost',
						'meta' => array('onclick' => 'MCEasyPublisher.UpdatePost(); return false;'),
						'title' => __( 'Update' ) . ' ' . $postType,
						'href' => '#' ) );
				}

				$showTitle = MCEasyPublisherSettingsManager::GetSetting(
						MCEasyPublisherSettingsManager::SETTING_SHOW_TITLE_IN_ABAR);

				if ($showTitle) {
					$wp_admin_bar->add_menu( array(
							'id'   => 'MCEPostTitle',
							'meta' => array('id' => 'MCEPostTitle'),
							'title' => '',
							'href' => '' ) );
				}

			}

			
			// These settings get passed to the MCEasyPublisher javascript class.
			
			$this->settings[MCEasyPublisherSettingsManager::SETTING_SHOW_ADMINBAR_IN_FULLSCREEN] =
				MCEasyPublisherSettingsManager::GetSetting(
				MCEasyPublisherSettingsManager::SETTING_SHOW_ADMINBAR_IN_FULLSCREEN);

			$this->settings[MCEasyPublisherSettingsManager::SETTING_KEEP_FS_TOOLBAR_VISIBLE] =
				MCEasyPublisherSettingsManager::GetSetting(
				MCEasyPublisherSettingsManager::SETTING_KEEP_FS_TOOLBAR_VISIBLE);

			$this->settings[MCEasyPublisherSettingsManager::SETTING_SHOW_PREVIEW_BUTTON_IN_FS] =
				MCEasyPublisherSettingsManager::GetSetting(
				MCEasyPublisherSettingsManager::SETTING_SHOW_PREVIEW_BUTTON_IN_FS);

			$this->settings[MCEasyPublisherSettingsManager::SETTING_SHOW_VIEWPOST_BUTTON_IN_FS] =
				MCEasyPublisherSettingsManager::GetSetting(
				MCEasyPublisherSettingsManager::SETTING_SHOW_VIEWPOST_BUTTON_IN_FS);
				
			
			$script_params = array( 'settings' => $this->settings);

			wp_localize_script( 'mc_easy_publisher_js', 'MCEasyPublisher', $script_params );

		}
	}

?>
