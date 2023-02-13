<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * Get filter configuration
 *
 * @param array $args
 *
 * @return array
 */
function stm_listings_attributes( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'where'  => array(),
			'key_by' => '',
		)
	);

	$result = array();
	$data   = array_filter( (array) get_option( 'stm_vehicle_listing_options' ) );

	foreach ( $data as $key => $_data ) {
		$passed = true;
		foreach ( $args['where'] as $_field => $_val ) {
			if ( array_key_exists( $_field, $_data ) && boolval( $_data[ $_field ] ) !== boolval( $_val ) ) {
				$passed = false;
				break;
			}
		}

		if ( $passed ) {
			if ( $args['key_by'] ) {
				$result[ $_data[ $args['key_by'] ] ] = $_data;
			} else {
				$result[] = $_data;
			}
		}
	}

	return apply_filters( 'stm_listings_attributes', $result, $args );
}

/**
 * Get single attribute configuration by taxonomy slug
 *
 * @param $taxonomy
 *
 * @return array|mixed
 */
function stm_listings_attribute( $taxonomy ) {
	$attributes = stm_listings_attributes( array( 'key_by' => 'slug' ) );
	if ( array_key_exists( $taxonomy, $attributes ) ) {
		return $attributes[ $taxonomy ];
	}

	return array();
}

/**
 * Get all terms grouped by taxonomy for the filter
 *
 * @return array
 */
function stm_listings_filter_terms( $hide_empty = false ) {
	static $terms;

	if ( isset( $terms ) ) {
		return $terms;
	}

	$filters = stm_listings_attributes(
		array(
			'where'  => array( 'use_on_car_filter' => true ),
			'key_by' => 'slug',
		)
	);

	$numeric = array_keys(
		stm_listings_attributes(
			array(
				'where'  => array(
					'use_on_car_filter' => true,
					'numeric'           => true,
				),
				'key_by' => 'slug',
			)
		)
	);

	$_terms = array();

	if ( count( $numeric ) ) {
		$_terms = get_terms(
			array(
				'taxonomy'               => $numeric,
				'hide_empty'             => $hide_empty,
				'update_term_meta_cache' => false,
			)
		);

		foreach ( $numeric as $numeric_item ) {
			if ( in_array( $numeric_item, $numeric, true ) ) {
				$_terms = array_merge(
					$_terms,
					get_terms(
						array(
							'taxonomy'               => $numeric_item,
							'hide_empty'             => false,
							'update_term_meta_cache' => false,
						)
					)
				);
			}
		}
	}

	$taxes = array_diff( array_keys( $filters ), $numeric );
	$taxes = apply_filters( 'stm_listings_filter_taxonomies', $taxes );

	$_terms = array_merge(
		$_terms,
		get_terms(
			array(
				'taxonomy'               => $taxes,
				'hide_empty'             => $hide_empty,
				'update_term_meta_cache' => false,
			)
		)
	);

	$terms = array();

	foreach ( $taxes as $tax ) {
		$terms[ $tax ] = array();
	}

	foreach ( $_terms as $_term ) {
		$terms[ $_term->taxonomy ][ $_term->slug ] = $_term;
	}

	$terms = apply_filters( 'stm_listings_filter_terms', $terms );

	return $terms;
}

/**
 * Drop-down options grouped by attribute for the filter
 *
 * @return array
 */
