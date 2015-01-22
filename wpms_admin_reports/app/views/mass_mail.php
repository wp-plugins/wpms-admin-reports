<?php
if( !class_exists( 'wpmsar_mass_mail_view' ) ):

	class wpmsar_mass_mail_view{
		
		public function display($data){
			?>

<div class="wrap">
  <?php screen_icon('index');?>
  <h2>
    <?php _e('Email Admins');?>
  </h2>
    <?php 
	if ( isset( $_GET['success'] ) && $_GET['success'] == '1' ):?>
   	<div id='message' class='updated fade'><p><strong>Message Sent Successfully!</strong></p></div>
	<?php elseif (isset( $_GET['success'] ) && $_GET['success'] == '2'):?>
	<div id='message' class='error fade'><p><strong>Message was not sent...</strong></p></div>
	<?php endif;?>
  <form method="post" action="<?php echo admin_url(); ?>admin-post.php">
  	<input type="hidden" name="action" value="wpmsar_send_mass_mail"/>
    <?php wp_nonce_field('wpmsar_mass_mail_verify'); ?>
    <table class="form-table">
      <tr>
        <th scope="row"> <label for="email_addresses">Recipients</label></th>
        <td>
        	<textarea name="email_addresses" id="email_addresses" cols="45" rows="5" class="large-text"><?php foreach ($data as $email){ echo $email . ", ";};?></textarea>
          <p class="description">These are all of the people listed as an administrator for at least one site in the network.</p>
        </td>
      </tr>
      <tr>
        <th scope="row"><label for="email_subject">Subject</label></th>
        <td><input type="text" name="email_subject" id="email_subject" ></td>
      </tr>
      <tr>
        <th scope="row"><label for="email_message">Message</label></th>
        <td><textarea name="email_message" id="email_message" cols="45" rows="5" class="large-text">Your message here...</textarea></td>
      </tr>
    </table>
    <p class="submit">
      <input type="submit" name="submit" id="submit" class="button button-primary" value="Send">
    </p>
  </form>
</div>
<?php
		}
	}
endif;
