<?php
// Product Registration
define( 'STM_THEME_NAME', 'Motors' );
define( 'STM_THEME_CATEGORY', 'Car Dealer, Rental & Listing WordPress theme' );
define( 'STM_ENVATO_ID', '13987211' );
define( 'STM_TOKEN_OPTION', 'stm_motors_token' );
define( 'STM_TOKEN_CHECKED_OPTION', 'stm_motors_token_checked' );
define( 'STM_THEME_SETTINGS_URL', ( ! empty( get_option( 'stm_motors_chosen_template', '' ) ) ) ? 'wpcfto_motors_' . get_option( 'stm_motors_chosen_template', 'car_dealer' ) . '_settings' : 'stm-admin-demos' );
define( 'STM_GENERATE_TOKEN', 'https://docs.stylemixthemes.com/motors-theme-documentation/theme-activation' );
define( 'STM_SUBMIT_A_TICKET', 'https://support.stylemixthemes.com/tickets/new/support?item_id=12' );
define( 'STM_DEMO_SITE_URL', 'https://motors.stylemixthemes.com/' );
define( 'STM_DOCUMENTATION_URL', 'https://docs.stylemixthemes.com/motors-theme-documentation/' );
define( 'STM_CHANGELOG_URL', 'https://docs.stylemixthemes.com/motors-theme-documentation/changelog' );
define( 'STM_INSTRUCTIONS_URL', 'https://docs.stylemixthemes.com/motors-theme-documentation/theme-activation' );
define( 'STM_INSTALL_VIDEO_URL', 'https://www.youtube.com/watch?v=tJAVpV4l8wE&list=PL3Pyh_1kFGGD0Z7F5Ad7LT6xv5LLYFpWU&index=1&ab_channel=StylemixThemes' );
define( 'STM_VOTE_URL', 'https://stylemixthemes.cnflx.io/boards/motors-car-dealer-rental-classifieds' );
define( 'STM_BUY_ANOTHER_LICENSE', 'https://themeforest.net/item/motors-automotive-cars-vehicle-boat-dealership-classifieds-wordpress-theme/13987211' );
define( 'STM_VIDEO_TUTORIALS', 'https://www.youtube.com/playlist?list=PL3Pyh_1kFGGD0Z7F5Ad7LT6xv5LLYFpWU' );
define( 'STM_FACEBOOK_COMMUNITY', 'https://www.facebook.com/groups/motorstheme' );
define( 'STM_TEMPLATE_URI', get_template_directory_uri() );
define( 'STM_TEMPLATE_DIR', get_template_directory() );
define( 'STM_THEME_SLUG', 'stm' );
define( 'STM_INC_PATH', get_template_directory() . '/inc' );
if ( ! defined( 'MOTORS_DEMO_SITE' ) ) {
	define( 'MOTORS_DEMO_SITE', false );
}

add_action(
	'current_screen',
	function () {
		$screen = get_current_screen();
		if ( stripos( $screen->base, 'page_transients-manager' ) !== false || stripos( $screen->base, 'page_stm-admin-system-status' ) !== false || stripos( $screen->base, 'page_tgmpa-install-plugins' ) !== false || 'themes' === $screen->base ) {
			return;
		}

		if ( is_admin() ) {
			$current_demo = apply_filters( 'stm_theme_demo_layout', '' );

			if ( ! empty( STM_Theme_Info::get_activation_token() ) && ! empty( $current_demo ) && class_exists( 'STM_TGM_Plugins' ) ) {
				$plugins = STM_TGM_Plugins::get_plugins_data( $current_demo );

				if ( is_array( $plugins ) && count( $plugins ) > 0 && array_key_exists( 'has_update', $plugins ) && count( $plugins['has_update'] ) > 0 ) {

					$pl = array_filter(
						$plugins['has_update'],
						function ( $plugin ) {
							if ( in_array( $plugin['slug'], array( 'stm_vehicles_listing', 'stm-motors-extends' ), true ) ) {
								return $plugin;
							}
						}
					);

					if ( count( $pl ) > 0 ) {
						set_transient( 'motors_check_core_plugin_update', true );
						if ( stripos( $screen->base, 'page_stm-admin-plugins' ) === false ) {
							wp_safe_redirect( admin_url( 'admin.php?page=stm-admin-plugins#core' ) );
							exit;
						}
					} else {
						delete_transient( 'motors_check_core_plugin_update' );
					}
				}
			}
		}
	},
	10,
	1
);

