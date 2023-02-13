<?php
$show_favorite             = stm_me_get_wpcfto_mod( 'enable_favorite_items', false );
$show_compare              = stm_me_get_wpcfto_mod( 'show_listing_compare', false );
$gallery_hover_interaction = stm_me_get_wpcfto_mod( 'gallery_hover_interaction', false );

if ( stm_is_dealer_two() || stm_is_aircrafts() ) {
	$show_favorite = false;
}

/*Media*/
$car_media   = stm_get_car_medias( get_the_ID() );
$col         = ( ! empty( get_post_meta( stm_get_listing_archive_page_id(), 'quant_grid_items', true ) ) ) ? 12 / get_post_meta( stm_get_listing_archive_page_id(), 'quant_grid_items', true ) : 4;
$img_size    = ( ! stm_is_listing_two() ) ? 'stm-img-255-160' : 'stm-img-255-135';
$img_retina  = ( ! stm_is_listing_two() ) ? 'stm-img-255-160-x-2' : 'stm-img-255-135-x-2';
$placeholder = 'plchldr255.png';

if ( is_listing( array( 'listing_three' ) ) || ! empty( $__vars['is_cars_on_top'] ) ) {
	$img_size    = 'stm-img-350-205';
	$img_retina  = 'stm-img-350-205-x-2';
	$placeholder = 'plchldr350.png';
}

if ( wp_is_mobile() ) {
	$img_size    = ( ! stm_is_listing_two() ) ? 'stm-img-796-466' : 'stm-img-255-135-x-2';
	$placeholder = 'plchldr350.png';
	$img_retina  = 'stm-img-255-135-x-2';
}

if ( stm_is_dealer_two() ) {
	$img_size    = 'stm-img-398-223';
	$img_retina  = 'stm-img-398-223-x-2';
	$placeholder = 'plchldr-398.jpg';
}

if ( stm_is_aircrafts() ) {
	$placeholder = 'ac_plchldr.jpg';
}

if ( '6' === $col ) {
	$img_size    = 'stm-img-398-223';
	$img_retina  = 'stm-img-398-223-x-2';
	$placeholder = 'plchldr-398.jpg';
}

$photo_class = 'stm-car-photos-' . get_the_ID() . '-' . wp_rand( 1, 99 );
$video_class = 'stm-car-videos-' . get_the_ID() . '-' . wp_rand( 1, 99 );

