<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter( 'request', 'stm_listings_query_vars' );

function stm_listings_query_vars( $query_vars ) {
	if ( ! empty( $query_vars['post_type'] ) && 'product' === $query_vars['post_type'] ) {
		return $query_vars;
	}

	$is_listing = isset( $query_vars['post_type'] ) && in_array( stm_listings_post_type(), (array) $query_vars['post_type'], true );

	/* Include search */
	$include_search = stm_listings_search_inventory();
	if ( true === $include_search && ! empty( $_GET['s'] ) ) {
		$is_listing = true;
	}

	if ( isset( $query_vars['pagename'] ) ) {
		$listing_id = stm_listings_user_defined_filter_page();
		if ( $listing_id ) {
			$requested = get_page_by_path( $query_vars['pagename'] );
			if ( ! empty( $requested ) && $is_listing && $listing_id === $requested->ID ) {
				unset( $query_vars['pagename'] );
			}
		}
	}

	if ( ! empty( $_GET['ajax_action'] ) && 'listings-result' === $_GET['ajax_action'] ) {
		unset( $query_vars['pagename'] );
		unset( $query_vars['page_id'] );
		$is_listing = true;
	}

	if ( $is_listing && ! is_admin() && ! isset( $query_vars['listings'] ) ) {
		$query_vars = apply_filters( 'stm_listings_query_vars', _stm_listings_build_query_args( $query_vars ) );
	}

	return $query_vars;
}

add_action( 'template_redirect', 'stm_listings_template_redirect', 0 );

function stm_listings_template_redirect() {
	if ( is_feed() ) {
		return;
	}

	if ( stm_listings_user_defined_filter_page() === get_the_ID() ) {
		if ( is_post_type_archive( 'listings' ) ) {
			$GLOBALS['listings_query'] = $GLOBALS['wp_the_query'];
			$query                     = new WP_Query( 'pagename=' . get_page_uri( get_the_ID() ) );
			$GLOBALS['wp_query']       = $query;
			$GLOBALS['wp_the_query']   = $query;
			$GLOBALS['wp']->register_globals();

			if ( stm_is_magazine() ) {
				add_filter( 'body_class', 'stm_listing_magazine_body_class' );
			}
		}
	}
}

/**
 * Get current listings query
 *
 * @return WP_Query
 */
function stm_listings_query( $source = null ) {
	$new_query = '';
	if ( isset( $GLOBALS['listings_query'] ) && is_null( $source ) ) {
		$new_query = $GLOBALS['listings_query'];
	} else {
		$query_attr = _stm_listings_build_query_args(
			array(
				'paged' => stm_listings_paged_var(),
			),
			$source
		);

		if ( ! is_null( $source ) ) {
			foreach ( $source as $k => $val ) {
				$query_attr[ $k ] = $val;
			}
		}

		$new_query = new WP_Query( $query_attr );

		$GLOBALS['listings_query'] = $new_query;
	}

	return $new_query;
}


add_filter( 'posts_clauses_request', 'stm_listings_posts_clauses', 100, 2 );

function stm_listings_posts_clauses( $clauses, WP_Query $query ) {
	if ( ! $query->get( 'filter_location' ) || ! stm_listings_input( 'stm_lat' ) || ! stm_listings_input( 'stm_lng' ) ) {
		return $clauses;
	}

	$formula = '6378.137 * ACOS(COS(RADIANS(stm_lat_prefix.meta_value)) * COS(RADIANS(:lat)) * COS(RADIANS(stm_lng_prefix.meta_value) - RADIANS(:lng)) + SIN(RADIANS(stm_lat_prefix.meta_value)) * SIN(RADIANS(:lat)))';
	$formula = strtr(
		$formula,
		array(
			':lat' => floatval( stm_listings_input( 'stm_lat' ) ),
			':lng' => floatval( stm_listings_input( 'stm_lng' ) ),
		)
	);

	$clauses['fields'] .= ", ($formula) AS stm_distance";

	global $wpdb;
	$table_prefix = $wpdb->prefix;

	$clauses['join'] .= " INNER JOIN {$table_prefix}postmeta stm_lat_prefix ON ({$table_prefix}posts.ID = stm_lat_prefix.post_id AND stm_lat_prefix.meta_key = 'stm_lat_car_admin')";
	$clauses['join'] .= " INNER JOIN {$table_prefix}postmeta stm_lng_prefix ON ({$table_prefix}posts.ID = stm_lng_prefix.post_id AND stm_lng_prefix.meta_key = 'stm_lng_car_admin') ";

	if ( 'stm_distance' === $query->get( 'orderby' ) ) {
		$clauses['orderby'] = 'stm_distance ASC, ' . $clauses['orderby'];
	}

	return apply_filters( 'stm_listings_clauses_filter', $clauses );
}

