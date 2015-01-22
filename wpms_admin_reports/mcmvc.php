<?php
/**
 * Framework Name: Moto Core MVC
 * Plugin URI: http://addlater
 * Description: This frameworks contains the core functions needed for basic MVC operations within the WP codebase.  This is not strict MVC, just what makes sense within the WordPress framework. 
 * Version: 0.8.3
 * Author: Joe Motacek
 * Author URI: http://www.joemotacek.com
 * License: GPL2
 * 
 * @package moto_core
 *
 * Moto Core MVC 
 * Purpose:
 *  - holds instances of controllers, models, views and helpers.
 */

if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );

ini_set('display_errors', 1); 
error_reporting(E_ALL);

if ( !class_exists( 'mcmvc' ) ):
	
	class mcmvc{
		private static $controllers = array();
		private static $models = array();
		private static $views = array();
		private static $helpers = array();
		
		public function __get_controller($path, $name, $shortcode) {
			$controller = $shortcode . '_' . $name . '_controller';
			if( ! isset( self::$controllers[$controller]) ) {
				require_once( $path . '/app/controllers/' . $name . '.php');
				self::$controllers[$controller] = new $controller;
			}
			
			return self::$controllers[$controller];				
		}
		
		public function __get_model($path, $name = NULL, $shortcode = NULL) {
			if(is_null($name) || is_null($shortcode)){
				$madel_name = get_called_class();
				// Get shortcode 
				preg_match('/.*?(?=_)/', $madel_name, $matches);
				$shortcode = $matches[0];
				// Get name
				preg_match('/(?<=_).*(?=_controller)/', $madel_name, $matches);
				$name = $matches[0];
			}
			
			$model = $shortcode . '_' . $name . '_model';
			if( ! isset( self::$models[$model]) ) {
				require_once( $path . '/app/models/' . $name . '.php');
				self::$models[$model] = new $model;
			}
			
			return self::$models[$model];				
		}
		
		public function __get_view($path, $name = NULL, $shortcode = NULL) {
			if(is_null($name) || is_null($shortcode)){
				$view_name = get_called_class();
				// Get shortcode 
				preg_match('/.*?(?=_)/', $view_name, $matches);
				$shortcode = $matches[0];
				// Get name
				preg_match('/(?<=_).*(?=_controller)/', $view_name, $matches);
				$name = $matches[0];
			}
			
			$view = $shortcode . '_' . $name . '_view';
			if( ! isset( self::$views[$view]) ) {
				require_once( $path . '/app/views/' . $name . '.php');
				self::$views[$view] = new $view;
			}
			
			return self::$views[$view];				
		}
		
		public function __get_helper($path, $name) {
			
			$helper =  $name . '_helper';
			if( ! isset( self::$helpers[$helper]) ) {
				require_once( $path . '/app/helpers/' . $name . '.php');
				self::$helpers[$helper] = new $helper;
			}
			
			return self::$helpers[$helper];				
		}
		
		public function __process_ajax_request($nonce, $model_name, $function_name){
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