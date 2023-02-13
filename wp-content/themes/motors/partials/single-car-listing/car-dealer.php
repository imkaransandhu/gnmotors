<?php
wp_enqueue_style( 'stm_car_dealer_info', get_theme_file_uri( '/assets/css/dist/stm_car_dealer_info.css' ), null, STM_THEME_VERSION, 'all' );

$user_added_by = get_post_meta( get_the_ID(), 'stm_car_user', true );
$show_number   = stm_me_get_wpcfto_mod( 'stm_show_number', false );

if ( ! empty( $user_added_by ) ) :

	$user_data = get_userdata( $user_added_by );

	if ( $user_data ) :

		$user_fields = stm_get_user_custom_fields( $user_added_by );
		$is_dealer   = stm_get_user_role( $user_added_by );

		if ( $is_dealer ) :
			$ratings = stm_get_dealer_marks( $user_added_by );
			?>

			<div class="stm-listing-car-dealer-info">
				<a class="stm-no-text-decoration" href="<?php echo ( is_listing() || stm_is_aircrafts() ) ? esc_url( stm_get_author_link( $user_added_by ) ) : '#!'; ?>">
					<h3 class="title">
						<?php stm_display_user_name( $user_added_by ); ?>
					</h3>
				</a>
				<div class="clearfix">
					<div class="dealer-image">
						<div class="stm-dealer-image-custom-view">
							<a href="<?php echo ( is_listing() || stm_is_aircrafts() ) ? esc_url( stm_get_author_link( $user_added_by ) ) : '#!'; ?>">
								<?php if ( ! empty( $user_fields['logo'] ) ) : ?>
									<img src="<?php echo esc_url( $user_fields['logo'] ); ?>" />
								<?php else : ?>
									<img src="<?php stm_get_dealer_logo_placeholder(); ?>" />
								<?php endif; ?>
							</a>
						</div>
					</div>
					<?php if ( ! empty( $ratings['average'] ) ) : ?>
						<div class="dealer-rating">
							<div class="stm-rate-unit">
								<div class="stm-rate-inner">
									<div class="stm-rate-not-filled"></div>
									<div class="stm-rate-filled" style="width:<?php echo esc_attr( $ratings['average_width'] ); ?>"></div>
								</div>
							</div>
							<div class="stm-rate-sum">(<?php esc_html_e( 'Reviews', 'motors' ); ?> <?php echo esc_attr( $ratings['count'] ); ?>)</div>
						</div>
					<?php endif; ?>
				</div>

				<div class="dealer-contacts">
					<?php if ( ! empty( $user_fields['phone'] ) ) : ?>
						<div class="dealer-contact-unit phone">
							<i class="stm-service-icon-phone_2"></i>
							<?php if ( $show_number ) : ?>
								<div class="phone heading-font">
									<?php echo esc_html( $user_fields['phone'] ); ?>
								</div>
							<?php else : ?>
								<div class="phone heading-font">
									<?php echo esc_html( substr_replace( $user_fields['phone'], '*******', 3, strlen( $user_fields['phone'] ) ) ); ?>
								</div>
								<span class="stm-show-number" data-listing-id="<?php echo intval( get_the_ID() ); ?>" data-id="<?php echo esc_attr( $user_fields['user_id'] ); ?>">
									<?php echo esc_html__( 'Show number', 'motors' ); ?>
								</span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $args['show_whatsapp'] ) && ! empty( $user_fields['phone'] ) && ! empty( $user_fields['stm_whatsapp_number'] ) ) : ?>
						<div class="dealer-contact-unit whatsapp">
							<a href="https://wa.me/<?php echo esc_attr( trim( preg_replace( '/[^0-9]/', '', $user_fields['phone'] ) ) ); ?>" target="_blank">
								<div class="whatsapp-btn">
									<i class="stm-icon-whatsapp"></i>
									<span>
										<?php echo esc_html__( 'Chat via WhatsApp', 'motors' ); ?>
									</span>
								</div>
							</a>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $args['show_email'] ) && ! empty( $user_fields['email'] ) && ! empty( $user_fields['show_mail'] ) ) : ?>
						<div class="dealer-contact-unit mail">
							<a href="mailto:<?php echo esc_attr( $user_fields['email'] ); ?>">
								<div class="email-btn">
									<i class="fas fa-envelope"></i>
									<span>
										<?php echo esc_html__( 'Message to dealer', 'motors' ); ?>
									</span>
								</div>
							</a>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $user_fields['location'] ) ) : ?>
						<div class="dealer-contact-unit address">
							<i class="stm-service-icon-pin_2"></i>
							<div class="address"><?php echo esc_attr( $user_fields['location'] ); ?></div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php else : ?>
			<div class="stm-listing-car-dealer-info stm-common-user">

				<div class="clearfix stm-user-main-info-c">
					<div class="image">
						<a href="<?php echo ( is_listing() || stm_is_aircrafts() ) ? esc_url( stm_get_author_link( $user_added_by ) ) : '#!'; ?>">
							<?php if ( ! empty( $user_fields['image'] ) ) : ?>
								<img src="<?php echo esc_url( $user_fields['image'] ); ?>" />
							<?php else : ?>
								<div class="no-avatar">
									<i class="stm-service-icon-user"></i>
								</div>
							<?php endif; ?>
						</a>
					</div>
					<a class="stm-no-text-decoration" href="<?php echo ( is_listing() || stm_is_aircrafts() ) ? esc_url( stm_get_author_link( $user_added_by ) ) : '#!'; ?>">
						<h3 class="title"><?php stm_display_user_name( $user_added_by ); ?></h3>
						<div class="stm-label"><?php esc_html_e( 'Private Seller', 'motors' ); ?></div>
					</a>
				</div>

				<div class="dealer-contacts">
					<?php if ( ! empty( $user_fields['phone'] ) ) : ?>
						<div class="dealer-contact-unit phone">
							<i class="stm-service-icon-phone_2"></i>
							<?php if ( $show_number ) : ?>
								<div class="phone heading-font"><?php echo esc_html( $user_fields['phone'] ); ?></div>
							<?php else : ?>
								<div class="phone heading-font">
									<?php echo esc_html( substr_replace( $user_fields['phone'], '*******', 3, strlen( $user_fields['phone'] ) ) ); ?>
								</div>
								<span class="stm-show-number" data-listing-id="<?php echo intval( get_the_ID() ); ?>" data-id="<?php echo esc_attr( $user_fields['user_id'] ); ?>"><?php echo esc_html__( 'Show number', 'motors' ); ?></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $args['show_whatsapp'] ) && ! empty( $user_fields['phone'] ) && ! empty( $user_fields['stm_whatsapp_number'] ) ) : ?>
						<div class="dealer-contact-unit whatsapp">
							<a href="https://wa.me/<?php echo esc_attr( trim( preg_replace( '/[^0-9]/', '', $user_fields['phone'] ) ) ); ?>" target="_blank">
								<div class="whatsapp-btn heading-font">
									<i class="stm-icon-whatsapp"></i>
									<span>
										<?php echo esc_html__( 'Chat via WhatsApp', 'motors' ); ?>
									</span>
								</div>
							</a>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $args['show_email'] ) && ! empty( $user_fields['email'] ) && ! empty( $user_fields['show_mail'] ) ) : ?>
						<div class="dealer-contact-unit mail">
							<a href="mailto:<?php echo esc_attr( $user_fields['email'] ); ?>">
								<div class="email-btn heading-font">
									<i class="fas fa-envelope"></i>
									<span>
										<?php echo esc_html__( 'Message to dealer', 'motors' ); ?>
									</span>
								</div>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php
		endif;
	endif;
endif;
