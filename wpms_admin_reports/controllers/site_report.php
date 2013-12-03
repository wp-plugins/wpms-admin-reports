<?php
if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );
	
require_once( MCMVC_PLUGIN_DIR . '/moto_core_mvc/controller.php');

if( !class_exists( 'wpmsar_site_report_controller' ) ):

	class wpmsar_site_report_controller extends mcmvc_controller{
				
		public function __construct() {			
			wp_localize_script( 
				'site_reportJS', 
				'ajax_object', 
				array( 
					'ajax_url' 		=> admin_url( 'admin-ajax.php' ),
					'ajax_nonce' 	=> wp_create_nonce('site_report'),
					'site_list' 	=> json_encode(self::__get_model()->site_list)
				)
			);
			
			//$this->update_site_status();
		}
		
		public function load_view() {
			$data = self::__get_model()->get_data();
			$view = self::__get_view();
			$view->display($data);
		}
		
		public function site_check(){
			echo self::__process_ajax_request('site_report', get_class(self::__get_model()), 'site_check' );
			die();			
		}
		
		public function update_site_status(){
			echo self::__process_ajax_request('site_report', get_class(self::__get_model()), 'update_site_status' );
			die();			
		}
	}
endif;
?>