add_action(
	'admin_notices',
	function () {
		$screen = get_current_screen();
		$check  = get_transient( 'motors_check_core_plugin_update' );

		if ( $check && 'motors_page_stm-admin-plugins' === $screen->base ) {
			echo '<div class="notice notice-warning __envato-market"><p>';
			echo sprintf( '<span class="dashicons dashicons-warning"></span><b style="padding-left: 10px;">%s</b>', esc_html__( 'Please update the plugins right below as well! It is essential to update these plugins for the theme to work properly.', 'motors' ) );
			echo '</p></div>';
		}
	},
	100,
	1
);

add_filter( 'stm_theme_enable_elementor', 'get_motors_theme_enable_elementor' );

function get_motors_theme_enable_elementor() {
	return true;
}

add_filter( 'stm_theme_default_layout', 'get_stm_theme_default_layout' );
function get_stm_theme_default_layout() {
	return 'car_dealer';
}

add_filter( 'stm_theme_default_layout_name', 'get_stm_theme_default_layout_name' );
function get_stm_theme_default_layout_name() {
	return 'car_dealer';
}

add_filter( 'stm_theme_demos', 'motors_get_demos' );
add_filter( 'stm_theme_demo_layout', 'get_stm_theme_demo_layout' );
add_filter( 'stm_theme_plugins', 'get_stm_theme_plugins' );
add_filter( 'stm_theme_layout_plugins', 'get_stm_theme_layout_plugins', 10, 1 );

function get_stm_theme_plugins() {
	return stm_require_plugins_popup( true );
}

function get_stm_theme_demo_layout( $default = '' ) {
	return get_option( 'stm_motors_chosen_template', $default );
}


if ( is_admin() && file_exists( get_template_directory() . '/admin/admin.php' ) ) {
	require_once get_template_directory() . '/admin/admin.php';
}

// Include path.
$inc_path = get_template_directory() . '/inc';

// Widgets path
$widgets_path = $inc_path . '/widgets';

require_once $inc_path . '/classes/STM_Custom_Colors_Helper.php';
// Custom code and theme main setups
require_once $inc_path . '/setup.php';

// Helpers
require_once $inc_path . '/helpers.php';

// Cron Settings
require_once $inc_path . '/cron.php';

// Enqueue scripts and styles for theme
require_once $inc_path . '/scripts_styles.php';

// Multiple Currency
require_once $inc_path . '/multiple_currencies.php';

// Custom code for any outputs modifying
require_once $inc_path . '/custom.php';

// Required plugins for theme
require_once $inc_path . '/tgm/tgm-plugin-registration.php';

// Custom code for any outputs modifying with ajax relation
require_once $inc_path . '/stm-ajax.php';

// Custom code for filter output
require_once $inc_path . '/user-filter.php';

// User
require_once $inc_path . '/user-extra.php';

require_once $inc_path . '/stm_single_dealer.php';

// email template manager
require_once $inc_path . '/email_template_manager/email_template_manager.php';

// value my car
if ( is_listing( array( 'listing_two', 'listing_three', 'listing_one_elementor', 'listing_three_elementor', 'listing_four_elementor' ) ) ) {
	require_once $inc_path . '/value_my_car/value_my_car.php';
}

// Custom code for woocommerce modifying
if ( class_exists( 'WooCommerce' ) ) {

	if ( class_exists( 'Subscriptio' ) || class_exists( 'RP_SUB' ) ) {
		require_once $inc_path . '/MultiplePlan.php';
	}

	require_once $inc_path . '/woocommerce_setups.php';
	if ( stm_is_rental() ) {
		require_once $inc_path . '/woocommerce_setups_rental.php';
	}

	if ( ( stm_me_get_wpcfto_mod( 'dealer_pay_per_listing', false ) ||
			stm_me_get_wpcfto_mod( 'dealer_payments_for_featured_listing', false ) ||
			stm_me_get_wpcfto_mod( 'enable_woo_online', false ) ) &&
			( is_listing() || stm_is_dealer_two() ) ) {
		require_once $inc_path . '/perpay.php';
	}
}

if ( class_exists( '\\STM_GDPR\\STM_GDPR' ) ) {
	require_once $inc_path . '/motors-gdpr.php';
}

add_filter( 'wpcf7_autop_or_not', '__return_false' );
