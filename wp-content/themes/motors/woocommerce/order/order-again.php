<?php
/**
 * Order again button
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-again.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

$listingId = 0;

if(stm_is_dealer_two()) {
	$listingId = get_post_meta( $order->get_id(), 'order_sell_online_car_id', true );
	$contactId = stm_me_get_wpcfto_mod('contact_us_page', '2080');
}
?>
<p class="order-again">
    <?php if($listingId): ?>
	    <a href="<?php echo esc_url( get_the_permalink($contactId) ); ?>" class="button"><?php esc_html_e( 'Contact Us', 'motors' ); ?></a>
    <?php else: ?>
        <a href="<?php echo esc_url( $order_again_url ); ?>" class="button"><?php esc_html_e( 'Order Again', 'motors' ); ?></a>
    <?php endif; ?>
</p>
