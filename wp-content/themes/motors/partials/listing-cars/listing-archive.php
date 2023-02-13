<div class="row">

	<?php
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
		<?php stm_listings_load_template( 'filter/sidebar' ); ?>
		<!--Sidebar-->
		<div class="stm-inventory-sidebar">
			<?php
			if ( 'default' === $sidebar_id ) {
				get_sidebar();
			} elseif ( ! empty( $sidebar_id ) ) {
				if ( class_exists( \Elementor\Plugin::class ) && is_numeric( $sidebar_id ) ) :
					apply_filters( 'motors_render_elementor_content', $sidebar_id );
				else :
					echo apply_filters( 'the_content', $blog_sidebar->post_content );//phpcs:ignore
				endif;

				if ( ! class_exists( \Elementor\Plugin::class ) ) :
					?>
					<style type="text/css">
						<?php echo get_post_meta( $sidebar_id, '_wpb_shortcodes_custom_css', true );//phpcs:ignore ?>
					</style>
					<?php
				endif;
			}
			?>
		</div>
	</div>

	<div class="col-md-9 col-sm-12 <?php echo esc_attr( $sidebar_pos['content'] ); ?>">

		<div class="stm-ajax-row">
			<?php stm_listings_load_template( 'filter/actions' ); ?>

			<div id="listings-result">
				<?php stm_listings_load_results(); ?>
			</div>
		</div>

	</div> <!--col-md-9-->
</div>
