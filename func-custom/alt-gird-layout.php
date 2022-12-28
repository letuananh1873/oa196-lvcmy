<?php
class ALT_Gird_Layout {

    function __construct() {
        add_action( 'alt_shop_item_swatches', array( $this, 'shop_swatches' ), 20, 1 );
        add_filter('woocommerce_sale_flash', array( $this, 'woocommerce_custom_sale_text'), 10, 3);
        add_action('wp_ajax_alt_load_filter', array( $this, 'alt_load_filter') );
        add_action('wp_ajax_nopriv_alt_load_filter', array( $this, 'alt_load_filter') );
    }

    function woocommerce_custom_sale_text($text, $post, $_product) {
        return '<span class="onsale">50% Off</span>';
    }

    function shop_swatches( $product) {

        if( $product->is_type('variable') && $product->is_in_stock() ) {
            $attributes = $product->get_attributes();

            if( ! empty($attributes) ) {
                // Get Available variations?
		        $get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
                $available_variations = $get_variations ? $product->get_available_variations() : false;

                $attribute_keys  = array_keys( $product->get_variation_attributes() );
                $variations_json = wp_json_encode( $this->get_simple_available_variations($available_variations)  );
                $variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

                $attribute_pretty_urls = get_option('_wc_attribute_pretty_urls');
                $show_attributes = get_option('_product_listing_attributes');


                $html = '<div class="alt-colorswatches-wrapper" data-product_variations="'.$variations_attr .'" data-id="'. $product->get_id().'" data-url="'. rtrim(get_permalink($product->get_id()), '/') .'" data-product_name="'. esc_attr($product->get_slug()).'">';
                $total_attribute = count($attributes);
                foreach( $attributes as $attribute_name => $attribute ) {
                    if( ! empty($attribute->get_variation()) && $attribute->is_taxonomy() ) {
                        $name  = wc_attribute_label( $attribute->get_name(), $product );
                        $terms = $attribute->get_terms();

                        $selected = '';
                        $attr = $this->get_tax_attribute( $attribute_name );
                        $style = get_option('attribute_style_'.$attribute->get_id());

                        $extra_class = '';
                        if( ! isset($show_attributes[$attribute_name]) ) {
                            $extra_class = 'alt-colorswatche-disable-item';
                            
                        }

                        // if( alt_is_debug() ) {
                        //     echo 'ok';
                        // }
 
                        ob_start();
                        include ALT_SWATCHES_PATH . 'templates/swatches-item.php';
                        $html .= ob_get_clean();
                    }
                }

                $html .= '</div>';

                echo $html;
            }
        }
    }

    /**
     * Get attribute's properties
     *
     * @param string $taxonomy
     *
     * @return object
     */
    public function get_tax_attribute( $taxonomy ) {
        global $wpdb;

        $attr = substr( $taxonomy, 3 );
        $attr = $wpdb->get_row( $wpdb->prepare("SELECT * FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = %s", $attr) );

        return $attr;
    }

    public function get_simple_available_variations( $variations ) {
        $new_variations = array();

        if( ! empty($variations) ) {
            foreach( $variations as $variation ) {
                $new_images = array();
                $new_images[] = $variation['variation_gallery_images'][0];
                if( count( $variation['variation_gallery_images']) > 0 ) {
                    $new_images[] = $variation['variation_gallery_images'][1];
                }

                $new_variations[] = array(
                    'attributes' => $variation['attributes'],
                    'price_html' => $variation['price_html'],
                    'gallery_images' => array_filter($new_images)
                );
            }
        }

        return $new_variations;
    }

    public function alt_load_filter() {
        $htmls = $_POST['html'];

        if( ! empty($htmls) ) {
            foreach( $htmls as $html ) {
                $html = urldecode($html);
                if( preg_match('/<div class=\"fs-option-label\">([A-Za-z ]+)/', $html, $output_array) ) {
                    echo '<pre>';
                    print_r($output_array);
                    echo '</pre>';
                }
            }
        }

        echo '<pre>';
        print_r($htmls);
        echo '</pre>';




    }
}

new ALT_Gird_Layout();