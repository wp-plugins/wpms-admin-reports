<?php
if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );

if( !class_exists( 'wpmsar_plugin_report_view' ) ):

	class wpmsar_plugin_report_view {
		
		public function display($data){?>
			
			<div class="wrap">
				<?php screen_icon( 'plugins' ); ?>
				<h2><?php _e( 'Plugin Report'); ?></h2>
				<div class="tablenav">
                    <div class="pager tablenav-pages">
                        <span class="displaying-num"><?php echo count($data['stats_data']);?> plugins</span>
                        <span class="pagination-links">
                            <a class="first-page" title="Go to the first page" href="#">«</a>
                            <a class="prev-page" title="Go to the previous page" href="#">‹</a>
                            <span class="pagedisplay"></span>
                            <a class="next-page" title="Go to the next page" href="#">›</a>
                            <a class="last-page" title="Go to the last page" href="#">»</a>
                        </span>
                        <select class="pagesize" title="Select page size"> 
                            <option value="10">10</option> 
                            <option selected="selected" value="20">20</option> 
                            <option value="30">30</option> 
                            <option value="40">40</option> 
                        </select>
                    </div>
                </div>
				<table class="widefat" id="wpmsar_report_table">
					<thead>
						<?php if ( sizeOf($data['auto_activate']) > 1 || sizeOf($data['user_control']) > 1 || $data['pm_auto_activate_status'] == 1 || $data['pm_user_control_status'] == 1 || $data['pm_supporter_control_status'] == 1 ) { ?>
						<tr>
							<th style="width: 25%;" >&nbsp;</th>
							<?php if (sizeOf($data['auto_activate']) > 1 || sizeOf($data['user_control']) > 1){ ?>
								<th colspan="2" class="pc_settings_heading"><?php printf( '%s %s', _e( 'Plugin Commander' ), _e( 'Settings')); ?></th>
							<?php }
							if ($data['pm_auto_activate_status'] == 1 || $data['pm_user_control_status'] == 1|| $data['pm_supporter_control_status'] == 1) { ?>
								<th colspan="3" align="center" class="pc_settings_heading"><?php printf( '%s %s', _e( 'Plugin Manager'), _e( 'Settings')); ?></th>
							<?php } ?>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
							<th style="width: 20%;">&nbsp;</th>
						</tr>
						<?php } ?>
						<tr>
								<th class="nocase"><?php _e( 'Plugin' ); ?></th>

								<?php if (sizeOf($data['auto_activate']) > 1 || sizeOf($data['user_control']) > 1){
								?>
								<th class="nocase pc_settings_left"><?php _e( 'Auto Activate' ); ?></th>
								<th class="nocase pc_settings_right"><?php _e( 'User Controlled' ); ?></th>
								<?php	
								}
								if ($data['pm_auto_activate_status'] == 1 || $data['pm_user_control_status'] == 1|| $data['pm_supporter_control_status'] == 1){
								?>
								<th class="pc_settings_left"><?php _e( 'Auto Activate'); ?></th>
								<th><?php _e( 'User Controlled' ); ?></th>
								<th class="pc_settings_right"><?php _e( 'Supporter Controlled' ); ?></th>
								<?php	
								}?>
								<th><?php _e( 'Ugradeable'); ?></th>
								<th><?php _e( 'Status'); ?></th>
								<th><?php _e( 'Activated Sitewide'); ?></th>
								<th><?php _e( 'Total Blogs'); ?></th>
								<th width="200px"><?php _e( 'Blog Titles'); ?></th>

						</tr>
					</thead>
					<tbody id="plugins">
						<?php
						$counter = 0;
						foreach ($data['stats_data'] as $file => $info) {
							$counter = $counter + 1;

							echo('<tr valign="top"><td>');

							//jason checking for non-existant plugins
							if (isset($info['Name'])) {
								if (strlen($info['Name'])) {
									$thisName = $info['Name'];
								} else {
									$thisName = $file;
								}
							} else {
								$thisName = $file . " <span class='plugin-not-found'>(" . __( 'Plugin File Not Found!') . ")</span>";
							}

							echo ($thisName . '</td>');
							// plugin commander columns	
							if (sizeOf($data['auto_activate']) > 1 || sizeOf($data['user_control']) > 1) {
								echo ('<td align="center" class="pc_settings_left">');
								if (in_array($file, $data['auto_activate'])) { 
									_e( 'Yes');
								}
								else {
									_e( 'No');
								}
								echo('</td><td align="center" class="pc_settings_right">');
								if (in_array($file, $data['user_control'])) {
									_e( 'Yes');
								}
								else {
									_e( 'No');
								}
								echo("</td>");
							}
							// plugin manager columns
							if ($data['pm_auto_activate_status'] == 1 || $data['pm_user_control_status'] == 1 || $data['pm_supporter_control_status'] == 1) {
								echo ('<td align="center" class="pc_settings_left">');
								if (in_array($file, $data['pm_auto_activate'])) {
									_e( 'Yes');
								}
								else {
									_e( 'No');
								}
								echo('</td><td align="center">');
								if (in_array($file, $data['pm_user_control'])) {
									_e( 'Yes');
								}
								else {
									_e( 'No');
								}
								echo('</td><td align="center" class="pc_settings_right">');
								if (in_array($file, $data['pm_supporter_control'])) {
									_e( 'Yes');
								}
								else {
									_e( 'No');
								}
								echo("</td>");
							}
							// Joe Motacek Upgradeable
							echo ('<td>');
							if (is_array($data['upgradeable']) && array_key_exists($file, $data['upgradeable'])) {
								?>
								<span class="icon-sad"></span>
								<?php _e( 'Yes');?>
								<?php
							}
							else {?>
                            	<span class="icon-happy"></span>
                                <?php
								_e( 'No');
							}
							
							echo ('<td>');
							if (is_array($data['derelict_data']) && array_key_exists($file, $data['derelict_data'])) {
								$status = $data['derelict_data'][$file];
								switch ($status){
									case "0":?>
										<span class="icon-angry"></span>
										<?php _e( 'Derelict'); 
										break;
									case "1":?>
										<span class="icon-sad"></span>
										<?php _e( 'Outdated'); 
										break;
									case "2":?>
										<span class="icon-smiley"></span>
										<?php _e( 'Questionable');
										break;
									case "3":?>
										<span class="icon-happy"></span>
										<?php _e( 'Diligent'); 
										break;
								}
									
							}
							else {
								_e( 'Not Found' );
							}
							
							echo ('<td>');
							if (is_array($data['active_sitewide_plugins']) && array_key_exists($file, $data['active_sitewide_plugins'])) {
								_e( 'Yes');
							}
							else {
								_e( 'No');
							}

							if (isset($info['blogs'])) {
								$numBlogs = sizeOf($info['blogs']);
							} else {
								$numBlogs = 0;
							}

							echo ('</td><td>' . $numBlogs . '</td><td>');
							?>
							<a href="javascript:void(0)" onClick="jQuery('#bloglist_<?php echo $counter; ?>').toggle(400);"><?php _e( 'Show/Hide Blogs'); ?></a>

							<?php
							echo ('<ul class="bloglist" id="bloglist_' . $counter  . '">');
							if ( isset($info['blogs']) && is_array($info['blogs']) ) {
								foreach($info['blogs'] as $blog) {
									echo ('<li><a href="http://' . $blog['url'] . '" target="new">' . $blog['name'] . '</a></li>');
								}
							}
							else
								echo ("<li>" . _e( 'N/A' ) . "</li>");	
							echo ('</ul></td>');
						} ?>
					</tbody>
				</table>
					<p>
						<?php 
							$lastUpdate = date('l, F jS, Y',$data['gen_time']);
							echo 'This data was last updated on '. $lastUpdate ."." ; ?>
							<button id="update" ><?php _e( 'Update' ); ?></button>
							<div id="update_area">
								<div id="progress_bar"></div>
								<div id="progress_status"></div>
							</div>
					</p>
        <?php }
	}
endif;