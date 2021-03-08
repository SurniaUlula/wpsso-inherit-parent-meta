<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2016-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoIpmFilters' ) ) {

	class WpssoIpmFilters {

		private $p;	// Wpsso class object.
		private $a;	// WpssoIpm class object.

		/**
		 * Instantiated by WpssoIpm->init_objects().
		 */
		public function __construct( &$plugin, &$addon ) {

			static $do_once = null;

			if ( true === $do_once ) {

				return;	// Stop here.
			}

			$do_once = true;

			$this->p =& $plugin;
			$this->a =& $addon;

			add_filter( 'update_post_metadata', array( $this, 'update_post_metadata' ), 10, 5 );

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

		public function update_post_metadata( $check = null, $obj_id, $meta_key, $meta_value, $prev_value ) {

			if ( ! $this->can_inherit_metadata( $meta_key ) ) {	// Uses a local cache.
	
				return $meta_data;
			}

			if ( '' === $prev_value ) {	// No existing previous value.

				foreach ( get_post_ancestors( $obj_id ) as $parent_id ) {

					$meta_cache = $this->get_meta_cache( $parent_id, 'post' );
	
					if ( ! empty( $meta_cache[ $meta_key ][ 0 ] ) ) {	// Parent has a meta key value.

						$parent_value = maybe_unserialize( $meta_cache[ $meta_key ][ 0 ] );

						if ( $meta_value == $parent_value ) {

							return false;	// Do not save the meta key value.
						}
					}
				}
			}

			return $check;
		}

		public function get_post_metadata( $meta_data, $obj_id, $meta_key, $single ) {

			if ( ! $this->can_inherit_metadata( $meta_key ) ) {	// Uses a local cache.
	
				return $meta_data;
			}

			$meta_cache = $this->get_meta_cache( $obj_id, 'post' );

			/**
			 * If the meta key already has a value, then no need to check the parents.
			 */
			if ( ! empty( $meta_cache[ $meta_key ] ) ) {

				return $meta_data;
			}

			/**
			 * Start with the parent and work our way up - return the first value found.
			 */
			foreach ( get_post_ancestors( $obj_id ) as $parent_id ) {

				$meta_cache = $this->get_meta_cache( $parent_id, 'post' );

				if ( ! empty( $meta_cache[ $meta_key ][ 0 ] ) ) {	// Parent has a meta key value.

					if ( $single ) {

						return maybe_unserialize( $meta_cache[ $meta_key ][ 0 ] );
					}

					return array_map( 'maybe_unserialize', $meta_cache[ $meta_key ] );
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
			 * WordPress stores data using a post, term, or user ID, along with a group string.
			 *
			 * Example: wp_cache_get( 1, 'user_meta' );
			 *
			 * Returns (bool|mixed) false on failure to retrieve contents or the cache contents on success.
			 *
			 * $found (bool) (Optional) whether the key was found  in the cache (passed by reference). Disambiguates a
			 * return of false, a storable value. Default null.
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

		private function can_inherit_metadata( $meta_key ) {

			/**
			 * Never inherit the WPSSO_META_NAME metadata array.
			 *
			 * Individual WPSSO metadata option values are handled by the 'wpsso_get_post_options' and
			 * 'wpsso_get_term_options' filters in $this->filter_get_md_options().
			 */
			static $local_cache = array( WPSSO_META_NAME => false );

			if ( isset( $local_cache[ $meta_key ] ) ) {	// Previously checked.

				return $local_cache[ $meta_key ];	// Return true or false.
			}

			static $inherit_keys = null;

			if ( null === $inherit_keys ) {

				$inherit_keys = (array) SucomUtil::get_const( 'WPSSOIPM_POST_METADATA_KEYS', array( '_thumbnail_id' ) );
			}

			if ( in_array( $meta_key, $inherit_keys, $strict = false ) ) {

				return $local_cache[ $meta_key ] = true;	// Remember this check.
			}

			return $local_cache[ $meta_key ] = false;	// Remember this check.
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
