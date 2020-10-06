<?php
/**
 * Plugin Name: WPSSO Inherit Parent Metadata
 * Plugin Slug: wpsso-inherit-parent-meta
 * Text Domain: wpsso-inherit-parent-meta
 * Domain Path: /languages
 * Plugin URI: https://wpsso.com/extend/plugins/wpsso-inherit-parent-meta/
 * Assets URI: https://surniaulula.github.io/wpsso-inherit-parent-meta/assets/
 * Author: JS Morisset
 * Author URI: https://wpsso.com/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Description: Inherit the Featured and Custom Images from Parents for Posts, Pages, Custom Post Types, Categories, Tags, and Custom Taxonomies.
 * Requires PHP: 5.6
 * Requires At Least: 4.7
 * Tested Up To: 5.5.1
 * Version: 3.4.0-dev.1
 * 
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *      {major}         Major structural code changes / re-writes or incompatible API changes.
 *      {minor}         New functionality was added or improved in a backwards-compatible manner.
 *      {bugfix}        Backwards-compatible bug fixes or small improvements.
 *      {stage}.{level} Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 * 
 * Copyright 2016-2020 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'SucomAddOn' ) ) {

	require_once dirname( __FILE__ ) . '/lib/abstracts/com/add-on.php';	// SucomAddOn class.
}

if ( ! class_exists( 'WpssoIpm' ) ) {

	class WpssoIpm extends SucomAddOn {

		/**
		 * Library class object variables.
		 */
		public $filters;	// WpssoIpmFilters class.
		public $reg;		// WpssoIpmRegister class.

		/**
		 * Reference Variables (config, options, modules, etc.).
		 */
		protected $p;
		protected $ext   = 'wpssoipm';
		protected $p_ext = 'ipm';
		protected $cf    = array();

		private static $instance = null;

		public function __construct() {

			require_once dirname( __FILE__ ) . '/lib/config.php';

			WpssoIpmConfig::set_constants( __FILE__ );

			WpssoIpmConfig::require_libs( __FILE__ );	// Includes the register.php class library.

			$this->cf =& WpssoIpmConfig::$cf;

			$this->reg = new WpssoIpmRegister();		// Activate, deactivate, uninstall hooks.

			/**
			 * WPSSO filter hooks.
			 */
			add_filter( 'wpsso_get_config', array( $this, 'get_config' ), 10, 1 );
			add_filter( 'wpsso_get_avail', array( $this, 'get_avail' ), 10, 1 );

			/**
			 * WPSSO action hooks.
			 */
			add_action( 'wpsso_init_textdomain', array( $this, 'init_textdomain' ), 10, 1 );
			add_action( 'wpsso_init_objects', array( $this, 'init_objects' ), 10, 0 );
			add_action( 'wpsso_init_plugin', array( $this, 'init_missing_requirements' ), 10, 2 );

			/**
			 * WordPress action hooks.
			 */
			add_action( 'all_admin_notices', array( $this, 'show_missing_requirements' ) );
		}

		public static function &get_instance() {

			if ( null === self::$instance ) {

				self::$instance = new self;
			}

			return self::$instance;
		}

		public function init_textdomain( $debug_enabled = false ) {

			static $local_cache = null;

			if ( null === $local_cache || $debug_enabled ) {

				$local_cache = 'wpsso-inherit-parent-meta';

				load_plugin_textdomain( 'wpsso-inherit-parent-meta', false, 'wpsso-inherit-parent-meta/languages/' );
			}

			return $local_cache;
		}

		public function init_objects() {

			$this->p =& Wpsso::get_instance();

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			if ( $this->get_missing_requirements() ) {	// Returns false or an array of missing requirements.

				return;	// Stop here.
			}

			$this->filters = new WpssoIpmFilters( $this->p );
		}
	}

	WpssoIpm::get_instance();
}
