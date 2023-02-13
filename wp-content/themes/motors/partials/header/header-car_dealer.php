<?php
$logo_url   = stm_me_get_wpcfto_img_src( 'logo', get_template_directory_uri() );
$logo_width = stm_me_get_wpcfto_mod( 'logo_width', '138' );

$compare_page = stm_me_get_wpcfto_mod( 'compare_page', 156 );
if ( function_exists( 'WC' ) ) {
	$woocommerce_shop_page_id = wc_get_cart_url();
}

$user = wp_get_current_user();

if ( ! is_wp_error( $user ) && ! empty( $user->data->ID ) ) {
	$stm_account_page_link = ( stm_is_listing_five() && function_exists( 'stm_c_f_get_page_url' ) ) ? stm_c_f_get_page_url( 'account_page' ) : stm_get_author_link( $user->data->ID );
} else {
	$stm_account_page_link = ( stm_is_listing_five() && function_exists( 'stm_c_f_get_page_url' ) ) ? stm_c_f_get_page_url( 'account_page' ) : stm_get_author_link( 'register' );
}

$stm_account_page_link = ( stm_is_listing_six() ) ? stm_c_six_get_page_url( 'account_page' ) : $stm_account_page_link;

$header_secondary_phone_1       = stm_me_get_wpcfto_mod( 'header_secondary_phone_1', '878-3971-3223' );
$header_secondary_phone_2       = stm_me_get_wpcfto_mod( 'header_secondary_phone_2', '878-0910-0770' );
$header_secondary_phone_label_1 = stm_me_get_wpcfto_mod( 'header_secondary_phone_label_1', 'Service' );
$header_secondary_phone_label_2 = stm_me_get_wpcfto_mod( 'header_secondary_phone_label_2', 'Parts' );
$header_main_phone              = stm_me_get_wpcfto_mod( 'header_main_phone', '878-9671-4455' );
$header_main_phone_label        = stm_me_get_wpcfto_mod( 'header_main_phone_label', 'Sales' );
$header_address                 = stm_me_get_wpcfto_mod( 'header_address', '1840 E Garvey Ave South West Covina, CA 91791' );
$header_address_url             = stm_me_get_wpcfto_mod( 'header_address_url' );
$socials                        = stm_get_header_socials( 'header_socials_enable' );
$show_add_btn                   = stm_me_get_wpcfto_mod( 'header_show_add_car_button', false );
$header_profile                 = stm_me_get_wpcfto_mod( 'header_show_profile', false );
?>

