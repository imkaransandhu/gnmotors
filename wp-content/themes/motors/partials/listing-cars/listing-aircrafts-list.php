<?php

if(empty($modern_filter)){
    $modern_filter = false;
}

$hide_labels = stm_me_get_wpcfto_mod('hide_price_labels', false);

stm_listings_load_template('loop/start', array('modern' => $modern_filter)); ?>
    <?php stm_listings_load_template('loop/classified/list/image'); ?>

    <div class="content">

        <!--Title-->
        <?php stm_listings_load_template('loop/classified/list/title_price', array('hide_labels' => $hide_labels)); ?>

        <!--Item parameters-->
        <div class="meta-middle">
            <?php stm_listings_load_template('loop/default/list/options'); ?>
        </div>
        
        <!--Item options-->
        <div class="meta-bottom">
            <?php stm_listings_load_template('loop/default/list/features'); ?>
        </div>
    </div>
</div>