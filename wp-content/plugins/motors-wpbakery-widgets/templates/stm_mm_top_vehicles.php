<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

$query = new WP_Query(
	array(
		'post_type'           => apply_filters( 'stm_listings_post_type', 'listings' ),
		'ignore_sticky_posts' => 1,
		'post_status'         => 'publish',
		'posts_per_page'      => 8,
		'meta_query'          => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			array(
				'key'     => 'stm_car_views',
				'value'   => '0',
				'compare' => '!=',
			),
		),
		'orderby'             => 'meta_value',
		'order'               => 'DESC',
	)
);

?>

<div class="stm-mm-top-vehicles <?php echo esc_attr( $css_class ); ?>">
	<?php
	if ( ! empty( $title ) ) {
		?>
		<h3><?php echo esc_html( $title ); ?></h3>
		<?php
	}
	?>
	<div class="stm-mm-vehicles-list">
		<?php if ( $query->have_posts() ) : ?>
			<ul class="top-vehicles">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();

					$make  = get_post_meta( get_the_ID(), 'make', true );
					$serie = get_post_meta( get_the_ID(), 'serie', true );

					if ( strpos( $make, ',' ) !== false ) {
						$make = explode( ',', $make );
						$make = $make[0];
					}

					$make_name  = ( ! empty( $make ) ) ? get_term_by( 'slug', $make, 'make' ) : '';
					$model_name = ( ! empty( $serie ) ) ? get_term_by( 'slug', $serie, 'serie' ) : '';

					?>
					<li>
						<a class="normal_font" href="<?php echo esc_url( get_the_permalink( stm_listings_user_defined_filter_page() ) ) . '?make=' . esc_url( $make ) . '&serie=' . esc_url( $serie ); ?>"><?php echo esc_html( $make_name->name . ' ' . $model_name->name ); ?></a>
					</li>
				<?php endwhile; ?>
			</ul>
			<?php
		endif;
		wp_reset_postdata();
		?>
	</div>
</div>