?>
<div class="image">
	<?php
	$img = stm_get_thumbnail( get_post_thumbnail_id( get_the_ID() ), $img_size );
	if ( ! empty( $img_retina ) ) {
		$img_x2 = stm_get_thumbnail( get_post_thumbnail_id( get_the_ID() ), $img_retina );
	}

	if ( has_post_thumbnail() ) :
		if ( true === $gallery_hover_interaction && ! wp_is_mobile() ) {
			$thumbs = stm_get_hoverable_thumbs( get_the_ID(), $img_size );

			if ( empty( $thumbs['gallery'] ) || 1 === count( $thumbs['gallery'] ) ) :
				?>
				<img
					data-src="<?php echo esc_url( $img[0] ); ?>"
					srcset="<?php echo esc_url( $img[0] ); ?> 1x, <?php echo esc_url( $img_x2[0] ); ?> 2x"
					src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $placeholder ); ?>"
					class="lazy img-responsive"
					alt="<?php echo esc_attr( stm_get_img_alt( get_post_thumbnail_id( get_the_ID() ) ) ); ?>"
				/>
				<?php

				get_template_part( 'partials/listing-cars/listing-directory', 'badges' );
			else :
				$array_keys    = array_keys( $thumbs['gallery'] );
				$last_item_key = array_pop( $array_keys );
				?>
				<div class="interactive-hoverable">
					<div class="hoverable-wrap">
						<?php
						foreach ( $thumbs['gallery'] as $key => $img_url ) :
							?>
							<div class="hoverable-unit <?php echo ( 0 === $key ) ? 'active' : ''; ?>">
								<div class="thumb">
									<?php if ( $key === $last_item_key && 5 === count( $thumbs['gallery'] ) && 0 < $thumbs['remaining'] ) : ?>
										<div class="remaining">
											<i class="stm-icon-album"></i>
											<p>
												<?php
													echo esc_html(
														sprintf(
															/* translators: number of remaining photos */
															_n( '%d more photo', '%d more photos', $thumbs['remaining'], 'motors' ),
															$thumbs['remaining']
														)
													);
												?>
											</p>
										</div>
									<?php endif; ?>
									<?php if ( is_array( $img_url ) ) : ?>
										<img
												data-src="<?php echo esc_url( $img_url[0] ); ?>"
												srcset="<?php echo esc_url( $img_url[0] ); ?> 1x, <?php echo esc_url( $img_url[1] ); ?> 2x"
												src="<?php echo esc_url( $img_url[0] ); ?>"
												class="lazy img-responsive"
												alt="<?php echo esc_attr( get_the_title( get_the_ID() ) ); ?>" >
									<?php else : ?>
										<img src="<?php echo esc_url( $img_url ); ?>" class="lazy img-responsive" alt="<?php echo esc_attr( get_the_title( get_the_ID() ) ); ?>" >
									<?php endif; ?>
								</div>
							</div>
							<?php
						endforeach;

						get_template_part( 'partials/listing-cars/listing-directory', 'badges' );
						?>
					</div>
					<div class="hoverable-indicators">
						<?php
						$first = true;
						foreach ( $thumbs['gallery'] as $thumb ) :
							?>
							<div class="indicator <?php echo ( $first ) ? 'active' : ''; ?>"></div>
							<?php
							$first = false;
						endforeach;
						?>
					</div>
				</div>
				<?php
			endif;
		} else {
			?>
			<img
				data-src="<?php echo esc_url( $img[0] ); ?>"
				<?php if ( ! empty( $img_retina ) ) : ?>
				srcset="<?php echo esc_url( $img[0] ); ?> 1x, <?php echo esc_url( $img_x2[0] ); ?> 2x"
				<?php endif; ?>
				src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $placeholder ); ?>"
				class="lazy img-responsive"
				alt="<?php echo esc_attr( stm_get_img_alt( get_post_thumbnail_id( get_the_ID() ) ) ); ?>"
			/>
			<?php
			get_template_part( 'partials/listing-cars/listing-directory', 'badges' );
		}
	else :
		?>
		<img
			src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $placeholder ); ?>"
			class="img-responsive"
			alt="<?php esc_attr_e( 'Placeholder', 'motors' ); ?>"
		/>
		<?php

		get_template_part( 'partials/listing-cars/listing-directory', 'badges' );
	endif;
	?>

	<!---Media-->
	<div class="stm-car-medias">
		<?php if ( ! empty( $car_media['car_photos_count'] ) ) : ?>
			<div class="stm-listing-photos-unit stm-car-photos-<?php echo get_the_ID(); ?> <?php echo esc_attr( $photo_class ); ?>">
				<i class="stm-service-icon-photo"></i>
				<span><?php echo esc_html( $car_media['car_photos_count'] ); ?></span>
			</div>

			<script>
				jQuery(document).ready(function(){
					jQuery(".<?php echo esc_attr( $photo_class ); ?>").on('click', function(e) {
						e.preventDefault();
						jQuery(this).lightGallery({
							dynamic: true,
							dynamicEl: [
								<?php foreach ( $car_media['car_photos'] as $car_photo ) : ?>
								{
									src  : "<?php echo esc_url( $car_photo ); ?>",
									thumb: "<?php echo esc_url( $car_photo ); ?>"
								},
								<?php endforeach; ?>
							],
							download: false,
							mode: 'lg-fade',
						})
					});
				});

			</script>
		<?php endif; ?>
		<?php if ( ! empty( $car_media['car_videos_count'] ) ) : ?>
			<div class="stm-listing-videos-unit stm-car-videos-<?php echo get_the_ID(); ?> <?php echo esc_attr( $video_class ); ?>">
				<i class="fas fa-film"></i>
				<span><?php echo esc_html( $car_media['car_videos_count'] ); ?></span>
			</div>

			<script>
				jQuery(document).ready(function(){

					jQuery(".<?php echo esc_attr( $video_class ); ?>").on('click', function(e) {
						e.preventDefault();

						jQuery(this).lightGallery({
							dynamic: true,
							dynamicEl: [
								<?php foreach ( $car_media['car_videos'] as $car_video ) : ?>
								{
									src  : "<?php echo esc_url( $car_video ); ?>"
								},
								<?php endforeach; ?>
							],
							download: false,
							mode: 'lg-fade',
						})
					}); //click
				}); //ready

			</script>
		<?php endif; ?>
	</div>

	<!--Favorite-->
	<?php if ( ! empty( $show_favorite ) && $show_favorite ) : ?>
		<div
			class="stm-listing-favorite"
			data-id="<?php echo esc_attr( get_the_ID() ); ?>"
			data-toggle="tooltip" data-placement="right"
			title="<?php esc_attr_e( 'Add to favorites', 'motors' ); ?>"
		>
			<i class="stm-service-icon-staricon"></i>
		</div>
	<?php endif; ?>

	<!--Compare-->
	<?php if ( ! empty( $show_compare ) && $show_compare ) : ?>
		<div
			class="stm-listing-compare stm-compare-directory-new"
			data-post-type="<?php echo esc_attr( get_post_type( get_the_ID() ) ); ?>"
			data-id="<?php echo esc_attr( get_the_ID() ); ?>"
			data-title="<?php echo esc_attr( stm_generate_title_from_slugs( get_the_ID(), false ) ); ?>"
			data-toggle="tooltip" data-placement="left"
			title="<?php esc_attr_e( 'Add to compare', 'motors' ); ?>"
		>
			<i class="stm-service-icon-compare-new"></i>
		</div>
	<?php endif; ?>
</div>
