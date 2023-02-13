<?php
if ( empty( $options ) ) {
	return;
}
/*Get min and max value*/
reset( $options );
asort( $options );

$start_value = null;

foreach ( $options as $v => $k ) {
	if ( empty( $start_value ) && ( 0 === $v || ! empty( $v ) ) ) {
		$start_value = $v;
		break;
	}
}

end( $options );
$end_value = key( $options );

/*Current slug*/
$slug = $taxonomy['slug'];

$info = stm_get_all_by_slug( $slug );

$affix = '';
if ( ! empty( $info['number_field_affix'] ) ) {
	$affix = str_replace( '\\', '', $info['number_field_affix'] );
}

$slider_step = ( ! empty( $info['slider'] ) && ! empty( $info['slider_step'] ) ) ? $info['slider_step'] : 100;

$min_value = $start_value;
$max_value = $end_value;

if ( ! empty( $_GET[ 'min_' . $slug ] ) ) {
	$min_value = intval( $_GET[ 'min_' . $slug ] );
}

if ( ! empty( $_GET[ 'max_' . $slug ] ) ) {
	$max_value = intval( $_GET[ 'max_' . $slug ] );
}

$vars = array(
	'slug'        => $slug,
	'affix'       => $affix,
	'js_slug'     => str_replace( '-', 'stmdash', $slug ),
	'start_value' => $start_value,
	'end_value'   => $end_value,
	'min_value'   => $min_value,
	'max_value'   => $max_value,
	'slider_step' => $slider_step,
);

$label_affix = $vars['min_value'] . $affix . ' — ' . $vars['max_value'] . $affix;
if ( stm_is_listing_price_field( $slug ) ) {
	$label_affix = stm_listing_price_view( $vars['min_value'] ) . ' — ' . stm_listing_price_view( $vars['max_value'] );
}

$vars['label'] = stripslashes( $label_affix );

?>
<div class="col-md-12 col-sm-12">
	<div class="filter-<?php echo esc_attr( $vars['slug'] ); ?> stm-slider-filter-type-unit">
		<div class="clearfix">
			<h5 class="pull-left"><?php stm_dynamic_string_translation_e( 'Filter Option Label for ' . $taxonomy['single_name'], $taxonomy['single_name'] ); ?></h5>
			<div class="stm-current-slider-labels"><?php echo esc_html( $vars['label'] ); ?></div>
		</div>

		<div class="stm-price-range-unit">
			<div class="stm-<?php echo esc_attr( $vars['slug'] ); ?>-range stm-filter-type-slider"></div>
		</div>
		<div class="row">
			<div class="col-md-6 col-sm-6 col-md-wider-right">
				<input type="text" name="min_<?php echo esc_attr( $vars['slug'] ); ?>"
					id="stm_filter_min_<?php echo esc_attr( $vars['slug'] ); ?>"
					class="form-control" 
					<?php echo ( 'search_radius' === $vars['slug'] ) ? 'readonly' : ''; ?>
				/>
			</div>
			<div class="col-md-6 col-sm-6 col-md-wider-left">
				<input type="text" name="max_<?php echo esc_attr( $vars['slug'] ); ?>"
					id="stm_filter_max_<?php echo esc_attr( $vars['slug'] ); ?>"
					class="form-control"
				/>
			</div>
		</div>
	</div>

	<!--Init slider-->
	<?php stm_listings_load_template( 'filter/types/slider-js', $vars ); ?>
</div>
