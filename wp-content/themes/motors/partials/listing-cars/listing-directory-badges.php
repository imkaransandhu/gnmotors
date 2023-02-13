<?php
$sold             = get_post_meta( get_the_ID(), 'car_mark_as_sold', true );
$sold_badge_color = stm_me_get_wpcfto_mod( 'sold_badge_bg_color' );

// remove "special" if the listing is sold.
if ( ! empty( $sold ) ) {
	delete_post_meta( get_the_ID(), 'special_car' );
}

$special_car    = get_post_meta( get_the_ID(), 'special_car', true );
$badge_text     = get_post_meta( get_the_ID(), 'badge_text', true );
$badge_bg_color = get_post_meta( get_the_ID(), 'badge_bg_color', true );

$badge_style = '';
if ( ! empty( $badge_bg_color ) ) {
	$badge_style = 'style=background-color:' . $badge_bg_color . ';';
}

if ( empty( $badge_text ) ) {
	$badge_text = esc_html__( 'Special', 'motors' );
}

if ( ! empty( $sold ) && stm_sold_status_enabled() ) {
	$badge_style = 'style=background-color:' . $sold_badge_color . ';';

	if ( stm_is_equipment() ) :
		?>
		<div class="special-label special-label-small h6" <?php echo esc_attr( $badge_style ); ?>>
			<?php esc_html_e( 'Sold', 'motors' ); ?>
		</div>
	<?php else : ?>
		<div class="stm-badge-directory heading-font 
		<?php
		if ( stm_is_car_dealer() ) {
			echo 'stm-badge-dealer';
		}
		?>
		" <?php echo esc_attr( $badge_style ); ?>>
			<?php esc_html_e( 'Sold', 'motors' ); ?>
		</div>
		<?php
	endif;
} else {
	if ( ! empty( $special_car ) && 'on' === $special_car ) {
		if ( stm_is_equipment() || stm_is_motorcycle() ) :
			?>
			<div class="special-label special-label-small h6" <?php echo esc_attr( $badge_style ); ?>>
				<?php echo esc_html( $badge_text ); ?>
			</div>
		<?php else : ?>
			<div class="stm-badge-directory heading-font  <?php echo ( stm_is_car_dealer() ) ? 'stm-badge-dealer' : ''; ?> " <?php echo esc_attr( $badge_style ); ?>>
				<?php stm_dynamic_string_translation_e( 'Special Badge Text', $badge_text ); ?>
			</div>
			<?php
		endif;
	}
}
