</div> <!--main-->
</div> <!--wrapper-->
<?php

do_action( 'stm_pre_footer' );

if ( ! is_404() && ! is_page_template( 'coming-soon.php' ) ) { ?>
	<footer id="footer">
		<?php
		// need to make this multilisting ready.
		if ( ! is_plugin_active( 'elementor/elementor.php' ) && is_singular( stm_listings_post_type() ) ) {
			get_template_part( 'partials/single-car/search-results-carousel' );
		}

		// widget areas.
		get_template_part( 'partials/footer/footer' );

		// copyright text & social icons.
		get_template_part( 'partials/footer/copyright' );

		get_template_part( 'partials/global-alerts' );

		// search form with possible results in inventory page.
		get_template_part( 'partials/modals/searchform' );
		?>
	</footer>
	<?php
} elseif ( is_page_template( 'coming-soon.php' ) ) {
	get_template_part( 'partials/footer/footer-coming-soon' );
}

if ( ! defined( 'ULISTING_VERSION' ) && ( stm_is_listing() || stm_is_listing_two() || stm_is_listing_three() || stm_is_listing_four() || stm_is_listing_five() || stm_is_listing_six() ) && is_author() ) {
	$user = wp_get_current_user();
	$vars = get_queried_object();

	if ( $user->ID === $vars->ID ) {
		get_template_part( 'partials/modals/statistics-modal' );
	}
}

if ( defined( 'MOTORS_ELEMENTOR_WIDGETS_PLUGIN_VERSION' ) ) {
	if ( apply_filters( 'mew_include_trade_in_modal', false ) ) {
		get_template_part( 'partials/modals/trade-in' );
	}

	if ( apply_filters( 'mew_include_offer_price_modal', false ) ) {
		get_template_part( 'partials/modals/trade-offer' );
	}
}

$post_types = stm_listings_multi_type( true );

if ( ! stm_is_auto_parts() && ! stm_is_rental() ) :
	if ( is_singular( $post_types ) ) {
		if ( stm_me_get_wpcfto_mod( 'show_calculator', false ) ) {
			get_template_part( 'partials/modals/car-calculator' );
		}

		if ( stm_me_get_wpcfto_mod( 'show_offer_price', false ) ) {
			get_template_part( 'partials/modals/trade-offer' );
		}

		if ( stm_me_get_wpcfto_mod( 'show_trade_in', false ) ) {
			get_template_part( 'partials/modals/trade-in' );
		}
	}

	if ( stm_is_motorcycle() ) {
		if ( stm_me_get_wpcfto_mod( 'show_calculator', false ) ) {
			get_template_part( 'partials/modals/car-calculator' );
		}
		if ( stm_me_get_wpcfto_mod( 'show_offer_price', false ) ) {
			get_template_part( 'partials/modals/trade-offer' );
		}
	}

	$listing_template_id = stm_me_get_wpcfto_mod( 'single_listing_template', null );

	if ( stm_me_get_wpcfto_mod( 'show_test_drive', false ) || ( ! empty( $listing_template_id ) && 'yes' === get_post_meta( $listing_template_id, 'show_test_drive', true ) ) ) {
		get_template_part( 'partials/modals/test-drive' );
	}

	get_template_part( 'partials/modals/get-car-price' );

	/* compare added/removed notification bar */
	if ( ! stm_is_rental_two() ) {
		get_template_part( 'partials/compare-notification' );
	}

	if ( stm_pricing_enabled() ) {
		get_template_part( 'partials/modals/limit_exceeded' );
		get_template_part( 'partials/modals/subscription_ended' );
	}
	?>
	<?php if ( defined( 'STM_VALUE_MY_CAR' ) ) : ?>
	<div class="notification-wrapper">
		<div class="notification-wrap">
			<div class="message-container">
				<span class="message"></span>
			</div>
			<div class="btn-container">
				<button class="notification-close">
					<?php echo esc_html__( 'Close', 'motors' ); ?>
				</button>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<div class="modal_content"></div>
	<?php
endif;

if ( stm_is_rental() ) {
	get_template_part( 'partials/modals/rental-notification-choose-another-class' );
	echo '<div class="stm-rental-overlay"></div>';
}

wp_footer();
?>
<div id="stm-overlay"></div>
</body>
</html>
