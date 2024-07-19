<?php
/**
 * Admin
 *
 * @package Adminscript
 */

namespace Nilambar\Adminscript\Admin;

/**
 * Admin class.
 *
 * @since 1.0.0
 */
class Admin {

	/**
	 * Register.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_filter( 'plugin_action_links_' . ADMINSCRIPT_BASE_FILENAME, [ $this, 'plugin_links' ] );
	}

	/**
	 * Customize plugin action links.
	 *
	 * @since 1.0.0
	 *
	 * @param array $actions Action links.
	 * @return array Modified action links.
	 */
	public function plugin_links( $actions ) {
		$url = add_query_arg(
			[
				'page' => 'adminscript',
			],
			admin_url( 'options-general.php' )
		);

		$actions = array_merge(
			[
				'welcome' => '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Admin JS', 'adminscript' ) . '</a>',
			],
			$actions
		);

		return $actions;
	}
}
