<?php
	$filter    = stm_listings_filter( null, true );
	$show_sold = stm_me_get_wpcfto_mod( 'show_sold_listings' );
?>
	<form action="<?php echo esc_url( stm_listings_current_url() ); ?>" method="get" data-trigger="filter">
		<div class="filter filter-sidebar stm-filter-sidebar-boats">
			<?php do_action( 'stm_listings_filter_before' ); ?>
			<div class="row row-pad-top-24">
				<div class="stm-boats-shorten-filter clearfix">
					<?php
					$close_filter = 0;
					foreach ( $filter['filters'] as $attribute => $config ) :
						if ( ! empty( $config['slider'] ) && $config['slider'] ) {
							if ( ! empty( $filter['options'][ $attribute ] ) ) {
								stm_listings_load_template(
									'filter/types/slider',
									array(
										'taxonomy' => $config,
										'options'  => $filter['options'][ $attribute ],
									)
								);
							}
						} else {
							?>
							<?php if ( ! empty( $filter['options'][ $attribute ] ) ) : ?>
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
						<?php } ?>

						<?php $close_filter++; ?>
						<?php if ( 3 === $close_filter ) : ?>
					</div>
					<div class="stm-boats-expand-filter col-md-12">
						<span><?php esc_html_e( 'More options', 'motors' ); ?></span></div>
						<script type="text/javascript">
							var stm_filter_expand_close = '<?php esc_html_e( 'Less options', 'motors' ); ?>';
						</script>
					<div class="stm-boats-longer-filter clearfix">
						<?php endif; ?>
				<?php endforeach; ?>

				<?php if ( $show_sold ) : ?>
					<div class="col-md-12 col-sm-12 stm-filter_listing_status">
						<div class="form-group">
							<select name="listing_status" class="form-control">
								<option value="">
									<?php esc_html_e( 'Listing status', 'motors' ); ?>
								</option>
								<option value="active" <?php echo ( isset( $_GET['listing_status'] ) && 'active' === $_GET['listing_status'] ) ? 'selected' : ''; ?>>
									<?php esc_html_e( 'Active', 'motors' ); ?>
								</option>
								<option value="sold" <?php echo ( isset( $_GET['listing_status'] ) && 'sold' === $_GET['listing_status'] ) ? 'selected' : ''; ?>>
									<?php esc_html_e( 'Sold', 'motors' ); ?>
								</option>
							</select>
						</div>
					</div>
				<?php endif; ?>

				<?php stm_listings_load_template( 'filter/types/location' ); ?>
				</div>
			</div>

			<!--View type-->
			<input type="hidden" id="stm_view_type" name="view_type"
				value="<?php echo esc_attr( stm_listings_input( 'view_type' ) ); ?>"/>
			<!--Filter links-->
			<input type="hidden" id="stm-filter-links-input" name="stm_filter_link" value=""/>
			<!--Popular-->
			<input type="hidden" name="popular" value="<?php echo esc_attr( stm_listings_input( 'popular' ) ); ?>"/>

			<input type="hidden" name="s" value="<?php echo esc_attr( stm_listings_input( 's' ) ); ?>"/>
			<input type="hidden" name="sort_order" value="<?php echo esc_attr( stm_listings_input( 'sort_order' ) ); ?>"/>

			<button id="stm-classic-filter-submit" class="stm-classic-filter-submit-boats heading-font" type="submit">
				<i class="stm-icon-search"></i>
				<span><?php echo intval( $filter['total'] ); ?></span>
				<?php esc_html_e( 'Items', 'motors' ); ?>
			</button>

			<?php do_action( 'stm_listings_filter_after' ); ?>
		</div>

		<?php stm_listings_load_template( 'filter/types/checkboxes', array( 'filter' => $filter ) ); ?>

	</form>

<?php stm_listings_load_template( 'filter/types/links', array( 'filter' => $filter ) ); ?>
