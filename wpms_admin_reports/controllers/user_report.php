<?php
if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );
	
require_once( MCMVC_PLUGIN_DIR . '/moto_core_mvc/controller.php');

if( !class_exists( 'wpmsar_user_report_controller' ) ):

	class wpmsar_user_report_controller extends mcmvc_controller{
		
		private $model;
		
		public function __construct() {
			$this->model = self::__get_model();
		}
		
		public function load_view() {
			$data = $this->model->get_data();
			$view = self::__get_view();
			$view->display($data);
		}
		
		public function udpate_last_login($user_login, $user){
			$this->model->update_last_login($user);
		}		
	}
endif;