<?php
/**
 * args has status completed to push more shipped status
 *
 *
 * @return void
 */
if (function_exists('acf_add_options_page')) {
  acf_add_options_page(array(
    'page_title'  => 'Email WooCommerce',

    'menu_title'  => 'Email WooCommerce',

    'menu_slug'   => 'woo-email-custom',

    'redirect'    => false

  )); 

}
function oa_get_shipping_method($order) {
	$shipping_item = array();
	foreach ( $order->get_shipping_methods() as $shipping_method ) {		
	//free_shipping:2
	$meta_id = $shipping_method->get_method_id().':'.$shipping_method->get_instance_id();
	$method_settings = get_shipping_method_from_method_id($meta_id);
	$label = sprintf("%s %s", $shipping_method->get_name(), "(".$method_settings['shipping_working_days'].")");
	$shipping_item['name'] = $label;
	$shipping_item['method_id'] = $shipping_method->get_method_id();
	$shipping_item['total'] = $shipping_method->get_total();
	$shipping_item['instance_id'] = $shipping_method->get_instance_id();
    }
	return $shipping_item;
}

add_filter('acf/load_field/name=select_type_delivery', 'objects_hidden_price_url2');
function objects_hidden_price_url2( $field ) { 
	$post_id = $_GET['post'];
	if ( get_post_type($post_id ) == 'shop_order' ) {
	$post_id = $_GET['post'];
	$order = new WC_Order( $post_id );
	$shipping_method = oa_get_shipping_method($order)['method_id'];
	if ( $shipping_method=='local_pickup') {
		$choices['store-collection'] = 'Store Collection';
	} else {
		$choices['3p'] = 'Doorstep delivery 3P';
		$choices['in-house'] = 'Inhouse Courier';
		
	}
	 $field['choices'] = $choices;
	}
    return $field;
}

