<?php

namespace Afca\Plugins\SoftwareLibrary;

class MetaFields {

	public function __construct( string $lib_acf_path, string $lib_acf_url ) {
		// Include the ACF plugin.
		include_once $lib_acf_path . 'acf.php';

		// Customize the url setting to fix incorrect asset URLs.
		add_filter(
			'acf/settings/url',
			function() use ( $lib_acf_url ) {
				return $lib_acf_url;
			}
		);

		//If function does not exists, add wp plugin lib
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		// Check if ACF Plugin is installed and active
		if ( ! is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {
			//If not:
			// (Optional) Hide the ACF admin menu item.
			add_filter(
				'acf/settings/show_admin',
				function() {
					return false;
				}
			);
		}

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			$this->register_meta_fields();
		}
	}

	private function register_meta_fields() {
		add_action(
			'acf/include_fields',
			function() {
				if ( ! function_exists( 'acf_add_local_field_group' ) ) {
					return;
				}

				acf_add_local_field_group(
					[
						'key'                   => 'group_640d3dafd8e12',
						'title'                 => __( 'Technical Information', 'afca-software-library' ),
						'fields'                => [
							[
								'key'               => 'field_647ca20950de9',
								'label'             => '',
								'name'              => 'software_library',
								'aria-label'        => '',
								'type'              => 'group',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => [
									'width' => '',
									'class' => '',
									'id'    => '',
								],
								'layout'            => 'block',
								'sub_fields'        => [
									[
										'key'           => 'field_640d3db147dcc',
										'label'         => __( 'Type', 'afca-software-library' ),
										'name'          => 'type',
										'aria-label'    => '',
										'type'          => 'select',
										'instructions'  => '',
										'required'      => 1,
										'conditional_logic' => 0,
										'wrapper'       => [
											'width' => '',
											'class' => '',
											'id'    => '',
										],
										'choices'       => [
											'plugin' => __( 'Plugin', 'afca-software-library' ),
											'theme'  => __( 'Theme', 'afca-software-library' ),
											'other'  => __( 'Others', 'afca-software-library' ),
										],
										'default_value' => false,
										'return_format' => 'value',
										'multiple'      => 0,
										'allow_null'    => 0,
										'ui'            => 1,
										'ajax'          => 0,
										'placeholder'   => '',
									],
									[
										'key'           => 'field_640d3ddc47dcd',
										'label'         => __( 'URL', 'afca-software-library' ),
										'name'          => 'url',
										'aria-label'    => '',
										'type'          => 'url',
										'instructions'  => '',
										'required'      => 1,
										'conditional_logic' => 0,
										'wrapper'       => [
											'width' => '',
											'class' => '',
											'id'    => '',
										],
										'default_value' => '',
										'placeholder'   => '',
									],
									[
										'key'           => 'field_640d3dfc47dce',
										'label'         => __( 'Version', 'afca-software-library' ),
										'name'          => 'version',
										'aria-label'    => '',
										'type'          => 'number',
										'instructions'  => '',
										'required'      => 1,
										'conditional_logic' => 0,
										'wrapper'       => [
											'width' => '',
											'class' => '',
											'id'    => '',
										],
										'default_value' => '',
										'min'           => '',
										'max'           => '',
										'placeholder'   => '',
										'step'          => '0.1',
										'prepend'       => '',
										'append'        => '',
									],
									[
										'key'           => 'field_640d3dfc47dca',
										'label'         => __( 'Required Version', 'afca-software-library' ),
										'name'          => 'wp_required',
										'aria-label'    => '',
										'type'          => 'number',
										'instructions'  => __( 'What is the WordPress required version?', 'afca-software-library' ),
										'required'      => 1,
										'conditional_logic' => 0,
										'wrapper'       => [
											'width' => '',
											'class' => '',
											'id'    => '',
										],
										'default_value' => '',
										'min'           => '',
										'max'           => '',
										'placeholder'   => '',
										'step'          => '',
										'prepend'       => '',
										'append'        => '',
									],
									[
										'key'           => 'field_640d3dfc47dcb',
										'label'         => __( 'Tested Versions', 'afca-software-library' ),
										'name'          => 'wp_tested',
										'aria-label'    => '',
										'type'          => 'number',
										'instructions'  => __( 'What is the WordPress tested version?', 'afca-software-library' ),
										'required'      => 1,
										'conditional_logic' => 0,
										'wrapper'       => [
											'width' => '',
											'class' => '',
											'id'    => '',
										],
										'default_value' => '',
										'min'           => '',
										'max'           => '',
										'placeholder'   => '',
										'step'          => '',
										'prepend'       => '',
										'append'        => '',
									],
									[
										'key'            => 'field_640e5386caf55',
										'label'          => __( 'Released Date', 'afca-software-library' ),
										'name'           => 'released_date',
										'aria-label'     => '',
										'type'           => 'date_picker',
										'instructions'   => '',
										'required'       => 0,
										'conditional_logic' => 0,
										'wrapper'        => [
											'width' => '',
											'class' => '',
											'id'    => '',
										],
										'display_format' => 'd/m/Y',
										'return_format'  => 'd/m/Y',
										'first_day'      => 1,
									],
								],
							],
						],
						'location'              => [
							[
								[
									'param'    => 'post_type',
									'operator' => '==',
									'value'    => 'afca-software-lib',
								],
							],
						],
						'menu_order'            => 0,
						'position'              => 'normal',
						'style'                 => 'default',
						'label_placement'       => 'top',
						'instruction_placement' => 'label',
						'hide_on_screen'        => '',
						'active'                => true,
						'description'           => '',
						'show_in_rest'          => 0,
					]
				);
			}
		);
	}

}
