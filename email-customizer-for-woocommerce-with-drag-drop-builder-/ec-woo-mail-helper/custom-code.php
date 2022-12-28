<?php
/**
 * Custom code shortcode
 *
 * @var $order WooCommerce order
 * @var $email_id WooCommerce email id (new_order, completed_order,etc)
 * @var $attr array custom code attributes
 *
 * IMPORTANT NOTE:
 * After adding custom shortcode, you will not see the result during customizing,
 * If you want to test it, just click 'Preview' button (the first button in the top-right menu in the builder interface)
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/* custom email template */

//////////////////////////////// main content email //////////////////////////

// Example for the short code [ec_woo_custom_code type="demo-purchase"]
if(isset($attr['type']) && $attr['type'] == 'custom-shipping'){
$email = (isset($email) ? $email : '');
$ec_woo_settings_border_padding = get_option('ec_woo_settings_border_padding', EC_WOO_BUILDER_BORDER_PADDING);
$ec_woo_settings_image_width = get_option('ec_woo_settings_image_width', EC_WOO_BUILDER_IMG);
$ec_woo_settings_image_height = get_option('ec_woo_settings_image_height', EC_WOO_BUILDER_IMG);
$ec_woo_settings_show_image = get_option('ec_woo_settings_show_image', EC_WOO_BUILDER_SHOW_IMAGE);
$ec_woo_settings_show_sku = get_option('ec_woo_settings_show_sku', EC_WOO_BUILDER_SHOW_SKU);
$ec_woo_settings_rtl = get_option('ec_woo_settings_rtl', EC_WOO_BUILDER_RTL);
$ec_woo_settings_show_meta = get_option('ec_woo_settings_show_meta', EC_WOO_BUILDER_SHOW_META)==1?true:false;
$items = $order->get_items();
$GLOBALS['order'] = $order;
$args = array(
    'order' => $order,
    'items' => $items,
    'show_download_links' => $order->is_download_permitted(),
    'show_sku' => $ec_woo_settings_show_sku,
    'show_purchase_note' => $order->is_paid(),
    'show_image' => $ec_woo_settings_show_image == '1' ? true : false,
    'image_width' => $ec_woo_settings_image_width,
    'image_height' => $ec_woo_settings_image_height,
    'rtl' => $ec_woo_settings_rtl
);

//$path_order_item = EC_WOO_BUILDER_PATH . '/templates/ec-woo-mail-helper/order-items-rows-4.php';
$a = '/email-customizer-for-woocommerce-with-drag-drop-builder/ec-woo-mail-helper/order-items-rows-4';
//$path_order_item = get_template_part( $a);
if ($ec_woo_settings_show_meta) {
    if ( ! $sent_to_admin && 'bacs' === $order->get_payment_method() && $order->has_status( 'on-hold' ) ) {$gateways = new WC_Payment_Gateways();

        $payment_gateways = $gateways->get_available_payment_gateways();
        foreach($payment_gateways as $gateway_id => $gateway):
            if($gateway_id === 'bacs'):
                $instructions = $gateway->instructions;
                $account_details = $gateway->account_details;
                if ( $instructions ) {
                    echo wp_kses_post( wpautop( wptexturize( $instructions ) ) . PHP_EOL );
                }
                foreach($account_details as $account_detail) :
                ?>
                    <section class="woocommerce-bacs-bank-details"><h2 class="wc-bacs-bank-details-heading" style="color: #c9e4bb; display: block; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 18px; font-weight: bold; line-height: 130%; margin: 0 0 18px; text-align: left;">Our bank details</h2>
                    <!-- <h3 class="wc-bacs-bank-details-account-name" style="color: #c9e4bb; display: block; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 16px; font-weight: bold; line-height: 130%; margin: 16px 0 8px; text-align: left;">Love &amp; Co. Sdn Bhd:</h3> -->
                    <ul class="wc-bacs-bank-details order_details bacs_details" style="padding-left: 20px">
                        <li class="bank_name">Account Name: <strong><?php echo $account_detail['account_name']; ?></strong> </li>
                        <li class="bank_name">Bank: <strong><?php echo $account_detail['bank_name']; ?></strong> </li>
                        <li class="account_number">Account number: <strong><?php echo $account_detail['account_number']; ?></strong></li>
                        <li class="bic">BIC: <strong><?php echo $account_detail['bic']; ?></strong></li>
                    </ul>
                    </section>
                <?php
                endforeach;
            endif;
        endforeach;
    }
}

// if ($ec_woo_settings_show_meta) {
//   do_action( 'woocommerce_email_before_order_table', $order, '', '', $email);
// }
?>
 <table class="woo-items-list-4"
           cellspacing="0"
           cellpadding="<?php echo $ec_woo_settings_border_padding; ?>"
           style="width: 100% !important;font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;"
           border="0">
        <thead>
        <tr>
            <td style="padding-bottom:0px;padding-top:30px;font-size:16px;text-align:left;" colspan="2">
                <strong>Product Details</strong>
            </td>
        </tr>
        </thead>
        <tbody style="padding-left:15px;padding-right: 15px;">            
        <?php
        get_template_part( $a);
        ?>
        </tbody>

    </table>
    <table class="woo-items-list-4-total" width="100%" cellpadding="0" border="0" cellspacing="0" style="width:100%;">  
    <tr><td colspan="2" style="padding:10px;"></td> </tr>      
        <?php
        $total_values = $order->get_order_item_totals();
        if (isset($total_values)) {
            // foreach ( $total_values as $key_total => $total ) {
            //         if ($key_total == 'payment_method') {
            //             unset($total_values[$key_total]);
            //         }
            //     }
            $index = 0;
            foreach ($total_values as $key => $item) {
               // var_dump($key);
                $font_weight = 'font-weight:normal;';
                if ($key =='order_total') {
                    $font_weight = 'font-weight:bold;';
                }

                
                $index++; ?>
                <tr>
                        <td class="col-total-label" scope="row" width="55%" colspan="2"
                            style="text-align: left;    color: #606060;  font-size: 15px;font-family: sans-serif;  <?php echo $font_weight; ?>  padding-top: 0px;  padding-bottom: 5px;  padding-left: 20px;letter-spacing: 0.5px; vertical-align: top;">
                            <?php if ($key == 'shipping') {
                                echo 'Delivery:';
                            } else {
                                echo $item['label'];
                            } 
                            
                            ?>
                            
                        </td>
                        <td class="col-total-value" width="45%"
                            style="text-align: right; color: #262626; padding-right: 20px; font-family: Helvetica, sans-serif;font-size: 15px;<?php echo $font_weight; ?> vertical-align: top;">
                            <?php 
                            if ($key == 'shipping') {
                                echo '<div style="color:#BAE0CC">';
								$order = $this->order;
								if( $order->has_shipping_method('flat_rate') ) { 
									/*$order_id = $this->order->get_id();
									$id_store = get_post_meta($order_id,'select_store',true);*/
                                    echo '$'.number_format(oa_get_shipping_method($order)['total'],2);
									
								} else {
                                    echo '<strong>FREE</strong>';
                                }
                                echo '</div>';
										
						  }  else if ($key == 'discount'){
                                    // Retrieving the coupon ID
                                    
                                    //$coupon = new WC_Coupon($coupon_id);
                                    $coupons = $order->get_items( 'coupon' );
                                   
                                    foreach ( $coupons as $item_id => $item ) :
                                        echo '<p style="margin-top:0;margin-bottom:5px;">';
                                        echo '&lt;'.strtoupper( $item->get_code() ).'&gt; ';
                                        
                                        echo wc_price( $item->get_discount(), array( 'currency' => $order->get_currency() ) ) ;
                                        echo '</p>';
                                    endforeach;

                                    
                            } else { echo $item['value']; } ?>

                        </td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
    <?php if ($ec_woo_settings_show_meta) {
    do_action('woocommerce_email_after_order_table', $order, '', '', $email);
    } ?>
<?php

}

if(isset($attr['type']) && $attr['type'] == 'get-reset-password-url') {
    $user_id = get_current_user_id();
    
    ?>
        <a href=""><Strong>Reset Password</Strong></a>
    <?php
}

/* emma */
//[ec_woo_custom_code type="view_order"]
if(isset($attr['type']) && $attr['type'] == 'view_order') {    
    $order_url = $order->get_view_order_url();
    echo '<a href="'.$order_url.'" style="display:inline-block; margin-bottom:30px;background:#9CD5BC; color:#000000;font-size:16px;padding-left:40px;padding-right:40px;padding-top:7px;padding-bottom:7px;font-weight:bold;">View your order</a>'; 
}

if(isset($attr['type']) && $attr['type'] == 'lvc_heading_email') {    
   // ob_start();
    ?>

<table cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color:rgb(255,255,255);border-spacing:0;border-collapse:collapse;table-layout:fixed;margin:0 auto">
    <tbody dir="ltr">
        <tr><td style="padding:10px;"></td> </tr>  
        <tr dir="ltr">               
            <td align="center" bgcolor="" background="" valign="top" style="">       
               <p style="font-size:25px; margin-top:0;margin-bottom:5px;line-height:25px;"><strong>Hi <?php echo $order->get_shipping_first_name(); ?>,</strong></p>                  
              <?php
             
                   $content_header_processing = get_field('processing_order_content_header','option');
                   if( $order->has_shipping_method('local_pickup') ) { 
                    $content_header_processing = get_field('processing_order_content_header_collection','option');
                   }
                   $order_number = $order->get_order_number();
                    $content_header_processing = str_replace('{{order_number}}', $order_number,$content_header_processing);
                    echo $content_header_processing;
                
              
               ?>                
            <p style="text-align:center;"><a href="<?php echo $order->get_view_order_url(); ?>" style="display:inline-block; margin-bottom:0px;background:#9CD5BC; color:#000000;font-size:16px;padding-left:40px;padding-right:40px;padding-top:7px;padding-bottom:7px;font-weight:bold;text-decoration: none;">View your order</a></p>
        
        </td>
    </tr>
    <tr>
        <td width="100%">
            <h2 style="background:#9CD5BC;margin-top:0;margin-bottom: 20px;color:#000000;text-align: center;padding-top:15px;padding-bottom:15px;font-size:28px;">
            YOUR ORDER CONFIRMATION
            </h2>
            <table width="100%">
                <tr>
                    <td style="padding-left:20px;">
                        <p style="font-size:14px;color:#000000;margin-top:0;margin-bottom:0;"><strong>Order Number:</strong></p>
                        <p style="font-size:14px;color:#999999;margin-top:0;margin-bottom:0;">#<?php echo $order->get_order_number(); ?></p>
                    </td>
                    <td style="font-size:14px;">
                        <p style="font-size:14px;color:#000000;margin-top:0;margin-bottom:0;"><strong>Order Placed On:</strong></p>
                        <p style="font-size:14px;color:#999999;margin-top:0;margin-bottom:0;"> 
                            <?php 
                            $order_date_create = $order->get_date_created();
                            echo mysql2date( 'd F Y', $order_date_create );
                            ?>
                        </p>
                    </td>
                   
                        <td style="font-size:15px;">
                        <p style="font-size:14px;color:#000000;margin-top:0;margin-bottom:0;"><strong>                        
                        <?php
                        if( $order->has_shipping_method('local_pickup') ) {
                             echo 'Estimated Collection Date:';
                        } else {
                            echo 'Estimated Delivery Date:';
                        }
                        ?>
                    </strong></p>
                        <p style="font-size:14px;color:#999999;margin-top:0;margin-bottom:0;"><?php echo oa_estimate_delivery($order); ?></p>
                    </td>
                   
                </tr>
               
            </table>

            
        </td>
    </tr>
</tbody>
</table>
    <?php
   
}



if(isset($attr['type']) && $attr['type'] == 'processing_customer_infor') {    
   // ob_start();
    ?>

<?php


$text_align = is_rtl() ? 'right' : 'left';
$address    = $order->get_formatted_billing_address();
$shipping   = $order->get_formatted_shipping_address();
$orders_meta = $order->get_meta_data();
$isset_gift_card_message = false;
$gift_card_message = "";
$store_id = "";
$store_title = "";
$store_content = '';
$shipping_method = "";
$array_order_item_shipping = $order->get_data()["shipping_lines"];
if(count($array_order_item_shipping) > 0){ 
    $shipping_method = array_pop($array_order_item_shipping)->get_method_id();
} 
foreach($orders_meta as $meta){
    $data = $meta->get_data();   
   // var_dump($data);
    if($data["key"]== "select_store"){
        $store_id = (int)$data["value"];
        $store_title = get_the_title($store_id);
       // $store_content = apply_filters( 'the_content',get_the_content(null,false,$store_id));
        $store_content = get_field('store_address',$store_id);
            }
} 
?><table id="addresses" cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top; margin-bottom: 0; padding:0;" border="0">
    <tr>
        <td colspan="2" style="width: 100%;text-align:<?php echo esc_attr( $text_align ); ?>; font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;vertical-align: top;font-size:px;" valign="top" width="100%">

            <?php 
            $delivery_content_detail='';
           $delivery_content = get_field('estimated_processing_mail','option')??array();
                if (is_array($delivery_content) && count($delivery_content) > 0) {
                    $delivery_content_detail = $delivery_content['estimated_delivery']??'';
                    if( $order->has_shipping_method('local_pickup') ) {  
                        $delivery_content_detail = $delivery_content['estimated_collection']??'';
                    }    
                }
            echo $delivery_content_detail;
            
             ?>
                     
        </td>
    </tr>  
    <tr>
        <td colspan="2" style="padding:10px;width:100%;">
            <hr>
        </td>
    </tr>
     <?php if($email->id == "customer_shipped_order"): ?>
        <tr>
        <td colspan="2" style="width: 100%;text-align:<?php echo esc_attr( $text_align ); ?>; font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;vertical-align: top;padding-top:0px;font-size:15px;" valign="top" width="100%">
            <?php echo get_field('content_shipped_footer','option');  ?>      
        </td>
    </tr>

    <?php else: ?>
    <tr>
        <td colspan="2" style="width: 100%;text-align:<?php echo esc_attr( $text_align ); ?>; font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;vertical-align: top;padding-top:0px;" valign="top" width="100%">
            <h2 style="color:#000000;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;text-align:center;">YOUR CONTACT INFORMATION:</h2>          
        </td>
    </tr>
    
    <tr>
        <td style="width: 100%;text-align:<?php echo esc_attr( $text_align ); ?>; font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;vertical-align: top;font-size:px;" valign="top">
            <p style="margin:0;font-size:15px;font-weight:300;color:#000000;">Name & Contact:</p>
            <p style="margin:0; color:#999999;font-size:14px;">
                <?php echo $order->get_billing_first_name(); ?>
                <?php echo $order->get_billing_last_name(); ?>
            </p>
            <p style="margin:0;color:#999999;font-size:14px;">
                <?php if ( $order->get_billing_phone() ) : ?>
                    <?php echo esc_html( $order->get_billing_phone() ); ?>
                <?php endif; ?>
            </p>
        </td>
        
         <td style="width: 100%;text-align:<?php echo esc_attr( $text_align ); ?>; font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;vertical-align: top;font-size:px;" valign="top">
            <p style="margin:0;font-size:15px;font-weight:300;color:#000000;">Email:</p>
            <p style="margin:0;color:#999999;font-size:14px;">
                <?php if ( $order->get_billing_email() ) : ?>
                    <?php echo esc_html( $order->get_billing_email() ); ?>
                <?php endif; ?>
            </p>
        </td>
    </tr>
    <tr><td colspan="2" style="padding:10px;"></td> </tr>
    <tr>
        <td style="width: 100%;text-align:<?php echo esc_attr( $text_align ); ?>; font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;vertical-align: top;font-size:px;" valign="top">
            <p style="margin:0;font-size:15px;font-weight:300;color:#000000;">Billing Address:</p>
            <p style="margin:0;color:#999999;font-size:14px;">
                <?php echo $order->get_formatted_billing_address(); ?>
            </p>
        </td>
         <td style="width: 100%;text-align:<?php echo esc_attr( $text_align ); ?>; font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;vertical-align: top;font-size:px;color:#999999;" valign="top">
            <?php if( $order->has_shipping_method('local_pickup') ) {  ?>
                <p style="margin:0;font-size:15px;font-weight:300;color:#000000;">Store Address:</p>
                <p style="margin:0;color:#000000;font-size:14px;"><?php echo $store_title; ?></p>
                <p style="margin:0;color:#999999;font-size:14px;"><?php echo  $store_content; ?></p>
            <?php } else { ?>
                <p style="margin:0;font-size:15px;font-weight:300;color:#000000;">Shipping Address:</p>
                <p style="font-size:14px;color:#999999;margin:0;"><?php echo $shipping; ?></p>
           <?php } ?>

            
        </td>
    </tr>
    <tr><td colspan="2" style="padding:10px;"></td> </tr>
    <tr>
        <td style="width: 100%;text-align:<?php echo esc_attr( $text_align ); ?>; font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;vertical-align: top;font-size:px;" valign="top">
            <p style="margin:0;font-size:15px;font-weight:300;color:#000000;">Payment Method:</p>
            <p style="margin:0;color:#999999;font-size:14px;"><?php echo $order->get_payment_method_title(); ?></p>
        </td>
         <td style="width: 100%;text-align:<?php echo esc_attr( $text_align ); ?>; font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;vertical-align: top;font-size:px;" valign="top">
            
        </td>
    </tr>  
    <?php endif; ?>
    <tr><td colspan="2" style="padding:15px;"></td> </tr>
    <tr>
       <td colspan="2" style="font-size:15px;width: 100%;text-align:center; font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;vertical-align: top;padding-top:0px;" valign="top" width="100%">
        <p>Thank you for shopping with us</p>
        <p></p>
        <p>For further assistance, please email us at <a href="mailto:info@love-and-co.com" style="text-decoration:underline;color:#9CD5BC;">info@love-anad-co.com</a></p>  
        </td>
    </tr>      
</table>
    <?php } ?>

<!-- /////////////////////////////// Footer ///////////////////////////////////// -->

    <?php if(isset($attr['type']) && $attr['type'] == 'email_footer') {  ?>

        <table border="0" cellpadding="10" cellspacing="0" style="width: 100%; vertical-align: top; margin-bottom: 0; padding:0;" id="template_footer2">
        <tr>
            <td style="background:#BAE0CC;color:#ffffff;width:50%;text-align: left;border-radius:0;padding:5px 10px 5x 10px;">Copyright @ <?php echo date("Y"); ?> Love & Co. All Rights Reserved.</td>
            <td style="background:#BAE0CC;color:#ffffff;width:50%;text-align: right;border-radius:0;padding:5px 10px 5x 10px;">
               
                <a  href="https://www.facebook.com/L0veandC0"><img style="margin-right:0;margin-left:10px;" width="25" height="25" src="https://oanglelab.com/oa134-lvc/ebase-uploads/2022/02/face2.jpg" alt=""></a>
                <a href="https://www.instagram.com/accounts/login/?next=/loveandcoofficial/"><img style="margin-right:0;margin-left:10px;" width="25" height="25" src="https://oanglelab.com/oa134-lvc/ebase-uploads/2022/02/ins.jpg" alt=""></a>
                <a href="https://www.youtube.com/user/OfficialLVC"><img style="margin-right:0;margin-left:10px;" width="25" height="25" src="https://oanglelab.com/oa134-lvc/ebase-uploads/2022/02/ytb.jpg" alt=""></a>
            </td>
        </tr>
    </table>
   <?php }

   if(isset($attr['type']) && $attr['type'] == 'shipped_customer_infor') {  
   // ob_start();
    ?>
<table id="addresses" cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top; margin-bottom: 0; padding:0;" border="0">
    <tr>
        <td colspan="2" style="width: 100%;text-align:<?php echo esc_attr( $text_align ); ?>; font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;vertical-align: top;font-size:px;" valign="top" width="100%">

            <?php 
            $delivery_content_detail='';
            $delivery_content = get_field('estimated_shipped_mail','option')??array();
                if (is_array($delivery_content) && count($delivery_content) > 0) {
                    $delivery_content_detail = $delivery_content['estimated_delivery_shipped']??'';
                    if( $order->has_shipping_method('local_pickup') ) {  
                        $delivery_content_detail = $delivery_content['estimated_collection_shipped']??'';
                    }
                    
                }  
                echo $delivery_content_detail;
                
             ?>
                     
        </td>
    </tr>  
    <tr>
        <td colspan="2" style="padding:10px;width:100%;">
            <hr>
        </td>
    </tr>
     
        <tr>
        <td colspan="2" style="width: 100%;text-align:<?php echo esc_attr( $text_align ); ?>; font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;vertical-align: top;padding-top:0px;" valign="top" width="100%">
            <?php echo get_field('content_shipped_footer','option');  ?>      
        </td>
    </tr>
    <tr><td colspan="2" style="padding:15px;"></td> </tr>
    <tr>
       <td colspan="2" style="width: 100%;text-align:center; font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;vertical-align: top;padding-top:0px;" valign="top" width="100%">
        <p>Thank you for shopping with us</p>
        <p></p>
        <p>For further assistance, please email us at <a href="mailto:info@love-and-co.com" style="text-decoration:underline;color:#9CD5BC;">info@love-anad-co.com</a></p>   
        </td>
    </tr>      
</table>
    <?php } 

    

if(isset($attr['type']) && $attr['type'] == 'get-reset-password-url') {
    $user_id = get_current_user_id();
    
    ?>
        <a href=""><Strong>Reset Password</Strong></a>
    <?php
}

/* emma */
//[ec_woo_custom_code type="view_order"]
if(isset($attr['type']) && $attr['type'] == 'view_order') {    
    $order_url = $order->get_view_order_url();
    echo '<a href="'.$order_url.'" style="display:inline-block; margin-bottom:30px;background:#9CD5BC; color:#000000;font-size:16px;padding-left:40px;padding-right:40px;padding-top:7px;padding-bottom:7px;font-weight:bold;">View your order</a>'; 
}

if(isset($attr['type']) && $attr['type'] == 'vc_heading_email_shipped') {    
   // ob_start();
    ?>

<table cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color:rgb(255,255,255);border-spacing:0;border-collapse:collapse;table-layout:fixed;margin:0 auto">
    <tbody dir="ltr">
        <tr><td style="padding:10px;"></td> </tr>  
        <tr dir="ltr">               
            <td align="center" bgcolor="" background="" valign="top" style="">       
               <p style="font-size:25px; line-height:25px; margin-top:0;margin-bottom:5px;"><strong>Hi <?php echo $order->get_shipping_first_name(); ?>,</strong></p>                  
              <?php
              echo oa_woocommerce_email_order_header_shipped($order);
              ?>
        </td>
    </tr>
    <tr>
        <td width="100%">
            <h2 style="background:#9CD5BC;margin-top:0;margin-bottom: 20px;color:#000000;text-align: center;padding-top:15px;padding-bottom:15px;font-size:28px;">
            YOUR ORDER CONFIRMATION
            </h2>
            <table width="100%">
                <tr>
                    <td style="padding-left:20px;" align="top">
                        <p style="font-size:14px;color:#000000;margin-top:0;margin-bottom:0;"><strong>Order Number:</strong></p>
                        <p style="font-size:14px;color:#999999;margin-top:0;margin-bottom:0;">#<?php echo $order->get_order_number(); ?></p>
                    </td>
                    <td style="font-size:14px;" align="top">
                        <p style="font-size:14px;color:#000000;margin-top:0;margin-bottom:0;"><strong>Order Placed On:</strong></p>
                        <p style="font-size:14px;color:#999999;margin-top:0;margin-bottom:0;"> 
                            <?php 
                            $order_date_create = $order->get_date_created();
                            echo mysql2date( 'd F Y', $order_date_create );
                            ?>
                        </p>
                    </td>
                    
                    <td style="font-size:15px;" align="top">
                        <p style="font-size:14px;color:#000000;margin-top:0;margin-bottom:0;"><strong>                        
                        <?php
                        if( $order->has_shipping_method('local_pickup') ) {
                             echo 'Collection Date:';
                        } else {
                            echo 'Estimated Delivery Date:';
                        }
                        ?>
                    </strong></p>
                        <p style="font-size:14px;color:#999999;margin-top:0;margin-bottom:0;"><?php echo oa_estimate_delivery_shipped($order); ?></p>
                   </td>
                   
                </tr>               
                <tr><td style="padding:10px;"></td> </tr>
                <tr>
                    <?php 
                    // $shipping_label = 'Shipping Address:';
                    // $shipping_address = $order->get_formatted_shipping_address();
                    // if( $order->has_shipping_method('local_pickup') ) {
                    //     $shipping_label = 'Store Address:';
                    //     //$orders_meta = $order->get_data();
                    //     $orders_meta = $order->get_meta_data();                       
                    //     $store_title = get_store_infor($orders_meta)['store_title'];
                    //     $store_detail = get_store_infor($orders_meta)['store_cotent'];
                    //     $shipping_address = $store_title.'<br/>'.$store_detail;
                    // } 
                    $shipping_label = 'Shipping Address:';
                    $shipping_address = $order->get_formatted_shipping_address();
                    $tracking_number = '';
                    $tracking_company = '';
                    $shipping_address = $order->get_formatted_shipping_address();
                    if( $order->has_shipping_method('local_pickup') ) {
                        $shipping_label = 'Store Address:';
                       // $orders_meta = $order->get_meta_data();                       
                       // $store_title = get_store_infor($orders_meta)['store_title'];
                       // $store_detail = get_store_infor($orders_meta)['store_cotent'];
                      // $store_detail = get_field('store_address',$store_id);
                      $id_store = get_post_meta( $order->get_id(), 'select_store', true )??'';
                      if (!empty($id_store)) {
                        $store_title = get_the_title($id_store);
       
                        $store_detail = get_field('store_address',$id_store);
                        $shipping_address = $store_title.'<br/>'.$store_detail;
                      }
                     
                        //var_dump(get_store_infor($orders_meta));
                    } 


                    $key_select_type_delivery = get_acf_key('select_type_delivery');
                    $type_delivery = $_POST['acf'][$key_select_type_delivery];
				if ($type_delivery == '3p'){
                    $shipping_label = 'Tracking number:';
					
					$order_id = $order->get_id();
					$shipping_address = get_post_meta($order_id,'skj_shippit_tracking_number',true) ??'';
					$tracking_company = get_post_meta($order_id,'skj_shippit_company',true) ??'';
					$tracking_url = get_post_meta($order_id,'shippit_tracking_id_url',true) ??'';
					$enable_delivery = $_POST['acf']['field_620cc875a9a92']??'';
					if ($enable_delivery === '1'){
						$key_acf_carrier_information = get_acf_key('carrier_information');
						$carrier_information = $_POST['acf'][$key_acf_carrier_information]['row-0'];
						$tracking_company = $carrier_information['field_61e8bccf6de37']??'';
						$shipping_address = $carrier_information['field_61e8bcc46de36']??'';
                        $tracking_url = $carrier_information['field_61ef76cde51ef']??'';					        
				
				    } 
                }  
                $colspan = 2;
                if (!empty($tracking_company)) $colspan = 1;
                    ?>
                    <td colspan="<?php echo $colspan; ?>" style="padding-left:20px;" align="top">
                        <p style="font-size:14px;color:#000000;margin-top:0;margin-bottom:0;"><strong><?php echo $shipping_label; ?></strong></p>
                        <p style="font-size:14px;color:#999999;margin-top:0;margin-bottom:0;max-width:70%;"><?php echo $shipping_address; ?></p>
                        <?php if (!empty($tracking_url)) { ?>
                            <p style="font-size:14px;color:#999999;margin-top:0;margin-bottom:0;">
                            <!-- <strong style="font-size:14px;color:#000000;margin-top:0;margin-bottom:0;">Tracking URl:</strong>
                            <a style="text-decoration:underline;color:#9CD5BC;" href="<?php //echo $tracking_url; ?>">Track your order</a></p> -->
                           
                            <a style="text-decoration:underline;color:#9CD5BC;" href="<?php echo $tracking_url; ?>">Track your order</a></p>
                        <?php } ?>
                    </td>
                    <?php if (!empty($tracking_company)) { ?>
                        <td colspan="1" style="padding-left:0px;" align="top">
                        <p style="font-size:14px;color:#000000;margin-top:0;margin-bottom:0;"><strong>Shipping Company:</strong></p>
                        <p style="font-size:14px;color:#999999;margin-top:0;margin-bottom:0;"><?php echo $tracking_company; ?></p>
                        
                    </td>
                    <?php } ?>

                    <td style="font-size:14px;" align="top">
                        <p style="font-size:14px;color:#000000;margin-top:0;margin-bottom:0;"><strong>Order Status:</strong></p>
                        <p style="font-size:14px;color:red;margin-top:0;margin-bottom:0;"> 
                            <?php 
                           // $order_date_create = $order->get_date_created();
                           // echo mysql2date( 'd F Y', $order_date_create );
                            if( $order->has_shipping_method('local_pickup') ) {
                                echo 'Dispatched for Collection';
                            } else {
                                echo 'Out For Delivery';
                            }
                            ?>
                        </p>
                    </td>
                    
                </tr>
            
            </table>

            
        </td>
    </tr>
</tbody>
</table>
    <?php
   
}




