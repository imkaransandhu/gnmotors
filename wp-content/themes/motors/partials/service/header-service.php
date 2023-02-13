<?php
$logo_url     = stm_me_get_wpcfto_img_src( 'logo', get_template_directory_uri() );
$fixed_header = stm_me_get_wpcfto_mod( 'header_sticky', false );

if ( ! empty( $fixed_header ) && $fixed_header ) {
	$fixed_header_class = 'header-service-fixed';
} else {
	$fixed_header_class = '';
}

$transparent_header = get_post_meta( get_the_id(), 'transparent_header', true );
if ( $transparent_header ) {
	$transparent_header_class = 'service-transparent-header';
} else {
	$transparent_header_class = 'service-notransparent-header';
}

?>

<div class="header-service <?php echo esc_attr( $fixed_header_class . ' ' . $transparent_header_class ); ?> <?php echo ( wp_is_mobile() ) ? 'header-main-mobile' : ''; ?>">
	<div class="container">
		<!--Logo-->
		<div class="service-logo-main" style="<?php echo esc_attr( stm_me_wpcfto_parse_spacing( stm_me_get_wpcfto_mod( 'logo_margin_top', '' ) ) ); ?>">
			<?php if ( stm_img_exists_by_url( $logo_url ) ) : ?>
				<a class="bloglogo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img
						src="<?php echo esc_url( $logo_url ); ?>"
						style="width: <?php echo esc_attr( stm_me_get_wpcfto_mod( 'logo_width', '138' ) ); ?>px;"
						title="<?php esc_attr_e( 'Home', 'motors' ); ?>"
						alt="<?php esc_attr_e( 'Logo', 'motors' ); ?>"
					/>
				</a>
			<?php else : ?>
				<a class="blogname" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Home', 'motors' ); ?>">
					<h1>
						<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
					</h1>
				</a>
			<?php endif; ?>
		</div>

		<div class="header-service-right clearfix">
			<?php
				$service_header_label = stm_me_get_wpcfto_mod( 'service_header_label', esc_html__( 'Make an Appointment', 'motors' ) );
				$service_header_link  = stm_me_get_wpcfto_mod( 'service_header_link', '#appointment-form' );
			?>

			<div class="service-mobile-menu-trigger visible-sm visible-xs">
				<span></span>
				<span></span>
				<span></span>
			</div>		

			<?php if ( ! empty( $service_header_label ) && ! empty( $service_header_link ) ) : ?>
				<a href="<?php echo esc_url( $service_header_link ); ?>" class="button_3d white service-header-appointment heading-font">
					<div class="default-state">
						<i class="stm-service-icon-appointment_calendar"></i><?php stm_dynamic_string_translation_e( 'Service Header Label', $service_header_label ); ?>
						<span class="active-state">
							<i class="stm-service-icon-appointment_calendar"></i><?php stm_dynamic_string_translation_e( 'Service Header Label', $service_header_label ); ?>
						</span>
					</div>
				</a>
			<?php endif; ?>

			<ul class="header-menu clearfix">
				<?php
				wp_nav_menu(
					array(
						'menu'           => 'primary',
						'theme_location' => 'primary',
						'depth'          => 3,
						'container'      => false,
						'menu_class'     => 'service-header-menu clearfix',
						'items_wrap'     => '%3$s',
						'fallback_cb'    => false,
					)
				);
				?>
			</ul>
		</div>
	</div>
</div>
