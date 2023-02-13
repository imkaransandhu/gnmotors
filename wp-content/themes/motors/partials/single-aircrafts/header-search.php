<?php
motors_include_once_scripts_styles( array( 'stmselect2', 'app-select2' ) );
$options = get_option( 'stm_vehicle_listing_options', '' );

$filter_all = '';

$i = 0;
foreach ( $options as $k => $val ) {
	if ( ! empty( $val['use_on_single_header_search'] ) ) {
		if ( 0 !== $i ) {
			$filter_all .= ',';
		}
		$filter_all .= $val['slug'];
		$i ++;
	}
}

if ( ! empty( $filter_all ) ) :

	?>
	<div class="container stm-single-header-search-wrap">
		<form action="<?php echo esc_attr( stm_get_listing_archive_link() ); ?>" method="get">
			<div class="stm-single-header-search">
				<h4><?php echo wp_kses_post( '<span>Quick</span> search', 'motors' ); ?></h4>
				<?php stm_listing_filter_get_selects( $filter_all ); ?>
				<button type="submit" class="heading-font"><i class="fas fa-search"></i>
					<span></span> <?php echo esc_html__( 'Planes', 'motors' ); ?></button>
			</div>
		</form>
	</div>
<?php endif; ?>
