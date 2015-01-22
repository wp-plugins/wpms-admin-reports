<?php
if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );	

if( !class_exists( 'wpmsar_dashboard_model' ) ):

	class wpmsar_dashboard_model {
		
		private $blogs;
		
		public function __construct() {
			global $wpdb;
			
			$this->blogs = $wpdb->get_results("
				SELECT blog_id
				FROM " . $wpdb->base_prefix . "blogs
				ORDER BY blog_id ASC
			");		
		}
		
		public function get_mass_mail_data(){
			$data = array();
						
			foreach( $this->blogs as $blog){
				
				switch_to_blog($blog->blog_id);
				
				//add all admin emails once and ignore default UWGB email.
				$new_email = get_option('admin_email');
				if(!in_array($new_email, $data)){
					$data[] = $new_email;
				}
				restore_current_blog();
			}
			
			return $data;
		}		
	}
endif;