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
			$messages = array();
			if(isset($_GET['action']) && isset($_GET['id']) ){
				$action = $_GET['action'];
				$id = $_GET['id'];
				if ($action == "archive" && wp_verify_nonce($_GET['_wpnonce'],'wpmsar_archive')){
					if( !is_archived($id)){
						update_blog_status( $id, 'archived', '1' );
						array_push($messages, "<div class='updated'><p>Blog Archived - Please update data to see changed status.</p></div>");
					}else{
						array_push($messages, "<div class='error'><p>Blog is already archived...</p></div>");
					}
				}
				if ($action == "unarchive" && wp_verify_nonce($_GET['_wpnonce'],'wpmsar_unarchive')){
					if( is_archived($id)){
						update_blog_status( $id, 'archived', '0' );
						array_push($messages, "<div class='updated'><p>Blog Unarchived - Please update data to see changed status.</p></div>");
					}else{
						array_push($messages, "<div class='error'><p>Blog is already unarchived...</p></div>");
					}
				}
			}
			
			$data = self::__get_model(WPMSAR_PLUGIN_DIR)->get_data();
			$view = self::__get_view(WPMSAR_PLUGIN_DIR);
			$view->display($data, $messages);
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