<?php
$stock_number     = get_post_meta( get_the_id(), 'stock_number', true );
$car_brochure     = get_post_meta( get_the_ID(), 'car_brochure', true );
$certified_logo_1 = get_post_meta( get_the_ID(), 'certified_logo_1', true );
$certified_logo_2 = get_post_meta( get_the_ID(), 'certified_logo_2', true );

if ( stm_is_car_dealer() ) {
	$certified_logo_1 = '';
	$certified_logo_2 = '';
}

// Show car actions.
$show_print_btn        = stm_me_get_wpcfto_mod( 'show_print_btn', false );
$show_stock            = stm_me_get_wpcfto_mod( 'show_stock', false );
$show_test_drive       = ( ! stm_is_magazine() ) ? stm_me_get_wpcfto_mod( 'show_test_drive', false ) : false;
$show_compare          = stm_me_get_wpcfto_mod( 'show_compare', false );
$show_share            = stm_me_get_wpcfto_mod( 'show_share', false );
$show_pdf              = stm_me_get_wpcfto_mod( 'show_pdf', false );
$show_certified_logo_1 = stm_me_get_wpcfto_mod( 'show_certified_logo_1', false );
$show_certified_logo_2 = stm_me_get_wpcfto_mod( 'show_certified_logo_2', false );
?>
<div class="single-car-actions">
	<ul class="list-unstyled clearfix">
		<?php if ( stm_me_get_wpcfto_mod( 'show_added_date', false ) ) : ?>
			<li>
				<span class="added_date">
				<i class="far fa-clock"></i>
					<?php
					/* translators: added date */
					printf( esc_html__( 'ADDED: %s', 'motors' ), esc_html( get_the_modified_date( 'F d, Y' ) ) );
					?>
				</span>
			</li>
		<?php endif; ?>

		<!--Stock num-->
		<?php if ( ! empty( $stock_number ) && ! empty( $show_stock ) && $show_stock ) : ?>
			<li>
				<div class="stock-num heading-font"><span><?php echo esc_html__( 'stock', 'motors' ); ?>
						# </span><?php echo esc_attr( $stock_number ); ?></div>
			</li>
		<?php endif; ?>

		<!--Schedule-->
		<?php if ( ! empty( $show_test_drive ) && $show_test_drive ) : ?>
			<li>
				<a href="#" class="car-action-unit stm-schedule" data-toggle="modal" data-target="#test-drive">
					<i class="stm-icon-steering_wheel"></i>
					<?php esc_html_e( 'Schedule Test Drive', 'motors' ); ?>
				</a>
			</li>
		<?php endif; ?>

		<!--Compare-->
		<?php if ( ! empty( $show_compare ) && $show_compare ) : ?>
			<li data-compare-id="<?php echo esc_attr( get_the_ID() ); ?>">
				<a href="#" class="car-action-unit add-to-compare stm-added" style="display: none;" data-id="<?php echo esc_attr( get_the_ID() ); ?>" data-action="remove" data-post-type="<?php echo esc_attr( get_post_type( get_the_ID() ) ); ?>">
					<i class="stm-icon-added stm-unhover"></i>
					<span class="stm-unhover"><?php esc_html_e( 'in compare list', 'motors' ); ?></span>
					<div class="stm-show-on-hover">
						<i class="stm-icon-remove"></i>
						<?php esc_html_e( 'Remove from list', 'motors' ); ?>
					</div>
				</a>
				<a href="#" class="car-action-unit add-to-compare" data-id="<?php echo esc_attr( get_the_ID() ); ?>" data-action="add" data-post-type="<?php echo esc_attr( get_post_type( get_the_ID() ) ); ?>">
					<i class="stm-icon-add"></i>
					<?php esc_html_e( 'Add to compare', 'motors' ); ?>
				</a>
			</li>
		<?php endif; ?>

		<!--PDF-->
		<?php if ( ! empty( $show_pdf ) && $show_pdf ) : ?>
			<?php if ( ! empty( $car_brochure ) ) : ?>
				<li>
					<a
						href="<?php echo esc_url( wp_get_attachment_url( $car_brochure ) ); ?>"
						class="car-action-unit stm-brochure"
						title="<?php esc_attr_e( 'Download brochure', 'motors' ); ?>"
						download>
						<i class="stm-icon-brochure"></i>
						<?php ( stm_is_listing_five() ) ? esc_html_e( 'PDF brochure', 'motors' ) : esc_html_e( 'Car brochure', 'motors' ); ?>
					</a>
				</li>
			<?php endif; ?>
		<?php endif; ?>


		<!--Share-->
		<?php if ( ! empty( $show_share ) && $show_share ) : ?>
			<li class="stm-shareble">

				<a
					href="#"
					class="car-action-unit stm-share"
					title="<?php esc_attr_e( 'Share this', 'motors' ); ?>"
					download>
					<i class="stm-icon-share"></i>
					<?php esc_html_e( 'Share this', 'motors' ); ?>
				</a>

				<?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) : ?>
				<div class="stm-a2a-popup">
					<?php echo wp_kses_post( stm_add_to_any_shortcode( get_the_ID() ) ); ?>
				</div>
				<?php endif; ?>
			</li>
		<?php endif; ?>

		<!--Print button-->
		<?php if ( ! empty( $show_print_btn ) && $show_print_btn ) : ?>
			<li>
				<a href="javascript:window.print()" class="car-action-unit stm-car-print">
					<i class="fas fa-print"></i>
					<?php echo esc_html__( 'Print page', 'motors' ); ?>
				</a>
			</li>
		<?php endif; ?>

		<?php if ( ! empty( $certified_logo_1 ) && ! empty( $show_certified_logo_1 ) && $show_certified_logo_1 ) : ?>
			<!--Certified Logo 1-->
			<?php
			$certified_logo_1 = wp_get_attachment_image_src( $certified_logo_1, 'full' );
			$logo_1_link      = get_post_meta( get_the_ID(), 'history_link', true );
			if ( ! empty( $certified_logo_1[0] ) ) {
				$certified_logo_1 = $certified_logo_1[0];
			}
			?>
			<li class="certified-logo-1">
				<?php if ( ! empty( $logo_1_link ) ) : ?>
				<a href="<?php echo esc_url( $logo_1_link ); ?>" target="_blank">
					<?php endif; ?>
					<img src="<?php echo esc_url( $certified_logo_1 ); ?>"
						alt="<?php esc_attr_e( 'Logo 1', 'motors' ); ?>"/>
					<?php if ( ! empty( $logo_1_link ) ) : ?>
				</a>
			<?php endif; ?>
			</li>
		<?php endif; ?>

		<?php if ( ! empty( $certified_logo_2 ) && ! empty( $show_certified_logo_2 ) && $show_certified_logo_2 ) : ?>
			<!--Certified Logo 2-->
			<?php
			$certified_logo_2 = wp_get_attachment_image_src( $certified_logo_2, 'full' );
			if ( ! empty( $certified_logo_2[0] ) ) {
				$certified_logo_2 = $certified_logo_2[0];
			}
			$logo_2_link = get_post_meta( get_the_ID(), 'certified_logo_2_link', true );
			?>
			<li class="certified-logo-2">
				<?php if ( ! empty( $logo_2_link ) ) : ?>
				<a href="<?php echo esc_url( $logo_2_link ); ?>" target="_blank">
					<?php endif; ?>
					<img src="<?php echo esc_url( $certified_logo_2 ); ?>"
						alt="<?php esc_attr_e( 'Logo 2', 'motors' ); ?>"/>
					<?php if ( ! empty( $logo_2_link ) ) : ?>
				</a>
			<?php endif; ?>
			</li>
		<?php endif; ?>

	</ul>
</div>
