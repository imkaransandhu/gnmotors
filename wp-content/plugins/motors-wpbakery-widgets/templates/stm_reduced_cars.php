<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
$css_class = ( ! empty( $css ) ) ? apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) ) : '';

if ( empty( $reduced_numbers ) ) {
	$reduced_numbers = 4;
}

$inventory_link = stm_get_listing_archive_link() . '?sale_cars=true';

$args = array(
	'post_type'      => apply_filters( 'stm_listings_post_type', 'listings' ),
	'post_status'    => 'publish',
	'posts_per_page' => $reduced_numbers,
	'order'          => 'rand',
	'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
		'relation' => 'AND',
		array(
			'relation' => 'OR',
			array(
				'key'     => 'sale_price',
				'value'   => '',
				'compare' => '!=',
			),
			array(
				'key'     => 'car_price_form',
				'value'   => '',
				'compare' => '!=',
			),
		),
		array(
			'relation' => 'OR',
			array(
				'key'     => 'car_mark_as_sold',
				'value'   => '',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => 'car_mark_as_sold',
				'value'   => '',
				'compare' => '=',
			),
		),
	),
);

$reduced_query = new WP_Query( $args );
?>

<div class="stm_cars_on_top stm-reduced-cars <?php echo esc_attr( $css_class ); ?>">
	<?php echo wp_kses_post( $content ); ?>
	<?php if ( $reduced_query->have_posts() ) : ?>
		<div class="row row-<?php echo intval( $reduced_numbers ); ?> car-listing-row">
			<?php
			while ( $reduced_query->have_posts() ) :
				$reduced_query->the_post();
				?>
				<?php get_template_part( 'partials/listing-cars/listing-grid-directory-loop-4' ); ?>
			<?php endwhile; ?>
		</div>
		<?php if ( ! empty( $show_more ) && 'yes' === $show_more ) : ?>
			<div class="row">
				<div class="col-xs-12 text-center">
					<div class="dp-in">
						<a class="load-more-btn" href="<?php echo esc_url( stm_get_listing_archive_link() . '?featured_top=true' ); ?>">
							<?php esc_html_e( 'Show all', 'motors-wpbakery-widgets' ); ?>
						</a>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	<div class="btn-wrap">
		<a href="<?php echo esc_url( $inventory_link ); ?>" class="button listing_add_cart heading-font">
			<?php echo esc_html__( 'Show all reduced cars', 'motors-wpbakery-widgets' ); ?>
		</a>
	</div>
	<?php endif; ?>
</div>
