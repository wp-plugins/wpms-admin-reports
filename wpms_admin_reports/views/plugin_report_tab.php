<?php
if( !class_exists( 'wpmsar_plugin_report_tab_view' ) ):

	class wpmsar_plugin_report_tab_view{
		
		public function display(){?>
			<style>.tab-about li { list-style: none; }</style>
			<h1>WordPress Multisite Admin Reports</h1>
			<h2>User Report Help</h2>
			<p>The plugin report is a sortable snapshot of all of your plugins.  To updated the information in this report please click the update button.  This process can take a significant amount of time which is why we do not update the data every time you visit the page.  The "Status" column indicates the standing of the plugin based on the criteria set for checking the plugin's legitimacy listed below.  </p>
            <ul><ul class="tab-about">
				<li><span class="icon-happy"> - <?php _e( 'Diligent', 'wpms_admin_tools'); ?>:</span>
					<ul>
						<li>Indicates that this plugin is diligently updated.</li>
						<li>This plugin is easily identified on the WordPress Plugin Directory (WPPD) by its slug.</li>	
						<li>This plugin has been updated within the last 2 years.</li>						
					</ul>
				</li>
				<li><span class="icon-smiley"> - <?php _e( 'Questionable', 'wpms_admin_tools'); ?>:</span>
					<ul>
						<li>Indicates that we could not find the plugin on the WPPD by its slug.</li>
						<li>We were able to find the Developers site intact.</li>	
						<li>Good plugin developers know to use the same slug name for their main php file as the one they have in the WWPPD</li>
					</ul>
				</li>
				<li><span class="icon-sad"> - <?php _e( 'Outdated', 'wpms_admin_tools'); ?>:</span>
					<ul>
						<li>Indicates that could not find the plugin on the WPPD by its slug.</li>
						<li>We were able to find the Developers site however it was recently moved.</li>	
						<li>It might be prudent to update if possible or at least follow up.</li>						
					</ul>
				</li>
				<li><span class="icon-angry"> - <?php _e( 'Derelict', 'wpms_admin_tools'); ?>:</span>
					<ul>
						<li>Indicates that could not find the plugin on the WPPD by its slug.</li>
						<li>When we tried to load the developers site it either timed out or returned a 404.</li>	
						<li>It is strongly recommended that your remove or replace this plugin.</li>						
					</ul>
				</li>
			</ul>
        <?php }
	}
endif;