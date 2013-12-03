<?php
if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );	

if( !class_exists( 'wpmsar_site_report_model' ) ):

	class wpmsar_site_report_model {
		
		public 	$site_list;
		private $blogs;
		
		public function __construct() {
			global $wpdb;
			
			$this->blogs = $wpdb->get_results("
				SELECT blog_id
				FROM " . $wpdb->base_prefix . "blogs
				ORDER BY blog_id ASC
			");
			
			$this->site_list = array();
			
			foreach($this->blogs as $blog){
				switch_to_blog($blog->blog_id);
				array_push( $this->site_list, get_option('blogname') );
				restore_current_blog();
			}			
		}
		
		public function get_data(){
			$data = array();
			
			global $blog_id;
			
			foreach( $this->blogs as $blog){
				
				$site_statuses = get_site_option('wpmsar_site_data');
				
				if(!$site_statuses){
					$site_statuses = array();
				}
							
				$blog_details = get_blog_details($blog->blog_id);
				$blog_details->blog_id = $blog->blog_id;
				switch_to_blog($blog->blog_id);
				
				//Options
				$blog_details->admin_email = get_option('admin_email');
				$blog_details->blog_name = get_option('blogname');
				$blog_details->current_theme = get_option('current_theme');
				$blog_details->home_url = get_option('home');
				
				//Last Post
				$last_post = wp_get_recent_posts( array( 'numberposts' => '1') );
				if( isset($last_post[0]) ){
					$blog_details->last_post_date = date("Y-m-d", strtotime( $last_post[0]['post_date'] ) );
					if(strtotime( $last_post[0]['post_date'] ) < strtotime('-1 year') ) {
						$blog_details->last_post_status = 'worst';
					}elseif(strtotime( $last_post[0]['post_date'] ) < strtotime('-8 month') ) {
						$blog_details->last_post_status = 'bad';
					}elseif(strtotime( $last_post[0]['post_date'] ) < strtotime('-4 month') ) {
						$blog_details->last_post_status = 'good';
					}else{
						$blog_details->last_post_status = 'best';
					}
				}else{
					$blog_details->last_post_date = "No Posts";
					$blog_details->last_post_status = 'worst';
				}
				
				//Last Updated
				if(strtotime($blog_details->last_updated) < strtotime('-1 year') ) {
					$blog_details->last_updated_status = 'worst';
				}elseif(strtotime($blog_details->last_updated) < strtotime('-8 month') ) {
					$blog_details->last_updated_status = 'bad';
				}elseif(strtotime($blog_details->last_updated) < strtotime('-4 month') ) {
					$blog_details->last_updated_status = 'good';
				}else{
					$blog_details->last_updated_status = 'best';
				}
									
				//Users
				$users = get_users( array("blog_id" => $blog->blog_id) );
				$blog_details->user_count = count($users);
				restore_current_blog();
				
				//Site Status
				foreach($site_statuses as $site => $status){
					if($blog_details->blog_name == $site){
						$blog_details->site_status = $status;
					}
				}
				if(!isset($blog_details->site_status) ){
					$blog_details->site_status = "Unknown";
				}
				
				array_push($data, $blog_details);
			}
			
			$this->update_dashboard_cache($data);
			
			return $data;
		}
		
		private function update_dashboard_cache($data){
			
			$cache_data = get_site_option('wpmsar_dashboard_cache');
			if(!isset($cache_data) ){
				$cache_data = array();
			}
			
			$names = array("sites_up", "sites_down", "last_updated_worst", "last_updated_bad", 
				"last_updated_good", "last_updated_best", "last_post_worst", "last_post_bad", 
				"last_post_good", "last_post_best", "sites_no_users", "sites_count");
				
			foreach($names as $name){
				$cache_data[$name] = 0;
			}
			
			foreach($data as $site){
				if(!isset($site->site_status) ){
					$cache_data['sites_down']++;
				}elseif($site->site_status == "Up"){
					$cache_data['sites_up']++;	
				}else{
					$cache_data['sites_down']++;
				}
				
				if( $site->last_updated_status == 'worst' ) {
					$cache_data['last_updated_worst']++;
				}elseif( $site->last_updated_status == 'bad' ) {
					$cache_data['last_updated_bad']++;
				}elseif( $site->last_updated_status == 'good' ) {
					$cache_data['last_updated_good']++;
				}else{
					$cache_data['last_updated_best']++;
				}
				
				if( $site->last_post_status == 'worst' ) {
					$cache_data['last_post_worst']++;
				}elseif( $site->last_post_status == 'bad' ) {
					$cache_data['last_post_bad']++;
				}elseif( $site->last_post_status == 'good' ) {
					$cache_data['last_post_good']++;
				}else{
					$cache_data['last_post_best']++;
				}
				
				if((int)$site->user_count == 0){
					$cache_data['sites_no_users']++;
				}
			}
			$cache_data['sites_count'] = count($data);
			
			update_site_option('wpmsar_dashboard_cache', $cache_data);
		}
		
		public function site_check( $json ) {
			ini_set('default_socket_timeout', 5); 
			global $wpdb;
			
			$blogs = $wpdb->get_results("
				SELECT blog_id
				FROM " . $wpdb->base_prefix . "blogs
				ORDER BY blog_id ASC
			");
			
			$site_name = htmlentities(stripslashes($json['site_name']), ENT_QUOTES);
			foreach($blogs as $blog){
				switch_to_blog($blog->blog_id);
				if(get_option('blogname') == $site_name){
					$home_url = get_option('home');
				}
				restore_current_blog();
			}
			
			if(isset($home_url) ){
				$site_home_page = @file_get_contents($home_url, NULL, NULL, 0 , 10);
				if($site_home_page !== false){
					$status = "Up";
				}else{
					$status = "Down";
				}
								
				$message = 'Site: ' . $site_name . ' updated...';
				$result = array('message' => $message, 'site_name' => $site_name, 'status' => $status);
			}else{
				$message = 'Site: ' . $site_name . ' not found...';
				$result = array('message' => $message, 'site_name' => $site_name, 'status' => "???");
			}
			
			return $result;
		}
		
		public function update_site_status( $data ) {
			
			update_site_option('wpmsar_site_data', $data);
			update_site_option('wpmsar_site_freshness', time());
			
			return 'All site data updated. Refreshing Page....';
		}
		
	}
endif;