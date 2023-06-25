<?php
/**
 * Plugin Name:       WP Software Library
 * Description:       This plugin allows you to manage the information of all of your themes and plugins. Everything is accessible trough the WordPress API.
 * Plugin URI:        https://andreamorim.site/plugin-documentation/sofware-library/
 * Requires at least: 6.1
 * Requires PHP:      7.4
 * Version:           1.0
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

use Afca\Plugins\SoftwareLibrary\Init;
new Init( plugin_dir_path( __FILE__ ), plugin_dir_url( __FILE__ ) );
