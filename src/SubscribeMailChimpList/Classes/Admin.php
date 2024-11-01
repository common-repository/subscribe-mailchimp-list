<?php

namespace SubscribeMailChimpList\Classes;


class Admin {

	public static $option_prefix = 'SubscribeMailChimpList__';

	public function __construct() {

		add_action( 'admin_menu', [ $this, 'add_option_field_to_setting_admin_page' ] );

	}

	public function add_option_field_to_setting_admin_page() {

		add_settings_field(
			self::$option_prefix . 'api_key',
			__( 'MailChimp API key', 'SubscribeMailChimpList' ),
			function ( $val ) {

				$option_name = self::$option_prefix . 'api_key';

				$val = esc_attr( get_option( $option_name, '' ) );

				echo "<input name='{$option_name}' id='{$option_name}' value='{$val}' class='regular-text' type='text' />";

			},
			'reading',
			'default'
		);

		register_setting( 'reading', self::$option_prefix . 'api_key', [ 'sanitize_callback' => [ $this, 'sanitize' ] ] );

		add_settings_field(
			self::$option_prefix . 'list_id',
			__( 'MailChimp List id', 'SubscribeMailChimpList' ),
			function ( $val ) {

				$option_name = self::$option_prefix . 'list_id';

				$val = esc_attr( get_option( $option_name, '' ) );

				echo "<input name='{$option_name}' id='{$option_name}' value='{$val}' class='regular-text' type='text' />";

			},
			'reading',
			'default'
		);

		register_setting( 'reading', self::$option_prefix . 'list_id', [ 'sanitize_callback' => [ $this, 'sanitize' ] ] );

	}

	public function sanitize( $val ) {

		if ( is_string( $val ) ) {
			return trim( $val );
		}

		return '';
	}

}