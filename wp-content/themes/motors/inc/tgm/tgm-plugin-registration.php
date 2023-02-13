<?php
require_once dirname( __FILE__ ) . '/tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'stm_require_plugins_popup' );

function stm_require_plugins_popup( $return = false ) {
	$stm_importer_ver                      = '5.0.2';
	$stm_motors_extends_ver                = '1.9.5';
	$revslider_ver                         = '6.5.19';
	$js_composer_ver                       = '6.9.0';
	$stm_gdpr_compliance_ver               = '1.5';
	$stm_vehicles_listing_ver              = '7.0.1';
	$stm_listing_types_ver                 = '1.2.0';
	$stm_motors_car_rental_ver             = '1.6.4';
	$stm_megamenu_ver                      = '2.3.6';
	$stm_motors_equipment_ver              = '1.1.4';
	$ulisting_compare_ver                  = '1.1.6';
	$ulisting_wishlist_ver                 = '1.1.3';
	$subscriptio_ver                       = '3.0.7';
	$stm_woocommerce_motors_auto_parts_ver = '1.1.1';
	$stm_motors_classified_five_ver        = '1.2';
	$stm_motors_classified_six_ver         = '1.0.4';
	$stm_motors_events_ver                 = '1.4.0';
	$stm_motors_review_ver                 = '1.4.2';
	$motors_elementor_widgets              = '1.1.4';
	$motors_wpbakery_widgets               = '1.0.8';

	$plugins = array(
		'envato-market'                              => array(
			'name'     => 'Envato Market',
			'slug'     => 'envato-market',
			'source'   => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
			'required' => true,
		),
		'stm-motors-extends'                         => array(
			'name'     => 'STM Motors Extends',
			'slug'     => 'stm-motors-extends',
			'source'   => 'downloads://motors/stm-motors-extends-' . $stm_motors_extends_ver . '.zip',
			'required' => true,
			'version'  => $stm_motors_extends_ver,
			'core'     => true,
		),
		'stm-gdpr-compliance'                        => array(
			'name'     => 'GDPR Compliance & Cookie Consent',
			'slug'     => 'stm-gdpr-compliance',
			'source'   => 'downloads://motors/stm-gdpr-compliance-' . $stm_gdpr_compliance_ver . '.zip',
			'required' => false,
			'version'  => $stm_gdpr_compliance_ver,
		),
		'stm_vehicles_listing'                       => array(
			'name'     => 'Motors - Classified Listings',
			'slug'     => 'stm_vehicles_listing',
			'source'   => 'downloads://motors/stm_vehicles_listing-' . $stm_vehicles_listing_ver . '.zip',
			'required' => true,
			'version'  => $stm_vehicles_listing_ver,
			'core'     => true,
		),
		'motors-listing-types'                       => array(
			'name'     => 'Motors Listing Types',
			'slug'     => 'motors-listing-types',
			'source'   => 'downloads://motors/motors-listing-types-' . $stm_listing_types_ver . '.zip',
			'required' => true,
			'version'  => $stm_listing_types_ver,
			'core'     => true,
		),
		'custom-elementor-icons'                     => array(
			'name'             => 'Custom Elementor Icons',
			'slug'             => 'custom-elementor-icons',
			'required'         => false,
			'force_activation' => false,
		),
		'stm_importer'                               => array(
			'name'     => 'STM Importer',
			'slug'     => 'stm_importer',
			'source'   => 'downloads://motors/stm_importer-' . $stm_importer_ver . '.zip',
			'required' => true,
			'version'  => $stm_importer_ver,
		),
		'js_composer'                                => array(
			'name'         => 'WPBakery Page Builder',
			'slug'         => 'js_composer',
			'source'       => 'downloads://js_composer/js_composer-' . $js_composer_ver . '.zip',
			'external_url' => 'https://wpbakery.com/',
			'version'      => $js_composer_ver,
			'required'     => false,
			'premium'      => true,
		),
		'elementor'                                  => array(
			'name'     => 'Elementor',
			'slug'     => 'elementor',
			'required' => false,
		),
		'stm_motors_events'                          => array(
			'name'     => 'STM Motors - events',
			'slug'     => 'stm_motors_events',
			'source'   => 'downloads://motors/stm_motors_events-' . $stm_motors_events_ver . '.zip',
			'required' => true,
			'version'  => $stm_motors_events_ver,
		),
		'stm_motors_review'                          => array(
			'name'     => 'STM Motors - review',
			'slug'     => 'stm_motors_review',
			'source'   => 'downloads://motors/stm_motors_review-' . $stm_motors_review_ver . '.zip',
			'required' => true,
			'version'  => $stm_motors_review_ver,
		),
		'stm-motors-classified-five'                 => array(
			'name'     => 'STM Motors - Classified Five',
			'slug'     => 'stm-motors-classified-five',
			'source'   => 'downloads://motors/stm-motors-classified-five-' . $stm_motors_classified_five_ver . '.zip',
			'required' => true,
			'version'  => $stm_motors_classified_five_ver,
		),
		'stm-motors-classified-six'                  => array(
			'name'     => 'STM Motors - Classified Six',
			'slug'     => 'stm-motors-classified-six',
			'source'   => 'downloads://motors/stm-motors-classified-six-' . $stm_motors_classified_six_ver . '.zip',
			'required' => true,
			'version'  => $stm_motors_classified_six_ver,
		),
		'stm-motors-car-rental'                      => array(
			'name'     => 'STM Motors Car rental',
			'slug'     => 'stm-motors-car-rental',
			'source'   => 'downloads://motors/stm-motors-car-rental-' . $stm_motors_car_rental_ver . '.zip',
			'required' => true,
			'version'  => $stm_motors_car_rental_ver,
		),
		'stm-megamenu'                               => array(
			'name'     => 'STM Motors MegaMenu',
			'slug'     => 'stm-megamenu',
			'source'   => 'downloads://motors/stm-megamenu-' . $stm_megamenu_ver . '.zip',
			'required' => true,
			'version'  => $stm_megamenu_ver,
		),
		'stm-motors-equipment'                       => array(
			'name'     => 'STM Equipment',
			'slug'     => 'stm-motors-equipment',
			'source'   => 'downloads://motors/stm-motors-equipment-' . $stm_motors_equipment_ver . '.zip',
			'required' => true,
			'version'  => $stm_motors_equipment_ver,
		),
		'stm-woocommerce-motors-auto-parts'          => array(
			'name'             => 'STM Woocommerce Motors Auto Parts',
			'slug'             => 'stm-woocommerce-motors-auto-parts',
			'source'           => 'downloads://motors/stm-woocommerce-motors-auto-parts-' . $stm_woocommerce_motors_auto_parts_ver . '.zip',
			'required'         => false,
			'force_activation' => false,
			'version'          => $stm_woocommerce_motors_auto_parts_ver,
		),
		'motors-wpbakery-widgets'                    => array(
			'name'             => 'Motors WPBakery Widgets',
			'slug'             => 'motors-wpbakery-widgets',
			'source'           => 'downloads://motors/motors-wpbakery-widgets-' . $motors_wpbakery_widgets . '.zip',
			'required'         => false,
			'force_activation' => false,
			'version'          => $motors_wpbakery_widgets,
		),
		'motors-elementor-widgets'                   => array(
			'name'             => 'Motors Elementor Widgets',
			'slug'             => 'motors-elementor-widgets',
			'source'           => 'downloads://motors/motors-elementor-widgets-' . $motors_elementor_widgets . '.zip',
			'required'         => false,
			'force_activation' => false,
			'version'          => $motors_elementor_widgets,
		),
		'revslider'                                  => array(
			'name'         => 'Revolution Slider',
			'slug'         => 'revslider',
			'source'       => 'downloads://revslider/revslider-' . $revslider_ver . '.zip',
			'required'     => false,
			'version'      => $revslider_ver,
			'external_url' => 'http://www.themepunch.com/revolution/',
			'premium'      => true,
		),
		'add-to-any'                                 => array(
			'name'             => 'AddToAny Share Buttons',
			'slug'             => 'add-to-any',
			'required'         => false,
			'force_activation' => false,
		),
		'breadcrumb-navxt'                           => array(
			'name'             => 'Breadcrumb NavXT',
			'slug'             => 'breadcrumb-navxt',
			'required'         => false,
			'force_activation' => false,
		),
		'contact-form-7'                             => array(
			'name'             => 'Contact Form 7',
			'slug'             => 'contact-form-7',
			'required'         => false,
			'force_activation' => false,
		),
		'spotlight-social-photo-feeds'               => array(
			'name'     => 'Spotlight Instagram Feeds',
			'slug'     => 'spotlight-social-photo-feeds',
			'required' => false,
		),
		'mailchimp-for-wp'                           => array(
			'name'         => 'MailChimp for WordPress',
			'slug'         => 'mailchimp-for-wp',
			'required'     => false,
			'external_url' => 'https://mc4wp.com/',
		),
		'accesspress-social-counter'                 => array(
			'name'         => 'AccessPress Social Counter',
			'slug'         => 'accesspress-social-counter',
			'required'     => true,
			'external_url' => 'http://accesspressthemes.com',
		),
		'woocommerce'                                => array(
			'name'             => 'Woocommerce',
			'slug'             => 'woocommerce',
			'required'         => false,
			'force_activation' => false,
		),
		'pearl-header-builder'                       => array(
			'name'             => 'Pearl Header Builder',
			'slug'             => 'pearl-header-builder',
			'required'         => false,
			'force_activation' => false,
		),
		'woo-multi-currency'                         => array(
			'name'             => 'Multi Currency for WooCommerce',
			'slug'             => 'woo-multi-currency',
			'required'         => false,
			'force_activation' => false,
		),
		'yith-woocommerce-wishlist'                  => array(
			'name'             => 'YITH WooCommerce Wishlist',
			'slug'             => 'yith-woocommerce-wishlist',
			'required'         => false,
			'force_activation' => false,
		),
		'yith-woocommerce-compare'                   => array(
			'name'             => 'YITH WooCommerce Compare',
			'slug'             => 'yith-woocommerce-compare',
			'required'         => false,
			'force_activation' => false,
		),
		'bookly-responsive-appointment-booking-tool' => array(
			'name'             => 'Bookly Lite',
			'slug'             => 'bookly-responsive-appointment-booking-tool',
			'required'         => false,
			'force_activation' => false,
		),
		'subscriptio'                                => array(
			'name'     => 'Subscriptio',
			'slug'     => 'subscriptio',
			'source'   => 'downloads://motors/subscriptio-' . $subscriptio_ver . '.zip',
			'version'  => $subscriptio_ver,
			'required' => true,
		),
		'wordpress-social-login'                     => array(
			'name'     => 'WordPress Social Login',
			'slug'     => 'wordpress-social-login',
			'required' => true,
		),
		'ulisting-wishlist'                          => array(
			'name'         => 'uListing Wishlist',
			'slug'         => 'ulisting-wishlist',
			'source'       => 'downloads://motors/ulisting-wishlist-' . $ulisting_wishlist_ver . '.zip',
			'required'     => true,
			'version'      => $ulisting_wishlist_ver,
			'external_url' => 'https://stylemixthemes.com/',
		),
		'ulisting-compare'                           => array(
			'name'         => 'uListing Compare',
			'slug'         => 'ulisting-compare',
			'source'       => 'downloads://motors/ulisting-compare-' . $ulisting_compare_ver . '.zip',
			'required'     => true,
			'version'      => $ulisting_compare_ver,
			'external_url' => 'https://stylemixthemes.com/',
		),
	);

	if ( $return ) {
		return $plugins;
	} else {
		$config = array(
			'id'           => 'tgm_message_update_new3r',
			'is_automatic' => false,
			'strings'      => array(
				'nag_type' => 'update-nag',
			),
		);

		$tgm_layout_plugins = $plugins;
		$choosen_demo       = get_stm_theme_demo_layout();

		if ( ! empty( $choosen_demo ) ) {
			$layout_plugins = motors_layout_plugins( $choosen_demo );

			$tgm_layout_plugins = array();
			foreach ( $layout_plugins as $layout_plugin ) {
				$tgm_layout_plugins[ $layout_plugin ] = $plugins[ $layout_plugin ];
			}
		}

		tgmpa( $tgm_layout_plugins, $config );
	}
}

add_filter( 'stm_theme_secondary_required_plugins', 'get_motors_theme_secondary_required_plugins' );

function get_motors_theme_secondary_required_plugins() {
	$plugins = array(
		'js_composer',
		'elementor',
		'motors-wpbakery-widgets',
		'stm-elementor-widgets',
		'motors-elementor-widgets',
	);

	return $plugins;
}

add_filter( 'stm_theme_elementor_addon', 'get_motors_theme_elementor_addon' );

function get_motors_theme_elementor_addon() {
	return array(
		'motors-elementor-widgets',
	);
}
