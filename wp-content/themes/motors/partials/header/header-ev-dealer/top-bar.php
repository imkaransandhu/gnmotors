<?php
$top_bar_address       = stm_me_get_wpcfto_mod( 'top_bar_address', '' );
$top_bar_working_hours = stm_me_get_wpcfto_mod( 'top_bar_working_hours', '' );
$header_address_url    = stm_me_get_wpcfto_mod( 'header_address_url', '' );
$top_bar_phone         = stm_me_get_wpcfto_mod( 'top_bar_phone', '' );
$top_bar_menu          = stm_me_get_wpcfto_mod( 'top_bar_menu', false );
?>

<div class="top-bar-wrap">
	<div class="container">
		<div class="stm-c-f-top-bar">
			<?php
			stm_getCurrencySelectorHtml();
			?>
			<?php if ( ! empty( $top_bar_address ) ) : ?>
				<div class="stm-top-address-wrap">
					<span id="top-bar-address" class="
					<?php
					if ( ! empty( $header_address_url ) ) {
						echo 'fancy-iframe';}
					?>
					" data-iframe="true" data-src="<?php echo esc_url( $header_address_url ); ?>">
						<?php echo wp_kses_post( stm_me_get_wpcfto_icon( 'top_bar_address_icon', 'fa fa-map-marker' ) ); ?> <?php stm_dynamic_string_translation_e( 'Top Bar Address', $top_bar_address ); ?>
					</span>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $top_bar_working_hours ) ) : ?>
				<div class="stm-top-address-wrap">
					<span id="top-bar-info">
						<?php echo wp_kses_post( stm_me_get_wpcfto_icon( 'top_bar_working_hours_icon', 'fas fa-clock' ) ); ?> <?php stm_dynamic_string_translation_e( 'Top Bar Working Hours', $top_bar_working_hours ); ?>
					</span>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $top_bar_phone ) ) : ?>
				<div class="stm-top-address-wrap">
					<span id="top-bar-phone">
						<?php echo wp_kses_post( stm_me_get_wpcfto_icon( 'top_bar_phone_icon', 'fas fa-phone' ) ); ?> <a href="tel:<?php echo esc_attr( $top_bar_phone ); ?>"><?php stm_dynamic_string_translation_e( 'Top Bar Phone', $top_bar_phone ); ?></a>
					</span>
				</div>
				<?php
			endif;
			if ( $top_bar_menu ) :
				?>
			<!--Top Bar Menu-->
			<div class="pull-right top-bar-menu-wrap">
				<div class="top_bar_menu">
					<?php get_template_part( 'partials/top-bar', 'menu' ); ?>
				</div>
			</div>
			<?php endif; ?>
			<div class="pull-right">
				<?php get_template_part( 'partials/header/header-ev-dealer/parts/socials' ); ?>
			</div>
			<?php get_template_part( 'partials/top-bar-parts/top-bar-auth' ); ?>
		</div>
	</div>
</div>
