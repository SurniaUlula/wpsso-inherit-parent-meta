<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2016-2018 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WpssoIpmConfig' ) ) {

	class WpssoIpmConfig {

		public static $cf = array(
			'plugin' => array(
				'wpssoipm' => array(			// Plugin acronym.
					'version'     => '1.0.0',	// Plugin version.
					'opt_version' => '1',		// Increment when changing default option values.
					'short'       => 'WPSSO IPM',	// Short plugin name.
					'name'        => 'WPSSO Inherit Parent Meta',
					'desc'        => 'WPSSO Core add-on to inherit the featured image and custom images from parents for posts, pages, custom post types, categories, tags, and custom taxonomies.',
					'slug'        => 'wpsso-inherit-parent-meta',
					'base'        => 'wpsso-inherit-parent-meta/wpsso-inherit-parent-meta.php',
					'update_auth' => '',
					'text_domain' => 'wpsso-inherit-parent-meta',
					'domain_path' => '/languages',
					'req' => array(
						'short'       => 'WPSSO Core',
						'name'        => 'WPSSO Core',
						'min_version' => '4.7.1-b.1',
					),
					'img' => array(
						'icons' => array(
							'low'  => 'images/icon-128x128.png',
							'high' => 'images/icon-256x256.png',
						),
					),
					'lib' => array(
						'gpl' => array(
						),
						'pro' => array(
						),
					),
				),
			),
			'form' => array(
				'ipm_inherit' => array(
					'og_img_max'        => null,
					'og_img_width'      => null,
					'og_img_height'     => null,
					'og_img_crop'       => null,
					'og_img_crop_x'     => null,
					'og_img_crop_y'     => null,
					'og_img_id'         => null,
					'og_img_id_pre'     => null,
					'og_img_url'        => null,
					'schema_img_max'    => null,
					'schema_img_id'     => null,
					'schema_img_id_pre' => null,
					'schema_img_width'  => null,
					'schema_img_height' => null,
					'schema_img_crop'   => null,
					'schema_img_crop_x' => null,
					'schema_img_crop_y' => null,
					'schema_img_url'    => null,
				),
			),
		);

		public static function get_version( $add_slug = false ) {
			$ext = 'wpssoipm';
			$info =& self::$cf['plugin'][$ext];
			return $add_slug ? $info['slug'].'-'.$info['version'] : $info['version'];
		}

		public static function set_constants( $plugin_filepath ) { 

			if ( defined( 'WPSSOIPM_VERSION' ) ) {	// Define constants only once.
				return;
			}

			define( 'WPSSOIPM_VERSION', self::$cf['plugin']['wpssoipm']['version'] );						
			define( 'WPSSOIPM_FILEPATH', $plugin_filepath );						
			define( 'WPSSOIPM_PLUGINDIR', trailingslashit( realpath( dirname( $plugin_filepath ) ) ) );
			define( 'WPSSOIPM_PLUGINSLUG', self::$cf['plugin']['wpssoipm']['slug'] );		// wpsso-inherit-parent-meta
			define( 'WPSSOIPM_PLUGINBASE', self::$cf['plugin']['wpssoipm']['base'] );		// wpsso-inherit-parent-meta/wpsso-inherit-parent-meta.php
			define( 'WPSSOIPM_URLPATH', trailingslashit( plugins_url( '', $plugin_filepath ) ) );
		}

		public static function require_libs( $plugin_filepath ) {

			require_once WPSSOIPM_PLUGINDIR.'lib/register.php';
			require_once WPSSOIPM_PLUGINDIR.'lib/filters.php';

			add_filter( 'wpssoipm_load_lib', array( 'WpssoIpmConfig', 'load_lib' ), 10, 3 );
		}

		public static function load_lib( $ret = false, $filespec = '', $classname = '' ) {

			if ( false === $ret && ! empty( $filespec ) ) {

				$filepath = WPSSOIPM_PLUGINDIR.'lib/'.$filespec.'.php';

				if ( file_exists( $filepath ) ) {

					require_once $filepath;

					if ( empty( $classname ) ) {
						return SucomUtil::sanitize_classname( 'wpssoipm' . $filespec, false );	// $underscore = false
					} else {
						return $classname;
					}
				}
			}

			return $ret;
		}
	}
}
