<?php
$show_compare    = stm_me_get_wpcfto_mod( 'header_compare_show', false );
$compare_page_id = ( stm_is_listing_six() ) ? \uListing\Classes\StmListingSettings::getPages( 'compare_page' ) : stm_me_get_wpcfto_mod( 'compare_page', 156 );
$compare_icon     = ( stm_is_listing_six() ) ? 'stm-all-icon-listing-compare' : 'list-icon stm-boats-icon-compare-boats';
?>

<?php if ( $show_compare ) : ?>
	<?php
	if ( defined( 'ULISTING_VERSION' ) ) {
		$compare_cookie = ( ! empty( $_COOKIE['ulisting_compare'] ) ) ? (array) $_COOKIE['ulisting_compare'] : array();
		$compare_count  = ( ! empty( $compare_cookie ) ) ? count( (array) json_decode( stripslashes( $compare_cookie[0] ) ) ) : 0;
	}

		$compare_page_link = ( $compare_page_id ) ? esc_url( get_the_permalink( $compare_page_id ) ) : '#!';

	?>
	<div class="stm-compare">
		<a class="lOffer-compare" href="<?php echo esc_url( $compare_page_link ); ?>" title="<?php esc_attr_e( 'View compared items', 'motors' ); ?>">
			<?php echo stm_me_get_wpcfto_icon( 'header_compare_icon', $compare_icon ); ?>

			<?php if ( ! defined( 'ULISTING_VERSION' ) ) : ?>
				<span class="list-badge">
					<span class="stm-current-cars-in-compare">
						<?php echo count( stm_get_compared_items() ); ?>
					</span>
				</span>
			<?php else : ?>
				<span class="list-badge">
					<span class="stm-current-cars-in-compare">
						<?php
						if ( $compare_count != 0 ) {
							echo esc_html( $compare_count );
						}
						?>
					</span>
				</span>
			<?php endif; ?>
		</a>
	</div>
<?php endif; ?>
