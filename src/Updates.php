<?php

namespace Afca\Plugins\SoftwareLibrary;

class Updates {

	private string $update_hub;
	private string $plugin_name;
	private string $plugin_version;

	public function __construct( $hub, $uid, $version ) {
		$this->update_hub     = $hub;
		$this->plugin_name    = $uid;
		$this->plugin_version = $version;

		add_filter( 'site_transient_update_plugins', [ $this, 'afca_custom_plugin_update' ] );
	}

	public function afca_custom_plugin_update( $transient ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';

		$remote = get_transient('afca-software-library-api-response');

		if ( ! $remote || ! isset( $remote->id ) ) {
			return $transient;
		}

		$data = (object) [
			'id'             => $this->plugin_name,
			'new_version'    => $remote->version,
			'package'        => $remote->url,
			'url'            => $this->update_hub . 'afca-software-lib/' . $this->plugin_name,
			'requires'       => $remote->wp_required,
			'tested'         => $remote->wp_tested,
			'released'       => $remote->released_date,
			'upgrade_notice' => $remote->released_notes,
		];

		if ( version_compare( $this->plugin_version, $data->new_version, '<' ) ) {
			if ( is_array( $transient->response ) ) {
				$transient->response['afca-software-library/afca-software-library.php'] = $data;
			}
		}

		return $transient;
	}

	public function check_for_updates_on_hub() {
		$ssl_verify = true; // Initial SSL verification option

		$remote = wp_remote_get(
			$this->update_hub . 'wp-json/afca-software-library/v1/ref/' . $this->plugin_name,
			[
				'timeout'   => 30,
				'headers'   => [
					'Accept' => 'application/json',
				],
				'sslverify' => $ssl_verify,
			]
		);

		// Retry with SSL verification disabled if there is an error
		if ( is_wp_error( $remote ) || 200 !== wp_remote_retrieve_response_code( $remote ) || empty( wp_remote_retrieve_body( $remote ) ) ) {
			$ssl_verify = false; // Disable SSL verification
			$remote = wp_remote_get(
				$this->update_hub . 'wp-json/afca-software-library/v1/ref/' . $this->plugin_name,
				[
					'timeout'   => 30,
					'headers'   => [
						'Accept' => 'application/json',
					],
					'sslverify' => $ssl_verify,
				]
			);
		}

		if ( is_wp_error( $remote ) && ( wp_remote_retrieve_response_code( $remote ) !==  200 || empty( wp_remote_retrieve_body( $remote ) ) ) ) {
			error_log( $remote->get_error_message() );
			return;
		} else {
			$remote = json_decode( wp_remote_retrieve_body( $remote ) );
			set_transient( 'afca-software-library-api-response', $remote, 86400 );
		}
	}

}
