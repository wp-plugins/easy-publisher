<?php
/**
 * @package Easy Publisher
 */
/*
Plugin Name: Easy Publisher
Description: Places the Update and Preview buttons conveniently in the Admin Bar.
Version: 1.0.0
Author: Marketing Clique, LLC. - David Vogelpohl and Andrew Oikle
Author URI: http://www.marketingclique.com/
Requires at least: 3.7.4
Tested up to: 3.9.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/*
 This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

define('MC_EASY_PUBLISHER_VERSION', '1.0.0');
define('MC_EASY_PUBLISHER_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('MC_EASY_PUBLISHER_PLUGIN_URI', plugin_dir_url(__FILE__));


if (!class_exists('MCEasyPublisher')) {

	class MCEasyPublisher {

		private $controller = null;

		function __construct() {
			add_action('admin_menu', array(&$this, 'add_menu'));
			add_action('init', array( &$this, 'init' ));
			add_action('admin_enqueue_scripts', array(&$this, 'init_admin'));
			add_action('wp_ajax_mceu_ajax_action', array(&$this, 'init_admin'));
			add_action('admin_bar_menu', array(&$this, 'place_buttons'), 100);
			add_action('admin_enqueue_scripts', array(&$this, 'add_scripts'));

			$this->load_dependencies();
		}

		public function add_scripts() {

			if (is_admin()) {

				wp_register_script(
					'mc_easy_publisher_js',
					MC_EASY_PUBLISHER_PLUGIN_URI.'mc-easy-publisher.js',
					array('jquery'),
					null,
					true
				);

				wp_enqueue_script( 'mc_easy_publisher_js' );

				wp_enqueue_style(
					'mc_easy_publisher_css',
					MC_EASY_PUBLISHER_PLUGIN_URI.'mc-easy-publisher.css',
					array(),
					null
				);
			}

		}

		public function place_buttons() {

			// DoDisplayButtons knows what to do and when to do it's
			// function.
			
			// Are we viewing a post or page edit?
			if (!is_admin() || !is_admin_bar_showing()) return false;
			
			$this->controller->DoDisplayButtons();

		}

		// Includes
		private function load_dependencies() {
			require_once MC_EASY_PUBLISHER_PLUGIN_PATH . 'controller.php';
			require_once MC_EASY_PUBLISHER_PLUGIN_PATH . 'settings-helper.php';
		}

		public function init_admin() {
			
			$this->controller = new MCEasyPublisherController();
				
			if (isset($_REQUEST['mcepAction'])) {
			
				$action = $_REQUEST['mcepAction'];
				
			} else if (isset($_REQUEST['page'])) {
				$page = str_replace('|', ':', $_REQUEST['page']);
				if(strpos($page, ':')) {
					$pageArray = explode(':', $page);
					$controllerName = $pageArray[0];
					
					if ($controllerName != 'MCEasyPublisherController') {
						return;
					}
					
					$action = $pageArray[1];					
				}
			} else  {
				return;
			}

			if ($action != null || method_exists($this->controller, $action) == true) {

				try {
					
					$this->controller->$action();
					
				} catch (Exception $ex) {

					// Nothing actually needs to be done about this right here.
				}

				if (file_exists(MC_EASY_PUBLISHER_PLUGIN_PATH.$this->controller->viewName.'.css')) {
					wp_enqueue_style(
					'msep_'.$this->controller->viewName.'_css',
					MC_EASY_PUBLISHER_PLUGIN_URI.$this->controller->viewName.'.css',
					array(),
					null
					);
				}

				if (file_exists(MC_EASY_PUBLISHER_PLUGIN_PATH.$this->controller->viewName.'.js')) {
					wp_enqueue_script(
					'mcep_'.$this->controller->viewName.'_js',
					MC_EASY_PUBLISHER_PLUGIN_URI.$this->controller->viewName.'.js',
					array('jquery'),
					null,
					true
					);
				}
			}
		}

		public function init_view() {

			if (!current_user_can('manage_options'))  {
				wp_die(__('You do not have sufficient permissions to access this page.'));
			}

			if ( isset($_POST['__nonce']))
			{
				if (!wp_verify_nonce($_POST['__nonce'],'__nonce')) {
					print 'Sorry, your nonce did not verify.';
					exit;
				}
			}

			include_once MC_EASY_PUBLISHER_PLUGIN_PATH.$this->controller->viewName.'.php';
		}

		// Activation procedure
		private function _activate() {
			if (!current_user_can('activate_plugins'))
				return;
			$plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
			check_admin_referer("activate-plugin_{$plugin}");
		}
		public static function activate($networkwide) {
			self::_activate();
		}

		// Deactivation procedure
		private function _deactivate() {
			if (!current_user_can('activate_plugins'))
				return;
			$plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
			check_admin_referer("deactivate-plugin_{$plugin}");

			delete_option(MCEasyPublisherSettingsManager::WP_OPTION_NAME);
		}
		public static function deactivate($networkwide) {
			self::_deactivate();
		}


		public static function init() {
		}


		// WP Admin functions

		public function add_menu() {

			add_submenu_page(
				'options-general.php', // place under the Settings menu
				'Easy Publisher',
				'Easy Publisher',
				'manage_options',
				'MCEasyPublisherController|ViewSettings',
				array( &$this, 'init_view' )
			);

		}
	}

}

if (class_exists('MCEasyPublisher')) {

	// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('MCEasyPublisher', 'activate'));
	register_deactivation_hook(__FILE__, array('MCEasyPublisher', 'deactivate'));

	// instantiate the plugin class
	$mcEasyPublisherPlugin = new MCEasyPublisher();

	// Add a link to the settings page onto the plugin page
	if (isset($mcEasyPublisherPlugin)) {

		$plugin = plugin_basename(__FILE__);

	}

}

?>