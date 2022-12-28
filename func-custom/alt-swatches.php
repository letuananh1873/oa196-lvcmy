<?php
define( 'ALT_SWATCHES_PATH', get_template_directory() . '/func-custom/alt-swatches/' );
define( 'ALT_SWATCHES_URL',get_template_directory_uri() .'/func-custom/alt-swatches/' );

class ALT_Product_Swatches {

    static $plugin_id = 'color_swatches';
    /**
     * Variable to hold the initialization state.
     *
     * @var  boolean
     */
    protected static $initialized = false;

    public static $types = array();
    
    /**
     * Initialize functions.
     *
     * @return  void
     */
    public static function initialize() {
        // Do nothing if pluggable functions already initialized.
        if ( self::$initialized ) {
            return;
        }

        if ( ! function_exists( 'WC' ) ) {
            add_action( 'admin_notices', array( __CLASS__, 'install_woocommerce_admin_notice') );
        }else{
            self::$types = array(
                'color' => esc_html__( 'Color', 'wcvs' ),
                'image' => esc_html__( 'Image', 'wcvs' ),
                'radio' => esc_html__( 'Radio', 'wcvs' ),
                'label' => esc_html__( 'Label', 'wcvs' ),
            );

            add_filter( 'product_attributes_type_selector', array( __CLASS__, 'add_attribute_types' ) );

            // if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            //     require_once 'inc/ajax.php';
            //     NBT_Color_Swatches_Ajax::initialize();
            // }
            
            require_once ALT_SWATCHES_PATH . '/inc/admin.php';
            require_once ALT_SWATCHES_PATH . 'inc/frontend.php';
        }

        self::$initialized = true;
    }
    
    /**
     * Method Featured.
     *
     * @return  array
     */
    public static function install_woocommerce_admin_notice() {?>
        <div class="error">
            <p><?php _e( 'WooCommerce plugin is not activated. Please install and activate it to use for plugin <strong>NBT WooCommerce Price Matrix</strong>.', 'nbt-ajax-cart' ); ?></p>
        </div>
        <?php    
    }

    /**
     * Add extra attribute types
     * Add color, image and label type
     *
     * @param array $types
     *
     * @return array
     */
    public static function add_attribute_types( $types ) {
        $types = array_merge( $types, self::$types );

        alt_write_log('add_attribute_types');
        alt_write_log($types);

        return $types;
    }

    /**
     * Get attribute's properties
     *
     * @param string $taxonomy
     *
     * @return object
     */
    public static function get_tax_attribute( $taxonomy ) {
        global $wpdb;

        $attr = substr( $taxonomy, 3 );
        $attr = $wpdb->get_row( $wpdb->prepare("SELECT * FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = %s", $attr) );

        return $attr;
    }

    public static function get_style(){
        return array(
            'square' => __('Square', 'nbtcs'),
            'circle' => __('Circle', 'nbtcs')
        );
    }
}

ALT_Product_Swatches::initialize();

class ALT_Swatches {
    function __construct() {
        add_filter('wc_get_template', array($this, 'alt_gallery_template_override'), 99, 2);
    }
    
    function alt_gallery_template_override( $template, $template_name ) {
        if ( $template_name == 'single-product/product-image.php' ) {
            // $type = get_field('product_image_type', 'option');
            // $type = empty($type) ? 'default' : esc_attr($type);

            // if( $type != 'default' ) {
            //     $template = get_template_directory() . '/func-custom/alt-swatches/product-images.php';
            // }else {
                
                if( function_exists('rtwpvg') ) {
                    $template = rtwpvg()->locate_template('product-images');
                }
            // }
        }
        
        return $template;
    }
}

new ALT_Swatches();

add_action('wp_enqueue_scripts', function() {
	wp_enqueue_style('jquery.ez-plus', get_template_directory_uri() . '/assets/css/jquery.ez-plus.css', array(), date('h:m:i'));
	wp_enqueue_script('jquery.ez-plus', get_template_directory_uri() . '/assets/js/jquery.ez-plus.js', array('jquery'), date('h:m:i'), true);
});;