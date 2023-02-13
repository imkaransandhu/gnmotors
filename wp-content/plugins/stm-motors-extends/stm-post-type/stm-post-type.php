<?php
if ( ! defined( 'STM_POST_TYPE' ) ) {
	define( 'STM_POST_TYPE', 'stm-post-type' );
}

require_once STM_MOTORS_EXTENDS_PATH . '/stm-post-type/post_type.class.php';

$options          = get_option( 'stm_post_types_options' );
$choosen_template = get_option( 'stm_motors_chosen_template' );

$default_post_types_options = array(
	'listings' => array(
		'title'        => __( 'Listings', 'stm_motors_extends' ),
		'plural_title' => __( 'Listings', 'stm_motors_extends' ),
		'rewrite'      => 'listings',
	),
);

$stm_post_types_options = wp_parse_args( $options, $default_post_types_options );

// Rental
STM_PostType::registerPostType(
	'stm_office',
	__( 'Office', 'stm_motors_extends' ),
	array(
		'menu_icon'           => 'dashicons-admin-multisite',
		'supports'            => array( 'title' ),
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
	)
);

STM_PostType::registerPostType(
	'sidebar',
	__( 'Sidebar', 'stm_motors_extends' ),
	array(
		'menu_icon'           => 'dashicons-schedule',
		'supports'            => array( 'title', 'editor' ),
		'exclude_from_search' => true,
		'publicly_queryable'  => true,

	)
);

STM_PostType::registerPostType(
	'test_drive_request',
	__( 'Test Drive Requests', 'stm_motors_extends' ),
	array(
		'pluralTitle'         => __( 'Test drives', 'stm_motors_extends' ),
		'supports'            => array( 'title' ),
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'show_in_menu'        => 'edit.php?post_type=listings',
	)
);

$title_box_opt = array(
	'page_bg_color'                 => array(
		'label' => __( 'Page Background Color', 'stm_motors_extends' ),
		'type'  => 'color_picker',
	),
	'transparent_header'            => array(
		'label' => __( 'Transparent Header', 'stm_motors_extends' ),
		'type'  => 'checkbox',
	),
	'separator_title_box'           => array(
		'label' => __( 'Title Box', 'stm_motors_extends' ),
		'type'  => 'separator',
	),
	'alignment'                     => array(
		'label'   => __( 'Alignment', 'stm_motors_extends' ),
		'type'    => 'select',
		'options' => array(
			'left'   => __( 'Left', 'stm_motors_extends' ),
			'center' => __( 'Center', 'stm_motors_extends' ),
			'right'  => __( 'Right', 'stm_motors_extends' ),
		),
	),
	'title'                         => array(
		'label'   => __( 'Title', 'stm_motors_extends' ),
		'type'    => 'select',
		'options' => array(
			'show' => __( 'Show', 'stm_motors_extends' ),
			'hide' => __( 'Hide', 'stm_motors_extends' ),
		),
	),
	'stm_title_tag'                 => array(
		'label'   => __( 'Select Title Tag', 'stm_motors_extends' ),
		'type'    => 'select',
		'options' => array(
			'h2' => __( 'H2', 'stm_motors_extends' ),
			'h1' => __( 'H1', 'stm_motors_extends' ),
		),
	),
	'sub_title'                     => array(
		'label' => __( 'Sub Title', 'stm_motors_extends' ),
		'type'  => 'text',
	),
	'title_box_bg_color'            => array(
		'label' => __( 'Background Color', 'stm_motors_extends' ),
		'type'  => 'color_picker',
	),
	'title_box_font_color'          => array(
		'label' => __( 'Font Color', 'stm_motors_extends' ),
		'type'  => 'color_picker',
	),
	'title_box_line_color'          => array(
		'label' => __( 'Line Color', 'stm_motors_extends' ),
		'type'  => 'color_picker',
	),
	'title_box_subtitle_font_color' => array(
		'label' => __( 'Sub Title Font Color', 'stm_motors_extends' ),
		'type'  => 'color_picker',
	),
	'title_box_custom_bg_image'     => array(
		'label' => __( 'Custom Background Image', 'stm_motors_extends' ),
		'type'  => 'image',
	),
	'separator_breadcrumbs'         => array(
		'label' => __( 'Breadcrumbs', 'stm_motors_extends' ),
		'type'  => 'separator',
	),
	'breadcrumbs'                   => array(
		'label'   => __( 'Breadcrumbs', 'stm_motors_extends' ),
		'type'    => 'select',
		'options' => array(
			'show' => __( 'Show', 'stm_motors_extends' ),
			'hide' => __( 'Hide', 'stm_motors_extends' ),
		),
	),
	'breadcrumbs_font_color'        => array(
		'label' => __( 'Breadcrumbs Color', 'stm_motors_extends' ),
		'type'  => 'color_picker',
	),
);

