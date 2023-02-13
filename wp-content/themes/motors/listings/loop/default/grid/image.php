<?php
$gallery_hover_interaction = stm_me_get_wpcfto_mod( 'gallery_hover_interaction', false );
$show_compare              = stm_me_get_wpcfto_mod( 'show_listing_compare', false );

$cars_in_compare    = stm_get_compared_items();
$in_compare         = '';
$car_compare_status = esc_html__( 'Add to compare', 'motors' );

if ( ! empty( $cars_in_compare ) && in_array( get_the_ID(), $cars_in_compare, true ) ) {
	$in_compare         = 'active';
	$car_compare_status = esc_html__( 'Remove from compare', 'motors' );
}

$size             = 'stm-img-255-135';
$size_retina      = 'stm-img-255-135-x-2';
$placeholder_path = 'plchldr255.png';

if ( wp_is_mobile() ) {
	$size             = 'stm-img-796-466';
	$placeholder_path = 'plchldr350.png';
}

if ( stm_is_boats() ) {
	$size             = 'stm-img-350-205';
	$size_retina      = 'stm-img-350-205-x-2';
	$placeholder_path = 'boats-placeholders/boats-250.png';
}

$col = ( ! empty( get_post_meta( stm_get_listing_archive_page_id(), 'quant_grid_items', true ) ) ) ? 12 / get_post_meta( stm_get_listing_archive_page_id(), 'quant_grid_items', true ) : 4;

if ( '6' === $col ) {
	$size        = 'stm-img-398-223';
	$size_retina = 'stm-img-398-223-x-2';
}

$placeholder_path = ( stm_is_aircrafts() ) ? 'ac_plchldr.jpg' : $placeholder_path;
?>

<div class="image">
	<?php
	if ( has_post_thumbnail() ) :
		$img    = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $size );
		$img_x2 = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $size_retina );

		if ( true === $gallery_hover_interaction && ! wp_is_mobile() ) {
			$thumbs = stm_get_hoverable_thumbs( get_the_ID(), $size );
			if ( empty( $thumbs['gallery'] ) || 1 === count( $thumbs['gallery'] ) ) :
				?>
				<img
					data-src="<?php echo esc_url( $img[0] ); ?>"
					srcset="<?php echo esc_url( $img[0] ); ?> 1x, <?php echo esc_url( $img_x2[0] ); ?> 2x"
					src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $placeholder_path ); ?>"
					class="lazy img-responsive"
					alt="<?php echo esc_attr( stm_get_img_alt( get_post_thumbnail_id( get_the_ID() ) ) ); ?>"
				/>
				<?php
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
			srcset="<?php echo esc_url( $img[0] ); ?> 1x, <?php echo esc_url( $img_x2[0] ); ?> 2x"
			src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $placeholder_path ); ?>"
			class="lazy img-responsive"
			alt="<?php echo esc_attr( stm_get_img_alt( get_post_thumbnail_id( get_the_ID() ) ) ); ?>"
		/>
			<?php
			get_template_part( 'partials/listing-cars/listing-directory', 'badges' );
		}
	else :
		?>
		<img
			src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $placeholder_path ); ?>"
			class="img-responsive"
			alt="<?php esc_attr_e( 'Placeholder', 'motors' ); ?>"
		/>
		<?php
		get_template_part( 'partials/listing-cars/listing-directory', 'badges' );
	endif;

	$tooltip_position = 'left';

	if ( stm_is_boats() ) {
		stm_get_boats_image_hover( get_the_ID() );
	}

	// Compare.
	if ( ! empty( $show_compare ) && $show_compare ) :
		?>
		<div
			class="stm-listing-compare stm-compare-directory-new"
			data-post-type="<?php echo esc_attr( get_post_type( get_the_ID() ) ); ?>"
			data-id="<?php echo esc_attr( get_the_id() ); ?>"
			data-title="<?php echo esc_attr( stm_generate_title_from_slugs( get_the_id(), false ) ); ?>"
			data-toggle="tooltip"
			data-placement="<?php echo esc_attr( $tooltip_position ); ?>"
			title="<?php echo esc_attr( $car_compare_status ); ?>">
			<i class="stm-boats-icon-add-to-compare"></i>
		</div>
		<?php
	endif;
	?>
</div>
