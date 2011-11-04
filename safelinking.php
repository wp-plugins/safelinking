<?php
/*
Plugin Name: Safelinking
Plugin URI: http://www.safelinking.net/tools
Description: Easily protect your links via safelinking.net
Version: 1.0
*/

// This is the html we will add to the comment page
function safelinking_comment() 
{
	echo '
              <br/><p class="comment-form-comment">
             	<label for="safelinking-links">Secure your links with Safelinking</label>
	      	<textarea name="" id="safelinking-links" cols="58" rows="6"></textarea>
	      	</p>
	      	<p class="form-submit">
			<input name="safelinking" type="button" onclick="safelinking_initialise();" value="Insert into comment" id="submit">
		</p><br/><br/>
	';
	
	echo "<script type='text/javascript' src='" . get_bloginfo('wpurl') . "/wp-content/plugins/safelinking/safelinking.js" . "'></script>";
}

function safelinking_admin()
{
	echo '<div class="postbox">
              <div class="handlediv" title="Click to toggle"><br /></div><h3 class=\'hndle\'><span>Secure your links</span></h3>
              <div class="inside">
              <div class="submitbox">
              
              <div>
              	<textarea id="safelinking-links" cols="" rows="" style="font-size:10px !important; width:265px;height:200px;"></textarea><br/><br/>
              	<a href="javascript:safelinking_initialise();" class="preview button">Insert links into post</a>
              </div>
              <div class="clear"></div>
              </div>
              
              </div>
              </div>
	';
	
	echo "<script type='text/javascript' src='" . get_bloginfo('wpurl') . "/wp-content/plugins/safelinking/safelinking.js" . "'></script>";
}

add_action('comment_form', 'safelinking_comment');

add_action('submitpost_box', 'safelinking_admin');

?>
