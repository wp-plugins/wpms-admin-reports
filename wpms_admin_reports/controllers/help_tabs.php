<?php
if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );
	
require_once( MCMVC_PLUGIN_DIR . '/moto_core_mvc/controller.php');

if( !class_exists( 'wpmsar_help_tabs_controller' ) ):

	class wpmsar_help_tabs_controller extends mcmvc_controller {
		
		public function __construct() {
			$screen = get_current_screen();
			$screen->add_help_tab( array(
				'id'        => 'wpmsat_help_tab_about',
				'title'     => __('About'),
				'callback'  => array( __CLASS__, 'about_tab')
			));
			$screen->add_help_tab( array(
				'id'        => 'wpmsat_help_tab_dashboard',
				'title'     => __('Dashboard'),
				'callback'  => array( __CLASS__, 'dashboard_tab')
			));
			$screen->add_help_tab( array(
				'id'        => 'wpmsat_help_tab_site_report',
				'title'     => __('Site Report'),
				'callback'  => array( __CLASS__, 'site_report_tab')
			));
			$screen->add_help_tab( array(
				'id'        => 'wpmsat_help_tab_user_report',
				'title'     => __('User Report'),
				'callback'  => array( __CLASS__, 'user_report_tab')
			));
			$screen->add_help_tab( array(
				'id'        => 'wpmsat_help_tab_plugin_report',
				'title'     => __('Plugin Report'),
				'callback'  => array( __CLASS__, 'plugin_report_tab')
			));
		}
		
		//Callbacks
		public function about_tab() {
			return self::__get_view('about_tab')->display();
		}
		
		public function dashboard_tab() {
			return self::__get_view('dashboard_tab')->display();
		}
		
		public function site_report_tab() {
			return self::__get_view('site_report_tab')->display();
		}
		
		public function user_report_tab() {
			return self::__get_view('user_report_tab')->display();
		}
		
		public function plugin_report_tab() {
			return self::__get_view('plugin_report_tab')->display();
		}
		
	}
endif;