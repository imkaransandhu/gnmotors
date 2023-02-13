<div class="title heading-font">
	<a href="<?php the_permalink() ?>" class="rmv_txt_drctn">
		<?php
            echo stm_generate_title_from_slugs(get_the_id(), stm_me_get_wpcfto_mod('show_generated_title_as_label', false));
        ?>
	</a>
</div>