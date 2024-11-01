<?php

namespace SubscribeMailChimpList\Classes;


use SubscribeMailChimpList\Utils\Ajax;
use SubscribeMailChimpList\Utils\Assets;

class AjaxHandle extends Ajax {
	use Assets;

	public static $action_name = "MailChimpListAddMail";

	public static $form_action;

	/**
	 * AjaxOut2 constructor.
	 */
	function __construct() {
		parent::__construct( self::$action_name );

		self::$form_action = $this->ajax_url_action;

		$this->add_js_css( self::$action_name );
	}

	/**
	 * @param $name
	 */
	private function add_js_css( $name ) {
		if ( ! is_admin() ) {

			$handle = $this->addJs(
				$name,
				'wp_head',
				[ 'jquery' ]
			);

			$this->vars_ajax(
				$handle,
				[
					'action_name'     => self::$action_name,
					'ajax_url'        => $this->ajax_url,
					'ajax_url_action' => $this->ajax_url_action,
				]
			);

		}
	}

	/**
	 * @param string $request
	 */
	public function callback( $request ) {
		do_action( 'SubscribeMailChimpList__ajax-handle', $request );
	}
}