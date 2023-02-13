<?php $footer_copyright_enabled = stm_me_get_wpcfto_mod( 'footer_copyright', false ); ?>

<?php
	$allowed_html = array(
		'a'    => array(
			'href'  => array(),
			'title' => array(),
		),
		'span' => array(
			'class' => array(),
		),
	);
	?>

<?php
if ( stm_is_listing() ) {
	$footer_bg = '#153e4d';
} else {
	$footer_bg = '#232628';
}

$footer_bg = stm_me_get_wpcfto_mod( 'footer_copyright_color', $footer_bg );
$style     = '';

if ( ! empty( $footer_bg ) ) {
	$style = 'style=background-color:' . $footer_bg;
}

?>

<?php if ( $footer_copyright_enabled ) : ?>
	<?php $footer_copyright_text = stm_dynamic_string_translation( 'Footer Copyright', stm_me_get_wpcfto_mod( 'footer_copyright_text', '&copy; 2020 <a href="http://motors.stylemixthemes.com/landing">Motors - Car Dealer WordPress Theme</a><span class="divider"></span>Trademarks and brands are the property of their respective owners.' ) ); ?>
	<?php if ( stm_is_boats() ) : ?>
		<div id="footer-copyright" <?php echo esc_attr( $style ); ?>>

			<?php
			if ( stm_is_listing() ) {
				get_template_part( 'partials/listing-layout-parts/footer-copyright', 'top' );
			}
			?>

			<div class="container footer-copyright">
				<div class="row">
					<div class="col-md-12">
						<div class="clearfix">
							<?php if ( $footer_copyright_text ) : ?>
								<div class="copyright-text heading-font text-center"><?php echo html_entity_decode( $footer_copyright_text ); ?></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php else : ?>
		<div id="footer-copyright" <?php echo esc_attr( $style ); ?>>

			<?php
			if ( stm_is_listing() ) {
				get_template_part( 'partials/listing-layout-parts/footer-copyright', 'top' );
			}
			?>

			<div class="container footer-copyright">
				<div class="row">
					<?php if ( ! stm_is_auto_parts() && ! stm_is_ev_dealer() ) : ?>
					<div class="col-md-8 col-sm-8">
						<div class="clearfix">
							<?php if ( $footer_copyright_text ) : ?>
								<div class="copyright-text heading-font"><?php echo html_entity_decode( $footer_copyright_text ); ?></div>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="clearfix">
							<div class="pull-right xs-pull-left">
								<?php $socials = stm_get_header_socials( 'footer_socials_enable' ); ?>
								<!-- Header top bar Socials -->
								<?php if ( ! empty( $socials ) ) : ?>
									<div class="pull-right">
										<div class="copyright-socials">
											<ul class="clearfix">
												<?php foreach ( $socials as $key => $val ) : ?>
													<li>
														<a href="<?php echo esc_url( $val ); ?>" target="_blank">
															<i class="fab fa-<?php echo esc_attr( $key ); ?>"></i>
														</a>
													</li>
												<?php endforeach; ?>
											</ul>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php else : ?>
						<div class="col-md-12 col-sm-12">
							<div class="clearfix">
								<?php if ( $footer_copyright_text ) : ?>
									<div class="copyright-text heading-font"><?php echo html_entity_decode( $footer_copyright_text ); ?></div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
