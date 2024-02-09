<?php

namespace Afca\Plugins\SoftwareLibrary;

class Endpoints {

	public function __construct() {
		add_action(
			'rest_api_init',
			function () {
				register_rest_route(
					'afca-software-library/v1',
					'/ref/(?P<slug>[a-z0-9-]+)',
					[
						'methods'             => 'GET',
						'callback'            => [ $this, 'callback' ],
						'permission_callback' => '__return_true',
					]
				);
			}
		);
	}

	public function callback( $data ) {
		$post_slug = $data['slug'];
		$post      = get_post( get_page_by_path( $post_slug, OBJECT, 'afca-software-lib' ) );
		if ( $post ) {
			$url           = get_post_meta( $post->ID, 'software_library_url', true );
			$version       = get_post_meta( $post->ID, 'software_library_version', true );
			$wp_required   = get_post_meta( $post->ID, 'software_library_wp_required', true );
			$wp_tested     = get_post_meta( $post->ID, 'software_library_wp_tested', true );
			$released_date = get_post_meta( $post->ID, 'software_library_released_date', true );

			return [
				'id'             => $post->ID,
				'title'          => $post->post_title,
				'released_notes' => $post->post_content,
				'version'        => $version,
				'url'            => $url,
				'wp_required'    => $wp_required,
				'wp_tested'      => $wp_tested,
				'released_date'  => $released_date,
			];
		} else {
			return new \WP_Error( 'not_found', 'Item not found', [ 'status' => 404 ] );
		}
	}
}