/*add_action('init', function() {
	$field = get_acf_key('select_type_delivery');

	echo '<pre>';
	print_r($field);
	echo '</pre>';
});*/
function get_acf_key($field_name){
    global $wpdb;

    return $wpdb->get_var("
        SELECT post_name
        FROM $wpdb->posts
        WHERE post_type='acf-field' AND post_excerpt='$field_name';
    ");
}
function get_store_infor($orders_meta) {
    $store_id = "";
    $store_title = "";
    $store_content = '';
    
    foreach($orders_meta as $meta){
        $data = $meta->get_data();  
        if($data["key"]== "select_store"){
            $store_id = (int)$data["value"];
            $store_title = get_the_title($store_id);
            $store_content = get_field('store_address',$store_id);
        }
}
return array(
        'store_id' => $store_id ,
        'store_title' => $store_title,
        'storstore_content_id' => $store_content,
    );
}


function oa_get_shipping_method2($order) {
    $shipping_item = array();
    foreach ( $order->get_shipping_methods() as $shipping_method ) {        
        //free_shipping:2        
        $shipping_item['name'] = $shipping_method->get_name();
        $shipping_item['method_id'] = $shipping_method->get_method_id();
        $shipping_item['total'] = $shipping_method->get_total();
    }
    return $shipping_item;
}
function date_start_procesing_shipped($date_start) {
	
	$day_order_start = intval(mysql2date('N',$date_start));//N -  (1 for Monday, 7 for Sunday)
	$day_plus = 0;
	if ($day_order_start == 6) { // statuday 	
		$day_plus = 1;
	}elseif ($day_order_start == 7) { // sunday	
		$day_plus = 0;
	} 
	if ($day_plus > 0) { 
		$day_plus = '+'.$day_plus.'days';
		return 	date('Y-m-d',strtotime($day_plus, strtotime($date_start)));
	} else return $date_start;
	
} 

function oa_estimate_delivery_working_day($min_day,$max_day,$format_date) {
	$day_order_min = intval(mysql2date('N',$min_day));//N -  (1 for Monday, 7 for Sunday)
	
	if (!empty($max_day))
	$day_order_max = mysql2date('N',$max_day);//N -  (1 for Monday, 7 for Sunday)	
	else $day_order_max = 0;
	if ($day_order_min == 6) { // statuday	
		$min_day = date($format_date,strtotime('+2days', strtotime($min_day)));
		if (!empty($max_day))
		$max_day = date($format_date,strtotime('+2days', strtotime($max_day)));
	} elseif ($day_order_min == 7) { // sunday	
		$min_day = date($format_date,strtotime('+2days', strtotime($min_day)));
		if (!empty($max_day))
		$max_day = date($format_date,strtotime('+2days', strtotime($max_day)));
	} elseif ($day_order_max == 6 || $day_order_max == 7) { // sunday			
		$max_day = date($format_date,strtotime('+2days', strtotime($max_day)));
		$min_day = mysql2date($format_date,$min_day);
	} elseif ( $day_order_max == 7) { // sunday			
		$max_day = date($format_date,strtotime('+1days', strtotime($max_day)));
		$min_day = mysql2date($format_date,$min_day);
	}
	else {
		$min_day = mysql2date($format_date,$min_day);
		if (!empty($max_day))
		$max_day = mysql2date($format_date,$max_day);
	}
	if (!empty($max_day))
	return $min_day.' - '.$max_day; 
	else return $min_day;

}
function date_delivery_email($date_start,$number_min_day,$number_max_day,$format_date) {
	// date_start == date_processing or date_shipped
	// if date_start == sun or sat then date_start = mon
	//var_dump($date_start);
	$date_order_start = date_start_procesing_shipped($date_start);
	//var_dump($date_order_start.'--'.$number_min_day);
	$a = intval(mysql2date('N',$date_order_start));
	//$number_min_day  and number_max_day are day delivery (5-7 days for free and 3-5 days for express)
	$number_min_day = '+'.$number_min_day.'days';	
	$min_day = date('Y-m-d',strtotime($number_min_day, strtotime($date_order_start)));// after plus delivery days, 
	$number_max_day = intval($number_max_day);
	if ($number_max_day > 0) {
		$number_max_day_str = '+'.$number_max_day.'days';
		$max_day = date('Y-m-d',strtotime($number_max_day_str, strtotime($date_order_start)));
		$day_order_max = intval(mysql2date('N',$max_day));//N -  (1 for Monday, 7 for Sunday)
	} else $max_day = '';	
	// if day delivery is not sun or sat, but from order precsing to max_day contain sun or sat 
	
	if ($a != 6  && $a != 7  && $day_order_max !=6 && $day_order_max !=7  && $number_max_day > 0) {
		$day_plus = 0;		
		$total_day = intval($number_max_day)+intval($a) - 1;
		//var_dump($total_day);
		if ($total_day > 1) {			
			for ($i = $a;$i<=$total_day;$i++) {
				$j = $i;
				if ($j > 7) {
					$j = $j % 7;
				}
				//var_dump('j: '.$j);
				if ($j % 7 == 6 || $j % 7 == 0) $day_plus += 1;
			}
		}		
		$day_plus = '+'.$day_plus.'days'; 
		$min_day = date('Y-m-d',strtotime($day_plus, strtotime($min_day)));
		$max_day = date('Y-m-d',strtotime($day_plus, strtotime($max_day)));
	}
	//var_dump($min_day);
	return oa_estimate_delivery_working_day($min_day,$max_day,$format_date);
}
function oa_estimate_delivery($order) {
	$shipping_method = oa_get_shipping_method($order)['method_id'];
	$instance_id = oa_get_shipping_method($order)['instance_id'];
	$order_date = $order->get_date_created();
	//$date_modi = $order->get_date_modified();
	$order_date = mysql2date('Y-m-d',$order->get_date_modified());
	if (empty($order_date) || $order_date == '1970-01-01') {
		$order_date = mysql2date('Y-m-d',begin_date_now_sg());		
	}
	
	$number_min_day = 5;
	$number_max_day = 7;
	if ($shipping_method === 'flat_rate' && $instance_id === '9') {
		$number_min_day = 3;
		$number_max_day = 4;
	}	
	$date_delivery = date_delivery_email($order_date,$number_min_day,$number_max_day,'j M');	
    return $date_delivery;
	//$time_shipping = '10AM – 5PM';	
	//return '<table cellspacing="0" cellpadding="0" style="margin:0 auto;"><tr><td style="border:solid 2px #AD073D; padding:3px 15px;background:#AD073D;color:#ffffff;">'.$date_delivery.'</td><td  style="border:solid 2px #AD073D; padding:5px 15px;color:#AD073D;font-size:15px;">'.$time_shipping.' </td></tr></table>';	
}

// function oa_estimate_delivery($order) {
//     $shipping_method = oa_get_shipping_method2($order)['method_id'];
//     $order_date = $order->get_date_created();
//     $add_day_min = '+3days';
//     $add_day_max = '+5days';
//     if ($shipping_method == 'flat_rate') {
//         $add_day_min = '+1days';
//         $add_day_max = '+3days';
//     }
//     $date_min =  date('j M Y',strtotime($add_day_min, strtotime($order_date)));
//     $date_max = date('j M Y',strtotime($add_day_max, strtotime($order_date)));
//     $date_delivery = $date_min.' - '.$date_max;
//     return $date_delivery; 
// }

function oa_estimate_delivery_working_day_shipped($min_day,$format_date) {
	$day_order_min = mysql2date('N',$min_day);//N -  (1 for Monday, 7 for Sunday)
	
	if ($day_order_min == 6) { // statuday	
		$min_day = date($format_date,strtotime('+2days', strtotime($min_day)));		
	} elseif ($day_order_min == 7) { // sunday	
		$min_day = date($format_date,strtotime('+1days', strtotime($min_day)));		
	} else {
		$min_day = mysql2date($format_date,$min_day);		
	}
	 return $min_day;

}
function date_delivery_email_shipped($date_start,$number_min_day,$format_date) {
	// date_start == date_processing or date_shipped
	// if date_start == sun or sat then date_start = mon
	//$date_order_start = date_start_procesing_shipped($date_start);
	//$number_min_day  and number_max_day are day delivery (5-7 days for free and 3-5 days for express)
	$number_min_day = '+'.$number_min_day.'days';	
	$min_day = date('Y-m-d',strtotime($number_min_day, strtotime($date_start)));// after plus delivery days, 
	return oa_estimate_delivery_working_day_shipped($min_day,$format_date);
}


add_shortcode( 'lvc_woo_email', 'create_lvc_woo_email' );
function create_lvc_woo_email($args, $content) {   

    if ($args['param'] == 'logo') {
        return '<a href="" style="display:inline-block; margin-bottom:30px;"><img style="max-width:300px;" src="https://oanglelab.com/oa134-lvc/ebase-uploads/2022/01/logo-lvc.jpg"></a>';           
    } 
    return '';
}
//[lvc_woo_email param="view_order" order_id=""]
function get_type_delivery_in_backend() {
    $key_select_type_delivery = get_acf_key('select_type_delivery')??'';
    return  $_POST['acf'][$key_select_type_delivery];   
}
//add_action( 'woocommerce_email_order_header_shipped', 'oa_woocommerce_email_order_header_shipped', 10,1);
function oa_woocommerce_email_order_header_shipped($order) {
    
    $shipped_order_store_name = "";
    /* shipped content header */
    //$order_id = $order -> get_id();
    $type_delivery = get_type_delivery_in_backend();
    $shipped_order_content_header = get_field('shipped_content_3p','option')??'';
    $heading = get_field('heading_doorstep_delivery_3p','option')??'';
    $shipped_content = get_field('shipped_content_3p','option')??'';
    if ($type_delivery == 'store-collection'){      
        $heading = get_field('heading_store_collection','option')??'';
        $shipped_content = get_field('shipped_content_store_collection_header','option')??'';
    } else if ($type_delivery == 'in-house') {      
        $heading = get_field('heading_in_house','option')??'';
        $shipped_content = get_field('shipped_content_in_house_header','option')??'';
    } 
    /* end shipped content header */

    /**
     * overlay {tracking_id} of shipped_order_content_header with field tracking_id of order.
     * overlay {store_name} of shipped_order_content_header with field tracking_id of order.
     */
    return '<p style="font-size:20px; margin-top:0;margin-bottom:15px;"><strong>'.$heading.'</strong></p>
                <p style="font-size:14px;  margin-top:0;margin-bottom:30px;">'.$shipped_content.'</p> '; 
   
}

function oa_estimate_delivery_shipped($order) {

	$date_last = $order->get_date_modified();
	$date_last = mysql2date('Y-m-d',$date_last);
	
	$date_last = date_start_procesing_shipped($date_last);
	$key_select_type_delivery = get_acf_key('select_type_delivery');
	$type_delivery = $_POST['acf'][$key_select_type_delivery];
	// tính lại estimate trừ 3p
	if ($type_delivery != '3p') {
		$key_enable_date_delivery = get_acf_key('enable_date_delivery')??false;
		$enable_date_delivery = $_POST['acf'][$key_enable_date_delivery];
		$date_delivery = $_POST['acf']['field_61e8c094aba49']??'';
		
		if ($enable_date_delivery === '1' && !empty($date_delivery)) {
			$date_delivery2 = $date_delivery;
			$date_delivery = mysql2date( 'j M', $date_delivery2 );			
			if ($type_delivery == 'in-house') {
				$date_delivery = mysql2date( 'j F', $date_delivery2 );
				return $date_delivery.', 10AM – 5PM'; 
			}
			else return $date_delivery.', 6PM onwards';
		} else { // plus day
			$working_day = get_field('working_days_from_order_shipped','option')??1;
			if (empty($working_day)) $working_day = 1;
			$date_shipping = mysql2date('Y-m-d',$order->get_date_modified());
			
			//$date_shipping = '2022-02-25';
			
		//	$day_shipped = date('Y-m-d ',strtotime($working_day, strtotime($date_last)));
			//var_dump($day_shipped);
			//$working_day_str = date_delivery_email($order->get_date_modified(),$working_day,0,'j M');	
			$working_day_str =  date_delivery_email_shipped($date_shipping,$working_day,' j M');
			
			if ($type_delivery == 'in-house') {
				//$working_day_str2 = date_delivery_email($order->get_date_modified(),$working_day,0,'j F');
				$working_day_str2 =  date_delivery_email_shipped($date_shipping,$working_day,' j F');
				return  $working_day_str2.', 10AM – 5PM';
			}
			else return $working_day_str.', 6PM onwards';
		}
		
	} else { // 3p
		$number_min_day = 1;
		$number_max_day = 2;
		$date_shipping = mysql2date('Y-m-d',$order->get_date_modified());
		//$date_shipping = '2022-02-25';
		$date_delivery_shipped =   date_delivery_email($date_shipping,$number_min_day,$number_max_day,'j M');	
		return $date_delivery_shipped.' 10AM – 5PM';
	}
	return '';
	
}
function check_args_exists_item($array,$item){
	foreach($array as $value){
		if($item == $value){
			return true;
		}
	}
	return false;
}
function custom_woocommerce_reports_get_order_report_data_args($args){
	if(isset($args["order_status"])){
		if($args["order_status"]){
			$completed = check_args_exists_item($args["order_status"],"completed");
			if($completed){
				array_push($args["order_status"],"shipped");
			}
		}
	}
	if(isset($args["parent_order_status"])){
		if($args["parent_order_status"]){
			$completed = check_args_exists_item($args["parent_order_status"],"completed");
			if($completed){
				array_push($args["parent_order_status"],"shipped");
			}
		}
	}
	return $args;
}
add_filter("woocommerce_reports_get_order_report_data_args","custom_woocommerce_reports_get_order_report_data_args");
/**
 * add status shipped
 *
 * @param array $order_statuses
 * @return array
 */
function add_shipped_status_wc_order_statuses($order_statuses){
	$order_statuses["wc-shipped"] = _x( 'Shipped', 'Order status', 'woocommerce' );
	return $order_statuses;
}
add_filter("wc_order_statuses","add_shipped_status_wc_order_statuses");

// Add custom status to order list
add_action( 'init', 'register_custom_post_status', 10 );
function register_custom_post_status() {
    register_post_status( 'wc-shipped', array(
        'label'                     => _x( 'Shipped', 'Order status', 'woocommerce' ),
        'public'                    => false,
        'exclude_from_search'       => false,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'label_count'               => _n_noop( 'Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>' )
    ) );
}
// Adding custom status  to admin order list bulk actions dropdown
add_filter( 'bulk_actions-edit-shop_order', 'custom_dropdown_bulk_actions_shop_order', 20, 1 );
function custom_dropdown_bulk_actions_shop_order( $actions ) {
    $actions['mark_shipped'] = __( 'Change status to shipped', 'woocommerce' );
    return $actions;
}
	/**
	 * send email if status change to shipped
	 *
	 * @param int $order_id
	 * @param string $from
	 * @param string $to
	 * @return void
	 */
	function setup_send_mail_for_status_shipped($order_id,$from,$to){
		// Fix Do not send new order mail issue after change order status from on hold to processing
		
		

		if($from == "processing" && $to === "shipped"){
			WC()->mailer()->get_emails()["WC_Email_Customer_Shipped_Order"]->trigger($order_id);
		}

	}

add_action("woocommerce_order_status_changed","setup_send_mail_for_status_shipped",10,3);


add_action("init","add_shipped_email_class_init");
function add_shipped_email_class_init(){
	add_filter("woocommerce_email_classes","add_class_wc_shipped_email_woocommerce_email_classes");
	function add_class_wc_shipped_email_woocommerce_email_classes($emails){
		$emails["WC_Email_Customer_Shipped_Order"] = include get_template_directory()."/inc/email/class-wc-customer-shipped-order.php";
		return $emails;
	}
	$GLOBALS["woocommerce"] = WC();
}

//add_filter('woocommerce_email_settings','wc_test_settings222',10,1);
function wc_test_settings222($settings) {
	$section = 'wc_email_customer_shipped_order';
	$id = 'shipped_email_admin2';
	$data_action ="shipped";
	if ( $section == 'wc_email_customer_processing_order') {
		$id = 'processing_email_admin2';
		$data_action ="processing";
	}
    if($section == 'wc_email_customer_shipped_order' || $section == 'wc_email_customer_processing_order') {
        $settings[] = 
            array(
                'title'             => __( 'Send mail to admin', 'wc_test' ),
                'id'                => $id,
                'type'              => 'text',
				'class'		=> 'email_admin_field',
                'desc'     => __( 'Each email is separated by comma', 'text-domain' )
            
        );
            $settings[] = array(
					'title' => __( '', 'woocommerce' ),
					'type'  => 'title',
					'id'    => 'update_admin_email',
					'desc'  => __( '<span data-action ="'.$data_action.'" class="update_admin_email">Update email admin</span><br><strong><i></i></strong>', 'woocommerce' ),
					
				);
            

    }
    return $settings;    
}
add_action( 'admin_footer', 'update_email_admin' );
function update_email_admin() { ?>
<?php 
	$section = $_GET['section'] ??'';
	$tab_email = $_GET['tab']??'';
	
	if ($tab_email == 'email' ) {
		if ($section == 'wc_email_customer_processing_order' || $section == 'wc_email_customer_shipped_order') {
?>
	<style>
		.update_admin_email {
			display: inline-block;
			padding: 5px 30px;
			border-radius: 5px;
			cursor: pointer;
			color: #fff;
			background: red;
		}
		.email_admin_field {
			width: 60%;
			min-width: 300;
		}
		.processing {
			display:none;
		}
		.processing.active {
			display:block;
		}
	</style>
	<?php
	//$section = 'wc_email_customer_shipped_order';
	$meta_key_option = 'shipped_email_admin2';
	$id = 'shipped_email_admin2';
	$data_action ="shipped";
	if ( $section == 'wc_email_customer_processing_order') {
		$id = 'processing_email_admin2';
		$data_action ="processing";
		$meta_key_option = 'processing_email_admin2';
	}
	
	$emails = get_option($meta_key_option);
	$html_email = '<label for="processing_email_admin2">Send mail to admin </label><div class="forminp forminp-text"><input name="'.$id.'" id="'.$id.'" type="text" style="" value="'.$emails.'" class="email_admin_field" placeholder="" /><p class="description">Each email is separated by comma</p></div><div id="update_admin_email-description"><p><span data-action="'.$data_action.'" class="update_admin_email">Update email admin</span><br /><strong><i></i></strong></p></div>';
		?>
	
		<script type='text/javascript'>
			
	 	 jQuery(document).ready( function(){ 	 

	 	 var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";	 		 	
	 	 var html_update_product = '<?php echo $html_email; ?>';	 	
	 	 	html_update_product += '<div class="processing dffafa">';
	 	 	html_update_product += '<div class="loading-wait">Please wait....</div></div>';
	 	 	
		jQuery(html_update_product).insertAfter("#template");
	 	if (jQuery(".update_admin_email").length) { 		 		
	 		jQuery('.update_admin_email').click(function(e){ 
	 			console.log('abc');
	 			e.preventDefault();	
				var list_email = jQuery(".email_admin_field").val();		
				var email_status = jQuery(this).data("action");	
					jQuery(".processing").addClass("active");
					jQuery.ajax({
				    url: ajaxurl,
				    data : {
				        action: "update_email_admin_shipped", 
						'email_status': email_status,
				        'list_email' : list_email		        				             
				    }
				})
				.done(function (response) {  		
				jQuery(".processing").removeClass("active");		 	
				});				
			});	
	 	}
 	 	}); 
	 </script>
	<?php } } }

	add_action('wp_ajax_update_email_admin_shipped', 'update_email_admin_shipped');
	function update_email_admin_shipped() {
		$list_email = $_REQUEST['list_email'] ?? '';	
		$email_status = $_REQUEST['email_status']??'';
		if ($email_status == 'shipped') {
			update_option( 'shipped_email_admin2', $list_email );
		}
		if ($email_status == 'processing') {
			update_option( 'processing_email_admin2', $list_email );
		}
		
		
	    wp_die();
	}




add_filter( 'woocommerce_email_headers', 'bbloomer_order_completed_email_add_cc_bcc', 9999, 3 );
 
function bbloomer_order_completed_email_add_cc_bcc( $headers, $email_id, $order ) {
	//var_dump($email_id);exit;
	
    if ( 'customer_shipped_order' == $email_id ) {
    	$emails_admin = get_option( 'shipped_email_admin2' ); 
    	$emails_admin =  explode(",",$emails_admin);

    	if (is_array($emails_admin) && count($emails_admin)>0){
    		foreach($emails_admin as $email_ad ) {
    		//$headers .= 'Cc: '.$email_ad.'>\r\n'; // delete if not needed
    		$headers .= "Cc: $email_ad \r\n";
    	}
    	}
    }
	if ( 'customer_processing_order' == $email_id ) {
    	$emails_admin = get_option( 'processing_email_admin2' ); 
    	$emails_admin =  explode(",",$emails_admin);

    	if (is_array($emails_admin) && count($emails_admin)>0){
    		foreach($emails_admin as $email_ad ) {
    		$headers .= "Cc: $email_ad \r\n";
    	}
    	}
    }
    return $headers; 
}


