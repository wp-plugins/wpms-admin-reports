<?php
if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );

if( !class_exists( 'wpmsar_site_report_controller' ) ):

	class wpmsar_site_report_controller extends mcmvc{
				
		public function __construct() {
			if( !current_user_can('manage_network')){
				wp_die( 'Network Admins Only' );
			}		
			wp_localize_script( 
				'site_reportJS', 
				'ajax_object', 
				array( 
					'ajax_url' 		=> admin_url( 'admin-ajax.php' ),
					'ajax_nonce' 	=> wp_create_nonce('site_report'),
					'site_list' 	=> json_encode(self::__get_model(WPMSAR_PLUGIN_DIR)->site_list)
				)
			);
		}
		
		public function load_view() {
			
			if(isset($_GET['action']) && isset($_GET['id']) ){
				$action = $_GET['action'];
				$id = $_GET['id'];
				if ($action == "archive"){
					check_admin_referer('wpmsar_archive');
					if( !is_archived($id)){
						update_blog_status( $id, 'archived', '1' );
						$msg = "Blog Archived - Please%20update%20data%20to%20see%20changed%20status.";
					}else{
						$msg = "Blog%20is%20already%20archived...";
					}
				}
				if ($action == "unarchive"){
					check_admin_referer('wpmsar_unarchive');
					if( is_archived($id)){
						update_blog_status( $id, 'archived', '0' );
						$msg = "Blog%20Unarchived%20-%20Please%20update%20data%20to%20see%20changed%20status.";
					}else{
						$msg = "Blog%20is%20already%20unarchived...";
					}
				}
				wp_redirect(network_admin_url("admin.php?page=wpmsar_site_report&msg=".$msg));
				exit;
			}
			
			$data = self::__get_model(WPMSAR_PLUGIN_DIR)->get_data();
			$view = self::__get_view(WPMSAR_PLUGIN_DIR);
			$view->display($data);
		}
		
		public function site_check(){
			echo self::__process_ajax_request('site_report', get_class(self::__get_model(WPMSAR_PLUGIN_DIR)), 'site_check' );
			die();			
		}
		
		public function update_site_status(){
			echo self::__process_ajax_request('site_report', get_class(self::__get_model(WPMSAR_PLUGIN_DIR)), 'update_site_status' );
			die();			
		}
	}
endif;
?>