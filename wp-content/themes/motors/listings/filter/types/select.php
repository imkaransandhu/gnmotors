<select name="<?php echo ( ( isset( $maxify ) && $maxify ) ) ? esc_attr( 'max_' . $name ) : esc_attr( $name ); ?>" class="form-control">
	<?php if ( ! empty( $options ) ) :
		foreach ( $options as $value => $option ) :
		?>
			<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $option['selected'] ); ?> <?php disabled( $option['disabled'] ); ?>>
				<?php
				if ( stm_is_listing_price_field( $name ) ) {
					if ( ! empty( $value ) ) {
						echo esc_html( stm_listing_price_view( $value ) );
					} else {
						echo esc_html( stm_dynamic_string_translation( 'Filter Option Label for ' . $option['label'], $option['label'] ) );
					}
				} else {
					echo esc_html( stm_dynamic_string_translation( 'Filter Option Label for ' . $option['label'], $option['label'] ) );
				}
				?>
			</option>
			<?php
		endforeach;
	endif;
	?>
</select>
