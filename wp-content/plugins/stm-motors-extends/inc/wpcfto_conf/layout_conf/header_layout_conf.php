<?php
add_filter(
	'motors_get_all_wpcfto_config',
	function ( $global_conf ) {

		$conf = array(
			'header_layout'                        =>
				array(
					'label'      => esc_html__( 'Header Layout', 'stm_motors_extends' ),
					'type'       => 'select',
					'options'    => stm_me_wpcfto_headers_list(),
					'submenu'    => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency' => array(
						'key'     => 'header_current_layout',
						'value'   => 'aircrafts||boats||ev_dealer||car_dealer_elementor||car_dealer_elementor_rtl||car_dealer||car_dealer_two||car_dealer_two_elementor||car_magazine||car_rental||equipment||listing||listing_one_elementor||listing_two||listing_three||listing_three_elementor||listing_four||listing_four_elementor||listing_five||motorcycle',
						'section' => 'general_tab',
					),
				),
			'header_bg_color'                      =>
				array(
					'label'           => esc_html__( 'Header Background Color', 'stm_motors_extends' ),
					'type'            => 'color',
					'description'     => esc_html__( 'Does not work when the Transparent Header option for the page is enabled.', 'stm_motors_extends' ),
					'mode'            => 'background-color',
					'style_important' => true,
					'submenu'         => esc_html__( 'Main', 'stm_motors_extends' ),
					'output'          => '
						#header .header-main,
						#header .stm_motorcycle-header .stm_mc-main.header-main,
						.home #header .header-main-listing-five.stm-fixed,
						#header .header-listing.stm-fixed,
						.header-service.service-notransparent-header,
						.stm-template-boats .header-listing.stm-fixed,
						.stm-template-car_dealer_two.no_margin #wrapper #stm-boats-header #header:after,
						.stm-template-aircrafts:not(.transparent-header) #wrapper #header,
						.stm-template-ev_dealer.stm-layout-header-car_dealer_two #wrapper #stm-boats-header #header,
						.stm-layout-header-ev_dealer #wrapper #header .header-main,
						.stm-layout-header-listing #wrapper #header .header-listing.listing-nontransparent-header,
						.stm-layout-header-listing #wrapper #header .header-listing:after,
						.stm-layout-header-equipment #header .header-listing,
						.stm-layout-header-car_dealer_two.no_margin #wrapper #stm-boats-header #header:after,
						.stm-layout-header-boats #stm-boats-header #header:after,
						.stm-template-rental_two #wrapper .header-main
					',
				),
			'header_mobile_bg_color'               =>
				array(
					'label'           => esc_html__( 'Mobile Header Background Color', 'stm_motors_extends' ),
					'type'            => 'color',
					'mode'            => 'background-color',
					'style_important' => true,
					'submenu'         => esc_html__( 'Main', 'stm_motors_extends' ),
					'output'          => '#header .header-main.header-main-mobile,
						#header .header-main.header-main-mobile .mobile-menu-holder,
						#header .stm_motorcycle-header.header-main-mobile .stm_mc-main.header-main,
						#header .stm_motorcycle-header.header-main-mobile .stm_mc-nav,
						.stm-layout-header-car_rental .header-main-mobile .stm-opened-menu-listing,
						.stm-layout-header-car_rental .header-main-mobile .stm-opened-menu-listing #top-bar,
						.stm-layout-header-equipment #header .header-listing.header-main-mobile,
						.stm-layout-header-equipment #header .header-listing.header-main-mobile .header-inner-content .mobile-menu-holder .header-menu,
						.stm-layout-header-listing #wrapper #header .header-listing.header-main-mobile.listing-nontransparent-header,
						.stm-layout-header-listing #wrapper #header .header-main-mobile.header-listing:after,
						.stm-layout-header-listing #wrapper #header .header-main-mobile.header-listing .stm-opened-menu-listing,
						.stm-layout-header-listing #wrapper #header .header-main-mobile.header-listing .stm-opened-menu-listing #top-bar,
						#header .header-listing.stm-fixed.header-main-mobile,
						.header-service.service-notransparent-header.header-main-mobile,
						.stm-boats-mobile-header,
						.stm-boats-mobile-menu,
						.stm-template-aircrafts:not(.home):not(.stm-inventory-page):not(.single-listings) #wrapper #header .header-main-mobile,
						.stm-layout-header-aircrafts #header .header-listing.header-main-mobile,
						.stm-template-rental_two #wrapper .header-main.header-main-mobile,
						.header-magazine.header-main-mobile,
						.header-magazine.header-main-mobile .stm-opened-menu-magazine,
						.stm-layout-header-motorcycle .stm_motorcycle-header.header-main-mobile .stm_mc-nav .main-menu .container .inner .header-menu
					',
				),
			'header_mobile_info_bg_color'          =>
				array(
					'label'           => esc_html__( 'Mobile Header Info Background Color', 'stm_motors_extends' ),
					'type'            => 'color',
					'mode'            => 'background-color',
					'output'          => '#header .header-main .header-top-info.open,
					#header .header-main .logo-main .mobile-contacts-trigger.open',
					'style_important' => true,
					'submenu'         => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency'      => array(
						'key'   => 'header_layout',
						'value' => 'car_dealer_elementor||car_dealer_elementor_rtl||car_dealer||listing_four||listing_four_elementor',
					),
				),
			'header_text_color'                    =>
				array(
					'label'      => esc_html__( 'Header Text Color', 'stm_motors_extends' ),
					'type'       => 'color',
					'mode'       => 'color',
					'submenu'    => esc_html__( 'Main', 'stm_motors_extends' ),
					'output'     => '
						#wrapper #header .header-main .heading-font,
						#wrapper #header .header-main .heading-font a,
						#wrapper #stm-boats-header #header .header-inner-content .listing-right-actions .heading-font,
						#wrapper #header .header-inner-content .listing-right-actions .head-phone-wrap .heading-font,
						#wrapper #header .header-magazine .container .magazine-service-right .magazine-right-actions .pull-right a.lOffer-compare,
						#wrapper #header .stm_motorcycle-header .stm_mc-main.header-main .header-main-phone a,
						.stm-layout-header-listing_five #wrapper .lOffer-compare,
						.stm-layout-header-listing_five #wrapper .header-main .stm-header-right .head-phone-wrap .ph-title,
						.stm-layout-header-listing_five #wrapper .header-main .stm-header-right .head-phone-wrap .phone
						',
					'dependency' => array(
						'key'   => 'header_layout',
						'value' => 'boats||ev_dealer||car_dealer_elementor||car_dealer_elementor_rtl||car_dealer||car_magazine||car_rental||equipment||listing_four||listing_four_elementor||motorcycle||listing_five',
					),
				),
			'header_mobile_text_color'             =>
				array(
					'label'           => esc_html__( 'Mobile Header Text Color', 'stm_motors_extends' ),
					'type'            => 'color',
					'mode'            => 'color',
					'style_important' => true,
					'submenu'         => esc_html__( 'Main', 'stm_motors_extends' ),
					'output'          => '
						#wrapper #header .header-main.header-main-mobile .heading-font,
						#wrapper #header .header-main.header-main-mobile .heading-font a,
						#header .header-main.header-main-mobile,
						#header .stm_motorcycle-header.header-main-mobile .stm_mc-main.header-main .header-main-phone a,
						.header-magazine.header-main-mobile .pull-right a
						',
					'dependency'      => array(
						'key'   => 'header_layout',
						'value' => 'car_dealer_elementor||car_dealer_elementor_rtl||car_dealer||car_rental||listing_four||listing_four_elementor||motorcycle',
					),
				),
			'header_icon_color'                    =>
				array(
					'label'      => esc_html__( 'Header Socials Icon Color', 'stm_motors_extends' ),
					'type'       => 'color',
					'mode'       => 'color',
					'submenu'    => esc_html__( 'Main', 'stm_motors_extends' ),
					'output'     => '
						#wrapper #header .header-main .header-main-socs i,
						#wrapper #header .header-magazine .magazine-service-right .header-main-socs i
						',
					'dependency' => array(
						'key'   => 'header_layout',
						'value' => 'car_dealer_elementor||car_dealer_elementor_rtl||car_dealer||car_magazine||listing_four||listing_four_elementor||motorcycle',
					),
				),
			'header_mobile_icon_color'             =>
				array(
					'label'           => esc_html__( 'Mobile Header Socials Icon Color', 'stm_motors_extends' ),
					'type'            => 'color',
					'mode'            => 'color',
					'style_important' => true,
					'submenu'         => esc_html__( 'Main', 'stm_motors_extends' ),
					'output'          => '
						#wrapper #header .header-main.header-main-mobile .header-main-socs i,
						#wrapper #header .header-main-mobile .header-main i,
						#header .stm_motorcycle-header.header-main-mobile .stm_mc-main.header-main .header-main-socs ul li a,
						.header-magazine.header-main-mobile .pull-right .header-main-socs i
						',
					'dependency'      => array(
						'key'   => 'header_layout',
						'value' => 'motorcycle',
					),
				),
			'header_sticky'                        =>
				array(
					'label'      => esc_html__( 'Sticky', 'stm_motors_extends' ),
					'type'       => 'checkbox',
					'submenu'    => esc_html__( 'Sticky', 'stm_motors_extends' ),
					'dependency' => array(
						'key'     => 'header_current_layout',
						'value'   => 'aircrafts||boats||ev_dealer||car_dealer_elementor||car_dealer_elementor_rtl||car_dealer||car_dealer_two||car_dealer_two_elementor||car_magazine||car_rental||equipment||listing||listing_one_elementor||listing_two||listing_three||listing_three_elementor||listing_four||listing_four_elementor||listing_five||listing_six||motorcycle||service',
						'section' => 'general_tab',
					),
				),
			'header_sticky_padding'                =>
				array(
					'label'           => esc_html__( 'Padding', 'stm_motors_extends' ),
					'type'            => 'spacing',
					'units'           => array( 'px', 'em' ),
					'output'          => '.header-service.header-service-fixed.header-service-sticky.service-notransparent-header,
					.header-service.header-service-fixed.header-service-sticky,
					.stm-layout-header-listing_five #wrapper #header .header-main.stm-fixed,
					.header-nav-fixed.header-nav-sticky,
					.stm-layout-header-car_dealer_two.no_margin #stm-boats-header #header .stm-fixed,
					.stm-layout-header-ev_dealer #wrapper #header .header-main-ev_dealer.header-listing-fixed.stm-fixed,
					#wrapper #header .header-listing.stm-fixed,
					.stm-layout-header-car_magazine #wrapper #header .header-magazine.header-magazine-fixed.stm-fixed
					',
					'mode'            => 'padding',
					'style_important' => true,
					'dependencies'    => '&&',
					'submenu'         => esc_html__( 'Sticky', 'stm_motors_extends' ),
					'value'           => array(
						'top'    => '10',
						'right'  => '',
						'bottom' => '13',
						'left'   => '',
						'unit'   => 'px',
					),
					'dependency'      => array(
						array(
							'key'   => 'header_sticky',
							'value' => 'not_empty',
						),
						array(
							'key'   => 'header_layout',
							'value' => 'aircrafts||boats||ev_dealer||car_dealer_elementor||car_dealer_elementor_rtl||car_dealer||car_dealer_two||car_dealer_two_elementor||car_magazine||car_rental||equipment||listing||listing_one_elementor||listing_two||listing_three||listing_three_elementor||listing_four||listing_four_elementor||listing_five||listing_six||service',
						),
					),
				),
			'header_sticky_bg'                     =>
				array(
					'label'           => esc_html__( 'Background Color', 'stm_motors_extends' ),
					'type'            => 'color',
					'mode'            => 'background-color',
					'style_important' => true,
					'submenu'         => esc_html__( 'Sticky', 'stm_motors_extends' ),
					'output'          => '
						#header-nav-holder .header-nav.header-nav-default.header-nav-sticky,
						.header-service.header-service-fixed.header-service-sticky.service-notransparent-header,
						.header-service.header-service-fixed.header-service-sticky,
						.stm-layout-header-boats #stm-boats-header #header .header-listing-boats.stm-fixed,
						.stm-layout-header-car_magazine #wrapper #header .header-magazine.header-magazine-fixed.stm-fixed,
						.stm-layout-header-ev_dealer #wrapper #header .header-main-ev_dealer.header-listing-fixed.stm-fixed,
						.stm-layout-header-motorcycle #wrapper #header .stm_motorcycle-header.stm-fixed .stm_mc-main.header-main,
						.stm-layout-header-motorcycle .stm_motorcycle-header.stm-fixed .stm_mc-nav .main-menu .container .inner .header-menu,
						.stm-layout-header-motorcycle .stm_motorcycle-header.stm-fixed .stm_mc-nav .main-menu .container .inner:before,
						.stm-layout-header-motorcycle .stm_motorcycle-header.stm-fixed .stm_mc-nav .main-menu .container .inner:after,
						.stm-layout-header-listing_five #wrapper #header .header-main.stm-fixed,
						.stm-layout-header-car_dealer_two #stm-boats-header #header .stm-fixed:after,
						#wrapper #header .header-listing.stm-fixed,
						#wrapper #header .header-listing.stm-fixed:after
					',
					'dependency'      => array(
						'key'   => 'header_sticky',
						'value' => 'not_empty',
					),
				),
			'phone_settings_start'                 =>
				array(
					'label'      => esc_html__( 'Phone Settings', 'stm_motors_extends' ),
					'type'       => 'notice',
					'group'      => 'started',
					'submenu'    => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency' => array(
						'key'   => 'header_layout',
						'value' => 'ev_dealer||car_dealer_elementor||car_dealer_elementor_rtl||car_dealer||motorcycle||car_rental||equipment',
					),
				),
			'header_main_phone_show_on_mobile'     =>
				array(
					'label'      => esc_html__( 'Main Phone Show on Mobile', 'stm_motors_extends' ),
					'type'       => 'checkbox',
					'submenu'    => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency' => array(
						'key'   => 'header_layout',
						'value' => 'motorcycle||car_rental',
					),
				),
			'header_main_phone_icon'               =>
				array(
					'label'           => esc_html__( 'Main Phone Icon', 'stm_motors_extends' ),
					'type'            => 'icon_picker',
					'style_important' => true,
					'submenu'         => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency'      => array(
						'key'   => 'header_layout',
						'value' => 'car_dealer_elementor||car_dealer_elementor_rtl||car_dealer||car_rental||equipment',
					),
				),
			'header_main_phone_label_color'        =>
				array(
					'label'           => esc_html__( 'Main Phone Label Color', 'stm_motors_extends' ),
					'type'            => 'color',
					'mode'            => 'color',
					'output'          => '#wrapper #header .header-main .header-main-phone .phone .phone-label',
					'style_important' => true,
					'submenu'         => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency'      => array(
						'key'   => 'header_layout',
						'value' => 'car_dealer_elementor||car_dealer_elementor_rtl||car_dealer',
					),
				),
			'header_main_phone_label'              =>
				array(
					'label'        => esc_html__( 'Main Phone Label', 'stm_motors_extends' ),
					'type'         => 'text',
					'dependencies' => '||',
					'submenu'      => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency'   => array(
						array(
							'key'   => 'header_layout',
							'value' => 'ev_dealer||car_dealer_elementor||car_dealer_elementor_rtl||car_dealer||equipment',
						),
						array(
							'key'     => 'header_current_layout',
							'value'   => 'listing_six',
							'section' => 'general_tab',
						),
					),
				),
			'header_main_phone'                    =>
				array(
					'label'        => esc_html__( 'Main Phone', 'stm_motors_extends' ),
					'type'         => 'text',
					'value'        => '878-9671-4455',
					'dependencies' => '||',
					'submenu'      => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency'   => array(
						array(
							'key'   => 'header_layout',
							'value' => 'ev_dealer||car_dealer_elementor||car_dealer_elementor_rtl||car_dealer||motorcycle||car_rental||equipment',
						),
						array(
							'key'     => 'header_current_layout',
							'value'   => 'listing_six',
							'section' => 'general_tab',
						),
					),
				),
			'header_main_phone_label_color'        =>
				array(
					'label'           => esc_html__( 'Main Phone Color', 'stm_motors_extends' ),
					'type'            => 'color',
					'mode'            => 'color',
					'output'          => '#wrapper #header .header-main .head-phone-wrap .phone, #wrapper #header .header-main .head-phone-wrap .ph-title',
					'style_important' => true,
					'submenu'         => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency'      => array(
						'key'   => 'header_layout',
						'value' => 'ev_dealer',
					),
				),
			'header_secondary_phone_label_1_color' =>
				array(
					'label'           => esc_html__( 'Secondary Phone 1 Label Color', 'stm_motors_extends' ),
					'type'            => 'color',
					'mode'            => 'color',
					'output'          => '#wrapper #header .header-main .header-secondary-phone .phone .phone-label',
					'style_important' => true,
					'submenu'         => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency'      => array(
						'key'   => 'header_layout',
						'value' => 'car_dealer_elementor||car_dealer_elementor_rtl||car_dealer',
					),
				),
			'header_secondary_phone_label_1'       =>
				array(
					'label'      => esc_html__( 'Secondary Phone 1 Label', 'stm_motors_extends' ),
					'type'       => 'text',
					'value'      => 'Service',
					'submenu'    => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency' => array(
						'key'   => 'header_layout',
						'value' => 'car_dealer_elementor||car_dealer_elementor_rtl||car_dealer',
					),
				),
			'header_secondary_phone_1'             =>
				array(
					'label'      => esc_html__( 'Secondary Phone 1', 'stm_motors_extends' ),
					'type'       => 'text',
					'value'      => '878-3971-3223',
					'submenu'    => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency' => array(
						'key'   => 'header_layout',
						'value' => 'car_dealer_elementor||car_dealer_elementor_rtl||car_dealer',
					),
				),
			'header_secondary_phone_label_2_color' =>
				array(
					'label'           => esc_html__( 'Secondary Phone 2 Label Color', 'stm_motors_extends' ),
					'type'            => 'color',
					'mode'            => 'color',
					'output'          => '#wrapper #header .header-main .header-secondary-phone .phone:nth-child(2) .phone-label',
					'style_important' => true,
					'submenu'         => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency'      => array(
						'key'   => 'header_layout',
						'value' => 'car_dealer_elementor||car_dealer_elementor_rtl||car_dealer',
					),
				),
			'header_secondary_phone_label_2'       =>
				array(
					'label'      => esc_html__( 'Secondary Phone 2 Label', 'stm_motors_extends' ),
					'type'       => 'text',
					'value'      => 'Parts',
					'submenu'    => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency' => array(
						'key'   => 'header_layout',
						'value' => 'car_dealer_elementor||car_dealer_elementor_rtl||car_dealer',
					),
				),
			'header_secondary_phone_2'             =>
				array(
					'label'      => esc_html__( 'Secondary Phone 2', 'stm_motors_extends' ),
					'type'       => 'text',
					'value'      => '878-0910-0770',
					'group'      => 'ended',
					'submenu'    => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency' => array(
						'key'   => 'header_layout',
						'value' => 'car_dealer_elementor||car_dealer_elementor_rtl||car_dealer',
					),
				),
			'address_settings_start'               =>
				array(
					'label'      => esc_html__( 'Address Settings', 'stm_motors_extends' ),
					'type'       => 'notice',
					'group'      => 'started',
					'submenu'    => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency' => array(
						'key'   => 'header_layout',
						'value' => 'car_dealer_elementor||car_dealer_elementor_rtl||car_dealer',
					),
				),
			'header_address_icon'                  =>
				array(
					'label'           => esc_html__( 'Address Icon', 'stm_motors_extends' ),
					'type'            => 'icon_picker',
					'style_important' => true,
					'submenu'         => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency'      => array(
						'key'   => 'header_layout',
						'value' => 'car_dealer_elementor||car_dealer_elementor_rtl||car_dealer',
					),
				),
			'header_address'                       =>
				array(
					'label'      => esc_html__( 'Address', 'stm_motors_extends' ),
					'type'       => 'text',
					'value'      => '1840 E Garvey Ave South West Covina, CA 91791',
					'submenu'    => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency' => array(
						'key'   => 'header_layout',
						'value' => 'car_dealer_elementor||car_dealer_elementor_rtl||car_dealer',
					),
				),
			'header_address_url'                   =>
				array(
					'label'      => esc_html__( 'Google Map Address URL', 'stm_motors_extends' ),
					'type'       => 'text',
					'group'      => 'ended',
					'submenu'    => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency' => array(
						'key'   => 'header_layout',
						'value' => 'car_dealer_elementor||car_dealer_elementor_rtl||car_dealer',
					),
				),
			'header_listing_layout_image_bg'       =>
				array(
					'label'      => esc_html__( 'Listing Layout Header Image for Non-transparent Option', 'stm_motors_extends' ),
					'type'       => 'image',
					'submenu'    => esc_html__( 'Main', 'stm_motors_extends' ),
					'dependency' => array(
						'key'   => 'header_layout',
						'value' => 'listing||listing_one_elementor||listing_two||listing_three||listing_three_elementor||listing_four||listing_four_elementor',
					),
				),
			'sticky_notice'                        =>
				array(
					'label'      => esc_html__( 'Settings Not Available on This Layout', 'stm_motors_extends' ),
					'type'       => 'notice',
					'submenu'    => esc_html__( 'Sticky', 'stm_motors_extends' ),
					'dependency' => array(
						'key'     => 'header_current_layout',
						'value'   => 'rental_two',
						'section' => 'general_tab',
					),
				),
		);

		$options_start = apply_filters( 'motors_wpcfto_header_start_config', array() );

		$conf = ( ! empty( $options_start ) ) ? array_merge( $options_start, $conf ) : $conf;
		$conf = apply_filters( 'motors_wpcfto_header_end_config', $conf );

		$conf = array(
			'name'   => 'Header',
			'fields' => $conf,
		);

		$global_conf[ stm_me_modify_key( $conf['name'] ) ] = $conf;

		return $global_conf;
	},
	20,
	1
);

add_filter(
	'motors_get_all_wpcfto_config',
	function ( $conf ) {
		if ( 'car_dealer_elementor_rtl' === get_stm_theme_demo_layout( 'car_dealer' ) ) {
			$conf['header']['fields']['header_layout']['options'] = array( 'car_dealer' => __( 'Dealer', 'stm_motors_extends' ) );
			$conf['header']['fields']['header_layout']['value'] = 'car_dealer';
			$conf['header']['fields']['header_layout']['dependency']['value'] = 'car_dealer_elementor_rtl';
		}
		return $conf;

	},
	21,
	1
);

