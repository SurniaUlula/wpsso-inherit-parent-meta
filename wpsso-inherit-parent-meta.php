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
 * Version: 3.4.0-b.1
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

if ( ! class_exists( 'WpssoAddOn' ) ) {

	require_once dirname( __FILE__ ) . '/lib/abstracts/add-on.php';	// WpssoAddOn class.
}

if ( ! class_exists( 'WpssoIpm' ) ) {

	class WpssoIpm extends WpssoAddOn {

		public $filters;	// WpssoIpmFilters class.

		protected $p;

		private static $instance = null;

		public function __construct() {

			parent::__construct( __FILE__, __CLASS__ );
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
