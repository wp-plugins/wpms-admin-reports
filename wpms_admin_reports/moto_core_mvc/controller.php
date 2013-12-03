<?php
/**
 * Framework Name: Moto Core MVC
 * Plugin URI: http://addlater
 * Description: This frameworks contains the core functions needed for basic MVC operations within the WP codebase.  This is not strict MVC, just what makes sense within the WordPress framework. 
 * Version: 0.5
 * Author: Joe Motacek
 * Author URI: http://www.joemotacek.com
 * License: GPL2
 * 
 * @package moto_core
 * @since 0.2
 *
 * Moto Core Dispatcher
 * Purpose:
 *  - holds instances of controllers
 */

if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );

if ( ! class_exists( 'mcmvc_controller' ) ):
	
	abstract class mcmvc_controller extends mcmvc_dispatcher{
		private static $models = array();
		private static $views = array();
		private static $helpers = array();
		
		public static function __get_model($name = null) {
			if(!$name){
				$controller_name = get_called_class();
				preg_match('/(?<=_).*(?=_)/', $controller_name, $matches);
				$name = $matches[0];
			}
			
			$model = MCMVC_SHORT_CODE . '_' . $name . '_model';
			if( ! isset( self::$models[$model]) ) {
				require_once( MCMVC_PLUGIN_DIR . '/models/' . $name . '.php');
				self::$models[$model] = new $model;
			}
			
			return self::$models[$model];				
		}
		
		public static function __get_view($name = null) {
			if(!$name){
				$controller_name = get_called_class();
				preg_match('/(?<=_).*(?=_)/', $controller_name, $matches);
				$name = $matches[0];
			}
			
			$view = MCMVC_SHORT_CODE . '_' . $name . '_view';
			if( ! isset( self::$views[$view]) ) {
				require_once( MCMVC_PLUGIN_DIR . '/views/' . $name . '.php');
				self::$views[$view] = new $view;
			}
			
			return self::$views[$view];				
		}
		
		public static function __get_helper($name) {
			
			$helper = MCMVC_SHORT_CODE . '_' . $name . '_helper';
			if( ! isset( self::$helpers[$helper]) ) {
				require_once( MCMVC_PLUGIN_DIR . '/helpers/' . $name . '.php');
				self::$helpers[$helper] = new $helper;
			}
			
			return self::$helpers[$helper];				
		}
		
		public static function __process_ajax_request($nonce, $model_name, $function_name){
			if( isset($_GET['nonce']) && isset($_GET['json_data']) ){
				$sent_nonce 	= $_GET['nonce'];
				$json_data 		= $_GET['json_data'];
			}elseif( isset($_POST['nonce']) && isset($_POST['json_data']) ){
				$sent_nonce 	= $_POST['nonce'];
				$json_data 		= $_POST['json_data'];
			}else{
				return "Nonce or data not found - Access Denied";
			}	
					
			if( wp_verify_nonce($sent_nonce, $nonce) ){
				$result = call_user_func(array($model_name, $function_name), $json_data );
			}else{
				$result = array('message' => "<img src='http://static1.wikia.nocookie.net/__cb20111128234452/jurassicpark/images/5/5f/YouDidn%27tSayTheMagicWord.gif' /> <br/>Ah ah ah... <br/> You didn't say the magic word.");
			}
			
			if(is_array($result) ){
				return json_encode($result);
			}else{
				return $result;
			}
				
			
		}
	}
endif;