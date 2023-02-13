<?php

$theme_info = wp_get_theme();
define( 'STM_THEME_VERSION', ( WP_DEBUG ) ? time() : $theme_info->get( 'Version' ) );

if ( ! is_admin() ) {
	// Motors icons for all layouts.
	add_action( 'wp_enqueue_scripts', 'stm_load_all_icons' );

	// scripts and styles.
	if ( defined( 'ULISTING_VERSION' ) ) {
		add_action( 'wp_enqueue_scripts', 'stm_load_ulisting_theme_ss' );
	} else {
		add_action( 'wp_enqueue_scripts', 'stm_load_theme_ss' );
	}
}

function stm_load_all_icons() {
	wp_enqueue_style( 'stm-theme-default-icons', get_theme_file_uri( '/assets/css/iconset-default.css' ), null, STM_THEME_VERSION, 'all' );
	wp_enqueue_style( 'stm-theme-service-icons', get_theme_file_uri( '/assets/css/iconset-service.css' ), null, STM_THEME_VERSION, 'all' );
	wp_enqueue_style( 'stm-theme-boat-icons', get_theme_file_uri( '/assets/css/iconset-boats.css' ), null, STM_THEME_VERSION, 'all' );
	wp_enqueue_style( 'stm-theme-moto-icons', get_theme_file_uri( '/assets/css/iconset-motorcycles.css' ), null, STM_THEME_VERSION, 'all' );
	wp_enqueue_style( 'stm-theme-rental-icons', get_theme_file_uri( '/assets/css/iconset-rental.css' ), null, STM_THEME_VERSION, 'all' );
	wp_enqueue_style( 'stm-theme-magazine-icons', get_theme_file_uri( '/assets/css/iconset-magazine.css' ), null, STM_THEME_VERSION, 'all' );
	wp_enqueue_style( 'stm-theme-listing-two-icons', get_theme_file_uri( '/assets/css/iconset-listing-two.css' ), null, STM_THEME_VERSION, 'all' );
	wp_enqueue_style( 'stm-theme-auto-parts-icons', get_theme_file_uri( '/assets/css/iconset-auto-parts.css' ), null, STM_THEME_VERSION, 'all' );
	wp_enqueue_style( 'stm-theme-aircrafts-icons', get_theme_file_uri( '/assets/css/iconset-aircrafts.css' ), null, STM_THEME_VERSION, 'all' );
}

