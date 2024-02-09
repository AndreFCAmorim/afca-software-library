<?php

// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// Clean schedule events
if ( wp_next_scheduled( 'afca_software_library_updates' ) ) {
	wp_clear_scheduled_hook( 'afca_software_library_updates' );
}
