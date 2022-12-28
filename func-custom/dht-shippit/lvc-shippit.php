<?php
$api_key = get_option('wc_settings_shippit_api_key') ??'';

$enable = get_option('wc_settings_shippit_enabled') ??'no';
add_filter('woocommerce_product_variation_get_weight', 'shippit_woocommerce_product_get_weight_filter', 10, 2 );
add_filter('woocommerce_product_get_weight', 'shippit_woocommerce_product_get_weight_filter', 10, 2 );
function shippit_woocommerce_product_get_weight_filter( $weight, $product ) {
    if ( empty($weight) || $weight == 5129 ) {
        return 0.5;
    }
    return $weight;
}

// Output a custom editable field in backend edit order pages under general section
add_action( 'woocommerce_admin_order_data_after_order_details', 'shippit_editable_order_custom_field', 15, 1 );
function shippit_editable_order_custom_field( $order ){
    if (!$order->has_shipping_method('local_pickup')){
    // Replace "customer reference" value by the meta data if it exist
    $value =  $order->get_meta('skj_shippit_tracking_id');
    $skj_shippit_tracking_number =  $order->get_meta('skj_shippit_tracking_number');
    $value1 =  $order->get_meta('skj_shippit_company');
    $value2 =  $order->get_meta('shippit_tracking_id_url');


    // Display the custom editable field
    woocommerce_wp_text_input( array(
        'id'            => 'skj_shippit_tracking_id',
        'label'         => __("Tracking ID Shippit:", "woocommerce"),
        'value'         => $value,
        'wrapper_class' => 'form-field-wide shippit_filed',
        'custom_attributes' => array('readonly' => 'readonly','required' =>'required'),
        'required'    => true,
	) );
    woocommerce_wp_text_input( array(
        'id'            => 'skj_shippit_tracking_number',
        'label'         => __("Tracking Number Shippit:", "woocommerce"),
        'value'         => $skj_shippit_tracking_number,
        'wrapper_class' => 'form-field-wide shippit_filed',
        'custom_attributes' => array('readonly' => 'readonly','required' =>'required'),
        'required'    => true,
    ) );
    woocommerce_wp_text_input( array(
        'id'            => 'skj_shippit_company',
        'label'         => __("Company Shipping:", "woocommerce"),
        'value'         => $value1,
        'wrapper_class' => 'form-field-wide shippit_filed',
        'custom_attributes' => array('readonly' => 'readonly','required' =>'required'),
        'required'    => true,
    ) );
    woocommerce_wp_text_input( array(
        'id'            => 'shippit_tracking_id_url',
        'label'         => __("Tracking url", "woocommerce"),
        'value'         => $value2,
        'wrapper_class' => 'form-field-wide shippit_filed',
       'custom_attributes' => array('readonly' => 'readonly','required' =>'required'),
        'required'    => true,
    ) );
    

    ?>
    <?php if ($order->get_status() == 'processing'): ?>
    <div class="get_shipping_on_shippit" id="get_shipping_on_shippit" style="">
        <div class="sys_from_spippit" ><span data-orderid="<?php echo $_GET['post'];?>"></span></div>
        <div class="loading"><div class="loading_processing"></div></div>
        <p style=""><strong>Notice:<br/></strong><i><small>1. Shipping info to be auto-updated for Shipped email: only under 3P shipping mode/Store collection<br/>2. 3P shipping mode must be selected first, then change to status Shipper to set shipping info</small></i></p>
    </div>
    <?php endif; ?>
    <?php
    }

    
}

