<div class="archive-listing-page">
	<div class="container">
		<?php
		wp_enqueue_script( 'stm_grecaptcha' );
		$boats_template = stm_me_get_wpcfto_mod( 'listing_boat_filter', false );
		$post_types     = stm_listings_multi_type( false );

		if ( is_post_type_archive( $post_types ) || stm_is_dealer_two() || is_listing( array( 'listing', 'listing_two', 'listing_three' ) ) ) {
			get_template_part( 'partials/listing-cars/listing-directory', 'archive', $__vars );
		} elseif ( stm_is_boats() && $boats_template ) {
			get_template_part( 'partials/listing-cars/listing-boats', 'archive', $__vars );
		} elseif ( stm_is_motorcycle() ) {
			require_once locate_template( 'partials/listing-cars/motos/listing-motos-archive.php' );
		} else {
			get_template_part( 'partials/listing-cars/listing', 'archive', $__vars );
		}
		?>
	</div>
</div>
