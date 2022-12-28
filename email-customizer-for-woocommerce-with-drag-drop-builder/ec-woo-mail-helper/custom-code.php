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

$path_order_item = EC_WOO_BUILDER_PATH . '/templates/ec-woo-mail-helper/order-items-rows-4.php';


?>
 <table class="woo-items-list-4"
           cellspacing="0"
           cellpadding="<?php echo $ec_woo_settings_border_padding; ?>"
           style="width: 100% !important;font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;"
           border="0">
        <thead>
        <tr>
            <?php if ($ec_woo_settings_rtl == '1'): ?>
                <th scope="col" class="col-product" width="53%"
                    style="text-align:right;border-bottom: 1px solid #ccc;font-size: 16px;"><?php _e('Product', 'woocommerce'); ?></th>

                <th scope="col" class="col-quantity" width="22%"
                    style="text-align:center;border-bottom: 1px solid #ccc;font-size: 16px;"><?php _e('Quantity', 'woocommerce'); ?></th>
                <th scope="col" class="col-price" width="25%"
                    style="text-align:right;border-bottom: 1px solid #ccc;font-size: 16px;"><?php _e('Price', 'woocommerce'); ?></th>

            <?php endif; ?>
            <?php if ($ec_woo_settings_rtl == '0'): ?>
                <th scope="col" class="col-product" width="53%"
                    style="text-align:left;border-bottom: 1px solid #ccc;font-size: 16px;"><?php _e('Product', 'woocommerce'); ?></th>
                <th scope="col" class="col-quantity" width="22%"
                    style="text-align:center;border-bottom: 1px solid #ccc;font-size: 16px;"><?php _e('Quantity', 'woocommerce'); ?></th>
                <th scope="col" class="col-price" width="25%"
                    style="text-align:right;border-bottom: 1px solid #ccc;font-size: 16px;"><?php _e('Price', 'woocommerce'); ?></th>

            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php

        include($path_order_item);
        ?>
        </tbody>

    </table>
     <div class="" style="width:100%;height:30px;"></div>
    <table class="woo-items-list-4-total" width="100%" bg-color="#f9f9f9" cellpadding="0" border="0" cellspacing="0"
           style="width:100%;background-color:#f9f9f9;">
        <?php
        $total_values = $order->get_order_item_totals();
        if (isset($total_values)) {
            $index = 0;
            foreach ($total_values as $key => $item) {
                $index++; ?>
                <tr>
                    <?php if ($ec_woo_settings_rtl == '1'): ?>
                        <td class="col-total-label" scope="row" width="65%" colspan="2"
                            style="text-align: right;    color: #606060;  font-size: 13px;font-family: sans-serif;  font-weight: normal;  padding-top: 5px;  padding-bottom: 5px;  padding-right: 20px;letter-spacing: 0.5px;  <?php echo $index == 1 ? 'padding-top:20px;' : '';
                            echo $index == sizeof($total_values) ? 'font-weight: bold;padding-bottom:20px;' : 'font-weight: 300;'; ?>">
                            fdgdfgdgd
                            <?php echo $item['label']; ?>
                        </td>
                        <td class="col-total-value" width="35%"
                            style="text-align: right; color: #262626; padding-right: 20px; font-family: Helvetica, sans-serif;font-size: 14px;font-weight: normal;<?php echo $index == 1 ? 'padding-top:30px;' : '';
                            echo $index == sizeof($total_values) ? 'font-weight: bold;padding-bottom:20px;' : 'font-weight: 300;'; ?>">
                            <?php echo $item['value']; ?>
                        </td>
                    <?php endif; ?>
                    <?php if ($ec_woo_settings_rtl == '0'): ?>
                        <td class="col-total-label" scope="row" width="55%" colspan="2"
                            style="text-align: left;    color: #606060;  font-size: 13px;font-family: sans-serif;  font-weight: normal;  padding-top: 5px;  padding-bottom: 5px;  padding-left: 20px;letter-spacing: 0.5px;  <?php echo $index == 1 ? 'padding-top:20px;' : '';
                            echo $index == sizeof($total_values) ? 'font-weight: bold;padding-bottom:20px;' : 'font-weight: 300;'; ?>">

                            <?php echo $item['label']; ?>
                        </td>
                        <td class="col-total-value" width="45%"
                            style="text-align: right; color: #262626; padding-right: 20px; font-family: Helvetica, sans-serif;font-size: 14px;font-weight: normal;<?php echo $index == 1 ? 'padding-top:30px;' : '';
                            echo $index == sizeof($total_values) ? 'font-weight: bold;padding-bottom:20px;' : 'font-weight: 300;'; ?>">
                            <?php echo $item['value']; ?>
                            <br/>
                            <?php 
                            if ($key == 'shipping') {
										$order = $this->order;
										if( $order->has_shipping_method('local_pickup') ) { 
											$order_id = $this->order->get_id();
											$id_store = get_post_meta($order_id,'select_store',true);
											echo '<strong>Store: </strong>'.get_the_title($id_store);
										}
										
						}
                            ?>
                        </td>
                    <?php endif; ?>
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

//// /////////////////
if(isset($attr['type']) && $attr['type'] == 'aashipping-address'){?>
    <div class="" style="font-size: 12px; text-align: left;">
    <?php
        if( $order->has_shipping_method('local_pickup') ) {
            $order_id = $this->order->get_id();
            $id_store = get_post_meta($order_id,'select_store',true);
            echo '<span style="font-size: 14px;">'.get_the_title($id_store).'</span><br/>
            <div class="opening-hours">';
                echo 'Opening Hours:'. wpautop(get_field('store_opening_hours',$id_store),true);
            echo '</div>';
        }	else {
            $shipping   = $order->get_formatted_shipping_address();
            echo $shipping.'<br/>';
            echo $order->get_billing_phone();
            echo '<br/>';
        }
       
        if ( $order->get_customer_note() ) {
            echo '<hr>';
            echo '<br/><div>'.esc_html_e( 'Note: ', 'woocommerce' ); ?><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ).'</div>'; 
        }
        ?>
    </div>
    <?php
    }

if(isset($attr['type']) && $attr['type'] == 'logo') {
    ?>
        <img src="<?php echo home_url('/wp-content/uploads/2020/08/loveco-logo.png'); ?>" alt="Logo" width="200" height="60" style="display: block; margin: auto;">
    <?php
}

if(isset($attr['type']) && $attr['type'] == 'billing_phone') {
    ?>
       <?php echo $order->get_billing_phone(); ?>
    <?php
}

if(isset($attr['type']) && $attr['type'] == 'shipping_phone') {
    ?>
       <?php echo get_post_meta( $order->get_id(), '_shipping_phone', true ); ?>
    <?php
}

if(isset($attr['type']) && $attr['type'] == 'email_footer') {
    ?>
    <div class="" style="text-align: center; padding: 20px 0 0; margin: 20px 0 0; border-top: 1px solid #cccccc;">
        <p style="text-align: center;">Sincerely, <br><a href="<?php echo home_url(); ?>" style="text-decoration: underline; color: #c9e4bb">Love & Co Team.</a></p>
    </div>
    <?php
}

if(isset($attr['type']) && $attr['type'] == 'email_banner_title') {
    ?>
    <div class="" style="background-color: #c9e4bb; padding: 20px 0;">
        <h1 style="color: #ffffff; text-align: center;"><?php echo $attr['content']; ?></h1>
    </div>
    <?php
}
if(isset($attr['type']) && $attr['type'] == 'order_id') {
    $order_id = $order->get_id();
    $order_date = $order->order_date;
    $order_ic = date('Ymd', strtotime($order_date)) . $order_id;
    $title = $attr['text'] .": #IC-$order_ic";
    ?>
    <div class="" style="background-color: #c9e4bb; padding: 20px 0; margin: 20px 0 0;">
        <h1 style="color: #ffffff; text-align: center;"><?php  echo $title; ?></h1>
    </div>
    <?php
}

if(isset($attr['type']) && $attr['type'] == 'username') {
    $user = new WP_User($order->get_user_id());
    echo $user->display_name;
}


if(isset($attr['type']) && $attr['type'] == 'on_hold_email_content') {
    if('bacs' == $order->get_payment_method()):
    ?>
    <p align="left">Thank you for your order. Here are the following steps:</p>
    <p align="left" style="padding-left: 20px; margin: 0">1. Please use the Order Number (Example: IC-202105xxxxxxx) as payment reference while making Bank Instant Transfer to our bank account. </p>
    <p align="left" style="padding-left: 20px; margin: 0">2. Once payment done, please email your payment slip to ecommercemy@love-and-co.com</p>
    <p align="left" style="padding-left: 20px; margin: 0">3. Our E-Commerce Team will verify your payment and process your order accordingly.</p>
    <p align="left">Your order is on-hold until we confirm payment has been received. Your order details are shown below for your reference:</p>
    <?php
    else: 
    ?>
    <p style="text-align: left; margin: 0;">Your order is <b>on-hold</b> until we confirm payment has been received. Your order details are shown below for your reference:</p>
    <?php
    endif;
}