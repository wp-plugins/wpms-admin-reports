<?php
if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );

if( !class_exists( 'wpmsar_menu_controller' ) ):

	class wpmsar_menu_controller extends mcmvc {
		
		public function __construct() {
			$menu = add_menu_page(
				__('Admin Reports Dashboard'), 
				__('Admin Reports'), 
				'manage_network', 
				'wpms_admin_reports', 
				array(__CLASS__, 'dashboard') 
			);
			
			$site_report = add_submenu_page(
				'wpms_admin_reports', 
				__('Site Report'), 
				__('Site Report'), 
				'manage_network', 
				'wpmsar_site_report', 
				array(__CLASS__, 'site_report') 
			);
			
			$user_report = add_submenu_page(
				'wpms_admin_reports', 
				__('User Report'), 
				__('User Report'), 
				'manage_network', 
				'wpmsar_user_report', 
				array(__CLASS__, 'user_report') 
			);
			
			$plugin_report = add_submenu_page(
				'wpms_admin_reports', 
				__('Plugin Report'), 
				__('Plugin Report'), 
				'manage_network', 
				'wpmsar_plugin_report', 
				array(__CLASS__, 'plugin_report') 
			);
			$mass_mail = add_submenu_page(
				NULL, 
				__('Email Admins'), 
				__('Email Admins'), 
				'manage_network', 
				'wpmsar_mass_mail', 
				array(__CLASS__, 'mass_mail') 
			);

			add_action("load-" . $menu, array( __CLASS__, 'help_tabs'));
			add_action("load-" . $plugin_report, array( __CLASS__, 'help_tabs'));
			add_action("load-" . $site_report, array( __CLASS__, 'help_tabs'));
			add_action("load-" . $user_report, array( __CLASS__, 'help_tabs'));
		}
		
		//Callbacks
		public function dashboard() {
			self::__get_controller(WPMSAR_PLUGIN_DIR, 'dashboard', 'wpmsar')->load_view();
		}
		
		public function mass_mail() {
			self::__get_controller(WPMSAR_PLUGIN_DIR, 'dashboard', 'wpmsar')->load_mass_mail();
		}
		
		public function plugin_report() {
			self::__get_controller(WPMSAR_PLUGIN_DIR, 'plugin_report', 'wpmsar')->load_view();
		}
		
		public function site_report() {
			self::__get_controller(WPMSAR_PLUGIN_DIR, 'site_report', 'wpmsar')->load_view();
		}
		
		public function user_report() {
			self::__get_controller(WPMSAR_PLUGIN_DIR, 'user_report', 'wpmsar')->load_view();
		}		
		
		public function help_tabs() {
			self::__get_controller(WPMSAR_PLUGIN_DIR, 'help_tabs', 'wpmsar');		     
		}		
	}
endif;