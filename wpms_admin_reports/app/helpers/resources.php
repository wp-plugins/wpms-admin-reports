<?php
if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );

if( !class_exists( 'resources_helper' ) ):

	class resources_helper {
		
		public function load_scripts($hook) {
		    //echo $hook . "<br/>";//To get the string for the condition below
			preg_match("/(?<=wpmsar_).*$/", $hook, $matches);
			//echo $matches[0];
			
			if ($hook == 'admin-reports_page_wpmsar_site_report' ||
				$hook == 'admin-reports_page_wpmsar_plugin_report' ||
				$hook == 'admin-reports_page_wpmsar_user_report') {
				wp_register_script(
					'tablesorter', 
					WPMSAR_PLUGIN_URL . '/assets/js/jquery.tablesorter.min.js', 
					array('jquery'), 
					'2.14.0'
				);
				
				wp_register_script(
					'tablesorterPager', 
					WPMSAR_PLUGIN_URL . '/assets/js/jquery.tablesorter.pager.js', 
					array(), 
					'2.14.0'
				);
				
				wp_register_script(
					'commonJS', 
					WPMSAR_PLUGIN_URL . '/assets/js/common.js', 
					array('jquery'), 
					'1.2.3'
				);
				
				if($hook != 'admin-reports_page_wpmsar_user_report'){
					wp_register_script( 
						$matches[0].'JS', 
						WPMSAR_PLUGIN_URL . '/assets/js/' . $matches[0] . '.js', 
						array(
							'jquery',
							'jquery-ui-button', 
							'jquery-ui-progressbar'
						), 
						'0.5', 
						true 
					);
					wp_enqueue_script( $matches[0] . 'JS' );
				}
				
				wp_register_style(
					'jQueryUIStyle', 
					WPMSAR_PLUGIN_URL . '/assets/css/start/jquery-ui-1.10.3.custom.min.css', 
					'1.10.3'
				);
				
				wp_register_style(
					'commonCSS', 
					WPMSAR_PLUGIN_URL . '/assets/css/common.css', 
					'0.5'
				);
				
				wp_register_style(
					$matches[0].'CSS', 
					WPMSAR_PLUGIN_URL . '/assets/css/' . $matches[0] . '.css', 
					'0.5'
				);
				
				wp_enqueue_script( 'tablesorter' );
				wp_enqueue_script( 'tablesorterPager' );
				wp_enqueue_script( 'commonJS' );
				wp_enqueue_style(  'jQueryUIStyle' );
				wp_enqueue_style(  'commonCSS' );
				wp_enqueue_style(  $matches[0] . 'CSS' );
			}
			
			if ($hook == 'toplevel_page_wpms_admin_reports'){
				wp_register_script(
					'charting', 
					WPMSAR_PLUGIN_URL . '/assets/js/Chart.min.js',
					array(
						'jquery'
					)
				);
				
				wp_register_script(
					'legend', 
					WPMSAR_PLUGIN_URL . '/assets/js/legend.js'
				);
				
				wp_enqueue_script( 'charting' );
				wp_enqueue_script( 'legend' );
			}

			if($hook == 'users.php'){
				wp_register_script(
					'hideRowJS', 
					WPMSAR_PLUGIN_URL . '/assets/js/hide-row.js', 
					array('jquery'), 
					'1.2.3'
				);

				wp_enqueue_script( 'hideRowJS' );
			}
		}
	}
endif;