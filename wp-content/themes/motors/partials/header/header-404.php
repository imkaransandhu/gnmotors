<?php
$logo_url = stm_me_get_wpcfto_img_src( 'logo', get_template_directory_uri() );
?>
<div class="error-header">
	<div class="text-center">
		<div class="dp-in">
			<?php if ( ! empty( $logo_url ) && stm_img_exists_by_url( $logo_url ) ) : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Home', 'motors' ); ?>">
					<img src="<?php echo esc_url( $logo_url ); ?>" style="width: <?php echo stm_me_get_wpcfto_mod( 'logo_width', '138' ); ?>px;" alt="<?php esc_attr_e( 'Logo', 'motors' ); ?>"/>
				</a>
			<?php else : ?>
				<a class="error-header__title" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Home', 'motors' ); ?>">
					<div><?php echo esc_attr( get_bloginfo( 'name' ) ); ?></div>
				</a>
			<?php endif; ?>
		</div>
	</div>
</div>
