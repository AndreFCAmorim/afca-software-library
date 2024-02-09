<?php

namespace Afca\Plugins\SoftwareLibrary;

class MetaFields {

	public function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'custom_add_meta_boxes' ] );
		add_action( 'save_post', [ $this, 'custom_save_meta_fields' ] );
	}

	public function custom_add_meta_boxes() {
		add_meta_box(
			'software_library_meta_box',
			__( 'Technical Information', 'afca-software-library' ),
			[ $this, 'custom_render_meta_box' ],
			'afca-software-lib',
			'normal',
			'high'
		);
	}

	public function custom_render_meta_box( $post ) {
		// Retrieve the existing values for the fields
		$type          = get_post_meta( $post->ID, 'software_library_type', true );
		$url           = get_post_meta( $post->ID, 'software_library_url', true );
		$version       = get_post_meta( $post->ID, 'software_library_version', true );
		$wp_required   = get_post_meta( $post->ID, 'software_library_wp_required', true );
		$wp_tested     = get_post_meta( $post->ID, 'software_library_wp_tested', true );
		$released_date = get_post_meta( $post->ID, 'software_library_released_date', true );

		// Output the fields
		printf(
			'<div class="metabox software-library" style="display:flex;flex-direction:column;">
				<label for="software-library-type" style="margin-bottom:5px;">
					%1$s
				</label>
				<select id="software-library-type" name="software-library-type">
					<option value="plugin">Plugin</option>
					<option value="theme">Theme</option>
					<option value="other">Others</option>
				</select><br>

				<label for="software-library-url" style="margin-bottom:5px;">
					%3$s
				</label>
				<input type="url" id="software-library-url" name="software-library-url" value="%4$s" pattern="https://.*" placeholder="https://"><br>

				<label for="software-library-version" style="margin-bottom:5px;">
					%5$s
				</label>
				<input type="number" id="software-library-version" name="software-library-version" value="%6$s" step="0.1"><br>

				<label for="software-library-wp-required" style="margin-bottom:5px;">
					%7$s
				</label>
				<input type="number" id="software-library-wp-required" name="software-library-wp-required" value="%8$s" step="0.1"><br>

				<label for="software-library-wp-tested" style="margin-bottom:5px;">
					%9$s
				</label>
				<input type="number" id="software-library-wp-tested" name="software-library-wp-tested" value="%10$s" step="0.1"><br>

				<label for="software-library-released-date" style="margin-bottom:5px;">
					%11$s
				</label>
				<input type="date" id="software-library-released-date" name="software-library-released-date" value="%12$s"><br>
			</div>',
			esc_html( __( 'Type:', 'afca-software-library' ) ),
			esc_attr( $type ),
			esc_html( __( 'URL:', 'afca-software-library' ) ),
			esc_attr( $url ),
			esc_html( __( 'Version:', 'afca-software-library' ) ),
			esc_attr( $version ),
			esc_html( __( 'Required WordPress Version:', 'afca-software-library' ) ),
			esc_attr( $wp_required ),
			esc_html( __( 'Tested WordPress Version:', 'afca-software-library' ) ),
			esc_attr( $wp_tested ),
			esc_html( __( 'Released Date:', 'afca-software-library' ) ),
			esc_attr( $released_date )
		);
	}

	public function custom_save_meta_fields( $post_id ) {
		// Save meta fields when the post is saved
		if ( isset( $_POST['software-library-type'] ) ) {
			update_post_meta( $post_id, 'software_library_type', sanitize_text_field( $_POST['software-library-type'] ) );
		}

		if ( isset( $_POST['software-library-url'] ) ) {
			update_post_meta( $post_id, 'software_library_url', esc_url_raw( $_POST['software-library-url'] ) );
		}

		if ( isset( $_POST['software-library-version'] ) ) {
			update_post_meta( $post_id, 'software_library_version', sanitize_text_field( $_POST['software-library-version'] ) );
		}

		if ( isset( $_POST['software-library-wp-required'] ) ) {
			update_post_meta( $post_id, 'software_library_wp_required', sanitize_text_field( $_POST['software-library-wp-required'] ) );
		}

		if ( isset( $_POST['software-library-wp-tested'] ) ) {
			update_post_meta( $post_id, 'software_library_wp_tested', sanitize_text_field( $_POST['software-library-wp-tested'] ) );
		}

		if ( isset( $_POST['software-library-released-date'] ) ) {
			update_post_meta( $post_id, 'software_library_released_date', sanitize_text_field( $_POST['software-library-released-date'] ) );
		}
	}
}
