<?php
function taxonomy_product() {
	return  array(
		'occasions' => 'Occasions',
		'material' => 'Material',
		'designer_collections' => 'Designer Collections'
	);
}
// coupon order first
function coupon_code_order_first() {
	return get_field('coupon_code_order_first','option') ??'';
}
function check_coupon_individual_use() {
	global $woocommerce;
	$individual_use =  false;
	$counpon_exits = $woocommerce->cart->get_applied_coupons();
	if (count($counpon_exits) > 0 ) {
		foreach ($counpon_exits as $key => $value) {
			$coupon = new WC_Coupon( $value );
			if ($coupon -> get_individual_use() && $coupon->get_code() != coupon_code_order_first()) {
				$individual_use =  true;
				break;
			}
		}

	}
	return $individual_use;

}
function check_order_first() {
	$check = false;
	if (is_user_logged_in()) {
		//$order_statuses = array('wc-on-hold', 'wc-processing', 'wc-completed');
		$order_statuses = array('wc-on-hold', 'wc-processing', 'wc-completed','wc-pending','wc-cancelled','wc-refunded');
		$customer_user_id = get_current_user_id();
		$customer_orders = wc_get_orders( array(
		    'meta_key' 		=> '_customer_user',
		    'meta_value' 	=> $customer_user_id,
		    'post_status' 	=> $order_statuses,
		    'numberposts' 	=> -1
		) );
		if (count($customer_orders) == 0) $check = true;
	}
	return $check;
}
if (isset($_GET['dev'])) {
	/*echo '<pre>';
var_dump(get_post(18078));
echo '</pre>';*/
//var_dump(check_order_first());
}


function check_coupon_exits() {
	$check = false;
	$args = array(
	  'name'        => coupon_code_order_first(),
	  'post_type'   => 'shop_coupon',
	  'post_status' => 'publish',
	  'numberposts' => 1
	);
	$my_posts = get_posts($args);
	/*var_dump(coupon_code_order_first());
	echo '<pre>';
	var_dump($my_posts);
	echo '</pre>';*/
	if( $my_posts ) $check = true;
	 return $check;
}
function get_ex_product_ids($coupon_id,$coupon) {

	$ex_product_ids = count($coupon->get_excluded_product_ids( 'edit' )) > 0  ? $coupon->get_excluded_product_ids( 'edit' ) : array_filter( (array) explode( ',', get_post_meta( $coupon_id, 'custom_exclude_product_ids', true ) ) )
	;

	return $ex_product_ids;
}

//var_dump(enable_disable_coupon('sknew5'));

function auto_coupon_first($coupon_code) {

	 // coupon
	global $woocommerce;


	if (enable_disable_coupon($coupon_code)) {
		$coupon_id =  wc_get_coupon_id_by_code( $coupon_code );
	if (check_order_first() && check_coupon_exits()) {  
		$coupon      = new WC_Coupon( $coupon_code );
		if ($coupon->is_valid()){
		$min_amount_coupon = $coupon->get_minimum_amount();
		$total_cart = WC()->cart->subtotal;
		if ($total_cart >= $min_amount_coupon )  {
			$valid = true;
			$valid_cate = true;
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$parent_id = $cart_item['product_id'];
				$product_data = $cart_item['data'];
	    		$product_id = $product_data -> get_id(); // simple product id or variation id
	    		$excluded_product_ids = get_ex_product_ids($coupon_id,$coupon)	 ;
			if ( sizeof($excluded_product_ids) > 0 ) {	
				$check_product_in_exclude = check_product_in_exclude($cart_item, $ex_product_ids);
				if ($check_product_in_exclude)	$valid = false;		        
		    }

		  
	   }


		if ( !WC()->cart->has_discount( $coupon_code ) && $valid && $valid_cate)
			WC()->cart->add_discount( $coupon_code );
		}
	}

	}
}

}
function get_id_coupon($slug_coupon) {  	
	if (!$slug_coupon) return array();
	if ( wc_get_coupon_id_by_code( $slug_coupon ) )
		$id = wc_get_coupon_id_by_code( $slug_coupon );
	else $id = 0;
	return $id;
  }

