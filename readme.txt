=== WP PingFM to post ===
Contributors: chmac
Donate link: http://www.callum-macdonald.com/code/donate/
Tags: pingfm, custom url, pingdotfm, ping
Requires at least: 2.7
Tested up to: 3.0.5
Stable tag: 0.2

Inspired by the most excellent by Ping.fm Custom URL plugin by Matt Jacob. This is a much cruder, simpler plugin that does something vaguely similar.

== Description ==

Inspired by the most excellent by <a href="http://wordpress.org/extend/plugins/pingfm-custom-url-status-updates/">Ping.fm Custom URL</a> plugin by <a href="http://mattjacob.com/">Matt Jacob</a>. This is a much cruder, much simpler plugin that does something vaguely similar.

== Installation ==

Install through the regular method. If you're not familiar with installing WordPress plugins I suggest you use Matt's excellent <a href="http://wordpress.org/extend/plugins/pingfm-custom-url-status-updates/">plugin</a>, it's much more user friendly. :-)

After install, go to wp-admin/options.php and set these options:
* pingfm_default_category
* pingfm_status_category
* pingfm_microblog_category
* pingfm_blog_category
* pingfm_author

They should all be single ids. Either category ids or user ids. Just the number, nothing else, easy.

Then head over to <a href="http://ping.fm/">ping.fm</a>, setup your custom url as your blog homepage and add this to the end:
?pingfm_token=XXX

Replace XXX with the value of the pingfm_token option. You can change this if you like.

You can also specify the author in the custom url like so:
?pingfm_token=XXX&author=1

Replace 1 with the id of whichever user you want to be the author.

Set the option pingfm_twitter_links to 0 if you do not want #hashtags and @replies to link to twitter.com.

== Frequently Asked Questions ==

New plugin, so no questions have yet been asked. :-)

If you have a question, please read the code. If you don't find the answer in there, try <a href="http://wordpress.org/extend/plugins/pingfm-custom-url-status-updates/">Matt's plugin</a> instead. It's much easier, much more user friendly.

== Screenshots ==

No screenshots.

== Support Questions ==

As per the FAQ. Read the code, if it doesn't make sense, use <a href="http://wordpress.org/extend/plugins/pingfm-custom-url-status-updates/">Matt's plugin</a> instead.
