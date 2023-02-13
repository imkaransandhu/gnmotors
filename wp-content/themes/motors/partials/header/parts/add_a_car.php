<?php
$header_listing_btn_link = ( stm_is_listing_five() && function_exists( 'stm_c_f_get_page_url' ) ) ? stm_c_f_get_page_url( 'add_listing' ) : stm_me_get_wpcfto_mod( 'header_listing_btn_link', '/add-a-car' );
$header_listing_btn_link = ( stm_is_listing_six() && function_exists( 'stm_c_six_get_page_url' ) ) ? stm_c_six_get_page_url( 'add_listing' ) : stm_me_get_wpcfto_mod( 'header_listing_btn_link', '/add-a-car' );
$header_listing_btn_text = stm_me_get_wpcfto_mod( 'header_listing_btn_text', esc_html__( 'Add your item', 'motors' ) );
?>
<?php if ( stm_me_get_wpcfto_mod('header_show_add_car_button', false) && is_listing() && !empty( $header_listing_btn_link ) and !empty( $header_listing_btn_text ) ): ?>
    <div class="pull-right">
        <a href="<?php echo esc_url( $header_listing_btn_link ); ?>" class="listing_add_cart heading-font">
            <div>
                <span class="list-label heading-font">
                    <?php stm_dynamic_string_translation_e( 'Listing Button Text', $header_listing_btn_text ); ?>
                </span>
				<?php echo stm_me_get_wpcfto_icon('header_listing_btn_icon', 'stm-service-icon-listing_car_plus'); ?>
            </div>
        </a>
    </div>
<?php endif; ?>