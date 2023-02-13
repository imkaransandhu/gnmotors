<?php
$listings_archive = get_post_type_archive_link( stm_listings_post_type() );

$back_inventory_link = stm_get_listing_archive_link();

$blog_id = get_current_blog_id();
if ( isset( $_COOKIE['stm_visitor_' . $blog_id] ) ) {
	$fake_id = $_COOKIE['stm_visitor_' . $blog_id];
}

// check if we have a previously visited page
if ( !empty( wp_get_referer() ) && !empty( $fake_id ) ) {
    // is there a query cookie (coming from modern inventory)?
    $modern_inventory_query = get_transient( 'stm_search_results_query_' . $fake_id );

    // previous page was CLASSIC INVENTORY, SOLD INVENTORY...
    $prev_inventory = (stm_get_listing_archive_page_id() == url_to_postid(wp_get_referer()) || wp_get_referer() == $listings_archive );
    
    //...or LISTING SINGLE page
    $prev_single = stm_listings_post_type() == get_post_type(url_to_postid(wp_get_referer()));

    if( empty( $modern_inventory_query ) && ($prev_inventory || $prev_single) ) {
		$last_query_args = get_transient( 'stm_last_query_args_' . $fake_id );
		$last_query_link = get_transient( 'stm_last_query_link_' . $fake_id );
        if( ! empty( $last_query_args ) ) {

            $args = $last_query_args;

            // get rid of 'paged', just in case there's one
            if ( isset( $args['paged']) && !empty($args['paged'] ) ) {
                unset($args['paged']);
            }

            if ( !empty( $last_query_link ) ) {
                $back_inventory_link = esc_url( $last_query_link );
            }
        }
    } else {

        delete_transient( 'stm_last_query_args_' . $fake_id );
		delete_transient( 'stm_last_query_link_' . $fake_id );

		if( ! empty( $modern_inventory_query ) ) {
            // if cookie contains valid json string and is decodable
            if ( is_array( $modern_inventory_query ) ) {
                foreach ( $modern_inventory_query as $tax => $terms ) {
                    if($tax == 'listing_status') {
                        // active or sold status
                        if(count($terms) == 1) {
                            if($terms[0] == 'listing_is_active') {
                                $args['meta_query'][] = [
                                    'key' => 'car_mark_as_sold',
                                    'compare' => 'NOT EXISTS'
                                ];
                            } else {
                                $args['meta_query'][] = [
                                    'key' => 'car_mark_as_sold',
                                    'value' => 'on',
                                    'compare' => '='
                                ];
                            }
                        }
                    } elseif($tax == 'min_price') {
                        $args['meta_query'][] = [
                            'key' => 'stm_genuine_price',
                            'value' => $terms[0],
                            'type' => 'DECIMAL',
                            'compare' => '>='
                        ];
                    } elseif($tax == 'max_price') {
                        $args['meta_query'][] = [
                            'key' => 'stm_genuine_price',
                            'value' => $terms[0],
                            'type' => 'DECIMAL',
                            'compare' => '<='
                        ];
                    } else {
                        // the rest of the filters
                        $_value = [];
                        if(!empty($terms)) {
                            foreach($terms as $term) {
                                $exploded = explode('-', $term);
                                array_pop($exploded);
                                if(count($exploded) > 1) {
                                    $_value[] = implode('-', $exploded);
                                } else {
                                    $_value[] = $exploded[0];
                                }
                            }
                        }

                        $args['tax_query'][] = array(
                            'taxonomy' => $tax,
                            'field' => 'slug',
                            'terms' => $_value,
                        );
                    }
                }
            }

        }

		$modern_inventory_link = get_transient( 'stm_modern_inventory_link_' . $fake_id );

        // previous page was a modern inventory
        if( !empty( $modern_inventory_link ) ) {
            $back_inventory_link = esc_url( $modern_inventory_link );
        }
    }
}