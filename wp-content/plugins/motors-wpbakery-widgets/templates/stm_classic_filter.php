<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
$css_class = ( ! empty( $css ) ) ? apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) ) : '';

if ( apply_filters( 'stm_is_motorcycle', false ) ) {
	get_template_part( 'partials/single-car-motorcycle/tabs' );
}

$quant_listing_on_grid = ( ! empty( $quant_listing_on_grid ) ) ? $quant_listing_on_grid : 3; ?>

<div class="<?php echo esc_attr( $css_class ); ?>">
	<?php stm_listings_load_template( 'filter/inventory/main', array( 'quantity_per_row' => $quant_listing_on_grid ) ); ?>
</div>
