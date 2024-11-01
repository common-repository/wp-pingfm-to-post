<?php
/*
Plugin Name: WP-PingFM-to-post
Plugin URI: http://www.callum-macdonald.com/code/
Description: Simple plugin inspired by <a href="http://wordpress.org/extend/plugins/pingfm-custom-url-status-updates/">Ping.fm Custom URL</a> by <a href="http://mattjacob.com/">Matt Jacob</a>.
Version: 0.2
Author: Callum Macdonald
Author URI: http://www.callum-macdonald.com/
*/
// This code is licensed under the GPL http://www.gnu.org/copyleft/gpl.html
if (!function_exists('wppf_init')) :
function wppf_init() {
	/*
	 * These checks could be more efficient.
	 * get_option() preloads most options so it won't hit the db for each
	 * call. So, I figure it's a reasonable performance trade for the 
	 * simplicity of the code and given WordPress's general performance.
	 */
	// Check if our options exist, if not, create them
	if (get_option('pingfm_token') === false)
		update_option('pingfm_token', md5(time().rand().microtime()));
	if (get_option('pingfm_default_category') === false)
		update_option('pingfm_default_category', '');
	if (get_option('pingfm_status_category') === false)
		update_option('pingfm_status_category', '');
	if (get_option('pingfm_microblog_category') === false)
		update_option('pingfm_microblog_category', '');
	if (get_option('pingfm_blog_category') === false)
		update_option('pingfm_blog_category', '');
	if (get_option('pingfm_author') === false)
		update_option('pingfm_author', 1);
	if (get_option('pingfm_link_twitter') === false)
		update_option('pingfm_link_twitter', 1);
	// If pingfm_token is set, do something...
	if (isset($_GET['pingfm_token'])) {
		if ($_GET['pingfm_token'] != get_option('pingfm_token'))
			wp_die('ERROR: Invalid pingfm_token.');
		// If we get to here, pingfm_token is good
		/*
		 * ping.fm variables are
		 * # method - The method of the message being sent (blog, microblog, status).
		 * # title - If method is "blog" then this contain the blog's title.
		 * # message - The posted message content.
		 * # location - Any location updates posted with the message.  This is plaintext, verbatim from the posting interface.
		 * # media - If media is posted, this will contain a URL to the media file.
		 * # raw_message - If media is posted, this will contain the posted message WITHOUT the hosted media link (i.e. http://ping.fm/p/12345)
		 * # trigger - If you post a message with a custom trigger (http://ping.fm/triggers/), it will show here
		 */
		// Set the category / tags based on the method (blog, microblog or status)
		if (isset($_POST['method'])) {
			switch ($_POST['method']) {
				case 'blog' :
					$categories = array(get_option('pingfm_blog_category'));
					break;
				case 'microblog' :
					$categories = array(get_option('pingfm_microblog_category'));
					break;
				case 'status' :
					$categories = array(get_option('pingfm_status_category'));
					break;
				default :
					$categories = array(get_option('pingfm_default_category'));
					break;
			}
		}
		else {
			$categories = $categories = array(get_option('pingfm_default_category'));
		}
		// Set the author
		if (!empty($_GET['author']))
			$author = $_GET['author'];
		else
			$author = get_option('pingfm_author', 1);
		// Parse links, etc in the message body, it comes as plain text
		// Modified from http://blog.andreaolivato.net/programming/using-regular-expressions-to-add-links-to-tweets.html
		$message = $_POST['message'];
		$regex = '/http([s]?):\/\/([^\ \)$]*)/';
		$link_pattern = '<a href="http$1://$2" title="$2" target="_blank">http$1://$2</a>';
		$message = preg_replace($regex,$link_pattern,$message);
		// Link #hashtags and @replies to twitter
		if (get_option('pingfm_link_twitter')) {
			$regex = '/@([a-zA-Z0-9_]*)/';
			$link_pattern = '<a href="http://twitter.com/$1" title="$1 profile on Twitter">@$1</a>';
			$message = preg_replace($regex,$link_pattern,$message);
			$regex = '/\#([a-zA-Z0-9_]*)/';
			$link_pattern = '<a href="http://search.twitter.com/search?q=%23$1" title="search for $1 on Twitter">\#$1</a>';
			$message = preg_replace($regex,$link_pattern,$message);
		}
		// Create the post array
		$new_post = array(
			'post_type'	=> 'post',
			'post_status'	=> 'publish',
			'post_author'	=> $author,
			'post_category'	=> $categories,
			'post_title'	=> (!empty($_POST['title']) ? $_POST['title'] : ''),
			'post_content'	=> $message
		);
		wp_insert_post($new_post);
		exit('Success. Post saved.');
	}
}
endif;

add_action('init', 'wppf_init');

?>
