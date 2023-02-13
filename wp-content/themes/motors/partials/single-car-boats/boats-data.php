<?php
$data             = apply_filters( 'stm_single_car_data', stm_get_single_car_listings() );
$show_compare     = stm_me_get_wpcfto_mod( 'show_compare', false );
$stm_car_location = get_post_meta( get_the_ID(), 'stm_car_location', true );
$cars_in_compare  = stm_get_compared_items();
?>

<?php if ( ! empty( $data ) ) : ?>
	<div class="single-boat-data-units">
		<div class="single-boat-data">
			<?php foreach ( $data as $data_value ) : ?>
				<?php if ( ! stm_is_listing_price_field( $data_value['slug'] ) ) : ?>
					<?php $data_meta = get_post_meta( get_the_ID(), $data_value['slug'], true ); ?>
					<?php if ( ! empty( $data_meta ) && $data_meta != 'none' ) : ?>

						<div class="t-row">
							<div class="t-label">
								<?php if ( ! empty( $data_value['font'] ) ) : ?>
									<i class="<?php echo esc_attr( $data_value['font'] ); ?>"></i>
								<?php endif; ?>
								<?php stm_dynamic_string_translation_e( 'Single listing ' . $data_value['single_name'], $data_value['single_name'] ); ?>
							</div>
							<?php if ( ! empty( $data_value['numeric'] ) && $data_value['numeric'] ) : ?>
								<div class="t-value h6">
									<?php echo esc_html( ucfirst( $data_meta ) ); ?>
								</div>
							<?php else : ?>
								<?php
								$data_meta_array = explode( ',', $data_meta );
								$datas           = array();

								if ( ! empty( $data_meta_array ) ) {
									foreach ( $data_meta_array as $data_meta_single ) {
										$data_meta = get_term_by( 'slug', $data_meta_single, $data_value['slug'] );
										if ( ! empty( $data_meta->name ) ) {
											$datas[] = esc_attr( $data_meta->name );
										}
									}
								}
								?>
								<div class="t-value h6">
									<?php echo esc_html( implode( ', ', $datas ) ); ?>
								</div>
							<?php endif; ?>
						</div>

					<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; ?>

			<?php if ( ! empty( $stm_car_location ) ) : ?>
				<div class="t-row">
					<div class="t-label">
						<i class="stm-boats-icon-pin"></i>
						<?php esc_html_e( 'Location', 'motors' ); ?>
					</div>
					<div class="t-value h6"><?php echo esc_attr( $stm_car_location ); ?></div>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $show_compare ) ) : ?>
			<?php
			$active = '';
			if ( ! empty( $cars_in_compare ) ) {
				if ( in_array( get_the_ID(), $cars_in_compare ) ) {
					$active = 'active';
				}
			}
			?>
			<div class="stm-gallery-action-unit compare <?php echo esc_attr( $active ); ?>"
				data-id="<?php echo esc_attr( get_the_ID() ); ?>"
				data-title="<?php echo esc_attr( stm_generate_title_from_slugs( get_the_id() ) ); ?>"
				data-post-type="<?php echo esc_attr( get_post_type( get_the_ID() ) ); ?>"
				>
				<i class="stm-boats-icon-add-to-compare"></i>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
