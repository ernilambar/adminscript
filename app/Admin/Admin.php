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
		add_action( 'admin_menu', [ $this, 'options_page' ] );
		add_action( 'admin_init', [ $this, 'register_options' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'load_assets' ] );
		add_action( 'admin_footer', [ $this, 'add_footer' ] );
		add_filter( 'plugin_action_links_' . ADMINSCRIPT_BASE_FILENAME, [ $this, 'plugin_links' ] );
	}

	/**
	 * Register options page.
	 *
	 * @since 1.0.0
	 */
	public function options_page() {
		add_options_page(
			'Adminscript',
			'Adminscript',
			'manage_options',
			'adminscript',
			[ $this, 'render_page' ]
		);
	}

	/**
	 * Register plugin options.
	 *
	 * @since 1.0.0
	 */
	public function register_options() {
		register_setting( 'adminscript', 'adminscript_options' );

		add_settings_section(
			'adminscript_section_general',
			'',
			function () {},
			'adminscript'
		);

		add_settings_field(
			'js_code',
			esc_html__( 'Code', 'adminscript' ),
			[ $this, 'cb_field_code' ],
			'adminscript',
			'adminscript_section_general',
			[
				'label_for' => 'js_code',
				'class'     => 'adminscript_js_code_row',
			]
		);
	}

	/**
	 * Code field callback.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Field arguments.
	 */
	public function cb_field_code( $args ) {
		$options = get_option( 'adminscript_options' );

		$code = '';

		if ( is_array( $options ) && array_key_exists( 'js_code', $options ) ) {
			$code = $options['js_code'];
		}
		?>
		<textarea name="adminscript_options[<?php echo esc_attr( $args['label_for'] ); ?>]" id="<?php echo esc_attr( $args['label_for'] ); ?>"><?php echo esc_textarea( $code ); ?></textarea>
		<?php
	}

	/**
	 * Render page.
	 *
	 * @since 1.0.0
	 */
	public function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap adminscript-wrap" id="adminscript-wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'adminscript' );
				do_settings_sections( 'adminscript' );
				submit_button( 'Save Settings' );
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Load assets.
	 *
	 * @since 1.0.0
	 *
	 * @param string $hook Hook name.
	 */
	public function load_assets( $hook ) {
		if ( 'settings_page_adminscript' !== $hook ) {
			return;
		}

		$ce_settings['javascript'] = wp_enqueue_code_editor( [ 'type' => 'javascript' ] );

		wp_localize_script( 'jquery', 'codeEditorSettings', $ce_settings );

		wp_enqueue_style( 'wp-codemirror' );

		wp_enqueue_style( 'adminscript-code', ADMINSCRIPT_URL . '/build/adminscript.css', [], ADMINSCRIPT_VERSION );
		wp_enqueue_script( 'adminscript-code', ADMINSCRIPT_URL . '/build/adminscript.js', [ 'jquery', 'code-editor' ], ADMINSCRIPT_VERSION, true );
	}

	/**
	 * Add JS to footer.
	 *
	 * @since 1.0.0
	 */
	public function add_footer() {
		$options = get_option( 'adminscript_options' );

		$code = '';

		if ( is_array( $options ) && array_key_exists( 'js_code', $options ) ) {
			$code = $options['js_code'];
		}

		if ( empty( $code ) ) {
			return;
		}
		?>
		<script type="text/javascript">
			( function ( $ ) {

				<?php echo $code; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

			} )( jQuery );
		</script>
		<?php
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
