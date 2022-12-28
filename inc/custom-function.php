<?php
function custom_font_and_message_add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
    if(isset($_POST['pa_font_type'])) {
        $cart_item_data['pa_font_type'] = ucfirst($_POST['pa_font_type']);
    }
    if(isset($_POST['engraving_message'])) {
        $cart_item_data['engraving_message'] = ($_POST['engraving_message']);
    }
    return $cart_item_data;
   }
add_filter( 'woocommerce_add_cart_item_data', 'custom_font_and_message_add_cart_item_data', 10, 3 ); 

function custom_font_and_message_get_item_data( $item_data, $cart_item_data ) {
 $_product_id = $cart_item_data['product_id'];
 if ( $cart_item_data['data']->is_type( 'variation' ) && is_array( $cart_item_data['variation'] ) && check_product_in_diamond($_product_id)) {
    $item_data = [];
             
              $item_data[] = array(
                             'key' => __( 'Centerstone', 'text_domain' ),
                             'value' => get_meta_centerstone ($_product_id)
                         );
     
     foreach ( $cart_item_data['variation'] as $name => $value ) {
         $taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );
 
         if ( taxonomy_exists( $taxonomy ) ) {
             // If this is a term slug, get the term's nice name.
             $term = get_term_by( 'slug', $value, $taxonomy );
             if ( ! is_wp_error( $term ) && $term && $term->name ) {
                 $value = $term->name;
             }
             $label = wc_attribute_label( $taxonomy );
         } else {
             // If this is a custom option slug, get the options name.
             $value = apply_filters( 'woocommerce_variation_option_name', $value, null, $taxonomy, $cart_item_data['data'] );
             $label = wc_attribute_label( str_replace( 'attribute_', '', $name ), $cart_item_data['data'] );
         }
 
         // Check the nicename against the title.
         if ( '' === $value || wc_is_attribute_in_product_name( $value, $cart_item_data['data']->get_name() ) ) {
             continue;
         }
 
         $item_data[] = array(
             'key'   => $label,
             'value' => $value,
         );
     }
 }
 
 
     if( isset( $cart_item_data['pa_font_type'] ) ) {
         $item_data[] = array(
             'key' => __( 'Font Type', 'text_domain' ),
             'value' => wc_clean($cart_item_data['pa_font_type'] )
         );
     }
     if( isset( $cart_item_data['engraving_message'] )  && !empty($cart_item_data['engraving_message'])) {
         $item_data[] = array(
             'key' => __( 'Engaving Message', 'text_domain' ),
             'value' => wc_clean( $cart_item_data['engraving_message'] )
         );
     }
     return $item_data;
 
 }
add_filter( 'woocommerce_get_item_data', 'custom_font_and_message_get_item_data', 20, 2 );

function custom_font_and_message_checkout_create_order_line_item( $item, $cart_item_key, $values, $order ) {
    if( isset( $values['pa_font_type'] ) ) {
        $item->add_meta_data(
            __( 'Font Type', 'text_domain' ),
            ucfirst($values['pa_font_type']),
            true
        );
    }
    if( isset( $values['engraving_message'] ) ) {
        $item->add_meta_data(
            __( 'Engraving Mesage', 'text_domain' ),
            ($values['engraving_message']),
            true
        );
    }
}
add_action( 'woocommerce_checkout_create_order_line_item', 'custom_font_and_message_checkout_create_order_line_item', 10, 4 );

////////////////////////////////////////////////

