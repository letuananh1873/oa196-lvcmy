<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$text_align = is_rtl() ? 'right' : 'left';

do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>

<h2 style="text-align: center; margin-bottom:0px;padding-top:20px;">
	<?php
	if ( $sent_to_admin ) {
		$before = '<a class="link" href="' . esc_url( $order->get_edit_order_url() ) . '">';
		$after  = '</a>';
	} else {
		$before = '';
		$after  = '';
	}
	/* translators: %s: Order ID. */
	// echo wp_kses_post( $before . sprintf( __( '[Order #%s]', 'woocommerce' ) . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format( 'c' ), wc_format_datetime( $order->get_date_created() ) ) );
	if($order->get_status() === "shipped"){
		echo wp_kses_post( $before . sprintf( __( 'ITEMS IN THIS ORDER ', 'woocommerce' ) . $after ) );
	} else {
		echo wp_kses_post( $before . sprintf( __( 'ORDER SUMMARY ', 'woocommerce' ) . $after ) );
	}
	
	?>

</h2>

<div style="margin-bottom: 40px;padding-top:30px;">
	<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
				<tbody>
			<?php
			echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$order,
				array(
					'show_sku'      => $sent_to_admin,
					'show_image'    => false,
					'image_size'    => array( 32, 32 ),
					'plain_text'    => $plain_text,
					'sent_to_admin' => $sent_to_admin,
				)
			);
			?>

		</tbody>
		<tfoot>
			
			<tr>
				<td colspan="2" style="padding:10px;">
					
				</td>
			</tr>

			<?php
			
			$item_totals = $order->get_order_item_totals();
			$shipping_rate_id = '';
			foreach($order->get_items('shipping') as $item) {
				$shipping_rate_id = sprintf('%s:%s', trim($item->get_method_id()), trim($item->get_instance_id()));
			}
			$shipping_method = get_shipping_method_from_method_id($shipping_rate_id);

			if ( $item_totals ) {
				$i = 0;
				$esd = $GLOBALS['esd'];
				foreach ( $item_totals as $key_total => $total ) {
					if ($total['label'] == 'Payment method:') {
						unset($item_totals[$key_total]);
					}
				}
				foreach ( $item_totals as $total ) {					

					$shipping_text = strip_tags(wp_kses_post( $total['value'] ));
					$shipping_working_days = $shipping_method['shipping_working_days']??'';

					if($total['label'] == 'Shipping:'  && !$esd['is_backorder']) {
						$shipping_text = sprintf( '%s (%s)', strip_tags(wp_kses_post( $total['value'] )), $shipping_working_days);
					}
					
					$estimated_day_add = '';

					if($total['label'] == 'Shipping:' && $esd['is_backorder']) {
						if(!empty($esd['esd']) && $esd['esd'] != '1-1-1970') {
							$estimated_day_add = date( 'M d, Y' ,strtotime($esd['esd']));
							$shipping_text = $shipping_text . " <br>Estimated Shipping Date: ".$estimated_day_add;
						}
					} 
					
					?>
					
					
					<tr style="padding-top: 0;">
						<th class="td" scope="row" colspan="2" style="padding-top: 0;padding-bottom: 5px;text-align:<?php echo esc_attr( $text_align ); ?>; <?php echo ( 1 === $i ) ? 'border-top-width: 0px;' : ''; ?> vertical-align: top; border:none;"><?php echo wp_kses_post( $total['label'] ); ?></th>
						<td class="td" colspan="<?php echo $colspan; ?>" style="padding-top: 0;padding-bottom: 5px;text-align:<?php echo esc_attr( $text_align ); ?>; <?php echo ( 1 === $i ) ? 'border-top-width: 0px;' : ''; ?>; vertical-align: top; border: none;text-align:right;">
							<?php
							$shipping_method = oa_get_shipping_method($order)['method_id'];							
							if ($total['label'] == 'Shipping:') {
								if ($shipping_method != 'flat_rate') {
									$shipping_text = 'FREE';
								} else {
									$shipping_text = '$'.number_format(oa_get_shipping_method($order)['total']);
								}
								$shipping_text = '<span style="font-weight:bold; color:#AD073D;">'.$shipping_text.'</span>';

							}
							?>
							<?php echo $shipping_text; ?></td>
					</tr>
					<?php
				}
			}
			if ( $order->get_customer_note() ) {
				?>
				<tr>
					<th class="td" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
					<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
				</tr>
				<?php
			}
			?>
		</tfoot>
	</table>
</div>
<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>
