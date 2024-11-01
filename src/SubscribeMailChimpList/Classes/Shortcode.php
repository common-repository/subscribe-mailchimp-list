<?php

namespace SubscribeMailChimpList\Classes;

use SubscribeMailChimpList\Utils\ActivateShortcode;
use SubscribeMailChimpList\Utils\Assets;

class Shortcode extends ActivateShortcode {
	use Assets;

	protected $js = false;
	protected $css = true;


	function base( $attrs, $content, $tag ) {

		$filter_code = apply_filters( 'SubscribeMailChimpList__shortcode-content', $attrs );

		$code = "<div class='SubscribeMailChimpList__form-shortcode'>{$filter_code}</div>";

		return str_replace(
			[ "\r", "\n" ],
			'',
			$code

		);

	}

}