<?php

namespace SubscribeMailChimpList\Utils;

abstract class ActivateShortcode {
	use Assets;
	protected $js = false;
	protected $css = false;

	private $attrs = [];

	/**
	 * ActivateShortcode constructor.
	 *
	 * @param $tag
	 * @param bool $attrs
	 */
	public function __construct( $tag, $attrs = false ) {
		if ( $attrs !== false ) {
			$this->attrs = $attrs;
		}

		add_action( "shortcode_added__" . $tag, function () use ( $tag ) {
			add_shortcode( $tag, [ $this, 'wrap' ] );
			$this->assets( $tag );
		} );

		add_action( 'template_redirect', function () use ( $tag ) {
			do_action( "shortcode_added__" . $tag );
		} );

		if ( method_exists( $this, 'init' ) ) {
			$this->init( $tag, $attrs );
		}

	}

	/**
	 * @param $tag
	 */
	protected function assets( $tag ) {
		global $wp_query;
		if ( is_singular() && is_object( $wp_query->post ) && has_shortcode( $wp_query->post->post_content, $tag ) ) {
			if ( $this->js ) {
				$this->addJs( $tag );
			}
			if ( $this->css ) {
				d( $this->addCss( $tag ) );
			}
		}
	}

	/**
	 * @param array $attrs
	 * @param string $content
	 * @param string $tag
	 *
	 * @return mixed
	 */
	public function wrap( $attrs, $content, $tag ) {
		$content = $this->attr_checker( $content );
		$tag     = $this->attr_checker( $tag );

		if ( count( $this->attrs ) > 0 ) {
			$attrs = shortcode_atts( $this->attrs, $attrs );
		}

		return $this->base( $attrs, $content, $tag );
	}

	/**
	 * @param string $val
	 *
	 * @return bool|string
	 */
	private function attr_checker( $val ) {
		if ( $val == '' ) {
			return false;
		}

		return $val;
	}

	/**
	 * @param $attrs
	 * @param $content
	 * @param $tag
	 *
	 * @return string
	 */
	abstract function base( $attrs, $content, $tag );

	/**
	 * @param $string
	 *
	 * @return string
	 */
	protected function trim_carriage_return( $string ) {
		$string =  str_replace( [ "\r", "\n" ], '', $string );

		return strval($string);
	}

}