function enable_disable_coupon($slug_coupon) {
	
  	global $post;
  	$id = get_id_coupon($slug_coupon);
  	$check_coupon = get_field('enable',$id);
	if ($check_coupon) return true;
	else return false;
}
 add_action( 'woocommerce_before_checkout_form', 'oa_gift');
add_action( 'woocommerce_before_mini_cart', 'oa_gift' );
add_action( 'woocommerce_before_cart', 'oa_gift' );
function oa_gift() {
//	wp_mail('devtest0909@gmail.com','before cart','how do you do');
	//var_dump('abc');exit;
	/* var_dump(WC()->cart->has_discount( $coupon_code ));
	   var_dump($valid);
	   var_dump($valid_cate);
	   exit;*/
global $woocommerce,$product;
WC()->session->set( 'wc_notices', null );
	$cart1 = $woocommerce->cart->cart_contents;
	$total 		= floatval($woocommerce->cart->get_cart_contents_total());	
	// add gift
	
		
   if (!check_coupon_individual_use()) {
   	if (check_order_first() && is_user_logged_in())
   		auto_coupon_first(coupon_code_order_first());
   }
   // end coupon
	$woocommerce->cart->calculate_totals();
	$woocommerce->cart->set_session();
	// Maybe set cart cookies
	$woocommerce->cart->maybe_set_cart_cookies();
	 //exit;
}
// end coupon order first



function get_value_include_taxonomy($coupon_id,$in_ex) {
	// in is custom_product_
	// ex is custom_exclude_product_
	$taxonomies = taxonomy_product();
	$in_terms = array();
	foreach ($taxonomies as $key => $taxonomy) {
		$name = $in_ex.$key;
		$category_ids = get_post_meta( $coupon_id,$name , true ) ? array_filter( (array) explode( ',', get_post_meta( $coupon_id, $name, true ) ) ) : array();
		if (count($category_ids) > 0) {
			foreach ($category_ids as $key => $id) {
				$in_terms[] = $id;
			}
		}
	}
	return $in_terms;
}

function check_in_collection($collection,$cart_item,$product_id) {
	$valid = true;
	$arr_taxonomy_product = array();
	foreach (taxonomy_product() as $key => $value) {
		$arr_taxonomy_product[] = $key;
	}

	if (count($collection) == 0) $valid = true;
	else {
		$product_cats = wp_get_post_terms( $product_id, $arr_taxonomy_product, array( "fields" => "ids" ) );
		if ( count($collection) > 0 && sizeof( array_intersect( $collection, $product_cats ) ) == 0 ) {
		$valid = false;			           
		}	 
		
	} 
	return $valid;
}

function check_ex_collection($collection,$cart_item,$product_id) {
	$valid = true;
	$arr_taxonomy_product = array();
	foreach (taxonomy_product() as $key => $value) {
		$arr_taxonomy_product[] = $key;
	}

	if (count($collection) == 0) $valid = false;
	else {
		$product_cats = wp_get_post_terms( $product_id, $arr_taxonomy_product, array( "fields" => "ids" ) );
		if ( count($collection) > 0 && sizeof( array_intersect( $collection, $product_cats ) ) == 0 ) {
		$valid = false;			           
		}	 
		
	} 
	return $valid;
}

