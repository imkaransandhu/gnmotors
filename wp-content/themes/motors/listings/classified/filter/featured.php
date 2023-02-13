<?php
$args                   = stm_listings_query()->query;
$args['posts_per_page'] = 3;

if ( is_listing() ) {
	$args['meta_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
		array(
			'key'     => 'special_car',
			'value'   => 'on',
			'compare' => '=',
		),
	);
} else {
	$args['meta_query'][] = array(
		'key'     => 'special_car',
		'value'   => 'on',
		'compare' => '=',
	);
}

$args['orderby'] = 'rand';

$featured = new WP_Query( $args );

$view_type = stm_listings_input( 'view_type', stm_me_get_wpcfto_mod( 'listing_view_type', 'list' ) );

$url_args = $_GET; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
if ( isset( $url_args['ajax_action'] ) ) {
	unset( $url_args['ajax_action'] );
}

$inventory_link = add_query_arg( array_merge( $url_args, array( 'featured_top' => 'true' ) ), stm_get_listing_archive_link() );

if ( $featured->have_posts() ) : ?>
	<div class="stm-featured-top-cars-title">
		<div class="heading-font"><?php esc_html_e( 'Featured Classified', 'motors' ); ?></div>
		<a href="<?php echo esc_url( $inventory_link ); ?>">
			<?php esc_html_e( 'Show all', 'motors' ); ?>
		</a>
	</div>

	<?php if ( ! stm_listings_input( 'featured_top' ) ) : ?>
		<?php if ( 'grid' === $view_type ) : ?>
			<div class="row row-3 car-listing-row car-listing-modern-grid">
		<?php endif; ?>

			<div class="stm-isotope-sorting stm-isotope-sorting-featured-top">

				<?php
					$template = 'partials/listing-cars/listing-' . $view_type . '-directory-loop';
				while ( $featured->have_posts() ) :
					$featured->the_post();
					if ( stm_is_listing_four() ) {
						get_template_part( 'partials/listing-cars/listing-four-' . $view_type . '-loop' );
					} else {
						get_template_part( 'partials/listing-cars/listing-' . $view_type . '-directory-loop' );
					}
					endwhile;
				?>

			</div>

		<?php if ( 'grid' === $view_type ) : ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
