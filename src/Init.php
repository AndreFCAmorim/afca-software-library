<?php

namespace Afca\Plugins\SoftwareLibrary;

use Afca\Plugins\SoftwareLibrary\PostType;
use Afca\Plugins\SoftwareLibrary\MetaFields;
use Afca\Plugins\SoftwareLibrary\Endpoints;
use Afca\Plugins\SoftwareLibrary\Updates;

class Init {

	private string $plugin_dir_path;
	private string $plugin_dir_url;

	public function __construct( string $plugin_dir_path, string $plugin_dir_url ) {
		if ( is_admin() ) {
			$this->plugin_dir_path = $plugin_dir_path;
			$this->plugin_dir_url  = $plugin_dir_url;

			/**
			 * Load plugin text domain for translations.
			 */
			add_action( 'plugins_loaded', [ $this, 'afca_load_plugin_language' ] );

			/**
			 * Register the custom post type
			 */
			new PostType();

			/**
			 * Register acf meta fields
			 */
			new MetaFields(
				$this->plugin_dir_path . '/libs/acf/',
				$this->plugin_dir_url . '/libs/acf/',
			);

			/**
			 * Register endpoints
			 */
			new Endpoints();

			/**
			 * Register updates
			 */
			$plugin_dir   = $this->plugin_dir_path;
			$plugin_data  = get_plugin_data( $plugin_dir . 'afca-software-library.php' );
			$update_class = new Updates( 'https://andreamorim.site/', basename( $plugin_dir ), $plugin_data['Version'] );

			// Schedule task for checking updates
			add_action( 'afca_software_library_updates', [ $update_class, 'check_for_updates_on_hub' ] );
			if ( ! wp_next_scheduled( 'afca_software_library_updates' ) ) {
				wp_schedule_event( current_time( 'timestamp' ), 'daily', 'afca_software_library_updates' );
			}
		}
	}


	public function afca_load_plugin_language() {
		// Replace 'your-textdomain' with your plugin's text domain.
		load_plugin_textdomain( 'afca-software-library', false, basename( $this->plugin_dir_path ) . '/languages/' );
	}
}
