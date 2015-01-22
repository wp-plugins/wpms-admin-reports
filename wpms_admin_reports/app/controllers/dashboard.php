<?php
if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );

if( !class_exists( 'wpmsar_dashboard_controller' ) ):

	class wpmsar_dashboard_controller extends mcmvc {
		
		public function __construct() {
			if( !current_user_can('manage_network')){
				wp_die( 'Network Admins Only' );
			}
		}
		
		public function load_view() {
			$view = self::__get_view(WPMSAR_PLUGIN_DIR);
			$view->display();
		}
		
		public function load_mass_mail() {
			$data = self::__get_model(WPMSAR_PLUGIN_DIR)->get_mass_mail_data();
			require_once( WPMSAR_PLUGIN_DIR . '/app/views/mass_mail.php');
			$view = new wpmsar_mass_mail_view;	
			$view->display($data);
		}
		
		public function send_mass_mail(){
			if( !current_user_can('manage_network')){
				wp_die( 'Only Network Admins are allowed to email everyone.' );
			}
			check_admin_referer('wpmsar_mass_mail_verify');
			
			if ( isset($_POST['email_addresses']) && isset($_POST['email_message']) && isset($_POST['email_subject']) ){
				mail( $_POST['email_addresses'], $_POST['email_subject'], $_POST['email_message'] );			
			}else{
				wp_redirect( network_admin_url('admin.php?page=wpmsar_mass_mail&success=2') );
			}
			wp_redirect( network_admin_url('admin.php?page=wpmsar_mass_mail&success=1') );
		}
	}
		
endif;