<div class="header-main <?php echo ( wp_is_mobile() ) ? 'header-main-mobile' : ''; ?>">
	<div class="container">
		<div class="clearfix">
			<!--Logo-->
			<div class="logo-main <?php echo ( $show_add_btn ) ? 'showing_add_btn' : ''; ?> <?php echo ( $header_profile ) ? 'showing_profile_btn' : ''; ?>" style="<?php echo esc_attr( stm_me_wpcfto_parse_spacing( stm_me_get_wpcfto_mod( 'logo_margin_top', '' ) ) ); ?>">
				<?php
				if ( stm_img_exists_by_url( $logo_url ) ) :
					?>
					<a class="bloglogo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img src="<?php echo esc_url( $logo_url ); ?>"
							style="width: <?php echo esc_attr( $logo_width ); ?>px;"
							title="<?php esc_attr_e( 'Home', 'motors' ); ?>"
							alt="<?php esc_attr_e( 'Logo', 'motors' ); ?>"
						/>
					</a>
					<?php
				else :
					?>
					<a class="blogname" href="<?php echo esc_url( home_url( '/' ) ); ?>"
						title="<?php esc_html_e( 'Home', 'motors' ); ?>">
						<h1><?php echo esc_attr( get_bloginfo( 'name' ) ); ?></h1>
					</a>
					<?php
				endif;

				if ( is_listing() && 'car_dealer' === stm_get_header_layout() ) :
					?>
					<div class="mobile-pull-right">
						<?php
						$header_listing_btn_link = stm_me_get_wpcfto_mod( 'header_listing_btn_link', '/add-car' );
						$header_listing_btn_text = stm_me_get_wpcfto_mod( 'header_listing_btn_text', 'Add your item' );
						?>
						<?php if ( true === $show_add_btn && ! empty( $header_listing_btn_link ) && ! empty( $header_listing_btn_text ) ) : ?>
							<a href="<?php echo esc_url( $header_listing_btn_link ); ?>" class="listing_add_cart heading-font">
								<div>
									<?php echo wp_kses_post( stm_me_get_wpcfto_icon( 'header_listing_btn_icon', 'stm-lt-icon-add_car' ) ); ?>
								</div>
							</a>
							<?php
						endif;

						if ( $header_profile ) :
							?>
							<div class="lOffer-account-unit">
								<a href="<?php echo esc_url( stm_get_author_link( 'register' ) ); ?>" class="lOffer-account">
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
									<?php echo wp_kses_post( stm_me_get_wpcfto_icon( 'header_profile_icon', 'stm-service-icon-user' ) ); ?>
								</a>
								<?php get_template_part( 'partials/user/user', 'dropdown' ); ?>
								<?php get_template_part( 'partials/user/private/mobile/user' ); ?>
							</div>
						<?php endif; ?>
					</div>
					<?php
				endif;

				if ( ! empty( $header_main_phone ) || ! empty( $header_secondary_phone_1 ) || ! empty( $header_secondary_phone_2 ) || ! empty( $header_address ) ) :
					?>
					<div class="mobile-contacts-trigger visible-sm visible-xs">
						<i class="stm-icon-phone-o"></i>
						<i class="stm-icon-close-times"></i>
					</div>
					<?php
				endif;
				?>

				<div class="mobile-menu-trigger visible-sm visible-xs">
					<span></span>
					<span></span>
					<span></span>
				</div>
			</div>

			<div class="mobile-menu-holder">
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

					if ( is_listing() && 'car_dealer' === stm_get_header_layout() ) {
						$header_listing_btn_link = stm_me_get_wpcfto_mod( 'header_listing_btn_link', 'add-car' );
						$header_listing_btn_text = stm_me_get_wpcfto_mod( 'header_listing_btn_text', 'Add your item' );

						if ( stm_me_get_wpcfto_mod( 'header_show_add_car_button', false ) && ! empty( $header_listing_btn_link ) && ! empty( $header_listing_btn_text ) ) {
							?>
							<li class="stm_add_car_mobile">
								<a href="<?php echo esc_url( $header_listing_btn_link ); ?>"
									class="listing_add_cart heading-font">
									<?php stm_dynamic_string_translation_e( 'Add A Car Button label in header', $header_listing_btn_text ); ?>
								</a>
							</li>
							<?php
						}
					}
					?>
					<li class="stm_compare_mobile">
						<a href="<?php echo esc_url( $stm_account_page_link ); ?>">
							<?php esc_html_e( 'Account', 'motors' ); ?>
						</a>
					</li>
					<?php echo wp_kses_post( apply_filters( 'stm_vin_decoder_mobile_menu', '' ) ); ?>
					<?php if ( ! empty( $compare_page ) && stm_me_get_wpcfto_mod( 'header_compare_show', false ) ) : ?>
						<li class="stm_compare_mobile">
							<a href="<?php echo esc_url( get_the_permalink( $compare_page ) ); ?>">
								<?php esc_html_e( 'Compare', 'motors' ); ?>
							</a>
						</li>
					<?php endif; ?>
					<?php if ( ! empty( $woocommerce_shop_page_id ) && stm_me_get_wpcfto_mod( 'header_cart_show', false ) ) : ?>
						<li class="stm_cart_mobile">
							<a href="<?php echo esc_url( $woocommerce_shop_page_id ); ?>">
								<?php esc_html_e( 'Cart', 'motors' ); ?>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>

			<div class="top-info-wrap">
				<div class="header-top-info">
					<div class="clearfix">
						<!-- Header top bar Socials -->
						<?php if ( ! empty( $socials ) ) : ?>
							<div class="pull-right">
								<div class="header-main-socs">
									<ul class="clearfix">
										<?php foreach ( $socials as $key => $val ) : ?>
											<li>
												<a href="<?php echo esc_url( $val ); ?>" target="_blank">
													<i class="fab fa-<?php echo esc_attr( $key ); ?>"></i>
												</a>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $header_secondary_phone_1 ) || ! empty( $header_secondary_phone_2 ) ) : ?>
							<div class="pull-right">
								<div class="header-secondary-phone header-secondary-phone-single">
									<?php if ( ! empty( $header_secondary_phone_1 ) ) : ?>
										<div class="phone">
											<?php if ( ! empty( $header_secondary_phone_label_1 ) ) : ?>
												<span class="phone-label">
													<?php stm_dynamic_string_translation_e( 'Phone Label One', $header_secondary_phone_label_1 ); ?>
												</span>
											<?php endif; ?>
											<span class="phone-number heading-font">
												<a href="tel:<?php stm_dynamic_string_translation_e( 'Phone Number One', $header_secondary_phone_1 ); ?>">
													<?php stm_dynamic_string_translation_e( 'Phone Number One', $header_secondary_phone_1 ); ?>
												</a>
											</span>
										</div>
									<?php endif; ?>
									<?php if ( ! empty( $header_secondary_phone_2 ) ) : ?>
										<div class="phone">
											<?php if ( ! empty( $header_secondary_phone_label_2 ) ) : ?>
												<span class="phone-label">
													<?php stm_dynamic_string_translation_e( 'Phone Label Two', $header_secondary_phone_label_2 ); ?>
												</span>
											<?php endif; ?>
											<span class="phone-number heading-font">
												<a href="tel:<?php stm_dynamic_string_translation_e( 'Phone Number Two', $header_secondary_phone_2 ); ?>">
													<?php stm_dynamic_string_translation_e( 'Phone Number One', $header_secondary_phone_2 ); ?>
												</a>
											</span>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
						<!--Header main phone-->
						<?php if ( ! empty( $header_main_phone ) ) : ?>
							<div class="pull-right">
								<div class="header-main-phone heading-font">
									<?php echo wp_kses_post( stm_me_get_wpcfto_icon( 'header_main_phone_icon', 'stm-icon-phone' ) ); ?>
									<div class="phone">
										<?php if ( ! empty( $header_main_phone_label ) ) : ?>
											<span class="phone-label">
												<?php stm_dynamic_string_translation_e( 'Header Phone Label', $header_main_phone_label ); ?>
											</span>
										<?php endif; ?>
										<span class="phone-number heading-font">
											<a href="tel:<?php echo esc_attr( preg_replace( '/\s/', '', $header_main_phone ) ); ?>">
												<?php stm_dynamic_string_translation_e( 'Header Phone', $header_main_phone ); ?>
											</a>
										</span>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<!--Header address-->
						<?php if ( ! empty( $header_address ) ) : ?>
							<div class="pull-right">
								<div class="header-address">
									<?php echo wp_kses_post( stm_me_get_wpcfto_icon( 'header_address_icon', 'stm-icon-pin' ) ); ?>
									<div class="address">
										<?php if ( ! empty( $header_address ) ) : ?>
											<span class="heading-font">
												<?php stm_dynamic_string_translation_e( 'Header address', $header_address ); ?>
											</span>
											<?php if ( ! empty( $header_address_url ) ) : ?>
												<span id="stm-google-map"
													class="fancy-iframe"
													data-iframe="true"
													data-src="<?php echo esc_url( $header_address_url ); ?>"
												>
													<?php esc_html_e( 'View on map', 'motors' ); ?>
												</span>
											<?php endif; ?>
										<?php endif; ?>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div> <!--clearfix-->
				</div> <!--header-top-info-->
			</div> <!-- Top info wrap -->
		</div> <!--clearfix-->
	</div> <!--container-->
</div> <!--header-main-->
<?php
get_template_part( 'partials/header/header-nav' );
