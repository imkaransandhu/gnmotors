<?php
if ( apply_filters( 'stm_equip_single', false ) ) {
	do_action( 'stm_equip_single_template' );
} else {
	if ( stm_is_magazine() ) {
		add_filter( 'body_class', 'stm_listing_magazine_body_class' );
	}

	get_header();

	if ( ! stm_is_aircrafts() ) :

		get_template_part( 'partials/page_bg' );
		get_template_part( 'partials/title_box' );
		?>

		<div class="stm-single-car-page single-listings-template">
			<?php
			if ( stm_is_motorcycle() ) {
				get_template_part( 'partials/single-car-motorcycle/tabs' );
			}

			$recaptcha_enabled    = stm_me_get_wpcfto_mod( 'enable_recaptcha', 0 );
			$recaptcha_public_key = stm_me_get_wpcfto_mod( 'recaptcha_public_key' );
			$recaptcha_secret_key = stm_me_get_wpcfto_mod( 'recaptcha_secret_key' );
			if ( ! empty( $recaptcha_enabled ) && $recaptcha_enabled && ! empty( $recaptcha_public_key ) && ! empty( $recaptcha_secret_key ) ) {
				wp_enqueue_script( 'stm_grecaptcha' );
			}
			?>

			<div class="container">
				<?php
				if ( have_posts() ) :

					$template = 'partials/single-car/car-main';
					if ( is_listing( array( 'listing', 'listing_two', 'listing_three', 'listing_three_elementor', 'listing_five' ) ) ) {
						$template = 'partials/single-car-listing/car-main';
					} elseif ( stm_is_listing_four() ) {
						$template = 'partials/single-car-listing/car-main-four';
					} elseif ( stm_is_boats() ) {
						$template = 'partials/single-car-boats/boat-main';
					} elseif ( stm_is_motorcycle() ) {
						$template = 'partials/single-car-motorcycle/car-main';
					}

					while ( have_posts() ) :
						the_post();
						$vc_status = get_post_meta( get_the_ID(), '_wpb_vc_js_status', true );

						if ( class_exists( 'Motors_E_W\MotorsApp' ) ) {
							\Motors_E_W\Helpers\TemplateManager::motors_display_template();
						} elseif ( 'true' === $vc_status ) {
							the_content();
						} else {
							get_template_part( $template );
						}

					endwhile;

				endif;
				?>
			</div> <!-- container -->

		</div> <!--single car page-->

		<?php
	else :
		echo '<div class="container">';
		get_template_part( 'partials/page_bg' );
		get_template_part( 'partials/single-aircrafts/title' );
		echo '</div>';

		get_template_part( 'partials/single-aircrafts/gallery' );
		?>
		<div class="stm-single-car-page">
			<div class="container">
				<?php
				if ( have_posts() ) :

					$template = 'partials/single-aircrafts/aircrafts-main';

					while ( have_posts() ) :
						the_post();

						$vc_status = get_post_meta( get_the_ID(), '_wpb_vc_js_status', true );

						if ( 'true' === $vc_status ) {
							the_content();
						} else {
							get_template_part( $template );
						}

					endwhile;

				endif;
				?>
			</div>
		</div>
		<?php
	endif;

	get_footer();
}
