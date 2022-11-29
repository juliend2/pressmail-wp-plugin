=== Plugin Name ===
Contributors: pressmail, jdesrosiers
Tags: mail, wp_mail, api
Requires at least: 6.0.0
Tested up to: 6.1.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The easiest way to send emails with WordPress

== Description ==

The simplest way to send emails from your WordPress site. No SMTP or DNS to manage.

**Note**: to use this plugin, you will need to first create an account on [pressmail.co](https://www.pressmail.co).

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the `pressmail/` directory to your site's `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Log into your Pressmail your profile at https://www.pressmail.co/profile/
    1. From there, create a Sender 
    1. Confirm the sender's `REPLY-TO` email address
1. Copy your Sender Key
1. In Settings > Pressmail, paste the Sender Key you just copied

== Frequently Asked Questions ==

= Is it free? =

Yes, up to 1000 outbound emails per month.

Professional plans are also available. See the [pricing](https://www.pressmail.co/pricing/) page for more details.

= Can people respond to those emails? =

You won't be able to respond from the email we'll provide you with (`something@pressmail.co`).
But recipients will be able to reply to your emails at the address you will provide as the `REPLY-TO` address to your Senders.


== Screenshots ==

1. This is the Pressmail Settings page

== Changelog ==

= 1.0 =
* First release

== Upgrade Notice ==

= 1.0 =
First release
