<?php 
/**
* Dispatcher
*/

//For calling scritps, css, and php from the root of the plugin
define( 'WPMSAR_PLUGIN_DIR',	plugin_dir_path( __FILE__ ) );
define( 'WPMSAR_PLUGIN_URL',	plugins_url('', __FILE__ ) );


if ( !class_exists('wpmsar_dispatcher') ):

	class wpmsar_dispatcher extends mcmvc { 
		 
		public function __construct() {
			add_action( 'network_admin_menu', 				array(__CLASS__, 'add_menu') );
			add_action( 'wp_authenticate',					array(__CLASS__, 'check_disabled'));
			add_filter( 'user_row_actions', 				array(__CLASS__, 'disabled_user'), 10 ,2);
			add_filter( 'ms_user_row_actions',				array(__CLASS__, 'disabled_user'), 10 ,2);
			add_action( 'wp_login', 						array(__CLASS__, 'last_login'), 10, 2);
			add_action( 'wp_ajax_update_plugin_list', 		array(__CLASS__, 'update_plugin_list') );
			add_action( 'wp_ajax_update_plugin_status', 	array(__CLASS__, 'update_plugin_status') );
			add_action( 'wp_ajax_update_derelict_status', 	array(__CLASS__, 'update_derelict_status') );
			add_action( 'wp_ajax_site_check', 				array(__CLASS__, 'site_check') );
			add_action( 'wp_ajax_update_site_status', 		array(__CLASS__, 'update_site_status') );
			add_action( 'admin_post_wpmsar_send_mass_mail',	array(__CLASS__, 'send_mass_mail') );
			add_action( 'admin_enqueue_scripts', 			array(__CLASS__, 'load_common_resources'));
		}
		
		//Callbacks in order listed in order of registration
		public function add_menu() {
			self::__get_controller(WPMSAR_PLUGIN_DIR, 'menu', 'wpmsar');		
		}

		public function check_disabled($user_name) {
			$user_report = self::__get_controller(WPMSAR_PLUGIN_DIR, 'user_report', 'wpmsar');
			$user_report->check_disabled($user_name);	
		}

		public function disabled_user($actions, $user) {
			$user_report = self::__get_controller(WPMSAR_PLUGIN_DIR, 'user_report', 'wpmsar');
			return $user_report->disabled_user($actions, $user);	
		}
		
		public function last_login($user_login, $user) {
			$user_report = self::__get_controller(WPMSAR_PLUGIN_DIR, 'user_report', 'wpmsar');
			$user_report->udpate_last_login($user_login, $user);		
		}
		
		public function update_plugin_list() {
			$plugin_stats = self::__get_controller(WPMSAR_PLUGIN_DIR, 'plugin_report', 'wpmsar');
			$plugin_stats->update_plugin_list();
		}
		
		public function update_plugin_status() {
			$plugin_stats = self::__get_controller(WPMSAR_PLUGIN_DIR, 'plugin_report', 'wpmsar');
			$plugin_stats->update_plugin_status();
		}
		
		public function update_derelict_status() {
			$plugin_stats = self::__get_controller(WPMSAR_PLUGIN_DIR, 'plugin_report', 'wpmsar');
			$plugin_stats->update_derelict_status();
		}
		
		public function site_check() {
			$site_report = self::__get_controller(WPMSAR_PLUGIN_DIR, 'site_report', 'wpmsar');
			$site_report->site_check();
		}
		
		public function update_site_status() {
			$site_report = self::__get_controller(WPMSAR_PLUGIN_DIR, 'site_report', 'wpmsar');
			$site_report->update_site_status();
		}
		
		public function send_mass_mail() {
			$dashboard = self::__get_controller(WPMSAR_PLUGIN_DIR, 'dashboard', 'wpmsar');
			$dashboard->send_mass_mail();
		}

		public function load_common_resources($hook){
			self::__get_helper(WPMSAR_PLUGIN_DIR, 'resources', 'wpmsar')->load_scripts($hook);
		}
	}
endif;