function stm_listings_filter_options( $hide_empty = false ) {
	static $options;

	if ( isset( $options ) ) {
		return $options;
	}

	$filters = stm_listings_attributes(
		array(
			'where'  => array( 'use_on_car_filter' => true ),
			'key_by' => 'slug',
		)
	);
	$terms   = stm_listings_filter_terms( $hide_empty );
	$options = array();

	foreach ( $terms as $tax => $_terms ) {
		$_filter         = isset( $filters[ $tax ] ) ? $filters[ $tax ] : array();
		$options[ $tax ] = _stm_listings_filter_attribute_options( $tax, $_terms );

		if ( empty( $_filter['numeric'] ) || ! empty( $_filter['use_on_car_filter_links'] ) ) {
			$_remaining = stm_listings_options_remaining( $terms[ $tax ], stm_listings_query() );

			foreach ( $_terms as $_term ) {
				if ( isset( $_remaining[ $_term->term_taxonomy_id ] ) ) {
					$options[ $tax ][ $_term->slug ]['count'] = (int) $_remaining[ $_term->term_taxonomy_id ];
				} else {
					$options[ $tax ][ $_term->slug ]['count']    = 0;
					$options[ $tax ][ $_term->slug ]['disabled'] = true;
				}
			}
		}
	}

	$options = apply_filters( 'stm_listings_filter_options', $options );

	return $options;
}

/**
 * Get list of attribute options filtered by query
 *
 * @param array    $terms
 * @param WP_Query $from
 *
 * @return array
 */
