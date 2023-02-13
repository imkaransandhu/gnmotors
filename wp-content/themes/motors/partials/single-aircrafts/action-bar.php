<?php
$post_id = get_the_ID();

$badge_text = get_post_meta( $post_id, 'badge_text', true );
$badge_bg_color = get_post_meta( $post_id, 'badge_bg_color', true );
$show_pdf = stm_me_get_wpcfto_mod('show_pdf', false);
$show_print = stm_me_get_wpcfto_mod( 'show_print_btn', false );
$show_compare = stm_me_get_wpcfto_mod( 'show_compare', false );
$show_share = stm_me_get_wpcfto_mod( 'show_share', false );
$show_featured_btn = stm_me_get_wpcfto_mod( 'show_featured_btn', false );

$asSold = get_post_meta(get_the_ID(), 'car_mark_as_sold', true);
$sold_badge_color = stm_me_get_wpcfto_mod('sold_badge_bg_color');

// remove "special" if the listing is sold
if(!empty($asSold)) {
    delete_post_meta(get_the_ID(), 'special_car');
}

$special_car = get_post_meta( $post_id, 'special_car', true );

if ( empty( $badge_text ) ) {
	$badge_text = esc_html__('Special', 'motors');
}

$badge_style = '';
if ( !empty( $badge_bg_color ) ) {
    $badge_style = 'style=background-color:' . $badge_bg_color . ';';
}
?>
<div class="actions-wrap">
    <!--Actions-->
    <div class="stm-gallery-actions">
        <ul>
        <!--Print button-->
        <?php if (!empty($show_print) and $show_print): ?>
            <li>
                <a href="javascript:window.print()" class="car-action-unit stm-car-print">
                    <i class="fas fa-print"></i>
                    <?php echo esc_html__('Print page', 'motors'); ?>
                </a>
            </li>
        <?php endif; ?>
        <?php if ( !empty( $show_featured_btn ) ): ?>
            <li class="stm-gallery-action-unit stm-listing-favorite-action car-action-unit"
                 data-id="<?php echo esc_attr( get_the_id() ); ?>">
                <i class="stm-service-icon-staricon"></i>
                <?php echo esc_html__('Featured', 'motors'); ?>
            </li>
        <?php endif; ?>
        <?php if (!empty($show_compare) and $show_compare): ?>
            <li data-compare-id="<?php echo esc_attr(get_the_ID()); ?>">
                <a href="#" class="car-action-unit add-to-compare stm-added" style="display: none;" data-id="<?php echo esc_attr(get_the_ID()); ?>" data-action="remove" data-post-type="<?php echo get_post_type( get_the_ID() ); ?>">
                    <i class="stm-icon-added stm-unhover"></i>
                    <span class="stm-unhover"><?php esc_html_e('in compare list', 'motors'); ?></span>
                    <div class="stm-show-on-hover">
                        <i class="stm-icon-remove"></i>
                        <?php esc_html_e('Remove from list', 'motors'); ?>
                    </div>
                </a>
                <a href="#" class="car-action-unit add-to-compare" data-id="<?php echo esc_attr(get_the_ID()); ?>" data-action="add" data-post-type="<?php echo get_post_type(get_the_ID()); ?>">
                    <i class="stm-icon-add"></i>
                    <?php esc_html_e('Add to compare', 'motors'); ?>
                </a>
            </li>
        <?php endif; ?>
        <!--Share-->
        <?php if (!empty($show_share) and $show_share): ?>
            <li class="stm-shareble">

                <a href="#"
                        class="car-action-unit stm-share"
                        title="<?php esc_attr_e('Share this', 'motors'); ?>"
                        download>
                    <i class="stm-icon-share"></i>
                    <?php esc_html_e('Share this', 'motors'); ?>
                </a>

                <?php if( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ): ?>
                    <div class="stm-a2a-popup">
                        <?php echo stm_add_to_any_shortcode(get_the_ID()); ?>
                    </div>
                <?php endif; ?>
            </li>
        <?php endif; ?>
        <!--PDF-->
        <?php if (!empty($show_pdf) and $show_pdf): ?>
            <?php if (!empty($car_brochure)): ?>
                <li>
                    <a
                            href="<?php echo esc_url(wp_get_attachment_url($car_brochure)); ?>"
                            class="car-action-unit stm-brochure"
                            title="<?php esc_attr_e('Download brochure', 'motors'); ?>"
                            download>
                        <i class="stm-icon-brochure"></i>
                        <?php ( stm_is_listing_five() ) ? esc_html_e('PDF brochure', 'motors') : esc_html_e('Car brochure', 'motors'); ?>
                    </a>
                </li>
            <?php endif; ?>
        <?php endif; ?>
        </ul>
    </div>
    <?php if ( empty($asSold) && !empty( $special_car ) and $special_car == 'on' ): ?>

        <div class="special-wrap">
            <div class="special-label h5" <?php echo esc_attr( $badge_style ); ?>>
                <?php stm_dynamic_string_translation_e( 'Special Badge Text', $badge_text ); ?>
            </div>
        </div>

    <?php elseif(stm_sold_status_enabled() && !empty($asSold)): ?>
        <?php $badge_style = 'style=background-color:' . $sold_badge_color . ';'; ?>
        <div class="special-wrap">
            <div class="special-label h5" <?php echo esc_attr( $badge_style ); ?>>
                <?php _e('Sold', 'motors'); ?>
            </div>
        </div>

    <?php endif; ?>
</div>