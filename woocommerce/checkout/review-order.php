<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<table class="shop_table woocommerce-checkout-review-order-table">
	<thead>
		<tr>
			<th class="product-name" colspan="2"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-total"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			
			if (isset($cart_item['variation']['attribute_pa_your-engraving-message'])) {
		        $message = $cart_item['variation']['attribute_pa_your-engraving-message'] ?? '';
		        
		        if (empty($message)) {
		           unset($cart_item['variation']);                 
		        }
		    }
    		$product_id = $cart_item['product_id'];
			if (check_product_in_diamond($product_id)) {

				// unset($cart_item['variation']['attribute_pa_shapes']);
				// unset($cart_item['variation']['attribute_pa_diamond-type']);
				// unset($cart_item['variation']['attribute_pa_casing']);
				// unset($cart_item['variation']['attribute_pa_metal-type']);

			}
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				//var_dump($cart_item['data']);
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
					<td class="product-thumbnail">
						<?php
							echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
						?>
					</td>
					<td class="product-name">
						<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php //var_dump($cart_item['variation']); ?>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<div class="engagement-rings-infor show_mobile">
							<?php echo html_meta_centerstone_item_cart($product_id,'0'); ?>
						</div>
						
					</td>
					<td class="product-total">
						<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</td>
				</tr>
				<?php echo html_meta_centerstone_item_cart($product_id,1); ?>

				
				<?php
			}
		}

		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</tbody>
	<tfoot>
		
		<tr class="cart-coupon">
			<td colspan="3">
				<!-- <form class="checkout_coupon woocommerce-form-coupon" method="post" style="width:100%;"> -->
					<div class="checkout_coupon woocommerce-form-coupon">
					<p style="margin-bottom: 10px;">Promo Code</p>
					
					<div class="form-container coupon-trigger">
						<p class="form-row form-row-first" >
							<input type="text" name="coupon_code" class="input-text input-coupon" placeholder="Enter Promo Code" id="coupon_code" value="" />
						</p>

						<p class="form-row form-row-last" >
							<button id="btn_apply_coupon" type="submit" class="button" name="apply_coupon" data-newcustomer="<?php echo coupon_code_order_first(); ?>" value="<?php //esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>">
								<i class="fas fa-chevron-down"></i>
							</button>
						</p>
					</div>
					
					<div class="desc_for_coupon">
					<?php echo do_shortcode( '[elementor-template id="13336"]' ); ?>
					</div>

					<div class="clear"></div>
					</div>
				<!-- </form> -->


				<div class="coupons">
				<?php do_action('add_list_coupon'); ?>
				</div>

			</td>
		</tr>

		<tr class="cart-subtotal">
			<th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
			<td colspan="2"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>
		<tr>
			<td colspan="3" class="wrapper-coupon">
				<?php echo html_list_coupon_applied(); ?>
			</td>
		</tr>

		

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th><?php echo esc_html( $fee->name ); ?></th>
				<td colspan="2"><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited ?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<th><?php echo esc_html( $tax->label ); ?></th>
						<td colspan="2"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
					<td colspan="2"><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<tr class="order-total">
			<th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			<td colspan="2"><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table>
