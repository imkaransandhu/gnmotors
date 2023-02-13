<?php get_header(); ?>
	<?php
	$container_class = 'stm-single-post';

	// check for multilisting
	$is_multilisting_single = false;
	if ( stm_is_multilisting() ) {
		$types = stm_listings_multi_type( false );
		if ( ! empty( $types ) && is_singular( $types ) ) {
			$is_multilisting_single = true;
			$container_class        = 'stm-single-car-page';
		}
	}

	if ( false === $is_multilisting_single ) {
		if ( stm_is_magazine() ) {
			get_template_part( 'partials/magazine/content/breadcrumbs' );
		} else {
			get_template_part( 'partials/page_bg' );
			get_template_part( 'partials/title_box' );
		}
	}
	?>
	<div id="post-<?php get_the_ID(); ?>" <?php post_class(); ?>>
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="container">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					if ( true === $is_multilisting_single ) {

						$vc_status = get_post_meta( get_the_ID(), '_wpb_vc_js_status', true );

						if ( 'true' === $vc_status ) {
							the_content();
						} else {
							$template = 'partials/single-car/car-main';
							if ( is_listing() ) {
								$template = 'partials/single-car-listing/car-main';
							} elseif ( stm_is_listing_four() ) {
								$template = 'partials/single-car-listing/car-main-four';
							} elseif ( stm_is_boats() ) {
								$template = 'partials/single-car-boats/boat-main';
							} elseif ( stm_is_motorcycle() ) {
								$template = 'partials/single-car-motorcycle/car-main';
							} elseif ( stm_is_aircrafts() ) {
								$template = 'partials/single-aircrafts/aircrafts-main';
							}

							get_template_part( $template );
						}
					} else {
						if ( ! stm_is_magazine() ) {
							get_template_part( 'partials/blog/content' );
						} else {
							get_template_part( 'partials/magazine/main' );
						}
					}
				endwhile;
			endif;
			?>
			</div>
		</div>
	</div>
<?php get_footer(); ?>