add_action("woocommerce_after_add_to_cart_quantity","custom_woocommerce_after_add_to_cart_quantity");
function custom_woocommerce_after_add_to_cart_quantity(){
    global $product;
    $class_child_diamond = function_exists('class_child_product') ? class_child_product($product->get_id()):'';
    if (!empty($class_child_diamond)):

    $font_type_terms = get_terms(array(
        'taxonomy' => 'pa_font-type',
        'hide_empty' => false,
        'orderby' => 'id'
    ));
    $message = '';
    if($product->is_type('variable')) {
        $variation_attributes = $product->get_variation_attributes();
        $your_engraving_message = $variation_attributes["pa_your-engraving-message"]??array(); 
        $message = array_pop($your_engraving_message);
    }

    $term_message = get_term_by("slug", $message, "pa_your-engraving-message");
    $term_message_label = $term_message ? get_field("placeholder",$term_message->taxonomy."_".$term_message->term_id) : "";
    $text_of_button_edit_engraving = get_field("text_of_button_edit_engraving","option")?? "";
    $text_placeholder_of_select_font_type = get_field("text_placeholder_of_select_font_type","option") ?? "";
    $text_label_of_engraving_guide = get_field("text_label_of_engraving_guide","option") ?? "";
    $text_link_of_engraving_guide = get_field("text_link_of_engraving_guide","option") ?? "/";
    $max_length_of_message = $term_message ? get_field("max_length",$term_message->taxonomy."_".$term_message->term_id) : "";
    ?>
    <!-- #70977 -->
    <div class="engraving">
        <div class="engraving-header">
            <button class="engraving-item engraving-button" id="edit-engraving" type="button">
                <span class="button--text"><?php echo $text_of_button_edit_engraving; ?></span>
            </button>
            <span class="text-demo"></span>
            <span class="mock--edit"><span class="mock--edit-text">
            <svg xmlns="http://www.w3.org/2000/svg" width="7" height="7" viewBox="0 0 25 25" fill="none"><path d="M2.37106 0.406738L0.407089 2.37071L10.5362 12.4998L0.407089 22.629L2.37106 24.5929L12.5002 14.4638L22.6293 24.5929L24.5933 22.629L14.4642 12.4998L24.5933 2.37071L22.6293 0.406738L12.5002 10.5359L2.37106 0.406738Z" fill="black"></path></svg>
            Clear Engraving</span></span>
        </div>

        <div class="engraving-item engraving-item-edit engraving-item--canhide" >
            <select id="trigger_pa_font-type" name="pa_font_type"> 
                <option value="" disabled selected ><?php echo $text_placeholder_of_select_font_type; ?></option>
                <?php
                foreach($font_type_terms as $font_type_term){
                    $slug = $font_type_term->slug;
                    $font_type_term = get_term_by("slug", $slug, "pa_font-type");
                    $acf_font_type_term_id = $font_type_term->taxonomy."_".$font_type_term->term_id;
                    $term_current_font_familty = get_field("font_family",$acf_font_type_term_id)?? "";
                    ?>
                    <option data-font-family="<?php echo $term_current_font_familty; ?>" value="<?php echo urldecode($font_type_term->slug); ?>"><?php echo $font_type_term->name; ?></option>
                    <?php
                }
                ?>
            </select>
            <!-- #70977 -->
            <?php
            $eng_font  = [];
            $cn_font = [];

            foreach($font_type_terms as $font_type_term) {
                $slug = $font_type_term->slug;
                $term = get_term_by("slug", $slug, "pa_font-type");  
                $is_cn = get_field('is_chinese', 'term_'.$font_type_term->term_id) ?? false;
                if($is_cn) {
                    array_push($cn_font, $slug);
                } else {
                    array_push($eng_font, $slug);
                }
            }
            ?>
            <div class="product-variable variable-language">
                <div class="container">
                    <header>
                        <ul class="tab-head">
                            <li class="tab-choose active" data-tab="eng">English</li>
                            <li class="tab-choose" data-tab="cn">Chinese</li>
                        </ul>
                        <input type="hidden" name="lag_active" id = "lag_active" value="eng">
                    </header>
                    <main>
                        <ul class="tab-font tab-eng active">                            
                            <?php
                            foreach($eng_font as $slug){
                                $term = get_term_by("slug", $slug, "pa_font-type");
                                $acf_font_type_term_id = $term->taxonomy."_".$term->term_id;
                                $term_current_font_familty = get_field("font_family",$acf_font_type_term_id)?? "";
                                ?>
                                <li data-font-family="<?php echo $term_current_font_familty; ?>" data-value="<?php echo $term->slug; ?>" style="font-family: <?php echo $term_current_font_familty; ?>"><?php echo $term->name; ?></li>
                                <?php
                            }
                            ?>
                        </ul>
                        <ul class="tab-font tab-cn">
                            <?php
                            foreach($cn_font as $slug){
                                $term = get_term_by("slug", $slug, "pa_font-type");
                                $acf_font_type_term_id = $term->taxonomy."_".$term->term_id;
                                $term_current_font_familty = get_field("font_family",$acf_font_type_term_id)?? "";
                                ?>
                                <li data-font-family="<?php echo $term_current_font_familty; ?>" data-value="<?php echo urldecode($term->slug); ?>" style="font-family: <?php echo $term_current_font_familty; ?>"><?php echo $term->name; ?></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </main>

                </div>
            </div>
            <!-- End #70977 -->
        </div>
        
        <div class="engraving-item engraving-item-edit engraving-item--message" >
            <input id="message" maxlength="<?php if($max_length_of_message){ echo $max_length_of_message; } else { echo '15'; }  ?>" data-select='<?php echo  $term_message->slug ?? ''; ?>' name="engraving_message" type="text" placeholder="<?php echo $term_message_label ?: 'Type Message...'; ?>" />
            <div class="engraving-footer">
                <p class="notice">Character limit: <span class="message-amount">0</span>/15</p>
                <button class="engraving-item engraving-button" id="edit-engraving" type="button">
                    <span class="button--text"><?php echo $text_of_button_edit_engraving; ?></span>
                </button>
            </div>
        </div>
        <?php
        ?>
        <div class="engraving-item engraving-item--canhide" id="block-engraving-guide">
            <?php if(!empty($text_link_of_engraving_guide)): ?>
                <a href="<?php echo $text_link_of_engraving_guide; ?>"><?php echo $text_label_of_engraving_guide; ?></a>
            <?php else: ?>
                <p><?php echo $text_label_of_engraving_guide; ?></a></p>
            <?php endif; ?>
        </div>
    </div>
    <?php 
    elseif (is_allow_engraving($product)): 
        get_template_part( "template-parts/content", "engraving-product" );
    ?>
    <?php endif;
}

function is_allow_engraving($product){
    $is_allow = false; 
    if($product){
        if($product->is_type( 'variable' )){
            $product_id = $product->get_id();
            $list_term_allow_engraving = get_field("allow_engraving_for","option") ?? array();
            foreach($list_term_allow_engraving as $term){
                if(has_term($term->term_id,$term->taxonomy,$product_id)){
                    $is_allow = true;
                }
            }
            if($is_allow){
                $show_engraving = get_field("show_engraving",$product_id) ?? false;
                // $$product->get_available_variations()
                $variation_attributes = $product->get_variation_attributes();
                if(!isset($variation_attributes["pa_font-type"]) || !isset($variation_attributes["pa_your-engraving-message"])){
                    $is_allow = false;
                } 
    
                if(!$show_engraving){
                    $is_allow = false;
                }
            }
        }
    }
    return $is_allow;
}

add_filter("woocommerce_add_to_cart_validation","custom_woocommerce_add_to_cart_validation",10,3);
function custom_woocommerce_add_to_cart_validation($passed, $product_id, $quantity){
    if(isset($_POST['product_id']) && $_POST["variation_id"]){
        $product_id = absint($_POST['product_id']);
        $variation_id = absint($_POST["variation_id"]);
        $product = wc_get_product($product_id);
        if(is_allow_engraving($product)){
            $variation_attributes = $product->get_variation_attributes();
            $your_engraving_message = $variation_attributes["pa_your-engraving-message"]; 
            $message = array_pop($your_engraving_message);
            $term_message = get_term_by("slug", $message, "pa_your-engraving-message");
            $message_input_name = $term_message->taxonomy."_".$term_message->term_id;
            $message_input = isset($_POST[$message_input_name]) ? wp_unslash( $_POST[$message_input_name] ) : "";
    
            $post_message_input_name = $variation_id."_".$message_input_name;
            
            $max_length_of_message = is_numeric(get_field("max_length",$message_input_name)) ? get_field("max_length",$message_input_name) : "";
            if($max_length_of_message && strlen($message_input) > $max_length_of_message){
                $message_input = substr($message_input,0,$max_length_of_message);
            }
            WC()->session->set($post_message_input_name,$message_input);
        }
    }
    return $passed;
}

add_filter("woocommerce_add_cart_item_data","custom_woocommerce_add_cart_item_data",10,4);
function custom_woocommerce_add_cart_item_data($cart_item_data, $product_id, $variation_id, $quantity){
    $product = wc_get_product($product_id);
    if(is_allow_engraving($product)){
        $variation_attributes = $product->get_variation_attributes();
        $your_engraving_message = $variation_attributes["pa_your-engraving-message"]; 
        $message = array_pop($your_engraving_message);
        $term_message = get_term_by("slug", $message, "pa_your-engraving-message");
        $message_input_name = $term_message->taxonomy."_".$term_message->term_id;
        $post_message_input_name = $variation_id."_".$message_input_name;
        $message_input_value = WC()->session->get($post_message_input_name);
        $cart_item_data[$message_input_name] = $message_input_value;
        $cart_item_data["variation"]["attribute_".$term_message->taxonomy] = $cart_item_data[$message_input_name];
    }

    return $cart_item_data;
}
add_filter("woocommerce_add_cart_item","custom_woocommerce_add_cart_item");
function custom_woocommerce_add_cart_item($cart_item_data){
    $product_id = $cart_item_data["product_id"];
    $variation_id = $cart_item_data["variation_id"];
    $product = wc_get_product($product_id);
    if(is_allow_engraving($product)){
        $variation_attributes = $product->get_variation_attributes();
        $your_engraving_message = $variation_attributes["pa_your-engraving-message"]; 
        $message = array_pop($your_engraving_message);
        $term_message = get_term_by("slug", $message, "pa_your-engraving-message");
        $message_input_name = $term_message->taxonomy."_".$term_message->term_id;
        $post_message_input_name = $variation_id."_".$message_input_name; 
        $cart_item_data["variation"]["attribute_".$term_message->taxonomy] = $cart_item_data[$message_input_name];
    }

    return $cart_item_data;
}

function engraving_taxonomy(){
    $engraving_taxonomy = array();
    foreach(engraving_attributes() as $v){
        array_push($engraving_taxonomy,"pa_".$v);
    }
    return $engraving_taxonomy;
}
function engraving_attributes(){
    return array("font-type",
    "your-engraving-message");
}
                
add_action("woocommerce_add_to_cart","custom_woocommerce_add_to_cart",10,6);
function custom_woocommerce_add_to_cart($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data){
    $product = wc_get_product($product_id);
    if(is_allow_engraving($product)){
        $variation_attributes = $product->get_variation_attributes();
        $your_engraving_message = $variation_attributes["pa_your-engraving-message"]; 
        $message = array_pop($your_engraving_message);
        $term_message = get_term_by("slug", $message, "pa_your-engraving-message");
        $message_input_name = $term_message->taxonomy."_".$term_message->term_id;
        $post_message_input_name = $variation_id."_".$message_input_name; 
        /*if(empty($cart_item_data[$message_input_name])){
            throw new Exception( sprintf( __( 'Message is empty.', 'woocommerce' )) );
        }*/
    }
}
// shipping option
function custom_woocommerce_shipping_methods(){
    $shipping_methods = WC()->shipping()->get_shipping_methods(); 
    $f = true;
	foreach($shipping_methods as $k => $v){
        $id = $v->id;
		add_filter("woocommerce_shipping_instance_form_fields_".$k,"custom_woocommerce_shipping_methods_woocommerce_shipping_instance_form_fields");
    }
    add_filter("woocommerce_shipping_packages", "custom_woocommerce_woocommerce_shipping_packages");
} 
function custom_woocommerce_woocommerce_shipping_packages($packages){

    $total = WC()->cart->get_displayed_subtotal();

    if ( WC()->cart->display_prices_including_tax() ) {
        $total = round( $total - ( WC()->cart->get_discount_total() + WC()->cart->get_discount_tax() ), wc_get_price_decimals() );
    } else {
        $total = round( $total - WC()->cart->get_discount_total(), wc_get_price_decimals() );
    }
    // check
    $stack_packages_pending = array();
    foreach($packages as $k => $package){
        $key_rates_pending_unset = array();
        if(isset($package['rates'])){
            foreach($package['rates'] as $k2 => $rate){
                $max_order_amount = WC_Shipping_Zones::get_shipping_method($rate->instance_id)->get_option("max_order_amount",null);
                if(is_numeric($max_order_amount)){
                    if($total > $max_order_amount){
                        array_push($key_rates_pending_unset,$k2);
                    }
                }
            }
        }
        $stack_packages_pending[$k][] =  $key_rates_pending_unset;
    }
    // do check
    foreach($stack_packages_pending as $k => $v){
        foreach($v as $v1){
            foreach($v1 as $v2){
                if(isset($packages[$k]["rates"][$v2])){
                    unset($packages[$k]["rates"][$v2]);
                }
            }
        }
    }
    return $packages;
}
add_action("woocommerce_init","custom_woocommerce_shipping_methods");
// add_filter("woocommerce_shipping_".$k."_is_available","custom_woocommerce_woocommerce_shipping_is_available",99,3);

add_action("woocommerce_shipping_init","custom_woocommerce_woocommerce_shipping_init");
function custom_woocommerce_woocommerce_shipping_init(){
    // $shipping_methods = WC()->shipping()->get_shipping_methods();
    // $packages = WC()->shipping()->get_packages();
    // var_dump($packages);
    // $a = true;
    // var_dump($shipping_methods);
	// foreach($shipping_methods as $k => $v){
    //     if($a){
    //         $id = $v->id;
    //         // add_filter("woocommerce_shipping_".$id."_is_available","custom_woocommerce_woocommerce_shipping_is_available",99,3);
    //         $a = false;
    //     }
    // }
}

function custom_woocommerce_woocommerce_shipping_is_available( $is_available, $package, $ship_object ){
    // if($is_available){
    //     $max_order_amount = $ship_object->get_option("max_order_amount",0);
    //     $total = WC()->cart->get_displayed_subtotal();

    //     if ( WC()->cart->display_prices_including_tax() ) {
    //         $total = round( $total - ( WC()->cart->get_discount_total() + WC()->cart->get_discount_tax() ), wc_get_price_decimals() );
    //     } else {
    //         $total = round( $total - WC()->cart->get_discount_total(), wc_get_price_decimals() );
    //     }
    //     // if ( $total < $max_order_amount ) {
    //         $is_available = false;
    //     // } 

    // }
    // return true;

}
// function custom_woocommerce_shipping_methods_instance_ids($order){
// 	$instance_ids = array();
// 	foreach($order->get_items("shipping") as $item){
// 		array_push($instance_ids,$item->get_instance_id());
// 	}
// 	return $instance_ids;
// }
// function get_shipping_days_time($order){
// 	$instance_ids = custom_woocommerce_shipping_methods_instance_ids($order);
// 	$delivery_zones = (array) WC_Shipping_Zones::get_zones();
// 	$zone = array_pop($delivery_zones);
// 	$shipping_methods = $zone["shipping_methods"];
// 	$shipping_days_time = "";
// 	foreach($shipping_methods as $v){
// 		if(in_array($v->instance_id,$instance_ids)){
// 			$shipping_days_time = $v->get_option("max_order_amount");
// 		}
// 	} 
// 	return $shipping_days_time;
// }

    // $instance_ids = custom_woocommerce_shipping_methods_instance_ids($order);
    add_action("wp_loaded","test_");
    function test_(){
        // $delivery_zones = (array) WC_Shipping_Zones::get_zones();
        // $zone = array_pop($delivery_zones);
        // $shipping_methods = $zone["shipping_methods"];
        // $shipping_days_time = "";
        // // var_dump($shipping_methods);
        // foreach($shipping_methods as $v){
        //     var_dump($v->id);
        //     add_action("woocommerce_update_options_shipping_".$v->id, "custom_woocommerce_woocommerce_shipping_is_available", 999, 3);
        //     if(in_array($v->instance_id,$instance_ids)){
        //         $shipping_days_time = $v->get_option("max_order_amount");
        //     }
        // }    
        // WC()->shipping()->calculate_shipping(WC()->cart->get_shipping_packages())
            // var_dump(WC()->cart->get_shipping_packages());
            // var_dump(WC()->shipping()->get_shipping_methods());
        
    // $packages           = WC()->shipping()->get_packages();
    // var_dump($packages);
    }
function custom_woocommerce_shipping_methods_woocommerce_shipping_instance_form_fields($instance_form_fields){
	$instance_form_fields["max_order_amount"] = array(
			'title'       => __( 'Max order Amount', 'woocommerce' ),
			'type'        => 'text',
			'placeholder' => '',
			'description' => __( 'Max order Amount', 'woocommerce' ),
            'default'     => '',
            'class'       => 'wc_input_price',
			'desc_tip'    => true,
    );

	return $instance_form_fields;
}
// end shipping option
// 12/16/20
add_filter('woocommerce_billing_fields', 'custom_nationality_woocommerce_billing_fields');
function custom_nationality_woocommerce_billing_fields($fields)
{
	 
    $fields['billing_nationality'] = array(
        'label' => __('Nationality', 'woocommerce'), // Add custom field label
        'placeholder' => _x('', 'placeholder', 'woocommerce'), // Add custom field placeholder
        'required' => true, // if field is required or not
        'clear' => false, // add clear or not
        'type' => 'select', // add field type
		'options'=>nationality_option(),
		'class'=>array("nationality-field","form-row-wide"),
        'priority' => '25'    // add class name
	);  
    $fields['billing_others_nationality'] = array(
        'label' => __('Others Nationality', 'woocommerce'), // Add custom field label 
        'required' => false, // if field is required or not
        'clear' => false, // add clear or not
		'type' => 'text', // add field type 
		'custom_attributes'=>array("data-label"=>"Others"),
        'priority' => '24'    // add class name
	);  
    return $fields;
}
add_filter("woocommerce_form_field","custom_nationality_woocommerce_form_field",10,4);
function custom_nationality_woocommerce_form_field($field, $key, $args, $value){
	if($key == "billing_others_nationality"){
		$field = $field;
	}
	// $field = $field."key".$key;
	return $field;
}
function nationality_option(){
	$billing_nationality_list = get_field("billing_nationality_list","option");
	if($billing_nationality_list){ 
		return array_column($billing_nationality_list,"label","name");
	}
	return array();
}  
add_action("woocommerce_after_checkout_validation","custom_nationality_woocommerce_after_checkout_validation",10,2);
function custom_nationality_woocommerce_after_checkout_validation($data,$errors){
	if(isset($data["billing_nationality"]) && $data["billing_nationality"] == "Others"){
		if(empty($data["billing_others_nationality"])){
			$errors->add( 'Billing', __( "Billing Others Nationality is empty", 'woocommerce' ) );
		}
	}
	if(isset($data["shipping_nationality"]) && $data["shipping_nationality"] == "Others"){
		if(empty($data["shipping_others_nationality"])){
			$errors->add( 'Shipping', __( "Shipping Others Nationality is empty", 'woocommerce' ) );
		}
	}
}
add_filter("woocommerce_get_order_address","custom_nationality_woocommerce_get_order_address",10,3);
function custom_nationality_woocommerce_get_order_address($data,$type,$order){
	if($type == "billing"){ 
		$billing_nationality = get_post_meta($order->get_id(),"_billing_nationality",true);
		if($billing_nationality == "Others"){
			$billing_nationality = get_post_meta($order->get_id(),"_billing_others_nationality",true);
		}
		$data["billing_nationality"] = $billing_nationality;
	}
	if($type == "shipping"){ 
		$shipping_nationality = get_post_meta($order->get_id(),"_shipping_nationality",true);
		if($shipping_nationality == "Others"){
			$shipping_nationality = get_post_meta($order->get_id(),"_shipping_others_nationality",true);
		}
		$data["shipping_nationality"] = $shipping_nationality;
	}
	return $data;
}
add_filter("woocommerce_admin_billing_fields","custom_nationality_woocommerce_admin_billing_fields");
function custom_nationality_woocommerce_admin_billing_fields($billing_fields){
	$billing_fields["nationality"] = array(
		"label" => __( 'Nationality', 'woocommerce' ),
		'show'  => false,
	);
	return $billing_fields;
}
add_filter("woocommerce_admin_shipping_fields","custom_nationality_woocommerce_admin_shipping_fields");
function custom_nationality_woocommerce_admin_shipping_fields($shipping_fields){
	$shipping_fields["nationality"] = array(
		"label" => __( 'Nationality', 'woocommerce' ),
		'show'  => false,
	);
	return $shipping_fields;
}
add_filter("woocommerce_formatted_address_replacements","custom_nationality_woocommerce_formatted_address_replacements",10,2);
function custom_nationality_woocommerce_formatted_address_replacements($replacements, $address ){
$replacements['{billing_nationality}'] = isset($address['billing_nationality']) ? $address['billing_nationality'] : ''; 
$replacements['{shipping_nationality}'] = isset($address['shipping_nationality']) ? $address['shipping_nationality'] : ''; 
return $replacements;
}

add_filter( 'woocommerce_localisation_address_formats', 'bbloomer_new_address_formats' );
function bbloomer_new_address_formats( $formats ) {
$formats['SG'] = "{name}\n{billing_nationality}\n{shipping_nationality}\n{company}\n{address_1}\n{address_2}\n{city}\n{state}\n{postcode}\n{country}";
return $formats;
}
// end 12/16/20	


// Add Shipping Minimum Rate 12/21/2020
function custom_woocommerce_shipping_methods_woocommerce_shipping_minimum_instance_form_fields($instance_form_fields){
    $instance_form_fields["shipping_minimum_value"] = array(
        'title'       => __( 'Shipping minimum value', 'woocommerce' ),
        'type'        => 'number',
        'placeholder' => '',
        'description' => __( 'Shipping minimum value', 'woocommerce' ),
        'default'     => '',
        'desc_tip'    => true,
);
	return $instance_form_fields;
}
function custom_woocommerce_shipping_minimum_methods(){
	$shipping_methods = WC()->shipping()->get_shipping_methods();
	foreach($shipping_methods as $k => $v){
		$id = $v->id;
		add_filter("woocommerce_shipping_instance_form_fields_".$k,"custom_woocommerce_shipping_methods_woocommerce_shipping_minimum_instance_form_fields");
	}
}
add_action("woocommerce_init","custom_woocommerce_shipping_minimum_methods");

function get_shipping_method_from_method_id( $method_rate_id = '' ){
    if( ! empty( $method_rate_id ) ){
        $method_key_id = str_replace( ':', '_', $method_rate_id ); // Formating
        $option_name = 'woocommerce_'.$method_key_id.'_settings'; // Get the complete option slug

        return get_option( $option_name, true ); // Get the title and return it
    } else {
        return false;
    }
}
add_filter( 'woocommerce_package_rates', 'hide_shipping_method_with_min_cart', 30, 2 );
function hide_shipping_method_with_min_cart( $rates, $package ) {	
	
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
	// if (!check_gift_card_in_cart($package['contents'])) {
		$total_cart = floatval(WC()->cart->cart_contents_total);
		// if (!check_gift_card_in_cart($package['contents'])) {
			$total_cart = floatval(WC()->cart->cart_contents_total);
			foreach( $rates as $rate_key => $rate ) {
				$method_rate_id = $rate_key;
                $shipping_method = get_shipping_method_from_method_id( $method_rate_id);
            // var_dump($shipping_method);
				$amount_setting = $shipping_method['shipping_minimum_value'] ?? 0;
				
				if ($total_cart < $amount_setting) unset($rates[$rate_key]);
			}
		// }
	// }
	return $rates;
}

// End 12/21/2020

// add by emma
// define the woocommerce_display_item_meta callback 
function filter_woocommerce_display_item_meta( $html, $item, $args ) {        
    $check = false;
    $key_engraving = array();
    foreach ( $item->get_formatted_meta_data() as $meta_id => $meta ) {               
        if ($meta -> key == 'pa_your-engraving-message' || $meta -> key == 'pa_font-type') {
            $key_engraving[] = $meta -> key;
        }         

    }       
    if (in_array('pa_font-type',$key_engraving) && count($key_engraving) == 1) {
     return '';
    }
    return $html; 
    }; 
         
// add the filter 


/////////////
 add_filter( 'woocommerce_order_item_get_formatted_meta_data', 'woocommerce_order_item_meta_remove_meta', 20, 2 );
function woocommerce_order_item_meta_remove_meta( $formatted_meta, $item ) {
    $arr = array();
    $arr_key = array();   
     foreach ($formatted_meta as $key => $value) {
        if ($value -> key == 'pa_your-engraving-message' || $value -> key == 'pa_font-type'){
            $arr[] = $value -> key;
            $arr_key[] = $key;         
        }       
     }
     if (count($arr) == 1 && in_array('pa_font-type',$arr)) {
         $key2 = $arr_key[0];
         unset($formatted_meta[$key2]);
     }
   
    return $formatted_meta;
}
// end

///////////////////////// review plugin /////////////////////////

require get_template_directory() . '/inc/custom-postype/taxonomy.php';
require get_template_directory() . '/inc/custom-postype/postype.php';

//css for admin
add_action( 'admin_enqueue_scripts', 'load_admin_styles' );
function load_admin_styles() {
    wp_enqueue_style('custom-admin-css', get_template_directory_uri() . '/assets/css/admin-css.css',date('ymdhsi'));
  
}

// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function( $data, $file, $filename, $mimes) {
      global $wp_version;
      if( $wp_version == '4.7' || ( (float) $wp_version < 4.7 ) ) {
      return $data;
    }
    $filetype = wp_check_filetype( $filename, $mimes );
      return [
      'ext'             => $filetype['ext'],
      'type'            => $filetype['type'],
      'proper_filename' => $data['proper_filename']
    ];
}, 10, 4 );

