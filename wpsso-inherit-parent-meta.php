<?php
/**
 * Plugin Name: WPSSO Inherit Parent Meta
 * Plugin Slug: wpsso-inherit-parent-meta
 * Text Domain: wpsso-inherit-parent-meta
 * Domain Path: /languages
 * Plugin URI: https://wpsso.com/extend/plugins/wpsso-inherit-parent-meta/
 * Assets URI: https://surniaulula.github.io/wpsso-inherit-parent-meta/assets/
 * Author: JS Morisset
 * Author URI: https://wpsso.com/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Description: Inherit featured and custom images from parents for posts, pages, custom post types, categories, tags, and custom taxonomies.
 * Requires At Least: 3.8
 * Tested Up To: 5.2.2
 * Version: 2.0.0
 * 
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *      {major}         Major structural code changes / re-writes or incompatible API changes.
 *      {minor}         New functionality was added or improved in a backwards-compatible manner.
 *      {bugfix}        Backwards-compatible bug fixes or small improvements.
 *      {stage}.{level} Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 * 
 * Copyright 2016-2019 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WpssoIpm' ) ) {

	class WpssoIpm {

		/**
		 * Wpsso plugin class object variable.
		 */
		public $p;		// Wpsso

		/**
		 * Library class object variables.
		 */
		public $filters;	// WpssoIpmFilters
		public $reg;		// WpssoIpmRegister

		/**
		 * Reference Variables (config, options, modules, etc.).
		 */
		private $have_req_min = true;	// Have minimum wpsso version.

		private static $instance;
		private static $wp_min_version = '4.7';

		public function __construct() {

			require_once ( dirname( __FILE__ ) . '/lib/config.php' );

			WpssoIpmConfig::set_constants( __FILE__ );
			WpssoIpmConfig::require_libs( __FILE__ );	// Includes the register.php class library.

			$this->reg = new WpssoIpmRegister();		// activate, deactivate, uninstall hooks

			if ( is_admin() ) {
				add_action( 'admin_init', array( __CLASS__, 'required_check' ) );
				add_action( 'admin_init', array( __CLASS__, 'check_wp_version' ) );	// Requires wp v4.7 or better.
			}

			/**
			 * Add WPSSO filter hooks.
			 */
			add_filter( 'wpsso_get_config', array( $this, 'wpsso_get_config' ), 10, 2 );	// Checks core version and merges config array.
			add_filter( 'wpsso_get_avail', array( $this, 'wpsso_get_avail' ), 10, 1 );

			/**
			 * Add WPSSO action hooks.
			 */
			add_action( 'wpsso_init_textdomain', array( __CLASS__, 'wpsso_init_textdomain' ) );
			add_action( 'wpsso_init_options', array( $this, 'wpsso_init_options' ), 10 );	// Sets the $this->p reference variable.
			add_action( 'wpsso_init_objects', array( $this, 'wpsso_init_objects' ), 10 );
			add_action( 'wpsso_init_plugin', array( $this, 'wpsso_init_plugin' ), 10 );
		}

		public static function &get_instance() {

			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		public static function required_check() {
			if ( ! class_exists( 'Wpsso' ) ) {
				add_action( 'all_admin_notices', array( __CLASS__, 'required_notice' ) );
			}
		}

		/**
		 * Also called from the activate_plugin method with $deactivate = true.
		 */
		public static function required_notice( $deactivate = false ) {

			self::wpsso_init_textdomain();

			$info = WpssoIpmConfig::$cf[ 'plugin' ][ 'wpssoipm' ];

			$die_msg = __( '%1$s is an add-on for the %2$s plugin &mdash; please install and activate the %3$s plugin before activating %4$s.', 'wpsso-inherit-parent-meta' );

			$error_msg = __( 'The %1$s add-on requires the %2$s plugin &mdash; install and activate the %3$s plugin or <a href="%4$s">deactivate the %5$s add-on</a>.', 'wpsso-inherit-parent-meta' );

			if ( true === $deactivate ) {

				if ( ! function_exists( 'deactivate_plugins' ) ) {
					require_once trailingslashit( ABSPATH ) . 'wp-admin/includes/plugin.php';
				}

				deactivate_plugins( $info[ 'base' ], true );	// $silent is true

				wp_die( '<p>' . sprintf( $die_msg, $info[ 'name' ], $info[ 'req' ][ 'name' ], $info[ 'req' ][ 'short' ], $info[ 'short' ] ) . '</p>' );

			} else {

				$deactivate_url = html_entity_decode( wp_nonce_url( add_query_arg( array(
					'action'        => 'deactivate',
					'plugin'        => $info[ 'base' ],
					'plugin_status' => 'all',
					'paged'         => 1,
					's'             => '',
				), admin_url( 'plugins.php' ) ), 'deactivate-plugin_' . $info[ 'base' ] ) );

				echo '<div class="notice notice-error error"><p>';
				echo sprintf( $error_msg, $info[ 'name' ], $info[ 'req' ][ 'name' ], $info[ 'req' ][ 'short' ], $deactivate_url, $info[ 'short' ] );
				echo '</p></div>';
			}
		}

		public static function check_wp_version() {

			global $wp_version;

			if ( version_compare( $wp_version, self::$wp_min_version, '<' ) ) {

				$plugin = plugin_basename( __FILE__ );

				if ( is_plugin_active( $plugin ) ) {

					self::wpsso_init_textdomain();

					if ( ! function_exists( 'deactivate_plugins' ) ) {
						require_once trailingslashit( ABSPATH ) . 'wp-admin/includes/plugin.php';
					}

					$plugin_data = get_plugin_data( __FILE__, false );	// $markup is false

					deactivate_plugins( $plugin, true );	// $silent is true

					wp_die( 
						'<p>' . sprintf( __( '%1$s requires %2$s version %3$s or higher and has been deactivated.',
							'wpsso-inherit-parent-meta' ), $plugin_data[ 'Name' ], 'WordPress', self::$wp_min_version ) . '</p>' . 
						'<p>' . sprintf( __( 'Please upgrade %1$s before trying to re-activate the %2$s plugin.',
							'wpsso-inherit-parent-meta' ), 'WordPress', $plugin_data[ 'Name' ] ) . '</p>'
					);
				}
			}
		}

		public static function wpsso_init_textdomain() {

			load_plugin_textdomain( 'wpsso-inherit-parent-meta', false, 'wpsso-inherit-parent-meta/languages/' );
		}

		/**
		 * Checks the core plugin version and merges the extension / add-on config array.
		 */
		public function wpsso_get_config( $cf, $plugin_version = 0 ) {

			$info = WpssoIpmConfig::$cf[ 'plugin' ][ 'wpssoipm' ];

			if ( version_compare( $plugin_version, $info[ 'req' ][ 'min_version' ], '<' ) ) {

				$this->have_req_min = false;

				return $cf;
			}

			return SucomUtil::array_merge_recursive_distinct( $cf, WpssoIpmConfig::$cf );
		}

		public function wpsso_get_avail( $avail ) {

			if ( ! $this->have_req_min ) {

				$avail[ 'p_ext' ][ 'ipm' ] = false;	// Signal that this extension / add-on is not available.

				return $avail;
			}

			$avail[ 'p_ext' ][ 'ipm' ] = true;		// Signal that this extension / add-on is available.

			return $avail;
		}

		/**
		 * Sets the $this->p reference variable for the core plugin instance.
		 */
		public function wpsso_init_options() {

			$this->p =& Wpsso::get_instance();

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}
		}

		public function wpsso_init_objects() {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( ! $this->have_req_min ) {
				return;	// Stop here.
			}

			$this->filters = new WpssoIpmFilters( $this->p );
		}

		public function wpsso_init_plugin() {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( ! $this->have_req_min ) {

				$this->min_version_notice();

				return;	// Stop here.
			}
		}

		private function min_version_notice() {

			$info = WpssoIpmConfig::$cf[ 'plugin' ][ 'wpssoipm' ];

			$error_msg = sprintf( __( 'The %1$s version %2$s add-on requires %3$s version %4$s or newer (version %5$s is currently installed).',
				'wpsso-inherit-parent-meta' ), $info[ 'name' ], $info[ 'version' ], $info[ 'req' ][ 'short' ], $info[ 'req' ][ 'min_version' ],
					$this->p->cf[ 'plugin' ][ 'wpsso' ][ 'version' ] );

			if ( is_admin() ) {

				$this->p->notice->err( $error_msg );

				if ( method_exists( $this->p->admin, 'get_check_for_updates_link' ) ) {
					$this->p->notice->inf( $this->p->admin->get_check_for_updates_link() );
				}
			}
		}
	}

	WpssoIpm::get_instance();
}
