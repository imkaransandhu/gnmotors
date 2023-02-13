<?php
$gallery_hover_interaction = stm_me_get_wpcfto_mod( 'gallery_hover_interaction', false );
$show_compare              = stm_me_get_wpcfto_mod( 'show_listing_compare', false );
$show_favorite             = stm_me_get_wpcfto_mod( 'enable_favorite_items', false );
$car_media                 = stm_get_car_medias( get_the_id() );

if ( stm_is_dealer_two() || stm_is_aircrafts() ) {
	$show_favorite = false;
}

$dynamic_class_photo = 'stm-car-photos-' . get_the_id() . '-' . wp_rand( 1, 99999 );
$dynamic_class_video = 'stm-car-videos-' . get_the_id() . '-' . wp_rand( 1, 99999 );

?>

<div class="image">
	<!---Media-->
	<div class="stm-car-medias">
		<?php if ( ! empty( $car_media['car_photos_count'] ) ) : ?>
			<div class="stm-listing-photos-unit stm-car-photos-<?php echo esc_attr( get_the_ID() ); ?> <?php echo esc_attr( $dynamic_class_photo ); ?>">
				<i class="stm-service-icon-photo"></i>
				<span><?php echo esc_html( $car_media['car_photos_count'] ); ?></span>
			</div>

			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery(".<?php echo esc_attr( $dynamic_class_photo ); ?>").on('click', function() {
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
			<div class="stm-listing-videos-unit stm-car-videos-<?php echo get_the_ID(); ?> <?php echo esc_attr( $dynamic_class_video ); ?>">
				<i class="fas fa-film"></i>
				<span><?php echo esc_html( $car_media['car_videos_count'] ); ?></span>
			</div>

			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery(".<?php echo esc_attr( $dynamic_class_video ); ?>").on('click', function() {

						jQuery(this).lightGallery({
							selector: 'this',
							dynamic: true,
							dynamicEl: [
								<?php foreach ( $car_media['car_videos'] as $car_video ) : ?>
								{
									src : "<?php echo esc_url( $car_video ); ?>",
									thumb: ''
								},
								<?php endforeach; ?>
							],
							download: false,
							mode: 'lg-video',
						})
					}); //click
				}); //ready

			</script>
		<?php endif; ?>
	</div>

	<!--Favorite-->
	<?php if ( ! empty( $show_favorite ) && $show_favorite ) : ?>
		<?php $favorite_tooltip_placement = ( stm_is_listing_four() ) ? 'left' : 'right'; ?>
		<div
			class="stm-listing-favorite"
			data-id="<?php echo esc_attr( get_the_ID() ); ?>"
			data-toggle="tooltip" data-placement="<?php echo esc_attr( $favorite_tooltip_placement ); ?>" title="<?php esc_attr_e( 'Add to favorites', 'motors' ); ?>">
			<i class="stm-service-icon-staricon"></i>
		</div>
	<?php endif; ?>

	<a href="<?php the_permalink(); ?>" class="rmv_txt_drctn">
		<div class="image-inner interactive-hoverable">
			<?php get_template_part( 'partials/listing-cars/listing-directory', 'badges' ); ?>
			<?php
			if ( has_post_thumbnail() ) :
				$img_size   = ( stm_is_dealer_two() ) ? 'stm-img-275-205' : 'stm-img-280-165';
				$img_retina = ( stm_is_dealer_two() ) ? 'stm-img-275-205-x-2' : 'stm-img-280-165-x-2';
				$plchldr    = ( stm_is_dealer_two() ) ? 'plchldr-275.jpg' : 'plchldr350.png';
				$plchldr    = ( stm_is_aircrafts() ) ? 'ac_plchldr.jpg' : $plchldr;
				$img        = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $img_size );
				if ( ! empty( $img_retina ) ) {
					$img_x2 = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $img_retina );
				}

				if ( true === $gallery_hover_interaction && ! wp_is_mobile() ) {
					$thumbs = stm_get_hoverable_thumbs( get_the_ID(), $img_size );
					if ( empty( $thumbs['gallery'] ) || 1 === count( $thumbs['gallery'] ) ) :
						?>
						<img data-src="<?php echo esc_url( ! empty( $img[0] ) ? $img[0] : get_stylesheet_directory_uri() . '/assets/images/' . $plchldr ); ?>"
							<?php if ( ! empty( $img_retina ) ) : ?>
								srcset="<?php echo esc_url( ! empty( $img[0] ) ? $img[0] : get_stylesheet_directory_uri() . '/assets/images/' . $plchldr ); ?> 1x, <?php echo esc_url( ! empty( $img_x2[0] ) ? $img_x2[0] : get_stylesheet_directory_uri() . '/assets/images/' . $plchldr ); ?> 2x"
							<?php endif; ?>
							src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $plchldr ); ?>"
							class="lazy img-responsive"
							alt="<?php the_title(); ?>"
						/>
						<?php
					else :
						$array_keys    = array_keys( $thumbs['gallery'] );
						$last_item_key = array_pop( $array_keys );
						?>
						<div class="hoverable-wrap">
							<?php foreach ( $thumbs['gallery'] as $key => $img_url ) : ?>
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
							<?php endforeach; ?>
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
						<?php
					endif;
				} else {
					?>
					<img data-src="<?php echo esc_url( ! empty( $img[0] ) ? $img[0] : get_stylesheet_directory_uri() . '/assets/images/' . $plchldr ); ?>"
						<?php if ( ! empty( $img_retina ) ) : ?>
							srcset="<?php echo esc_url( ! empty( $img[0] ) ? $img[0] : get_stylesheet_directory_uri() . '/assets/images/' . $plchldr ); ?> 1x, <?php echo esc_url( ! empty( $img_x2[0] ) ? $img_x2[0] : get_stylesheet_directory_uri() . '/assets/images/' . $plchldr ); ?> 2x"
						<?php endif; ?>
						src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $plchldr ); ?>"
						class="lazy img-responsive"
						alt="<?php the_title(); ?>"
					/>
					<?php
				}
			else :
				$plchldr = ( stm_is_dealer_two() ) ? 'plchldr-275.jpg' : 'plchldr350.png';
				?>
				<img
					src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $plchldr ); ?>"
					class="img-responsive"
					alt="<?php esc_attr_e( 'Placeholder', 'motors' ); ?>"
				/>
			<?php endif; ?>
		</div>
	</a>
</div>
