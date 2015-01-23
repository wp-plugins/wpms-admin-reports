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

			if(isset($_GET['action']) && isset($_GET['user_id']) ){
				$action = $_GET['action'];
				$id = $_GET['user_id'];
				//Start Here:
				$msg = "";
				if ($action == "disable_user"){
					check_admin_referer('wpmasr_disable_user');
					update_user_meta($id, 'disabled', true);
					$msg = "User%20disabeled";
				}
				if ($action == "enable_user"){
					check_admin_referer('wpmasr_enable_user');
					delete_user_meta($id, 'disabled');
					$msg = "User%20enabeled";
				}
				wp_redirect(network_admin_url("admin.php?page=wpmsar_user_report&msg=".$msg));
				exit();
			}

			$data = $this->model->get_data();
			$view = self::__get_view(WPMSAR_PLUGIN_DIR);
			$view->display($data);
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