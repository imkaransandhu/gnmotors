<?php
$hide_labels = stm_me_get_wpcfto_mod( 'hide_price_labels', false );

if ( $hide_labels ) {
	$classes[] = 'stm-listing-no-price-labels';
}

$classes = array();

$classes[] = 'stm-special-car-top-' . get_post_meta( get_the_ID(), 'special_car', true );

if ( empty( $modern_filter ) ) {
	$modern_filter = false;
}

stm_listings_load_template(
	'loop/start',
	array(
		'modern'          => $modern_filter,
		'listing_classes' => $classes,
	)
);

?>
	<?php stm_listings_load_template( 'loop/classified/list/image' ); ?>

	<div class="content">
		<?php stm_listings_load_template( 'loop/classified/list/title_price', array( 'hide_labels' => $hide_labels ) ); ?>

		<?php stm_listings_load_template( 'loop/classified/list/options' ); ?>

		<div class="meta-bottom">
			<?php get_template_part( 'partials/listing-cars/listing-directive-list-loop', 'actions' ); ?>
		</div>

		<a href="<?php the_permalink(); ?>" class="stm-car-view-more button visible-xs"><?php esc_html_e( 'View more', 'motors' ); ?></a>
	</div>
</div>
