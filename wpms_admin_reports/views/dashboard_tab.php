<?php
if( !class_exists( 'wpmsar_dashboard_tab_view' ) ):

	class wpmsar_dashboard_tab_view{
		
		public function display(){?>
			<style>.tab-about li { list-style: none; }</style>
			<h1>WordPress Multisite Admin Reports</h1>
			<h2>Dashboard Help</h2>
			<h4>"Whooptydoo. But what does it all mean Basil?"</h4>
            <p>Pretty fancy graphs there but some context might help, right?  Think of this as an overall summary page.</p>
			<ul class="tab-about">
				<li><h3>Overall Health:</h3>
					<p>The overall health measures five factors and displays a percentage of green or red indicating how healthy your site is in that factor.  For example: if you have 120 sites and 12 were down (after the last check) the green potion would be at 90% and the red would be at 10%.</p>
                    <ul>
                        <li><b>Site Up/Down</b> - indicates how many sites are loading correctly versus how many are not.</li>
                        <li><b>Plugin Usage</b> - indicates how many of the installed plugins are actually being used.</li>
                        <li><b>Upgradeable Plugins</b> - indicates how many plugins should be upgraded (red means upgrade).</li>
                        <li><b>Unassigned Users</b> - indicates how many users exists in the user table that are not assigned to any sites.</li>
                        <li><b>Sites with Users</b> - indicates how many sites actually have users assigned to them.</li>
                    </ul>
                 </li>
                 <li><h3>User - Status</h3>
                 	<p>This chart shows when all of your users have logged in within the given time frames. Since WordPress does not inherently record this information it will not start recording until after this plugin is installed.</p>
                 </li>
                 <li><h3>Site - Last Updated</h3>
                 	<p>This chart shows when all of your sites were last updated within the given time frames.  A site is considered "updated" when a user logs in and changes anything.</p>
                 </li>
                 <li><h3>Site - Last Post</h3>
                 	<p>This chart shows when all of your sites were last posted to within the given time frames.  Posts compared to "last updated" can give you a better indicated on how much new content the site administrator is actually contributing to the site. </p>
                 </li>
                 <li><h3>Plugins - Status</h3>
                 	<p>This chart shows where all of your plugins stand as far as how well kept they are.  For more information about how plugin status is determined please reference the Plugin Report help tab.</p>
                 </li>
			</ul>
		<?php }
	}
endif;