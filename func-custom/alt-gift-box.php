<?php
class ALT_Gift_Box {
    private $acf_name = 'field_6246a1950d5bd';
    private $no_add_to_cart_msg = 'You can only add this one product to the cart.';
    private $require_add_to_cart_msg = 'You cannot buy this product.';

    function __construct() {
        $this->register_acf_settings();

        
        add_action( 'init', array( $this, 'remove_cart') );
        add_action( 'woocommerce_cart_item_removed', array( $this,'remove_cart_of_wc'), 99, 2 );
        //add_action( 'template_include', array( $this, 'disable_product_gift' ), 99 );
        add_action( 'wp_footer', array( $this, 'display_flash_message') );


        add_action('acf/save_post', array( $this, 'save_theme_options'), 20);
        //add_action('woocommerce_add_to_cart', array( $this, 'add_to_cart'), 20, 6);
        //add_action('woocommerce_after_cart_item_name', array( $this, 'show_text_gift'), 20, 2 );
        add_action('woocommerce_after_add_to_cart_button', array( $this, 'show_giftbox'), 40 );
        add_action('woocommerce_after_add_to_cart_button', array( $this, 'disable_add_to_cart') );
        add_action('woocommerce_mini_cart_contents', array( $this, 'show_mini_cart_gift') );
        add_action( 'woocommerce_cart_contents', array( $this, 'cart_show_text_gift') );
        

        add_filter('woocommerce_add_to_cart_validation', array( $this, 'validate_before_add_to_cart'), 99, 3);
        add_filter( 'woocommerce_locate_template', array( $this, 'woocommerce_locate_template'), 99, 3 );
        add_filter( 'woocommerce_quantity_input_args', array( $this, 'woocommerce_quantity_input'), 99, 2 );
        //add_filter('woocommerce_product_is_in_stock', array( $this, 'woocommerces_purchasable' ), 99, 2 );
        add_filter( 'alt_get_mini_cart', array($this, 'alt_get_mini_cart'), 99, 1 );
        add_filter( 'alt_get_mini_cart_gift', array($this, 'alt_get_mini_cart_gift'), 99, 1 );
        
    }

    public function show_mini_cart_gift() {
        if( ! empty($this->is_enable()) ) {
            $gift_id = $this->get_product_gift_id();

            $product = wc_get_product($gift_id);
            if( ! empty($product) ) {
    
                $text_for_minicart = get_field('text_for_minicart', 'option');
                $description = get_Field('description_for_minicart', 'option');

                if( empty($this->is_gift_in_cart()) ) {
                    echo '<div class="alt-minicart-item-wrapper">';
                        if( function_exists('alt_elementor_pro_render_mini_cart_item') ) {
                            echo '<div class="alt-minicart-item-label"><span>' . $text_for_minicart .'</span></div>';
                            include_once get_template_directory() .'/func-custom/alt-gift-box/lvc-cart-item.php';
                        }else {
                            echo '<li class="alt-minicart-item-label"><span>' . $text_for_minicart .'</span></li>';
                            include_once get_template_directory() .'/woo-custom/alt-gift-box/skj-cart-item.php';
                        }
                    echo '</div>';
                }
            }
        }
    }

    public function cart_show_text_gift() {
        if( ! empty($this->is_enable()) ) {
            $gift_id = $this->get_product_gift_id();

            $product = wc_get_product($gift_id);
            if( ! empty($product) ) {
                $text_for_minicart = get_field('text_for_minicart', 'option');
                $description = get_Field('description_for_minicart', 'option');
    
                if( empty($this->is_gift_in_cart()) ) {
                    printf('</table><div class="alt-giftbox-cart-wrapper"><div class="alt-giftbox-cart-heading">%s</div>', $text_for_minicart);
                    
                    //if( defined( 'ELEMENTOR_VERSION' ) ) {
                        include_once get_template_directory() .'/func-custom/alt-gift-box/lvc-cart-page.php';
                    // }else {
                    //     include_once get_template_directory() .'/woo-custom/alt-gift-box/cart-page.php';
                    // }
                    echo '</div><table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents shop_table_coupon"><tbody>';
                }
            }
        }
    }

    /**
     * Disable quantity cart
     * @since 04/04/2022
     */
    public function woocommerce_quantity_input($args, $product) {
        if( ! empty($this->is_enable()) && $this->get_product_id($product) == $this->get_product_gift_id() ) {
            //if( $product->is_in_stock() ) {
                $args['min_value'] = 1;
                $args['max_value'] = 1;
            //}
        }

        return $args;
    }