function stm_load_theme_ss() {
	$template_directory_uri = get_template_directory_uri();
	$jquery                 = array( 'jquery' );

	wp_enqueue_script( 'jquery', false, array(), STM_THEME_VERSION, false );

	if ( ! wp_script_is( 'jquery-migrate', 'enqueued' ) ) {
		wp_enqueue_script( 'stm-jquerymigrate', get_theme_file_uri( '/assets/js/jquery-migrate-3.3.2.min.js' ), $jquery, STM_THEME_VERSION, true );
	}

	// header styles.
	$file_name = 'header-' . stm_get_header_layout();
	stm_motors_enqueue_header_scripts_styles( $file_name );
	$site_color_style = stm_me_get_wpcfto_mod( 'site_style' );
	if ( 'site_style_default' !== $site_color_style ) {
		wp_dequeue_style( $file_name );
		wp_deregister_style( $file_name );
	}

	// Styles
	// Fonts.
	$typography_body_font_family    = stm_me_get_wpcfto_mod( 'typography_body_font_family' );
	$typography_heading_font_family = stm_me_get_wpcfto_mod( 'typography_heading_font_family' );

	$layout          = stm_get_current_layout();
	$upload_dir      = wp_upload_dir();
	$stm_upload_dir  = $upload_dir['baseurl'] . '/stm_uploads';
	$stm_upload_path = $upload_dir['basedir'] . '/stm_uploads';

	// Main font if user hasn't chosen anything.
	if ( ! empty( stm_me_get_wpcfto_mod( 'typography_body_font_family' ) ) || ! empty( stm_me_get_wpcfto_mod( 'typography_heading_font_family' ) ) ) {
		wp_enqueue_style( 'stm_default_google_font', stm_default_google_fonts_enqueue(), null, STM_THEME_VERSION, 'all' );
	}

	wp_register_style( 'bootstrap', get_theme_file_uri( '/assets/css/bootstrap/main.css' ), null, STM_THEME_VERSION, 'all' );
	wp_register_script( 'bootstrap', get_theme_file_uri( '/assets/js/dist/bootstrap.js' ), $jquery, STM_THEME_VERSION, true );

	//DateTime Picker
	wp_register_style( 'stmdatetimepicker', get_theme_file_uri( '/assets/css/stmdatetimepicker.css' ), null, STM_THEME_VERSION, 'all' );
	wp_register_script( 'stmdatetimepicker', get_theme_file_uri( '/assets/js/stmdatetimepicker.js' ), $jquery, STM_THEME_VERSION, true );
	wp_register_script( 'app-datetime', get_theme_file_uri( '/assets/js/parts/datetime.js' ), 'stmdatetimepicker', STM_THEME_VERSION, true );

	//select2
	wp_register_style( 'stmselect2', get_theme_file_uri( '/assets/css/select2.min.css' ), null, STM_THEME_VERSION, 'all' );
	wp_register_script( 'stmselect2', get_theme_file_uri( '/assets/js/select2.full.min.js' ), $jquery, STM_THEME_VERSION, true );
	wp_register_script( 'app-select2', get_theme_file_uri( '/assets/js/parts/select2.js' ), 'stmselect2', STM_THEME_VERSION, true );

	//LoadImage
	wp_register_script( 'load-image', get_theme_file_uri( '/assets/js/load-image.all.min.js' ), array(), STM_THEME_VERSION, true );

	//Add a car
	wp_register_script( 'stm-theme-sell-a-car', get_theme_file_uri( '/assets/js/sell-a-car.js' ), array( 'jquery', 'load-image' ), STM_THEME_VERSION, true );

	//CascadingDropdown
	wp_register_script( 'stm-cascadingdropdown', get_theme_file_uri( '/assets/js/jquery.cascadingdropdown.js' ), $jquery, STM_THEME_VERSION, true );

	//IsoTope
	wp_register_script( 'isotope', get_theme_file_uri( '/assets/js/isotope.pkgd.min.js' ), array( 'jquery', 'imagesloaded' ), STM_THEME_VERSION, true );

	//uniform
	wp_register_script( 'uniform', get_theme_file_uri( '/assets/js/jquery.uniform.min.js' ), $jquery, STM_THEME_VERSION, true );
	wp_register_script( 'uniform-init', get_theme_file_uri( '/assets/js/parts/uniform.js' ), array( 'uniform' ), STM_THEME_VERSION, true );

	//LightGallery
	wp_enqueue_style( 'light-gallery', get_theme_file_uri( '/assets/css/lightgallery.min.css' ), array(), STM_THEME_VERSION, 'all' );
	wp_enqueue_script( 'light-gallery', get_theme_file_uri( '/assets/js/lightgallery-all.js' ), array( 'jquery' ), STM_THEME_VERSION, true );
	wp_enqueue_script( 'lg-video', get_theme_file_uri( '/assets/js/lg-video.js' ), array( 'jquery' ), STM_THEME_VERSION, true );

	//TypeAHead
	wp_enqueue_script( 'typeahead', get_theme_file_uri( '/assets/js/typeahead.jquery.min.js' ), $jquery, STM_THEME_VERSION, true );

	//UserSidebar
	wp_register_script( 'stm-theme-user-sidebar', get_theme_file_uri( '/assets/js/app-user-sidebar.js' ), $jquery, STM_THEME_VERSION, true );

	//CountDown
	wp_register_script( 'jquery.countdown.js', get_theme_file_uri( '/assets/js/jquery.countdown.min.js' ), $jquery, STM_THEME_VERSION, true );

	//chartJS
	if ( ( stm_is_listing() || stm_is_listing_two() || stm_is_listing_three() || stm_is_listing_four() || stm_is_listing_five() ) && is_author() ) {
		wp_register_script( 'chartjs', get_theme_file_uri( '/assets/js/chart.min.js' ), array(), STM_THEME_VERSION, true );
	}

	wp_enqueue_style( 'stm-jquery-ui-css', get_theme_file_uri( '/assets/css/jquery-ui.css' ), null, STM_THEME_VERSION, 'all' );

	if ( is_post_type_archive( stm_listings_multi_type( true ) ) || ( stm_me_get_wpcfto_mod( 'top_bar_currency_enable', false ) && ! empty( stm_me_get_wpcfto_mod( 'currency_list', '' ) ) ) || stm_me_get_wpcfto_mod( 'top_bar_wpml_switcher', false ) ) {
		wp_enqueue_style( 'stmselect2' );
		wp_enqueue_script( 'stmselect2' );
		wp_enqueue_script( 'app-select2' );
	}

	if ( is_post_type_archive( stm_listings_multi_type( true ) ) || is_singular( array( 'listings', 'stm_events' ) ) ) {
		wp_enqueue_script( 'uniform' );
		wp_enqueue_script( 'uniform-init' );
	}

	$gallery_hover_interaction = stm_me_get_wpcfto_mod( 'gallery_hover_interaction', false );

	if ( true === $gallery_hover_interaction ) {
		wp_enqueue_style( 'brazzers-carousel', get_theme_file_uri( '/assets/css/brazzers-carousel.min.css' ), array(), STM_THEME_VERSION, 'all' );
		wp_enqueue_script( 'brazzers-carousel', get_theme_file_uri( '/assets/js/brazzers-carousel.min.js' ), array( 'jquery' ), STM_THEME_VERSION, true );
	}

	if ( stm_motors_is_unit_test_mod() && file_exists( get_template_directory() . '/assets/css/unit-test-styles.css' ) ) {
		wp_enqueue_style( 'stm-unit-test-styles', $template_directory_uri . '/assets/css/unit-test-styles.css', null, STM_THEME_VERSION, 'all' );
	}

	// Electric Vehicle Dealership.
	if ( stm_is_ev_dealer() ) {
		wp_enqueue_style( 'swiper-slider', get_theme_file_uri( '/assets/css/swiper-bundle.min.css' ), null, STM_THEME_VERSION, 'all' );
		wp_enqueue_script( 'swiper-slider', get_theme_file_uri( '/assets/js/swiper-bundle.min.js' ), array(), STM_THEME_VERSION, true );
	}

	if ( 'site_style_default' !== stm_me_get_wpcfto_mod( 'site_style', 'site_style_default' ) && is_dir( $upload_dir['basedir'] . '/stm_uploads' ) ) {
		wp_enqueue_style( 'stm-skin-custom', $stm_upload_dir . '/skin-custom.css', array( 'bootstrap' ), get_option( 'stm_custom_style', '4' ), 'all' );
	} else {
		if ( file_exists( get_theme_file_path( '/assets/css/dist/app-' . $layout . '.css' ) ) ) {
			wp_enqueue_style( 'stm-theme-style-css', get_theme_file_uri( '/assets/css/dist/app.css' ), array( 'bootstrap' ), STM_THEME_VERSION, 'all' );
			wp_enqueue_style( 'stm-theme-style-' . $layout . '-css', get_theme_file_uri( '/assets/css/dist/app-' . $layout . '.css' ), array( 'bootstrap' ), STM_THEME_VERSION, 'all' );
		} else {
			/**
			 * Layouts NOT using the main app.css:
			 * 1. Boats
			 * 2. Motorcycles
			 * 3. Auto Parts
			 * 4. Rental One
			 */
			if ( 'boats' === $layout ) {
				wp_enqueue_style( 'stm-theme-style-boats', get_theme_file_uri( '/assets/css/dist/boats/app.css' ), array( 'bootstrap' ), STM_THEME_VERSION, 'all' );
			} elseif ( 'motorcycle' === $layout ) {
				wp_enqueue_style( 'stm-theme-style-sass', get_theme_file_uri( '/assets/css/dist/motorcycle/app.css' ), array( 'bootstrap' ), STM_THEME_VERSION, 'all' );
			} elseif ( stm_is_auto_parts() ) {
				wp_enqueue_style( 'stm-theme-style-ap-sass', get_theme_file_uri( '/assets/css/dist/auto-parts/app.css' ), array( 'bootstrap' ), STM_THEME_VERSION, 'all' );
			} else {
				wp_enqueue_style( 'stm-theme-style-sass', get_theme_file_uri( '/assets/css/dist/app.css' ), array( 'bootstrap' ), STM_THEME_VERSION, 'all' );

				if ( is_listing() ) {
					if ( stm_is_listing_four() ) {
						wp_enqueue_style( 'stm-theme-style-listing-four-sass', get_theme_file_uri( '/assets/css/dist/listing_four/app.css' ), array( 'bootstrap' ), STM_THEME_VERSION, 'all' );
					} else {
						wp_enqueue_style( 'stm-theme-style-listing-sass', get_theme_file_uri( '/assets/css/dist/listing/app.css' ), array( 'bootstrap' ), STM_THEME_VERSION, 'all' );
						if ( stm_is_listing_two() ) {
							wp_enqueue_style( 'stm-theme-style-listing-two-sass', get_theme_file_uri( '/assets/css/dist/listing_two/app.css' ), array( 'bootstrap' ), STM_THEME_VERSION, 'all' );
						}
						if ( stm_is_listing_three() ) {
							if ( stm_is_listing_three_elementor() ) {
								wp_enqueue_style( 'stm-theme-style-listing-three-sass', get_theme_file_uri( '/assets/css/dist/app-listing_three_elementor.css' ), array( 'bootstrap' ), STM_THEME_VERSION, 'all' );
							} else {
								wp_enqueue_style( 'stm-theme-style-listing-three-sass', get_theme_file_uri( '/assets/css/dist/listing_three/app.css' ), array( 'bootstrap' ), STM_THEME_VERSION, 'all' );
							}
						}
					}
				} elseif ( 'car_magazine' === $layout ) {
					wp_enqueue_style( 'stm-theme-style-magazine-sass', get_theme_file_uri( '/assets/css/dist/magazine/app.css' ), array( 'bootstrap' ), STM_THEME_VERSION, 'all' );
				} elseif ( 'car_dealer_two' === $layout ) {
					wp_enqueue_style( 'stm-theme-style-dealer-two-sass', get_theme_file_uri( '/assets/css/dist/dealer_two/app.css' ), array( 'bootstrap' ), STM_THEME_VERSION, 'all' );
				}
			}

			if ( stm_is_rental() ) {
				wp_enqueue_style( 'stm-theme-style-rental', get_theme_file_uri( '/assets/css/dist/rental/app.css' ), array( 'bootstrap' ), STM_THEME_VERSION, 'all' );
			}
		}
	}

	// Animations.
	wp_enqueue_style( 'stm-theme-style-animation', get_theme_file_uri( '/assets/css/animation.css' ), null, STM_THEME_VERSION, 'all' );

	if ( stm_me_get_wpcfto_mod( 'site_style' ) && stm_me_get_wpcfto_mod( 'site_style' ) !== 'site_style_default' && stm_me_get_wpcfto_mod( 'site_style' ) !== 'site_style_custom' ) {
		wp_enqueue_style( STM_THEME_SLUG . '-' . stm_me_get_wpcfto_mod( 'site_style' ) );
	}

	// Theme main stylesheet.
	wp_enqueue_style( 'stm-theme-style', $template_directory_uri . '/style.css', array(), STM_THEME_VERSION, 'all' );

	if ( file_exists( $stm_upload_path . '/wpcfto-generate.css' ) ) {
		wp_enqueue_style( 'stm-wpcfto-styles', $stm_upload_dir . '/wpcfto-generate.css', null, get_option( 'stm_wpcfto_style' ), 'all' );
	}

	// Scripts.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$google_api_key        = stm_me_get_wpcfto_mod( 'google_api_key', '' );
	$google_marker_cluster = 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js';
	if ( ! empty( $google_api_key ) ) {
		$google_api_map = 'https://maps.googleapis.com/maps/api/js?key=' . $google_api_key . '&';
	} else {
		$google_api_map = 'https://maps.googleapis.com/maps/api/js?';
	}

	if ( stm_is_boats() || stm_is_dealer_two() || is_listing() || stm_is_car_dealer() ) {
		$google_api_map .= 'libraries=places';
	}

	$callback = '';

	if ( stm_is_use_plugin( 'stm_motors_events/stm_motors_events.php' ) ) {
		$callback = '&callback=initGoogleScripts';
	}

	wp_register_script( 'stm_marker_cluster', $google_marker_cluster, $jquery, STM_THEME_VERSION, true );

	wp_register_script( 'stm_gmap', $google_api_map . $callback . '&language=' . get_bloginfo( 'language' ), $jquery, STM_THEME_VERSION, true );

	wp_register_script( 'stm-google-places', get_theme_file_uri( '/assets/js/stm-google-places.js' ), 'stm_gmap', STM_THEME_VERSION, true );

	wp_register_script( 'stm_grecaptcha', 'https://www.google.com/recaptcha/api.js?onload=stmMotorsCaptcha&render=explicit', $jquery, STM_THEME_VERSION, true );

	wp_enqueue_script( 'stm-classie', get_theme_file_uri( '/assets/js/classie.js' ), $jquery, STM_THEME_VERSION, false );
	wp_enqueue_script( 'lazyload', get_theme_file_uri( '/assets/js/lazyload.js' ), $jquery, STM_THEME_VERSION, true );

	if ( class_exists( 'WooCommerce' ) && ( is_checkout() || is_shop() || is_account_page() || is_edit_account_page() || ( stm_is_rental_two() && is_product() ) ) ) {
		motors_include_once_scripts_styles( array( 'uniform', 'uniform-init', 'stmselect2', 'app-select2' ) );
	}

	if ( ! stm_is_auto_parts() ) {
		if ( file_exists( get_theme_file_path( '/assets/js/app-' . $layout . '.js' ) ) ) {
			if ( stm_is_listing_five() ) {
				wp_enqueue_script( 'stm-theme-scripts-main', get_theme_file_uri( '/assets/js/app.js' ), $jquery, STM_THEME_VERSION, true );
			}

			wp_enqueue_script( 'stm-theme-scripts', get_theme_file_uri( '/assets/js/app-' . $layout . '.js' ), array( 'jquery', 'bootstrap' ), STM_THEME_VERSION, true );
		} else {
			wp_enqueue_script( 'stm-theme-scripts', get_theme_file_uri( '/assets/js/app.js' ), array( 'jquery', 'bootstrap' ), STM_THEME_VERSION, true );
			if ( stm_is_rental() ) {
				wp_enqueue_script( 'stm-theme-rental-scripts', get_theme_file_uri( '/assets/js/app-rental.js' ), array( 'jquery', 'bootstrap' ), STM_THEME_VERSION, true );
			}
		}
	} else {
		wp_enqueue_script( 'stm-theme-scripts', get_theme_file_uri( '/assets/js/app-auto-parts.js' ), array( 'jquery', 'bootstrap' ), STM_THEME_VERSION, true );
	}

	if ( stm_is_magazine() ) {

		if ( is_single() ) {
			wp_enqueue_style( 'stmselect2' );
			wp_enqueue_script( 'stmselect2' );
			wp_enqueue_script( 'app-select2' );
		}

		wp_enqueue_script( 'stm-magazine-theme-scripts', get_theme_file_uri( '/assets/js/magazine_scripts.js' ), $jquery, STM_THEME_VERSION, true );
		wp_enqueue_script( 'vue_min', get_theme_file_uri( '/assets/js/vue.min.js' ), array( 'typeahead' ), STM_THEME_VERSION, false );
		wp_enqueue_script( 'vue_resource', get_theme_file_uri( '/assets/js/vue-resource.js' ), array( 'typeahead' ), STM_THEME_VERSION, false );
		wp_enqueue_script( 'vue_app', get_theme_file_uri( '/assets/js/vue-app.js' ), array( 'typeahead' ), STM_THEME_VERSION, false );
	}

	wp_add_inline_script( 'stm-theme-scripts', stm_me_get_wpcfto_mod( 'footer_custom_scripts', '' ) );

	wp_register_script( 'stm-countUp.min.js', get_theme_file_uri( '/assets/js/countUp.min.js' ), $jquery, STM_THEME_VERSION, true );

	// Enable scroll js only if user wants header be fixed.
	$fixed_header = stm_me_get_wpcfto_mod( 'header_sticky', false );
	if ( ! empty( $fixed_header ) && $fixed_header ) {
		wp_enqueue_script( 'stm-theme-scripts-header-scroll', get_theme_file_uri( '/assets/js/app-header-scroll.js' ), $jquery, STM_THEME_VERSION, true );
	}

	if ( stm_is_rental() ) {
		wp_enqueue_script( 'moment-localize', get_theme_file_uri( '/assets/js/moment.min.js' ), $jquery, STM_THEME_VERSION, false );
	}

	$smooth_scroll = stm_me_get_wpcfto_mod( 'smooth_scroll', false );

	if ( ! empty( $smooth_scroll ) && true === $smooth_scroll && ! is_admin() && ( class_exists( 'Elementor' ) && ! \Elementor\Plugin::$instance->preview->is_preview_mode( get_the_ID() ) ) ) {
		wp_enqueue_script( 'stm-smooth-scroll', get_theme_file_uri( '/assets/js/smoothScroll.js' ), $jquery, STM_THEME_VERSION, true );
	}

	if ( ! stm_is_auto_parts() && ! stm_is_rental_two() ) {
		wp_enqueue_script( 'stm-theme-scripts-ajax', get_theme_file_uri( '/assets/js/app-ajax.js' ), array( 'jquery' ), STM_THEME_VERSION, true );
	}

	if ( ! stm_is_auto_parts() && ! stm_is_rental_two() ) {
		wp_enqueue_script( 'stm-theme-script-filter', get_theme_file_uri( '/assets/js/filter.js' ), array( 'jquery' ), STM_THEME_VERSION, true );
	}

	if ( stm_is_boats() || stm_is_dealer_two() || is_listing() || stm_is_car_dealer() ) {
		wp_enqueue_script( 'custom_scrollbar' );
	}

	wp_localize_script(
		'stm-theme-scripts',
		'stm_i18n',
		array(
			'remove_from_compare'   => __( 'Remove from compare', 'motors' ),
			'remove_from_favorites' => __( 'Remove from favorites', 'motors' ),
		)
	);
}


