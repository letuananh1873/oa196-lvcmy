<?php
define('CUSTOMISER_URI', get_template_directory_uri() .'/customiser/' );
define('CUSTOMISER_PATH', __DIR__);
define('PAGE_NAME', 'name-customiser');
define('CREATION_PAGE_SLUG', 'my-creations');

require(CUSTOMISER_PATH .'/includes/class-customiser-enqueue.php');
require(CUSTOMISER_PATH .'/includes/class-custom-core.php');
require(CUSTOMISER_PATH .'/includes/class-name-customiser.php');

// Functions

function get_type_of_name($name = '') {
    $name_length = strlen($name);
    if( $name_length <= 5) {
        return 'sally-necklace';
    } 
    if($name_length > 5 && $name_length <= 9) {
        return 'angelina-necklace';
    } 
    if($name_length > 9 && $name_length <= 15) {
        return 'jacqueline-necklace';
    } 

    return false;
}

function get_user_creations($user_id = '') {
    if(empty($user_id)) {
        $user_id = get_current_user_id();
    }
    return get_user_meta($user_id, 'user_customiser_creation', true);
}

add_filter('wc_add_to_cart_message', 'customiser_message', 10, 2 );
function customiser_message($message, $product_id) {
    $product = wc_get_product($product_id);
    $product_name = $_POST['product_name'] ?? '';
    if(!empty($product_name)) {
        $message = sprintf(__('"%s" has been added to cart.'), $product_name);
    }

    return $message;
} 
function product_gallery_count($product_id) {
   
    $product = wc_get_product($product_id);
    $product_thumb = get_the_post_thumbnail_url($product->get_id());
    $product_gallery_ids = $product->get_gallery_image_ids() ?? array();
    return count($product_gallery_ids);
}