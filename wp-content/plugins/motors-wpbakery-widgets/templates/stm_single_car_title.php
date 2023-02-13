<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract

$css_class     = ( ! empty( $css ) ) ? apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) ) : '';
$listing_title = stm_generate_title_from_slugs( get_the_ID(), false );

?>

<h1 class="title stm_listing_title <?php echo esc_attr( $css_class ); ?> h2">
	<?php echo esc_html( $listing_title ); ?>
</h1>
