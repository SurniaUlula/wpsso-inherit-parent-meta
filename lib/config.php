<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2016-2020 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoIpmConfig' ) ) {

	class WpssoIpmConfig {

		public static $cf = array(
			'plugin' => array(
				'wpssoipm' => array(			// Plugin acronym.
					'version'     => '3.4.0-dev.1',	// Plugin version.
					'opt_version' => '1',		// Increment when changing default option values.
					'short'       => 'WPSSO IPM',	// Short plugin name.
					'name'        => 'WPSSO Inherit Parent Metadata',
					'desc'        => 'Inherit the Featured and Custom Images from Parents for Posts, Pages, Custom Post Types, Categories, Tags, and Custom Taxonomies.',
					'slug'        => 'wpsso-inherit-parent-meta',
					'base'        => 'wpsso-inherit-parent-meta/wpsso-inherit-parent-meta.php',
					'update_auth' => '',		// No premium version.
					'text_domain' => 'wpsso-inherit-parent-meta',
					'domain_path' => '/languages',

					/**
					 * Required plugin and its version.
					 */
					'req' => array(
						'wp' => array(
							'name'           => 'WordPress',
							'home'           => 'https://wordpress.org/',
							'version_global' => 'wp_version',
							'min_version'    => '4.7.0',
						),
						'wpsso' => array(
							'name'          => 'WPSSO Core',
							'home'          => 'https://wordpress.org/plugins/wpsso/',
							'plugin_class'  => 'Wpsso',
							'version_const' => 'WPSSO_VERSION',
							'min_version'   => '8.8.0-dev.1',
						),
					),

					/**
					 * URLs or relative paths to plugin banners and icons.
					 *
					 * Icon image array keys are '1x' and '2x'.
					 */
					'assets' => array(
						'icons' => array(
							'1x' => 'images/icon-128x128.png',
							'2x' => 'images/icon-256x256.png',
						),
					),

					/**
					 * Library files loaded and instantiated by WPSSO.
					 */
					'lib' => array(
					),
				),
			),
			'form' => array(
				'ipm_inherit' => array(

					/**
					 * Open Graph.
					 */
					'og_img_max'    => null,
					'og_img_id'     => null,
					'og_img_id_pre' => null,
					'og_img_url'    => null,

					/**
					 * Pinterest.
					 */
					'p_img_id'     => null,
					'p_img_id_pre' => null,
					'p_img_url'    => null,

					/**
					 * Twitter Cards.
					 */
					'tc_lrg_img_id'     => null,
					'tc_lrg_img_id_pre' => null,
					'tc_lrg_img_url'    => null,

					'tc_sum_img_id'     => null,
					'tc_sum_img_id_pre' => null,
					'tc_sum_img_url'    => null,

					/**
					 * Schema JSON-LD Markup / Google Rich Results.
					 */
					'schema_img_max'    => null,
					'schema_img_id'     => null,
					'schema_img_id_pre' => null,
					'schema_img_url'    => null,
				),
			),
		);

		public static function get_version( $add_slug = false ) {

			$info =& self::$cf[ 'plugin' ][ 'wpssoipm' ];

			return $add_slug ? $info[ 'slug' ] . '-' . $info[ 'version' ] : $info[ 'version' ];
		}

		public static function set_constants( $plugin_file ) { 

			if ( defined( 'WPSSOIPM_VERSION' ) ) {	// Define constants only once.

				return;
			}

			$info =& self::$cf[ 'plugin' ][ 'wpssoipm' ];

			/**
			 * Define fixed constants.
			 */
			define( 'WPSSOIPM_FILEPATH', $plugin_file );						
			define( 'WPSSOIPM_PLUGINBASE', $info[ 'base' ] );	// Example: wpsso-inherit-parent-meta/wpsso-inherit-parent-meta.php.
			define( 'WPSSOIPM_PLUGINDIR', trailingslashit( realpath( dirname( $plugin_file ) ) ) );
			define( 'WPSSOIPM_PLUGINSLUG', $info[ 'slug' ] );	// Example: wpsso-inherit-parent-meta.
			define( 'WPSSOIPM_URLPATH', trailingslashit( plugins_url( '', $plugin_file ) ) );
			define( 'WPSSOIPM_VERSION', $info[ 'version' ] );						

			/**
			 * Define variable constants.
			 */
			self::set_variable_constants();
		}

		public static function set_variable_constants( $var_const = null ) {

			if ( ! is_array( $var_const ) ) {

				$var_const = (array) self::get_variable_constants();
			}

			/**
			 * Define the variable constants, if not already defined.
			 */
			foreach ( $var_const as $name => $value ) {

				if ( ! defined( $name ) ) {

					define( $name, $value );
				}
			}
		}

		public static function get_variable_constants() {

			$var_const = array();

			$var_const[ 'WPSSOIPM_POST_METADATA_KEYS' ] = array( '_thumbnail_id' );						

			/**
			 * Maybe override the default constant value with a pre-defined constant value.
			 */
			foreach ( $var_const as $name => $value ) {

				if ( defined( $name ) ) {

					$var_const[$name] = constant( $name );
				}
			}

			return $var_const;
		}

		public static function require_libs( $plugin_file ) {

			require_once WPSSOIPM_PLUGINDIR . 'lib/filters.php';
			require_once WPSSOIPM_PLUGINDIR . 'lib/register.php';

			add_filter( 'wpssoipm_load_lib', array( 'WpssoIpmConfig', 'load_lib' ), 10, 3 );
		}

		public static function load_lib( $success = false, $filespec = '', $classname = '' ) {

			if ( false === $success && ! empty( $filespec ) ) {

				$file_path = WPSSOIPM_PLUGINDIR . 'lib/' . $filespec . '.php';

				if ( file_exists( $file_path ) ) {

					require_once $file_path;

					if ( empty( $classname ) ) {

						return SucomUtil::sanitize_classname( 'wpssoipm' . $filespec, $allow_underscore = false );

					}

					return $classname;
				}
			}

			return $success;
		}
	}
}