function ns_mime_types( $mimes ){
   $mimes['svg'] = 'image/svg+xml';
   return $mimes;
}
add_filter( 'upload_mimes', 'ns_mime_types' );

function ns_fix_svg() {
  echo '<style type="text/css">.attachment-266x266, .thumbnail img { width: 100% !important; height: auto !important;} </style>';
}
add_action( 'admin_head', 'ns_fix_svg' );

////////////////////////////////
// add file in footer
add_action('astra_body_bottom','add_notice_cookie');

function add_notice_cookie() {
    require get_template_directory() . '/func-custom/cookie-notice/notice-html.php';
}

// add

function get_country_mobile_code() {
		$user_id = get_current_user_id();
		$countrys = json_decode(file_get_contents(__DIR__ . '/countrys.json'), true);

		$billing_code = get_user_meta($user_id, 'billing_phone_code', true);
		$shipping_code = get_user_meta($user_id, 'shipping_phone_code', true);
		$data_code = array(
			'billing' => $billing_code ?: 60,
			'shipping' => $shipping_code ?: 60
		);

        echo '<div id="country-mobile-code" data-code="'.htmlspecialchars(json_encode($data_code)).'" style="display: none !important">'.htmlspecialchars(json_encode($countrys)).'</div>';
} 

// define the woocommerce_checkout_process callback 
function action_woocommerce_checkout_process( $wooccm_remove_notices_conditional ) { 
    $billing_phone = $_POST['billing_phone'];
    $billing_phone_code = $_POST['billing_phone_customcode'];
    $enable_shipping = $_POST['ship_to_different_address'];
    $shipping_phone = $_POST['shipping_phone'];
    $shipping_phone_code = $_POST['shipping_phone_customcode'];



    if(isset($billing_phone) && isset($billing_phone_code) && ( strlen($billing_phone) != 9 && strlen($billing_phone) != 10 ) && $billing_phone_code == '60') {
        wc_add_notice('Please input a valid billing contact number.', 'error');
    }
    if(isset($enable_shipping) && $enable_shipping) {
        if(isset($shipping_phone) && isset($shipping_phone_code) && ( strlen($shipping_phone) != 9 && strlen($shipping_phone) != 10 ) && $shipping_phone_code == '60') {
            wc_add_notice('Please input a valid shipping contact number.', 'error');
        }	
    }
}; 
add_action( 'woocommerce_after_checkout_validation', 'action_woocommerce_checkout_process', 10, 1 ); 