if ( 'rental_two' === $choosen_template ) {
	$title_box_opt['separator_home_page'] = array(
		'label' => __( 'Home Page', 'stm_motors_extends' ),
		'type'  => 'separator',
	);

	$title_box_opt['stm_select_home_page'] = array(
		'label'   => __( 'Select Home Page', 'stm_motors_extends' ),
		'type'    => 'select',
		'options' => array(
			'home_page_1' => __( 'Home 1', 'stm_motors_extends' ),
			'home_page_2' => __( 'Home 2', 'stm_motors_extends' ),
		),
	);
	$title_box_opt['home_page_logo']       = array(
		'label' => __( 'Home Page Logo', 'stm_motors_extends' ),
		'type'  => 'image',
	);
}

if ( 'motorcycle' === $choosen_template ) {
	$title_box_opt['motorcycle_sep']            = array(
		'label' => __( 'Additional Title Box opt (Motorcycle layout)', 'stm_motors_extends' ),
		'type'  => 'separator',
	);
	$title_box_opt['sub_title_instead']         = array(
		'label' => __( 'Text instead Title', 'stm_motors_extends' ),
		'type'  => 'text',
	);
	$title_box_opt['disable_title_box_overlay'] = array(
		'label' => __( 'Disable Title Box Color Overlay', 'stm_motors_extends' ),
		'type'  => 'checkbox',
	);
}

if ( 'car_magazine' === $choosen_template ) {
	STM_PostType::addMetaBox(
		'video_url',
		__( 'Set Youtube Url', 'stm_motors_extends' ),
		array( 'post' ),
		'',
		'side',
		'',
		array(
			'fields' => array(
				'video_url' => array(
					'label' => __( 'Url', 'stm_motors_extends' ),
					'type'  => 'text',
				),
			),
		)
	);
}

STM_PostType::addMetaBox(
	'page_options',
	__( 'Page Options', 'stm_motors_extends' ),
	array( 'page', 'post', 'listings', 'product', 'stm_events', 'stm_review' ),
	'',
	'',
	'',
	array(
		'fields' => $title_box_opt,
	)
);

STM_PostType::addMetaBox(
	'test_drive_form',
	__( 'Credentials', 'stm_motors_extends' ),
	array( 'test_drive_request' ),
	'',
	'',
	'',
	array(
		'fields' => array(
			'name'  => array(
				'label' => __( 'Name', 'stm_motors_extends' ),
				'type'  => 'text',
			),
			'email' => array(
				'label' => __( 'E-mail', 'stm_motors_extends' ),
				'type'  => 'text',
			),
			'phone' => array(
				'label' => __( 'Phone', 'stm_motors_extends' ),
				'type'  => 'text',
			),
			'date'  => array(
				'label' => __( 'Day', 'stm_motors_extends' ),
				'type'  => 'text',
			),
		),
	)
);


$args          = array(
	'post_type'      => 'wpcf7_contact_form',
	'posts_per_page' => - 1,
);
$available_cf7 = array();
$cf7_forms     = get_posts( $args );
if ( $cf7_forms ) {
	foreach ( $cf7_forms as $cf7_form ) {
		$available_cf7[ $cf7_form->ID ] = $cf7_form->post_title;
	}
} else {
	$available_cf7['No CF7 forms found'] = 'none';
};

STM_PostType::addMetaBox(
	'service_info',
	esc_html__( 'Options', 'stm_motors_extends' ),
	array( 'service' ),
	'',
	'',
	'',
	array(
		'fields' => array(
			'icon'    => array(
				'label' => esc_html__( 'Icon', 'stm_motors_extends' ),
				'type'  => 'iconpicker',
			),
			'icon_bg' => array(
				'label' => esc_html__( 'Icon Background Color', 'stm_motors_extends' ),
				'type'  => 'color_picker',
			),
		),
	)
);

