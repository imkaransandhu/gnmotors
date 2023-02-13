<?php
if ( empty( $options ) ) {
	return;
}

$start_value = $options[0];
$end_value   = ( count( $options ) > 0 ) ? $options[ count( $options ) - 1 ] : 0;
$info        = stm_get_all_by_slug( $taxonomy );
$slider_step = ( ! empty( $info['slider'] ) && ! empty( $info['slider_step'] ) ) ? $info['slider_step'] : 100;
$label_affix = $start_value . ' — ' . $end_value;
$min_value   = $start_value;
$max_value   = $end_value;

if ( stm_is_listing_price_field( $taxonomy ) && isset( $_COOKIE['stm_current_currency'] ) ) {
	$cookie      = explode( '-', $_COOKIE['stm_current_currency'] );
	$start_value = ( $start_value * $cookie[1] );
	$end_value   = ( $end_value * $cookie[1] );
	$min_value   = $start_value;
	$max_value   = $end_value;
}

if ( ! empty( $_GET[ 'min_' . $taxonomy ] ) ) {
	$min_value = intval( $_GET[ 'min_' . $taxonomy ] );
}

if ( ! empty( $_GET[ 'max_' . $taxonomy ] ) ) {
	$max_value = intval( $_GET[ 'max_' . $taxonomy ] );
}

$vars = array(
	'slug'        => $taxonomy,
	'js_slug'     => str_replace( '-', 'stmdash', $taxonomy ),
	'label'       => stripslashes( $label_affix ),
	'start_value' => $start_value,
	'end_value'   => $end_value,
	'min_value'   => $min_value,
	'max_value'   => $max_value,
	'slider_step' => $slider_step,
);

?>
<div class="taxonomy_range_wrap">
	<div class="vc_taxonomy mts_semeht_taxonomy">
		<label><?php stm_dynamic_string_translation_e( 'Label category ' . $label, $label ); ?></label>
		<div class="stm-taxonomy-range-unit">
			<div class="stm-<?php echo esc_attr( $taxonomy ); ?>-range ui-slider-wrap"></div>
		</div>
		<input type="hidden" name="min_<?php echo esc_attr( $taxonomy ); ?>" id="stm_filter_min_<?php echo esc_attr( $taxonomy ); ?>"/>
		<input type="hidden" name="max_<?php echo esc_attr( $taxonomy ); ?>" id="stm_filter_max_<?php echo esc_attr( $taxonomy ); ?>"/>
	</div>
</div>

<!--Init slider-->
<?php stm_listings_load_template( 'filter/types/vc_slider-js', $vars ); ?>
