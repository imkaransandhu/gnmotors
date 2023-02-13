<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

$args = array(
	'orderby'    => 'name',
	'order'      => 'ASC',
	'hide_empty' => false,
	'pad_counts' => true,
);

/*Get modern Filter*/
$modern_filter = stm_get_car_modern_filter();

$query_args = array(
	'post_type'      => apply_filters( 'stm_listings_post_type', 'listings' ),
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'paged'          => false,
);

$show_sold = stm_me_get_wpcfto_mod( 'show_sold_listings' );

if ( false === $show_sold ) {
	$query_args[]['meta_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
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
	);
}

$listings = new WP_Query( $query_args );

$listing_filter_position = stm_me_get_wpcfto_mod( 'listing_filter_position', 'left' );
if ( ! empty( $_GET['filter_position'] ) && 'right' === $_GET['filter_position'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$listing_filter_position = 'right';
}

$sidebar_pos_classes = '';
$content_pos_classes = '';

if ( 'right' === $listing_filter_position ) {
	$sidebar_pos_classes = 'col-md-push-9 col-sm-push-0';
	$content_pos_classes = 'col-md-pull-3 col-sm-pull-0';
}
?>
<script>
	var stmOptionsObj = new Object();
</script>

<div class="row" id="modern-filter-listing">
	<div class="col-md-3 col-sm-12 sidebar-sm-mg-bt <?php echo esc_attr( $sidebar_pos_classes ); ?>">
		<?php
		if ( ! empty( $modern_filter ) ) {
			$counter = 0;
			foreach ( $modern_filter as $unit ) {
				$counter++;
				$terms = get_terms( array( $unit['slug'] ), $args );

				$unit['listing_rows_numbers_default_expanded'] = 'open';

				if ( ! empty( $unit['numeric'] ) && 'price' !== $unit['slug'] && empty( $unit['slider'] ) ) {
					stm_listings_load_template(
						'modern_filter/filters/numeric',
						compact( 'modern_filter', 'unit', 'terms' )
					);
				} else {
					if ( empty( $unit['slider'] ) && 'price' !== $unit['slug'] ) {
						/*First one if ts not image goes on another view*/
						if ( 1 === $counter && empty( $unit['use_on_car_modern_filter_view_images'] ) && ! $unit['use_on_car_modern_filter_view_images'] ) {
							if ( ! empty( $terms ) ) {
								stm_listings_load_template(
									'modern_filter/filters/checkbox',
									compact( 'modern_filter', 'unit', 'terms' )
								);
							}
						} else { // if its not first one and have images.
							if ( ! empty( $unit['use_on_car_modern_filter_view_images'] ) ) {
								?>
								<?php
								if ( ! empty( $terms ) ) {
									stm_listings_load_template(
										'modern_filter/filters/images',
										compact( 'modern_filter', 'unit', 'terms' )
									);
								}
							} else { // all others...
								if ( ! empty( $terms ) ) {
									stm_listings_load_template(
										'modern_filter/filters/checkbox',
										compact( 'modern_filter', 'unit', 'terms' )
									);
								}
							}
						}
					} else { /*price*/
						if ( ! empty( $terms ) ) {
							if ( 'price' === $unit['slug'] ) {

								stm_listings_load_template(
									'modern_filter/filters/price',
									compact( 'modern_filter', 'unit', 'terms' )
								);

								?>
								<?php
							} else {

								stm_listings_load_template(
									'modern_filter/filters/slider',
									compact( 'modern_filter', 'unit', 'terms' )
								);
							}
						} // if terms price not empty
					} // slider price
				} // numberic price
			} // foreach

			if ( $show_sold ) {
				stm_listings_load_template(
					'modern_filter/filters/sold_filter',
					compact( 'modern_filter', 'unit' )
				);
			}
		} // if modern filter
		?>
	</div>
	<div class="col-md-9 col-sm-12 <?php echo esc_attr( $content_pos_classes ); ?>">
		<div class="stm-car-listing-sort-units stm-modern-filter-actions clearfix">
			<div class="stm-modern-filter-found-cars">
				<h4><span class="orange"><?php echo esc_attr( $listings->found_posts ); ?></span> <?php esc_html_e( 'Vehicles available', 'motors-wpbakery-widgets' ); ?>
				</h4>
			</div>
			<?php
			$view_list = '';
			$view_grid = '';
			$view_type = stm_listings_input( 'view_type', stm_me_get_wpcfto_mod( 'listing_view_type', 'list' ) );

			if ( ! empty( $_GET['view_type'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				if ( 'list' === $_GET['view_type'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					$view_list = 'active';
				} elseif ( 'grid' === $_GET['view_type'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					$view_grid = 'active';
				}
			} else {
				if ( 'list' === $view_type ) {
					$view_list = 'active';
				} elseif ( 'grid' === $view_type ) {
					$view_grid = 'active';
				}
			}
			?>
			<div class="stm-view-by">
				<a href="?view_type=grid" class="stm-modern-view view-grid view-type <?php echo esc_attr( $view_grid ); ?>">
					<i class="stm-icon-grid"></i>
				</a>
				<a href="?view_type=list" class="stm-modern-view view-list view-type <?php echo esc_attr( $view_list ); ?>">
					<i class="stm-icon-list"></i>
				</a>
			</div>
			<div class="stm-sort-by-options clearfix">
				<span><?php esc_html_e( 'Sort by:', 'motors-wpbakery-widgets' ); ?></span>
				<div class="stm-select-sorting">
					<select>
						<?php echo wp_kses_post( stm_get_sort_options_html() ); ?>
					</select>
				</div>
			</div>
		</div>
		<div class="modern-filter-badges">
			<ul class="stm-filter-chosen-units-list">

			</ul>
		</div>
		<?php if ( $listings->have_posts() ) : ?>
			<?php if ( 'active' === $view_grid ) : ?>
				<div class="row row-3 car-listing-row 
				<?php
				if ( 'active' === $view_grid ) {
					echo esc_attr( 'car-listing-modern-grid' );}
				?>
				">
			<?php endif; ?>

			<div class="stm-isotope-sorting">
				<?php
				$template = 'partials/listing-cars/listing-grid-loop';
				if ( 'active' === $view_grid ) {
					if ( apply_filters( 'stm_is_motorcycle', false ) ) {
						$template = 'partials/listing-cars/motos/grid';
					} elseif ( apply_filters( 'stm_is_listing', false ) ) {
						$template = 'partials/listing-cars/listing-grid-directory-loop';
					} else {
						$template = 'partials/listing-cars/listing-grid-loop';
					}
				} else {
					if ( apply_filters( 'stm_is_motorcycle', false ) ) {
						$template = 'partials/listing-cars/motos/list';
					} elseif ( apply_filters( 'stm_is_listing', false ) ) {
						$template = 'partials/listing-cars/listing-list-directory-loop';
					} elseif ( apply_filters( 'stm_is_boats', false ) ) {
						$template = 'partials/listing-cars/listing-list-loop-boats';
					} else {
						$template = 'partials/listing-cars/listing-list-loop';
					}
				}

				$modern_filter = true;

				while ( $listings->have_posts() ) :
					$listings->the_post();
					include locate_template( $template . '.php' );
				endwhile;
				?>
				<a class="button stm-show-all-modern-filter stm-hidden-filter"><?php esc_html_e( 'Show all', 'motors-wpbakery-widgets' ); ?></a>
			</div>
			<?php if ( 'active' === $view_grid ) : ?>
				</div>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</div>
</div>