if ( 'listing' === $choosen_template || 'listing_two' === $choosen_template || 'listing_three' === $choosen_template || 'listing_four' === $choosen_template || 'listing_four_elementor' === $choosen_template || 'listing_five' === $choosen_template || 'listing_one_elementor' === $choosen_template ) {

	STM_PostType::addMetaBox(
		'listing_seller_note',
		esc_html__( 'Seller`s note', 'stm_motors_extends' ),
		array( 'listings' ),
		'',
		'normal',
		'high',
		array(
			'fields' => array(
				'listing_seller_note' => array(
					'label' => '',
					'type'  => 'texteditor',
					'class' => 'fullwidth',
				),
			),
		)
	);

	STM_PostType::registerPostType(
		'dealer_review',
		__( 'Dealer Review', 'stm_motors_extends' ),
		array(
			'menu_icon'           => 'dashicons-groups',
			'supports'            => array( 'title', 'editor' ),
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
		)
	);

	$rates = array();
	for ( $i = 1; $i < 6; $i ++ ) {
		$rates[ $i ] = $i;
	}

	$likes = array(
		'neutral' => esc_html__( 'Neutral', 'motors' ),
		'yes'     => esc_html__( 'Yes', 'motors' ),
		'no'      => esc_html__( 'No', 'motors' ),
	);

	STM_PostType::addMetaBox(
		'dealer_reviews',
		esc_html__( 'Reviews', 'stm_motors_extends' ),
		array( 'dealer_review' ),
		'',
		'',
		'',
		array(
			'fields' => array(
				'stm_review_added_by' => array(
					'label'   => __( 'User added by', 'stm_motors_extends' ),
					'type'    => 'select',
					'options' => STM_PostType::getUsers(),
				),
				'stm_review_added_on' => array(
					'label'   => __( 'User added on', 'stm_motors_extends' ),
					'type'    => 'select',
					'options' => STM_PostType::getUsers(),
				),
				'stm_rate_1'          => array(
					'label'   => __( 'Rate 1', 'stm_motors_extends' ),
					'type'    => 'select',
					'options' => $rates,
				),
				'stm_rate_2'          => array(
					'label'   => __( 'Rate 2', 'stm_motors_extends' ),
					'type'    => 'select',
					'options' => $rates,
				),
				'stm_rate_3'          => array(
					'label'   => __( 'Rate 3', 'stm_motors_extends' ),
					'type'    => 'select',
					'options' => $rates,
				),
				'stm_recommended'     => array(
					'label'   => __( 'Recommended', 'stm_motors_extends' ),
					'type'    => 'select',
					'options' => $likes,
				),
			),
		)
	);
}

if ( 'listing_two' === $choosen_template ) {
	STM_PostType::registerPostType(
		'car_value',
		__( 'Value My Car', 'stm_motors_extends' ),
		array(
			'menu_icon'           => 'dashicons-groups',
			'supports'            => array( 'title', 'editor', 'thumbnail' ),
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'show_in_menu'        => false,
		)
	);
}

function stm_me_post_type_styles() {

	wp_enqueue_style( 'admin-styles', STM_MOTORS_EXTENDS_URL . '/assets/css/admin.css', null, '1.0', 'all' );

	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );

	wp_enqueue_style( 'stmcss-datetimepicker', STM_MOTORS_EXTENDS_URL . '/assets/css/jquery.stmdatetimepicker.css', null, '1.0', 'all' );
	wp_enqueue_script( 'stmjs-datetimepicker', STM_MOTORS_EXTENDS_URL . '/assets/js/jquery.stmdatetimepicker.js', array( 'jquery' ), '1.0', true );

	$google_api_key = '';

	if ( function_exists( 'stm_me_get_wpcfto_mod' ) ) {
		$google_api_key = stm_me_get_wpcfto_mod( 'google_api_key', '' );
	}

	if ( ! wp_script_is( 'stm_gmap', 'enqueued' ) ) {
		if ( ! empty( $google_api_key ) ) {
			$google_api_map = 'https://maps.googleapis.com/maps/api/js?libraries=places&key=' . $google_api_key . '&';
		} else {
			$google_api_map = 'https://maps.googleapis.com/maps/api/js?libraries=places';
		}

		if ( ! wp_script_is( 'stm_gmap_admin', 'registered' ) ) {
			wp_register_script( 'stm_gmap_admin', $google_api_map, array( 'jquery' ), '1.0', true );
		}

		if ( ! wp_script_is( 'stm_gmap_admin', 'enqueued' ) ) {
			wp_enqueue_script( 'stm_gmap_admin' );
		}
	}

	wp_enqueue_script( 'stmjs-admin-places', STM_MOTORS_EXTENDS_URL . '/assets/js/stm-admin-places.js', array( 'jquery' ), '1.0', true );

	wp_enqueue_media();
}

add_action( 'admin_enqueue_scripts', 'stm_me_post_type_styles' );

require_once STM_MOTORS_EXTENDS_PATH . '/stm-post-type/rewrite.php';

