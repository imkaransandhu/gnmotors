<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract

$css_class = ( ! empty( $css ) ) ? apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) ) : '';

$filter_by    = explode( ',', $atts['filter_all'] );
$is_inventory = ( get_the_ID() === intval( stm_me_get_wpcfto_mod( 'listing_archive', 0 ) ) ) ? true : false;
$show_sold    = stm_me_get_wpcfto_mod( 'show_sold_listings' );

?>
<div class="row stm_inventory_with_filter-wrap 
<?php
if ( $is_inventory ) {
	echo 'is_page_inventory';}
?>
">
	<div class="col-md-3 col-sm-12 classic-filter-row sidebar-sm-mg-bt">
		<?php
		$data   = array_filter( (array) get_option( 'stm_vehicle_listing_options' ) );
		$filter = array();

		foreach ( $data as $key => $_data ) {
			foreach ( $filter_by as $_val ) {
				if ( array_key_exists( 'slug', $_data ) && $_data['slug'] === $_val ) {
					$filter['filters'][ $_data['slug'] ] = $_data;
				}
			}
		}

		$_terms = get_terms(
			array(
				'taxonomy'               => $filter_by,
				'hide_empty'             => true,
				'update_term_meta_cache' => false,
			)
		);

		$terms = array();

		foreach ( $_terms as $_term ) {
			if ( ! empty( $_term ) ) {
				$terms[ $_term->taxonomy ][ $_term->slug ] = $_term;
			}
		}

		$filter['options'] = $terms;
		$selected_options  = array();
		?>
		<form action="<?php echo esc_url( stm_listings_current_url() ); ?>" method="get" data-trigger="filter">
			<?php
			wp_nonce_field( 'inventory_with_filter' );
			foreach ( $filter['filters'] as $checkbox ) {
				if ( false === apply_filters( 'stm_is_listing_price_field', $checkbox['slug'] ) ) {

					$listing_rows_numbers_default_expanded = 'false';
					if ( isset( $checkbox['listing_rows_numbers_default_expanded'] ) && 'open' === $checkbox['listing_rows_numbers_default_expanded'] ) {
						$listing_rows_numbers_default_expanded = 'true';
					}

					if ( ! empty( $_GET[ $checkbox['slug'] ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
						if ( is_array( $_GET[ $checkbox['slug'] ] ) && ! empty( $_GET[ $checkbox['slug'] ][0] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
							$val = $_GET[ $checkbox['slug'] ][0]; // phpcs:ignore WordPress.Security
						} else {
							$val = sanitize_text_field( wp_unslash( $_GET[ $checkbox['slug'] ] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
						}

						$selected_options = $val;
						if ( ! is_array( $selected_options ) ) {
							$selected_options = array( '0' => $selected_options );
						}
					}

					if ( ! empty( $checkbox['enable_checkbox_button'] ) && 1 === $checkbox['enable_checkbox_button'] ) {
						$stm_checkbox_ajax_button = 'stm-ajax-checkbox-button';
					} else {
						$stm_checkbox_ajax_button = 'stm-ajax-checkbox-instant';
					}
					?>

					<?php
					$terms_args = array(
						'orderby'    => 'name',
						'order'      => 'ASC',
						'hide_empty' => false,
						'fields'     => 'all',
						'pad_counts' => true,
					);
					?>
					<div class="stm-accordion-single-unit stm-listing-directory-checkboxes <?php echo esc_attr( $stm_checkbox_ajax_button ); ?>">
						<a class="title <?php echo ( 'false' === $listing_rows_numbers_default_expanded ) ? 'collapsed' : ''; ?> "
							data-toggle="collapse" href="#accordion-<?php echo esc_attr( $checkbox['slug'] ); ?>"
							aria-expanded="<?php echo esc_attr( $listing_rows_numbers_default_expanded ); ?>">
							<h5><?php echo esc_html( $checkbox['single_name'] ); ?></h5>
							<span class="minus"></span>
						</a>
						<div class="stm-accordion-content">
							<div class="collapse content <?php echo ( 'true' === $listing_rows_numbers_default_expanded ) ? 'in' : ''; ?>"
								id="accordion-<?php echo esc_attr( $checkbox['slug'] ); ?>">
								<div class="stm-accordion-content-wrapper stm-accordion-content-padded">
									<div class="stm-accordion-inner">
										<?php
										$terms = get_terms( $checkbox['slug'], $terms_args );

										if ( ! empty( $terms ) ) {
											foreach ( $terms as $stm_term ) {
												?>
												<label class="stm-option-label 
												<?php
												if ( in_array( $stm_term->slug, $selected_options, true ) ) :
													?>
													checked<?php endif; ?>"
														data-taxonomy="stm-iwf-<?php echo esc_attr( $stm_term->taxonomy ); ?>">
													<input type="checkbox"
															name="<?php echo esc_attr( $checkbox['slug'] ); ?>[]"
															value="<?php echo esc_attr( $stm_term->slug ); ?>"
															<?php
															if ( in_array( $stm_term->slug, $selected_options, true ) ) :
																?>
																checked<?php endif; ?>/>
													<span class="heading-font"><?php echo esc_html( $stm_term->name ); ?>
														<span
																class="count"
																data-slug="stm-iwf-<?php echo esc_attr( $stm_term->slug ); ?>">(<?php echo esc_html( $stm_term->count ); ?>)</span></span>
												</label>
												<?php
											}
										}

										if ( ! empty( $checkbox['enable_checkbox_button'] ) && 1 === $checkbox['enable_checkbox_button'] ) :
											?>
											<div class="clearfix"></div>
											<div class="stm-checkbox-submit">
												<a class="button"
													href="#"><?php echo esc_html_e( 'Apply', 'motors-wpbakery-widgets' ); ?></a>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
				} else {
					if ( ! empty( $filter['options'] ) && ! empty( $filter['options']['price'] ) ) {
						stm_listings_load_template(
							'filter/types/price',
							array(
								'taxonomy' => 'price',
								'options'  => $filter['options']['price'],
							)
						);
					}
				}
			}
			?>

			<?php if ( $show_sold ) : ?>
				<div class="stm-accordion-single-unit stm-listing-directory-checkboxes <?php echo esc_attr( $stm_checkbox_ajax_button ); ?>">
					<a class="title collapsed"
						data-toggle="collapse" href="#accordion-filter_listing_status"
						aria-expanded="">
						<h5><?php esc_html_e( 'Listing status', 'motors-wpbakery-widgets' ); ?></h5>
						<span class="minus"></span>
					</a>
					<div class="stm-accordion-content">
						<div class="collapse content" id="accordion-filter_listing_status">
							<div class="stm-accordion-content-wrapper stm-accordion-content-padded">
								<div class="stm-accordion-inner">
									<label class="stm-option-label <?php echo ( ! empty( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'inventory_with_filter' ) && isset( $_GET['listing_status'] ) && 'active' === $_GET['listing_status'] ) ? 'checked' : ''; ?>" data-taxonomy="stm-iwf-stm_active_listings">
										<input type="checkbox" name="listing_status" value="active"
										<?php echo ( isset( $_GET['listing_status'] ) && 'active' === $_GET['listing_status'] ) ? 'checked' : ''; ?>/>
										<span class="heading-font"><?php echo esc_html_e( 'Active', 'motors-wpbakery-widgets' ); ?>
										<span class="count" data-slug="stm-iwf-stm_active_listings">(<?php echo esc_html( stm_get_listings_count_by_status( 'active' ) ); ?>)</span></span>
									</label>
									<label class="stm-option-label <?php echo ( isset( $_GET['listing_status'] ) && 'sold' === $_GET['listing_status'] ) ? 'checked' : ''; ?>" data-taxonomy="stm-iwf-stm_sold_listings">
										<input type="checkbox" name="listing_status" value="sold"
										<?php echo ( ! empty( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'inventory_with_filter' ) && ! empty( $_GET['listing_status'] ) && 'sold' === $_GET['listing_status'] ) ? 'checked' : ''; ?>/>
										<span class="heading-font"><?php echo esc_html_e( 'Sold', 'motors-wpbakery-widgets' ); ?>
										<span class="count" data-slug="stm-iwf-stm_sold_listings">(<?php echo esc_html( stm_get_listings_count_by_status( 'sold' ) ); ?>)</span></span>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>


			<input type="hidden" id="stm_view_type" name="view_type" value="<?php echo esc_attr( stm_listings_input( 'view_type', stm_me_get_wpcfto_mod( 'listing_view_type', 'list' ) ) ); ?>"/>
			<input type="hidden" name="navigation_type" value="<?php echo esc_attr( $navigation ); ?>" />
			<input type="hidden" name="posts_per_page" value="<?php echo esc_attr( $posts_per_page ); ?>" />
			<input type="hidden" name="sort_order" value="<?php echo esc_attr( stm_listings_input( 'sort_order' ) ); ?>"/>
		</form>
	</div>

	<div class="col-md-9 col-sm-12">

		<div class="stm-ajax-row">
			<div class="stm-action-wrap">
				<?php if ( $is_inventory ) : ?>
					<div class="showing heading-font">
					<?php
					printf(
						/* translators: 1. number of posts per page, 2. zero */
						wp_kses_post( '<b>Showing <span class="ac-showing">%1$s</span> jets</b> from <span class="ac-total">%2$s</span>', 'motors-wpbakery-widgets' ),
						esc_html( $posts_per_page ),
						0
					);
					?>
					</div>
				<?php else : ?>
					<h2><?php echo esc_html( $inventory_title ); ?></h2>
				<?php endif; ?>
				<?php stm_listings_load_template( 'filter/actions' ); ?>
			</div>
			<div id="listings-result">
				<?php stm_listings_load_results( array( 'posts_per_page' => $posts_per_page ), null, $navigation ); ?>
			</div>
		</div>

	</div> <!--col-md-9-->
</div>
