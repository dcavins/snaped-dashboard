<?php
/**
 * Extras for the MoCWP hub.
 *
 * @package   CARES_SnapEd_Dashboard
 * @author    AuthorName
 * @license   GPL-2.0+
 * @link      http://www.communitycommons.org
 * @copyright 2016 Community Commons
 *
 * @wordpress-plugin
 * Plugin Name:       CARES SnapEd Dashboard
 * Plugin URI:        @TODO
 * Description:       Adds custom hub functionality to CC site
 * Version:           1.0.0
 * Author:            AuthorName
 * Text Domain:       cares-snaped-dashboard
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: https://github.com/careshub/cares-openlayers
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

function csed_class_init() {

	// Helper functions
	require_once( plugin_dir_path( __FILE__ ) . 'includes/snaped-dashboard-functions.php' );

	// Template output functions
	require_once( plugin_dir_path( __FILE__ ) . 'public/views/template-tags.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'public/views/shortcodes.php' );

	// The main class
	require_once( plugin_dir_path( __FILE__ ) . 'public/class-snaped-dashboard.php' );
	$class_public = new CARES_SnapEd_Dashboard();
	$class_public->add_hooks();

	// Admin and dashboard functionality
	if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
		require_once( plugin_dir_path( __FILE__ ) . 'admin/class-snaped-dashboard-admin.php' );
		$class_admin = new CARES_SnapEd_Dashboard_Admin();
		$class_admin->add_hooks();
	}

}
add_action( 'init', 'csed_class_init' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 */
// require_once plugin_dir_path( __FILE__ ) . 'includes/class-openlayers-activator.php';
// register_activation_hook( __FILE__, array( 'CARES_OpenLayers_Activator', 'activate' ) );
// register_deactivation_hook( __FILE__, array( 'CARES_OpenLayers_Activator', 'deactivate' ) );

/*
 * Helper function.
 * @return Fully-qualified URI to the root of the plugin.
 */
function csed_get_plugin_base_uri(){
	return plugin_dir_url( __FILE__ );
}

/*
 * Helper function.
 * @TODO: Update this when you update the plugin's version above.
 *
 * @return string Current version of plugin.
 */
function csed_get_plugin_version(){
	return '1.0.0';
}
