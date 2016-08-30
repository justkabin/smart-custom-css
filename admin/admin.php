<?php
/**
 * Custom CSS setting.
 */

/**
 * Add the custom css menu to the admin menu.
 */
function smc_custom_css_menu() {

	// Add Custom CSS menu under the Appearance.
	$setting = add_theme_page(
		__( 'Smart Custom CSS', 'smart-custom-css' ),
		__( 'Custom CSS', 'smart-custom-css' ),
		'edit_theme_options',
		'smart-custom-css',
		'smc_custom_css_page'
	);

	if ( ! $setting )
		return;

	// Provided hook_suffix that's returned to add scripts only on custom css page.
    add_action( 'load-' . $setting, 'smc_scripts' );

}
add_action( 'admin_menu', 'smc_custom_css_menu', 20 );

/**
 * Load scripts and styles for the custom css page.
 */
function smc_scripts() {

	// Load the javascript file.
	wp_enqueue_script( 'codemirror-js', trailingslashit( SMC_ASSETS ) . 'js/codemirror.js', array( 'jquery' ), null );

	// Load the custom javascript file.
	wp_enqueue_script( 'smart-custom-css-js', trailingslashit( SMC_ASSETS ) . 'js/smart-custom-css.js', array( 'jquery' ), null );

	// Load the css file.
	wp_enqueue_style( 'codemirror-css', trailingslashit( SMC_ASSETS ) . 'css/codemirror.css', null, null );
	wp_enqueue_style( 'smart-custom-css-css', trailingslashit( SMC_ASSETS ) . 'css/smart-custom-css.css', null, null );

}

/**
 * Register the custom css setting.
 */
function smc_register_setting() {

	register_setting(
		'smc_custom_css',                 // Option group
		'smc_custom_css',                 // Option name
		'smc_custom_css_setting_validate' // Sanitize callback
	);

}
add_action( 'admin_init', 'smc_register_setting' );

/**
 * Render the custom CSS page
 */
function smc_custom_css_page() {
	$options    = get_option( 'smc_custom_css' );
	$custom_css = isset( $options['custom_css'] ) ? $options['custom_css'] : '';
	$custom_css = wp_kses( $custom_css, array( '\'', '\"', '>', '+' ) );
	?>

	<div class="wrap">

		<h2><?php esc_html_e( 'Smart Custom CSS', 'smart-custom-css' ) ?></h2>

		<?php settings_errors(); ?>

		<div id="post-body" class="smc-custom-css metabox-holder columns-2">

			<div id="post-body-content">

				<form action="options.php" method="post">

					<?php settings_fields( 'smc_custom_css' ); ?>

					<div class="smc-custom-css-container">
						<textarea name="smc_custom_css[custom_css]" id="smc-custom-css-textarea"><?php echo $custom_css; ?></textarea>
					</div>

					<?php submit_button( esc_attr__( 'Save CSS', 'smart-custom-css' ), 'primary large' ); ?>

				</form>

			</div><!-- .post-body-content -->

			<div id="postbox-container-1" class="postbox-container">
				<div>

					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Spesific Post or Page', 'smart-custom-css' ); ?></span></h3>
						<div class="inside">
							<p><?php _e( 'If you need to add custom CSS to a spesific post or page, just go to the edit post or page admin screen, you will see the Custom CSS metabox under the Editor.', 'smart-custom-css' ); ?></p>
						</div>
					</div>

					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Live Preview', 'smart-custom-css' ); ?></span></h3>
						<div class="inside">
							<p><?php printf( __( 'Please go to the %1$sCustomize%2$s page and open the Custom CSS section.', 'smart-custom-css' ), '<a href="' . esc_url( admin_url( 'customize.php?autofocus[control]=smc_custom_css' ) ) . '">', '</a>' ); ?></p>
						</div>
					</div>

				</div>
			</div><!-- .postbox-container -->

		</div><!-- .smc-custom-css -->

	</div>
	<?php
}

/**
 * Sanitize and validate form input.
 */
function smc_custom_css_setting_validate( $input ) {
	$input['custom_css'] = wp_kses( $input['custom_css'], array( '\'', '\"', '>', '+' ) );
	return $input;
}
