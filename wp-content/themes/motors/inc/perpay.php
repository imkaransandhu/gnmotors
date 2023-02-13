<?php

class STM_Listing_Data_Store_CPT extends WC_Product_Data_Store_CPT {
	/**
	 * Method to read a product from the database.
	 *
	 * @param WC_Product
	 */


	public function read( &$product ) {

		add_filter(
			'woocommerce_is_purchasable',
			function () {
				return true;
			},
			10,
			1
		);

		$product->set_defaults();

		$post_object = get_post( $product->get_id() );

		$post_types = array( stm_listings_post_type() );

		if ( stm_is_multilisting() ) {
			$slugs = STMMultiListing::stm_get_listing_type_slugs();
			if ( ! empty( $slugs ) ) {
				$post_types = array_merge( $post_types, $slugs );
			}
		}

		if ( ! $product->get_id() || ! ( $post_object = get_post( $product->get_id() ) ) || ! ( ( 'product' === $post_object->post_type ) || ( in_array( $post_object->post_type, $post_types ) ) ) ) {
			throw new Exception( __( 'Invalid product.', 'motors' ) );
		}

		$product->set_props(
			array(
				'name'              => $post_object->post_title,
				'slug'              => $post_object->post_name,
				'date_created'      => 0 < $post_object->post_date_gmt ? wc_string_to_timestamp( $post_object->post_date_gmt ) : null,
				'date_modified'     => 0 < $post_object->post_modified_gmt ? wc_string_to_timestamp( $post_object->post_modified_gmt ) : null,
				'status'            => $post_object->post_status,
				'description'       => $post_object->post_content,
				'short_description' => $post_object->post_excerpt,
				'parent_id'         => $post_object->post_parent,
				'menu_order'        => $post_object->menu_order,
				'reviews_allowed'   => 'open' === $post_object->comment_status,
			)
		);

		$this->read_attributes( $product );
		$this->read_downloads( $product );
		$this->read_visibility( $product );
		$this->read_product_data( $product );
		$this->read_extra_data( $product );
		$product->set_object_read( true );

	}

	/**
	 * Get the product type based on product ID.
	 *
	 * @since 3.0.0
	 * @param int $product_id
	 * @return bool|string
	 */

	public function get_product_type( $product_id ) {
		$post_type = get_post_type( $product_id );

		$post_types = array( stm_listings_post_type() );

		if ( stm_is_multilisting() ) {
			$slugs = STMMultiListing::stm_get_listing_type_slugs();
			if ( ! empty( $slugs ) ) {
				$post_types = array_merge( $post_types, $slugs );
			}
		}

		if ( 'product_variation' === $post_type ) {
			return 'variation';
		} elseif ( ( $post_type === 'product' ) || ( in_array( $post_type, $post_types ) ) ) {
			$terms = get_the_terms( $product_id, 'product_type' );
			return ! empty( $terms ) ? sanitize_title( current( $terms )->name ) : 'simple';
		} else {
			return false;
		}
	}
}

function stm_woocommerce_payment_complete( $id ) {

	$order        = wc_get_order( $id );
	$orderId      = 0;
	$order_status = $order->get_status();
	$order_items  = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
	$listingTitle = '';
	$listingId    = get_post_meta( $id, 'order_pay_per_listing_id', true );

	$send_access = false;

	foreach ( $order_items as $item ) {
		if ( get_post_type( $item->get_data()['product_id'] ) != 'product' ) {
			$listingTitle = $item->get_data()['name'];
			$send_access  = true;
		}
	}

	$to      = get_bloginfo( 'admin_email' );
	$args    = array(
		'first_name'    => $order->get_billing_first_name(),
		'last_name'     => $order->get_billing_last_name(),
		'email'         => $order->get_billing_email(),
		'order_id'      => $orderId,
		'order_status'  => $order_status,
		'listing_title' => $listingTitle,
		'car_id'        => $listingId,
	);
	$subject = stm_generate_subject_view( 'pay_per_listing', $args );
	$body    = stm_generate_template_view( 'pay_per_listing', $args );

	if ( $send_access ) {
		do_action( 'stm_wp_mail', $to, $subject, $body, '' );
	}
}