// Update Billing Phone After create order
function set_shipping_last_name($order,$data){

	if(isset($data['billing_phone'])) {
		$order->set_billing_phone('+'.$_POST['billing_phone_customcode'].' '.$data['billing_phone']);
	}
	if(isset($data['shipping_phone'])) {
		$order->update_meta_data('_shipping_phone','+'.$_POST['shipping_phone_customcode'].' '.$data['shipping_phone']);
	}

}

add_action("woocommerce_checkout_create_order","set_shipping_last_name",10,2);

// Change Billing Phone Field maxLength Digit
add_filter( 'woocommerce_checkout_fields', 'bbloomer_checkout_fields_custom_attributes', 9999 );

function bbloomer_checkout_fields_custom_attributes( $fields ) {
   $fields['billing']['billing_phone']['custom_attributes']['maxlength'] = 15;
   return $fields;
}

// define the woocommerce_save_account_details callback 
function action_woocommerce_save_account_details( $user_id, $load_address ) { 
    $billing_phone_customcode = $_REQUEST['billing_phone_customcode'] ?? '';
    $shipping_phone_customcode = $_REQUEST['shipping_phone_customcode'] ?? '';
    if(!empty($billing_phone_customcode)) {
        update_user_meta($user_id, 'billing_phone_code', $billing_phone_customcode);
    }
    if(!empty($shipping_phone_customcode)) {
        update_user_meta($user_id, 'shipping_phone_code', $shipping_phone_customcode);
    }
}; 

