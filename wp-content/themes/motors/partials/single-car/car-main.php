<div class="row">

	<div class="col-md-9 col-sm-12 col-xs-12">

		<div class="stm-single-car-content">
			<h1 class="title h2"><?php the_title(); ?></h1>

			<!--Actions-->
			<?php get_template_part( 'partials/single-car/car', 'actions' ); ?>

			<!--Gallery-->
			<?php get_template_part( 'partials/single-car/car', 'gallery' ); ?>

			<!--Car Gurus if is style BANNER-->
			<?php
			if ( strpos( stm_me_get_wpcfto_mod( 'carguru_style', 'STYLE1' ), 'BANNER' ) !== false ) {
				get_template_part( 'partials/single-car/car', 'gurus' );
			}

			the_content();

			/*<!--Calculator-->*/
			get_template_part( 'partials/single-car/car', 'calculator' );
			?>
		</div>
	</div>

	<div class="col-md-3 col-sm-12 col-xs-12">
		<div class="stm-single-car-side">
			<?php
			if ( is_active_sidebar( 'stm_listing_car' ) ) {
				dynamic_sidebar( 'stm_listing_car' );
			} else {
				if ( get_theme_mod( 'show_vin_history_btn', false ) ) {
					do_action( 'stm_single_show_vin_history_btn' );
				}
				/*<!--Prices-->*/
				get_template_part( 'partials/single-car/car', 'price' );

				/*<!--Data-->*/
				get_template_part( 'partials/single-car/car', 'data' );

				/*<!--Rating Review-->*/
				get_template_part( 'partials/single-car/car', 'review_rating' );

				/*<!--MPG-->*/
				get_template_part( 'partials/single-car/car', 'mpg' );
			}
			?>

		</div>
	</div>
</div>
