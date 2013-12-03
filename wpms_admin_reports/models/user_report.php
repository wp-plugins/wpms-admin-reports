<?php
if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );

if( !class_exists( 'wpmsar_user_report_model' ) ):

	class wpmsar_user_report_model {
		
		public function get_data(){
			global $wpdb;
			
			$data = $wpdb->get_results("SELECT id, user_login, user_email, user_registered, display_name" .
				" FROM " . $wpdb->users .
				" WHERE deleted = 0" .
				" ORDER BY ID ASC");
				
			$last_logins = get_site_option('wpmsar_last_logins');
			
			if(!$last_logins){
				$last_logins = array();
			}
			
			foreach( $data as &$user){
				//Get Last login and last IP address
				$user->last_login = 'Unknown';
				$user->ip_address = 'Unknown';
				foreach($last_logins as $login){
					if($login['id'] == $user->id){
						$user->last_login = date('Y-m-d', $login['last_login']);
						$user->ip_address = $login['last_ip'];
					}
				}
				//Set last login status
				if($user->last_login == "Unknown"){
					$user->last_login_status = 'bad';
				}elseif(strtotime( $user->last_login ) < strtotime('-1 year')){
					$user->last_login_status = 'worst';
				}elseif(strtotime( $user->last_login ) < strtotime('-8 month') ) {
					$user->last_login_status = 'bad';
				}elseif(strtotime( $user->last_login ) < strtotime('-4 month') ) {
					$user->last_login_status = 'good';
				}else{
					$user->last_login_status = 'best';
				}
				//Get blogs they are asigned to
				$user->blogs = get_blogs_of_user($user->id);
				//Get their roles for the respective blogs
				foreach($user->blogs as &$blog){
					switch_to_blog($blog->userblog_id);
					$userdata = get_userdata($user->id);
					$blog->role =  $userdata->roles[0];
					restore_current_blog();
				}
			}
			
			$this->update_dashboard_cache($data);
			
			return $data;
		}
		
		private function update_dashboard_cache($data){
			
			$cache_data = get_site_option('wpmsar_dashboard_cache');
			if(!isset($cache_data) ){
				$cache_data = array();
			}
			
			$names = array("users_login_worst", "users_login_bad", "users_login_good", "users_login_best",
			"count_users", "unassigned_users");
				
			foreach($names as $name){
				$cache_data[$name] = 0;
			}
			
			foreach($data as $user){
				
				if( $user->last_login_status == 'worst' ) {
					$cache_data['users_login_worst']++;
				}elseif( $user->last_login_status == 'bad' ) {
					$cache_data['users_login_bad']++;
				}elseif( $user->last_login_status == 'good' ) {
					$cache_data['users_login_good']++;
				}else{
					$cache_data['users_login_best']++;
				}
								
				if(count($user->blogs) == 0){
					$cache_data['unassigned_users']++;
				}
			}
			$cache_data['count_users'] = count($data);
			
			
			update_site_option('wpmsar_dashboard_cache', $cache_data);
		}
		
		public function update_last_login($user) {
			$current_user = $user->get('ID');
			$last_logins = get_site_option('wpmsar_last_logins');
			$found = false;
			
			if($last_logins){
				foreach($last_logins as &$user){
					if( $user['id'] === $current_user ){
						$found = true;
						$user['last_login'] = time();
						$user['last_ip'] = $_SERVER['REMOTE_ADDR'];
					}
				}
			}else{
				$last_logins = array();
			}
			
			if(!$found){
				$user = array();
				$user['id'] = $current_user;
				$user['last_login'] = time();
				$user['last_ip'] = $_SERVER['REMOTE_ADDR'];
				array_push($last_logins, $user);
			}
			
			update_site_option('wpmsar_last_logins', $last_logins);
		}
		
	}
	
endif;