<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract

$uniqid = uniqid();

if ( ( ! empty( $inactive_tab_bg_color ) && '#11323e' !== $inactive_tab_bg_color ) && ( ! empty( $active_tab_bg_color ) && '#153e4d' !== $active_tab_bg_color ) ) : ?>
		<style>
			.stm_dynamic_listing_two_filter .stm_dynamic_listing_filter_nav li {
				background: ' . $inactive_tab_bg_color . ' !important;
				border-right: 1px solid ' . $inactive_tab_bg_color . ' !important;
			}
			.stm_dynamic_listing_two_filter .stm_dynamic_listing_filter_nav li.active {
				background: ' . $active_tab_bg_color . ' !important;
				border-right: 1px solid ' . $active_tab_bg_color . ' !important;
			}

			.stm_dynamic_listing_two_filter .tab-content {
				background-color: ' . $active_tab_bg_color . ' !important;
			}
		</style>

	<?php
endif;

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );


if ( isset( $atts['items'] ) && strlen( $atts['items'] ) > 0 ) {
	$items = vc_param_group_parse_atts( $atts['items'] );
	if ( ! is_array( $items ) ) {
		$temp         = explode( ',', $atts['items'] );
		$param_values = array();
		foreach ( $temp as $value ) {
			$data                  = explode( '|', $value );
			$new_line              = array();
			$new_line['title']     = isset( $data[0] ) ? $data[0] : 0;
			$new_line['sub_title'] = isset( $data[1] ) ? $data[1] : '';
			if ( isset( $data[1] ) && preg_match( '/^\d{1,3}\%$/', $data[1] ) ) {
				$new_line['title']     = (float) str_replace( '%', '', $data[1] );
				$new_line['sub_title'] = isset( $data[2] ) ? $data[2] : '';
			}
			$param_values[] = $new_line;
		}
		$atts['items'] = rawurlencode( wp_json_encode( $param_values ) );
	}
}

$args = array(
	'post_type'        => apply_filters( 'stm_listings_post_type', 'listings' ),
	'post_status'      => 'publish',
	'posts_per_page'   => 1,
	'suppress_filters' => 0,
);

