<?php
/**
 * Custom css metabox for post & page
 */

/**
 * Registers new meta box.
 */
function smc_add_meta_boxes() {

	add_meta_box(
		'smc-custom-css-metabox',
		__( 'Custom CSS', 'smart-custom-css' ),
		'smc_metabox_display',
		array( 'post', 'page' ),
		'normal',
		'default'
	);

}
add_action( 'add_meta_boxes', 'smc_add_meta_boxes' );

/**
 * Register style & script
 */
function smc_metabox_scripts( $hook_suffix ) {
	if( 'post.php' == $hook_suffix || 'post-new.php' == $hook_suffix ) {

		// Load the javascript file.
		wp_enqueue_script( 'codemirror-js', trailingslashit( SMC_ASSETS ) . 'js/codemirror.js', array( 'jquery' ), null );

		// Load the custom javascript file.
		wp_enqueue_script( 'smart-custom-css-js', trailingslashit( SMC_ASSETS ) . 'js/smart-custom-css.js', array( 'jquery' ), null );

		// Load the css file.
		wp_enqueue_style( 'codemirror-css', trailingslashit( SMC_ASSETS ) . 'css/codemirror.css', null, null );
		wp_enqueue_style( 'smart-custom-css-metabox-css', trailingslashit( SMC_ASSETS ) . 'css/smart-custom-css-metabox.css', null, null );

	}
}
add_action( 'admin_enqueue_scripts', 'smc_metabox_scripts' );

/**
 * Displays the content of the meta box.
 */
function smc_metabox_display( $post ) {

	wp_nonce_field( basename( __FILE__ ), 'smc-metabox-custom-css-nonce' ); ?>

	<label for="smc-custom-css-textarea" class="screen-reader-text"><?php _e( 'Custom CSS', 'smart-custom-css' ) ?></label>
	<textarea rows="1" cols="40" name="smc-custom-css-textarea" id="smc-custom-css-textarea"><?php echo get_post_meta( $post->ID, '_smc_post_type_custom_css', true ); ?></textarea>

	<?php
}

/**
 * Saves the metadata/
 */
function smc_metabox_save( $post_id, $post ) {

	if ( ! isset( $_POST['smc-metabox-custom-css-nonce'] ) || ! wp_verify_nonce( $_POST['smc-metabox-custom-css-nonce'], basename( __FILE__ ) ) )
		return;

	if ( ! current_user_can( 'edit_post', $post_id ) )
		return;

	$meta = array(
		'_smc_post_type_custom_css' => wp_kses( $_POST['smc-custom-css-textarea'], array( '\'', '\"', '>', '+' ) )
	);

	foreach ( $meta as $meta_key => $new_meta_value ) {

		// Get the meta value of the custom field key.
		$meta_value = get_post_meta( $post_id, $meta_key, true );

		// If there is no new meta value but an old value exists, delete it.
		if ( current_user_can( 'delete_post_meta', $post_id, $meta_key ) && '' == $new_meta_value && $meta_value )
			delete_post_meta( $post_id, $meta_key, $meta_value );

		// If a new meta value was added and there was no previous value, add it.
		elseif ( current_user_can( 'add_post_meta', $post_id, $meta_key ) && $new_meta_value && '' == $meta_value )
			add_post_meta( $post_id, $meta_key, $new_meta_value, true );

		// If the new meta value does not match the old value, update it.
		elseif ( current_user_can( 'edit_post_meta', $post_id, $meta_key ) && $new_meta_value && $new_meta_value != $meta_value )
			update_post_meta( $post_id, $meta_key, $new_meta_value );
	}

}
add_action( 'save_post', 'smc_metabox_save', 10, 2 );
