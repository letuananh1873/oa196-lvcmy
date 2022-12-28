<?php

class ALT_Product_Swatches_Frontend {
    private $exclude_term = 'create-engagement-rings';
    public function __construct() {
        add_action('woocommerce_before_add_to_cart_form', array($this, 'show_swatches') );
        add_filter( 'body_class', array( $this, 'add_body_class' ) );
    }

    /**
     * Add body class has-swatches for Single product
     * @since 13/04/2022
     */
    public function add_body_class($classes) {
        global $post;

        if( is_single() && !empty($post) && ! $this->is_disable($post->ID) ) {
            $classes = array_merge( $classes, array( 'has-swatches' ) );
        }

        return $classes;
    }

    public function show_swatches() {
        global $product;

        if( $this->is_disable($product->get_id()) ) {
            return;
        }

        if( $product->is_type('variable') && $product->is_in_stock() ) {
            $attributes = $product->get_attributes();
            $attributes_selected = $this->get_attribute_selected();

            if( ! empty($attributes) ) {
                $total_attribute = count($attributes);
                $class_attributes = (count($attributes) == 1) ? ' has-one-attribute' : ' has-multi-attributes';
                $html = '<div class="alt-colorswatches-wrapper'.$class_attributes.'" data-url="'. rtrim(get_permalink($product->get_id()), '/') .'" data-product_name="'. esc_attr($product->get_slug()).'">';
                foreach( $attributes as $attribute_name => $attribute ) {
                    if( ! empty($attribute->get_variation()) && $attribute->is_taxonomy() ) {
                        $name  = wc_attribute_label( $attribute->get_name(), $product );
                        $terms = $attribute->get_terms();

                        $selected = isset($attributes_selected[$attribute_name]) ? $attributes_selected[$attribute_name] : '';
                        $attr = $this->get_tax_attribute( $attribute_name );
                        $style = get_option('attribute_style_'.$attribute->get_id());

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

    private function get_attribute_selected() {
        if( ! empty($_GET) ) {
            $data = [];
            foreach( $_GET as $attr => $value ) {
                $name = str_replace('attribute_', '', $attr);

                $data[$name] = $value;
            }

            return $data;
        }
    }

    private function is_disable($post_id) {
        $term_obj_list = get_the_terms( $post_id, 'product_cat' );
        if( ! empty($term_obj_list) ) {
            $exclude_product_category = get_field('exclude_product_category', 'option');
            if( empty($exclude_product_category) ) {
                return;
            }

            foreach( $term_obj_list as $term ) {
                if( in_array( $term->term_id, $exclude_product_category) ) {
                    return true;
                }
            }
        }
    }
}

new ALT_Product_Swatches_Frontend();