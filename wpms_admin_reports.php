<?php
/**
* Plugin Name: WordPress Multisite Admin Reports
* Plugin URI: http://www.wordpress.org/plugins/wpms_admin_reports
* Description: TWPMS Admin Reports is a reporting tool for Wordpress Multisite administrators.
* Version: 1.0
* Author: Joe Motacek
* Author URI: http://www.joemotacek.com
* License: GPL2
*
* @package wpms_admin_reports
* @since 0.1
*
* Dispatcher
* Plugin Bootstrap
* Check requirements and gets instance of plugin
*/

//Define requirments
define( 'MCMVC_NAME',                 	'WordPress Multsite Admin Reports' );
define( 'MCMVC_SHORT_CODE',		'wpmsar' );
define( 'MCMVC_REQUIRED_PHP_VERSION', 	'5.3.1' ); 
define( 'MCMVC_REQUIRED_WP_VERSION',  	'3.1' ); 

function mcmvc_requirments_check() {
	global $wp_version;
	
	if ( version_compare( PHP_VERSION, MCMVC_REQUIRED_PHP_VERSION, '<') ) {
		return false;
	}
	
	if ( version_compare( $wp_version, MCMVC_REQUIRED_WP_VERSION, '<') ) {
		return false;
	}
	
	return true;
}

if( mcmvc_requirments_check() ) {
	require_once ( WPMU_PLUGIN_DIR . '/wpms_admin_reports/' . MCMVC_SHORT_CODE . '_dispatcher.php');
	$classname = MCMVC_SHORT_CODE . '_dispatcher';
	if( class_exists( $classname ) ) {
		$GLOBALS[MCMVC_SHORT_CODE] = new $classname;
	} else{
		throw new Exception( $classname . ' error: static method get_dispatcher does not exist.');
	}
}else {
	throw new Exception ("This plugin requires PHP version 5.3.1 or higher and WP version 3.1 or higher");
}
