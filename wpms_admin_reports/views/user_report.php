<?php 
if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ )
	die( 'Access denied.' );

if( !class_exists( 'wpmsar_user_report_view' ) ):

	class wpmsar_user_report_view {
		
		public function display($data){
			?>
			<div class="wrap">
            	<?php screen_icon('users');?>
                <h2><?php _e('User Report');?></h2>
                <div class="tablenav">
                    <div class="pager tablenav-pages">
                        <span class="displaying-num"><?php echo count($data);?> users</span>
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
                        	<th class="username_column"><?php _e('Username');?></th>
                        	<th><?php _e('Name');?></th>
                            <th><?php _e('Email');?></th>
                            <th class="last_login_column"><?php _e('Last Login');?></th>
                            <th class="ip_address_column"><?php _e('IP Address');?></th>
                            <th class="registered_column"><?php _e('Registered');?></th>
                            <th class="sites_column"><?php _e('Sites');?></th>
                            <th class="roles_column"><?php _e('Roles');?></th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php 
						foreach($data as $user){
							?>
                        	<tr>
                            	<td><?php echo $user->id;?></td>
                            	<td><a href="<?php echo network_admin_url() .
									'user-edit.php?user_id=' .
									$user->id;?>'"><?php echo $user->user_login ?></a>
                                    <div class="row-actions">
                                        <span class="edit"><span class="edit">
                                            <a href="<?php echo network_admin_url() .
											'user-edit.php?user_id=' .
											$user->id; ?>">Edit</a>
                                        </span>  </span>
                                        <!--<span class="delete"><span class="delete">
                                            <a href="<?php echo network_admin_url() .
											'admin.php?page=wpmsar_user_report'?>">Delete</a>
                                        </span></span>-->
                                    </div>
                                </td>
                                <td><?php echo $user->display_name;?></td>
                                <td><a href="mailto:<?php echo $user->user_email?>"><?php echo $user->user_email;?></a>
                                    <div class="row-actions">
                                        <span class="edit">
                                            <a href="mailto:<?php echo $user->user_email?>">Email</a>
                                        </span>
                                    </div>
                                </td>
                                <td>
									<?php 
									if($user->last_login_status == 'best'){
										echo "<span class='icon-happy'></span> ";
									}elseif($user->last_login_status == 'good'){
										echo "<span class='icon-smiley'></span> ";
									}elseif($user->last_login_status == 'bad'){
										echo "<span class='icon-sad'></span> ";
									}elseif($user->last_login_status == 'worst'){
										echo "<span class='icon-angry'></span> ";
									}
									echo $user->last_login;?>
                                </td>
                                <td><?php echo $user->ip_address;?></td>
                                <td><?php echo date('Y-m-d', strtotime( $user->user_registered ) );?></td>
                                <td>
								<?php 
									if( count($user->blogs) == 0 ){
										echo "<span class='icon-angry'></span> ";
									}
									echo count($user->blogs);
								?>
                                	<div class="wpmsar-hidden">
                                    	<?php
										foreach($user->blogs as $blog){
											echo '<span class="ellipsis-overflow">' .
											'<a href="#">' . $blog->blogname .
											'</a></span>';
										}
										?>
                                    </div>
                                </td>
                                <td><?php echo '<span class="wpmsar-show-more">Show</span>';?>
                                	<div class="wpmsar-hidden">
                                    	<?php
										foreach($user->blogs as $blog){
											echo $blog->role ."<br/>";
										}
										?>
                                    </div>
                                </td>
                            </tr>         
						<?php		
						}
						?>
                    </tbody>
                </table>
            </div>
		<?php }
	}
endif;