add_action('in_admin_footer', 'shippit_admin_page');
    function shippit_admin_page () {   
      ?>
      <script type='text/javascript'>
        jQuery(document).ready( function(){ 
            if (jQuery(".shippit_filed").length) {
            function hide_shippit_filed(type_delivery) {
                var enable_delivery_manual = 0;
                    if (jQuery('#acf-field_620cc875a9a92').is(':checked')) {
                        enable_delivery_manual = 1;
                    }
                    console.log(enable_delivery_manual);
                    if (type_delivery == '3p' && enable_delivery_manual == 0) {
                    jQuery(".shippit_filed").show();
                    } else {
                        jQuery(".shippit_filed").hide();
                    }
                }   

                var type_delivery = jQuery("#acf-field_61e8b76222fad").val();
                hide_shippit_filed(type_delivery);               
                jQuery("#acf-field_61e8b76222fad").change(function(){
                    var type_delivery = jQuery(this).val();
                    hide_shippit_filed(type_delivery);
                });
                jQuery('#acf-field_620cc875a9a92').change(function(){
                    console.log('123456');
                    var type_delivery = jQuery("#acf-field_61e8b76222fad").val();
                    hide_shippit_filed(type_delivery);
                })
            }

            if (jQuery(".get_shipping_on_shippit").length) {  
                console.log('aaaaaaaa');
              
                jQuery(".get_shipping_on_shippit").insertBefore(jQuery('.wc-order-status'));
                // ajax update sh
                var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";   
                jQuery("#order_status").change(function(){
                    var status = jQuery(this).val();   
                    var type_delivery = jQuery("#acf-field_61e8b76222fad").val();
                    console.log(type_delivery)      ;
                    var enable_delivery_manual = 0;
                    if (jQuery('#acf-field_620cc875a9a92').is(':checked')) {
                        enable_delivery_manual = 1;
                    }
                    console.log(type_delivery+'--'+enable_delivery_manual)    ;      
                    if (status === 'wc-shipped' && type_delivery == '3p' && enable_delivery_manual == 0) {
                        jQuery('.sys_from_spippit span').trigger("click");
                    }
                });
                jQuery('.sys_from_spippit span').click(function(e){ 
                    e.preventDefault();  
                    var tracking_number = jQuery("#skj_shippit_tracking_id").val();
                    var skj_shippit_tracking_number = jQuery("#skj_shippit_tracking_number").val();
                    console.log(skj_shippit_tracking_number);
                    var orderid = jQuery(this).data('orderid');
                    if (tracking_number != '' ) {   
                        if (skj_shippit_tracking_number == ''){
                    jQuery(".loading").show();                                                                 
                           jQuery.ajax({
                            url: ajaxurl,
                            data: {
                            'action': 'update_shippit_infor_in_order',
                            'tracking_number': tracking_number,
                            'orderid': orderid,
                        }                         
                        })
                        .done(function (response) {  
                            console.log('kmmmm');
                                if (response != '') {
                                console.log('finish');
                                jQuery(".loading").hide();
                                jQuery("#skj_shippit_company").val(response.data.shipping_company);
                                jQuery("#shippit_tracking_id_url").val(response.data.tracking_url);
                                jQuery("#skj_shippit_tracking_number").val(response.data.tracking_number);
                            
                                //alert("done");
                            }
                        });    
                    }                                                           
                    
            } else {
                alert("Tracking number is empty");
            }          
        }); 
            }
        });
      </script>
      <?php 
      
    }

add_action('wp_ajax_update_shippit_infor_in_order', 'update_shippit_infor_in_order');
function update_shippit_infor_in_order() {
    $tracking_number = trim($_REQUEST['tracking_number']);
    $order_id = $_REQUEST['orderid'];   
    $order = wc_get_order( $order_id );  
    $shipping_company = '';
    $tracking_url = '';
    if (!empty($tracking_number)) {
       // woo_order_status_change_custom($order_id,$old_status,'processing');
         $shipping_company = skj_shippit_get_shipping_company($tracking_number)->courier_type;
         $skj_shippit_tracking_number = skj_shippit_get_shipping_company($tracking_number)->courier_job_id;
        $trackings  = skj_shippit_get_tracking_url($tracking_number); 

       
         if (!empty($shipping_company)) {
            $shippit_updated = get_post_meta($order_id,'shippit_tracking_updated',true)??'';
            if ($shippit_updated !== 'updated') {
                $tracking_url = $trackings -> tracking_url; 
                update_post_meta($order_id,'skj_shippit_company',$shipping_company);
                update_post_meta($order_id,'shippit_tracking_id_url',$tracking_url);
                update_post_meta($order_id,'skj_shippit_tracking_number',$skj_shippit_tracking_number);
                //update_post_meta($order_id,'shippit_tracking_updated','updated');

            }        
         }
    }
    wp_send_json_success(array(
        'shipping_company' => $shipping_company,
        'tracking_number' => $skj_shippit_tracking_number,
        'tracking_url' => $tracking_url,
         
    ));
    wp_die();
}



add_action( 'in_admin_header' ,'add_css_shippit_admin');

function add_css_shippit_admin() {
?>
<style>
    .get_shipping_on_shippit {
        clear:both;
        padding: 10px   ;
        text-align:center;
        background:#f6f6f6;
        border-top: solid 10px #ffffff;

    }
    #order_data .get_shipping_on_shippit p {
        color:red;
        margin:5px 0;
    }
    .sys_from_spippit  {
        padding:5px 5px;
    }
    .sys_from_spippit span {
        display: inline-block;
        cursor:pointer;
        
        font-weight:bold;
        color:green;
        border-bottom: solid 2px #f6f6f6;
    }
     .sys_from_spippit span:hover {
        border-bottom: solid 2px green;
     }
     .loading {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: gray;
        z-index: 999;
        display: none;
        opacity: 0.3;
     }
     .loading_processing {
    border: 6px solid #666;
    border-radius: 50%;
    border-top: 5px solid #999;
    width: 30px;
    height: 30px;
    -webkit-animation: spin 1s linear infinite;
    /* Safari */
    animation: spin 1s linear infinite;
    position: absolute;
    left: 50%;
    top: 50%;
    margin-top: -15px;
    margin-left: -15px;
}
</style>
<?php
}


