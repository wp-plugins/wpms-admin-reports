<?php
if( !class_exists( 'wpmsar_user_report_tab_view' ) ):

	class wpmsar_user_report_tab_view{
		
		public function display(){?>
			<style>.tab-about li { list-style: none; }</style>
			<h1>WordPress Multisite Admin Reports</h1>
			<h2>User Report Help</h2>
			<p>The user report is a sortable snapshot of all of your users.  The really important information you want to see on your users is now all in one place.  When they last logged in, where they logged in from, when they were registered, how many sites they are listed as a user on and what their primary role on that site is.  This report is especially helpful if you have to conduct annual audits to remove old users.</p>
            <ul>
                <li><h3>Last Login</h3>
                	<p>The status icons are a quick way to see which users might need be removed or emailed a reminder to login and check their site.</p>	
                    <ul>
                    	<li><span class="icon-happy"></span> - the user has logged in within the last 4 months.</li>
                        <li><span class="icon-smiley"></span> - the user logged in between 4 and 8 months ago.</li>
                        <li><span class="icon-sad"></span> - the user logged in between 8 and 12 months ago or has not logged in since this plugin was installed (Unknown).</li>
                        <li><span class="icon-angry"></span> - the user has not logged in in over a year.</li>
                    </ul>
                </li>
			</ul>
		<?php }
	}
endif;