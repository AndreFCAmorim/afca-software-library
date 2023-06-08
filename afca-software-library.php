<?php
/**
 * Plugin Name:       WP Software Library
 * Description:       This plugin allows you to manage the information of all of your themes and plugins. Everything is accessible trough the WordPress API.
 * Requires at least: 6.1
 * Requires PHP:      7.4
 * Version:           0.2
 * Author:            André Amorim
 * Author URI:        https://andreamorim.site
 * Text Domain:       afca-software-library
 */

/**
 * Require composer autoload for psr-4
 */
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * Load plugin text domain for translations.
 */
function afca_load_plugin_language() {
	// Replace 'your-textdomain' with your plugin's text domain.
	load_plugin_textdomain( 'afca-software-library', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'afca_load_plugin_language' );

/**
 * Register the custom post type
 */
use Afca\Plugins\SoftwareLibrary\PostType;
new PostType();

/**
 * Register acf meta fields
 */
use Afca\Plugins\SoftwareLibrary\MetaFields;
new MetaFields(
	plugin_dir_path( __FILE__ ) . '/libs/acf/',
	plugin_dir_url( __FILE__ ) . '/libs/acf/',
);

/**
 * Register endpoints
 */
use Afca\Plugins\SoftwareLibrary\Endpoints;
new Endpoints();

/**
 * Register updates
 */
use Afca\Plugins\SoftwareLibrary\Updates;
$plugin_dir  = plugin_dir_path( __FILE__ );
$plugin_data = get_plugin_data( $plugin_dir . 'afca-software-library.php' );
$update_class = new Updates( 'https://andreamorim.site/', $plugin_data['TextDomain'], $plugin_data['Version'] );

add_action( 'init', [ $update_class, 'check_for_updates_on_hub' ] );