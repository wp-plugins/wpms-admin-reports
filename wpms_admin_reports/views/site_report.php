<?php 
if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );

if( !class_exists( 'wpmsar_site_report_view' ) ):

	class wpmsar_site_report_view {
		
		public function display($data){
			global $blog_id;
			?>
			<div class="wrap">
            	<?php screen_icon('ms-admin');?>
                <h2><?php _e('Site Report');?></h2>
                <div class="tablenav">
                    <div class="pager tablenav-pages">
                        <span class="displaying-num"><?php echo count($data);?> sites</span>
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
                    	<tr>
                        	<th class="ID_column"><?php _e('ID');?></th>
                        	<th><?php _e('Name');?></th>
                            <th><?php _e('Path');?></th>
                            <th class="status_column"><?php _e('Status');?></th>
                            <th class="date_column"><?php _e('Last Post');?></th>
                            <th class="date_column"><?php _e('Updated');?></th>
                            <th class="date_column"><?php _e('Created');?></th>
                            <th><?php _e('Tempalte');?></th>
                            <th class="user_column"><?php _e('Users');?></th>
                            <th><?php _e('Admin');?></th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php 
						foreach( $data as $site){
							?>
                        	<tr>
                            	<td><?php echo $site->blog_id;?></td>
                                <td><?php echo $site->blog_name;?>
                                <div class="row-actions">
                                	<span class="edit"><span class="edit">
                                        <a href="<?php echo network_admin_url(); ?>site-info.php?id=<?php echo $site->blog_id?>">Edit</a>
                                    </span> | </span>
                                    <span class="backend"><span class="backend">
                                        <a href="<?php echo get_admin_url() . $site->path; ?>wp-admin/" class="edit">Dashboard</a>
                                    </span>  </span>
                                    <!-- Add this functionality it next version @todo
                                    <span class="archive"><span class="archive">
                                    	<a href="<?php
										$url = network_admin_url() . 
											'admin.php?page=wpmsar_site_report&amp;action=archive&amp;id=' . 
											$site->blog_id;
										echo wp_nonce_url($url, 'archive')?>">Archive</a>
                                    </span> | </span>
                                    <span class="delete"><span class="delete">
                                    <a href="<?php
										$url = network_admin_url() . 
											'admin.php?page=wpmsar_site_report&amp;action=delete&amp;id=' . 
											$site->blog_id;
										echo wp_nonce_url($url, 'delete');?>">Delete</a>
                                    </span></span>-->
                                </div>
                                </td>
                                <td><?php echo "<a href='" .
											$site->home_url .
											"'>".
											$site->path .
											"</a>";?>
                                <div class="row-actions">
                                	<span class="visit"><span class="view">
                                    	<a href="<?php echo $site->home_url; ?>" rel="permalink">Visit</a>
                                    </span></span>
                                </div>
                                </td>
                                <td>
									<?php 
                                    if($site->site_status == "Up"){
                                        echo "<span class='icon-arrow-up'></span> ";
                                    }else{
										echo "<span class='icon-arrow-down'></span> ";
									}
									echo $site->site_status;?>
                                </td>
                                <td>
									<?php
									if($site->last_post_status == 'best'){
										echo "<span class='icon-happy'></span> ";
									}elseif($site->last_post_status == 'good'){
										echo "<span class='icon-smiley'></span> ";
									}elseif($site->last_post_status == 'bad'){
										echo "<span class='icon-sad'></span> ";
									}elseif($site->last_post_status == 'worst'){
										echo "<span class='icon-angry'></span> ";
									}
									echo $site->last_post_date;?>
                                </td>
                                <td>
									<?php
									if($site->last_updated_status == 'best'){
										echo "<span class='icon-happy'></span> ";
									}elseif($site->last_updated_status == 'good'){
										echo "<span class='icon-smiley'></span> ";
									}elseif($site->last_updated_status == 'bad'){
										echo "<span class='icon-sad'></span> ";
									}elseif($site->last_updated_status == 'worst'){
										echo "<span class='icon-angry'></span> ";
									}
									echo date("Y-m-d", strtotime($site->last_updated) );?>
                                </td>
                                <td><?php echo date("Y-m-d", strtotime($site->registered) );?></td>
                                <td><?php echo "<a href='" .
											get_admin_url() . 
											"network/site-themes.php?id=" .
											$site->blog_id .
											"'>" .
											$site->current_theme .
											"</a>";?>
                                <div class="row-actions">
                                	<span class="view"><span class="view">
                                    	<a href="<?php echo get_admin_url() .
										"network/site-themes.php?id=" .
										$site->blog_id; ?>" rel="permalink">Manage</a>
                                    </span></span>
                                </div>
                                </td>
                                <td><?php echo $site->user_count?></td>
                                <td><?php echo "<a href='mailto:" .
											$site->admin_email .
											"'>" .
											$site->admin_email .
											"</a>";?>
                                <div class="row-actions">
                                	<span class="email"><span class="email">
                                    	<a href="mailto:<?php echo $site->admin_email; ?>" rel="permalink">Email</a>
                                    </span></span>
                                </div>
                                </td>
                            </tr>                        
						<?php		
						}
						?>
                    </tbody>
                </table>
                <p>
                	<?php 
					$lastUpdate = date( 'l, F jS, Y', get_site_option('wpmsar_site_freshness') );
					echo 'This data was last updated on '. $lastUpdate ."." ; 
					?>
					<button id="update" ><?php _e( 'Update' ); ?></button>
					<div id="update_area">
						<div id="progress_bar"></div>
						<div id="progress_status"></div>
					</div>
                </p>
            </div>
<?php	}
	}
endif;