function stm_load_ulisting_theme_ss() {
	$directoryStylesheet = get_template_directory_uri();

	$jquery = array( 'jquery' );

	wp_enqueue_script( 'jquery', false, array(), STM_THEME_VERSION, false );
	wp_enqueue_script( 'jquery-effects-slide' );
	wp_enqueue_script( 'jquery-ui-droppable' );
	wp_enqueue_script( 'uniform', get_theme_file_uri( '/assets/js/jquery.uniform.min.js' ), $jquery, STM_THEME_VERSION, true );

	$layout          = stm_get_current_layout();
	$upload_dir      = wp_upload_dir();
	$stm_upload_dir  = $upload_dir['baseurl'] . '/stm_uploads';
	$stm_upload_path = $upload_dir['basedir'] . '/stm_uploads';

	if ( ! empty( stm_me_get_wpcfto_mod( 'typography_body_font_family' ) ) || ! empty( stm_me_get_wpcfto_mod( 'typography_heading_font_family' ) ) ) {
		wp_enqueue_style( 'stm_default_google_font', stm_default_google_fonts_enqueue(), null, STM_THEME_VERSION, 'all' );
	}

	wp_enqueue_script( 'owl.carousel', get_theme_file_uri( '/assets/js/owl.carousel.js' ), 'jquery', STM_THEME_VERSION, true );
	wp_enqueue_script( 'light-gallery', get_theme_file_uri( '/assets/js/lightgallery-all.js' ), array( 'jquery' ), STM_THEME_VERSION, true );

	if ( file_exists( get_theme_file_path( '/assets/js/app-' . $layout . '.js' ) ) ) {
		wp_enqueue_script( 'stm-theme-scripts', get_theme_file_uri( '/assets/js/app-' . $layout . '.js' ), array( 'jquery' ), STM_THEME_VERSION, true );
	}

	// header styles.
	$file_name = 'header-' . stm_get_header_layout();
	stm_motors_enqueue_header_scripts_styles( $file_name );
	$site_color_style = stm_me_get_wpcfto_mod( 'site_style' );
	if ( 'site_style_default' !== $site_color_style ) {
		wp_dequeue_style( $file_name );
		wp_deregister_style( $file_name );
	}

	wp_enqueue_style( 'light-gallery', get_theme_file_uri( '/assets/css/lightgallery.min.css' ), array(), STM_THEME_VERSION, 'all' );
	wp_enqueue_style( 'owl.carousel', get_theme_file_uri( '/assets/css/owl.carousel.css' ), null, STM_THEME_VERSION, 'all' );

	wp_enqueue_style( 'stm-theme-style', $directoryStylesheet . '/style.css', null, STM_THEME_VERSION, 'all' );

	if ( stm_me_get_wpcfto_mod( 'site_style', 'site_style_default' ) !== 'site_style_default' && is_dir( $upload_dir['basedir'] . '/stm_uploads' ) ) {
		wp_enqueue_style( 'stm-skin-custom', $stm_upload_dir . '/skin-custom.css', null, get_option( 'stm_custom_style', '4' ), 'all' );
	} else {
		wp_enqueue_style( 'stm-theme-style-ulisting', get_theme_file_uri( '/assets/css/dist/app-' . $layout . '.css' ), null, STM_THEME_VERSION, 'all' );
	}

	if ( file_exists( $stm_upload_path . '/wpcfto-generate.css' ) ) {
		wp_enqueue_style( 'stm-wpcfto-styles', $stm_upload_dir . '/wpcfto-generate.css', null, get_option( 'stm_wpcfto_style' ), 'all' );
	}
}


