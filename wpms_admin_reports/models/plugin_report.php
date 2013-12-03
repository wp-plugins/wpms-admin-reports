<?php
if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );

if( !class_exists( 'wpmsar_plugin_report_model' ) ):

	class wpmsar_plugin_report_model {		
		
		public 	$plugin_list;
		
		public function __construct() {
			$plugins = get_plugins();
			$this->plugin_list = array();
			
			foreach($plugins as $file => $data){
				array_push($this->plugin_list, $data['Name']);
			}
		}
		
		public function get_data(){
			$data = array();
			
			if( !get_site_option('wpmsar_plugin_report_data_freshness') ||
				!get_site_option('wpmsar_plugin_report_data') ||
				!get_site_option('wpmsar_plugin_derelict_data') ){
				//fist run... build simple list
				$resutls = $this->update_plugin_list();	
			}
			// Get the time when the plugin list was last generated
			$data['gen_time'] = get_site_option('wpmsar_plugin_report_data_freshness');
			// Stats Data
			$data['stats_data'] = get_site_option('wpmsar_plugin_report_data');
			ksort($data['stats_data']);
			// Derelict Data	
			$data['derelict_data'] = get_site_option('wpmsar_plugin_derelict_data');
			if(!$data['derelict_data']){$data['derelict_data'] = array();}
			
			// if you're using plugin commander, these two values will be populated
			$data['auto_activate'] = explode(',',get_site_option('pc_auto_activate_list'));
			$data['user_control'] = explode(',',get_site_option('pc_user_control_list'));
			// if you're using plugin manager, these values will be populated
			$pm_auto_activate = explode(',',get_site_option('mp_pm_auto_activate_list'));
			$pm_user_control = explode(',',get_site_option('mp_pm_user_control_list'));
			$pm_supporter_control = explode(',',get_site_option('mp_pm_supporter_control_list'));
			$data['pm_auto_activate_status'] = ($pm_auto_activate[0] == '' || $pm_auto_active[0] == 'EMPTY' ? 0 : 1);
			$data['pm_user_control_status'] = ($pm_user_control[0] == '' || $pm_user_control == 'EMPTY' ? 0 : 1);
			$data['pm_supporter_control_status'] = ($pm_supporter_control[0] == '' || $pm_supporter_control == 'EMPTY' ? 0 : 1);
			
			// Upgradable
			$site_transient_update_plugins = get_site_option('_site_transient_update_plugins');
			$data['upgradeable'] = maybe_unserialize($site_transient_update_plugins->response);

			// this is the built-in sitewide activation
			$data['active_sitewide_plugins'] = maybe_unserialize( get_site_option( 'active_sitewide_plugins') );
			
			$this->update_dashboard_cache($data);
			
			return $data;
		}
		
		private function update_dashboard_cache($data){
			$cache_data = get_site_option('wpmsar_dashboard_cache');
			
			if(!isset($cache_data) ){
				$cache_data = array();
			}
			$names = array("plugins_derelict", "plugins_outdated", "plugins_questionable", "plugins_diligent",
				"plugins_never_used", "plugins_upgradable", "plugins_count");
			
			foreach($names as $name){
				$cache_data[$name] = 0;
			}
			
			foreach($data['derelict_data'] as $plugin => $status){
				if($status == "0"){
					$cache_data['plugins_derelict']++;
				}elseif($status == "1"){
					$cache_data['plugins_outdated']++;
				}
				elseif($status ==  "2"){
					$cache_data['plugins_questionable']++;
				}else{
					$cache_data['plugins_diligent']++;
				}
			}
			foreach ($data['stats_data'] as $file => $info) {
				if (isset($info['blogs'])) {
					$numBlogs = sizeOf($info['blogs']);
				}else{
					$numBlogs = 0;
				}
				
				if((int)$numBlogs == 0){
					$cache_data['plugins_never_used']++;
				}
				
				if (is_array($data['upgradeable']) && array_key_exists($file, $data['upgradeable'])) {
					$cache_data['plugins_upgradable']++;
				}
			}
			$cache_data['plugins_count'] = count($data['stats_data']);
			
			update_site_option('wpmsar_dashboard_cache', $cache_data);
		}
		
		public function update_plugin_list($plugin_list = null) {
			global $wpdb, $current_site;
			
			$plugins = get_plugins();
			
			$blogs = $wpdb->get_results("SELECT blog_id, domain, path FROM " . 
				$wpdb->blogs . 
				" WHERE site_id = {$current_site->id} ORDER BY domain ASC");
			$blogplugins = array();
			$processedplugins = array();

			if ($blogs) {
				foreach ($blogs as $blog) {
					switch_to_blog($blog->blog_id);

					if( constant( 'VHOST' ) == 'yes' ) {
						$blogurl = $blog->domain;			
					} else {
						$blogurl =  trailingslashit( $blog->domain . $blog->path );
					}

					$blog_info = array('name' => get_bloginfo('name'), 'url' => $blogurl);
					$active_plugins = get_option('active_plugins');

					if (sizeOf($active_plugins) > 0) {
						foreach ($active_plugins as $plugin) {

							if (isset($plugins[$plugin])) {
								$this_plugin = $plugins[$plugin];
								if (isset($this_plugin['blogs']) && is_array($this_plugin['blogs'])) {
									array_push($this_plugin['blogs'], $blog_info);
								} else {
									$this_plugin['blogs'] = array();
									array_push($this_plugin['blogs'], $blog_info);
								}
								unset($plugins[$plugin]);
								$plugins[$plugin] = $this_plugin;
							} else {
								
							}
						}
					}

					restore_current_blog();
				}
			}

			update_site_option('wpmsar_plugin_report_data', $plugins);
			
			return "Plugin list updated...";
		}
		
		public function derelict_check( $plugin ) {
			ini_set('default_socket_timeout', 10); 
			
			$plugins = get_plugins();
			
			foreach($plugins as $file => $data){
				if($plugin['plugin_name'] == $data['Name']){
					$plugin_file = $file;
					$plugin_URI = $data['PluginURI'];
				}
			}
			
			if(isset($plugin_file) ){
				
				preg_match("/(?<=\/).*[a-zA-Z0-9-](?=.php)/", $plugin_file, $slug);
				$plugin_wp_page = @file_get_contents('http://www.wordpress.org/plugins/' . $slug[0] . "/");
							
				if($plugin_wp_page !== false){
					preg_match('/(?<=<meta itemprop="dateModified" content=").*[0-9-](?=")/', $plugin_wp_page ,$date_string);
	
					$plugin_date = strtotime($date_string[0]);
					$two_years = strtotime ( '-2 year' , strtotime( date("Y-m-d") ) ) ;
						
					$status = ($plugin_date < $two_years ? "0" : "3");
				}
	
				else{
					$plugin_author_page = @get_headers($plugin_URI);
					if($plugin_author_page !== false){
						if($plugin_author_page[0] == 'HTTP/1.1 404 Not Found') {
							$status = "0";
						}
						elseif($plugin_author_page[0] == 'HTTP/1.1 301 Moved Permanently'){
							$status = "1";
						}
						else{
							$status = "2";
						}
					}else{
						$status = "0";
					}
				}	
								
				$message = 'Plugin: ' . $plugin['plugin_name'] . ' updated...';
				$result = array('message' => $message, 'file' => $plugin_file, 'status' => $status);
			}else{
				$message = 'Plugin: ' . $plugin_name['plugin_name'] . ' not found...';
				$result = array('message' => $message, 'file' => $plugin_name, 'status' => '0');
			}
			
			return $result;
		}
		
		public function update_derelict_status( $data ) {
			
			update_site_option('wpmsar_plugin_derelict_data', $data);
			update_site_option('wpmsar_plugin_report_data_freshness', time());
			
			return 'All plugin data updated. Refreshing Page....';
		}
		
	}
endif;