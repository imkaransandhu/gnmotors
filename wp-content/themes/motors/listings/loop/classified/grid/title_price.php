<div class="car-meta-top heading-font clearfix">
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
    <div class="car-title" data-max-char="<?php echo stm_me_get_wpcfto_mod('grid_title_max_length', 44); ?>">
        <?php
        $show_title_two_params_as_labels = stm_me_get_wpcfto_mod('show_generated_title_as_label', false);
        if($show_title_two_params_as_labels) {
            echo stm_generate_title_from_slugs(get_the_id(),$show_title_two_params_as_labels);
        } else {
            echo esc_attr( stm_generate_title_from_slugs(get_the_id()) );

        }

        ?>
    </div>
</div>