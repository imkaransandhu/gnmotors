<?php
$enable_features_search = stm_me_get_wpcfto_mod( 'enable_features_search', false );
if ( $enable_features_search ) :
	if ( ! empty( $taxonomy ) ) :
		$features = get_terms(
			'stm_additional_features',
			array(
				'hide_empty' => true,
			)
		);

		$selected = array();

		if ( ! empty( $_GET['stm_features'] ) ) { // phpcs:ignore WordPress.Security
			if ( is_array( $_GET['stm_features'] ) ) { // phpcs:ignore WordPress.Security
				foreach ( $_GET['stm_features'] as $item ) { // phpcs:ignore WordPress.Security
					$selected[] = sanitize_text_field( $item );
				}
			} else {
				$selected[] = sanitize_text_field( $_GET['stm_features'] ); // phpcs:ignore WordPress.Security
			}
		}

		if ( ! empty( $features ) && ! is_wp_error( $features ) ) : ?>
			<div class="col-md-12 col-sm-12">
				<div class="stm-multiple-select stm_additional_features">
					<h5><?php esc_html_e( 'Additional features', 'motors' ); ?></h5>
					<select multiple="multiple" name="stm_features[]">
						<?php foreach ( $features as $feature ) : ?>
							<option value="<?php echo esc_attr( $feature->slug ); ?>"
								<?php echo ( in_array( $feature->slug, $selected, true ) ) ? 'selected' : ''; ?>>
								<?php echo esc_html( $feature->name ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
