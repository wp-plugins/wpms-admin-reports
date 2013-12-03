<?php
if( !class_exists( 'wpmsar_dashboard_view' ) ):

	class wpmsar_dashboard_view{
		
		public function display(){
			$data = get_site_option('wpmsar_dashboard_cache');
			?>
            <style>
			.legend {
				width: 10em;
				border: 1px solid black;
			}
			
			.legend .title {
				display: block;
				margin: 0.5em;
				border-style: solid;
				border-width: 0 0 0 1em;
				padding: 0 0.3em;
			}
			.chart-area{
				margin-left:20px;
				float:left;
			}
			#charts{
				width:700px;
			}
			.row{
				height:500px;
			}
			</style>
			<div class="wrap" id="charts">
            	<?php screen_icon('index');?>
                <h2><?php _e('Dashboard');?></h2>
                <?php if($data != 0): ?>
                <div>
                	<h3>Overall Health</h3>
                    <?php
					if(!isset($data['sites_up']) || !isset($data['sites_down']) || !isset($data['sites_count']) ||
						!isset($data['plugins_never_used']) || !isset($data['plugins_upgradable']) || 
						!isset($data['plugins_count']) || !isset($data['unassigned_users']) || !isset($data['count_users']) ||
						!isset($data['sites_no_users']) || !isset($data['sites_count']) ):
					?>
                    	<p>Necessary data unavailable.  Please make sure all reports have been visited and updated.</p>
                    <?php endif; ?>
                    <canvas id="overall-health-chart-block" height="600" width="600"></canvas>
                </div>
                <div class="row">
                    <div class="chart-area">
                        <h3>Users - Status</h3>
                    <?php
					if( !isset($data['users_login_worst']) || !isset($data['users_login_bad']) || 
						!isset($data['users_login_good']) || !isset($data['users_login_best']) ):
					?>
                    	<p>Necessary data unavailable.  Please visit and update user report.</p>
                    <?php endif; ?>
                        <canvas id="user-status-chart-block" height="300" width="300"></canvas>
                        <div id="user-status-ledgend"></div>
                    </div>
                    <div class="chart-area">
                        <h3>Sites - Last Updated</h3>
                    <?php
					if( !isset($data['last_updated_worst']) || !isset($data['last_updated_bad']) || 
						!isset($data['last_updated_good']) || !isset($data['last_updated_best']) ):
					?>
                    	<p>Necessary data unavailable.  Please visit site report.</p>
                    <?php endif; ?>
                        <canvas id="last-updated-chart-block" height="300" width="300"></canvas>
                        <div id="last-updated-ledgend"></div>
                    </div>
	            </div>
                <div class="row">
                    <div class="chart-area">
                        <h3>Sites - Last Post</h3>
                    <?php
					if( !isset($data['last_post_worst']) || !isset($data['last_post_bad']) || 
						!isset($data['last_post_good']) || !isset($data['last_post_best']) ):
					?>
                    	<p>Necessary data unavailable.  Please visit site report.</p>
                    <?php endif; ?>
                        <canvas id="last-post-chart-block" height="300" width="300"></canvas>
                        <div id="last-post-ledgend"></div>
                    </div>
                    <div class="chart-area">
                        <h3>Plugins - Status</h3>
                    <?php
					if( !isset($data['plugins_derelict']) || !isset($data['plugins_outdated']) || 
						!isset($data['plugins_questionable']) || !isset($data['plugins_diligent']) || 
						$data['plugins_derelict'] == 0 && $data['plugins_outdated'] == 0 && 
						$data['plugins_questionable'] == 0 && $data['plugins_diligent'] == 0 ):
					?>
                    	<p>Necessary data unavailable.  Please visit and update plugin report.</p>
                    <?php endif; ?>
                        <canvas id="plugin-status-chart-block" height="300" width="300"></canvas>
                        <div id="plugin-status-ledgend"></div>
                    </div>
                </div>
            </div>
            
            <script>
				var chartOptions = {animationEasing : "easeOutQuart"};
			<?php
			if(isset($data['sites_up']) && isset($data['sites_down']) && isset($data['sites_count']) &&
				isset($data['plugins_never_used']) && isset($data['plugins_upgradable']) && 
				isset($data['plugins_count']) && isset($data['unassigned_users']) && isset($data['count_users']) &&
				isset($data['sites_no_users']) && isset($data['sites_count']) ):
			?>
				
			
				var sites_up, sites_down, plugins_used, plugins_unused, plugins_upgradable, plugins_upgraded, 
					users_unassigned, users_assigned, sites_no_users, sites_with_users;
					
					sites_up = <?php echo $data['sites_up'];?> / <?php echo $data['sites_count'];?> * 100;
					sites_down = <?php echo $data['sites_down'];?> / <?php echo $data['sites_count'];?> * 100;
					plugins_unused = <?php echo $data['plugins_never_used'];?>/ <?php echo $data['plugins_count'];?> * 100;
					plugins_used = 100 - plugins_unused;
					plugins_upgradable = <?php echo $data['plugins_upgradable'];?>/ <?php echo $data['plugins_count'];?> * 100;
					plugins_upgraded = 100 - plugins_upgradable;
					users_unassigned = <?php echo $data['unassigned_users'];?>/ <?php echo $data['count_users'];?> * 100;
					users_assigned = 100 - users_unassigned;
					sites_no_users = <?php echo $data['sites_no_users'];?>/ <?php echo $data['sites_count'];?> * 100;
					sites_with_users = 100 - sites_no_users;
					
				var overallHealthData = {
					labels : ["Site Up/Down", "Plugin Usage", "Upgradeable PLugins",
					 "Unassigned Users", "Sites with Users"],
					datasets : [
						{
							fillColor : "rgba(192,57,43,0.5)",
							strokeColor : "rgba(192,57,43,1)",
							data : [sites_down, plugins_unused, plugins_upgradable, users_unassigned, sites_no_users]
						},
						{
							fillColor : "rgba(46,204,113,0.5)",
							strokeColor : "rgba(46,204,113,1)",
							data : [sites_up, plugins_used, plugins_upgraded, users_assigned, sites_with_users]
						}
					]
				}
				var radarOptions = {
					scaleOverride : true,
					scaleSteps : 10,
					scaleStepWidth : 10,
					scaleStartValue : 0
				};
				var ohcb = document.getElementById("overall-health-chart-block").getContext("2d");
				var ohBar = new Chart(ohcb).Radar(overallHealthData, radarOptions);
			<?php endif; 
			if(isset($data['users_login_worst']) && isset($data['users_login_bad']) && 
				isset($data['users_login_good']) && isset($data['users_login_best']) ):
			?>
				var userStatusData = [
					{
						value: <?php echo $data['users_login_worst']; ?>,
						color: "rgba(192,57,43,1)",
						title: "Over a Year"
					},
					{
						value : <?php echo $data['users_login_bad']; ?>,
						color : "rgba(230,126,34,1)",
						title : "Over 8 Months or Unkown"
					},
					{
						value : <?php echo $data['users_login_good']; ?>,
						color : "rgba(241,196,15,1)",
						title : "Over 4 Months" 
					},
					{
						value : <?php echo $data['users_login_best']; ?>,
						color : "rgba(46,204,113,1)",
						title : "Under 4 Months" 
					}
				];
				var uscb = document.getElementById("user-status-chart-block").getContext("2d");
				var chartOptions = {animationEasing : "easeOutQuart"};
				var usPie = new Chart(uscb).Pie(userStatusData, chartOptions);
				legend(document.getElementById("user-status-ledgend"), userStatusData);
			<?php endif; 
			if(isset($data['last_updated_worst']) && isset($data['last_updated_bad']) && 
				isset($data['last_updated_good']) && isset($data['last_updated_best']) ):
			?>
				var lastUpdatedData = [
					{
						value: <?php echo $data['last_updated_worst']; ?>,
						color: "rgba(192,57,43,1)",
						title: "Over a Year"
					},
					{
						value : <?php echo $data['last_updated_bad']; ?>,
						color : "rgba(230,126,34,1)",
						title : "Over 8 Months"
					},
					{
						value : <?php echo $data['last_updated_good']; ?>,
						color : "rgba(241,196,15,1)",
						title : "Over 4 Months" 
					},
					{
						value : <?php echo $data['last_updated_best']; ?>,
						color : "rgba(46,204,113,1)",
						title : "Within 4 Months" 
					}
				];
				var lucb = document.getElementById("last-updated-chart-block").getContext("2d");
				var luPie = new Chart(lucb).Pie(lastUpdatedData, chartOptions);
				legend(document.getElementById("last-updated-ledgend"), lastUpdatedData);
			<?php endif; 
			if(isset($data['last_post_worst']) && isset($data['last_post_bad']) && 
				isset($data['last_post_good']) && isset($data['last_post_best']) ):
			?>
				var lastPostData = [
					{
						value: <?php echo $data['last_post_worst']; ?>,
						color: "rgba(192,57,43,1)",
						title: "Over a Year or No Posts"
					},
					{
						value : <?php echo $data['last_post_bad']; ?>,
						color : "rgba(230,126,34,1)",
						title : "Over 8 Months"
					},
					{
						value : <?php echo $data['last_post_good']; ?>,
						color : "rgba(241,196,15,1)",
						title : "Over 4 Months" 
					},
					{
						value : <?php echo $data['last_post_best']; ?>,
						color : "rgba(46,204,113,1)",
						title : "Within 4 Months" 
					}
				];
				
				var lpcb = document.getElementById("last-post-chart-block").getContext("2d");
				var lpPie = new Chart(lpcb).Pie(lastPostData, chartOptions);
				legend(document.getElementById("last-post-ledgend"), lastPostData);
			<?php endif; 
			if(isset($data['plugins_derelict']) && isset($data['plugins_outdated']) && 
				isset($data['plugins_questionable']) && isset($data['plugins_diligent']) ):
			?>
				var pluginStatusData = [
					{
						value: <?php echo $data['plugins_derelict']; ?>,
						color: "rgba(192,57,43,1)",
						title: "Derelict"
					},
					{
						value : <?php echo $data['plugins_outdated']; ?>,
						color : "rgba(230,126,34,1)",
						title : "Outdated"
					},
					{
						value : <?php echo $data['plugins_questionable']; ?>,
						color : "rgba(241,196,15,1)",
						title : "Questionable" 
					},
					{
						value : <?php echo $data['plugins_diligent']; ?>,
						color : "rgba(46,204,113,1)",
						title : "Diligent" 
					}
				];
				var pscb = document.getElementById("plugin-status-chart-block").getContext("2d");
				var psPie = new Chart(pscb).Pie(pluginStatusData, chartOptions);
				legend(document.getElementById("plugin-status-ledgend"), pluginStatusData);
			<?php endif; ?>
			</script>
		<?php 
		else:?>
        	<h3>There is no data to display.</h3>
        	<p>Please visit each of the reports and updated them in order to populate the dashboard with data.</p>
		<?php
		endif;
		}
	}
endif;