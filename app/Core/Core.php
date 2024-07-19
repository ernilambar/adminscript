<?php
/**
 * Core
 *
 * @package Adminscript
 */

namespace Nilambar\Adminscript\Core;

/**
 * Core class.
 *
 * @since 1.0.0
 */
class Core {

	/**
	 * Register.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_action( 'plugins_loaded', [ $this, 'load_textdomain' ] );
	}

	/**
	 * Load plugin textdomain.
	 *
	 * @since 1.0.0
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'adminscript' );
	}
}