if ( stm_sold_status_enabled() ) {
	$args['meta_query'][] = array(
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

$all = new WP_Query( $args );
$all = $all->found_posts;

if ( empty( $show_amount ) ) {
	$show_amount = 'no';
}

$words = array();

if ( ! empty( $select_prefix ) ) {
	$words['select_prefix'] = $select_prefix;
}

if ( ! empty( $select_affix ) ) {
	$words['select_affix'] = $select_affix;
}

if ( ! empty( $number_prefix ) ) {
	$words['number_prefix'] = $number_prefix;
}

if ( ! empty( $number_affix ) ) {
	$words['number_affix'] = $number_affix;
}
?>
	<div class="stm_dynamic_listing_two_filter filter-listing stm-vc-ajax-filter animated fadeIn <?php echo esc_attr( $css_class ); ?>">
		<!-- Nav tabs -->
		<ul class="stm_dynamic_listing_filter_nav clearfix heading-font" role="tablist">
			<li role="presentation" class="active">
				<a href="#stm_first_tab" aria-controls="stm_first_tab" role="tab" data-toggle="tab">
					<?php echo esc_attr( $first_tab_label ); ?>
				</a>
			</li>
			<li role="presentation">
				<a href="#stm_second_tab" aria-controls="stm_second_tab" role="tab" data-toggle="tab">
					<?php echo esc_attr( $second_tab_label ); ?>
				</a>
			</li>
			<li role="presentation">
				<a href="#stm_third_tab" aria-controls="stm_third_tab" role="tab" data-toggle="tab">
					<?php echo esc_attr( $third_tab_label ); ?>
				</a>
			</li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="stm_first_tab">
				<form action="<?php echo esc_url( stm_get_listing_archive_link() ); ?>" method="GET">
					<div class="btn-wrap">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12 stm-select-col">
								<?php if ( count( explode( ',', $first_tab_tax ) ) > 4 ) : ?>
									<div class="stm-more-options-wrap" data-tab="first">
								<span>
									<?php echo esc_html__( 'Advanced search', 'motors-wpbakery-widgets' ); ?>
									<i class="fas fa-angle-down"></i>
								</span>
									</div>
								<?php endif; ?>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 stm-select-col">
								<button type="submit" class="heading-font">
									<i class="fas fa-search"></i> <?php echo '<span>' . esc_html( $all ) . '</span> ' . esc_html( $search_button_postfix ); ?>
								</button>
							</div>
						</div>
					</div>
					<div class="stm-filter-tab-selects stm-filter-tab-selects-first filter stm-vc-ajax-filter">
						<?php if ( function_exists( 'stm_listing_filter_get_selects' ) ) : ?>
							<?php stm_listing_filter_get_selects( $first_tab_tax, 'stm_all_listing_tab', $words, $show_amount, true ); ?>
						<?php endif; ?>
					</div>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane fade in" id="stm_second_tab">
				<form action="<?php echo esc_url( stm_review_archive_link() ); ?>" method="GET">
					<div class="btn-wrap">
						<button type="submit" class="heading-font">
							<i class="fas fa-search"></i> <?php echo '<span>' . esc_html( $all ) . '</span> ' . esc_html( $search_button_postfix ); ?>
						</button>
						<?php if ( count( explode( ',', $second_tab_tax ) ) > 4 ) : ?>
							<div class="stm-more-options-wrap" data-tab="second">
							<span>
								<?php echo esc_html__( 'Advanced search', 'motors-wpbakery-widgets' ); ?>
								<i class="fas fa-angle-down"></i>
							</span>
							</div>
						<?php endif; ?>
					</div>
					<div class="stm-filter-tab-selects stm-filter-tab-selects-second filter stm-vc-ajax-filter">
						<?php stm_listing_filter_get_selects( $second_tab_tax, 'stm_car_reviews_tab', $words, false, true ); ?>
					</div>
					<input type="hidden" name="listing_type" value="with_review" />
				</form>
			</div>
			<div role="tabpanel" class="tab-pane fade in" id="stm_third_tab">
				<div class="stm-filter-tab-selects stm-filter-tab-selects-third filter stm-vc-ajax-filter" id="value-my-car-<?php echo esc_attr( $uniqid ); ?>">
					<?php
					if ( ! empty( $third_tab_tax ) ) {
						$html   = '<form method="post" name="vmc-form" type="multipart/formdata">';
						$html  .= '<div class="row">';
						$params = explode( ',', $third_tab_tax );
						$opt    = stm_get_value_my_car_options();
						$i      = 0;

						foreach ( $params as $k ) {
							if ( 4 === $i && count( $params ) > 4 ) {
								$html .= '<div class="stm-slide-content clearfix">';
							}

							if ( 'photo' === $k ) {
								$html .= '<div class="col-md-3 col-sm-6 col-xs-12 stm-select-col vmc-file-wrap">'; // input wrap div open.
								$html .= '<div class="file-wrap"><div class="input-file-holder"><span>' . __( 'Add Image', 'motors-wpbakery-widgets' ) . '</span><i class="fas fa-plus"></i><input type="file"  name="' . $k . '" /></div><span class="error"></span></div>';
							} else {
								$html .= '<div class="col-md-3 col-sm-6 col-xs-12 stm-select-col">'; // input wrap div open.
								$html .= '<input type="text" name="' . $k . '" placeholder="' . array_search( $k, $opt, true ) . '" />';
							}

							$html .= '</div>'; // input wrap div close.

							if ( ( count( $params ) - 1 ) === $i && count( $params ) > 4 ) {
								$html .= '</div>';
							}

							$i++;
						}

						$html .= '</div>';
						$html .= '</form>';

						echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
					?>
				</div>
				<div class="btn-wrap">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12 stm-select-col">
							<?php if ( count( explode( ',', $third_tab_tax ) ) > 4 ) : ?>
								<div class="stm-more-options-wrap" data-tab="third">
							<span>
								<?php echo esc_html__( 'More Options', 'motors-wpbakery-widgets' ); ?>
								<i class="fas fa-angle-down"></i>
							</span>
								</div>
							<?php endif; ?>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 stm-select-col">
							<button id="vmc-btn" type="submit" class="vmc-btn-submit heading-font" data-widget-id="value-my-car-<?php echo esc_attr( $uniqid ); ?>">
								<?php echo esc_html( $third_tab_label ); ?>
								<i class="fas fa-spinner"></i>
							</button>
							<?php
							if ( class_exists( '\\STM_GDPR\\STM_GDPR' ) ) {
								echo do_shortcode( '[motors_gdpr_checkbox]' );
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
$bind_tax = stm_data_binding( true );

if ( ! empty( $bind_tax ) ) :
	?>

	<script>
		jQuery(function ($) {
			var options = <?php echo wp_json_encode( $bind_tax ); ?>,
				show_amount = <?php echo wp_json_encode( 'no' !== $show_amount ); ?>;

			if (show_amount) {
				$.each(options, function (tax, data) {
					$.each(data.options, function (val, option) {
						option.label += ' (' + option.count + ')';
					});
				});
			}

			$('.stm-filter-tab-selects.filter').each(function () {
				new STMCascadingSelect(this, options);
			});

			$("select[data-class='stm_select_overflowed']").on("change", function () {
				var sel = $(this);
				var selValue = sel.val();
				var selType = sel.attr("data-sel-type");
				var min = 'min_' + selType;
				var max = 'max_' + selType;

				if( selValue === null || selValue.length == 0 ) return;

				if (selValue.includes("<")) {
					var str = selValue.replace("<", "").trim();
					$("input[name='" + min + "']").val("");
					$("input[name='" + max + "']").val(str);
				} else if (selValue.includes("-")) {
					var strSplit = selValue.split("-");
					$("input[name='" + min + "']").val(strSplit[0]);
					$("input[name='" + max + "']").val(strSplit[1]);
				} else {
					var str = selValue.replace(">", "").trim();
					$("input[name='" + min + "']").val(str);
					$("input[name='" + max + "']").val("");
				}
			});
		});
	</script>
<?php endif; ?>
