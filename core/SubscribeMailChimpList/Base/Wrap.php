<?php

namespace SubscribeMailChimpList\Base;
class Wrap {
	public $version = '1.0.0';
	public $css_patch = "public/css/";
	public $js_patch = "public/js/";

	private $defaults_vars = [
		'css_patch' => "public/css/",
		'js_patch'  => "public/js/",
		'version'   => "1.0.0",
		'min'       => true
	];

	/**
	 * @param $name
	 *
	 * @return mixed|null|string
	 */
	public function __get( $name ) {

		if ( $name == 'base_name' ) {
			return $this->basename_helper();
		}

		if ( $name == 'space' ) {
			return $this->basename_helper();
		}

		if ( $name == 'prefix' ) {
			return '_' . $this->basename_helper();

		}

		if ( $name == 'plugin_path' ) {
			return $this->plugin_dir();
		}

		if ( $name == 'plugin_url' ) {
			return $this->url();
		}

		if ( $name == 'plugin_text_domain' ) {
			return $this->get_text_domain();
		}

		if ( array_key_exists( $name, $this->defaults_vars ) ) {
			return $this->defaults_vars[ $name ];
		}

		return null;
	}

	/**
	 * @return string
	 */
	public function basename_helper() {
		$array = explode( '\\', __NAMESPACE__ );
		$id    = array_shift( $array );

		return $id;
	}

	/**
	 * @return string
	 */
	public function plugin_dir() {
		$string = plugin_basename( __FILE__ );
		$array  = explode( '/', $string );
		$path   = array_shift( $array );

		return WP_PLUGIN_DIR . '/' . $path . '/';
	}

	/**
	 * @return string
	 */
	public function url() {
		$plugins    = trailingslashit( plugins_url() );
		$plugin     = plugin_dir_url( __FILE__ );
		$plugin     = preg_replace( "#/$#", "", $plugin );
		$path_array = str_replace( $plugins, '', $plugin );
		$array      = explode( '/', $path_array );
		$path       = array_shift( $array );

		return trailingslashit( $plugins . $path );
	}


	/**
	 * @param string $val
	 *
	 * @return $this
	 */
	public function setVersion( $val ) {
		$this->version = $val;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_text_domain() {
		$string = plugin_basename( __FILE__ );
		$array  = explode( '/', $string );
		$path   = array_shift( $array );

		return $path;
	}

	/**
	 *
	 * @return bool True on success, false on failure.
	 */
	function setTextdomain( $domine = false ) {
		if ( ! $domine ) {
			$domine = $this->base_name;
		}

		load_textdomain( $domine, $this->plugin_path . "languages/{$this->plugin_text_domain}-" . get_locale() . '.mo' );

		return $domine;
	}


}