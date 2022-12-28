<?php

class Name_customiser {
    function __construct() {


        add_filter('is_out_of_stock', [$this, 'is_out_of_stock'], 10, 1);
        add_filter('product_gallery_html', [$this, 'product_gallery_html'], 10, 5);
        add_filter('woocommerce_cart_item_name', [$this, 'customiser_variation_item_name'], 10, 3 );
        add_filter('woocommerce_cart_item_permalink', [$this, 'customiser_cart_item_permalink'] , 10, 3 );
        add_filter('woocommerce_account_menu_items', [$this, 'add_woocommerce_account_menu_item'], 20, 1);
        add_filter('woocommerce_order_item_name', [$this, 'woocommerce_order_item_name_1'], 10, 3);
        add_filter( 'woocommerce_order_item_display_meta_value', [$this, 'filter_order_item_display_meta_value'], 10, 3 );
        add_filter('woocommerce_order_item_get_name', [$this, 'woocoommerce_get_name'], 10, 2 );


        add_action('wp_ajax_customiser_with_month', [$this, 'customiser_with_month']);
        add_action('wp_ajax_nopriv_customiser_with_month', [$this, 'customiser_with_month']);
        add_action('wp_ajax_alphabet_image', [$this, 'alphabet_image']);
        add_action('wp_ajax_nopriv_alphabet_image', [$this, 'alphabet_image']);
        add_action('wp_ajax_user_creations_save', [$this, 'user_creations_save']);
        add_action('wp_ajax_nopriv_user_creations_save', [$this, 'user_creations_save']);
        add_action('wp_ajax_customiser_add_to_cart', [$this, 'customiser_add_to_cart']);
        add_action('wp_ajax_nopriv_customiser_add_to_cart', [$this, 'customiser_add_to_cart']);
        add_action('wp_ajax_check_customiser_product_duplicate', [$this, 'check_customiser_product_duplicate']);
        add_action('wp_ajax_nopriv_check_customiser_product_duplicate', [$this, 'check_customiser_product_duplicate']);
        add_action('wp_ajax_remove_creation', [$this, 'remove_creation']);
        add_action('wp_ajax_nopriv_remove_creation', [$this, 'remove_creation']);
        add_action('wp_ajax_customiser_email_share', [$this, 'customiser_email_share']);
        add_action('wp_ajax_nopriv_customiser_email_share', [$this, 'customiser_email_share']);

        add_action('woocommerce_add_cart_item_data', [$this, 'add_customiser_to_cart_item_data'], 10, 3);
        add_action('woocommerce_get_item_data', [$this, 'add_customiser_to_cart_item'], 10, 2);
        add_action('after_customiser_content', [$this, 'after_customiser_content']);
        add_action( 'woocommerce_checkout_create_order_line_item', [$this, 'save_cart_item_custom_meta_as_order_item_meta'], 10, 4 );
        

    }


    function is_out_of_stock($product) {
	
        $product_id = $product->get_id();
        $product_stock = get_post_meta( $product_id, '_stock_status', true );
    
        if((!$product->managing_stock() && !$product->is_in_stock()) || $product_stock === 'outofstock') {
            return true;
        }
    
        return false;
    }

    function customiser_with_month() {
        $month = $_POST['month'] ?? '';
        $name = $_POST['name'] ?? '';

        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'meta_query' => array(
                array(
                    'key' => 'month',
                    'value' => $month
                )
            ),
            'tax_query' => array(
                array(
                    'taxonomy' => 'name_necklace',
                    'field' => 'slug',
                    'terms' => get_type_of_name($name) 
                )
            )
        );

        $wp_query = new WP_Query($args);
        $post = $wp_query->posts[0];
        $necklace = wc_get_product($post->ID);
        // Get Product Thumbnail
        $product_thumb= '';
        ob_start();
        echo get_the_post_thumbnail($post->ID);
        $product_thumb = ob_get_contents();
        ob_clean();
        ob_end_flush();

        // Get Product Gallery
        $product_price = '';
        ob_start();
        echo $necklace->get_price_html();
        $product_price = ob_get_contents();
        ob_clean();
        ob_end_flush();
        // Get Product Price


