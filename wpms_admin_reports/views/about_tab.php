<?php
if( !class_exists( 'wpmsar_about_tab_view' ) ):

	class wpmsar_about_tab_view{
		
		public function display(){?>
			<style>.tab-about li { list-style: none; }</style>
			<h1>WordPress Multisite Admin Reports</h1>
			<h2>Version: 1.0</h2>
			<p>
				<a href="http://wordpress.org/extend/plugins/wpms_admin_reports/" target="_blank">WordPress.org</a> | 
				<a href="https://github.com/cleanshooter/wpms_admin_reports" target="_blank">GitHub Repository</a> | 
				<a href="https://github.com/cleanshooter/wpms_admin_reports/issues" target="_blank">Issue Tracker</a>
			</p>
			<ul class="tab-about">
				<li><b>Development:</b>
					<ul>
                    	<li>
                        	<h3>Joe Motacek</h3>
                        	<p>This plugin was orginally inspired by Plugin Stats.  I find that as an administrator I needed more information out of WordPress than the standard pages provided.  So I decided to create more robust reporting tool.  This is the first version so if there are any bugs or issues please report them on GitHub.  Also if there are any features you want me to add let me know.  I have only tested this on 3.7.x I am unsure if it works on earlier versions, more people testing would be much appreciated.</p>
                        </li>
                        <li><h3>Future Features</h3>
                        	<ul>
                            	<li>Comments Report</li>
                                <li>Archive and Delete Actions</li>
                                <li>Options/Configuration/Settings Page</li>
                            </ul>
                        </li>
                        <li>
                        	<h3>Credits, Thanks & Inspiration</h3>
                        	<h4>Plugin Stats (Original Version)</h4>
                        	<ul>
                            	<li>Kevin Graeme | <a href="http://profiles.wordpress.org/kgraeme/" target="_blank">kgraeme@WP.org</a></li>
								<li><a href="http://deannaschneider.wordpress.com/" target="_blank">Deanna Schneider</a> | <a href="http://profiles.wordpress.org/deannas/" target="_blank">deannas@WP.org</a></li>
								<li><a href="http://www.jasonlemahieu.com/" target="_blank">Jason Lemahieu</a> | <a href="http://profiles.wordpress.org/MadtownLems/" target="_blank">MadtownLems@WP.org</a></li>
                            </ul>
                            <h4><a href="http://icomoon.io/">IcoMoon</a> - for making great icons.</h4>
                            <h4><a href="http://www.chartjs.org/">Chart.js</a> - for making beautiful charts.</h4>
                            <h4><a href="http://tablesorter.com/docs/">tablesorter</a> - for removing the need to refresh for table pagination.</h4>
                            <h4><a href="http://jquery.com/">jQuery</a> - for being awsome.</h4>
                            <h4>Wordpress Last Login</h4>
                        </li>
                    </ul>
				</li>
				<li><b>WordPress Requirments:</b>
					<ul>
						<li><?php printf( __( 'Requires at least: %s'), '???'); ?></li>
						<li><?php printf( __( 'Tested up to: %s'), '3.7.1'); ?></li>
					</ul>
				</li>
				<!--<li><b>Languages:</b>
					<ul>
						<li>English (development)</li>
						<li><?php printf( __( 'Help to translate at %s'), '<a href="https://www.joemotacek.com/wpms_admin_tools" target="_blank">Translate > WPMS Admin Tools</a>'); ?></li>
					</ul>
				</li>-->
				<li><b>License:</b>
                <ul>
                    <li>
                        <p>GPL2</p>
                    </li>
                    <li>
                        <p>Copyright &copy; 2013 Joe Motacek </p>
                    </li>
                </ul>
                </li>
			</ul>
            
            
		<?php }
	}
endif;