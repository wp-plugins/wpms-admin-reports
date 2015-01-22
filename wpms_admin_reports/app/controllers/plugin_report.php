<?php
if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );

if( !class_exists( 'wpmsar_plugin_report_controller' ) ):

	class wpmsar_plugin_report_controller extends mcmvc{
		
		public function __construct() {	
			if( !current_user_can('manage_network')){
				wp_die( 'Network Admins Only' );
			}		
			wp_localize_script( 
				'plugin_reportJS', 
				'ajax_object', 
				array( 
					'ajax_url' 		=> admin_url( 'admin-ajax.php' ), 
					'ajax_nonce' 	=> wp_create_nonce('plugin_report'),
					'plugin_list' 	=> json_encode(self::__get_model(WPMSAR_PLUGIN_DIR)->plugin_list)
				) 
			);
		}
		
		public function load_view() {
			$data = self::__get_model(WPMSAR_PLUGIN_DIR)->get_data();
			$view = self::__get_view(WPMSAR_PLUGIN_DIR);
			$view->display($data);
		}
		
		//AJAX Requests
		public function update_plugin_list(){
			echo self::__process_ajax_request('plugin_report', get_class(self::__get_model(WPMSAR_PLUGIN_DIR)), 'update_plugin_list' );
			die();	
		}
		
		public function update_plugin_status(){
			
			echo self::__process_ajax_request('plugin_report', get_class(self::__get_model(WPMSAR_PLUGIN_DIR)), 'derelict_check' );
			die();			
		}
		
		public function update_derelict_status(){			
			echo self::__process_ajax_request('plugin_report', get_class(self::__get_model(WPMSAR_PLUGIN_DIR)), 'update_derelict_status' );
			die();			
		}
		
	}
endif;
?>