function stm_listings_options_remaining( $terms, $from = null ) {
	/** !!!!!!!!! VERY IMPORTANT !!!!!!!!!
	* BEFORE ADD JOIN OR OTHER DATA TO QUERY
	* CHECK IS THAT DATA ALREADY EXIST IN VARS
	*  - $meta_query_count_sql, $tax_query_sql etc
	*/
	global $wpdb;

	/** @var WP_Query $from */
	$from = is_null( $from ) ? $GLOBALS['wp_query'] : $from;

	if ( empty( $terms ) || is_null( $from ) ) {
		return array();
	}

	$meta_query_count = new WP_Meta_Query( $from->get( 'meta_query_count', array() ) );
	$tax_query        = new WP_Tax_Query( $from->get( 'tax_query', array() ) );

	/** @var  IMPORTANT $meta_query_count_sql connection with 'postmeta' table  */
	$meta_query_count_sql = $meta_query_count->get_sql( 'post', $wpdb->posts, 'ID' );
	$tax_query_sql        = $tax_query->get_sql( $wpdb->posts, 'ID' );

	$term_ids  = wp_list_pluck( $terms, 'term_taxonomy_id' );
	$post_type = $from->get( 'post_type' );

	// Generate query
	$query           = array();
	$query['select'] = "SELECT term_taxonomy.term_taxonomy_id, COUNT( {$wpdb->posts}.ID ) as count";
	$query['from']   = "FROM {$wpdb->posts}";

	$query['join']  = "LEFT JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id";
	$query['join'] .= "\nLEFT JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )";
	$query['join'] .= "\n" . $tax_query_sql['join'] . $meta_query_count_sql['join'];

	$query['where']  = "WHERE {$wpdb->posts}.post_type IN ( '{$post_type}' ) AND {$wpdb->posts}.post_status = 'publish' ";
	$query['where'] .= "\n" . $tax_query_sql['where'] . $meta_query_count_sql['where'];
	$query['where'] .= "\nAND term_taxonomy.term_taxonomy_id IN (" . implode( ',', array_map( 'absint', $term_ids ) ) . ')';

	$query['group_by'] = 'GROUP BY term_taxonomy.term_taxonomy_id';

	$query = apply_filters( 'stm_listings_options_remaining_query', $query );
	$query = join( "\n", $query );

	$results = $wpdb->get_results( $query ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
	$results = wp_list_pluck( $results, 'count', 'term_taxonomy_id' );

	return $results;
}

/**
 * Filter configuration array
 *
 * @return array
 */
function stm_listings_filter( $source = null, $hide_empty = false ) {
	$query   = stm_listings_query( $source );
	$total   = $query->found_posts;
	$filters = stm_listings_attributes(
		array(
			'where'  => array( 'use_on_car_filter' => true ),
			'key_by' => 'slug',
		)
	);
	$options = stm_listings_filter_options( $hide_empty );
	$terms   = stm_listings_filter_terms();
	$url     = '';

	$compact = compact( 'options', 'filters', 'total', 'url' );

	if ( isset( $_GET['result_with_posts'] ) ) {
		$filter_params = explode( ',', $_GET['filter-params'] );
		$fp            = '';
		foreach ( $filter_params as $k => $val ) {
			$get = ( true === apply_filters( 'stm_is_listing_price_field', $val ) ) ? 'max_' . $val : $val;
			if ( isset( $_GET[ $get ] ) && ! empty( $_GET[ $get ] ) ) {

				if ( empty( $fp ) ) {
					$fp .= $filters[ $val ]['single_name'];
				} elseif ( ! empty( $fp ) && 0 !== $k && ( count( $filter_params ) - 1 ) !== $k ) {
					$fp .= ', ' . $filters[ $val ]['single_name'];
				} elseif ( $k >= 1 && ! empty( $fp ) ) {
					$fp .= esc_html__( ' and ', 'stm_vehicles_listing' ) . $filters[ $val ]['single_name'];
				}
			}
		}

		if ( ! empty( $fp ) ) {
			$fp = esc_html__( 'By ', 'stm_vehicles_listing' ) . $fp;
		}

		$posts   = add_review_info_to_listing( $query->posts );
		$compact = compact( 'options', 'filters', 'total', 'url', 'posts', 'fp' );
	}

	if ( isset( $_GET['offset'] ) ) {
		$result_count = count( $query->get_posts() );
		$offset       = $_GET['offset'] + 1;
		if ( $offset * $_GET['posts_per_page'] <= $total ) {

			$offset = ( $offset * $_GET['posts_per_page'] >= $total ) ? 0 : $offset;

			$compact = compact( 'options', 'filters', 'total', 'url', 'posts', 'offset', 'fp', 'result_count' );
		}
	}

	return apply_filters( 'stm_listings_filter', $compact, $terms );
}

function add_review_info_to_listing( $posts ) {
	$new_posts = array();

	foreach ( $posts as $k => $post ) {
		$listing_id = $post->ID;
		$review_id  = get_post_id_by_meta_k_v( 'review_car', $listing_id );
		$post_type  = get_post_type( $listing_id );
		$start_at   = get_post_meta( $review_id, 'show_title_start_at', true );
		$price      = stm_listing_price_view( get_post_meta( $listing_id, 'stm_genuine_price', true ) );
		$hwy        = get_post_meta( $listing_id, 'highway_mpg', true );
		$cwy        = get_post_meta( $listing_id, 'sity_mpg', true );
		$title      = $post->post_title;

		if ( ! is_null( $review_id ) ) {
			$title = '<span>' . $title . '</span> ' . string_max_charlength( get_the_title( $review_id ), 55 );
		}

		$cars_in_compare    = stm_get_compared_items( $post_type );
		$in_compare         = '';
		$car_compare_status = esc_html__( 'Add to compare', 'stm_vehicles_listing' );

		if ( ! empty( $cars_in_compare ) && in_array( $listing_id, $cars_in_compare, true ) ) {
			$in_compare         = 'active';
			$car_compare_status = esc_html__( 'Remove from compare', 'stm_vehicles_listing' );
		}

		$image_url = get_the_post_thumbnail_url( $listing_id, 'stm-img-255-160' );

		if ( empty( $image_url ) && ! is_null( $review_id ) ) {
			$image_data = get_the_post_thumbnail_url( $review_id, 'stm-img-255-160' );
			$image_url  = ( ! empty( $image_data ) ) ? $image_data : get_template_directory_uri() . '/assets/images/plchldr255_160.jpg';
		} elseif ( ! $image_url ) {
			$image_url = get_template_directory_uri() . '/assets/images/plchldr255_160.jpg';
		}

		$post_link = get_the_permalink( $listing_id );
		$excerpt   = apply_filters( 'the_content', get_the_excerpt( $listing_id ) );

		$new_post = array();

		$new_post['id']                 = $listing_id;
		$new_post['car_already_added']  = $in_compare;
		$new_post['car_compare_status'] = $car_compare_status;
		$new_post['title']              = $title;
		$new_post['generate_title']     = stm_generate_title_from_slugs( $listing_id, false );

		$new_post['excerpt']       = $excerpt;
		$new_post['url']           = $post_link;
		$new_post['img_url']       = $image_url;
		$new_post['price']         = $price;
		$new_post['show_start_at'] = $start_at;
		$new_post['hwy']           = $hwy;
		$new_post['cwy']           = $cwy;

		if ( ! is_null( $review_id ) ) {

			$performance = get_post_meta( $review_id, 'performance', true );
			$comfort     = get_post_meta( $review_id, 'comfort', true );
			$interior    = get_post_meta( $review_id, 'interior', true );
			$exterior    = get_post_meta( $review_id, 'exterior', true );

			$rating_summary = ( ( $performance + $comfort + $interior + $exterior ) / 4 );

			$new_post['ratingSumm']   = $rating_summary;
			$new_post['ratingP']      = $rating_summary * 20;
			$new_post['performance']  = $performance;
			$new_post['performanceP'] = $performance * 20;
			$new_post['comfort']      = $comfort;
			$new_post['comfortP']     = $comfort * 20;
			$new_post['interior']     = $interior;
			$new_post['interiorP']    = $interior * 20;
			$new_post['exterior']     = $exterior;
			$new_post['exteriorP']    = $exterior * 20;
		}

		$new_posts[ $k ] = (object) $new_post;
	}

	return $new_posts;
}

function get_post_id_by_meta_k_v( $key, $value ) {
	global $wpdb;
	$meta = $wpdb->get_results( $wpdb->prepare( 'SELECT post_id FROM ' . $wpdb->postmeta . ' WHERE meta_key=%s AND meta_value=%s', $key, $value ) );

	return ( count( $meta ) > 0 ) ? $meta[0]->post_id : null;
}

/**
 * Retrieve input data from $_POST, $_GET by path
 *
 * @param $path
 * @param $default
 *
 * @return mixed
 */
function stm_listings_input( $path, $default = null ) {
	if ( empty( trim( $path, '.' ) ) ) {
		return $default;
	}

	foreach ( array( $_POST, $_GET ) as $source ) {
		$value = $source;
		foreach ( explode( '.', $path ) as $key ) {
			if ( ! is_array( $value ) || ! array_key_exists( $key, $value ) ) {
				$value = null;
				break;
			}

			$value = &$value[ $key ];
		}

		if ( ! is_null( $value ) ) {
			return $value;
		}
	}

	return $default;
}

/**
 * Current URL with native WP query string parameters ()
 *
 * @return string
 */
function stm_listings_current_url() {
	global $wp, $wp_rewrite;

	$url = preg_replace( '/\/page\/\d+/', '', $wp->request );
	$url = home_url( $url . '/' );
	if ( ! $wp_rewrite->permalink_structure ) {
		parse_str( $wp->query_string, $query_string );

		$leave        = array( 'post_type', 'pagename', 'page_id', 'p' );
		$query_string = array_intersect_key( $query_string, array_flip( $leave ) );

		$url = trim( add_query_arg( $query_string, $url ), '&' );
		$url = str_replace( '&&', '&', $url );
	}

	return apply_filters( 'stm_listings_current_url', $url );
}

function _stm_listings_filter_attribute_options( $taxonomy, $_terms ) {
	$attribute = stm_listings_attribute( $taxonomy );
	$attribute = wp_parse_args(
		$attribute,
		array(
			'slug'        => $taxonomy,
			'single_name' => '',
			'numeric'     => false,
			'slider'      => false,
		)
	);

	$options = array();

	if ( ! $attribute['numeric'] ) {

		$options[''] = array(
			'label'    => apply_filters( 'stm_listings_default_tax_name', $attribute['single_name'] ),
			'selected' => stm_listings_input( $attribute['slug'] ) === null,
			'disabled' => false,
		);

		foreach ( $_terms as $_term ) {
			$options[ $_term->slug ] = array(
				'label'    => $_term->name,
				'selected' => stm_listings_input( $attribute['slug'] ) === $_term->slug,
				'disabled' => false,
				'count'    => $_term->count,
			);
		}
	} else {
		$numbers = array();
		foreach ( $_terms as $_term ) {
			$numbers[ intval( $_term->slug ) ] = $_term->name;
		}
		ksort( $numbers );

		if ( ! empty( $attribute['slider'] ) ) {
			foreach ( $numbers as $_number => $_label ) {
				$options[ $_number ] = array(
					'label'    => $_label,
					'selected' => stm_listings_input( $attribute['slug'] ) === $_label,
					'disabled' => false,
				);
			}
		} else {

			$options[''] = array(
				'label'    => sprintf( __( 'Max %s', 'stm_vehicles_listing' ), $attribute['single_name'] ),
				'selected' => stm_listings_input( $attribute['slug'] ) === null,
				'disabled' => false,
			);

			$_prev  = null;
			$_affix = empty( $attribute['affix'] ) ? '' : esc_html( $attribute['affix'] );

			foreach ( $numbers as $_number => $_label ) {

				if ( null === $_prev ) {
					$_value = '<' . $_number;
					$_label = '< ' . $_label . ' ' . $_affix;
				} else {
					$_value = $_prev . '-' . $_number;
					$_label = $_prev . '-' . $_label . ' ' . $_affix;
				}

				$options[ $_value ] = array(
					'label'    => $_label,
					'selected' => stm_listings_input( $attribute['slug'] ) === $_value,
					'disabled' => false,
				);

				$_prev = $_number;
			}

			if ( $_prev ) {
				$_value             = '>' . $_prev;
				$options[ $_value ] = array(
					'label'    => '>' . $_prev . ' ' . $_affix,
					'selected' => stm_listings_input( $attribute['slug'] ) === $_value,
					'disabled' => false,
				);
			}
		}
	}

	return $options;
}

if ( ! function_exists( 'stm_listings_user_defined_filter_page' ) ) {
	function stm_listings_user_defined_filter_page() {
		return apply_filters( 'stm_listings_inventory_page_id', stm_me_get_wpcfto_mod( 'listing_archive', false ) );
	}
}

function stm_listings_paged_var() {
	global $wp;

	$paged = null;

	if ( isset( $wp->query_vars['paged'] ) ) {
		$paged = $wp->query_vars['paged'];
	} elseif ( isset( $_GET['paged'] ) ) {
		$paged = sanitize_text_field( $_GET['paged'] );
	}

	return $paged;
}

/**
 * Listings post type identifier
 *
 * @return string
 */
if ( ! function_exists( 'stm_listings_post_type' ) ) {
	function stm_listings_post_type() {
		return apply_filters( 'stm_listings_post_type', 'listings' );
	}
}

add_action( 'init', 'stm_listings_init', 1 );

function stm_listings_init() {
	$options = get_option( 'stm_post_types_options' );

	$stm_vehicle_options = wp_parse_args(
		$options,
		array(
			'listings' => array(
				'title'        => __( 'Listings', 'stm_vehicles_listing' ),
				'plural_title' => __( 'Listings', 'stm_vehicles_listing' ),
				'rewrite'      => 'listings',
			),
		)
	);

	register_post_type(
		stm_listings_post_type(),
		array(
			'labels'             => array(
				'name'               => $stm_vehicle_options['listings']['plural_title'],
				'singular_name'      => $stm_vehicle_options['listings']['title'],
				'add_new'            => __( 'Add New', 'stm_vehicles_listing' ),
				'add_new_item'       => __( 'Add New Item', 'stm_vehicles_listing' ),
				'edit_item'          => __( 'Edit Item', 'stm_vehicles_listing' ),
				'new_item'           => __( 'New Item', 'stm_vehicles_listing' ),
				'all_items'          => __( 'All Items', 'stm_vehicles_listing' ),
				'view_item'          => __( 'View Item', 'stm_vehicles_listing' ),
				'search_items'       => __( 'Search Items', 'stm_vehicles_listing' ),
				'not_found'          => __( 'No items found', 'stm_vehicles_listing' ),
				'not_found_in_trash' => __( 'No items found in Trash', 'stm_vehicles_listing' ),
				'parent_item_colon'  => '',
				'menu_name'          => $stm_vehicle_options['listings']['plural_title'],
			),
			'menu_icon'          => 'dashicons-location-alt',
			'show_in_nav_menus'  => true,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'comments', 'excerpt', 'author', 'revisions' ),
			'rewrite'            => array( 'slug' => $stm_vehicle_options['listings']['rewrite'] ),
			'has_archive'        => ( 'equipment' === get_option( 'stm_motors_chosen_template' ) && empty( stm_me_get_wpcfto_mod( 'listing_archive', '' ) ) ) ? false : true,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'hierarchical'       => false,
			'menu_position'      => 4,
		)
	);

}

