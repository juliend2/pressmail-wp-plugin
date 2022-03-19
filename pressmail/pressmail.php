<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://pressmail.co/
 * @since             1.0.0
 * @package           Pressmail
 *
 * @wordpress-plugin
 * Plugin Name:       Pressmail
 * Plugin URI:        https://pressmail.co/
 * Description:       The simplest way to send emails from your WordPress site. No SMTP or DNS to manage.
 * Version:           1.0.0
 * Author:            Pressmail
 * Author URI:        https://pressmail.co/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pressmail
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PRESSMAIL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pressmail-activator.php
 */
function activate_pressmail() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pressmail-activator.php';
	Pressmail_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pressmail-deactivator.php
 */
function deactivate_pressmail() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pressmail-deactivator.php';
	Pressmail_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pressmail' );
register_deactivation_hook( __FILE__, 'deactivate_pressmail' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pressmail.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pressmail() {

	$plugin = new Pressmail();
	$plugin->run();

}
run_pressmail();
