<?php

namespace SubscribeMailChimpList\Classes;


class MailChimpAjax {

	public $api_key;

	public $list_id;

	private $timeout = 35;

	private $respond_message = false;

	function __construct() {

		$this->api_key = get_option( Admin::$option_prefix . 'api_key' );
		$this->list_id = get_option( Admin::$option_prefix . 'list_id' );

		add_action( 'SubscribeMailChimpList__ajax-handle', [ $this, 'action' ] );

	}

	public function action() {

		$request = $_REQUEST;
		$request = array_map( 'trim', $request );
		unset( $request['action'] );


		if ( array_key_exists( 'email', $request ) && is_email( $request['email'] ) ) {

			if ( $this->subscribe( $request['email'] ) ) {
				wp_send_json_success( [
					'message'     => __( 'You have subscribed', 'SubscribeMailChimpList' ),
					'additional'  => $this->respond_message,
					'button_text' => __( 'Success', 'SubscribeMailChimpList' ),
				] );
			} else {

				if ( 400 == $this->respond_message ) {

					wp_send_json( [
						'message'    => __( 'Member Exists', 'SubscribeMailChimpList' ),
						'additional' => $this->respond_message,
					] );

				}

				wp_send_json_error( [
					'message'    => __( 'Send failed', 'SubscribeMailChimpList' ),
					'additional' => $this->respond_message
				] );

			}
		}

		wp_send_json_error( [
			'message' => __( 'Invalid Email', 'SubscribeMailChimpList' ),
		] );
	}

	private function subscribe( $email ) {

		$api_key = $this->api_key;
		$list_id = $this->list_id;

		$data = [
			'email_address' => $email,
			'status'        => 'subscribed',
			'merge_fields'  => [
				'EMAIL' => $email,
			]
		];

		$body = json_encode( $data );

		$opts        = [
			'headers'  => [
				'Content-Type'  => 'application/json',
				'Authorization' => 'apikey ' . $api_key

			],
			'blocking' => true,
			'timeout'  => $this->timeout,
			'body'     => $body
		];
		$apiKeyParts = explode( '-', $api_key );
		$shard       = $apiKeyParts[1];
		$url         = "https://{$shard}.api.mailchimp.com/3.0/lists/{$list_id}/members/";
		$response    = wp_remote_post( $url, $opts );


		if ( is_wp_error( $response ) ) {
			return false;
		}

		$this->respond_message = json_decode( wp_remote_retrieve_body( $response ), true );


		if ( $response['response']['code'] == 200 ) {
			return true;
		}

		return false;
	}

}
