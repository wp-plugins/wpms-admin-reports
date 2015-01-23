<?php
if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );

if( !class_exists( 'wpmsar_user_report_controller' ) ):

	class wpmsar_user_report_controller extends mcmvc{
		
		private $model;
		
		public function __construct() {
			//no check in here for network admin because this is 
			//used as part of the login
			$this->model = self::__get_model(WPMSAR_PLUGIN_DIR);
		}
		
		public function load_view() {
			if( !current_user_can('manage_network')){
				wp_die( 'WPMSAR - Network Admins Only' );
			}
			$messages = array();
			if(isset($_GET['action']) && isset($_GET['user_id']) ){
				$action = $_GET['action'];
				$id = $_GET['user_id'];
				//Start Here:
				if ($action == "disable_user" && wp_verify_nonce($_GET['_wpnonce'],'wpmsar_disable_user')){
					update_user_meta($id, 'disabled', true);
					array_push($messages, "<div class='error'><p>User has been disabled.</p></div>");
				}
				if ($action == "enable_user" && wp_verify_nonce($_GET['_wpnonce'],'wpmsar_enable_user')){
					delete_user_meta($id, 'disabled');
					array_push($messages, "<div class='updated'><p>User has been enabled.</p></div>");
				}
			}

			$data = $this->model->get_data();
			$view = self::__get_view(WPMSAR_PLUGIN_DIR);
			$view->display($data, $messages);
		}
		
		public function udpate_last_login($user_login, $user){
			$this->model->update_last_login($user);
		}

		public function check_disabled($user_name){
			$this->model->check_disabled($user_name);
		}

		public function disabled_user($actions, $user){
			return $this->model->disabled_user($actions, $user);
		}		
	}
endif;