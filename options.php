<div class="wrap">
	<?php screen_icon(); ?>
	<h2>Safelinking options</h2>
	<?php if (isset($message)) { ?>
    <div id="message" class="<?php if(isset($error)) { echo 'error'; } else { echo 'updated'; } ?>">
        <p><strong><?php echo $message; ?></strong></p>
    </div>
	<?php } ?>
	<form method="post">
		 <?php settings_fields('safelinking_options'); ?>
		 <table class="form-table">
			<tr valign="top">
				<th scope="row">Custom domain url</th>
				<td>
					<input class="regular-text" type="text" name="safelinking_custom_domain" value="<?php echo get_option('safelinking_custom_domain'); ?>" />
					<p class="description">Must be in the format of http://yourdomain.tld/</p>
				</td>
			</tr>
			<tr>
				<th scope="row">Show in admin page</th>
				<td>
					<input type="checkbox" name="safelinking_display_postbox_admin" <?php if(get_option('safelinking_display_postbox_admin') == true) { echo 'checked="checked"'; } ?>/>
				</td>
			</tr>
			<tr>
				<th scope="row">Show in post comment</th>
				<td>
					<input type="checkbox" name="safelinking_display_postbox_main_site" <?php if(get_option('safelinking_display_postbox_main_site') == true) { echo 'checked="checked"'; } ?>/>
				</td>
			</tr>
		</table>
	<?php submit_button(); ?>
	</form>
</div>