if ( is_listing() || stm_is_dealer_two() ) {
	add_action( 'woocommerce_checkout_update_order_meta', 'stm_before_create_order', 200, 2 );
	add_filter( 'woocommerce_data_stores', 'stm_motors_woocommerce_data_stores' );
}

function stm_before_create_order( $order_id, $data ) {
	$cart = WC()->cart->get_cart();

	foreach ( $cart as $cart_item ) {
		$id          = $cart_item['product_id'];
		$post_object = get_post( $cart_item['product_id'] );

		if ( 'product' === $post_object->post_type || 'car_option' === $post_object->post_type ) {
			continue;
		}

		if ( ! empty( get_post_meta( $id, 'car_make_featured_status', true ) ) ) {
			update_post_meta( $id, 'car_make_featured_status', 'processing' );
			update_post_meta( $order_id, 'car_make_featured_id', $id );
		} elseif ( ! empty( get_post_meta( $id, 'is_sell_online_status', true ) ) ) {
			update_post_meta( $id, 'is_sell_online_status', 'processing' );
			update_post_meta( $order_id, 'is_sell_online_car_id', $id );
		} else {
			update_post_meta( $order_id, 'order_pay_per_listing_id', $id );
			update_post_meta( $id, 'pay_per_order_id', $order_id );
		}
	}

	// stm_woocommerce_payment_complete($order_id);

	return true;
}

function stm_motors_woocommerce_data_stores( $stores ) {
	$stores['product'] = 'STM_Listing_Data_Store_CPT';
	return $stores;
}

// check car stock amount before adding to cart
add_filter( 'woocommerce_add_to_cart_validation', 'stm_check_car_stock_amount_before_adding_to_cart', 10, 5 );
function stm_check_car_stock_amount_before_adding_to_cart( $passed, $product_id, $quantity, $variation_id = '', $variations = '' ) {

	if ( ! stm_is_dealer_two() ) {
		return $passed;
	}

	$car_stock = (int) get_post_meta( $product_id, 'stm_car_stock', true );

	if ( get_post_type( $product_id ) == stm_listings_post_type() && $car_stock <= 0 ) {
		$passed = false;
		wc_add_notice( __( 'Sorry, item is out of stock and cannot be added to cart', 'motors' ), 'error' );
	}

	return $passed;
}

// order completed
add_action( 'woocommerce_order_status_completed', 'stm_woo_order_status_positive' );
function stm_woo_order_status_positive( $order_id ) {
	$vehicle_id = (int) get_post_meta( $order_id, 'is_sell_online_car_id', true );

	if ( ! empty( $vehicle_id ) ) {
		$car_stock = (int) get_post_meta( $vehicle_id, 'stm_car_stock', true );

		if ( is_numeric( $car_stock ) ) {
			if ( $car_stock == 1 ) {
				update_post_meta( $vehicle_id, 'car_mark_as_sold', 'on' );
			}

			update_post_meta( $vehicle_id, 'stm_car_stock', $car_stock - 1 );
		}
	}

}

// order canceled
add_action( 'woocommerce_order_status_failed', 'stm_woo_order_status_negative' );
add_action( 'woocommerce_order_status_refunded', 'stm_woo_order_status_negative' );
add_action( 'woocommerce_order_status_cancelled', 'stm_woo_order_status_negative' );
function stm_woo_order_status_negative( $order_id ) {
	$vehicle_id = (int) get_post_meta( $order_id, 'is_sell_online_car_id', true );

	if ( ! empty( $vehicle_id ) ) {
		$car_stock = (int) get_post_meta( $vehicle_id, 'stm_car_stock', true );

		if ( is_numeric( $car_stock ) ) {
			if ( ! empty( get_post_meta( $vehicle_id, 'car_mark_as_sold', true ) ) ) {
				delete_post_meta( $vehicle_id, 'car_mark_as_sold', 'on' );
			}

			update_post_meta( $vehicle_id, 'stm_car_stock', $car_stock + 1 );
		}
	}
}
