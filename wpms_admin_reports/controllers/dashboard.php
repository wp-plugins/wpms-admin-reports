<?php
if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );
	
require_once( MCMVC_PLUGIN_DIR . '/moto_core_mvc/controller.php');

if( !class_exists( 'wpmsar_dashboard_controller' ) ):

	class wpmsar_dashboard_controller extends mcmvc_controller{
		
		public function __construct() {
		}
		
		public function load_view() {
			$view = self::__get_view();
			$view->display();
		}
		
	}
		
endif;