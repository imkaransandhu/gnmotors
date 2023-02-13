<?php
$tab_tax       = '';
$tab_tax_exist = false;
$filter_tab    = stm_get_car_filter();
foreach ( $filter_tab as $filter_taxex ) {
	if ( ! empty( $filter_taxex['use_on_tabs'] ) and $filter_taxex['use_on_tabs'] and ! $tab_tax_exist ) {
		$tab_tax       = $filter_taxex;
		$tab_tax_exist = true;
	}
}

if ( $tab_tax_exist ) {
	echo '<style type="text/css">';
	echo '.filter .stm-filter_' . $tab_tax['slug'] . '{display:none}';
	echo '</style>';
}

if ( empty( $action ) ) {
	$action = 'listings-result';
}

$show_sold = stm_me_get_wpcfto_mod( 'show_sold_listings', false );

?>

<form action="<?php echo stm_listings_current_url(); ?>" method="get" data-trigger="filter" data-action="<?php echo esc_attr( $action ); ?>">
	<div class="filter filter-sidebar ajax-filter">

		<?php do_action( 'stm_listings_filter_before' ); ?>

		<div class="sidebar-entry-header">
			<span class="h4"><?php esc_html_e( 'Search', 'motors' ); ?></span>
			<a class="heading-font" href="<?php echo esc_url( strtok( $_SERVER['REQUEST_URI'], '?' ) ); ?>">
				<?php esc_html_e( 'Reset All', 'motors' ); ?>
			</a>
		</div>

		<div class="row row-pad-top-24">

			<?php
			if ( empty( $filter['filters'] ) ) :
				$post_type_name = esc_html( 'Listings', 'motors' );
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
						<?php echo sprintf( esc_html( 'No categories created for %s', 'motors' ), $post_type_name ); ?>
					</p>
				</div>
			<?php else : ?>

				<?php
				foreach ( $filter['filters'] as $attribute => $config ) :
					if ( ! empty( $filter['options'][ $attribute ] ) ) :
						if ( ! empty( $config['slider'] ) && $config['slider'] ) :
							stm_listings_load_template(
								'filter/types/slider',
								array(
									'taxonomy' => $config,
									'options'  => $filter['options'][ $attribute ],
								)
							);
						else :
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

				<?php
					// stm_listings_load_template('filter/types/location');
				?>

				<?php
				stm_listings_load_template(
					'filter/types/features',
					array(
						'taxonomy' => 'stm_additional_features',
					)
				);
				?>

				<?php if ( $show_sold && $action != 'listings-sold' ) : ?>
					<div class="col-md-12 col-sm-12 stm-filter_listing_status">
						<div class="form-group">
							<select name="listing_status" class="form-control">
								<option value="">
									<?php esc_html_e( 'Listing status', 'motors' ); ?>
								</option>
								<option value="active" <?php echo ( isset( $_GET['listing_status'] ) && $_GET['listing_status'] == 'active' ) ? 'selected' : ''; ?>>
									<?php esc_html_e( 'Active', 'motors' ); ?>
								</option>
								<option value="sold" <?php echo ( isset( $_GET['listing_status'] ) && $_GET['listing_status'] == 'sold' ) ? 'selected' : ''; ?>>
									<?php esc_html_e( 'Sold', 'motors' ); ?>
								</option>
							</select>
						</div>
					</div>
				<?php endif; ?>

			<?php endif; ?>

		</div>

		<!--View type-->
		<input type="hidden" id="stm_view_type" name="view_type"
			   value="<?php echo esc_attr( stm_listings_input( 'view_type' ) ); ?>"/>
		<!--Filter links-->
		<input type="hidden" id="stm-filter-links-input" name="stm_filter_link" value=""/>
		<!--Popular-->
		<input type="hidden" name="popular" value="<?php echo esc_attr( stm_listings_input( 'popular' ) ); ?>"/>

		<input type="hidden" name="sort_order" value="<?php echo esc_attr( stm_listings_input( 'sort_order' ) ); ?>"/>

		<?php if ( ! empty( $filter['filters'] ) ) : ?>
			<div class="sidebar-action-units">
				<input id="stm-classic-filter-submit" class="hidden" type="submit"
					value="<?php esc_html_e( 'Show cars', 'motors' ); ?>"/>

				<a href="<?php echo esc_url( stm_get_listing_archive_link() ); ?>"
				class="button"><span><?php esc_html_e( 'Reset all', 'motors' ); ?></span></a>
			</div>
		<?php endif; ?>

		<?php do_action( 'stm_listings_filter_after' ); ?>
	</div>

	<?php stm_listings_load_template( 'filter/types/checkboxes', array( 'filter' => $filter ) ); ?>

</form>

<?php stm_listings_load_template( 'filter/types/links', array( 'filter' => $filter ) ); ?>
