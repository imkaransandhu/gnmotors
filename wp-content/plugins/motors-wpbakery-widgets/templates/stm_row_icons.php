<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
$css_class = ( ! empty( $css ) ) ? apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) ) : '';

if ( ! empty( $filter_selected ) ) :
	$args = array(
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => false,
		'pad_counts' => true,
	);

	$terms = get_terms( $filter_selected, $args );

	$terms_images = array();
	$terms_text   = array();
	if ( ! empty( $terms ) ) {
		foreach ( $terms as $stm_term ) {
			$image = get_term_meta( $stm_term->term_id, 'stm_image', true );
			if ( empty( $image ) ) {
				$terms_text[] = $stm_term;
			} else {
				$terms_images[] = $stm_term;
			}
		}
	}
	?>

	<div class="stm-boats-listing-icons <?php echo esc_attr( $css_class ); ?>">
		<?php foreach ( $terms_images as $stm_term ) : ?>
			<?php
			$image = get_term_meta( $stm_term->term_id, 'stm_image', true );
			if ( ! empty( $image ) ) :
				$image_dim = 'stm-img-190-132';
				if ( apply_filters( 'stm_is_motorcycle', false ) ) {
					$image_dim = 'stm-img-350-205';
				}
				$image          = wp_get_attachment_image_src( $image, $image_dim );
				$category_image = $image[0];
				?>
				<a href="<?php echo esc_url( stm_get_listing_archive_link() . '?' . $filter_selected . '=' . $stm_term->slug ); ?>"
					class="stm_listing_icon_filter_single" title="<?php echo esc_attr( $stm_term->name ); ?>">
					<div class="inner">
						<div class="image">
							<img src="<?php echo esc_url( $category_image ); ?>" alt="<?php echo esc_attr( $stm_term->name ); ?>" />
						</div>
						<div class="name heading-font"><?php echo esc_attr( $stm_term->name ); ?></div>
					</div>
				</a>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>

<?php endif; ?>
