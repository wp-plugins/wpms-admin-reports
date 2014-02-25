<?php 
/**
* @package wpms_admin_reports
* @since 0.1
*
* Dispatcher
*/

//For calling scritps, css, and php from the root of the plugin
define( 'MCMVC_PLUGIN_DIR',	plugin_dir_path( __FILE__ ) );
define( 'MCMVC_PLUGIN_URL',	plugins_url('', __FILE__ ) );

require_once( MCMVC_PLUGIN_DIR . '/moto_core_mvc/dispatcher.php');

if ( !class_exists('wpmsar_dispatcher') ):
	 
	class wpmsar_dispatcher extends mcmvc_dispatcher {
		 
		public function __construct() {
			add_action( 'network_admin_menu', 				array(__CLASS__, 'add_menu') );
			add_action( 'wp_login', 						array(__CLASS__, 'last_login'),  10, 2);
			add_action( 'wp_ajax_update_plugin_list', 		array(__CLASS__ , 'update_plugin_list') );
			add_action( 'wp_ajax_update_plugin_status', 	array(__CLASS__ , 'update_plugin_status') );
			add_action( 'wp_ajax_update_derelict_status', 	array(__CLASS__ , 'update_derelict_status') );
			add_action( 'wp_ajax_site_check', 				array(__CLASS__ , 'site_check') );
			add_action( 'wp_ajax_update_site_status', 		array(__CLASS__ , 'update_site_status') );
		}
		
		//Callbacks in order listed in order of registration
		public static function add_menu() {
			self::__get_controller('menu');		
		}
		
		public static function last_login($user_login, $user) {
			$user_report = self::__get_controller('user_report');
			$user_report->udpate_last_login($user_login, $user);		
		}
		
		public static function update_plugin_list() {
			$plugin_stats = self::__get_controller('plugin_report');
			$plugin_stats->update_plugin_list();
		}
		
		public static function update_plugin_status() {
			$plugin_stats = self::__get_controller('plugin_report');
			$plugin_stats->update_plugin_status();
		}
		
		public static function update_derelict_status() {
			$plugin_stats = self::__get_controller('plugin_report');
			$plugin_stats->update_derelict_status();
		}
		
		public static function site_check() {
			$site_report = self::__get_controller('site_report');
			$site_report->site_check();
		}
		
		public static function update_site_status() {
			$site_report = self::__get_controller('site_report');
			$site_report->update_site_status();
		}
			
	}
endif;