// add the action 
add_action( 'woocommerce_customer_save_address', 'action_woocommerce_save_account_details', 10, 2 ); 


// Create register user js file and ajax url
add_action( 'wp_enqueue_scripts', 'custom_register_user_scripts' );

function custom_register_user_scripts(){
    if (is_page_template('page-templates/template-register-account.php') || is_page_template('page-templates/template-ben.php')) {
        wp_enqueue_style('register_user_css', get_template_directory_uri() .'/assets/css/register-page.css', array() , date("h:i:s"));

        wp_register_script( 'register_user_js', get_template_directory_uri() . '/assets/js/register-user.js', array('jquery'), date("h:i:s"),  true );
        wp_localize_script( 'register_user_js', 'custom_ajax_url', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'home_url' => get_home_url() ));
        wp_enqueue_script('register_user_js');
    }

    // wp_enqueue_style('temp-1', get_template_directory_uri() .'/assets/css/woocommerce/woocommerce-layout.min.css', array() , date("h:i:s"));
    // wp_enqueue_style('temp-2', get_template_directory_uri() .'/assets/css/woocommerce/woocommerce.min.css', array() , date("h:i:s"));

}

// Register user

function _regex($text, $type) {

    $regex = '';

    if($type == 'email') $regex = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
    if($type == 'phone') $regex = '/^[0-9]+$/';

    $check = preg_match($regex, $text); 

    return $check;
}


add_action('wp_ajax_custom_register_user', 'custom_register_user');
add_action('wp_ajax_nopriv_custom_register_user', 'custom_register_user');

function custom_register_user() {
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $password = $_POST['password'];
    $cf_password = $_POST['confirm_password'];
    $phone_code = $_POST['phone_code'];
    $can_add = true;
    $errs = array();

    if(!_regex($email, 'email')) {
        $can_add = false;
        $errs['email'] = "Please Enter valid Email.";
    }

    if(empty($gender)) {
        $can_add = false;
        $errs['gender'] = 'Gender is Required!';
    }

    if(empty($fname)) {
        $can_add = false;
        $errs['firstname'] = 'First Name is Required!';
    }
    if(empty($lname)) {
        $can_add = false;
        $errs['lastname'] = 'Last Name is Required!';
    }
    if(!_regex($phone, 'phone') || empty($phone)) {
        $can_add = false;
        $errs['contact'] = 'Please Enter valid Phone Number.';
    }
    if(empty($dob)) {
        $can_add = false;
        $errs['dob'] = 'Date of Birth is Required!';   
    }
    if(empty($password)) {
        $can_add = false;
        $errs['password'] = 'Password is Required!';
    }
    if(empty($cf_password)) {
        $can_add = false;
        $errs['confirmpassword'] = 'Confirm Password is Required!';
    }
    if($cf_password != $password) {
        $can_add = false;
        $errs['confirmpassword'] = 'Confirm Password is not Match!';   
    }
    if(empty($phone_code) || !_regex($phone_code, 'phone')) {
        $can_add = false;
        $errs['contact_customcode'] = 'Phone Code is Required!'. $phone_code;
    }

    if($can_add) {
        $user_login = apply_filters('user_login_by_email', user_name_by_email($email));
        $args = array(
            'user_login' => $user_login,
            'user_nicename' =>  $fname.' '.$lname,
            'user_email' => $email,
            'display_name' => $fname.' '.$lname,
            'first_name' => $fname,
            'last_name' => $lname,
            'role' => 'customer',
            'user_pass' => $password
        );

        $user_id = wp_insert_user($args);

        if(is_object($user_id)) {
            $can_add = false;
            $errs['err'] = $user_id->errors;
        } else {
            // Add user meta after create user successfully
            update_user_meta($user_id, 'billing_first_name', $fname);
            update_user_meta($user_id, 'billing_last_name', $lname);
            update_user_meta($user_id, 'billing_last_name', $lname);
            update_user_meta($user_id, 'billing_phone', $phone);
            update_user_meta($user_id, 'billing_phone_code', $phone_code);


            update_field('gender', $gender, 'user_'.$user_id);
            update_field('birthday', $dob, 'user_'.$user_id);



            // Send mail after create user successfully
            $subject = 'Thank you for registering with "Love & Co"!';
            $headers = array('Content-Type: text/html; charset=UTF-8');

            $logo = get_field('email_logo', 'option');
            $mail_content = htmlspecialchars(get_field('email_content', 'option'));
            $mail_footer = get_field('email_footer_image', 'option');

            $mail_content = str_replace('[email_logo]', $logo['url'], $mail_content);
            $mail_content = str_replace('[home_url]', home_url('/login'), $mail_content);
            $mail_content = str_replace('[footer_image]', $mail_footer['url'], $mail_content);
            $mail_content = str_replace('[user_name]', $fname.' '.$lname, $mail_content);
            $mail_content = str_replace('[password]', $password, $mail_content);
            ob_start();
            ?>
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html>
                <head>
                    <meta content="text/html; charset=ISO-8859-1" http-equiv="Content-Type" />
                    <meta content="width=device-width" name="viewport" />
                </head>
                <body>
                    <?php echo htmlspecialchars_decode($mail_content); ?>
                </body>
            </html>
            <?php
            $content = ob_get_contents();
            ob_clean();
            ob_end_clean();
            wp_mail( $email, $subject, $content, $headers );
        }

    }

    wp_send_json_success(array(
        'can_add' => $can_add,
        'errors' => $errs,
    ));

}

