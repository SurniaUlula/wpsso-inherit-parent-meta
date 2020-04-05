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
					'version'     => '2.2.0-b.1',	// Plugin version.
					'opt_version' => '1',		// Increment when changing default option values.
					'short'       => 'WPSSO IPM',	// Short plugin name.
					'name'        => 'WPSSO Inherit Parent Metadata',
					'desc'        => 'Inherit featured and custom images from parents for posts, pages, custom post types, categories, tags, and custom taxonomies.',
					'slug'        => 'wpsso-inherit-parent-meta',
					'base'        => 'wpsso-inherit-parent-meta/wpsso-inherit-parent-meta.php',
					'update_auth' => '',		// No premium version.
					'text_domain' => 'wpsso-inherit-parent-meta',
					'domain_path' => '/languages',

					/**
					 * Required plugin and its version.
					 */
					'req' => array(
						'wpsso' => array(
							'class'       => 'Wpsso',
							'name'        => 'WPSSO Core',
							'min_version' => '6.28.0-b.1',
						),
					),

					/**
					 * URLs or relative paths to plugin banners and icons.
					 */
					'assets' => array(
						'icons' => array(
							'low'  => 'images/icon-128x128.png',
							'high' => 'images/icon-256x256.png',
						),
					),

					/**
					 * Library files loaded and instantiated by WPSSO.
					 */
					'lib' => array(
						'pro' => array(
						),
						'std' => array(
						),
					),
				),
			),
			'form' => array(
				'ipm_inherit' => array(

					/**
					 * Open Graph - Priority Image.
					 */
					'og_img_max'        => null,
					'og_img_id'         => null,
					'og_img_id_pre'     => null,
					'og_img_url'        => null,

					/**
					 * Twitter Card.
					 */
					'tc_lrg_img_id'     => null,
					'tc_lrg_img_id_pre' => null,
					'tc_lrg_img_url'    => null,
					'tc_sum_img_id'     => null,
					'tc_sum_img_id_pre' => null,
					'tc_sum_img_url'    => null,

					/**
					 * Schema JSON-LD Markup / Rich Results.
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

		public static function set_constants( $plugin_file_path ) { 

			if ( defined( 'WPSSOIPM_VERSION' ) ) {	// Define constants only once.
				return;
			}

			$info =& self::$cf[ 'plugin' ][ 'wpssoipm' ];

			/**
			 * Define fixed constants.
			 */
			define( 'WPSSOIPM_FILEPATH', $plugin_file_path );						
			define( 'WPSSOIPM_PLUGINBASE', $info[ 'base' ] );	// Example: wpsso-inherit-parent-meta/wpsso-inherit-parent-meta.php.
			define( 'WPSSOIPM_PLUGINDIR', trailingslashit( realpath( dirname( $plugin_file_path ) ) ) );
			define( 'WPSSOIPM_PLUGINSLUG', $info[ 'slug' ] );	// Example: wpsso-inherit-parent-meta.
			define( 'WPSSOIPM_URLPATH', trailingslashit( plugins_url( '', $plugin_file_path ) ) );
			define( 'WPSSOIPM_VERSION', $info[ 'version' ] );						
		}

		public static function require_libs( $plugin_file_path ) {

			require_once WPSSOIPM_PLUGINDIR . 'lib/filters.php';
			require_once WPSSOIPM_PLUGINDIR . 'lib/register.php';

			add_filter( 'wpssoipm_load_lib', array( 'WpssoIpmConfig', 'load_lib' ), 10, 3 );
		}

		public static function load_lib( $ret = false, $filespec = '', $classname = '' ) {

			if ( false === $ret && ! empty( $filespec ) ) {

				$file_path = WPSSOIPM_PLUGINDIR . 'lib/' . $filespec . '.php';

				if ( file_exists( $file_path ) ) {

					require_once $file_path;

					if ( empty( $classname ) ) {
						return SucomUtil::sanitize_classname( 'wpssoipm' . $filespec, $allow_underscore = false );
					} else {
						return $classname;
					}
				}
			}

			return $ret;
		}
	}
}
