<?php
/*
Plugin Name: Safelinking
Plugin URI: https://safelinking.net/tools
Description: Easily protect your links via safelinking.net
Version: 1.2
*/

// This is the html we will add to the comment page
function safelinking_comment()  {
	echo '
              <br/><p class="comment-form-comment">
             	<label for="safelinking-links">Secure your links with ' . get_option('safelinking_custom_domain_site_name') . ' <span id="safelinking-user"></span></label>
	      	<textarea name="" id="safelinking-links" cols="58" rows="6"></textarea>
	      	</p>
	      	<p class="form-submit">
			<input name="safelinking" type="button" onclick="safelinking_initialise();" value="Insert into comment" id="submit">
		</p><br/><br/>
	';
	echo "<script type='text/javascript'>var safelinkingUrl = '" . safelinking_get_url() . "';var safelinkingName = '" . get_option('safelinking_custom_domain_site_name') . "';</script>";
	echo "<script type='text/javascript' src='" . get_bloginfo('wpurl') . "/wp-content/plugins/safelinking/safelinking.js" . "'></script>";
}

function safelinking_admin() {
	echo '<div class="postbox">
              <div class="handlediv" title="Click to toggle"><br /></div><h3 class=\'hndle\'><span>Secure links <span id="safelinking-user"></span></span></h3>
              <div class="inside">
              <div class="submitbox">
              
              <div>
              	<textarea id="safelinking-links" cols="" rows="" style="font-size:10px !important; width:265px;height:200px;"></textarea><br/><br/>
              	<a href="javascript:safelinking_initialise();" class="button button-primary button-large" style="float:right;">Insert links into post</a>
              </div>
              <div class="clear"></div>
              </div>
              
              </div>
              </div>
	';
	echo "<script type='text/javascript'>var safelinkingUrl = '" . safelinking_get_url() . "';var safelinkingName = '" . get_option('safelinking_custom_domain_site_name') . "';</script>";
	echo "<script type='text/javascript' src='" . get_bloginfo('wpurl') . "/wp-content/plugins/safelinking/safelinking.js" . "'></script>";
}

function safelinking_menu() {
	add_options_page('Safelinking options', 'Safelinking', 'manage_options', 'safelinking', 'safelinking_options');
}

function safelinking_register_settings() {
	register_setting('safelinking', 'safelinking_custom_domain');
	register_setting('safelinking', 'safelinking_display_postbox_main_site');
	register_setting('safelinking', 'safelinking_display_postbox_admin');
	register_setting('safelinking', 'safelinking_custom_domain_site_name');
}

function safelinking_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$message = 'Your settings were saved successfully.';
		$domain = $_POST['safelinking_custom_domain'];
		if(!empty($domain)) {
			add_filter('https_ssl_verify', '__return_false');
			$result = json_decode(wp_remote_retrieve_body(wp_remote_get('https://safelinking.net/api?mode=isCustomDomain&domain=' . $domain)), true);
			$isDomain = $result['isDomain'];
			if($isDomain) {
				update_option('safelinking_custom_domain', $domain);
				update_option('safelinking_custom_domain_site_name', $result['siteName']);
			} else {
				$error = true;
				$message = $domain . ' is not a valid custom domain!';
			}
		} else {
			update_option('safelinking_custom_domain', '');
		}
		update_option('safelinking_display_postbox_admin', ($_POST['safelinking_display_postbox_admin'] == 'on'));
		update_option('safelinking_display_postbox_main_site', ($_POST['safelinking_display_postbox_main_site'] == 'on'));
	}
	include(str_replace('safelinking.php', 'options.php', __FILE__));
}

function safelinking_get_url() {
	$domain = get_option('safelinking_custom_domain');
	if(!empty($domain)) {
		return get_option('safelinking_custom_domain');
	} else {
		return 'https://safelinking.net/';
	}
}

add_option('safelinking_custom_domain', '');
add_option('safelinking_custom_domain_site_name', 'Safelinking');
add_option('safelinking_display_postbox_main_site', true);
add_option('safelinking_display_postbox_admin', true);

if(is_admin()) {
	if(get_option('safelinking_display_postbox_admin') == true) {
		add_action('submitpost_box', 'safelinking_admin');
	}
	add_action('admin_menu', 'safelinking_menu');
	add_action('admin_init', 'safelinking_register_settings');
}

if(get_option('safelinking_display_postbox_main_site') == true) {
	add_action('comment_form', 'safelinking_comment');
}

?>
