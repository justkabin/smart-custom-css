<?php
/**
 * Uninstall procedure for the plugin.
 */

/* If uninstall not called from WordPress exit. */
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

/* Delete plugin settings. */
delete_option( 'smc_custom_css' );