// Hooks near the bottom of profile page (if current user) 
add_action('show_user_profile', 'custom_user_profile_fields');
add_action('edit_user_profile', 'custom_user_profile_fields');

function custom_user_profile_fields( $user ) {
$user_id = $user->ID;
$countrys = json_decode(file_get_contents(__DIR__ . '/countrys.json'), true);

$billing_code = get_user_meta($user_id, 'billing_phone_code', true);
$shipping_code = get_user_meta($user_id, 'shipping_phone_code', true);
?>
    <table class="form-table">
        <tr>
            <th>
                <label for="code"><?php _e( 'Billing Phone Code' ); ?></label>
            </th>
            <td>
                <select name="billing_phone_code" id="billing_phone_code">
                <?php 
                foreach($countrys as $country) {

                    $has_billing = ((int)$country['country_mobile_code'] == (int)$billing_code) ? 'selected' : '';
                    echo '<option value="'.$country['country_mobile_code'].'" '.$has_billing.'>'.$country['country_name'].' ('.$country['country_mobile_code'].')</option>';
                }
                ?>	
                </select>
            </td>
        </tr>
    </table>
<?php
}
// Hooks near the bottom of the profile page (if not current user) 
add_action( 'personal_options_update', 'custom_user_profile_edit', 10, 1 ); 

function custom_user_profile_edit($user_id) {

    if(!current_user_can('edit_user', $user_id)) return;

    $billing_code = $_REQUEST['billing_phone_code'] ?? '';
    $shiping_code = $_REQUEST['shipping_phone_code'] ?? '';

    if(!empty($billing_code)) {
        update_user_meta($user_id, 'billing_phone_code', $billing_code);
    }
    if(!empty($shiping_code)) {
        update_user_meta($user_id, 'shipping_phone_code', $shiping_code);
    }
}


function user_name_by_email($email) {
    $cut_position = strpos( $email, '@');
    $cuted_str = substr($email, 0, $cut_position);
    return $cuted_str;
}

add_action('wp_logout','auto_redirect_after_logout');

function auto_redirect_after_logout(){
  wp_redirect( home_url('/login') );
  exit();
}

// Custom Gallery video 
add_action( 'woocommerce_before_single_product_summary' , 'my_custom_contnet', 30 );

function my_custom_contnet() {
   echo '<div class="custom" style="background: #fdfd5a; clear:left; width:50%">';
   echo '<p>My custom contnet here..</p>';
   echo '</div>';
} 


function var_dumpp($a) {
   if(isset($_GET['dump'])){
    var_dump($a);
   }
}

function seo_script($position = 'header') {
    $scripts = get_field('scripts', 'option') ?? array();
	foreach($scripts as $script) {
		$script_type = $script['type'] ?? 'all_pages';
		$script_page = $script['pages'] ?? '';
		$script_position = $script['position'] ?? 'header';
		$script_status = $script['status'] ?? 'deactivate';

		if($script_status == 'activate' && $script_position == $position) {
			if($script_type == 'all_pages') {
				echo $script['code'];
			} else if(in_array(get_queried_object_id(), $script_page)) {
				echo $script['code'];
			}
		}
	}

}

add_action( 'woocommerce_before_add_to_cart_form', 'bbloomer_show_return_policy', 20 );

function bbloomer_show_return_policy() {
    global $product;
    echo '<input type="hidden" id="product-slug" value="'.get_permalink($product->get_id()).'" />';
    echo '<input type="hidden" id="product-thumbnail" value="'.get_the_post_thumbnail_url($product->get_id()).'" />';
    if(isset($_GET['p_id'])) {
        $parent_product_id = $_GET['p_id'] ?: '';
        $parent_product = wc_get_product($parent_product_id);
        echo '<input type="hidden" id="parent-product-name" value="'.$parent_product->get_title().'" />';
    }
    if(isset($_REQUEST['add-to-cart']) && $product->is_type('variable')) {
        $vatiations = array(
            'shapes'=> $_REQUEST['attribute_pa_shapes'],
            'diamond_type' => $_REQUEST['attribute_pa_diamond-type'],
            'casing' => $_REQUEST['attribute_pa_casing'],
            'metal_type' => $_REQUEST['attribute_pa_metal-type'],
            'ring_size' => $_REQUEST['attribute_pa_ring-size']
        );
        echo '<input type="hidden" id="is_add_to_cart" value="'.htmlspecialchars(json_encode($vatiations)).'" />';
    }
}

function header_menu_v2() {
    register_nav_menu('header-menu-v2',__( 'Header Menu v2' ));
}
add_action( 'init', 'header_menu_v2' );
class HeaderMenuV2 extends Walker_Nav_Menu {
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= '<div class="submenu-wrap submenu-lv-'.$depth.'">';
        $output .= "\n$indent<ul class=\"xxxx sub-menu\">\n";
    }
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n</div>";
    }
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';
 
        $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
        $class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
 
        $output .= $indent . '<li ' . $id . $class_names . '>';
       // $images = ['gift-4', 'diamond-4', 'wedding-band-3', 'education-1', 'education-2', 'jewellery-4', 'aboutus-4'];
        $images = [
            'jewellery-4' => 'https://love-and-co.com/ebase-uploads/2022/08/Mobile-Header-790x600px.webp',
            'diamond-4' => 'https://love-and-co.com/ebase-uploads/2022/01/bespokediamond.jpg',
            'wedding-band-3' => 'https://love-and-co.com/ebase-uploads/2021/11/DT-WB-1536x635px.jpg',
            'aboutus-4' => 'https://love-and-co.com/ebase-uploads/2022/06/new_store.jpeg'
        ];

        foreach($images as $k=>$images_item) {
            if(in_array($k, $classes)) {
                $image_data = $images_item;
                if($image_data) {
                 $output .= '<div class="menu-image-wrap">
                    <a href="'.$item->url.'">
                    <img src="'.esc_url($image_data).'" alt="" />
                    </a>
                 </div>';
                }
            } 
        }
 
        $atts           = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target ) ? $item->target : '';
        if ( '_blank' === $item->target && empty( $item->xfn ) ) {
            $atts['rel'] = 'noopener';
        } else {
            $atts['rel'] = $item->xfn;
        }
        $atts['href']         = ! empty( $item->url ) ? $item->url : '';
        $atts['aria-current'] = $item->current ? 'page' : '';
 
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
 
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
 
        $item_output  = $args->before;
        $item_output .= '<a ' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

add_shortcode( "header_menu", function() {
    echo get_template_part('template-parts/header/header', 'v2');
} );

