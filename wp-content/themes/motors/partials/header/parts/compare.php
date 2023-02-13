<?php
$show_compare = stm_me_get_wpcfto_mod( 'header_compare_show', false );

if ( $show_compare ) :
	$compare_page_id   = stm_me_get_wpcfto_mod( 'compare_page', false );
	$compare_page_link = ( $compare_page_id ) ? esc_url( get_the_permalink( $compare_page_id ) ) : '#!';
	?>
	<div class="pull-right hdn-767">
		<a class="lOffer-compare" href="<?php echo esc_url( $compare_page_link ); ?>" title="<?php esc_attr_e( 'View compared items', 'motors' ); ?>">
			<?php if ( ! is_listing() ) : ?>
				<span class="heading-font"><?php esc_html_e( 'Compare', 'motors' ); ?></span>
			<?php endif; ?>

			<?php echo stm_me_get_wpcfto_icon( 'header_compare_icon', 'stm-boats-icon-compare-boats', 'list-icon' ); ?>

			<span class="list-badge">
				<span class="stm-current-cars-in-compare">
					<?php echo count( stm_get_compared_items() ); ?>
				</span>
			</span>
		</a>
	</div>
<?php endif; ?>
