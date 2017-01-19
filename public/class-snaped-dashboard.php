<?php
/**
 * @package   CARES_SnapEd_Dashboard
 * @author    AuthorName
 * @license   GPL-2.0+
 * @link      http://www.communitycommons.org
 * @copyright 2016 Community Commons
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `admin/class-cares_ol-admin.php`
 *
 *
 * @package CARES_SnapEd_Dashboard
 * @author  AuthorName
 */
class CARES_SnapEd_Dashboard {

	/**
	 *
	 * The current version of the plugin.
	 *
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $version = '1.0.0';

	/**
	 *
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'cares-snaped-dashboard';

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	public function __construct() {

		$this->version = csed_get_plugin_version();
	}

	public function add_hooks() {
		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );
	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return   string Plugin slug.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {
		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles_scripts() {
		// Styles
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'css/public.css', __FILE__ ), array(), $this->version );

		// IE specific
		// global $wp_styles;
		// wp_enqueue_style( $this->plugin_slug . '-ie-plugin-styles', plugins_url( 'css/public-ie.css', __FILE__ ), array(), $this->version );
		// $wp_styles->add_data( $this->plugin_slug . '-ie-plugin-styles', 'conditional', 'lte IE 9' );

		// Scripts
		if ( is_page( 'dashboard' ) ) {
			// wp_enqueue_script( 'd3-js-v3', 'https://d3js.org/d3.v3.min.js', array(), '3.5.17' );
			wp_enqueue_script( 'd3-js-v4', 'https://d3js.org/d3.v4.min.js', array(), '4.4.0' );
		}

		// Enqueue Chosen.js library.
		// wp_enqueue_style( 'openlayers-styles', 'https://openlayers.org/en/v3.19.1/css/ol.css', array(), '3.19.1' );
		// wp_enqueue_script( 'openlayers-script', 'https://openlayers.org/en/v3.19.1/build/ol.js', array(), '3.19.1' );
	}

}
