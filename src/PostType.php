<?php

namespace Afca\Plugins\SoftwareLibrary;

class PostType {

	public function __construct() {
		add_action( 'init', [ $this, 'register_cpt' ] );
	}

	public function register_cpt() {
		/**
		 * Post Type: Software Library.
		 */

		 $labels = [
			 'name'          => esc_html__( 'Software Library', 'afca-software-library' ),
			 'singular_name' => esc_html__( 'Software Library', 'afca-software-library' ),
		 ];

		 $args = [
			 'label'                 => esc_html__( 'Software Library', 'afca-software-library' ),
			 'labels'                => $labels,
			 'description'           => '',
			 'public'                => true,
			 'publicly_queryable'    => true,
			 'show_ui'               => true,
			 'show_in_rest'          => false,
			 'rest_base'             => '',
			 'rest_controller_class' => 'WP_REST_Posts_Controller',
			 'rest_namespace'        => 'wp/v2',
			 'has_archive'           => false,
			 'show_in_menu'          => true,
			 'show_in_nav_menus'     => true,
			 'delete_with_user'      => false,
			 'exclude_from_search'   => true,
			 'capability_type'       => 'post',
			 'map_meta_cap'          => true,
			 'hierarchical'          => false,
			 'can_export'            => true,
			 'rewrite'               => [
				 'slug'       => 'afca-software-lib',
				 'with_front' => true,
			 ],
			 'query_var'             => true,
			 'menu_icon'             => 'dashicons-portfolio',
			 'supports'              => [ 'title', 'editor' ],
			 'show_in_graphql'       => false,
		 ];

		 register_post_type( 'afca-software-lib', $args );
	}
}
