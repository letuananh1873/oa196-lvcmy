<?php
// GDEX 
add_action("woocommerce_order_status_changed","custom_gdex_order_completed",10,4);
function custom_gdex_order_completed($order_id,$from,$to,$order){ 
	
	if($from == "processing" && $to == "shipped"){
		// if(!$order->has_shipping_method("local_pickup")){
			WC()->mailer()->get_emails()["WC_Email_GDEX_Shipped_Order"]->trigger($order_id);
		// }
	}
	if($from != "processing" && $to == "processing"){      
		 if(!$order->has_shipping_method("local_pickup")){ 
			$gdex_consignment = new GDEX_Consignment($order);
			$gdex_consignment->create_consignment_order($order);
		 }
	} 
} 



add_menu_page('GD Express', 'GD Express', 'manage_options', 'gdex', 'my_magic_function');
function my_magic_function(){ 
	$args = array(
		'numberposts'    => 'limit',
		'post_type'      => 'shop_order',
		'post_status'    => 'processing', 
		'posts_per_page' => '-1',
		'paged'          => 'page',
	);
	// var_dump(wc_get_orders($args));
	$orders = wc_get_orders($args);
	$gdex_consignment = new GDEX_Consignment();
	// $gdex_consignment->cancel_consignment("TCN1001150");
	// var_dump($gdex_consignment->response_cancel_consignment);
	?>
	<table class="wp-list-table widefat fixed striped posts" id="gdex-orders">
	<thead>
		<tr >
		<th class="manage-column">ID</th>
		<th class="manage-column">Consignment Number</th>
		<th class="manage-column">Shipment Status</th>
		<th class="manage-column">Send Email</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$orders_tracking = array();
	

	foreach($orders as $order){
		$order_id = $order->get_id();
		$order_tracking = get_post_meta($order_id,"_order_tracking_id",true); 
		// $shipment_status = false; 
		$is_email_sent_gdex_shipped_order = get_post_meta($order_id,"_is_email_sent_gdex_shipped_order",true);
		$send_email_status = "waiting";
		if($is_email_sent_gdex_shipped_order == "1"){
			$send_email_status = "sent";
		}
		$consignment_note_status = get_post_meta($order_id,"_gdex_consignment_note_status",true);
		
		if($order_tracking){
			$orders_tracking[$order_id] = $order_tracking;			
		}
		?>
		<tr id="<?php echo "post_".$order_id; ?>">
		<td><?php echo $order_id; ?></td>
		<td><?php echo $order_tracking; ?></td>
		<td class="shipment_status"><?php echo $consignment_note_status; ?></td>
		<td class="send_email_status"><?php echo $send_email_status; ?></td>
		</tr>
		<?php
	}
	?></tbody></table>
	<?php  
	if(isset($_POST["submit"])){ 
		$shipments_status = $gdex_consignment->get_consignment_status_detail($orders_tracking); 
		?><p id="shipments_status" shipments-status='<?php echo json_encode($shipments_status); ?>' style="display:none;" ></p><?php
	}  ?>
	<form action="" method="post"> 
	<input type="submit" name="submit" class="button action" value="Update Status">
	</form>
	<?php


}

/**
 * validate checkout, validate postcode
 */
add_action("woocommerce_after_checkout_validation","gdex_woocommerce_after_checkout_validation",10,2);
function gdex_woocommerce_after_checkout_validation($data,$errors){ 
	$billing_postcode = $data["billing_postcode"];
	$gdex_consignment = new GDEX_Consignment();
	$validate_postcode = $gdex_consignment->validate_postcode($billing_postcode);
	if($validate_postcode === false){
		$errors->add("billing","<strong>Billing Post Code</strong> Invalid Postcode");
	}
}


if(isset($_GET) && isset($_GET["debug"])){
	add_action("wp_loaded","custom_after_theme_setup");
	function custom_after_theme_setup(){ 
		// echo preg_replace("/[^0-9\+]/","","123123 12312");
	
		// $order = wc_get_order(74585);
		// echo  get_post_meta(74585,"_shipping_phone",true);
	// // 	var_dump($order->has_shipping_method("local_pickup"));
		
	// $gdex_consignment = new GDEX_Consignment($order);
	// $gdex_consignment->create_consignment_order($order); 
	// $gdex_consignment->
	// var_dump($gdex_consignment->);
		// var_dump($order->get_items());
		// foreach($order->get_items() as $item){
		// 	if ( ! is_object( $item ) ) {
        //         continue;
        //       }
        //       if ( $item->is_type( 'line_item' ) ) {
		// 		$product        = $item->get_product();
		// 		var_dump($product);
		// 	}
		// }
	}
}