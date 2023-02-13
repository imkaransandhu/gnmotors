<?php
$shopping_cart_boats     = stm_me_get_wpcfto_mod( 'header_cart_show', false );
$compare_page            = stm_me_get_wpcfto_mod( 'compare_page', 156 );
$show_compare_page       = stm_me_get_wpcfto_mod( 'header_compare_show', false );
$header_listing_btn_link = stm_me_get_wpcfto_mod( 'header_listing_btn_link', '/add-a-car' );
$header_listing_btn_text = stm_me_get_wpcfto_mod( 'header_listing_btn_text', esc_html__( 'Add your item', 'motors' ) );
$header_profile          = stm_me_get_wpcfto_mod( 'header_show_profile', false );
$compared_items_count    = stm_get_compared_items();

if ( function_exists( 'WC' ) ) {
	$woocommerce_shop_page_id = wc_get_cart_url();
}

?>
<?php if ( stm_me_get_wpcfto_mod( 'header_show_add_car_button', false ) && is_listing() && ! empty( $header_listing_btn_link ) && ! empty( $header_listing_btn_text ) ) : ?>
	<li class="menu-item menu-item-type-post_type menu-item-object-page">
		<a href="<?php echo esc_url( $header_listing_btn_link ); ?>">
			<span>
				<?php stm_dynamic_string_translation_e( 'Listing Button Text', $header_listing_btn_text ); ?>
			</span>
		</a>
	</li>
<?php endif; ?>
<?php if ( is_listing() && $header_profile ) : ?>
	<li class="menu-item menu-item-type-post_type menu-item-object-page">
		<a href="<?php echo esc_url( stm_get_author_link( 'myself-view' ) ); ?>">
			<span>
				<?php esc_html_e( 'Profile', 'motors' ); ?>
			</span>
		</a>
	</li>
<?php endif; ?>
<?php if ( $shopping_cart_boats && ! empty( $woocommerce_shop_page_id ) ) : ?>
	<li class="menu-item menu-item-type-post_type menu-item-object-page">
		<?php $items = WC()->cart->cart_contents_count; ?>
		<!--Shop archive-->
		<a href="<?php echo esc_url( $woocommerce_shop_page_id ); ?>" title="<?php esc_attr_e( 'Watch shop items', 'motors' ); ?>" >
			<span><?php esc_html_e( 'Cart', 'motors' ); ?></span>
			<?php
			if ( $items > 0 ) :
				?>
				<span class="list-badge">
					<span class="stm-current-items-in-cart">
						<?php echo esc_html( $items ); ?>
					</span>
				</span>
				<?php
			endif;
			?>
		</a>
	</li>
<?php endif; ?>

<?php if ( ! empty( $compare_page ) && $show_compare_page ) : ?>
	<li class="menu-item menu-item-type-post_type menu-item-object-page">
		<a href="<?php echo esc_url( get_the_permalink( $compare_page ) ); ?>" title="<?php esc_attr_e( 'View compared items', 'motors' ); ?>">
			<span><?php esc_html_e( 'Compare', 'motors' ); ?></span>
			<span class="list-badge">
				<span class="stm-current-cars-in-compare">
					<?php echo esc_attr( $compared_items_count ); ?>
				</span>
			</span>
		</a>
	</li>
<?php endif; ?>

<?php
echo apply_filters( 'stm_vin_decoder_mobile_menu', '' );
