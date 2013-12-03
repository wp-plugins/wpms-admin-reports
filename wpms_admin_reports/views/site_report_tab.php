<?php
if( !class_exists( 'wpmsar_site_report_tab_view' ) ):

	class wpmsar_site_report_tab_view{
		
		public function display(){?>
			<style>.tab-about li { list-style: none; }</style>
			<h1>WordPress Multisite Admin Reports</h1>
			<h2>Site Report Help</h2>
			<p>The site report is a sortable snapshot of all of your sites.  From this page you can also jump to some common admin task for each site such as; editing the basic info, visiting the dashboard, visiting the site, managing the template or emailing the administrator.</p>
            <ul>
            	<li><h3>Updating the Status</h3>
                	<p>By clicking the "Update" button the report will run a script that goes out to each of your sites and checks if they are loading correctly.  If you are working on debugging your sites this will save you the time of going to each page manually.  Personally, I put my development server in debug mode (in the wp-config file) and then run the check because it will point me to all the sites that are reporting errors.</p>
                </li>
                <li><h3>Last Post and Updated</h3>
                	<p>The status icons are a quick way to see which sites might need closer attention or an email to the administrator.</p>	
                    <ul>
                    	<li><span class="icon-happy"></span> - the site has been updated with in the last 4 months.</li>
                        <li><span class="icon-smiley"></span> - the site was updated between 4 and 8 months ago.</li>
                        <li><span class="icon-sad"></span> - the site was updated between 8 and 12 months ago.</li>
                        <li><span class="icon-angry"></span> - the site was last updated over a year ago.</li>
                    </ul>
                </li>
			</ul>
		<?php }
	}
endif;