    public function woocommerces_purchasable( $stock, $product ) {
        if( $product->get_id() == $this->get_product_gift_id() ) {
            $stock = $this->is_gift_in_cart() ? false : $stock;;
        }

        return $stock;
    }

    public function disable_add_to_cart() {
        global $product;

        $gift = $this->is_gift_in_cart();?>
        <script>
            var buttonAddToCart = document.getElementsByClassName('single_add_to_cart_button')[0];
            <?php if( ! empty($this->is_enable()) && ! empty($gift) && $product->get_id() == $gift ) { ?>
                
                buttonAddToCart.classList.add("disabled");
                buttonAddToCart.classList.add("alt-button-cart");
                buttonAddToCart.disabled = true;
            <?php }else {
                if( empty(WC()->cart->get_cart()) && ! empty($this->is_enable()) && $this->get_product_id($product) == $this->get_product_gift_id() ) { ?>
                    jQuery(document).ready(function() {
                        jQuery('.single_add_to_cart_button').hide().after('<button type="button" class="button button-single-cart">' + jQuery('.single_add_to_cart_button').text() + '</button>');

                        jQuery(document).on('click', '.button-single-cart', function(e) {
                            e.preventDefault();

                            if( jQuery('.alt-notices-wrapper').length <= 0 ) {
                                jQuery('.woocommerce-breadcrumb').before('<div class="woocommerce-notices-wrapper alt-notices-wrapper"><ul class="woocommerce-error" role="alert"><li><strong><?php echo esc_attr($product->get_name());?></strong> is only available as an add-on to your order. Please add a product to your cart before purchasing <strong><?php echo esc_attr($product->get_name());?></strong></li></ul></div>');

                                jQuery('html, body').animate({
                                    scrollTop: jQuery(".alt-notices-wrapper").offset().top - 150
                                }, 1000);
                            }
                        });
                    });
                    <?php
                }
            }?>
            var gift_id = <?php echo $this->get_product_gift_id();?>
        </script>
        <?php
    }

    /**
     * Show Gift Box
     * @since 04/04/2022
     */
    public function show_giftbox() {
        global $product;

        $gift_id = $this->get_product_gift_id();

        if( ! empty($this->is_enable()) && $product->get_id() != $gift_id ) {
            $gift = wc_get_product($gift_id);

            if( ! empty($gift) ) { ?>
                <div class="alt-giftbox">
                    <div class="alt-giftbox-data">
                        <div class="alt-giftbox-title"><?php echo esc_attr( $gift->get_title() );?></div>
                        <div class="alt-giftbox-sku"><?php echo trim(get_field('description_for_giftbox', 'option') );?></div>
                    </div>

                    <div class="alt-giftbox-thumbnail">
                        <img src="<?php echo wp_get_attachment_url( $gift->get_image_id() ); ?>" alt="Gift With Purchase">
                    </div>
                </div>
                <?php

                $this->alt_gift_popup($gift);
            }
        }
    }

    private function alt_gift_popup($gift) {
        $sku = $gift->get_sku();
        ?>
        <!-- Modal -->
        <div class="modal fade" id="showGiftModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button class="modal-gift-close" data-dismiss="modal" aria-label="Close"></button>
                        <div class="gift-container">
                            <div class="gift-left-thumbnail">
                                <a href="<?php echo esc_url( get_permalink($gift->get_id()) );?>">
                                    <img src="<?php echo wp_get_attachment_url( $gift->get_image_id() ); ?>" />
                                </a>
                            </div>
                            <div class="gift-right-detail">
                                <h1><?php echo esc_attr( $gift->get_title() );?></h1>

                                <?php if( ! empty($sku) ) { ?>
                                <div class="product_meta">
                                    <span class="sku"><?php echo esc_attr($sku);?></span>
                                </div>
                                <?php }?>
                                <!-- <p class="price static-price isnt-on-sale">{price_html}<span class="red-text">FREE</span></p> 
                                <p class="price static-price isnt-on-sale"><span class="red-text">Gift with Purchase</span></p>-->
                                <div class="product_desc"><?php echo trim(get_field('description_for_popup', 'option') );
                                //$gift->get_description();?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function disable_product_gift( $template ) {
        global $wp_query;

        if( ! empty($wp_query->posts[0]) && $wp_query->is_single && ! empty($wp_query->query['post_type']) && $wp_query->query['post_type'] == 'product' ) {
            if( $wp_query->posts[0]->ID == $this->get_product_gift_id() ) {
                $carts = WC()->cart->get_cart();

                $in_cart = false;
                // foreach( $carts as $cart_item_key => $cart ) {
                //     if( $cart['product_id'] == $wp_query->posts[0]->ID ) {
                //         $in_cart = true;
                //     }
                // }

                if( empty($carts) ) {
                    $in_cart = true;
                }

                if( ! empty($in_cart) && ! isset($_POST['add-to-cart']) && ! isset($_REQUEST['removed_item']) ) {
                    setcookie( 'flash_message', sprintf('Product %s is invalid.', $wp_query->posts[0]->post_title), time() + 3600, COOKIEPATH, COOKIE_DOMAIN );
                    wp_safe_redirect( get_permalink( woocommerce_get_page_id( 'shop' ) ) );
                }
            }
        }

        return $template;
    }