add_filter( 'get_pagenum_link', 'stm_listings_get_pagenum_link' );

function stm_listings_get_pagenum_link( $link ) {
	return remove_query_arg( 'ajax_action', $link );
}

/*Functions*/
function stm_check_motors() {
	return apply_filters( 'stm_listing_is_motors_theme', false );
}

require_once 'templates.php';
require_once 'enqueue.php';
require_once 'vehicle_functions.php';

add_action( 'init', 'stm_listings_include_customizer' );

function stm_listings_include_customizer() {
	if ( ! stm_check_motors() ) {
		require_once 'customizer/customizer.class.php';
	}
}

function stm_listings_search_inventory() {
	return apply_filters( 'stm_listings_default_search_inventory', false );
}

function stm_listing_magazine_body_class( $classes ) {
	$classes[] = 'no_margin';

	return $classes;
}

function stm_listings_dynamic_string_translation_e( $desc, $string ) {
	do_action( 'wpml_register_single_string', 'stm_vehicles_listing', $desc, $string );
	echo wp_kses_post( apply_filters( 'wpml_translate_single_string', $string, 'stm_vehicles_listing', $desc ) );
}

function stm_listings_dynamic_string_translation( $desc, $string ) {
	do_action( 'wpml_register_single_string', 'stm_vehicles_listing', $desc, $string );
	return apply_filters( 'wpml_translate_single_string', $string, 'stm_vehicles_listing', $desc );
}

// check for multilisting
if ( ! function_exists( 'stm_is_multilisting' ) ) {
	function stm_is_multilisting() {
		if ( defined( 'MULTILISTING_PATH' ) && class_exists( 'STMMultiListing' ) ) {
			return true;
		} else {
			return false;
		}
	}
}


// get wpcfto settings
if ( ! function_exists( 'stm_me_get_wpcfto_mod' ) ) {
	function stm_me_get_wpcfto_mod( $key, $default = '' ) {
		return apply_filters( 'stm_me_get_wpcfto_mod', $key, $default );
	}
}


// get multilisting post types (array of post types) including/excluding default "listings" post type
if ( ! function_exists( 'stm_listings_multi_type' ) ) {

	function stm_listings_multi_type( $include_default = false ) {
		$post_types = array();

		if ( $include_default ) {
			array_push( $post_types, stm_listings_post_type() );
		}

		if ( stm_is_multilisting() ) {
			$types = STMMultiListing::stm_get_listing_type_slugs();
			if ( ! empty( $types ) ) {
				$post_types = array_merge( $post_types, $types );
			}
		}

		return apply_filters( 'stm_listings_multi_type', $post_types );
	}
}
