<?php

namespace Afca\Plugins\SoftwareLibrary;

class Endpoints {

	function __construct() {
		add_action(
			'rest_api_init',
			function () {
				register_rest_route(
					'afca-software-library/v1',
					'/ref/(?P<slug>[a-z0-9-]+)',
					[
						'methods'  => 'GET',
						'callback' => [ $this, 'callback' ],
					]
				);
			}
		);
	}

	public function callback( $data ) {
		$post_slug = $data['slug'];
		$post      = get_post( get_page_by_path( $post_slug, OBJECT, 'afca-software-lib' ) );
		if ( $post ) {
			$meta_group = get_field( 'software_library', $post->ID );

			return [
				'id'             => $post->ID,
				'title'          => $post->post_title,
				'released_notes' => $post->post_content,
				'version'        => $meta_group['version'],
				'url'            => $meta_group['url'],
				'wp_required'    => $meta_group['wp_required'],
				'wp_tested'      => $meta_group['wp_tested'],
				'released_date'  => $meta_group['released_date'],
			];
		} else {
			return new \WP_Error( 'not_found', 'Item not found', [ 'status' => 404 ] );
		}
	}

}
