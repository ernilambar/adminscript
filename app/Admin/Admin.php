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
		add_filter( 'plugin_action_links_' . ADMINSCRIPT_BASE_FILENAME, [ $this, 'plugin_links' ] );
	}


	public function options_page() {
		add_options_page(
			'Adminscript',
			'Adminscript',
			'manage_options',
			'adminscript',
			[ $this, 'render_page' ]
		);
	}

	public function register_options() {
		register_setting( 'adminscript', 'adminscript_options' );

		add_settings_section(
			'adminscript_section_general',
			'',
			function () {},
			'adminscript'
		);

		add_settings_field(
			'code',
			__( 'Code', 'adminscript' ),
			[ $this, 'cb_field_code' ],
			'adminscript',
			'adminscript_section_general',
			[
				'label_for'               => 'code',
				'class'                   => 'adminscript_row',
				'adminscript_custom_data' => 'custom',
			]
		);
	}

	public function cb_field_code( $args ) {
		$options = get_option( 'adminscript_options' );

		$code = '';

		if ( is_array( $options ) && array_key_exists( 'code', $options ) ) {
			$code = $options['code'];
		}
		?>
		<textarea name="adminscript_options[<?php echo esc_attr( $args['label_for'] ); ?>]" id="<?php echo esc_attr( $args['label_for'] ); ?>"><?php echo esc_textarea( $code ); ?></textarea>
		<?php
	}

	public function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( 'adminscript_messages', 'adminscript_message', __( 'Settings Saved', 'adminscript' ), 'updated' );
		}

		settings_errors( 'adminscript_messages' );
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

		wp_enqueue_script( 'adminscript-code', ADMINSCRIPT_URL . '/build/admin.js', [ 'jquery', 'code-editor' ], ADMINSCRIPT_VERSION, true );
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
