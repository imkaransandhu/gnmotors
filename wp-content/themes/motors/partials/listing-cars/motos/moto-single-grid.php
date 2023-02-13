<?php
$regular_price_label           = get_post_meta( get_the_ID(), 'regular_price_label', true );
$special_price_label           = get_post_meta( get_the_ID(), 'special_price_label', true );
$price                         = get_post_meta( get_the_id(), 'price', true );
$sale_price                    = get_post_meta( get_the_id(), 'sale_price', true );
$car_price_form_label          = get_post_meta( get_the_ID(), 'car_price_form_label', true );
$data_price                    = '0';
$mileage                       = get_post_meta( get_the_id(), 'mileage', true );
$data_mileage                  = '0';
$taxonomies                    = stm_get_taxonomies();
$categories                    = wp_get_post_terms( get_the_ID(), array_values( $taxonomies ) );
$classes                       = array();
$show_compare                  = stm_me_get_wpcfto_mod( 'show_listing_compare', false );
$cars_in_compare               = stm_get_compared_items();
$car_already_added_to_compare  = '';
$car_compare_status            = esc_html__( 'Add to compare', 'motors' );
$placeholder_path              = 'moto-placeholders/moto-350.jpg';
$show_generated_title_as_label = stm_me_get_wpcfto_mod( 'show_generated_title_as_label', false );
$gallery_hover_interaction     = stm_me_get_wpcfto_mod( 'gallery_hover_interaction', false );

if ( ! empty( $price ) ) {
	$data_price = $price;
}

if ( ! empty( $sale_price ) ) {
	$data_price = $sale_price;
}

if ( empty( $price ) && ! empty( $sale_price ) ) {
	$price = $sale_price;
}

if ( ! empty( $mileage ) ) {
	$data_mileage = $mileage;
}

if ( ! empty( $categories ) ) {
	foreach ( $categories as $category ) {
		$classes[] = $category->slug . '-' . $category->term_id;
	}
}

if ( ! empty( $cars_in_compare ) && in_array( get_the_ID(), $cars_in_compare, true ) ) {
	$car_already_added_to_compare = 'active';
	$car_compare_status           = esc_html__( 'Remove from compare', 'motors' );
}

?>

