<?php
/**
 * IMPORTANT: READ THE LICENSE AGREEMENT CAREFULLY.
 *
 * BY INSTALLING, COPYING, RUNNING, OR OTHERWISE USING THE WPSSO CORE PRO
 * APPLICATION, YOU AGREE TO BE BOUND BY THE TERMS OF ITS LICENSE AGREEMENT.
 * 
 * License: Nontransferable License for a WordPress Site Address URL
 * License URI: https://wpsso.com/wp-content/plugins/wpsso/license/pro.txt
 *
 * IF YOU DO NOT AGREE TO THE TERMS OF ITS LICENSE AGREEMENT, PLEASE DO NOT
 * INSTALL, RUN, COPY, OR OTHERWISE USE THE WPSSO CORE PRO APPLICATION.
 * 
 * Copyright 2012-2018 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WpssoIpmFilters' ) ) {

	class WpssoIpmFilters {

		private $p;

		public function __construct( &$plugin ) {

			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			add_filter( 'get_post_metadata', array( $this, 'get_meta_thumbnail_id' ), 10, 4 );

			$this->p->util->add_plugin_filters( $this, array(
				'get_md_defaults' => 2,
				'get_md_options'  => array(
					'get_post_options' => 3,
					'get_term_options' => 3,
				),
			) );
		}

		public function get_meta_thumbnail_id( $meta_data, $obj_id, $meta_key, $single ) {

			/**
			 * We're only interested in the featured image (aka '_thumbnail_id').
			 */
			if ( $meta_key !== '_thumbnail_id' ) {
				return $meta_data;
			}

			$meta_cache = $this->get_meta_cache( $obj_id, 'post' );

			/**
			 * If the meta already has a featured image, then no need to check the parents.
			 */
			if ( ! empty( $meta_cache[$meta_key] ) ) {
				return $meta_data;
			}

			/**
			 * Start with the parent and work our way up - return the first featured image found.
			 */
			foreach ( get_post_ancestors( $obj_id ) as $parent_id ) {

				$meta_cache = $this->get_meta_cache( $parent_id, 'post' );

				if ( ! empty( $meta_cache[$meta_key] ) ) {
					if ( $single ) {
						return maybe_unserialize( $meta_cache[$meta_key][0] );
					} else {
						return array_map( 'maybe_unserialize', $meta_cache[$meta_key] );
					}
				}
			}

			return $meta_data;
		}

		public function filter_get_md_defaults( $md_defs, $mod ) {

			$parent_opts = $this->get_parent_opts( $mod );

			/**
			 * Apply all the parent default options to the child's default options.
			 */
			if ( ! empty( $parent_opts ) ) {
				$md_defs = array_merge( $md_defs, $parent_opts );
			}

			return $md_defs;
		}

		public function filter_get_md_options( array $md_opts, $obj_id, $mod ) {

			$parent_opts = $this->get_parent_opts( $mod );

			/**
			 * Apply all the child's custom options to the parent default options.
			 */
			if ( ! empty( $parent_opts ) ) {
				$md_opts = array_merge( $parent_opts, $md_opts );
			}

			return $md_opts;
		}

		private function get_meta_cache( $obj_id, $meta_type ) {

			$meta_cache = wp_cache_get( $obj_id, $meta_type . '_meta' );

			if ( ! $meta_cache ) {
				$meta_cache = update_meta_cache( $meta_type, array( $obj_id ) );
				$meta_cache = $meta_cache[ $obj_id ];
			}

			return $meta_cache;
		}

		private function get_parent_opts( $mod ) {
			static $local_cache = array();

			$cache_index = SucomUtil::get_mod_salt( $mod );

			if ( isset( $local_cache[ $cache_index ] ) ) {
				return $local_cache[ $cache_index ];
			}

			$local_cache[ $cache_index ] = array();

			if ( $mod['is_post'] ) {
				$parent_ids = array_reverse( get_ancestors( $mod[ 'id' ], $mod['post_type'], 'post_type' ) );
			} elseif ( $mod['is_term'] ) {
				$parent_ids = array_reverse( get_ancestors( $mod[ 'id' ], $mod['tax_slug'], 'taxonomy' ) );
			} else {
				$parent_ids = array();
			}

			foreach ( $parent_ids as $parent_id ) {

				$meta_cache = $this->get_meta_cache( $parent_id, $mod[ 'name' ] );

				if ( isset( $meta_cache[ WPSSO_META_NAME ][0] ) ) {

					$parent_opts = maybe_unserialize( $meta_cache[ WPSSO_META_NAME ][ 0 ] );

					$parent_opts = array_intersect_key( $parent_opts, WpssoIpmConfig::$cf['form']['ipm_inherit'] );

					$local_cache[ $cache_index ] = array_merge( $local_cache[ $cache_index ], $parent_opts );
				}
			}

			return $local_cache[ $cache_index ];
		}
	}
}
