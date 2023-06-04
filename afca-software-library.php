<?php
/**
 * Plugin Name:       WP Software Library
 * Description:       This plugin allows you to manage the information of all of your themes and plugins. Everything is accessible trough the WordPress API.
 * Requires at least: 6.1
 * Requires PHP:      8.1
 * Version:           0.0.1
 * Author:            André Amorim
 * Author URI:        https://andreamorim.site
 * Text Domain:       afca-software-library
 */

/**
 * Load plugin text domain for translations.
 */
function afca_load_plugin_language() {
    // Replace 'your-textdomain' with your plugin's text domain.
    load_plugin_textdomain( 'afca-software-library', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'afca_load_plugin_language' );
