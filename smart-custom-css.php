<?php
/**
 * Plugin Name:  Smart Custom CSS
 * Plugin URI:   https://6hourcreative.com/plugins/smart-custom-css
 * Description:  Easily to add any custom css code to your site and your posts and pages.
 * Version:      1.0.0
 * Author:       6 Hour Creative
 * Author URI:   https://6hourcreative.com/
 * Author Email: hi@6hourcreative.com
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Smart_Custom_CSS {

	/**
	 * PHP5 constructor method.
	 */
	public function __construct() {

		// Set constant path to the plugin directory.
		add_action( 'plugins_loaded', array( &$this, 'constants' ), 1 );

		// Internationalize the text strings used.
		add_action( 'plugins_loaded', array( &$this, 'i18n' ), 2 );

		// Load the admin functions files.
		add_action( 'plugins_loaded', array( &$this, 'admin' ), 3 );

		// Load the admin functions files.
		add_action( 'plugins_loaded', array( &$this, 'includes' ), 4 );

	}

	/**
	 * Defines constants used by the plugin.
	 */
	public function constants() {

		// Set constant path to the plugin directory.
		define( 'SMC_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		// Set the constant path to the plugin directory URI.
		define( 'SMC_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

		// Set the constant path to the admin directory.
		define( 'SMC_ADMIN', SMC_DIR . trailingslashit( 'admin' ) );

		// Set the constant path to the inc directory.
		define( 'SMC_INC', SMC_DIR . trailingslashit( 'inc' ) );

		// Set the constant path to the assets directory.
		define( 'SMC_ASSETS', SMC_URI . trailingslashit( 'assets' ) );

	}

	/**
	 * Loads the translation files.
	 */
	public function i18n() {
		load_plugin_textdomain( 'smart-custom-css', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Loads the admin functions.
	 */
	public function admin() {
		require_once( SMC_ADMIN . 'admin.php' );
		require_once( SMC_ADMIN . 'customize.php' );
		require_once( SMC_ADMIN . 'metabox.php' );
	}

	/**
	 * Loads the initial files needed by the plugin.
	 */
	public function includes() {
		require_once( SMC_INC . 'functions.php' );
	}

}

new Smart_Custom_CSS;
