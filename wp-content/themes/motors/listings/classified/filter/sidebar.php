<?php
	$filter_bg = stm_me_motors_get_wpcfto_mod( 'sidebar_filter_bg', get_template_directory_uri() . '/assets/images/listing-directory-filter-bg.jpg' );

if ( ! empty( $filter_bg ) ) {
	if ( is_int( $filter_bg ) ) {
		$filter_bg = wp_get_attachment_image_url( $filter_bg, 'full' );
	}
	?>
		<style type="text/css">
			.stm-template-listing .filter-sidebar:after {
				background-image: url("<?php echo esc_url( $filter_bg ); ?>");
			}
		</style>
		<?php
}

if ( empty( $action ) ) {
	$action = 'listings-result'; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
}

	$show_sold = stm_me_get_wpcfto_mod( 'show_sold_listings', false );
?>

<form action="<?php echo esc_url( stm_listings_current_url() ); ?>" method="get" data-trigger="filter" data-action="<?php echo esc_attr( $action ); ?>">
	<div class="filter filter-sidebar ajax-filter">

		<?php do_action( 'stm_listings_filter_before' ); ?>

		<?php if ( ! stm_is_dealer_two() && ! stm_is_motorcycle() ) : ?>
			<div class="sidebar-entry-header">
				<i class="stm-icon-car_search"></i>
				<span class="h4"><?php esc_html_e( 'Search Options', 'motors' ); ?></span>
			</div>
		<?php else : ?>
			<div class="sidebar-entry-header">
				<span class="h4"><?php esc_html_e( 'Search', 'motors' ); ?></span>
				<a class="heading-font" href="<?php echo esc_url( strtok( $_SERVER['REQUEST_URI'], '?' ) ); // phpcs:ignore WordPress.Security ?>">
					<?php esc_html_e( 'Reset All', 'motors' ); ?>
				</a>
			</div>
		<?php endif; ?>

		<div class="row row-pad-top-24">

			<?php
			if ( empty( $filter['filters'] ) ) :
				$post_type_name = __( 'Listings', 'motors' );
				if ( stm_is_multilisting() ) {
					$ml = new STMMultiListing();
					if ( ! empty( $ml->stm_get_current_listing() ) ) {
						$multitype      = $ml->stm_get_current_listing();
						$post_type_name = $multitype['label'];
					}
				}
				?>
				<div class="col-md-12 col-sm-12">
					<p class="text-muted text-center">
						<?php
						/* translators: post type name */
						echo sprintf( esc_html__( 'No categories created for %s', 'motors' ), esc_html( $post_type_name ) );
						?>
					</p>
				</div>
			<?php else : ?>

				<?php
				foreach ( $filter['filters'] as $attribute => $config ) :

					if ( 'price' === $attribute && ! empty( $config['slider'] ) ) {
						continue;
					}
					if ( ! empty( $config['slider'] ) && $config['slider'] ) :
						if ( isset( $filter['options'][ $attribute ] ) ) :
							stm_listings_load_template(
								'filter/types/slider',
								array(
									'taxonomy' => $config,
									'options'  => $filter['options'][ $attribute ],
								)
							);
						endif;
					else :
						if ( isset( $filter['options'][ $attribute ] ) ) :
							?>

							<div class="col-md-12 col-sm-6 stm-filter_<?php echo esc_attr( $attribute ); ?>">
								<div class="form-group">
									<?php
									stm_listings_load_template(
										'filter/types/select',
										array(
											'options' => $filter['options'][ $attribute ],
											'name'    => $attribute,
										)
									);
									?>
								</div>
							</div>

						<?php endif; ?>
					<?php endif; ?>
				<?php endforeach; ?>

				<?php if ( $show_sold && 'listings-sold' !== $action ) : ?>
					<div class="col-md-12 col-sm-12 stm-filter_listing_status">
						<div class="form-group">
							<select name="listing_status" class="form-control">
								<option value="">
									<?php esc_html_e( 'Listing status', 'motors' ); ?>
								</option>
								<option value="active" <?php echo ( isset( $_GET['listing_status'] ) && 'active' === $_GET['listing_status'] ) ? 'selected' : ''; // phpcs:ignore WordPress.Security ?>>
									<?php esc_html_e( 'Active', 'motors' ); ?>
								</option>
								<option value="sold" <?php echo ( isset( $_GET['listing_status'] ) && 'sold' === $_GET['listing_status'] ) ? 'selected' : ''; // phpcs:ignore WordPress.Security ?>>
									<?php esc_html_e( 'Sold', 'motors' ); ?>
								</option>
							</select>
						</div>
					</div>
				<?php endif; ?>

				<?php stm_listings_load_template( 'filter/types/location' ); ?>

				<?php
				stm_listings_load_template(
					'filter/types/features',
					array(
						'taxonomy' => 'stm_additional_features',
					)
				);
				?>
			<?php endif; ?>

		</div>

		<!--View type-->
		<input type="hidden" id="stm_view_type" name="view_type" value="<?php echo esc_attr( stm_listings_input( 'view_type' ) ); ?>"/>
		<!--Filter links-->
		<input type="hidden" id="stm-filter-links-input" name="stm_filter_link" value=""/>
		<!--Popular-->
		<input type="hidden" name="popular" value="<?php echo esc_attr( stm_listings_input( 'popular' ) ); ?>"/>
		<input type="hidden" name="s" value="<?php echo esc_attr( stm_listings_input( 's' ) ); ?>"/>
		<input type="hidden" name="sort_order" value="<?php echo esc_attr( stm_listings_input( 'sort_order' ) ); ?>"/>

		<?php if ( ! empty( $filter['filters'] ) ) : ?>
			<div class="sidebar-action-units">
				<input id="stm-classic-filter-submit" class="hidden" type="submit" value="<?php esc_html_e( 'Show cars', 'motors' ); ?>"/>

				<a href="<?php echo esc_url( strtok( $_SERVER['REQUEST_URI'], '?' ) ); ?>" class="button"><span><?php esc_html_e( 'Reset all', 'motors' ); // phpcs:ignore WordPress.Security ?></span></a>
			</div>
		<?php endif; ?>

		<?php do_action( 'stm_listings_filter_after' ); ?>
	</div>

	<!--Classified price-->
	<?php
	if ( ! empty( $filter['options']['price'] ) && ! empty( $filter['filters']['price']['slider'] ) ) {
		stm_listings_load_template(
			'filter/types/price',
			array(
				'taxonomy' => 'price',
				'options'  => $filter['options']['price'],
			)
		);
	}
	?>

	<?php
	if ( ! stm_is_aircrafts() ) {
		stm_listings_load_template( 'filter/types/checkboxes', array( 'filter' => $filter ) );
		stm_listings_load_template( 'filter/types/links', array( 'filter' => $filter ) );
	}
	?>

</form>
