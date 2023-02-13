<?php
$top_bar  = stm_me_get_wpcfto_mod( 'top_bar_enable', false );
$logo_url = stm_me_get_wpcfto_img_src( 'logo', get_template_directory_uri() );

$fixed_header = stm_me_get_wpcfto_mod( 'header_sticky', false );
if ( ! empty( $fixed_header ) and $fixed_header ) {
	$fixed_header_class = 'header-listing-fixed';
} else {
	$fixed_header_class = 'header-listing-unfixed';
}

$transparent_header = get_post_meta( get_the_ID(), 'transparent_header', true );

$transparent_header_class = ( $transparent_header ) ? 'transparent-header' : '';

if ( function_exists( 'WC' ) ) {
	$woocommerce_shop_page_id = wc_get_cart_url();
}

$langs = apply_filters( 'wpml_active_languages', null, null );

$header_listing_btn_text = stm_me_get_wpcfto_mod( 'header_listing_btn_text', esc_html__( 'Add your item', 'motors' ) );

$header_listing_btn_link = ( is_listing( array( 'listing_five' ) ) && function_exists( 'stm_c_f_get_page_url' ) ) ? stm_c_f_get_page_url( 'add_listing' ) : stm_me_get_wpcfto_mod( 'header_listing_btn_link', '/add-car' );
$header_listing_btn_link = ( is_listing( array( 'listing_six' ) ) && function_exists( 'stm_c_six_get_page_url' ) ) ? stm_c_six_get_page_url( 'add_listing' ) : $header_listing_btn_link;
$header_profile          = stm_me_get_wpcfto_mod( 'header_show_profile', false );

