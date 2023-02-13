<?php
if ( is_date() ) {
	get_template_part( 'index' );
} else {
	get_header();
	get_template_part( 'partials/title_box' );

	$recaptcha_enabled    = stm_me_get_wpcfto_mod( 'enable_recaptcha', 0 );
	$recaptcha_public_key = stm_me_get_wpcfto_mod( 'recaptcha_public_key' );
	$recaptcha_secret_key = stm_me_get_wpcfto_mod( 'recaptcha_secret_key' );

	if ( ! empty( $recaptcha_enabled ) && $recaptcha_enabled && ! empty( $recaptcha_public_key ) && ! empty( $recaptcha_secret_key ) ) {
		wp_enqueue_script( 'stm_grecaptcha' );
	}

	stm_listings_load_template( 'filter/inventory/main' );

	get_footer();
}
