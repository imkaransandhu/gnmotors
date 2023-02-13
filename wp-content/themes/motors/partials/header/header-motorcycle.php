<?php
$logo_url = stm_me_get_wpcfto_img_src( 'logo', get_template_directory_uri() );

$fixed_header = stm_me_get_wpcfto_mod( 'header_sticky', false );
if ( ! empty( $fixed_header ) and $fixed_header ) {
	$fixed_header_class = 'header-listing-fixed';
} else {
	$fixed_header_class = 'header-listing-unfixed';
}

if ( is_listing() ) {
	$fixed_header_class .= ' is-listing';
}

$show_main_phone_on_mobile = true;

if ( wp_is_mobile() && ! stm_me_get_wpcfto_mod( 'header_main_phone_show_on_mobile', false ) ) {
	$show_main_phone_on_mobile = false;
}

$header_main_phone = stm_me_get_wpcfto_mod( 'header_main_phone', '878-9671-4455' );

$header_listing_btn_link = stm_me_get_wpcfto_mod( 'header_listing_btn_link', '/add-a-car' );
$header_listing_btn_text = stm_me_get_wpcfto_mod( 'header_listing_btn_text', esc_html__( 'Add your item', 'motors' ) );
$logo_width              = stm_me_get_wpcfto_mod( 'logo_width', '138' );
$socials                 = stm_get_header_socials( 'header_socials_enable' );
?>
<div class="stm_motorcycle-header <?php echo esc_attr( $fixed_header_class ); ?>  <?php echo ( wp_is_mobile() ) ? 'header-main-mobile' : ''; ?>">
	<?php if ( $show_main_phone_on_mobile ) : ?>
	<div class="stm_mc-main header-main">
		<div class="container clearfix">
			<div class="left">
				<div class="clearfix">
					<!--Socials-->
					<?php
					if ( ! empty( $socials ) ) :
						?>
						<div class="pull-left">
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
				</div>
			</div>
			<div class="right">
					<?php if ( stm_img_exists_by_url( $logo_url ) ) : ?>
						<a class="bloglogo hidden-xs" href="<?php echo esc_url( home_url( '/' ) ); ?>" style="<?php echo stm_me_wpcfto_parse_spacing( stm_me_get_wpcfto_mod( 'logo_margin_top', '' ) ); ?>">
							<img
								src="<?php echo esc_url( $logo_url ); ?>"
								style="width: <?php echo esc_attr( $logo_width ); ?>px;"
								title="<?php esc_attr_e( 'Home', 'motors' ); ?>"
								alt="<?php esc_attr_e( 'Logo', 'motors' ); ?>"
							/>
						</a>
					<?php else : ?>
						<a class="blogname hidden-xs" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Home', 'motors' ); ?>">
							<h1><?php echo esc_attr( get_bloginfo( 'name' ) ); ?></h1>
						</a>
					<?php endif; ?>
				<div class="right-right">
					<div class="clearfix">
						<?php if ( ! empty( $header_main_phone ) && $show_main_phone_on_mobile ) : ?>
							<div class="pull-right">
								<div class="header-main-phone heading-font">
									<div class="phone">
										<span class="phone-number heading-font"><a href="tel:<?php echo preg_replace( '/\s/', '', $header_main_phone ); ?>"><?php stm_dynamic_string_translation_e( 'Phone Number', $header_main_phone ); ?></a></span>
									</div>
								</div>
							</div>
						<?php endif; ?>

						<?php get_template_part( 'partials/header/parts/profile' ); ?>

						<?php get_template_part( 'partials/header/parts/cart' ); ?>

						<?php get_template_part( 'partials/header/parts/compare' ); ?>

					</div>
				</div>

			</div>
		</div>
	</div>
	<?php endif; ?>

	<div class="stm_mc-nav">
		<div class="mobile-logo-wrap">
			<?php if ( empty( $logo_url ) ) : ?>
				<a class="blogname" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php _e( 'Home', 'motors' ); ?>">
					<h1><?php echo esc_attr( get_bloginfo( 'name' ) ); ?></h1>
				</a>
			<?php else : ?>
				<a class="bloglogo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img
						src="<?php echo esc_url( $logo_url ); ?>"
						style="width: <?php echo esc_attr( stm_me_get_wpcfto_mod( 'logo_width', '138' ) ); ?>px;"
						title="<?php esc_attr_e( 'Home', 'motors' ); ?>"
						alt="<?php esc_attr_e( 'Logo', 'motors' ); ?>"
						/>
				</a>
			<?php endif; ?>
		</div>
		<?php if ( wp_is_mobile() && is_listing() ) : ?>
			<div class="mobile-pull-right">
				<?php get_template_part( 'partials/header/parts/add_a_car' ); ?>
				<?php get_template_part( 'partials/header/parts/profile' ); ?>
			</div>
		<?php endif; ?>
		<div class="mobile-menu-trigger">
			<span></span>
			<span></span>
			<span></span>
		</div>
		<div class="main-menu hidden-xs">
			<div class="container">
				<div class="inner">
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

						if ( is_listing() && stm_me_get_wpcfto_mod( 'header_show_add_car_button', false ) && ! empty( $header_listing_btn_link ) && ! empty( $header_listing_btn_text ) ) {
							?>
							<li>
								<a href="<?php echo esc_url( $header_listing_btn_link ); ?>">
									<?php stm_dynamic_string_translation_e( 'Listing Button Text', $header_listing_btn_text ); ?>
								</a>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div>
			<div class="main-menu mobile-menu-holder">
				<div class="container">
					<div class="inner">
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

							get_template_part( 'partials/header/parts/mobile_menu_items' );
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