function delete_media() {
    global $wpdb;
    $path = "/mnt/data/home/607657.cloudwaysapps.com/rarcvkkpen/public_html/wp-content/uploads/";
    $files = glob($path . '2021/10/*.*');
    $start = $_REQUEST['first_num'];
    $add_num = 100000;
    $temp = 0;
    $in_array = "";
    $last_array = array_slice($files, (int)$start, (int)$add_num);
    $new_last_array = [];
    foreach($last_array as $key => $item) {
        if(!preg_match_all('/(?:[-_]?[0-9]+x[0-9]+)+/',   $item)) {
            array_push($new_last_array, $item);
        }
    }
    foreach($new_last_array as $key => $_item) {
        if($key >= count($new_last_array) - 1) {
            $in_array .= "'".str_replace($path, '',  $_item)."'";
        } else {
            $in_array .= "'".str_replace($path, '',  $_item)."',";
        }
    }

    $query_str = "SELECT post_id, meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = '_wp_attached_file' AND meta_value IN (" .$in_array.")";
    $results = $wpdb->get_results($query_str);

    $result_array = [];

    foreach($results as $result) {
        array_push($result_array, $result->meta_value);
    }
    $last_filter = [];
    foreach($new_last_array as $key => $item) {
        if(!in_array(str_replace($path, '',  $item), $result_array)) {
            array_push($last_filter, !in_array(str_replace($path, '',  $item), $result_array));
            chmod($item, 0777);
            if(unlink($item)) {
                $temp++;
            }
        }
    }
    update_option('delete_media_start_number', $start + $add_num);
    wp_send_json_success( array(
        'all' => count(glob($path . '2021/10/*.*')),
        'start' => $start + $add_num,
        'deleted' => $temp,
        'result' => $last_filter,
        // 'new_last_array' => $result_array,
    ) );
    die();
}
add_action('wp_ajax_delete_media', 'delete_media');
add_action('wp_ajax_nopriv_delete_media', 'delete_media');


add_filter( 'woocommerce_product_data_tabs', 'add_my_custom_product_data_tab' );
function add_my_custom_product_data_tab( $product_data_tabs ) {
	$product_data_tabs['product-message-tab'] = array(
		'label' => __( 'Product Message', 'my_text_domain' ),
		'target' => 'product_message_data',
	);
	return $product_data_tabs;
}

add_action( 'woocommerce_product_data_panels', 'add_my_custom_product_data_fields' );

function add_my_custom_product_data_fields() {
	global $woocommerce, $post;
	?>
	<!-- id below must match target registered in above add_my_custom_product_data_tab function -->
	<div id="product_message_data" class="panel woocommerce_options_panel">
		<?php
            woocommerce_wp_checkbox(
                array(
                    'id'        => 'enable_message',
                    'label'     => __( 'Enable Message And Fonts Type', 'my_text_domain' ),
                    'desc_tip'  => __( 'Select this option to show giftwrapping options for this product', 'my_text_domain' )
                )
            );
		?>
	</div>
	<?php

}

add_action( 'woocommerce_process_product_meta', 'custom_product_meta_save' );

function custom_product_meta_save($post_id) {
    $product = wc_get_product( $post_id );
    $enable_mesage = isset( $_POST['enable_message'] ) ? 'yes' : '';
    $product->update_meta_data( 'enable_message', sanitize_text_field( $enable_mesage ) );

    $product->save();
}

function pagely_security_headers( $headers ) {
   $headers['Access-Control-Allow-Origin'] = 'https://love-and-co.com/';   
    $headers['X-Frame-Options'] = 'SAMEORIGIN';  
    $headers['Strict-Transport-Security'] = 'max-age=7776000; includeSubDomains; preload'; 

    $headers['set-cookie'] = 'Max-Age=7776000; httpOnly'; 
    $headers['set-cookie'] = 'wordpress_test_cookie=WP+Cookie+check; httpOnly';   
    $headers['set-cookie'] = 'wp-settings-2=editor%3Dtinymce%26libraryContent%3Dbrowse%26imgsize%3Dfull%26urlbutton%3Dfile; httpOnly';   
    $headers['Set-Cookie'] = 'wp-settings-time-2=1540179866; httpOnly';   

 $headers['Cache-Control'] = 'max-age=2592000';  // 30 days 
    $headers['X-Content-Type-Options'] = 'nosniff';   
    $headers['X-XSS-Protection'] = '1; mode=block';  
    $headers['Referrer-Policy'] = 'same-origin';
    $headers['Strict-Transport-Security'] = 'max-age=7776000; includeSubDomains; preload';
    $headers['Permissions-Policy'] = 'fullscreen=(self "https://love-and-co.com/"), geolocation=*, camera=()';
    $headers['Content-Security-Policy'] = "script-src 'unsafe-inline' 'unsafe-eval' https: data: blob:"; 
    
///$headers['Content-Security-Policy'] = "default-src *; style-src 'self' cdn-cfhoi.nitrocdn.com fonts.googleapis.com cdnjs.cloudflare.com/ static.klaviyo.com/ 'unsafe-inline' 'unsafe-eval'; media-src *;script-src 'self' cdn-cfhoi.nitrocdn.com cdnjs.cloudflare.com script.hotjar.com/  static-tracking.klaviyo.com/ www.google-analytics.com/  google.com static.klaviyo.com static.cloudflareinsights.com googletagmanager.com connect.facebook.net static.hotjar.com gstatic.com script.hotjar.com/ googleads.g.doubleclick.net  www.googletagmanager.com/ www.youtube.com/ www.google.com www.gstatic.com/ www.googleadservices.com/ static-tracking.klaviyo.com/ 'unsafe-inline' 'unsafe-eval';font-src 'self' data: fonts.gstatic.com ; connect-src 'self' cdn-cfhoi.nitrocdn.com in.hotjar.com/ wss://ws19.hotjar.com  stats.g.doubleclick.net  www.google-analytics.com/  a.klaviyo.com/ fast.a.klaviyo.com/ telemetrics.klaviyo.com/ to.getnitropack.com/ static-forms.klaviyo.com gstatic.com www.gstatic.com/;object-src 'none';frame-src 'self' https://vars.hotjar.com/ https://www.google.com/ https://www.facebook.com/ https://marketingplatform.google.com/about/enterprise/ ;img-src data: *;";

    //$headers['Content-Security-Policy'] = "default-src 'self' https://cdn-cfhoi.nitrocdn.com/; style-src 'self' https://fonts.googleapis.com https://cdnjs.cloudflare.com/ https://static.klaviyo.com/onsite/js/10.a5540beb560761e98c07.css 'unsafe-inline' 'unsafe-eval'; media-src *;script-src 'self' https://script.hotjar.com/ https://script.hotjar.com/modules.909c20fd8721306b1fa9.js https://static-tracking.klaviyo.com/onsite/js/static.*.js https://www.google-analytics.com/plugins/ua/linkid.js https://www.google-analytics.com/plugins/ua/ec.js https://cdnjs.cloudflare.com https://google.com https://static.klaviyo.com https://static.cloudflareinsights.com https://googletagmanager.com https://connect.facebook.net https://static.hotjar.com https://gstatic.com https://script.hotjar.com/modules.376dac12c7cbd03331c3.js https://googleads.g.doubleclick.net https://www.google.com/recaptcha https://www.googletagmanager.com/ https://www.youtube.com/iframe_api https://www.youtube.com/ https://www.google.com/recaptcha/api.js https://www.gstatic.com/recaptcha/releases/*/recaptcha__en.js https://www.googleadservices.com/pagead/conversion_async.js https://www.google-analytics.com/analytics.js https://static-tracking.klaviyo.com/onsite/js/fender_analytics.*.js 'unsafe-inline' 'unsafe-eval';font-src 'self' data: https://fonts.gstatic.com ; connect-src 'self' wss://ws19.hotjar.com/api/v2/client/ws https://ws19.hotjar.com/api/v2/sites/2540727/recordings/content https://stats.g.doubleclick.net/j/collect https://www.google-analytics.com/j/collect https://a.klaviyo.com/api/track https://a.klaviyo.com/forms/api/v3/geo-ip https://fast.a.klaviyo.com/custom-fonts/api/v1/company-fonts/onsite https://static-forms.klaviyo.com/forms/api/v5/Y4KXtr/full-forms https://in.hotjar.com/api/v2/client/sites/2540727/visit-data https://telemetrics.klaviyo.com/v1/metric https://to.getnitropack.com/;object-src 'none';frame-src 'self' https://vars.hotjar.com/ https://www.google.com/ https://www.facebook.com/ https://marketingplatform.google.com/about/enterprise/ ;img-src data: *;";

    return $headers;
}

