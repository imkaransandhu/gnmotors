<?php
if ( function_exists( 'motors_include_once_scripts_styles' ) ) {
	motors_include_once_scripts_styles( array( 'stmdatetimepicker', 'app-datetime' ) );
}
?>
<div class="modal" id="test-drive" tabindex="-1" role="dialog" aria-labelledby="myModalLabelTestDrive">
	<form id="request-test-drive-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-header-iconed">
					<i class="stm-icon-steering_wheel"></i>
					<h3 class="modal-title" id="myModalLabelTestDrive">
						<?php esc_html_e( 'Schedule a Test Drive', 'motors' ); ?>
					</h3>
					<div class="test-drive-car-name">
						<?php echo wp_kses_post( stm_generate_title_from_slugs( get_queried_object_id() ) ); ?>
					</div>
					<div class="mobile-close-modal" data-dismiss="modal" aria-label="Close">
						<i class="fas fa-times" aria-hidden="true"></i>
					</div>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="form-modal-label"><?php esc_html_e( 'Name', 'motors' ); ?></div>
								<input name="name" type="text"/>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="form-modal-label"><?php esc_html_e( 'Email', 'motors' ); ?></div>
								<input name="email" type="email" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="form-modal-label"><?php esc_html_e( 'Phone', 'motors' ); ?></div>
								<input name="phone" type="tel" />
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="form-modal-label"><?php esc_html_e( 'Best time', 'motors' ); ?></div>
								<div class="stm-datepicker-input-icon">
									<input name="date" class="stm-date-timepicker" type="text" />
								</div>
							</div>
						</div>
					</div>
					<div class="mg-bt-25px"></div>
					<div class="row">
						<div class="col-md-7 col-sm-7">
							<?php
							if ( class_exists( '\\STM_GDPR\\STM_GDPR' ) ) {
								echo do_shortcode( '[motors_gdpr_checkbox]' );
							}
							?>
						</div>
						<div class="col-md-5 col-sm-5">
							<?php
							$recaptcha_enabled    = stm_me_get_wpcfto_mod( 'enable_recaptcha', 0 );
							$recaptcha_public_key = stm_me_get_wpcfto_mod( 'recaptcha_public_key' );
							$recaptcha_secret_key = stm_me_get_wpcfto_mod( 'recaptcha_secret_key' );

							if ( ! empty( $recaptcha_enabled ) && $recaptcha_enabled && ! empty( $recaptcha_public_key ) && ! empty( $recaptcha_secret_key ) ) :
								?>
								<script>
									function onSubmitTestDrive(token) {
										var form = $("#request-test-drive-form");

										$.ajax({
											url: ajaxurl,
											type: "POST",
											dataType: 'json',
											context: this,
											data: form.serialize() + '&action=stm_ajax_add_test_drive&security=' + stm_security_nonce,
											beforeSend: function () {
												$('.alert-modal').remove();
												form.find('input').removeClass('form-error');
												form.find('.stm-ajax-loader').addClass('loading');
											},
											success: function (data) {
												form.find('.stm-ajax-loader').removeClass('loading');
												form.find('.modal-body').append('<div class="alert-modal alert alert-' + data.status + ' text-left">' + data.response + '</div>')
												for (var key in data.errors) {
													$('#request-test-drive-form input[name="' + key + '"]').addClass('form-error');
												}
											}
										});
										form.find('.form-error').on('hover', function () {
											$(this).removeClass('form-error');
										});
									}
								</script>
								<button class="g-recaptcha" data-sitekey="<?php echo esc_attr( $recaptcha_public_key ); ?>" data-callback='onSubmitTestDrive' type="submit" class="stm-request-test-drive"><?php esc_html_e( 'Request', 'motors' ); ?></button>
							<?php else : ?>
								<button type="submit" class="stm-request-test-drive"><?php esc_html_e( 'Request', 'motors' ); ?></button>
							<?php endif; ?>
							<div class="stm-ajax-loader" style="margin-top:10px;">
								<i class="stm-icon-load1"></i>
							</div>
						</div>
					</div>
					<div class="mg-bt-25px"></div>
					<input name="vehicle_id" type="hidden" value="<?php echo esc_attr( get_queried_object_id() ); ?>" />
					<input name="vehicle_name" type="hidden" value="<?php echo esc_attr( get_the_title( get_queried_object_id() ) ); ?>" />
				</div>
			</div>
		</div>
	</form>
</div>
