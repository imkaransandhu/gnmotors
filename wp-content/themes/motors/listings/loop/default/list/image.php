<?php
$gallery_hover_interaction = stm_me_get_wpcfto_mod( 'gallery_hover_interaction', false );
$thumbnail_size            = ( stm_is_listing_two() ) ? 'stm-img-255-160' : 'stm-img-275-205';

?>
<div class="image">
	<!-- Video button with count -->
	<?php stm_listings_load_template( 'loop/list/video' ); ?>
	<a href="<?php the_permalink(); ?>" class="rmv_txt_drctn">
		<div class="image-inner interactive-hoverable">

			<?php
			// sold/featured badge.
			stm_listings_load_template( 'loop/default/list/badge' );

			// featured image.
			if ( has_post_thumbnail() ) :
				if ( true === $gallery_hover_interaction && ! wp_is_mobile() ) {
					$thumbs = stm_get_hoverable_thumbs( get_the_ID(), $thumbnail_size );
					if ( empty( $thumbs['gallery'] ) || 1 === count( $thumbs['gallery'] ) ) :
						the_post_thumbnail( $thumbnail_size, array( 'class' => 'img-responsive' ) );
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
						<?php
					endif;
				} else {
					the_post_thumbnail( $thumbnail_size, array( 'class' => 'img-responsive' ) );
				}
			else :
				?>
				<img
					src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/plchldr350.png' ); ?>"
					class="img-responsive"
					alt="<?php esc_attr_e( 'Placeholder', 'motors' ); ?>"
				/>
				<?php
			endif;
			?>
		</div>
	</a>
</div>