    public function display_flash_message() {
        if( isset($_COOKIE['flash_message']) ) {
            $flash_message = esc_attr($_COOKIE['flash_message']);
            setcookie( 'flash_message', '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN ); ?>
            <script>
                alert('<?php echo $flash_message;?>');
            </script>
            <?php
        }
    }

    public function remove_cart() {
        if(  $this->is_request_remove_cart() ) {
            $carts = WC()->cart->get_cart();

            if( ! empty($carts) && count($carts) == 1 ) {
                foreach( $carts as $cart_item_key => $cart ) {
                    if( $cart['product_id'] == $this->get_product_gift_id() ) {
                        WC()->cart->remove_cart_item( $cart_item_key );
                    }
                }
            }
        }
    }

    public function remove_cart_of_wc($item_key, $cart) {
        $this->remove_cart();
    }

    /**
    * Overwrite Mini Cart write by Elementor PRO
    * @since 01/04/2022
    * @author David Lee
    */
    public function woocommerce_locate_template($template, $template_name, $template_path) {
        if ( 'cart/mini-cart.php' !== $template_name ) {
            return $template;
        }

        $plugin_path = get_template_directory() . '/woocommerce/cart/';
    
        
        if ( file_exists( $plugin_path . 'mini-cart-elementor.php' ) ) {
            $template = $plugin_path . 'mini-cart-elementor.php';
        }
 
        return $template;
    }

    public function validate_before_add_to_cart($return, $product_id, $quantity) {
        $_pid = get_option( 'options_product_for_gift');
        $cart = WC()->cart->get_cart();

        if( $product_id == $_pid) {
            if( empty($cart) ) {
                wc_add_notice(
                    sprintf( '<a href="%s" tabindex="1" class="button wc-forward">%s</a> %s', esc_url( wc_get_cart_url() ), esc_html__( 'View cart', 'woocommerce' ), esc_html( $this->require_add_to_cart_msg, ) ),
                    'error' 
                );

                $return = false;
            }else {
                $in_cart = $this->is_gift_in_cart();

                if( ! empty($in_cart) ) {
                    wc_add_notice( 
                        sprintf( '<a href="%s" tabindex="1" class="button wc-forward">%s</a> %s', esc_url( wc_get_cart_url() ), esc_html__( 'View cart', 'woocommerce' ), esc_html( $this->no_add_to_cart_msg, ) ),
                        'error'
                    );

                    $return = false;
                }
            }
        }
        
        return $return;
    }

    //$cart_item, $cart_item_key
    public function show_text_gift($cart_items, $cart_item_key) {
        $product_id = $this->is_gift_in_cart();

        if( empty($product_id) ) {
            $text = get_option('options_text_for_gift');
            printf('<p data-href="%s" class="alt-cart-text-gift">%s</p>', get_permalink($this->get_product_gift_id()), $text);
        }
        // $product_id = get_option( 'options_product_for_gift');
        // if( ! empty($product_id) ) {
        //     $is_show = true;
        //     $all_cart_items = WC()->cart->get_cart();
        //     if( ! empty($all_cart_items) ) {
        //         foreach( $all_cart_items as $_cart_item_key => $_cart_item ) {
        //             if( $_cart_item['product_id'] == $product_id ) {
        //                 $is_show = false;
        //             }
        //         }
        //     }

        //     if( $is_show ) {

        //     }
        // }
    }

    public function register_acf_settings() {
        if( function_exists('acf_add_local_field_group') ) {
            acf_add_local_field_group(array(
                'key' => 'group_62469e3b55eff',
                'title' => 'Gift Settings',
                'fields' => array(
                    array(
                        'key' => 'field_624d0cea97e7d',
                        'label' => 'Enable/Disable',
                        'name' => 'giftbox_enable',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => '',
                        'default_value' => 1,
                        'ui' => 1,
                        'ui_on_text' => 'Enable',
                        'ui_off_text' => 'Disable',
                    ),
                    array(
                        'key' => $this->acf_name,
                        'label' => 'Gift Products',
                        'name' => 'product_for_gift',
                        'type' => 'post_object',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_624d0cea97e7d',
                                    'operator' => '==',
                                    'value' => '1',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'post_type' => array(
                            0 => 'product',
                        ),
                        'taxonomy' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'return_format' => 'object',
                        'ui' => 1,
                    ),
                    array(
                        'key' => 'field_6246a1950d5b5',
                        'label' => 'Description',
                        'name' => 'description_for_minicart',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_624d0cea97e7d',
                                    'operator' => '==',
                                    'value' => '1',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'post_type' => array(
                            0 => 'product',
                        ),
                        'taxonomy' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 1,
                    ),
                    array(
                        'key' => 'field_6246a1750d5b5',
                        'label' => 'Label display on mini cart',
                        'name' => 'text_for_minicart',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_624d0cea97e7d',
                                    'operator' => '==',
                                    'value' => '1',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'post_type' => array(
                            0 => 'product',
                        ),
                        'taxonomy' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 1,
                    ),
                    array(
                        'key' => 'field_6746a1950d5b5',
                        'label' => 'Description for Gift box',
                        'name' => 'description_for_giftbox',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_624d0cea97e7d',
                                    'operator' => '==',
                                    'value' => '1',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'post_type' => array(
                            0 => 'product',
                        ),
                        'taxonomy' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 1,
                    ),
                    array(
                        'key' => 'field_62569c3b051a1',
                        'label' => 'Description for Popup',
                        'name' => 'description_for_popup',
                        'type' => 'wysiwyg',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_624d0cea97e7d',
                                    'operator' => '==',
                                    'value' => '1',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'tabs' => 'all',
                        'toolbar' => 'basic',
                        'media_upload' => 1,
                        'delay' => 0,
                    )
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'theme-settings',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ));
        }
    }

    public function save_theme_options($post_id) {
        if( $post_id == 'options' ) {
            if( ! empty($_POST['acf'][$this->acf_name]) && is_numeric($_POST['acf'][$this->acf_name]) ) {
                $product_id = absint($_POST['acf'][$this->acf_name]);
                $product = wc_get_product($product_id);

                if( ! empty($product) ) {
                    $terms = array( 'exclude-from-search', 'exclude-from-catalog' ); // for hidden..
                    wp_set_post_terms( $product_id, $terms, 'product_visibility', false );
                }
            }
        }
    }

    public function alt_get_mini_cart($carts) {
        if( ! empty($carts) ) {
            foreach( $carts as $cart_item_key => $cart_item ) {
                if( $cart_item['product_id'] == $this->get_product_gift_id() ) {
                    unset($carts[$cart_item_key]);
                }
            }
        }

        return $carts;
    }

    public function alt_get_mini_cart_gift($carts) {
        if( ! empty($carts) ) {
            foreach( $carts as $cart_item_key => $cart_item ) {
                if( $cart_item['product_id'] != $this->get_product_gift_id() ) {
                    unset($carts[$cart_item_key]);
                }
            }
        }

        return $carts;
    }

    

    private function get_product_gift_id() {
        return (int)get_option( 'options_product_for_gift');
    }

    /**
     * Get product id
     * @since 06/04/2022
     */
    private function get_product_id($product) {
        $product_id = $product->get_id();

        if( $product->get_type() == 'variation' ) {
            $product_id = $product->get_parent_id();
        }

        return $product_id;
    }

    //
    private function is_gift_in_cart() {
        $pid = 0;
        $product_id = $this->get_product_gift_id();
        if( ! empty($product_id) ) {
            $all_cart_items = WC()->cart->get_cart();
            if( ! empty($all_cart_items) ) {
                foreach( $all_cart_items as $_cart_item_key => $_cart_item ) {
                    if( $_cart_item['product_id'] == $product_id ) {
                        $pid = $product_id;
                    }
                }
            }
        }

        return $pid;
    }

    private function is_request_remove_cart() {
        if( ! empty($_REQUEST['remove_item']) && ! empty($_REQUEST['_wpnonce']) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'woocommerce-cart' ) || ! empty($_REQUEST['wc-ajax']) && $_REQUEST['wc-ajax'] == 'remove_from_cart' ) {
            return true;
        }

        return false;
    }

    private function is_enable() {
        $enable = get_option( 'options_giftbox_enable');
        return empty($enable) ? false : true;
    }
}

new ALT_Gift_Box();

add_action('init', function() {
    // if( isset($_GET['altdev']) ) {
    //     global $wpdb;

    //     $results = $wpdb->get_results("SELECT * FROM {$wpdb->postmeta} WHERE post_id = 748477");
    //     echo '<pre>';
    //     print_r($results);
    //     echo '</pre>';
    //     die();
    // }
});