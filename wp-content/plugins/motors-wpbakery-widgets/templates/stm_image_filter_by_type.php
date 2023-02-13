<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );


$random_id = 'owl_' . wp_rand( 1, 99999 );
$items     = vc_param_group_parse_atts( $atts['items'] );

$image_sizes = array(
	'items_3' => array( 'stm-img-635-255', 'stm-img-635-255', 'stm-img-445-540' ),
	'items_4' => array( 'stm-img-445-255', 'stm-img-635-255', 'stm-img-635-255', 'stm-img-445-255' ),
	'items_5' => array( 'stm-img-635-255', 'stm-img-445-255', 'stm-img-350-255', 'stm-img-350-255', 'stm-img-350-255' ),
);

?>
<div class="stm-image-filter-wrap <?php echo esc_attr( $css_class ); ?>">
	<div class="title">
		<?php echo wp_kses_post( $content ); ?>
	</div>
	<div id="<?php echo esc_attr( $random_id ); ?>" class="owl-carousel stm-img-filter-container stm-img-<?php echo esc_attr( $row_number ); ?>">
		<?php
		if ( is_array( $items ) ) {
			$num = 0;
			$i   = 0;
			foreach ( $items as $item ) {
				if ( empty( $item['images'] ) ) {
					continue;
				}
				if ( 0 === $num ) {
					echo '<div class="carousel-container">';
				}
				$stm_term = get_term_by( 'slug', $item['body_type'], 'body' );
				$img      = wp_get_attachment_image_src( $item['images'], $image_sizes[ 'items_' . $row_number ][ $num ] );

				if ( 3 === $row_number && ( 0 === $num || 2 === $num ) ) {
					echo '<div class="col-wrap">';
				}

				$calculation = ( $num % $row_number );

				?>
				<div class="img-filter-item template-<?php echo esc_attr( $row_number ) . '-' . esc_attr( $calculation ); ?>">
					<a href="<?php echo esc_url( stm_get_listing_archive_link( array( 'body' => $item['body_type'] ) ) ); ?>">
						<div class="img-wrap">
							<img src="<?php echo esc_url( $img[0] ); ?>" />
						</div>
					</a>
					<div class="body-type-data">
						<div class="bt-title heading-font"><?php echo esc_html( $stm_term->name ); ?></div>
						<div class="bt-count normal_font"><?php echo esc_html( $stm_term->count ) . ' ' . esc_html__( 'cars', 'motors-wpbakery-widgets' ); ?></div>
					</div>
				</div>
				<?php

				if ( 3 === $row_number && ( 1 === $num || 2 === $num ) ) {
					echo '</div>';
				}
				$num = ( $row_number - 1 > $num ) ? $num + 1 : 0;
				if ( 0 === $num || ( count( $items ) - 1 ) === $i ) {
					echo '</div>';
				}
				$i++;
			}
		}
		?>
	</div>
</div>

<script>
	(function($) {
		$(document).ready(function () {
			var owlIcon = $('#<?php echo esc_attr( $random_id ); ?>');
			var owlRtl = false;
			if( $('body').hasClass('rtl') ) {
				owlRtl = true;
			}

			owlIcon.on('initialized.owl.carousel', function(e){
				setTimeout(function () {
					owlIcon.find('.owl-nav, .owl-dots').wrapAll("<div class='owl-controls'></div>");
					owlIcon.find('.owl-dots').remove();
				}, 500);
			});

			owlIcon.owlCarousel({
				items: 1,
				smartSpeed: 800,
				dots: false,
				margin: 0,
				autoplay: false,
				nav: true,
				navElement: 'div',
				loop: false,
				responsiveRefreshRate: 1000,
			})
		});
	})(jQuery);
</script>
