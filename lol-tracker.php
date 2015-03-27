<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/vvasiloud/wp-loltracker
 * @since             1.0.0
 * @package           LoL_Tracker
 *
 * @wordpress-plugin
 * Plugin Name:       League Of Legends Tracker
 * Plugin URI:        https://github.com/vvasiloud/wp-loltracker
 * Description:       LoL Tracker is a set of tools relating your league of Legends account. In this current version there is only the functionality of "Free Week Champions Widget"
 * Version:           1.0.0
 * Author:            vvasiloudis
 * Author URI:        http://vvasiloud.github.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       lol-tracker
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-lol-tracker-activator.php
 */
function activate_lol_tracker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lol-tracker-activator.php';
	LoL_Tracker_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-lol-tracker-deactivator.php
 */
function deactivate_lol_tracker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lol-tracker-deactivator.php';
	LoL_Tracker_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_lol_tracker' );
register_deactivation_hook( __FILE__, 'deactivate_lol_tracker' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-lol-tracker.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_lol_tracker() {

	$plugin = new LoL_Tracker();
	$plugin->run();

}
run_lol_tracker();
