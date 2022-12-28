<?php
defined( 'ABSPATH' ) || exit;

// sửa trong file /woocommerce/checkout/review-order.php line 101,

require get_template_directory() . '/func-custom/custom-coupon/coupon-new-customer.php';

add_action('wp_enqueue_scripts', 'oa_sdj_skj_scripts',15);
add_action( 'wp_ajax_auto_apply_coupon', 'auto_apply_coupon' );

/*function check_order_first() {
	$check = false;
	if (is_user_logged_in()) {
		$order_statuses = array('wc-on-hold', 'wc-processing', 'wc-completed');
		$customer_user_id = get_current_user_id();
		$customer_orders = wc_get_orders( array(
		    'meta_key' 		=> '_customer_user',
		    'meta_value' 	=> $customer_user_id,
		    'post_status' 	=> $order_statuses,
		    'numberposts' 	=> -1
		) );
		if (count($customer_orders) == 0) $check = true;
	} else return true;
	return $check;
}*/



function oa_sdj_skj_scripts(){   

	if (is_checkout() ){	
		//css
		wp_enqueue_style('cp-css', get_template_directory_uri() . '/func-custom/custom-coupon/cp-css.css', array(), date("ymdh:i:s"));

		//js
		wp_enqueue_script( 'oa-cp-js',get_template_directory_uri().'/func-custom/custom-coupon/cp-js.js', array('jquery'), date("ymdh:i:s"));
		wp_localize_script( 'oa-cp-js', 'ajax_cp_genre_params',
			array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'home_url' => get_home_url(),
			) );
		}
}



function html_list_coupon_applied() {
	global $woocommerce;
	ob_start();
	foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
		<?php
		$class_auto_coupon = $code == coupon_code_order_first() ? 'auto_coupon' : '';
		?>
		<tr class="<?php echo $class_auto_coupon; ?> cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
			<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
			<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
		</tr>
	<?php endforeach; 
	$html_coupon = ob_get_contents();
	ob_clean();
	ob_end_flush();
	return $html_coupon;
}


// 

add_action('wp_ajax_nopriv_auto_apply_coupon', 'auto_apply_coupon');
function auto_apply_coupon() {
	$email = $_REQUEST['email'];
	$coupon_code = coupon_code_order_first();
	$list_err = '';
	$html_coupon = '';
	if (email_exists( $email )) {
		$list_err =  'This email has been register. Please use other email';
	} /*else {
		global $woocommerce;
		if ( !WC()->cart->has_discount( $coupon_code ) )
			WC()->cart->add_discount( $coupon_code );
		

     
    $html_coupon = html_list_coupon_applied();
    $total 		= floatval($woocommerce->cart->get_cart_contents_total());
	}*/
	wp_send_json_success(array('error' => $list_err));
	
		wp_die();
	
}





function coupons_valid() {
global $wpdb;
$today = date('Y-m-d');
$today = new DateTime($today, new DateTimeZone('Asia/Singapore'));
$date_time = strtotime($today->format('Y-m-d'));
 
$sql = ' wp_posts.post_title, wp_posts.ID 
FROM wp_posts 
INNER JOIN wp_postmeta 
ON ( wp_posts.ID = wp_postmeta.post_id ) 
WHERE wp_posts.post_type = "shop_coupon"
AND wp_posts.post_status = "publish" 
AND (wp_postmeta.meta_key = "date_expires" 
AND (wp_postmeta.meta_value IS NULL OR wp_postmeta.meta_value = "" 
OR CONVERT(wp_postmeta.meta_value,UNSIGNED INTEGER) >= '.$date_time.')) 

AND wp_posts.ID 
not In 
(SELECT wp_postmeta.post_id 
FROM wp_postmeta 
WHERE 
wp_postmeta.meta_key = "customer_email" AND wp_postmeta.meta_value <> ""
)
AND wp_posts.ID 
In (SELECT wp_postmeta.post_id 
FROM wp_postmeta 
WHERE 
    wp_postmeta.meta_key = "show_on_list" AND wp_postmeta.meta_value =1 )
GROUP BY wp_posts.ID
        DESC LIMIT 0, 1000
';
$sql = 'SELECT'.$sql;
$coupons =  $wpdb->get_col($sql ) ;
return $coupons;
}

function coupon_allow_email($email_user) {
	if (empty($email_user)) return array();
	global $wpdb;
$today = date('Y-m-d');
$today = new DateTime($today, new DateTimeZone('Asia/Singapore'));
$date_time = strtotime($today->format('Y-m-d'));
 
$sql = ' wp_posts.post_title, wp_posts.ID 
FROM wp_posts 
INNER JOIN wp_postmeta 
ON ( wp_posts.ID = wp_postmeta.post_id ) 
WHERE wp_posts.post_type = "shop_coupon"
AND wp_posts.post_status = "publish" 
AND (wp_postmeta.meta_key = "date_expires" 
AND (wp_postmeta.meta_value IS NULL OR wp_postmeta.meta_value = "" 
OR CONVERT(wp_postmeta.meta_value,UNSIGNED INTEGER) >= '.$date_time.')) 

AND wp_posts.ID 
In 
(SELECT wp_postmeta.post_id 
FROM wp_postmeta 
WHERE 
wp_postmeta.meta_key = "customer_email" AND wp_postmeta.meta_value like "%'.$email_user.'%"
)

GROUP BY wp_posts.ID
        DESC LIMIT 0, 1000
';
$sql = 'SELECT'.$sql;
$coupons =  $wpdb->get_col($sql ) ;
return $coupons;
}



function get_all_coupons_valid($email_user) {
	$coupons1 = coupons_valid();
	$coupons2 = coupon_allow_email($email_user);
	$coupons = array_merge($coupons1,$coupons2);

	if (count($coupons) > 0) {
	foreach ($coupons as $key => $id) {
		$id_coupon = get_id_coupon($id);
		//$coupon2 = new WC_Coupon( $coupon->post_name );
		$coupon2 = new WC_Coupon( $id );
		$coupon_code = $coupon2->get_code();	

		if (function_exists('check_coupon_in_cart') && !check_coupon_in_cart($coupon2)) {
			unset($coupons[$key]);
		}
		
		$usage_limit = get_post_meta($id_coupon,'usage_limit',true);
		$usage_count = get_post_meta($id_coupon,'usage_count',true);
		if ($usage_limit > 0 && $usage_count >= $usage_limit) {			
			unset($coupons[$key]);
		}
		if (false === check_coupon_valid_product_sale($coupon2)) {
			unset($coupons[$key]);
		}
		if (is_user_logged_in() && !check_order_first() && $coupon_code == strtolower(coupon_code_order_first())) {
			unset($coupons[$key]);
		}
		$enable = get_field('show_on_list',$id_coupon)??0;		
		if ($enable != 1) {
			unset($coupons[$key]);
		}


	}
}
	return $coupons;

}

add_action( 'woocommerce_checkout_process', 'my_custom_checkout_field_process2' );
function my_custom_checkout_field_process2( ) {
	global $woocommerce;

	if (!is_user_logged_in() && !isset($_POST['createaccount'])){
		if ( $woocommerce->cart->has_discount( coupon_code_order_first() ) ){ 
		wc_add_notice( __( coupon_code_order_first() .' is invalid. Please remove it.' ), 'error' );
	}


	}

	}



