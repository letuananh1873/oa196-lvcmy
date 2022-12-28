<?php
/**
 * Email Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-addresses.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 6.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$text_align = is_rtl() ? 'right' : 'left';
$address    = $order->get_formatted_billing_address();
$shipping   = $order->get_formatted_shipping_address();

$orders_meta = $order->get_meta_data();
$isset_gift_card_message = false;
$gift_card_message = "";
$store_id = "";
$store_title = "";
$shipping_method = "";
$array_order_item_shipping = $order->get_data()["shipping_lines"];
if(count($array_order_item_shipping) > 0){ 
	$shipping_method = array_pop($array_order_item_shipping)->get_method_id();
} 
foreach($orders_meta as $meta){
	$data = $meta->get_data();
	if($data["key"] == "gift_card" && $data["value"] == "yes"){
		$isset_gift_card_message = true;
	}
	if($data["key"] == "note_gift_card"){
		$gift_card_message = $data["value"];
	}
	if($data["key"]== "store"){
		$store_id = (int)$data["value"];
		$store_title = get_the_title($store_id);
		$store_content = apply_filters( 'the_content',get_the_content(null,false,$store_id));
	}
} 
?><table id="addresses" cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top; margin-bottom: 0; padding:0;" border="0">
	<tr>
		<td colspan="2" style="padding:5px;"></td>
	</tr>
	<?php if($order->get_status() != "completed"): ?>
	<tr>
		<td colspan="2" style="width: 100%;text-align:<?php echo esc_attr( $text_align ); ?>; font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; border:0; padding:0" valign="top" width="100%">
			<h2 style="color:#ad073d;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;text-align:center;">CUSTOMER INFORMATION</h2>			
		</td>
	</tr>
	<?php endif; ?>
	<tr>
		
		
		<?php if($order->get_status() === "completed"): 
		// $type_delivery = get_field('select_type_delivery',$order->get_id())??'';	
		// if (empty($type_delivery)) {
		// 	$type_delivery = get_type_delivery_in_backend($order);
		// }
		$type_delivery = get_type_delivery_in_backend($order);
			if ($type_delivery == 'in-house'):
				$text_align = 'center';
			endif;		
			if ($type_delivery !== 'in-house'):
			?>
		<td valign="top" width="50%" style="border-color:transparent;text-align:left;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;border:0;padding:0">
			<h2 style="color:#000000;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">Shipping Details:</h2>
					
			<?php
			//if (oa_get_shipping_method($order)['method_id'] != 'local_pickup') {				
				$company_name = '';
				$tracking = '';
				$link_company = '';
				if ($type_delivery == '3p' || $type_delivery == 'store-collection'){
					echo '<p style="margin-bottom:10px;">Order Number: '.$order->get_order_number().'</p>';
					
					$order_id = $order->get_id();
					
					//$enable_delivery = get_post_meta($order_id,'enable_delivery_manual',true) ??false;
					$enable_delivery = $_POST['acf']['field_620cc875a9a92']??'';
					if ($enable_delivery === '1'){
						$key_acf_carrier_information = get_acf_key('carrier_information');
						$carrier_information = $_POST['acf'][$key_acf_carrier_information]['row-0'];
						$name = $carrier_information['field_61e8bccf6de37']??'';
						$tracking = $carrier_information['field_61e8bcc46de36']??'';					        
						$link_company = $carrier_information['field_61ef76aae51ee']??'';
						if (!empty($tracking)) echo '<p style="margin-bottom:10px;">Tracking Number: '.$tracking.'</p>';
						if (!empty($name) && empty($link_company)) echo '<p style="margin-bottom:10px;">Shipping Company: '.$name.'</p>';
						if (!empty($link_company)) {
							echo '<p style="margin-bottom:10px;">Shipping Company: <a href="'.$link_company.'">'.$name.'</a></p>';
						}

						// if ($type_delivery == 'store-collection') {
						// 	echo '<p style="margin-bottom:10px;"><a href="/">Track your order</a></p>';
						// }
					
				
				} else {
					$tracking_number = trim(get_post_meta($order_id,'skj_shippit_tracking_id',true)) ??'';
					$tracking = get_post_meta($order_id,'skj_shippit_tracking_number',true) ??'';
					$name = get_post_meta($order_id,'skj_shippit_company',true) ??'';
					$tracking_url = get_post_meta($order_id,'shippit_tracking_id_url',true) ??'';
					if (!empty($tracking_number) && (empty($tracking) || empty($name) || empty($tracking_url))) {
						
						
						// woo_order_status_change_custom($order_id,$old_status,'processing');
						$name = skj_shippit_get_shipping_company($tracking_number)->courier_type;
						$tracking = skj_shippit_get_shipping_company($tracking_number)->courier_job_id;
					   $trackings  = skj_shippit_get_tracking_url($tracking_number); 
						   $shippit_updated = get_post_meta($order_id,'shippit_tracking_updated',true)??'';
						   $shippit_updated = '';
						   if ($shippit_updated !== 'updated') {
							   $tracking_url = $trackings -> tracking_url; 
							   update_post_meta($order_id,'skj_shippit_company',$name);
							   update_post_meta($order_id,'shippit_tracking_id_url',$tracking_url);
							   update_post_meta($order_id,'skj_shippit_tracking_number',$tracking);
							   //update_post_meta($order_id,'shippit_tracking_updated','updated');
			   
						   }        
						
					}
					if (!empty($tracking) && empty($tracking_url)) echo '<p style="margin-bottom:10px;">Tracking Number:  '.$tracking.'</p>';
					if (!empty($tracking_url)) {
						echo '<p style="margin-bottom:10px;">Tracking Number:  <a href="'.$tracking_url.'">'.$tracking.'</a></p>';
					}

				if (!empty($name)) echo '<p style="margin-bottom:10px;">Shipping Company: '.$name.'</p>';
			}

}
			?>
		</td>
		<?php endif; ?>
		<?php else: ?>
		<td style="text-align:<?php echo esc_attr( $text_align ); ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;width:50%" valign="top" >
			<h2 style="color:#000000;"><?php esc_html_e( 'Billing address', 'woocommerce' ); ?></h2>

			<address class="address">
				<?php echo wp_kses_post( $address ? $address : esc_html__( 'N/A', 'woocommerce' ) ); ?>
				<?php if ( $order->get_billing_phone() ) : ?>
					<br/><?php echo esc_html( $order->get_billing_phone() ); ?>
				<?php endif; ?>
				<?php if ( $order->get_billing_email() ) : ?>
					<br/><?php echo esc_html( $order->get_billing_email() ); ?>
				<?php endif; ?>
			</address>
		</td>
	<?php endif; ?>
		<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && $shipping ) { ?>
			<?php
			$type_delivery = get_field('select_type_delivery',$order->get_id())??'';	
			if ($type_delivery == 'in-house'):
				$text_align = 'center';
			endif;	
			?>
			<td style="text-align:<?php echo esc_attr( $text_align ); ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; padding:0;width:50%;padding-left:30px;" valign="top" >

				<h2 style="color:#000000; text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Shipping address', 'woocommerce' ); ?></h2>

				<address class="address"><?php echo wp_kses_post( $shipping ); ?>
					<?php if ( $order->get_meta("_shipping_phone") ) : ?>
						<br/><?php echo esc_html( $order->get_meta("_shipping_phone") ); ?>
					<?php endif; ?>
				</address>
			</td>
		<?php } else if($shipping_method == "local_pickup"){ ?> 
			<td style="text-align:<?php echo esc_attr( $text_align ); ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; padding:0;width:50%;" valign="top" >
				<h2  style="color:#000000;"><?php esc_html_e( 'Selected Store', 'woocommerce' ); ?></h2> 
				<address class="address" style="padding-top:0;">
					<?php echo wp_kses_post( $store_title ); ?>
					<?php echo $store_content; ?>
				</address>
			</td>
		<?php } ?>
	</tr> 
		<?php if($isset_gift_card_message): ?>
		<tr>
			<td style="text-align:<?php echo esc_attr( $text_align ); ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; padding:0;" valign="top" width="50%">
				<h2 style="margin-top:40px;color:#000000;"><?php esc_html_e( 'Gift card message', 'woocommerce' ); ?></h2>

				<address class="address"><?php echo wp_kses_post( $gift_card_message ); ?></address>
			</td>
		</tr>
		<?php endif; ?> 
	<?php 
	if($order->get_status() === "completed"):
		$enable_delivery = $_POST['acf']['field_620cc875a9a92']??'';
		if ($enable_delivery === '1'){
		$key_select_type_delivery = get_acf_key('select_type_delivery');
		$type_delivery = $_POST['acf'][$key_select_type_delivery];
		$key_acf_carrier_information = get_acf_key('carrier_information');
		$carrier_information = $_POST['acf'][$key_acf_carrier_information]['row-0'];
		$tracking_link_order = $carrier_information['field_61ef76cde51ef']??'';		

		if ($type_delivery == '3p' || $type_delivery == 'store-collection') {
		if (!empty($tracking_link_order)):
			echo '<tr>';
			echo '<td colspan="2" style="text-align:center;padding-bottom:30px;" width="100%">';
			echo '<a href="'.$tracking_link_order.'" style="background:#AD073D;color:#ffffff;display:inline-block;padding:15px 30px;border-radius:0px;text-decoration:none;">Track your order</a>';
			echo '</td>';
			echo '</tr>';

		

	endif;
}
} else {

		$key_select_type_delivery = get_acf_key('select_type_delivery');
		$type_delivery = $_POST['acf'][$key_select_type_delivery]??'';

		$order_id = $order->get_id();		
		$tracking_link_order = get_post_meta($order_id,'shippit_tracking_id_url',true) ??''	;			
		if ($type_delivery == '3p' || $type_delivery == 'store-collection') {
		if (!empty($tracking_link_order)):
			echo '<tr>';
			echo '<td colspan="2" style="text-align:center;padding-bottom:30px;" width="100%">';
			echo '<a href="'.$tracking_link_order.'" style="background:#AD073D;color:#ffffff;display:inline-block;padding:15px 30px;border-radius:0px;text-decoration:none;">Track your order</a>';
			echo '</td>';
			echo '</tr>';

		

	endif;
	}
}
	endif;
	?>

		
</table>
