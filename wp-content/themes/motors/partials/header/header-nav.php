<?php
$compare_page = stm_me_get_wpcfto_mod( 'compare_page', 156 );
$show_compare = stm_me_get_wpcfto_mod( 'header_compare_show', false );
$show_cart    = stm_me_get_wpcfto_mod( 'header_cart_show', false );

// Get archive shop page id
if ( function_exists( 'WC' ) ) {
	$woocommerce_shop_page_id = wc_get_cart_url();
}

// Get page option
$transparent_header       = get_post_meta( get_the_id(), 'transparent_header', true );
$transparent_header_class = 'header-nav-default';

if ( ! empty( $transparent_header ) && $transparent_header == 'on' ) {
	$transparent_header_class = 'header-nav-transparent';
} else {
	$transparent_header_class = 'header-nav-default';
}

$fixed_header = stm_me_get_wpcfto_mod( 'header_sticky', false );
if ( ! empty( $fixed_header ) && $fixed_header ) {
	$fixed_header_class = 'header-nav-fixed';
} else {
	$fixed_header_class = '';
}
?>

<div id="header-nav-holder" class="hidden-sm hidden-xs">
	<div class="header-nav <?php echo esc_attr( $transparent_header_class . ' ' . $fixed_header_class ); ?>">
		<div class="container">
			<div class="header-help-bar-trigger">
				<i class="fas fa-chevron-down"></i>
			</div>
			<div class="header-help-bar">
				<ul>
					<?php echo apply_filters( 'stm_vin_decoder_header_btn', '' ); ?>
					<?php if ( ! empty( $compare_page ) && $show_compare ) : ?>
						<li class="help-bar-compare">
							<a href="<?php echo esc_url( get_the_permalink( $compare_page ) ); ?>" title="<?php esc_attr_e( 'View compared items', 'motors' ); ?>">
								<span class="list-label heading-font"><?php esc_html_e( 'Compare', 'motors' ); ?></span>
								<?php echo stm_me_get_wpcfto_icon( 'header_compare_icon', 'stm-icon-speedometr2', 'list-icon' ); ?>
								<span class="list-badge">
									<span class="stm-current-cars-in-compare" data-contains="compare-count"></span>
								</span>
							</a>
						</li>
					<?php endif; ?>
					<?php if ( $show_cart && ! empty( $woocommerce_shop_page_id ) ) : ?>
						<?php $items = WC()->cart->cart_contents_count; ?>
						<!--Shop archive-->
						<li class="help-bar-shop">
							<a href="<?php echo esc_url( $woocommerce_shop_page_id ); ?>" title="<?php esc_attr_e( 'Watch shop items', 'motors' ); ?>">
								<span class="list-label heading-font">
									<?php esc_html_e( 'Cart', 'motors' ); ?>
								</span>
								<?php echo stm_me_get_wpcfto_icon( 'header_cart_icon', 'stm-icon-shop_bag', 'list-icon' ); ?>
								<span class="list-badge">
									<span class="stm-current-items-in-cart">
										<?php echo ( 0 !== $items ) ? esc_html( $items ) : ''; ?>
									</span>
								</span>
							</a>
						</li>
					<?php endif; ?>
					<?php if ( is_listing() && 'car_dealer' === stm_get_header_layout() ) : ?>
						<?php
						$header_listing_btn_link = stm_me_get_wpcfto_mod( 'header_listing_btn_link', '/add-a-car' );
						$header_listing_btn_text = stm_me_get_wpcfto_mod( 'header_listing_btn_text', esc_html__( 'Add your item', 'motors' ) );
						?>
						<?php if ( stm_me_get_wpcfto_mod( 'header_show_add_car_button', false ) && ! empty( $header_listing_btn_link ) and ! empty( $header_listing_btn_text ) ) : ?>
						<li>
							<a href="<?php echo esc_url( $header_listing_btn_link ); ?>" class="listing_add_cart heading-font">
								<span class="list-label heading-font">
									<?php stm_dynamic_string_translation_e( 'Listing Button Text', $header_listing_btn_text ); ?>
								</span>
								<?php echo stm_me_get_wpcfto_icon( 'header_listing_btn_icon', 'stm-service-icon-listing_car_plus' ); ?>
							</a>
						</li>
						<?php endif; ?>
						<?php if ( stm_me_get_wpcfto_mod( 'header_show_profile', false ) ) : ?>
							<li>
								<div class="lOffer-account-unit">
									<a href="<?php echo esc_url( stm_get_author_link( 'register' ) ); ?>"
										class="lOffer-account">
										<?php
										if ( is_user_logged_in() ) :
											$user_fields = stm_get_user_custom_fields( '' );
											if ( ! empty( $user_fields['image'] ) ) :
												?>
												<div class="stm-dropdown-user-small-avatar">
													<img src="<?php echo esc_url( $user_fields['image'] ); ?>" class="im-responsive"/>
												</div>
											<?php endif; ?>
										<?php endif; ?>
										<?php echo stm_me_get_wpcfto_icon( 'header_profile_icon', 'stm-service-icon-user' ); ?>
									</a>
									<?php get_template_part( 'partials/user/user', 'dropdown' ); ?>
									<?php get_template_part( 'partials/user/private/mobile/user' ); ?>
								</div>
							</li>
						<?php endif; ?>
					<?php endif; ?>
					<?php if ( stm_me_get_wpcfto_mod( 'hma_search_button', false ) ) : ?>
						<li class="nav-search">
							<a href="#!" data-toggle="modal" data-target="#searchModal">
								<?php echo stm_me_get_wpcfto_icon( 'hma_search_button_icon', 'stm-icon-search' ); ?>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
			<div class="main-menu">
				<ul class="header-menu clearfix" style="<?php echo stm_me_wpcfto_parse_spacing( stm_me_get_wpcfto_mod( 'menu_top_margin', array( 'top' => '0' ) ) ); ?>">
					<?php
					$location = ( has_nav_menu( 'primary' ) ) ? 'primary' : '';

					wp_nav_menu(
						array(
							'menu'           => $location,
							'theme_location' => $location,
							'depth'          => 5,
							'container'      => false,
							'menu_class'     => 'header-menu clearfix',
							'items_wrap'     => '%3$s',
							'fallback_cb'    => false,
						)
					);
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
