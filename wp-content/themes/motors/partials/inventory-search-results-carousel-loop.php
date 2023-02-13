<?php
$gallery_hover_interaction = stm_me_get_wpcfto_mod( 'gallery_hover_interaction', false );
$car_price_form_label      = get_post_meta( get_the_ID(), 'car_price_form_label', true );
// Compare.
if ( stm_is_boats() ) {
	$placeholder_path = 'plchldr255.png';
	if ( stm_is_boats() ) {
		$placeholder_path = 'boats-placeholders/boats-250.png';
	}
}

$current_vehicle_id = $args['current_vehicle_id'];
?>

<div class="stm-template-front-loop <?php echo ( intval( $current_vehicle_id ) === get_the_ID() ) ? 'current' : ''; ?>">
	<a href="<?php the_permalink(); ?>" class="rmv_txt_drctn xx">
		<div class="image">
			<?php
			if ( has_post_thumbnail() ) :
				$img_2x = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'stm-img-796-466' );

				if ( true === $gallery_hover_interaction && ! wp_is_mobile() ) {
					$thumbs = stm_get_hoverable_thumbs( get_the_ID(), 'stm-img-796-466' );
					if ( empty( $thumbs['gallery'] ) || 1 === count( $thumbs['gallery'] ) ) :
						?>
						<div class="brazzers-wrap">
							<div class="brazzers-carousel">
								<?php
								echo wp_get_attachment_image(
									get_post_thumbnail_id( get_the_ID() ),
									'stm-img-796-466',
									false,
									array(
										'data-retina' => $img_2x[0],
										'alt'         => get_the_title(),
									)
								);
								?>
							</div>
							<?php
							get_template_part( 'partials/listing-cars/listing-directory', 'badges' );
							?>
							<div class="listing-car-item-meta">
								<?php stm_listings_load_template( 'loop/default/list/price' ); ?>
							</div>
						</div>
						<?php
					else :
						$array_keys    = array_keys( $thumbs['gallery'] );
						$last_item_key = array_pop( $array_keys );
						$remaining_photos = '';
						if ( ! empty( $thumbs['remaining'] ) && 0 < $thumbs['remaining'] ) {
							$remaining_photos = $thumbs['remaining'];
						}
						?>
						<div class="brazzers-wrap">
							<div class="brazzers-carousel" data-remaining="<?php echo esc_attr( $remaining_photos ); ?>">
								<?php foreach ( $thumbs['gallery'] as $key => $img_url ) : ?>
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
								<?php endforeach; ?>
							</div>
							<?php
							get_template_part( 'partials/listing-cars/listing-directory', 'badges' );
							?>
							<div class="listing-car-item-meta">
								<?php stm_listings_load_template( 'loop/default/list/price' ); ?>
							</div>
						</div>
						<?php
					endif;
				} else {
					echo wp_get_attachment_image(
						get_post_thumbnail_id( get_the_ID() ),
						'stm-img-255-135',
						false,
						array(
							'data-retina' => $img_2x[0],
							'alt'         => get_the_title(),
						)
					);

					get_template_part( 'partials/listing-cars/listing-directory', 'badges' );

					?>
					<div class="listing-car-item-meta">
						<?php stm_listings_load_template( 'loop/default/list/price' ); ?>
					</div>
					<?php
				}
			else :
				if ( stm_check_if_car_imported( get_the_id() ) ) :
					?>
					<img
						src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/automanager_placeholders/plchldr255automanager.png' ); ?>"
						class="img-responsive"
						alt="<?php esc_attr_e( 'Placeholder', 'motors' ); ?>"
						/>
					<?php
				else :
					?>
					<img
						src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/plchldr255.png' ); ?>"
						class="img-responsive"
						alt="<?php esc_attr_e( 'Placeholder', 'motors' ); ?>"
						/>
					<?php
				endif;
				get_template_part( 'partials/listing-cars/listing-directory', 'badges' );

				?>
				<div class="listing-car-item-meta">
					<?php stm_listings_load_template( 'loop/default/list/price' ); ?>
				</div>
				<?php
			endif;
			if ( stm_is_boats() ) {
				stm_get_boats_image_hover( get_the_ID() );
			}
			?>
		</div>
		<div class="listing-car-item-meta">
			<div class="car-meta-top heading-font clearfix">
				<div class="car-title">
					<?php
					echo esc_attr( trim( preg_replace( '/\s+/', ' ', substr( stm_generate_title_from_slugs( get_the_id() ), 0, 35 ) ) ) );

					if ( strlen( stm_generate_title_from_slugs( get_the_id() ) ) > 35 ) {
						echo esc_attr( '...' );
					}
					?>
				</div>
			</div>
		</div>
	</a>
</div>
