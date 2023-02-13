<?php get_header();?>

	<?php get_template_part('partials/title_box'); ?>

	<div class="stm-single-car-page">
        <?php 
            if(stm_is_motorcycle()) {
                get_template_part('partials/single-car-motorcycle/tabs');
            }
        ?>

		<div class="container">
            <?php stm_listings_load_template('filter/inventory/main'); ?>
		</div> <!--cont-->

        <?php
            $recaptcha_enabled = stm_me_get_wpcfto_mod('enable_recaptcha', 0);
            $recaptcha_public_key = stm_me_get_wpcfto_mod('recaptcha_public_key');
            $recaptcha_secret_key = stm_me_get_wpcfto_mod('recaptcha_secret_key');
            if (!empty($recaptcha_enabled) and $recaptcha_enabled and !empty($recaptcha_public_key) and !empty($recaptcha_secret_key)) {
                wp_enqueue_script('stm_grecaptcha');
            }
        ?>

	</div> <!--single car page-->

<?php get_footer();