//$cart_item['data'];
function product_invalid($cart_item,$coupon) {
	// $cart_item_data = $cart_item['data'];
	global $woocommerce;
	$valid1 = true;
	$coupon_code  = $coupon -> get_code();
	$coupon_id = wc_get_coupon_id_by_code( $coupon_code );
	$in_collections = get_value_include_taxonomy($coupon_id,'custom_product_');
	$ex_collections = get_value_include_taxonomy($coupon_id,'custom_exclude_product_');	
	$product_id = $cart_item['product_id'];
	//var_dump($product_id);
	//debug($in_collections);
	//debug($ex_collections);
	$check_in_collection = check_in_collection($in_collections,$cart_item,$product_id);
	$check_ex_collection = check_ex_collection($ex_collections,$cart_item,$product_id);


	if ($check_ex_collection) {
		$valid1 = false;
	}
	if (!$check_in_collection) {
		$valid1 = false;
	}

	$in_category = $coupon->get_product_categories();
	if (count($in_category) > 0){
		if ( !has_term( $in_category, 'product_cat', $product_id ) ) {
	  	$valid1 = false;
	  }
	}
	
	$include_ids =  $coupon->get_product_ids();
	if (!count($include_ids) > 0) {
		if (in_array($product_id, $include_ids)) {
			$valid1 = false;
		}
	}

	$ex_products = $coupon->get_excluded_product_ids( 'edit' );
	/*var_dump($ex_products);
	var_dump(get_the_title(14884));*/
	//var_dump($product_id);
	if (count($ex_products) > 0) {
		if (in_array($product_id, $ex_products)) {
			$valid1 = false;
		}
	}

	$ex_cates = $coupon->get_excluded_product_categories( 'edit' );
	if (count($ex_cates) > 0) {
		if ( has_term( $ex_cates, 'product_cat', $product_id ) ) {
	  	$valid1 = false;
	  }
	}

	  
//var_dump($valid1);

	
    return $valid1;
}

function check_coupon_in_cart($coupon) {
	global $woocommerce;		
	$min_amount = intval($coupon -> get_minimum_amount());		

	$total_cart_collection = 0;	
	$check = true;
	$i = 0;
	if (sizeof($woocommerce->cart->get_cart()) > 0) {
			foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) {
				/*debug($cart_item);
				debug($coupon);*/
			
				if (product_invalid($cart_item,$coupon)) {
					 $qty = $cart_item['quantity'];
			            $price = $cart_item['data'] -> get_price();			            
			            $total_cart_collection +=  floatval($qty) * floatval($price);
			            $i ++;
				}
					    
			}
		} 

	if ($total_cart_collection < $min_amount ) $check = false;
	if ($i == 0 ) $check = false;
	if ($min_amount == 0 && $total_cart_collection == $min_amount ) $check = false;
	return $check;

}


function check_coupon_valid_product_sale($coupon_obj) {
	//$coupon_obj->get_exclude_sale_items();
	$exclude_sale_items = $coupon_obj->get_exclude_sale_items();
	$valid = false;
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$parent_id = $cart_item['product_id'];
				$product_data = $cart_item['data'];
				if ( !$product_data->is_on_sale() ) {
                $valid = true;
            }
		  
	   }
	  if ($exclude_sale_items && false == $valid ) return false;
	  else return true;
}


add_filter('woocommerce_coupon_is_valid', 'custom_woocommerce_coupon_is_valid2', 1, 2 );

function custom_woocommerce_coupon_is_valid2( $valid, $coupon ) {	
	global $woocommerce;
	$coupon_code = $coupon->get_code();	
	$valid = check_coupon_in_cart($coupon);
	//var_dump($coupon->get_code());

	// coupon first order

	/*if ( is_user_logged_in() && get_current_user_id() == 138) {
		var_dump($coupon->get_code());
	}*/

	if ($coupon->get_code() == coupon_code_order_first()){	
		if (false === check_coupon_valid_product_sale($coupon)) return  false;
		if (!check_order_first() && is_user_logged_in()) return  false;
		//var_dump(enable_disable_coupon($coupon_code));
/*
		if (!check_order_first()) return  false;
		if (!is_user_logged_in()) return  false;*/
		if (check_coupon_individual_use()) return  false;
		if (!enable_disable_coupon($coupon_code)) return  false;
	} 
	// end coupon first order

	return $valid;
}
//add_filter('woocommerce_coupon_is_valid_for_product', 'woocommerce_coupon_is_valid_for_product', 5, 4);

function woocommerce_coupon_get_discount_amount($discount, $discounting_amount, $cart_item, $single, $coupon) {
	//debug($cart_item);

	global $woocommerce;
	$valid = product_invalid($cart_item,$coupon);
   if (!$valid) $discount = 0;
   return $discount;
}
//add hook to coupon amount hook
add_filter('woocommerce_coupon_get_discount_amount', 'woocommerce_coupon_get_discount_amount', 99, 5);


