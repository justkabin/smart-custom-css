<?php
/**
 * Custom functions needed by the plugin.
 */

/**
 * Global custom css.
 */
function smc_global_custom_css() {

	$option = get_option( 'smc_custom_css' );
	$output = isset( $option['custom_css'] ) ? $option['custom_css'] : '';
	$output = wp_kses( $output, array( '\'', '\"', '>', '+' ) );
	$output = str_replace( '&gt;', '>', $output );

	if ( $output ) {
		$css = '<!-- Global Custom CSS -->' . "\n";
		$css .= '<style>' . "\n";
		$css .= $output . "\n";
		$css .= '</style>' . "\n";
		$css .= '<!-- Generated by https://wordpress.org/plugins/smart-custom-css/ -->' . "\n";

		echo $css;
	}

}
add_action( 'wp_head', 'smc_global_custom_css', 20 );

/**
 * Post/page custom css
 */
function smc_post_type_custom_css() {
	global $post;

	if ( is_singular() ) {

		$option = get_post_meta( $post->ID, '_smc_post_type_custom_css', true );
		$output = isset( $option ) ? $option : '';
		$output = wp_kses( $output, array( '\'', '\"', '>', '+' ) );
		$output = str_replace( '&gt;', '>', $output );

		if ( $output ) {
			$css = '<!-- Custom CSS -->' . "\n";
			$css .= '<style>' . "\n";
			$css .= $output . "\n";
			$css .= '</style>' . "\n";
			$css .= '<!-- Generated by https://wordpress.org/plugins/smart-custom-css/ -->' . "\n";

			echo $css;
		}

	}

}
add_action( 'wp_head', 'smc_post_type_custom_css', 20 );