// Admin styles.
add_action( 'admin_enqueue_scripts', 'stm_admin_assets' );
add_action( 'admin_enqueue_scripts', 'stm_load_all_icons' );
function stm_admin_assets() {
	wp_enqueue_style( 'stm-theme-admin-css', get_template_directory_uri() . '/assets/admin/css/style.css', null, 4.1, 'all' );
	wp_enqueue_style( 'stm-theme-etm-style', get_theme_file_uri( '/inc/email_template_manager/assets/css/etm-style.css' ), null, STM_THEME_VERSION, 'all' );
}

if ( ! function_exists( 'stm_motors_enqueue_header_scripts_styles' ) ) {
	function stm_motors_enqueue_header_scripts_styles( $file_name ) {
		if ( ! wp_style_is( $file_name, 'enqueued' ) && file_exists( get_theme_file_path( '/assets/css/dist/headers/' . $file_name . '.css' ) ) ) {
			wp_enqueue_style( $file_name, get_theme_file_uri( '/assets/css/dist/headers/' . $file_name . '.css' ), null, STM_THEME_VERSION, 'all' );
		}

		if ( ! wp_script_is( $file_name, 'enqueued' ) && file_exists( get_theme_file_path( '/assets/js/headers/' . $file_name . '.js' ) ) ) {
			wp_enqueue_script( $file_name, get_theme_file_uri( '/assets/js/headers/' . $file_name . '.js' ), 'jquery', STM_THEME_VERSION, false );
		}
	}
}

