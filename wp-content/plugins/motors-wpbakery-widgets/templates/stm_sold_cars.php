<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( $atts ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract

$css_class = ( ! empty( $css ) ) ? apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) ) : '';
$view_type = stm_listings_input( 'view_type', stm_me_get_wpcfto_mod( 'listing_view_type', 'list' ) );

if ( 'list' === $view_type && ! empty( $ppp_on_list ) ) {
	$posts_per_page = intval( $ppp_on_list );
} elseif ( 'grid' === $view_type && ! empty( $ppp_on_grid ) ) {
	$posts_per_page = intval( $ppp_on_grid );
} else {
	$posts_per_page = get_option( 'posts_per_page' );
}
?>

<div class="archive-listing-page sold-listings-inventory">
	<div class="container">
		<div class="row">
			<?php
			$filter = stm_listings_filter( array( 'sold_car' => 'on' ) );

			$sidebar_pos = stm_get_sidebar_position();
			$sidebar_id  = stm_me_get_wpcfto_mod( 'listing_sidebar', 'default' );
			if ( ! empty( $sidebar_id ) ) {
				$blog_sidebar = get_post( $sidebar_id );
			}

			if ( ! is_numeric( $sidebar_id ) && ( 'no_sidebar' === $sidebar_id || ! is_active_sidebar( $sidebar_id ) ) ) {
				$sidebar_id = false;
			}

			if ( is_numeric( $sidebar_id ) && empty( $blog_sidebar->post_content ) ) {
				$sidebar_id = false;
			}

			?>
			<div class="col-md-3 col-sm-12 classic-filter-row sidebar-sm-mg-bt <?php echo esc_attr( $sidebar_pos['sidebar'] ); ?>">
				<?php if ( apply_filters( 'stm_is_motorcycle', false ) ) : ?>
					<?php
					stm_listings_load_template(
						'motorcycles/filter/sidebar',
						array(
							'filter' => $filter,
							'action' => 'listings-sold',
						)
					);
					?>
				<?php else : ?>
					<?php
					stm_listings_load_template(
						'classified/filter/sidebar',
						array(
							'filter' => $filter,
							'action' => 'listings-sold',
						)
					);
					?>
				<?php endif; ?>
				<!--Sidebar-->
				<div class="stm-inventory-sidebar">
					<?php
					if ( 'default' === $sidebar_id ) {
						get_sidebar();
					} elseif ( ! empty( $sidebar_id ) ) {
						echo apply_filters( 'the_content', $blog_sidebar->post_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
						<style type="text/css">
							<?php echo esc_attr( get_post_meta( $sidebar_id, '_wpb_shortcodes_custom_css', true ) ); ?>
						</style>
						<?php
					}
					?>
				</div>
			</div>

			<div class="col-md-9 col-sm-12 <?php echo esc_attr( $sidebar_pos['content'] ); ?>">
				<div class="stm-ajax-row">
					<?php stm_listings_load_template( 'classified/filter/actions', array( 'filter' => $filter ) ); ?>
					<div id="listings-result" data-type="sold-car">
						<?php
						stm_listings_load_results(
							array(
								'sold_car'       => 'on',
								'posts_per_page' => $posts_per_page,
							),
							'sold_car'
						);
						?>
					</div>
				</div>
			</div> <!--col-md-9-->

		</div>
	</div>
</div>

<?php wp_reset_postdata(); ?>
