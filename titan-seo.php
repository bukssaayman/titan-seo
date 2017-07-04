<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.titandigital.com.au
 * @since             1.0.0
 * @package           Titan_Seo
 *
 * @wordpress-plugin
 * Plugin Name:       Titan SEO
 * Plugin URI:        www.titandigital.com.au
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Buks Saayman
 * Author URI:        www.titandigital.com.au
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       titan-seo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-titan-seo-activator.php
 */
function activate_titan_seo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-titan-seo-activator.php';
	Titan_Seo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-titan-seo-deactivator.php
 */
function deactivate_titan_seo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-titan-seo-deactivator.php';
	Titan_Seo_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_titan_seo' );
register_deactivation_hook( __FILE__, 'deactivate_titan_seo' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-titan-seo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_titan_seo() {

	$plugin = new Titan_Seo();
	$plugin->run();

}
run_titan_seo();
