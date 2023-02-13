<?php
$query = $GLOBALS['wp_query'];

if ( have_posts() ) :

	$view_type = sanitize_file_name( stm_listings_input( 'view_type', stm_me_get_wpcfto_mod( 'listing_view_type', 'list' ) ) );

	/*Filter Badges*/
	stm_listings_load_template( 'filter/badges' );

	if ( is_listing() && 'sold_car' !== $type ) {
		stm_listings_load_template( 'classified/filter/featured' );
	}
	?>

	<div class="stm-isotope-sorting stm-isotope-sorting-<?php echo esc_attr( $view_type ); ?>">
		<?php
		if ( 'grid' === $view_type ) :
			?>
		<div class="row row-3 car-listing-row car-listing-modern-grid">
			<?php
		endif;

			$template = 'partials/listing-cars/listing-' . $view_type . '-loop';

		if ( stm_is_ev_dealer() || is_listing( array( 'listing', 'listing_two', 'listing_three', 'listing_three_elementor', 'listing_one_elementor' ) ) || stm_is_dealer_two() || stm_is_listing_five() || stm_is_listing_six() ) {
			$template = 'partials/listing-cars/listing-' . $view_type . '-directory-loop';
		} elseif ( stm_is_listing_four() ) {
			$template = 'partials/listing-cars/listing-four-' . $view_type . '-loop';
		} elseif ( stm_is_boats() && 'list' === $view_type ) {
			$template = 'partials/listing-cars/listing-' . $view_type . '-loop-boats';
		} elseif ( stm_is_motorcycle() ) {
			$template = 'partials/listing-cars/motos/' . $view_type;
		} elseif ( stm_is_aircrafts() ) {
			$template = 'partials/listing-cars/listing-aircrafts-' . $view_type;
		}

		while ( have_posts() ) :
			the_post();
			get_template_part( $template );
			endwhile;

		if ( 'grid' === $view_type ) :
			?>
		</div>
	<?php endif; ?>

	</div>
	<?php
	if ( is_null( $navigation_type ) || 'pagination' === $navigation_type ) :
		stm_listings_load_pagination();
	else :
		$ppp   = $query->query['posts_per_page'];
		$paged = ( ! empty( $query->query['paged'] ) && 1 !== $query->query['paged'] ) ? $query->query['paged'] + 1 : 2;

		if ( $ppp < $query->found_posts ) {
			echo "<a class='btn stm-inventory-load-more-btn' href='#' data-ppp='" . esc_attr( $ppp ) . "' data-page='" . esc_attr( $paged ) . "' data-nav='load_more' data-offset='1'>" . esc_html__( 'Load More', 'motors' ) . '</a>';
		}
	endif;
	?>
<?php else : ?>
	<h3><?php esc_html_e( 'Sorry, no results', 'motors' ); ?></h3>
<?php endif; ?>
<?php if ( stm_is_aircrafts() ) : ?>
	<script>
		jQuery(document).ready(function (){
			var showing = '<?php echo esc_html( $query->found_posts ); ?>';

			jQuery('.ac-total').text('<?php echo esc_html( $query->found_posts ); ?>');

			if(showing === '0') {
				jQuery('.ac-showing').text('0');
			}
		});
	</script>
<?php endif; ?>
