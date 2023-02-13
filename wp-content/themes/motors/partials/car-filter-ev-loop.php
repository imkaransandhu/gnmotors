<?php
$gallery_hover_interaction = stm_me_get_wpcfto_mod( 'gallery_hover_interaction', false );
$show_compare              = stm_me_get_wpcfto_mod( 'show_listing_compare', false );

?>
<div class="col-md-3 col-sm-4 col-xs-12 col-xxs-12 stm-template-front-loop ev-filter-loop">
	<a href="<?php the_permalink(); ?>" class="rmv_txt_drctn xx">
		<div class="image">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php
				$img_2x = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'stm-img-796-466' );
				if ( true === $gallery_hover_interaction && ! wp_is_mobile() ) {
					$thumbs = stm_get_hoverable_thumbs( get_the_ID(), 'stm-img-255-160' );
					if ( empty( $thumbs['gallery'] ) || 1 === count( $thumbs['gallery'] ) ) :
						echo wp_get_attachment_image(
							get_post_thumbnail_id( get_the_ID() ),
							'stm-img-255-160',
							false,
							array(
								'data-retina' => $img_2x[0],
								'alt'         => get_the_title(),
							)
						);

						get_template_part( 'partials/listing-cars/listing-directory', 'badges' );

						get_template_part( 'partials/price-electric', 'badge' );

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
									<?php
								endforeach;

								get_template_part( 'partials/listing-cars/listing-directory', 'badges' );

								get_template_part( 'partials/price-badge-ev' );
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
					echo wp_get_attachment_image(
						get_post_thumbnail_id( get_the_ID() ),
						'stm-img-255-160',
						false,
						array(
							'data-retina' => $img_2x[0],
							'alt'         => get_the_title(),
						)
					);

					get_template_part( 'partials/listing-cars/listing-directory', 'badges' );

					get_template_part( 'partials/price-badge-ev' );
				}

			else :
				if ( stm_check_if_car_imported( get_the_ID() ) ) :
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
			endif;

			if ( ! empty( $show_compare ) && true === $show_compare ) :
				?>
				<div
					class="stm-listing-compare stm-compare-directory-new"
					data-post-type="<?php echo esc_attr( get_post_type( get_the_ID() ) ); ?>"
					data-id="<?php echo esc_attr( get_the_ID() ); ?>"
					data-title="<?php echo esc_attr( stm_generate_title_from_slugs( get_the_ID(), false ) ); ?>"
					data-toggle="tooltip" data-placement="right"
					title="<?php esc_attr_e( 'Add to compare', 'motors' ); ?>"
					>
					<i class="stm-boats-icon-add-to-compare"></i>
				</div>
				<?php
			endif;
			?>
		</div> <!-- image -->
		<div class="listing-car-item-meta">
			<div class="car-meta-top heading-font clearfix">
				<div class="car-title">
					<?php
					$listing_title = stm_generate_title_from_slugs( get_the_ID(), true );
					if ( ! empty( $listing_title ) ) {
						echo wp_kses( $listing_title, array( 'div' => array( 'class' => array() ) ) );
					}
					?>
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
						$label_meta = get_post_meta( get_the_ID(), $label['slug'], true );
						if ( empty( $label_meta ) ) {
							continue;
						}

						if ( false === stm_is_listing_price_field( $label['slug'] ) ) :
							$single_name = esc_attr__( 'Listing attribute', 'motors' );

							if ( ! empty( $label['single_name'] ) ) {
								$single_name = $label['single_name'];
							}
							?>
							<li title="<?php echo esc_attr( $single_name ); ?>">
								<?php if ( ! empty( $label['font'] ) ) : ?>
									<i class="<?php echo esc_attr( $label['font'] ); ?>"></i>
								<?php endif; ?>

								<?php
								if ( ! empty( $label['numeric'] ) && $label['numeric'] ) :
									$affix = '';
									if ( ! empty( $label['number_field_affix'] ) ) {
										$affix = $label['number_field_affix'];
									}
									?>
									<span><?php echo esc_html( $label_meta . $affix ); ?></span>
								<?php else : ?>

									<?php
										$data_meta_array = explode( ',', $label_meta );
										$datas           = array();

									if ( ! empty( $data_meta_array ) ) {
										foreach ( $data_meta_array as $data_meta_single ) {
											$data_meta = get_term_by( 'slug', $data_meta_single, $label['slug'] );
											if ( is_object( $data_meta ) && ! empty( $data_meta->name ) ) {
												$datas[] = esc_attr( $data_meta->name );
											} else {
												echo '---';
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
													<?php echo esc_html( stm_do_lmth( $datas[0] ) ) . '<span class="stm-dots dots-aligned">...</span>'; ?>
												</span>
											<?php else : ?>
												<span><?php echo esc_html( implode( ', ', $datas ) ); ?></span>
											<?php endif; ?>
									<?php endif; ?>

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
