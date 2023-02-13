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
$in_compare                    = '';
$car_compare_status            = esc_html__( 'Add to compare', 'motors' );
$placeholder_path              = 'moto-placeholders/moto-400.jpg';
$show_generated_title_as_label = stm_me_get_wpcfto_mod( 'show_generated_title_as_label', false );
$sold_listing                  = get_post_meta( get_the_ID(), 'car_mark_as_sold', true );
$sold_badge_color              = stm_me_get_wpcfto_mod( 'sold_badge_bg_color' );
$badge_text                    = get_post_meta( get_the_ID(), 'badge_text', true );
$special_car                   = get_post_meta( get_the_ID(), 'special_car', true );
$badge_bg_color                = get_post_meta( get_the_ID(), 'badge_bg_color', true );
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
	$in_compare         = 'active';
	$car_compare_status = esc_html__( 'Remove from compare', 'motors' );
}

// remove "special" if the listing is sold.
if ( ! empty( $sold_listing ) ) {
	delete_post_meta( get_the_ID(), 'special_car' );
}

if ( empty( $badge_text ) ) {
	$badge_text = esc_html__( 'Special', 'motors' );
}

$badge_style = '';
if ( ! empty( $badge_bg_color ) ) {
	$badge_style = 'style="background-color:' . $badge_bg_color . '";';
}

/* is listing active or sold? */
if ( ! empty( $sold_listing ) && 'on' === $sold_listing ) {
	$classes[] = 'listing_is_sold';
} else {
	$classes[] = 'listing_is_active';
}

?>

<div
	class="col-md-6 col-sm-6 col-xs-12 col-xxs-12 stm-isotope-listing-item stm_moto_single_grid_item all <?php echo esc_attr( implode( ' ', $classes ) ); ?>"
	data-price="<?php echo esc_attr( $data_price ); ?>"
	data-date="<?php echo get_the_date( 'Ymdhi' ); ?>"
	data-mileage="<?php echo esc_attr( $data_mileage ); ?>"
	>
	<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="rmv_txt_drctn">
		<div class="image">
			<?php if ( empty( $sold_listing ) && ! empty( $special_car ) && 'on' === $special_car && ! empty( $badge_text ) ) : ?>
				<div class="special-label special-label-small h6" <?php echo esc_attr( $badge_style ); ?>>
					<?php stm_dynamic_string_translation_e( 'Special Badge Text', $badge_text ); ?>
				</div>
			<?php elseif ( stm_sold_status_enabled() && ! empty( $sold_listing ) ) : ?>
				<?php $badge_style = 'style=background-color:' . $sold_badge_color . ';'; ?>
				<div class="special-label special-label-small h6" <?php echo esc_attr( $badge_style ); ?>>
					<?php esc_html_e( 'Sold', 'motors' ); ?>
				</div>
			<?php endif; ?>
			<?php
			if ( has_post_thumbnail() ) :
				$img_placeholder = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'stm-img-796-466' );
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
			else :
				?>
				<img
					src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $placeholder_path ); ?>"
					class="img-responsive"
					alt="<?php esc_attr_e( 'Placeholder', 'motors' ); ?>"
					/>
				<?php
			endif;
			?>
			<div class="stm_moto_hover_unit">
				<!--Compare-->
				<?php
				if ( ! empty( $show_compare ) && true === $show_compare ) :
					?>
					<div
						class="stm-listing-compare heading-font stm-compare-directory-new <?php echo esc_attr( $in_compare ); ?>"
						data-post-type="<?php echo esc_attr( get_post_type( get_the_ID() ) ); ?>"
						data-id="<?php echo esc_attr( get_the_id() ); ?>"
						data-title="<?php echo esc_attr( stm_generate_title_from_slugs( get_the_id(), false ) ); ?>"
						>
						<i class="stm-service-icon-compare-new"></i>
						<?php esc_html_e( 'Compare', 'motors' ); ?>
					</div>
					<?php
				endif;

				stm_get_boats_image_hover( get_the_ID() );
				?>
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
			<?php
			$labels = stm_get_car_listings();

			if ( ! empty( $labels ) ) :
				?>
				<div class="car-meta-bottom">
					<ul>
						<?php
						foreach ( $labels as $label ) :
							$label_meta = get_post_meta( get_the_id(), $label['slug'], true );

							if ( ! empty( $label_meta ) && 'price' !== $label['slug'] ) :
								?>
								<li>
									<?php if ( ! empty( $label['font'] ) ) : ?>
										<i class="<?php echo esc_attr( $label['font'] ); ?>"></i>
									<?php endif; ?>

									<span class="stm_label">
										<?php stm_dynamic_string_translation_e( 'Motos Grid Label Name', $label['single_name'] ); ?>:
									</span>

									<?php
									if ( ! empty( $label['numeric'] ) && $label['numeric'] ) :
										?>
										<span><?php echo esc_attr( $label_meta ); ?></span>
										<?php
									else :
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

										if ( ! empty( $datas ) ) :
											if ( count( $datas ) > 1 ) :
												?>
													<span 
														class="stm-tooltip-link" 
														data-toggle="tooltip"
														data-placement="bottom"
														title="<?php echo esc_attr( implode( ', ', $datas ) ); ?>">
														<?php echo esc_html( $datas[0] ) . '<span class="stm-dots dots-aligned">...</span>'; ?>
													</span>
												<?php
											else :
												?>
													<span><?php echo esc_html( implode( ', ', $datas ) ); ?></span>
												<?php
											endif;
										endif;
									endif;

									if ( ! empty( $label['number_field_affix'] ) ) :
										?>
										<span><?php stm_dynamic_string_translation_e( 'Number Field Affix', $label['number_field_affix'] ); ?></span>
										<?php
									endif;
									?>
								</li>
								<?php
							endif;
						endforeach;
						?>
					</ul>
				</div>
				<?php
			endif;
			?>
		</div>
	</a>
</div>
