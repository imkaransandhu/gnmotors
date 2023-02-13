<?php
$sold = get_post_meta(get_the_ID(), 'car_mark_as_sold', true);
$sold_badge_color = stm_me_get_wpcfto_mod('sold_badge_bg_color');

// remove "special" if the listing is sold
if(!empty($sold)) {
	delete_post_meta(get_the_ID(), 'special_car');
}

$badge_text = get_post_meta(get_the_ID(),'badge_text',true);
$special_car = get_post_meta(get_the_ID(),'special_car', true);

if(empty($badge_text)) {
	$badge_text = esc_html__('Special', 'motors');
}

$badge_style = '';
$badge_bg_color = get_post_meta(get_the_ID(),'badge_bg_color',true);

if(!empty($badge_bg_color)) {
	$badge_style = 'style=background-color:'.$badge_bg_color.';';
}

if(empty($sold) && !empty($special_car) && $special_car == 'on'): ?>

	<div class="special-label special-label-small h6" <?php echo esc_attr($badge_style); ?>>
		<?php stm_dynamic_string_translation_e('Special Badge Text', $badge_text ); ?>
	</div>

<?php elseif(stm_sold_status_enabled() && !empty($sold)): ?>
	<?php $badge_style = 'style=background-color:' . $sold_badge_color . ';'; ?>
	<div class="special-label special-label-small h6" <?php echo esc_attr($badge_style); ?>>
		<?php _e('Sold', 'motors') ?>
	</div>

<?php endif; ?>