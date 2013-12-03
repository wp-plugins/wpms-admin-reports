<<<<<<< HEAD:trunk/wpms_admin_reports/wpmsar_dispatcher.php
<?php 
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
		public function add_menu() {
			self::__get_controller('menu');		
		}
		
		public function last_login($user_login, $user) {
			$user_report = self::__get_controller('user_report');
			$user_report->udpate_last_login($user_login, $user);		
		}
		
		public function update_plugin_list() {
			$plugin_stats = self::__get_controller('plugin_report');
			$plugin_stats->update_plugin_list();
		}
		
		public function update_plugin_status() {
			$plugin_stats = self::__get_controller('plugin_report');
			$plugin_stats->update_plugin_status();
		}
		
		public function update_derelict_status() {
			$plugin_stats = self::__get_controller('plugin_report');
			$plugin_stats->update_derelict_status();
		}
		
		public function site_check() {
			$site_report = self::__get_controller('site_report');
			$site_report->site_check();
		}
		
		public function update_site_status() {
			$site_report = self::__get_controller('site_report');
			$site_report->update_site_status();
		}
			
	}
endif;
=======
<?php 
/**
* Plugin Name: WordPress Multisite Admin Reports
* Plugin URI: http://www.wordpress.org/plugins/wpms_admin_reports
* Description: TWPMS Admin Reports is a reporting tool for Wordpress Multisite administrators.
* Version: 1.0
* Author: Joe Motacek
* Author URI: http://www.joemotacek.com
* License: GPL2
*
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
		public function add_menu() {
			self::__get_controller('menu');		
		}
		
		public function last_login($user_login, $user) {
			$user_report = self::__get_controller('user_report');
			$user_report->udpate_last_login($user_login, $user);		
		}
		
		public function update_plugin_list() {
			$plugin_stats = self::__get_controller('plugin_report');
			$plugin_stats->update_plugin_list();
		}
		
		public function update_plugin_status() {
			$plugin_stats = self::__get_controller('plugin_report');
			$plugin_stats->update_plugin_status();
		}
		
		public function update_derelict_status() {
			$plugin_stats = self::__get_controller('plugin_report');
			$plugin_stats->update_derelict_status();
		}
		
		public function site_check() {
			$site_report = self::__get_controller('site_report');
			$site_report->site_check();
		}
		
		public function update_site_status() {
			$site_report = self::__get_controller('site_report');
			$site_report->update_site_status();
		}
			
	}
endif;
>>>>>>> cc70c92b9c180ec03f5911e8410ba30163eddd86:wpms_admin_reports/wpmsar_dispatcher.php