        $res = array(
            'product_id' => $post->ID,
            'product_name' => $necklace->get_title(),
            'product_thumb' => get_the_post_thumbnail_url($post->ID),
            'product_images' => $this->product_gallery_urls($necklace->get_gallery_image_ids()),
            'product_price' => $product_price,
            'product_gallery' => $this->product_gallery_html($post->ID, true, 'no-lst', 'gallery-wrarp', 'gallery_img'),
            'name' => $name,
            "gallery_count" => product_gallery_count($post->ID)
        );
        wp_send_json_success($res);
    }

    function product_gallery_urls($galleries) {
        $results = [];
        foreach($galleries as $gallery) {
            array_push($results, wp_get_attachment_image_url($gallery, 'full'));
        }
        return $results;
    }


    function product_gallery_html($product_id, $thumbnail = true, $parent_class = '', $child_class = '', $image_class = '') {
        
        $product = wc_get_product($product_id);
        $product_thumb = get_the_post_thumbnail_url($product->get_id());
        $product_gallery_ids = $product->get_gallery_image_ids();
        $result = '';
        ob_start();
        ?>
        <ul class="<?php echo $parent_class; ?>">   
            <li class="product-thumbnail <?php echo $child_class; ?> active">
                <img class="<?php echo $image_class; ?>" src="<?php echo $product_thumb; ?>" alt="Product Gallery">
            </li>
            <?php
            foreach($product_gallery_ids as $gallery_id):
                $gallery_src = wp_get_attachment_image_url($gallery_id, 'full');
            ?>
            <li class="product-gallery-item <?php echo $child_class; ?>">
                <img class="<?php echo $image_class; ?>" src="<?php echo $gallery_src; ?>" alt="Product Gallery">
            </li>
            <?php endforeach; ?>
        </ul>
        <?php 
        $result = ob_get_contents();
        ob_clean();
        ob_end_flush();
        return $result;
    }

    function alphabet_image() {
        $name = $_POST['name'] ?? '';

        if(empty($name)) wp_send_json_error();

        $alphabet = get_field('customiser_name', 'option');
        foreach($alphabet as $item) {
            if(strtolower($item['character']) == strtolower(substr($name, 0, 1))) {
                wp_send_json_success($item);
            }
        }

        wp_send_json_error($alphabet);
        die();
    }


    function user_creations_save() {

        if(!is_user_logged_in()) wp_send_json_error(array('redirect' => home_url('/account/')));

        $month = $_POST['month'] ?? '';
        $name = $_POST['name'] ?? '';
        $product_id = $_POST['productId'] ?? '';
        $product_name = $_POST['productName'] ?? '';
        $url = $_POST['url'] ?? '';
        $user_id = get_current_user_id();

        $creations = get_user_creations($user_id);
        $data = array();
        if(!empty($creations)) {
            $data = json_decode($creations);
        }
        array_push($data, array(
            'month' => $month,
            'name' => $name,
            'product_id' => $product_id,
            'product_name' => $product_name,
            'url' => $url
        ));

        $result = update_user_meta($user_id, 'user_customiser_creation', json_encode($data));

        wp_send_json_success(array('url' => home_url('/my-creations/')));
    }

    function customiser_add_to_cart() {
        $product_id = $_POST['product_id'] ?? '';
        $product_name = $_POST['product_name'] ?? '';
        $product_url = $_POST['product_url'] ?? '';
        $product_month = $_POST['product_month'] ?? '';
        $customer_name = $_POST['customer_name'] ?? '';
        $duplicate_key = $_POST['duplicate_key'] ?? '';

        $product = wc_get_product($product_id);
        $quantity = 1;

        if(empty($product_id)) wp_send_json_error(array('error' => 'Please Choose a product.'));
        $custom_data = array(
            'customiser_data' => array(
                'customiser_product_id' => $product_id,
                'customiser_product_name' => $product_name,
                'customiser_customer_name' => $customer_name,
                'customiser_product_month' => $product_month,
                'customiser_product_url' => $product_url
            )
        );

        $validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

        $add_to_cart = WC()->cart->add_to_cart( $product_id, '1', '0', array(), $custom_data );

        if($validation &&  $add_to_cart && $product->get_status() === 'publish') {
            // Add Product To Cart
            do_action( 'woocommerce_ajax_added_to_cart', $product_id );
            wc_add_to_cart_message( $product_id );

            // Remove Duplicate Product from Cart
            if(!empty($duplicate_key)) {
                WC()->cart->remove_cart_item($duplicate_key);
            }

            wp_send_json_success(array('redirect' => home_url('/cart/')));
        } else {
            $data = array(
                'error'       => true,
                'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
                'validation' => $validation,
                'product_status' => $product->get_status(),
                'cart_item_key' => $duplicate_key
            );

            wp_send_json_error($data);
        }
        die();
    }

    function add_customiser_to_cart_item_data($cart_item_data, $product_id, $variation_id) {
        if(isset($cart_item_data['customiser_data'])) {
            $cart_item_data['custom_data']['unique_key'] = md5( microtime().rand() ); 
        }
        return $cart_item_data;
    }

    function add_customiser_to_cart_item($item_data, $cart_item_data) {
        if(isset($cart_item_data['customiser_data'])) {
            $customiser_data = $cart_item_data['customiser_data'];
            if(isset($customiser_data['customiser_product_month'])) {
                $item_data[] = array(
                    'key' => __('Birthstone', 'text_domain'),
                    'value' => wc_clean($customiser_data['customiser_product_month'])
                );
            }

            if(isset($customiser_data['customiser_customer_name'])) {
                $item_data[] = array(
                    'key' => __('Name', 'text_domain'),
                    'value' => wc_clean($customiser_data['customiser_customer_name'])
                );
            }
        }
        return $item_data;
    }

    /**
     *  Change Order Item Name
    */

    function customiser_variation_item_name($item_name,  $cart_item_data,  $cart_item_key) {
        if(isset($cart_item_data['customiser_data'])) {
            $customiser_data = $cart_item_data['customiser_data'];
            if(isset($customiser_data['customiser_product_name'])) {
                $item_name = $customiser_data['customiser_product_name'];
            }
        }
        return $item_name;
    }

    /**
     * Change Order Item Permalink
    */
    function customiser_cart_item_permalink( $permalink, $cart_item_data, $cart_item_key ) {

        if(isset($cart_item_data['customiser_data'])) {
            $customiser_data = $cart_item_data['customiser_data'];
            if(isset($customiser_data['customiser_product_url'])) {
                $permalink = $customiser_data['customiser_product_url'];
            }
        }
        return $permalink;
    }

    function check_customiser_product_duplicate() {
        $product_id = $_POST['product_id'] ?? '';
        $product_name = $_POST['product_name'] ?? '';
        $product_url = $_POST['product_url'] ?? '';
        $product_month = $_POST['product_month'] ?? '';
        $customer_name = $_POST['customer_name'] ?? '';

        $cart = WC()->cart;
        $cart_contents = $cart->get_cart();
        if(empty($customer_name)) {
            wp_send_json_error();
        }
        if(count($cart_contents) <= 0) {
            wp_send_json_success(array(
                'open' => true
            ));
        } else {
            $duplicate_item_key = '';
            $open = true;
            // Loop cart item and get month of end item same month of new item
            foreach($cart_contents as $key => $item) {
                $item_product_id = $item['product_id'];
                $customiser_data = $item['customiser_data'];
                $customiser_month = $customiser_data['customiser_product_month'];

                if((int)$item_product_id === (int)$product_id && $product_month === $customiser_month) {
                    $duplicate_item_key = $key;
                }
            }
            // Create Html
            $html = '';
            if(!empty($duplicate_item_key)):
                $open = false;
                $duplicate_item = $cart_contents[$duplicate_item_key];
                ob_start();
                $duplicate_customiser_data = $duplicate_item['customiser_data'];
                $duplicate_product_id = $duplicate_customiser_data['customiser_product_id'];
                $duplicate_product = wc_get_product($duplicate_product_id);
                $duplicate_thumb_url = get_the_post_thumbnail_url($duplicate_product_id, 'medium');
                $duplicate_price_html = $duplicate_product->get_price_html();
                ?>
                <input type="hidden" id="duplicate-key" value="<?php echo $duplicate_item_key; ?>">
                <div class="in-cart">
                    <div class="container">
                        <p class="title">CURENTLY IN CART</p>
                        <ul class="modal-products no-lst">
                            <li>
                                <div class="product-thumb">
                                    <img src="<?php echo $duplicate_thumb_url; ?>" alt="Thumbnail">
                                </div>
                                <div class="product-meta">
                                    <p class="product-name"><?php echo $duplicate_customiser_data['customiser_product_name']; ?></p>
                                    <div class="product-price"><?php echo $duplicate_price_html; ?></div>
                                    <p class="product-birthstone">Birthstone: <?php echo $duplicate_customiser_data['customiser_product_month']; ?></p>
                                    <p class="product-cus-name">Name: <?php echo $duplicate_customiser_data['customiser_customer_name']; ?></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php 
                $new_product = wc_get_product($product_id);
                $new_thumb_url = get_the_post_thumbnail_url($product_id, 'medium');
                $new_price_html = $new_product->get_price_html();
                ?>
                <div class="in-page">
                    <div class="container">
                        <p class="title">YOU ARE ADDING TO YOUR CART.</p>
                        <ul class="modal-products no-lst">
                            <li>
                                <div class="product-thumb">
                                    <img src="<?php echo $new_thumb_url; ?>" alt="Thumbnail">
                                </div>
                                <div class="product-meta">
                                    <p class="product-name"><?php echo $product_name; ?></p>
                                    <div class="product-price"><?php echo $new_price_html; ?></div>
                                    <p class="product-birthstone">Birthstone: <?php echo $product_month; ?></p>
                                    <p class="product-cus-name">Name: <?php echo $customer_name; ?></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php 
                $html = ob_get_contents();
                ob_clean();
                ob_end_flush();
            endif;
            // Send Result
            wp_send_json_success(array(
                'open' => $open,
                'cart_contents' => $duplicate_item_key,
                'html' => $html
            ));
        }

    }

    function add_woocommerce_account_menu_item($items) {
        $new_items = [];
        foreach($items as $key => $item) {
            $new_items[$key] = $item;
            if($key === 'contributions') {
                $new_items['my-creations'] = __('My creations', 'text_domain');
            }
        }
        return $new_items;
    }

    function remove_creation() {
        $key = $_POST['key'] ?? '';
        
        if((empty($key) && $key != 0) || !is_user_logged_in()) {
            wp_send_json_error(array(
                'key' => (empty($key) && $key != 0),
                'login' => !is_user_logged_in()
            ));
        }

        $user_id = get_current_user_id();
        $creations = json_decode(get_user_meta($user_id, 'user_customiser_creation', true), false);
        $new_creation = [];
        foreach($creations as $creation_key => $creation) {
            if((int)$creation_key !== (int)$key) {
                array_push($new_creation, $creation);
            }
        }

        $update_meta = update_user_meta($user_id, 'user_customiser_creation', json_encode($new_creation));
        wp_send_json_success(array(
            'updated' => $update_meta
        ));
    }

    function customiser_email_share() {
        $your_name = $_POST['your_name'] ?? '';
        $your_email = $_POST['your_email'] ?? '';
        $recipient_name = $_POST['recipient_name'] ?? '';
        $recipient_email = $_POST['recipient_email'] ?? '';
        $message_optionals = $_POST['message'] ?? '';
        $customiser_url = $_POST['customiser_url'] ?? '';
        $product_name = $_POST['product_name'] ?? '';

        if(empty($your_email) || empty($your_name) || empty($recipient_name) || empty($recipient_email) || empty($customiser_url)) {
            wp_send_json_error();
        }

        $subject = 'Here is a gift idea for ' .$recipient_name;
        // $headers = array('Content-Type: text/html; charset=UTF-8');
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'Bcc: ecommercemy@love-and-co.com',
            'From: Love & Co <ecommercemy@love-and-co.com>',
            'Reply-To: ecommercemy@love-and-co.com',

        );
        $html = '';
        ob_start();
        require CUSTOMISER_PATH . '/emails/email-share.php';
        $html .= ob_get_contents();
        ob_clean();
        ob_end_flush();

        wp_mail($recipient_email, $subject, $html, $headers);
        wp_send_json_success(array($recipient_email, $subject, $headers, $html));
    }

    function after_customiser_content() {
        require CUSTOMISER_PATH . '/template-parts/customiser-below.php';
    }


    function save_cart_item_custom_meta_as_order_item_meta( $item, $cart_item_key, $values, $order ) {
        $customiser_data = $values['customiser_data'];
        if ( isset($customiser_data) && isset($customiser_data) ) {
            $item->update_meta_data( 'customiser_data', $customiser_data );

            if(isset($customiser_data['customiser_product_month'])) {
                $item->add_meta_data(
                    __( 'BirthStone', 'text_domain' ),
                    $customiser_data['customiser_product_month'],
                    true
                );
            }
            if(isset($customiser_data['customiser_customer_name'])) {
                $item->add_meta_data(
                    __( 'Name', 'text_domain' ),
                    $customiser_data['customiser_customer_name'],
                    true
                );
            }
        }
    }

    function woocommerce_order_item_name_1($product_permalink, $item, $is_visible ) {
        $customiser_data = $item->get_meta('customiser_data');
        if(isset($customiser_data) && !empty($customiser_data)) {
            $product_permalink = sprintf('<a href="%s">%s</a>', $customiser_data['customiser_product_url'], $customiser_data['customiser_product_name']);
        }
        return $product_permalink;
    }

    function woocoommerce_get_name ( $value, $item) {
        $customiser_data = $item->get_meta('customiser_data');
        if(is_admin() && isset($customiser_data) && !empty($customiser_data)) {
            $value = $customiser_data['customiser_product_name'];
        }
        return $value;
    }
    function filter_order_item_display_meta_value( $meta_value, $meta_object, $order_item ) {

        if ( is_admin() && get_class($order_item) == 'WC_Order_Item_Shipping') {
            $order = $order_item->get_order();
            $order_items = $order->get_items();
            foreach( $order_items as $order_item ){
                $customiser_data = $order_item->get_meta('customiser_data');
                if(isset($customiser_data) && !empty($customiser_data)) {
                    $meta_value = $customiser_data['customiser_product_name'];
                }
            }
        }
    
        return $meta_value;
    }
}

new Name_customiser;