if ( ! function_exists( 'motors_include_once_scripts_styles' ) ) {
	function motors_include_once_scripts_styles( $handle ) {
		if ( is_array( $handle ) ) {
			foreach ( $handle as $id ) {
				if ( wp_style_is( $id, 'registered' ) && ! wp_style_is( $id, 'enqueued' ) ) {
					wp_enqueue_style( $id );
				}

				if ( wp_script_is( $id, 'registered' ) && ! wp_script_is( $id, 'enqueued' ) ) {
					wp_enqueue_script( $id );
				}
			}
		} else {
			if ( wp_style_is( $handle, 'registered' ) && ! wp_style_is( $handle, 'enqueued' ) ) {
				wp_enqueue_style( $handle );
			}

			if ( wp_script_is( $handle, 'registered' ) && ! wp_script_is( $handle, 'enqueued' ) ) {
				wp_enqueue_script( $handle );
			}
		}
	}
}

// Default Google fonts enqueue.
if ( ! function_exists( 'stm_default_google_fonts_enqueue' ) ) {
	function stm_default_google_fonts_enqueue() {
		$fonts_url = '';

		$typography_body_font_family = stm_me_get_wpcfto_mod( 'typography_body_font_family' );
		if ( ! empty( $typography_body_font_family['font-data']['family'] ) ) {
			$font_families[ strtolower( str_replace( ' ', '_', $typography_body_font_family['font-data']['family'] ) ) ] = $typography_body_font_family['font-data']['family'] . ':' . implode( ',', $typography_body_font_family['font-data']['variants'] );
		}

		$typography_heading_font_family = stm_me_get_wpcfto_mod( 'typography_heading_font_family' );
		if ( ! empty( $typography_heading_font_family['font-data']['family'] ) ) {
			$font_families[ strtolower( str_replace( ' ', '_', $typography_heading_font_family['font-data']['family'] ) ) ] = $typography_heading_font_family['font-data']['family'] . ':' . implode( ',', $typography_heading_font_family['font-data']['variants'] );
		}

		$typography_menu_font_family = stm_me_get_wpcfto_mod( 'typography_menu_font_family' );
		if ( ! empty( $typography_menu_font_family['font-data']['family'] ) ) {
			$font_families[ strtolower( str_replace( ' ', '_', $typography_menu_font_family['font-data']['family'] ) ) ] = $typography_menu_font_family['font-data']['family'] . ':' . implode( ',', $typography_menu_font_family['font-data']['variants'] );
		}

		$typography_main_menu_font_family = stm_me_get_wpcfto_mod( 'typography_main_menu_font_settings' );
		if ( ! empty( $typography_main_menu_font_family['font-data']['family'] ) ) {
			$font_families[ strtolower( str_replace( ' ', '_', $typography_main_menu_font_family['font-data']['family'] ) ) ] = $typography_main_menu_font_family['font-data']['family'] . ':' . implode( ',', $typography_main_menu_font_family['font-data']['variants'] );
		}

		$logo_font_family = stm_me_get_wpcfto_mod( 'logo_font_family' );
		if ( ! empty( $logo_font_family['font-data']['family'] ) ) {
			$font_families[ strtolower( str_replace( ' ', '_', $logo_font_family['font-data']['family'] ) ) ] = $logo_font_family['font-data']['family'] . ':' . implode( ',', $logo_font_family['font-data']['variants'] );
		}

		if ( stm_is_ev_dealer() ) {
			$font_families[] = 'Montserrat:400,500,600,700,800,900';
		}

		if ( ! empty( $font_families ) ) {
			$query_args = array(
				'family' => rawurlencode( implode( '|', $font_families ) ),
				'subset' => rawurlencode( 'latin,latin-ext' ),
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		} else {
			if ( stm_is_motorcycle() ) {
				$montserrat = _x( 'on', 'Exo 2 font: on or off', 'motors' );
			} else {
				$montserrat = _x( 'on', 'Montserrat font: on or off', 'motors' );
			}
			$open_sans = _x( 'on', 'Open Sans font: on or off', 'motors' );

			if ( 'off' !== $montserrat || 'off' !== $open_sans ) {
				$font_families = array();

				if ( 'off' !== $montserrat ) {
					if ( stm_is_motorcycle() ) {
						$font_families[] = 'Exo 2:400,300,500,600,700,800,900';
					} else {
						$font_families[] = 'Montserrat:400,500,600,700,800,900';
					}
				}

				if ( 'off' !== $open_sans ) {
					$font_families[] = 'Open Sans:300,400,500,700,800,900';
				}

				$query_args = array(
					'family' => rawurlencode( implode( '|', $font_families ) ),
					'subset' => rawurlencode( 'latin,latin-ext' ),
				);

				$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
			}
		}

		return esc_url_raw( $fonts_url );
	}
}

add_action( 'customize_controls_enqueue_scripts', 'motors_customize_scripts' );
if ( ! function_exists( 'motors_customize_scripts' ) ) {
	function motors_customize_scripts() {
		wp_enqueue_script( 'motors-customize-script', get_template_directory_uri() . '/assets/js/customize.js', array( 'customize-controls' ), 'all', true );

		wp_localize_script(
			'motors-customize-script',
			'customize_data',
			array(
				'message' => sprintf(
					__( 'Motors theme Customize Settings were moved to <a href="%s">Dashboard > Theme Options</a>.', 'motors' ),
					admin_url( '?page=wpcfto_motors_' . stm_get_current_layout() . '_settings' )
				),
			)
		);
	}
}