$phoneLabel = stm_me_get_wpcfto_mod( 'header_main_phone_label', 'Call Free' );
$phone      = stm_me_get_wpcfto_mod( 'header_main_phone', '+1 212-226-3126' );
?>
<div id="header" class="<?php echo esc_attr( $transparent_header_class ); ?>"><!--HEADER-->
	<?php
	if ( $top_bar ) {
		get_template_part( 'partials/header/header-classified-five/top-bar' );}
	?>

	<div class="header-main header-main-listing-five <?php echo esc_attr( $fixed_header_class ); ?> <?php echo ( wp_is_mobile() ) ? 'header-main-mobile' : ''; ?>">
		<div class="container">
			<div class="row header-row" >
				<div class="col-md-2 col-sm-12 col-xs-12">
					<div class="stm-header-left">
						<div class="logo-main" style="<?php echo stm_me_wpcfto_parse_spacing( stm_me_get_wpcfto_mod( 'logo_margin_top', array( 'top' => '0' ) ) ); ?>">
							<?php if ( stm_img_exists_by_url( $logo_url ) ) : ?>
								<a class="bloglogo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
									<img src="<?php echo esc_url( $logo_url ); ?>"
										style="width: <?php echo stm_me_get_wpcfto_mod( 'logo_width', '138' ); ?>px;"
										title="<?php esc_attr_e( 'Home', 'motors' ); ?>"
										alt="<?php esc_attr_e( 'Logo', 'motors' ); ?>"
									/>
								</a>
							<?php else : ?>
								<a class="blogname" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Home', 'motors' ); ?>">
									<h1><?php echo esc_attr( get_bloginfo( 'name' ) ); ?></h1>
								</a>
							<?php endif; ?>
							<div class="mobile-menu-trigger visible-sm visible-xs">
								<span></span>
								<span></span>
								<span></span>
							</div>
						</div>
					</div>
					<?php
						$compare_page = ( defined( 'ULISTING_VERSION' ) && is_listing( array( 'listing_five', 'listing_six' ) ) ) ? \uListing\Classes\StmListingSettings::getPages( 'compare_page' ) : stm_me_get_wpcfto_mod( 'compare_page', 156 );

						$show_compare  = stm_me_get_wpcfto_mod( 'header_compare_show', false );
						$wishlist_page = ( defined( 'ULISTING_VERSION' ) && is_listing( array( 'listing_five', 'listing_six' ) ) ) ? \uListing\Classes\StmListingSettings::getPages( 'wishlist_page' ) : null;
						$account_link  = ( defined( 'ULISTING_VERSION' ) && is_listing( array( 'listing_five' ) ) ) ? stm_c_f_get_page_url( 'account_page' ) : stm_get_author_link( 'register' );
						$account_link  = ( defined( 'ULISTING_VERSION' ) && is_listing( array( 'listing_six' ) ) ) ? stm_c_six_get_page_url( 'account_page' ) : $account_link;
					?>
					<div class="mobile-menu-holder">
						<div class="account-lang-wrap">
							<?php get_template_part( 'partials/header/header-classified-five/parts/lang-switcher' ); ?>
						</div>
						<?php stm_getCurrencySelectorHtml(); ?>
						<div class="mobile-menu-wrap">
							<ul class="header-menu clearfix">
								<?php
								$location = ( has_nav_menu( 'primary' ) ) ? 'primary' : '';

								wp_nav_menu(
									array(
										'theme_location' => $location,
										'depth'          => 5,
										'container'      => false,
										'items_wrap'     => '%3$s',
										'fallback_cb'    => false,
									)
								);
								?>
								<?php if ( is_listing() && $header_profile ) : ?>
									<li>
										<a href="<?php echo esc_url( $account_link ); ?>">
											<?php echo esc_html__( 'Account', 'motors' ); ?>
										</a>
									</li>
								<?php endif; ?>

								<?php if ( $show_compare ) : ?>
								<li>
									<a class="lOffer-compare" href="<?php echo esc_url( get_the_permalink( $compare_page ) ); ?>">
										<?php echo esc_html__( 'Compare', 'motors' ); ?>
									</a>
								</li>
								<?php endif; ?>

								<?php if ( ! empty( $wishlist_page ) ) : ?>
									<li>
										<a href="<?php echo esc_url( get_the_permalink( $wishlist_page ) ); ?>"><?php esc_html_e( 'Wishlist', 'motors' ); ?></a>
									</li>
								<?php endif; ?>

								<?php if ( stm_me_get_wpcfto_mod( 'header_show_add_car_button', false ) && is_listing() ) : ?>
									<li>
										<a class="add-listing-btn stm-button heading-font" href="<?php echo esc_html( $header_listing_btn_link ); ?>">
											<?php echo esc_html( $header_listing_btn_text ); ?>
										</a>
									</li>
								<?php endif; ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-10 hidden-sm hidden-xs">
					<div class="stm-header-right" style="<?php echo stm_me_wpcfto_parse_spacing( stm_me_get_wpcfto_mod( 'menu_icon_top_margin', '' ) ); ?>">
						<div class="main-menu" style="<?php echo stm_me_wpcfto_parse_spacing( stm_me_get_wpcfto_mod( 'menu_top_margin', array( 'top' => '0' ) ) ); ?>">
							<ul class="header-menu clearfix">
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

						<?php if ( stm_is_listing_six() ) : ?>
							<div class="head-phone-wrap">
								<div class="ph-title heading-font">
									<?php echo stm_dynamic_string_translation( 'Header Equipment call free', $phoneLabel ); ?>
								</div>
								<div class="phone heading-font">
									<?php echo esc_html( $phone ); ?>
								</div>
							</div>
						<?php endif; ?>

						<?php get_template_part( 'partials/header/header-classified-five/parts/compare' ); ?>
						<?php get_template_part( 'partials/header/parts/cart' ); ?>

						<?php if ( is_listing() ) : ?>

							<?php
							if ( $header_profile ) {
								get_template_part( 'partials/header/header-classified-five/parts/account' );}
							?>

							<?php if ( stm_me_get_wpcfto_mod( 'header_show_add_car_button', false ) ) : ?>
								<div class="stm-c-f-add-btn-wrap">
									<a class="add-listing-btn stm-button heading-font"
									   href="<?php echo esc_html( $header_listing_btn_link ); ?>">
										<?php echo stm_me_get_wpcfto_icon( 'header_listing_btn_icon', 'fas fa-plus' ); ?>
										<?php echo esc_html( $header_listing_btn_text ); ?>
									</a>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div> <!--container-->
	</div> <!--header-main-->
</div><!--HEADER-->