function _stm_listings_build_query_args( $args, $source = null ) {
	$sanitized = filter_var_array( $_GET, FILTER_SANITIZE_STRING );

	if ( is_null( $source ) ) {
		$source = $sanitized;
	} else {
		if ( ! empty( $sanitized ) ) {
			$source = array_merge( $source, $sanitized );
		}
	}

	$args['post_type'] = stm_listings_post_type();

	$args['order']   = 'DESC';
	$args['orderby'] = 'date';

	foreach ( stm_listings_attributes( array( 'key_by' => 'slug' ) ) as $attribute => $filter_option ) {

		if ( $filter_option['numeric'] ) {
			// Compatibility for min_
			if ( ! empty( $source[ 'min_' . $attribute ] ) ) {
				$source[ $attribute ] = array( 'min' => $source[ 'min_' . $attribute ] );
			}

			// Compatibility for max_
			if ( ! empty( $source[ 'max_' . $attribute ] ) ) {
				$maxArr               = array( 'max' => $source[ 'max_' . $attribute ] );
				$source[ $attribute ] = ( isset( $source[ $attribute ]['min'] ) ) ? array_merge( $source[ $attribute ], $maxArr ) : $maxArr;
			}
		}

		if ( empty( $source[ $attribute ] ) ) {
			continue;
		}

		$_value = $source[ $attribute ];

		if ( ! is_array( $_value ) && $filter_option['numeric'] ) {
			if ( strpos( trim( $_value, '-' ), '-' ) !== false ) {
				$_value = explode( '-', $_value );
				$_value = array(
					'min' => $_value[0],
					'max' => $_value[1],
				);
			} elseif ( strpos( $_value, '>' ) === 0 ) {
				$_value = array(
					'min' => str_replace( '>', '', $_value ),
				);
			} elseif ( strpos( $_value, '<' ) === 0 ) {
				$_value = array(
					'max' => str_replace( '<', '', $_value ),
				);
			}
		}

		if ( ! is_array( $_value ) ) {
			// Exact value
			$args['tax_query'][] = array(
				'taxonomy' => $attribute,
				'field'    => 'slug',
				'terms'    => (array) $_value,
			);
			continue;
		}

		if ( ! empty( $_value['min'] ) || ! empty( $_value['max'] ) ) {
			$between = array( 0, 9999999999 );

			if ( 'price' === $attribute || ( isset( $filter_option['listing_price_field'] ) && ! empty( $filter_option['listing_price_field'] ) ) ) {
				if ( isset( $_value['min'] ) ) {
					$between[0] = stm_convert_to_normal_price( $_value['min'] );
				}
				if ( isset( $_value['max'] ) ) {
					$between[1] = stm_convert_to_normal_price( $_value['max'] );
				}

				$args['meta_query'][] = array(
					array(
						'key'     => 'stm_genuine_price',
						'value'   => $between,
						'type'    => 'DECIMAL',
						'compare' => 'BETWEEN',
					),
				);

				continue;
			}

			if ( isset( $_value['min'] ) ) {
				$between[0] = $_value['min'];
			}
			if ( isset( $_value['max'] ) ) {
				$between[1] = $_value['max'];
			}

			// Range condition
			$args['meta_query'][] = array(
				'key'     => $attribute,
				'value'   => $between,
				'type'    => 'DECIMAL',
				'compare' => 'BETWEEN',
			);

		} elseif ( array_filter( $_value ) ) {
			// Multiple values
			$args['tax_query'][] = array(
				'taxonomy' => $attribute,
				'terms'    => $_value,
				'field'    => 'slug',
			);
		}
	}

	if ( isset( $args['meta_query'] ) && count( $args['meta_query'] ) > 1 ) {
		$args['meta_query'] = array_merge( array( 'relation' => 'AND' ), $args['meta_query'] );
	}

	if ( ! empty( $source['popular'] ) && 'true' === $source['popular'] ) {
		$args['order']    = 'DESC';
		$args['orderby']  = 'meta_value_num';
		$args['meta_key'] = 'stm_car_views';
	}

	$metaKey = '';

	$default_sort = apply_filters( 'stm_get_default_sort_option', 'date_high' );
	$sort_by      = ( ! empty( $source['sort_order'] ) ) ? $source['sort_order'] : $default_sort;

	$custom_sort_order  = '';
	$custom_meta_key    = '';
	$custom_price_field = false;

	if ( strpos( $sort_by, '_high' ) !== false ) {
		$custom_sort_order = 'DESC';
		$custom_meta_key   = str_replace( '_high', '', $sort_by );
		$custom_suffix     = 'high';
	} else {
		$custom_sort_order = 'ASC';
		$custom_meta_key   = str_replace( '_low', '', $sort_by );
		$custom_suffix     = 'low';
	}

	if ( stm_is_multilisting() && ! empty( $custom_meta_key ) ) {
		$current_slug = STMMultiListing::stm_get_current_listing_slug();
		if ( ! empty( $current_slug ) ) {
			$data = (array) get_option( "stm_{$current_slug}_options", array() );
			if ( ! empty( $data ) ) {
				foreach ( $data as $key => $arr ) {
					if ( $custom_meta_key === $arr['slug'] && true === $arr['listing_price_field'] ) {
						$sort_by = 'price_' . $custom_suffix;
					}
				}
			}
		}
	}

	if ( ! empty( $sort_by ) ) {
		switch ( $sort_by ) {
			case 'price_low':
				$metaKey          = 'stm_genuine_price';
				$args['meta_key'] = 'stm_genuine_price';
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'ASC';
				break;
			case 'price_high':
				$metaKey          = 'stm_genuine_price';
				$args['meta_key'] = 'stm_genuine_price';
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'DESC';
				break;
			case 'date_low':
				$args['order']   = 'ASC';
				$args['orderby'] = 'date';
				break;
			case 'date_high':
				$args['order']   = 'DESC';
				$args['orderby'] = 'date';
				break;
			case 'mileage_low':
				$metaKey          = 'mileage';
				$args['order']    = 'ASC';
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = 'mileage';
				break;
			case 'mileage_high':
				$metaKey          = 'mileage';
				$args['order']    = 'DESC';
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = 'mileage';
				break;
			case 'distance_nearby':
				$args['order']   = 'ASC';
				$args['orderby'] = 'stm_distance';
				break;
			default:
				$args['meta_key'] = $custom_meta_key;
				$args['orderby']  = 'meta_value_num';
				$args['order']    = $custom_sort_order;
		}
	}

	$args['sold_car'] = 'off';

	if ( function_exists( 'stm_sold_status_enabled' ) && stm_sold_status_enabled() ) {

		if ( ! empty( $source['sold_car'] ) ) {

			$args['sold_car'] = 'on';

			$args['meta_query'][] = array(
				array(
					'key'     => 'car_mark_as_sold',
					'value'   => 'on',
					'compare' => '=',
				),
			);

		} else {

			$show_sold = stm_me_get_wpcfto_mod( 'show_sold_listings' );

			if ( $show_sold ) {

				if ( ! empty( $source['listing_status'] ) && 'sold' === $source['listing_status'] ) {
					$args['meta_query'][] = array(
						array(
							'key'     => 'car_mark_as_sold',
							'value'   => 'on',
							'compare' => '=',
						),
					);
				} elseif ( ! empty( $source['listing_status'] ) && 'active' === $source['listing_status'] ) {
					$args['meta_query'][] = array(
						'relation' => 'OR',
						array(
							'key'     => 'car_mark_as_sold',
							'value'   => '',
							'compare' => 'NOT EXISTS',
						),
						array(
							'key'     => 'car_mark_as_sold',
							'value'   => '',
							'compare' => '=',
						),
					);
				}
			} else {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'car_mark_as_sold',
						'value'   => '',
						'compare' => 'NOT EXISTS',
					),
					array(
						'key'     => 'car_mark_as_sold',
						'value'   => '',
						'compare' => '=',
					),
				);
			}
		}
	}

	$args['meta_query_count'][] = ( isset( $args['meta_query'] ) ) ? $args['meta_query'] : array();

	if ( ! empty( $source['listing_type'] ) && 'with_review' === $source['listing_type'] ) {
		$args['meta_query'][] = array(
			array(
				'key'     => 'has_review_car',
				'compare' => 'EXISTS',
			),
		);
	}

	if ( ! empty( $source['posts_per_page'] ) ) {
		$args['posts_per_page'] = $source['posts_per_page'];
	}

	if ( ! empty( $source['offset'] ) && ! empty( $source['posts_per_page'] ) ) {
		$args['offset'] = $source['offset'] * $source['posts_per_page'];
	}

	// Enables adding location conditions
	$args['filter_location'] = true;

	$blog_id = get_current_blog_id();

	// later used in STM Inventory Search Results shortcode

	// search results back link
	$link_get = $sanitized;

	if ( isset( $link_get['ajax_action'] ) && ! empty( $link_get['ajax_action'] ) ) {
		unset( $link_get['ajax_action'] );
	}

	$inventory_link = add_query_arg( $link_get, get_the_permalink( apply_filters( 'stm_get_listing_archive_page_id', 0 ) ) );

	if ( isset( $_COOKIE[ 'stm_visitor_' . $blog_id ] ) ) {
		$fake_id = $_COOKIE[ 'stm_visitor_' . $blog_id ];
		set_transient( 'stm_last_query_args_' . $fake_id, $args, HOUR_IN_SECONDS );
		set_transient( 'stm_last_query_link_' . $fake_id, $inventory_link, HOUR_IN_SECONDS );
	}

	return apply_filters( 'stm_listings_build_query_args', $args, $source );
}
