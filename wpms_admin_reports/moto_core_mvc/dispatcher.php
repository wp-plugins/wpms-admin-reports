<?php
/**
 * Framework Name: Moto Core MVC
 * Plugin URI: http://addlater
 * Description: This frameworks contains the core functions needed for basic MVC operations within the WP codebase.  This is not strict MVC, just what makes sense within the WordPress framework. 
 * Version: 0.2
 * Author: Joe Motacek
 * Author URI: http://www.joemotacek.com
 * License: GPL2
 * 
 * @package moto_core
 * @since 0.2
 *
 * Moto Core Dispatcher
 * Purpose:
 *  - holds instances controllers controllers
 */

if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );

if ( ! class_exists( 'mcmvc_dispatcher' ) ):

	abstract class mcmvc_dispatcher {
		private static $controllers = array();
		
		public static function __get_controller($name) {
			$controller = MCMVC_SHORT_CODE . '_' . $name . '_controller';
			if( ! isset( self::$controllers[$controller]) ) {
				require_once( MCMVC_PLUGIN_DIR . '/controllers/' . $name . '.php');
				self::$controllers[$controller] = new $controller;
			}
			
			return self::$controllers[$controller];				
		}
	}
endif;