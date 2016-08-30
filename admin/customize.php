<?php
/**
 * Customizer setting.
 */

/**
 * Load textarea function for customizer.
 */
function smc_textarea_customize_control() {
	require_once( SMC_ADMIN . 'customize-control-textarea.php' );
}
add_action( 'customize_register', 'smc_textarea_customize_control', 1 );

/**
 * Register customizer.
 */
function smc_register_customize( $wp_customize ) {

	$wp_customize->add_section( 'smc_custom_css_section',
		array(
			'title'       => esc_html__( 'Custom CSS', 'smart-custom-css' ),
			'description' => esc_html__( 'Add your custom css code below.', 'smart-custom-css' ),
			'priority'    => 150,
		)
	);

	$wp_customize->add_setting( 'smc_custom_css[custom_css]' ,
		array(
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'wp_kses',
		)
	);

	$wp_customize->add_control( new Smc_Customize_Control_Textarea( $wp_customize, 'smc_custom_css',
		array(
			'label'    => '',
			'section'  => 'smc_custom_css_section',
			'settings' => 'smc_custom_css[custom_css]'
		)
	) );

}
add_action( 'customize_register', 'smc_register_customize' );