<div
	class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 stm-isotope-listing-item stm_moto_single_grid_item all <?php echo esc_attr( implode( ' ', $classes ) ); ?>"
	data-price="<?php echo esc_attr( $data_price ); ?>"
	data-date="<?php echo get_the_date( 'Ymdhi' ); ?>"
	data-mileage="<?php echo esc_attr( $data_mileage ); ?>"
	>
	<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="rmv_txt_drctn">
		<div class="image">
			<?php
			if ( has_post_thumbnail() ) :
				$img_placeholder = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'stm-img-350-205' );
				$img             = $img_placeholder;
				if ( true === $gallery_hover_interaction && ! wp_is_mobile() ) {
					$thumbs = stm_get_hoverable_thumbs( get_the_ID(), 'stm-img-796-466' );
					if ( empty( $thumbs['gallery'] ) || 1 === count( $thumbs['gallery'] ) ) :
						?>
						<img
							data-src="<?php echo esc_url( $img[0] ); ?>"
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
								<?php foreach ( $thumbs['gallery'] as $key => $img_url ) : ?>
									<div class="hoverable-unit <?php echo ( 0 === $key ) ? 'active' : ''; ?>">
										<div class="thumb">
											<?php if ( $key === $last_item_key && 5 === count( $thumbs['gallery'] ) && 0 < $thumbs['remaining'] ) : ?>
												<div class="remaining">
													<i class="stm-icon-album"></i>
													<p>
														<?php
															/* translators: number of remaining photos */
															echo esc_html( sprintf( _n( '%d more photo', '%d more photos', $thumbs['remaining'], 'motors' ), $thumbs['remaining'] ) );
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
						</div>
						<?php
					endif;
				} else {
					?>
					<img
						data-src="<?php echo esc_url( $img[0] ); ?>"
						src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $placeholder_path ); ?>"
						class="lazy img-responsive"
						alt="<?php echo esc_attr( stm_get_img_alt( get_post_thumbnail_id( get_the_ID() ) ) ); ?>"
						/>
					<?php
				}

				get_template_part( 'partials/listing-cars/listing-directory', 'badges' );
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
			?>

			<div class="stm_moto_hover_unit">
				<!--Compare-->
				<?php if ( ! empty( $show_compare ) && $show_compare ) : ?>
					<div
						class="stm-listing-compare heading-font stm-compare-directory-new"
						data-post-type="<?php echo esc_attr( get_post_type( get_the_ID() ) ); ?>"
						data-id="<?php echo esc_attr( get_the_id() ); ?>"
						data-title="<?php echo esc_attr( stm_generate_title_from_slugs( get_the_id(), false ) ); ?>"
						>
						<i class="stm-service-icon-compare-new"></i>
						<?php esc_html_e( 'Compare', 'motors' ); ?>
					</div>
				<?php endif; ?>
				<?php stm_get_boats_image_hover( get_the_ID() ); ?>
				<div class="heading-font">
					<?php if ( empty( $car_price_form_label ) ) : ?>
						<?php if ( ! empty( $price ) && ! empty( $sale_price ) && $price !== $sale_price ) : ?>
							<div class="price discounted-price">
								<div class="regular-price"><?php echo esc_attr( stm_listing_price_view( $price ) ); ?></div>
								<div class="sale-price"><?php echo esc_attr( stm_listing_price_view( $sale_price ) ); ?></div>
							</div>
						<?php elseif ( ! empty( $price ) ) : ?>
							<div class="price">
								<div class="normal-price"><?php echo esc_attr( stm_listing_price_view( $price ) ); ?></div>
							</div>
						<?php endif; ?>
					<?php else : ?>
						<div class="price">
							<div class="normal-price"><?php echo esc_attr( $car_price_form_label ); ?></div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="listing-car-item-meta">
			<div class="car-meta-top heading-font clearfix">
				<div class="car-title">
					<?php echo wp_kses_post( stm_generate_title_from_slugs( get_the_id(), true ) ); ?>
				</div>
			</div>

			<?php $labels = stm_get_car_listings(); ?>
			<?php if ( ! empty( $labels ) ) : ?>
				<div class="car-meta-bottom">
					<ul>
						<?php foreach ( $labels as $label ) : ?>
							<?php $label_meta = get_post_meta( get_the_id(), $label['slug'], true ); ?>
							<?php if ( ! empty( $label_meta ) && ! stm_is_listing_price_field( $label['slug'] ) ) : ?>
								<li>
									<?php if ( ! empty( $label['font'] ) ) : ?>
										<i class="<?php echo esc_attr( $label['font'] ); ?>"></i>
									<?php endif; ?>

									<span class="stm_label">
										<?php stm_dynamic_string_translation_e( 'Label Name', $label['single_name'] ); ?>:
									</span>

									<?php if ( ! empty( $label['numeric'] ) && $label['numeric'] ) : ?>
										<span><?php echo esc_attr( $label_meta ); ?></span>
									<?php else : ?>

										<?php
											$data_meta_array = explode( ',', $label_meta );
											$datas           = array();

										if ( ! empty( $data_meta_array ) ) {
											foreach ( $data_meta_array as $data_meta_single ) {
												$data_meta = get_term_by( 'slug', $data_meta_single, $label['slug'] );
												if ( ! empty( $data_meta->name ) ) {
													$datas[] = esc_attr( $data_meta->name );
												}
											}
										}
										?>

										<?php if ( ! empty( $datas ) ) : ?>

											<?php
											if ( count( $datas ) > 1 ) {
												?>

													<span 
														class="stm-tooltip-link" 
														data-toggle="tooltip"
														data-placement="bottom"
														title="<?php echo esc_attr( implode( ', ', $datas ) ); ?>">
														<?php echo esc_html( $datas[0] ) . '<span class="stm-dots dots-aligned">...</span>'; ?>
													</span>

												<?php } else { ?>
													<span><?php echo esc_html( implode( ', ', $datas ) ); ?></span>
												<?php
												}
												?>
										<?php endif; ?>

									<?php endif; ?>

									<?php if ( ! empty( $label['number_field_affix'] ) ) : ?>
										<span><?php stm_dynamic_string_translation_e( 'Number Field Affix', $label['number_field_affix'] ); ?></span>
									<?php endif; ?>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

		</div>
	</a>
</div>
