<?php
$current_id = get_the_ID();
if ( is_post_type_archive( stm_listings_post_type() ) ) {
	$current_id = stm_listings_user_defined_filter_page();
}

$is_multilisting_archive = false;

if ( stm_is_multilisting() ) {
	$listing_types = stm_listings_multi_type( false );
	$options       = get_option( 'stm_motors_listing_types', array() );
	if ( ! empty( $listing_types ) ) {
		foreach ( $listing_types as $key => $listing_type ) {
			if ( is_post_type_archive( $listing_type ) ) {
				foreach ( $options['multilisting_repeater'] as $key => $item ) {
					if ( $item['slug'] === $listing_type && ! empty( $item['inventory_page'] ) ) {
						$current_id = abs( $item['inventory_page'] );
					}
				}

				$is_multilisting_archive = true;
			}
		}
	}
}

$show_title_box      = 'hide';
$stm_title_style     = '';
$is_shop             = false;
$is_product          = false;
$is_product_category = false;

if ( function_exists( 'is_shop' ) && is_shop() ) {
	$is_shop = true;
}

if ( function_exists( 'is_product_category' ) && is_product_category() || function_exists( 'is_product_tag' ) && is_product_tag() ) {
	$is_product_category = true;
}

if ( function_exists( 'is_product' ) && is_product() ) {
	$is_product = true;
}

if ( is_home() || is_category() || is_search() ) {
	$current_id = get_option( 'page_for_posts' );
}

if ( $is_shop ) {
	$current_id = get_option( 'woocommerce_shop_page_id' );
}

$stm_title   = '';
$breadcrumbs = get_post_meta( $current_id, 'breadcrumbs', true );

if ( is_home() ) {
	if ( ! get_option( 'page_for_posts' ) ) {
		$stm_title = __( 'News', 'motors' );
	} else {
		$stm_title = get_the_title( $current_id );
	}
} elseif ( $is_product ) {
	$stm_title = get_the_title( $current_id );
} elseif ( $is_product_category ) {
	$stm_title  = single_cat_title( '', false );
	$current_id = get_option( 'woocommerce_shop_page_id' );
} elseif ( is_post_type_archive( stm_listings_post_type() ) || $is_multilisting_archive ) {
	$stm_title   = stm_me_get_wpcfto_mod( 'classic_listing_title', esc_html__( 'Inventory', 'motors' ) );
	$breadcrumbs = 'hide';
} elseif ( is_category() ) {
	$stm_title = single_cat_title( '', false );
} elseif ( is_tax() ) {
	$stm_title = single_term_title( '', false );
} elseif ( is_tag() ) {
	$stm_title = single_tag_title( '', false );
} elseif ( is_search() ) {
	$stm_title = __( 'Search', 'motors' );
} elseif ( is_date() ) {
	if ( is_day() ) {
		$stm_title = get_the_time( 'F d, Y' );
	} elseif ( is_month() ) {
		$stm_title = get_the_time( 'F, Y' );
	} elseif ( is_year() ) {
		$stm_title = get_the_time( 'Y' );
	}
} else {
	$stm_title = get_the_title( $current_id );
}

$alignment                         = get_post_meta( $current_id, 'alignment', true );
$stm_heading_style                = array();
$stm_title_style_subtitle          = array();
$stm_title_box_bg_color            = get_post_meta( $current_id, 'title_box_bg_color', true );
$stm_title_box_font_color          = get_post_meta( $current_id, 'title_box_font_color', true );
$stm_title_box_line_color          = get_post_meta( $current_id, 'title_box_line_color', true );
$stm_title_box_custom_bg_image     = get_post_meta( $current_id, 'title_box_custom_bg_image', true );
$stm_title_tag                     = ( empty( get_post_meta( $current_id, 'stm_title_tag', true ) ) ) ? 'h2' : get_post_meta( $current_id, 'stm_title_tag', true );
$sub_title                         = get_post_meta( $current_id, 'sub_title', true );
$breadcrumbs_font_color            = get_post_meta( $current_id, 'breadcrumbs_font_color', true );
$stm_title_box_subtitle_font_color = get_post_meta( $current_id, 'title_box_subtitle_font_color', true );
$sub_title_instead                 = get_post_meta( $current_id, 'sub_title_instead', true );

if ( empty( $alignment ) || is_post_type_archive( stm_listings_post_type() ) ) {
	$alignment = 'left';
}

if ( $stm_title_box_bg_color ) {
	$stm_title_style .= 'background-color: ' . $stm_title_box_bg_color . ';';
}

if ( $stm_title_box_font_color ) {
	$stm_heading_style['font_color'] = 'color: ' . $stm_title_box_font_color . ';';
}

if ( $stm_title_box_subtitle_font_color ) {
	$stm_title_style_subtitle['font_color'] = 'color: ' . $stm_title_box_subtitle_font_color . ';';
}

$stm_title_box_custom_bg_image = wp_get_attachment_image_src( $stm_title_box_custom_bg_image, 'full' );
if ( ! empty( $stm_title_box_custom_bg_image ) ) {
	$stm_title_style .= "background-image: url('" . $stm_title_box_custom_bg_image[0] . "');";
}