// add new field overwrite old field

add_action('woocommerce_coupon_options_usage_restriction','add_new',20,2) ;
function add_new($coupon_id, $coupon) {
	?>
<?php
$array_taxonomy = taxonomy_product();
//debug($array_taxonomy);
	
	foreach ($array_taxonomy as $key => $taxonomy) {	
	
?>


<!--  Categories. -->
<div class="options_group">

	<p class="form-field coupon-field">
		<?php
		$in = 'Include '.$taxonomy;
		$name = 'custom_product_'.$key;
		?>
		<label for="product_categories"><?php _e($in, 'woocommerce' ); ?></label>
		<select id="<?php echo $name; ?>" name="custom_product_<?php echo $key; ?>[]" style="width: 50%;"  class="wc-enhanced-select" multiple="multiple" data-placeholder="<?php esc_attr_e( 'Any category', 'woocommerce' ); ?>">
			<?php
			
			$category_ids = get_post_meta( $coupon_id,$name , true ) ? array_filter( (array) explode( ',', get_post_meta( $coupon_id, $name, true ) ) ) : array();				
			$categories   = get_terms( $key, 'orderby=name&hide_empty=0' );

			if ( $categories ) {
				foreach ( $categories as $cat ) {
					echo '<option value="' . esc_attr( $cat->term_id ) . '"' . wc_selected( $cat->term_id, $category_ids ) . '>' . esc_html( $cat->name ) . '</option>';
				}
			}
			?>
		</select> <?php echo wc_help_tip( __( 'Product categories that the coupon will be applied to, or that need to be in the cart in order for the "Fixed cart discount" to be applied.', 'woocommerce' ) ); ?>
	</p>

	<?php // Exclude Categories. ?>
	<p class="form-field coupon-field">
		<?php
			$ex = 'Exclude '.$taxonomy;
			$name_ex = 'custom_exclude_product_'.$key;
		?>
		<label for="<?php echo $name_ex; ?>"><?php _e( $ex, 'woocommerce' ); ?></label>
		<select id="<?php echo $name_ex; ?>" name="<?php echo $name_ex; ?>[]" style="width: 50%;"  class="wc-enhanced-select" multiple="multiple" data-placeholder="<?php esc_attr_e( 'No categories', 'woocommerce' ); ?>">
			<?php
			$category_ids = get_post_meta( $coupon_id, $name_ex, true ) ? array_filter( (array) explode( ',', get_post_meta( $coupon_id, $name_ex, true ) ) ) : array();
			$categories   = get_terms( $key, 'orderby=name&hide_empty=0' );

			if ( $categories ) {
				foreach ( $categories as $cat ) {
					echo '<option value="' . esc_attr( $cat->term_id ) . '"' . wc_selected( $cat->term_id, $category_ids ) . '>' . esc_html( $cat->name ) . '</option>';
				}
			}
			?>
		</select>
		<?php echo wc_help_tip( __( 'Product categories that the coupon will not be applied to, or that cannot be in the cart in order for the "Fixed cart discount" to be applied.', 'woocommerce' ) ); ?>
	</p>
</div>
<?php } ?>
<?php
}


add_action( 'woocommerce_update_coupon', 'woocommerce_coupon_options_save', 50, 2 );
function woocommerce_coupon_options_save( $coupon_id, $coupon ) {
	$array_taxonomy = taxonomy_product();
//debug($array_taxonomy);
	
	foreach ($array_taxonomy as $key => $taxonomy) {
		$name_in = 'custom_product_'.$key;
		$name_ex = 'custom_exclude_product_'.$key;

		$terms_in = isset( $_POST[$name_in] ) ? implode( ',', array_filter( array_map( 'intval', $_POST[$name_in] ) ) ) : '';
		$terms_ex =  isset( $_POST[$name_ex] ) ? implode( ',', array_filter( array_map( 'intval', $_POST[$name_ex] ) ) ) : '';	
		update_post_meta( $coupon_id, $name_in, $terms_in);
	update_post_meta( $coupon_id, $name_ex, $terms_ex );
	}

}