function getApiUrl($path) {
   // const API_ENDPOINT_LIVE = 'https://www.shippit.com/api/3';
   // const API_ENDPOINT_STAGING = 'https://staging.shippit.com/api/3';
    $environment =  get_option('wc_settings_shippit_environment') ??'';
    if ( $environment == 'sandbox' ) {
        return 'https://staging.shippit.com/api/3/' . $path;
    }
    else {
        return 'https://www.shippit.com/api/3/' . $path;
    }
}




function skj_shippit_get_shipping_company($tracking_number) {
    $api_key = get_option('wc_settings_shippit_api_key') ??'';
 $path = 'orders/'.$tracking_number.'/label';
 $url = getApiUrl($path);
     $args =   array(
         'blocking'     => true,
         'method'       => 'GET',
         'timeout'      => 30,
         'user-agent'   => 'Mamis_Shippit for WooCommerce' . 'v' . '1.6.5',
         'headers'      => array(
             'content-type' => 'application/json',
             'Authorization' => sprintf(
                 'Bearer %s',
                 $api_key
             ),
         ),
     );

    $response = wp_remote_request(
                 $url,
                 $args
             );

    $responseCode = wp_remote_retrieve_response_code($response);
    
    if ($responseCode == 200) {
        $jsonResponseData = wp_remote_retrieve_body($response);
        $responseData = json_decode($jsonResponseData);
        return $responseData->response->order;
    } else {
            return '';
    }
              
}



function skj_shippit_get_tracking_url($tracking_number) {
    $api_key = get_option('wc_settings_shippit_api_key') ??'';
 $path = 'orders/'.$tracking_number.'/tracking';
 $url = getApiUrl($path);
 
     $args =   array(
         'blocking'     => true,
         'method'       => 'GET',
         'timeout'      => 30,
         'user-agent'   => 'Mamis_Shippit for WooCommerce' . 'v' . '1.6.5',
         'headers'      => array(
             'content-type' => 'application/json',
             'Authorization' => sprintf(
                 'Bearer %s',
                 $api_key
             ),
         ),
     );

    $response = wp_remote_request(
                 $url,
                 $args
             );

    $responseCode = wp_remote_retrieve_response_code($response);
    if ($responseCode == 200) {
        $jsonResponseData = wp_remote_retrieve_body($response);
        $responseData = json_decode($jsonResponseData);
       // return $responseData->response->tracking_url;
        return $responseData->response;
    } else {
            return '';
    }
              
}
            
add_filter('woocommerce_new_order_note_data', 'skj_shippit_update_tracking', 20, 2);
function skj_shippit_update_tracking($a1,$a2) {       
    $str1 = $a1['comment_content'];
    $str2 = 'Order Synced with Shippit. Tracking number:';
    $stro = strpos($str1,$str2);
    if ($stro !== false ) {
        $order_id = $a2['order_id'];
        $track = str_replace($str2,"",$str1);
        $track = rtrim($track,".");
        update_post_meta($order_id,'skj_shippit_tracking_id',$track );
        
    } 
    
    return $a1;
}

//add_action('woocommerce_order_status_changed','woo_order_status_change_custom',60,3);
function woo_order_status_change_custom($order_id,$old_status,$new_status) {
    if ($new_status == 'processing') {
         $tracking_number = trim(get_post_meta($order_id,'skj_shippit_tracking_id',true));   
        //var_dump($tracking_number);
         $shipping_company = skj_shippit_get_shipping_company($tracking_number)->courier_type;
         $skj_shippit_tracking_number = skj_shippit_get_shipping_company($tracking_number)->courier_job_id;
          $trackings  = skj_shippit_get_tracking_url($tracking_number);        
         if (!empty($shipping_company)) {
            $shippit_updated = get_post_meta($order_id,'shippit_tracking_updated',true)??'';
            if ($shippit_updated !== 'updated') {
                 $tracking_url = $trackings -> tracking_url; 
                update_post_meta($order_id,'skj_shippit_company',$shipping_company);
                update_post_meta($order_id,'shippit_tracking_id_url',$tracking_url);
                update_post_meta($order_id,'skj_shippit_tracking_number',$skj_shippit_tracking_number);
                update_post_meta($order_id,'shippit_tracking_updated','updated');
            }        
         }
    }

}

add_action( 'pre_post_update',  'track_created_date_change' , 10,2 );
 function track_created_date_change( $post_id, $data ) {
        $post_type = get_post_type( $post_id );

        if ( 'shop_order' === $post_type ) {
            $type_delivery = $_POST['acf']['field_61e8b76222fad'];
            $enable_manual = $_POST['acf']['field_620cc875a9a92'];
            $status = $_POST['order_status'];
            if ($status == 'wc-shipped') {               
                $shipping_compnay = $_POST['skj_shippit_company']??'';
                if ($type_delivery == '3p' && $enable_manual == 0 && empty($shipping_compnay)) {
                    echo 'Plase check type devilery, <a href="'.home_url().'/wp-admin/post.php?post='.$post_id.'&action=edit">Back</a>';
                    exit;
                }
            }           
            }
          
        }












