$show_title_box = get_post_meta( $current_id, 'title', true );

if ( 'hide' === $show_title_box ) {
	$show_title_box = false;
} else {
	$show_title_box = true;
}

if ( is_tag() || is_date() || is_category() ) {
	$show_title_box = true;
	$breadcrumbs    = 'show';
}

$additional_classes = '';

if ( ( ! is_tag() && ! is_date() && ! is_category() ) || ( empty( $sub_title ) && empty( $stm_title_box_line_color ) ) ) {
	$additional_classes = ' small_title_box';
}
if ( ( $is_shop || $is_product || $is_product_category ) && 'show' === $breadcrumbs ) {
	$additional_classes .= ' no_woo_padding';
}

/*Only for blog*/
$blog_margin = '';
if ( 'post' === get_post_type() ) {
	if ( ! empty( $_GET['show-title-box'] ) && 'hide' === $_GET['show-title-box'] ) {
		$show_title_box = false;
	}
	if ( ! empty( $_GET['show-breadcrumbs'] ) && 'yes' === $_GET['show-breadcrumbs'] ) {
		$breadcrumbs = 'show';
		$blog_margin = 'stm-no-margin-bc';
	}
}

if ( stm_is_listing() ) {
	$assigned_add_car_page = stm_me_get_wpcfto_mod( 'user_add_car_page', 1755 );
	$prices_page           = stm_me_get_wpcfto_mod( 'pricing_link', 1678 );

	$restricted = false;
	if ( is_user_logged_in() ) {
		$user         = wp_get_current_user();
		$user_id      = $user->ID;
		$restrictions = stm_get_post_limits( $user_id );
	} else {
		$restrictions = stm_get_post_limits( '' );
	}

	if ( $restrictions['posts'] < 1 ) {
		$restricted = true;
	}

	$is_add_car_page = ( $current_id === $assigned_add_car_page ) ? true : false;

	$pricing_plans_enabled = stm_me_get_wpcfto_mod( 'enable_plans', false );
}

if ( $show_title_box ) {
	$disable_overlay = '';
	if ( stm_is_motorcycle() ) :
		$disable_overlay = get_post_meta( $current_id, 'disable_title_box_overlay', true );
		if ( ! empty( $disable_overlay ) && 'on' === $disable_overlay ) {
			$disable_overlay = ' disable_overlay';
		}
	endif; ?>
	<div class="entry-header <?php echo esc_attr( $alignment . $additional_classes . $disable_overlay ); ?>" style="<?php echo stm_do_lmth( $stm_title_style ); ?>">
		<div class="container">
			<div class="entry-title">
				<<?php echo esc_attr( $stm_title_tag ); ?> class="h1" style="<?php echo implode( ' ', $stm_heading_style ); ?>">
				<?php
				if ( ! empty( $stm_title ) ) {
					echo apply_filters( 'stm_balance_tags', $stm_title );
				}
				?>
			</<?php echo esc_attr( $stm_title_tag ); ?>>
			<?php if ( $stm_title_box_line_color ) : ?>
				<div class="colored-separator">
					<div class="first-long" 
					<?php
					if ( ! empty( $stm_title_box_line_color ) ) :
						?>
						style="background-color: <?php echo esc_attr( $stm_title_box_line_color ); ?>" <?php endif; ?>></div>
					<div class="last-short" 
					<?php
					if ( ! empty( $stm_title_box_line_color ) ) :
						?>
						style="background-color: <?php echo esc_attr( $stm_title_box_line_color ); ?>" <?php endif; ?>></div>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $sub_title ) && ! is_search() && ! is_tag() && ! is_date() && ! is_category() ) { ?>
				<div class="sub-title h5" style="<?php echo implode( ' ', $stm_title_style_subtitle ); ?>">
					<?php echo apply_filters( 'stm_balance_tags', $sub_title ); ?>
				</div>
			<?php } ?>
		</div>
	</div>
	</div>
<?php } else { ?>
	<?php if ( 'hide' !== $breadcrumbs ) : ?>
		<div class="title-box-disabled"></div>
	<?php endif; ?>
<?php } ?>

	<!-- Breads -->
<?php
if ( 'hide' !== $breadcrumbs ) :

	if ( $is_shop || $is_product || $is_product_category ) {
		woocommerce_breadcrumb();
	} else {
		if ( function_exists( 'bcn_display' ) ) {
			?>
			<div class="stm_breadcrumbs_unit heading-font <?php echo esc_attr( $blog_margin ); ?>">
				<div class="container">
					<div class="navxtBreads">
						<?php bcn_display(); ?>
					</div>
					<?php if ( stm_is_listing() && $is_add_car_page && $restricted && $pricing_plans_enabled && is_user_logged_in() ) : ?>
						<div class="stm-notice">
							<div class="notice-text">
								<i class="fas fa-info-circle"></i>
								<span class="heading-font"><?php echo esc_html__( 'Ad limit has been reached. Buy a new plan', 'motors' ); ?></span>
							</div>
							<div class="btn-plans">
								<a href="<?php echo get_the_permalink( $prices_page ); ?>" class="button"><?php echo esc_html__( 'Plans', 'motors' ); ?></a>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php
		}
	}
endif;
