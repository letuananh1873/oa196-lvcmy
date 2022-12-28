<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php
/**
 * Get the items in the shopping cart to see if there is an item that is backorder, this email will be the backorder email 
*/
$order_items = $order->get_items();

$onbackorder = false;
$esd = '1-1-1970';

foreach($order_items as $key => $order_item) {
	$prd_id = $order_item->get_product_id();
	$prd = wc_get_product($prd_id);
	$prd_stock_num = $prd->get_stock_quantity();
	$prd_stock = get_post_meta( $prd_id, '_stock_status', true );
	$prd_manage_stock = $prd->managing_stock();
	$prd_type = $prd->get_type();
	if($prd_stock == 'onbackorder') {
		$prd_esd = strtr(apply_filters('get_esd_acf', $prd_id), '/', '-');
		if($prd_manage_stock) {
			if($prd_stock_num < 0 && !empty($prd_esd)) {
				$onbackorder = true;
			}	
		} else {
			if(!empty($prd_esd)) {
				$onbackorder = true;
			}
		}
		if(strtotime($esd) < strtotime($prd_esd)) {
			$esd = date($prd_esd);
		}
	}

}

$GLOBALS['esd'] = [
	'esd' => $esd,
	'is_backorder' => $onbackorder
];
?>
<?php

	do_action( 'woocommerce_email_order_header_shipped', $order );	

$Titems = $order->get_items();




	// estimate infor

	do_action('oa_estimate_order_shipped_email',$order);

	// billing, shipping
	do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );
	// shiping method, payment method
	//do_action('oa_shiping_payment_order_shipped_email',$order);
	
	// order detail
	do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

	

	

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */




/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */

/**
 * Show user-defined additonal content - this is set in each email's settings.
 */

if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
// email footer
do_action('oa_footer_email_shipped',$order);


