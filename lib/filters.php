<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2016-2020 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoIpmFilters' ) ) {

	class WpssoIpmFilters {

		private $p;

		public function __construct( &$plugin ) {

			/**
			 * Just in case - prevent filters from being hooked and executed more than once.
			 */
			static $do_once = null;

			if ( true === $do_once ) {
				return;	// Stop here.
			}

			$do_once = true;

			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			add_filter( 'get_post_metadata', array( $this, 'get_post_metadata' ), 10, 4 );

			/**
			 * Do not include the 'wpsso_get_user_options' filter as there is no parent / child relationship for
			 * WordPress user objects - inheritance is only possible for post and term objects.
			 */
			$this->p->util->add_plugin_filters( $this, array(
				'get_md_defaults' => 2,
				'get_md_options'  => array(
					'get_post_options' => 3,
					'get_term_options' => 3,
				),
			) );
		}

		public function get_post_metadata( $meta_data, $obj_id, $meta_key, $single ) {

			static $do_inherit = array();

			if ( isset( $do_inherit[ $meta_key ] ) ) {	// Previously checked.
			
				if ( ! $do_inherit[ $meta_key ] ) {	// Do not inherit this metadata key.
					return $meta_data;
				}
			}

			/**
			 * Do not inherit the WPSSO_META_NAME metadata array.
			 *
			 * Individual WPSSO metadata option values are handled by the 'wpsso_get_post_options' and
			 * 'wpsso_get_term_options' filters.
			 */
			if ( WPSSO_META_NAME === $meta_key ) {	// Just in case.

				$do_inherit[ $meta_key ] = false;	// Remember this check.

				return $meta_data;
			}

			/**
			 * Default WPSSOIPM_POST_METADATA_KEYS value is array( '_thumbnail_id' ).
			 */
			$inherit_keys = (array) SucomUtil::get_const( 'WPSSOIPM_POST_METADATA_KEYS', array() );

			if ( ! in_array( $meta_key, $inherit_keys, $strict = false ) ) {

				$do_inherit[ $meta_key ] = false;	// Remember this check.

				return $meta_data;
			}

			$do_inherit[ $meta_key ] = true;	// Remember this check.

			$meta_cache = $this->get_meta_cache( $obj_id, 'post' );

			/**
			 * If the meta already has metadata, then no need to check the parents.
			 */
			if ( ! empty( $meta_cache[ $meta_key ] ) ) {
				return $meta_data;
			}

			/**
			 * Start with the parent and work our way up - return the first metadata found.
			 */
			foreach ( get_post_ancestors( $obj_id ) as $parent_id ) {

				$meta_cache = $this->get_meta_cache( $parent_id, 'post' );

				if ( ! empty( $meta_cache[ $meta_key ] ) ) {

					if ( $single ) {
						return maybe_unserialize( $meta_cache[ $meta_key ][ 0 ] );
					} else {
						return array_map( 'maybe_unserialize', $meta_cache[ $meta_key ] );
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

			/**
			 * Returns (bool|mixed) false on failure to retrieve contents or the cache contents on success.
			 *
			 * $found (bool) (Optional) whether the key was found in the cache (passed by reference). 
			 */
			$meta_cache = wp_cache_get( $obj_id, $group = $meta_type . '_meta', $force = false, $found );

			if ( ! $found ) {

				/**
				 * Returns (array|false) metadata cache for the specified objects, or false on failure.
				 */
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

			if ( $mod[ 'is_post' ] ) {
				$parent_ids = array_reverse( get_ancestors( $mod[ 'id' ], $mod[ 'post_type' ], 'post_type' ) );
			} elseif ( $mod[ 'is_term' ] ) {
				$parent_ids = array_reverse( get_ancestors( $mod[ 'id' ], $mod[ 'tax_slug' ], 'taxonomy' ) );
			} else {
				$parent_ids = array();
			}

			foreach ( $parent_ids as $parent_id ) {

				$meta_cache = $this->get_meta_cache( $parent_id, $mod[ 'name' ] );

				if ( isset( $meta_cache[ WPSSO_META_NAME ][ 0 ] ) ) {

					$parent_opts = maybe_unserialize( $meta_cache[ WPSSO_META_NAME ][ 0 ] );

					$parent_opts = array_intersect_key( $parent_opts, WpssoIpmConfig::$cf[ 'form' ][ 'ipm_inherit' ] );

					$local_cache[ $cache_index ] = array_merge( $local_cache[ $cache_index ], $parent_opts );
				}
			}

			return $local_cache[ $cache_index ];
		}
	}
}
