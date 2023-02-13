<?php
if(stm_is_dealer_two()) {
	$selling_online_global = stm_me_get_wpcfto_mod( 'enable_woo_online', false );
	$sell_online = ( $selling_online_global ) ? !empty( get_post_meta( get_the_ID(), 'car_mark_woo_online', true ) ) : false;
}
?>
<div class="car-meta-top heading-font clearfix">
	<?php if(stm_is_dealer_two() && $sell_online && empty($car_price_form_label)):?>
		<?php
		    if(!empty($sale_price)) $price = $sale_price;
		?>
        <div class="sell-online-wrap price">
            <div class="normal-price">
                <span class="normal_font"><?php echo esc_html__('BUY ONLINE', 'motors'); ?></span>
                <span class="heading-font"><?php echo esc_attr(stm_listing_price_view($price)); ?></span>
            </div>
        </div>
	<?php else : ?>
        <?php if(empty($car_price_form_label)): ?>
            <?php if(!empty($price) and !empty($sale_price) and $price != $sale_price):?>
                <div class="price discounted-price">
                    <div class="regular-price"><?php echo esc_attr(stm_listing_price_view($price)); ?></div>
                    <div class="sale-price"><?php echo esc_attr(stm_listing_price_view($sale_price)); ?></div>
                </div>
            <?php elseif(!empty($price)): ?>
                <div class="price">
                    <div class="normal-price"><?php echo esc_attr(stm_listing_price_view($price)); ?></div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="price">
                <div class="normal-price"><?php echo esc_attr($car_price_form_label); ?></div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="car-title" data-max-char="<?php echo stm_me_get_wpcfto_mod('grid_title_max_length', 44); ?>">
        <?php
        if(!stm_is_listing_three()) {
            echo esc_html(stm_generate_title_from_slugs(get_the_id()));
        } else {
            echo trim(stm_generate_title_from_slugs(get_the_id(), true));
        }
        ?>
    </div>
</div>