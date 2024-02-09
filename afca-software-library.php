<?php
/**
 * Plugin Name:       WP Software Library
 * Description:       This plugin allows you to manage the information of all of your themes and plugins. Everything is accessible trough the WordPress API.
 * Plugin URI:        https://andreamorim.site/plugin-documentation/sofware-library/
 * Requires at least: 6.1
 * Requires PHP:      7.4
 * Version:           1.1
 * Author:            André Amorim
 * Author URI:        https://andreamorim.site
 * Text Domain:       afca-software-library
 */

/**
 * Require composer autoload for psr-4
 */
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

// Init
use Afca\Plugins\SoftwareLibrary\Init;
new Init( plugin_dir_path( __FILE__ ) );

// Clean schedule events on plugin deactivation
register_deactivation_hook(
	__FILE__,
	function () {

		if ( wp_next_scheduled( 'afca_software_library_updates' ) ) {
			wp_clear_scheduled_hook( 'afca_software_library_updates' );
		}
	},
);