add_filter( 'wp_headers', 'pagely_security_headers' );

/*Checkout - Field Changes #13063*/
function billing_remove_additional_information_checkout($fields){
    unset( $fields['billing_company'] );
    return $fields;
}
add_filter( 'woocommerce_billing_fields', 'billing_remove_additional_information_checkout' );
function shipping_remove_additional_information_checkout($fields){
    unset( $fields['shipping_company'] );
    return $fields;
}
add_filter( 'woocommerce_shipping_fields', 'shipping_remove_additional_information_checkout' );

// add new field on checkout

add_action('woocommerce_after_checkout_registration_form','add_new_field_register');
function add_new_field_register() { ?>
    <div class="create-account">
    <p class="Female woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="user_gender"><?php _e( 'Gender', 'woocommerce' ); ?></label>
        <select name="user_gender" id="user_gender">
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>       
    </p>
     <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="user_dob"><?php _e( 'Date of Birth', 'woocommerce' ); ?></label>
        <input type="text" name="dob" id="dob" class="form__input" placeholder="01/01/1990" autocomplete="off">     
    </p>
</div>
<?php
}

function add_new_field_register_validation( $posted ) {
    if ($_POST['createaccount']) {
         if ( ! $_POST['user_gender'] )
        wc_add_notice( __( 'Please enter your gender.', 'oa_lvc' ), 'error' );
    if ( ! $_POST['dob'] )
        wc_add_notice( __( 'Please enter your Date of Birth.', 'oa_lvc' ), 'error' );
    }
   
}
add_action( 'woocommerce_after_checkout_validation', 'add_new_field_register_validation', 10, 2 );

// update user meta with Birth date (in checkout and my account edit details pages)

add_action( 'woocommerce_checkout_order_processed', 'custom_processed_checkout' );
function custom_processed_checkout($order_id){
     if ($_POST['createaccount']) {
  $theorder     = new WC_Order( $order_id );
  $user_id     = $theorder->user_id; // for checkout page post data
    if ( isset($_POST['dob']) ) {
        update_user_meta( $user_id, 'birthday', sanitize_text_field($_POST['dob']) );
    }
    // for customer my account edit details page post data
    if ( isset($_POST['user_gender']) ) {
        update_user_meta( $user_id, 'gender', sanitize_text_field($_POST['user_gender']) );
    }
}
}
/*End Checkout - Field Changes #13063*/

add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields_city');
function custom_override_checkout_fields_city($fields)
 {
   
   $fields['shipping']['shipping_city']['required'] 	= true;
   $fields['billing']['billing_city']['required'] 		= true;

   return $fields;
 }

 function get_id_image_by_url($url_img) {
	global $wpdb;
	$sql = "SELECT post_id FROM wp_postmeta WHERE meta_key = '_wp_attached_file' AND meta_value = '$url_img'";
	$ids = $wpdb->get_results($sql);	
	return $ids[0]->post_id;
}

/* gdex my */
// Output a custom editable field in backend edit order pages under general section
add_action( 'woocommerce_admin_order_data_after_order_details', 'editable_order_custom_field', 12, 1 );

function editable_order_custom_field( $order ){
    // Replace "customer reference" value by the meta data if it exist
    $value =  $order->get_meta('_order_tracking_id');
    $gdex_log = $order->get_meta("_order_gdex_log");
    // Display the custom editable field
    woocommerce_wp_text_input( array(
        'id'            => 'order_tracking_id',
        'label'         => __("Tracking ID:", "woocommerce"),
        'value'         => $value,
        'wrapper_class' => 'form-field-wide',
        'custom_attributes' => array(
            'autocomplete' => 'new-password'
        )
    ) );

    woocommerce_wp_textarea_input(array(
        'id'=>'order_gdex_log',
        'label'=> "GDEX Log",
        "value"=>$gdex_log,
        "wrapper_class"=>'form-field-wide',
        "custom_attributes"=>array("disabled"=>""),
    ));
   /* if($order-> has_shipping_method("local_pickup")){
        $store_id = get_post_meta($order->get_id(),"store",true);
        $store_options = array();
        $store_options = get_stores();
        $store_options[0]  = __( 'Select a store', 'woocommerce');

        woocommerce_wp_select( array(
            'id'      => 'store',
            'label'   => __( 'Store', 'woocommerce' ),
            'options' =>  $store_options, 
            'value'   => $store_id,
        ) );
    }*/
}
/**
 * args has status completed to push more shipped status
 *
 *
 * @return void
 */
function custom_woocommerce_reports_get_order_report_data_args($args){
    if(isset($args["order_status"])){
        if($args["order_status"]){
            $completed = check_args_exists_item($args["order_status"],"completed");
            if($completed){
                array_push($args["order_status"],"shipped");
            }
        }
    }else{
        $args["order_status"] = array( 'completed', 'processing', 'shipped', 'on-hold' );
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
        // if($from != "shipped" && $to === "shipped"){
        //  WC()->mailer()->get_emails()["WC_Email_Customer_Shipped_Order"]->trigger($order_id);
        // } 
    }

    add_action("woocommerce_order_status_changed","setup_send_mail_for_status_shipped",10,3);



// Save the custom editable field value as order meta data
add_action( 'woocommerce_process_shop_order_meta', 'save_order_custom_field_meta_data', 12, 2 );
/**
 * update order tracking id, store
 *
 * @param [type] $post_id
 * @param [type] $post
 * @return void
 */
function save_order_custom_field_meta_data( $post_id, $post ){
    if( isset( $_POST[ 'order_tracking_id' ] ) ){
        update_post_meta( $post_id, '_order_tracking_id', sanitize_text_field( $_POST[ 'order_tracking_id' ] ) );
    } 
    $order = new WC_Order($post_id);
    if($order){
        if($order->has_shipping_method("local_pickup")){
            if(isset($_POST["store"])){
                $store = get_store(sanitize_text_field($_POST["store"]));
                if($store){
                    update_post_meta($post_id,"store",$store->ID);
                    $store_name = get_the_title($store->ID);
                    $store_address = get_the_content(null,false,$store->ID);
                    update_post_meta($post_id,"store_name",$store_name);
                    update_post_meta($post_id,"store_address",$store_address);
                }
            }
        }
    }
}

add_action("init","add_shipped_email_class_init");
function add_shipped_email_class_init(){
    add_filter("woocommerce_email_classes","add_class_wc_shipped_email_woocommerce_email_classes");
    function add_class_wc_shipped_email_woocommerce_email_classes($emails){
        $emails["WC_Email_Customer_Shipped_Order"] = include get_template_directory()."/inc/email/class-wc-customer-shipped-order.php";
        $emails["WC_Email_GDEX_Shipped_Order"] = include get_template_directory()."/inc/email/class-wc-gdex-shipped-order.php";
        return $emails;
    }
    $GLOBALS["woocommerce"] = WC();
}
function define_referrent_texts($order){
    $referrent_texts = array();
    $tracking_id = get_post_meta($order->get_id(),"_order_tracking_id",true) ? get_post_meta($order->get_id(),"_order_tracking_id",true) : "" ;
    $user_login = $order->get_billing_first_name();
    $store_name = "";
    if($order->has_shipping_method("local_pickup")){
        $store_name = get_the_title($order->get_meta("store"));
    }
    $referrent_texts["tracking_id"] = $tracking_id;
    $referrent_texts["user_login"] = $user_login;
    $referrent_texts["store_name"] = $store_name;
    return $referrent_texts;
}
function replace_referrent_texts($text,$referrent_texts = array()){
    $pattern = array();
    $replace = array();
    if(is_array($referrent_texts) && !empty($referrent_texts)){
        foreach($referrent_texts as $k => $v){
            $k = "{".$k."}";
            array_push($pattern,$k);
            array_push($replace,$v);
        }
    }
    return str_replace($pattern,$replace,$text);
}
/* end gdex my */