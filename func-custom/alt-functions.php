<?php
if( ! function_exists('alt_is_debug') ) {
    function alt_is_debug() {
        $ip = '118.70.52.28';
        $agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.124 Safari/537.36 Edg/102.0.1245.44';
        

        if( isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == $ip && isset($_SERVER['HTTP_USER_AGENT']) &&  $_SERVER['HTTP_USER_AGENT'] == $agent ) {
            return true;
        }
    }
}

class ALT_WC_Attribute_Pretty_URL {
    private $attributes = [];
    private $product_name;
	function __construct() {
		add_filter('acf/load_field/key=field_627f1da43cb00', array( $this, 'render_dropdown_attributes'), 90, 1 );
        add_filter('acf/load_field/key=field_634f5fa745d1e', array( $this, 'render_dropdown_attributes'), 90, 1 );
		add_action('acf/save_post',array( $this, 'save_attributes' ), 20);

        add_filter('posts_where', array( $this, 'posts_where' ), 90, 2 );
        add_action('wp_footer', array( $this, 'set_default_attributes' ) );
	}

	function render_dropdown_attributes($field) {
        global $wpdb;
        
        // Add options to select field
        $field['choices'] = array();
        
        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}woocommerce_attribute_taxonomies ORDER BY attribute_id ASC");
        
        if( ! empty($results) ) {
            foreach( $results as $row ) {
                $field['choices']['pa_'.$row->attribute_name] = $row->attribute_label;
            }
        }
    
        return $field;
    }

	function save_attributes( $post_id ) {
		global $wpdb;

		if( empty($_POST['acf']['field_627f1da43cb00']) || empty($_POST['acf']['field_634f5fa745d1e']) ) {
			return;
		}

		$wc_attribute_pretty_urls = $_POST['acf']['field_627f1da43cb00'];
	
		if( ! empty($wc_attribute_pretty_urls) ) {
			$saved = [];
			foreach( $wc_attribute_pretty_urls as $attribute_name ) {
				$results = $wpdb->get_results($wpdb->prepare(
					"SELECT t.slug FROM {$wpdb->terms} as t LEFT JOIN {$wpdb->prefix}term_taxonomy as tt ON t.term_id = tt.term_id WHERE tt.taxonomy = %s AND count > 0 ORDER BY tt.term_id ASC",
					$attribute_name
				), ARRAY_A);
	
				if( ! empty($results) ) {
	
					foreach( $results as $slug) {
						$saved[$attribute_name][] = $slug['slug'];
					}
				}
			}
	
			if( ! empty($saved) ) {
				update_option('_wc_attribute_pretty_urls', $saved);
			}
		}

        
		$product_listing_attributes = $_POST['acf']['field_634f5fa745d1e'];
	
		if( ! empty($product_listing_attributes) ) {
			$saved = [];
			foreach( $product_listing_attributes as $attribute_name ) {
				$results = $wpdb->get_results($wpdb->prepare(
					"SELECT t.slug FROM {$wpdb->terms} as t LEFT JOIN {$wpdb->prefix}term_taxonomy as tt ON t.term_id = tt.term_id WHERE tt.taxonomy = %s AND count > 0 ORDER BY tt.term_id ASC",
					$attribute_name
				), ARRAY_A);
	
				if( ! empty($results) ) {
	
					foreach( $results as $slug) {
						$saved[$attribute_name][] = $slug['slug'];
					}
				}
			}
	
			if( ! empty($saved) ) {
				update_option('_product_listing_attributes', $saved);
			}
		}
	}

	function posts_where($where, \WP_Query $wp_query) {
		global $wpdb;


		if( ! is_admin() && $wp_query->is_main_query() ) {
			if( ! empty($wp_query->is_single) && ! empty($wp_query->query['post_type']) && $wp_query->query['post_type'] == 'product' && strpos($where, $wpdb->posts .".post_type = 'product'") ) {
				$_wc_attribute_pretty_urls = get_option('_wc_attribute_pretty_urls');

				if( ! empty($_wc_attribute_pretty_urls) ) {
					$this->product_name = $wp_query->query['name'];

                    // $db = $this->search_by_slug();
                    // $data_db = unserialize($db->meta_value);

                    if( ! empty($_COOKIE['product_name']) ) {
                        if( ! preg_match('/^'. $_COOKIE['product_name'] .'/', $this->product_name, $output_array) ) {
                            return $where;
                        }

                        $this->product_name = sanitize_text_field($_COOKIE['product_name']);
                        
                        if( ! empty($_COOKIE['cookie_variatons']) ) {
                            $cookie_variatons = $this->get_attribute_from_cookies();
                            $GLOBALS['variations'] = $cookie_variatons;
                        }

                        // if( alt_is_debug() ) {
                        //     echo 'Has Cookie';
                        // }

                        $where = "AND {$wpdb->posts}.post_name = '" . $this->product_name . "' AND {$wpdb->posts}.post_type = 'product'";


                    }else {
                        $db = $this->search_by_slug();

                                                        
                        // if( alt_is_debug() ) {
                        //     echo 'Else';
                        // }

                        if( ! empty($db) ) {
                            $data_db = unserialize($db->meta_value);
                            if( isset($data_db[$wp_query->query['name']]) ) {
                                $GLOBALS['variations'] = $data_db[$wp_query->query['name']];
                            }

                                
                            // if( alt_is_debug() ) {
                            //     echo 'Has DB';
                            //     echo '<pre>';
                            //     print_r($db);
                            //     echo '</pre>';
                            // }

                            $where = "AND {$wpdb->posts}.ID = '" . $db->post_id . "' AND {$wpdb->posts}.post_type = 'product'";
                        }else {
                            $is_simple = $this->is_simple($this->product_name);

                            if( empty($is_simple) ) {
                                        
                                // if( alt_is_debug() ) {
                                //     echo 'Has Default';
                                // }
                                
                                $this->sreplace($this->product_name, $_wc_attribute_pretty_urls, 0);

                                // if( alt_is_debug() ) {
                                //     echo '<pre>';
                                //     print_r($this->attributes);
                                //     print_r($this->product_name);
                                //     echo '</pre>';
                                // }
 
                                if( ! empty($this->attributes) ) {
                                    $this->product_name = rtrim($this->product_name, '-');

                                    // if( alt_is_debug() ) {
                                    //     echo $this->product_name;
                                    // }
            
                                    $GLOBALS['variations'] = $this->attributes;
                                }
    
                                $where = "AND {$wpdb->posts}.post_name = '" . $this->product_name . "' AND {$wpdb->posts}.post_type = 'product'";
                            }

                        }
                    }

				}
			}
		
		}

        // if( alt_is_debug() ) {
        //     echo $where;
        //     die();
        // }

		return $where;
	}

    private function search_by_slug() {
        global $wpdb;


        $str = 's:'.strlen($this->product_name).':"'. $this->product_name .'";';

        return $wpdb->get_row($wpdb->prepare(
            "SELECT post_id, meta_value FROM {$wpdb->postmeta} WHERE meta_key = %s AND meta_value = %s",
            '_pretty_urls',
            '%' . $wpdb->esc_like($str) .'%'
        ));
    }

    private function get_attribute_from_cookies() {
        $cookie_variatons = explode('|', $_COOKIE['cookie_variatons']);

        if( ! empty($cookie_variatons) ) {
            $this->attributes = [];
            foreach( $cookie_variatons as $cookie ) {
                $cookies = explode('::', $cookie);
                
                if( ! empty($cookies) && count($cookies) == 2 ) {
                    $this->attributes[$cookies[0]] = $cookies[1];
                }
            }

            return $this->attributes;
        }
    }

    private function is_simple($name) {
        global $wpdb;

        return $wpdb->get_var($wpdb->prepare("SELECT * FROM {$wpdb->posts} WHERE post_name = %s", $name));
    }

    function set_default_attributes() {
        global $variations, $wp_query;



        if( ! empty($wp_query->query['post_type']) && $wp_query->query['post_type'] == 'product' && ! empty($wp_query->queried_object) && ! empty($variations) ) {
            $pretty_urls = get_post_meta($wp_query->queried_object->ID, '_pretty_urls', true);
            $pretty_urls = empty($pretty_urls) ? [] : $pretty_urls;

            if( ! isset($pretty_urls[$wp_query->query['name']]) ) {
                $pretty_urls[$wp_query->query['name']] = $variations;
                update_post_meta($wp_query->queried_object->ID, '_pretty_urls', $pretty_urls);
            }

            $found = true;
        }
        
        
        ?>
        <script>
            jQuery(document).ready(function() {
                document.cookie = 'cookie_variatons=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/';
                document.cookie = 'product_name=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/';

                <?php if( ! empty($found) ) : ?>
                    var alt_has_variatons = true;
                    //setCookie('product_name', wrapper.attr('data-product_name'), 60);
                <?php endif;?>
                
                <?php 
                if( ! empty($variations) ) {
                    end($variations);
                    $key = key($variations);
                    foreach( $variations as $variation_id => $attribute) { ?>
                        var wrapper = jQuery('#alt-colorswatches-<?php echo $variation_id;?>'),
                            item = wrapper.find('#alt-colorswatches-<?php echo $attribute;?>-item'),
                            label = item.attr('data-label');
                        item.addClass('selected');
                        wrapper.find('.alt-colorswatches-item-label-selected').text(label);
                        jQuery('#<?php echo $variation_id;?>').val('<?php echo $attribute;?>');
                    <?php }?>

                jQuery(window).load(function() {
                    jQuery('table.variations tr:last-child select').trigger('change');
                    jQuery('#alt-colorswatches-<?php echo $key;?> #alt-colorswatches-<?php echo $variations[$key];?>-item').trigger('click');
                });
                <?php }?>
            });
        </script>
        <?php
    }

    private function sreplace($string, $attributes, $i = 0) {
        
        $taxonomies = array_keys($attributes);

        if( isset($taxonomies[$i]) ) {
            $key = $taxonomies[$i];

            $find = 0;
            foreach( $attributes[$key] as $attribute ) {

                if( preg_match('/(.*)-'.$attribute.'$/', $string, $output_array) ) {
                    unset($attributes[$key]);
                    $find = 1;

                    $this->product_name = $output_array[1];//rtrim($string, $attribute);
                    $this->attributes[$key] = $attribute;

                    $this->sreplace($output_array[1], $attributes, 0);
                }
            }

            if( empty($find) ) {
                $this->sreplace($string, $attributes, $i+1);
            }
        }
    }

    private function str_lreplace($search, $replace, $subject)
    {
        $pos = strrpos($subject, $search);
    
        if($pos !== false)
        {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }
    
        return $subject;
    }
}


new ALT_WC_Attribute_Pretty_URL;


class ALT_FaceWP_Filter {
    function __construct() {
        add_action('shop_before_heading', array( $this, 'display') );
    }
    
    /**
     * Display HTML filter on mobile
     * @author#225538 LVC Product Listing Page Revamp
     * @since 13/05
     */
    function display() {
        $file = get_template_directory() .'/func-custom/alt-functions/html-facewp-filter.php';
        if( file_exists($file) ) {
            include_once $file;
        }else {
            echo 'Filter exists';
        }
    }

    function get_item($name) {
        $facet = FWP()->helper->get_facet_by_name( $name );
        return sprintf('<div class="altm-facewp-box" data-label="%s">%s</div>', $facet['label_any'], do_shortcode( '[facetwp facet="' . $name . '"]' ));
    }
}

new ALT_FaceWP_Filter;

add_action( 'admin_init', 'alt_custom_remove_menu_pages' );
function alt_custom_remove_menu_pages() {
    remove_menu_page( 'edit.php?post_type=instagram_photos' );
}

add_filter( 'elementor_acf_url', function($value, $key ) {
	if( $key == 'store_phone_no' ) {
		$value = str_replace( array('+', '.', ' '), '', $value );
		$value = 'tel:' . $value;
	}
	return $value;
}, 99, 2);


class ALT_Single_Product_Layout {
    function __construct() {
        add_action('woocommerce_after_add_to_cart_button', array( $this, 'show_book_appointment'), 5 );

        // add_action('woocommerce_after_add_to_cart_button', array( $this, 'show_'), 95 );

        add_filter( 'yith_wcwl_remove_from_wishlist_label', array( $this, 'remove_text_added_text' ) );
        add_filter( 'woocommerce_product_tabs', array( $this, 'woocommerce_product_tabs' ), 99, 1 );
        add_action('wp_enqueue_scripts', array( $this, 'load_js') );
    }

    public function show_book_appointment() {
        echo '<div id="alt-button-book-appointment" class="call-booking-form"><a href="#">Book Appointment in Store</a></div>';    
    }

    public function show_() {
        $return_policy = get_field('return_policy', 'option');
        $return_policy = empty($return_policy) ? [] : $return_policy;

        $return_policy['title'] = empty($return_policy['title']) ? 'Return and Exchange Policy' : esc_attr($return_policy['title']);
        $return_policy['url'] = empty($return_policy['url']) ? '#' : $return_policy['url'];
        $return_policy['target'] = empty($return_policy['target']) ? '' : $return_policy['target'];

        include get_template_directory() . '/template-parts/woocommerce/single-product-detail.php';
    }

    public function remove_text_added_text() {
        return '';
    }

    public function woocommerce_product_tabs($tabs) {
        $new_tabs = array();


        // $tabs['details']['title'] = 'PRODUCT STORY';

        // $new_tabs['details'] = $tabs['details'];
        $new_tabs['details'] = array(
            'title'    => 'PRODUCT STORY',
            'priority' => 20,
            'callback' => array( $this, 'detail_tab' ),
        );

        unset($tabs['details']);
        unset($tabs['reviews']);


        if( have_rows('product_details') ) {
            $new_tabs['additional_information'] = array(
                'title'    => 'PRODUCT SPECS',
                'priority' => 20,
                'callback' => array( $this, 'additional_information_tab' ),
            );
        }else {
            unset($new_tabs['additional_information']);
        }

        $new_tabs['delivery'] = array(
            'title' 	=> __( 'DELIVERY AND SHIPPING', 'woocommerce' ),
            'priority' 	=> 50,
            'callback' 	=> array( $this, 'delivery_tab' )
        );

        return $new_tabs;
    }

	/**
	 * Output the attributes tab content.
	 */
    
	public function detail_tab() {
        echo '<div class="alt-detail-tab-content">';
        the_content();
        echo '</div>';
	}

	public function additional_information_tab() {
        if( have_rows('product_details') ): ?>
            <ul class="woocommerce-product-attributes">
            <?php while( have_rows('product_details') ): the_row(); ?>
                <li><?php the_sub_field('product_detail_title') ?>: <?php the_sub_field('product_detail_desc') ?></li>
            <?php endwhile; ?>
            </ul>
        <?php endif; 
		// wc_get_template( 'single-product/tabs/additional-information.php' );
	}

    public function delivery_tab() {
        echo do_shortcode('[elementor-template id="149134"]');
    }

    public function load_js() {
        if( is_single() ) {
            $my_css_ver = '2.3.4';
            wp_enqueue_style( 'owl.carousel', get_template_directory_uri() .'/assets/css/owl.carousel.min.css', false,   $my_css_ver );
            wp_enqueue_style( 'owl.theme.default', get_template_directory_uri() .'/assets/css/owl.theme.default.min.css', false,   $my_css_ver );

            
            wp_enqueue_script( 'owl.carousel', get_template_directory_uri() .'/assets/js/owl.carousel.min.js', array(), $my_js_ver );
        }
    }
}

new ALT_Single_Product_Layout();


function alt_error_log($msg) {
    $file = fopen(get_stylesheet_directory() .'/debug.log',"a");
    fwrite($file, date('d/m/Y H:i:s', time()) . ': '.  $msg ."\n");
    fclose($file);
}

function alt_write_log ( $log )  {
    if ( is_array( $log ) || is_object( $log ) ) {
        alt_error_log( print_r( $log, true ) );
    } else {
        alt_error_log( $log );
    }
}


if( ! function_exists('alt_size_img') ) {
    function alt_size_img( $src, $image = array() ) {
        if( ! empty($image) && ! empty($image['width']) && ! empty($image['height']) ) {
            $width = $image['width'];
            $height = $image['height'];
        }else {
            list($width, $height) = getimagesize($src);
        }

        return sprintf(' width="%d" height="%d" src="%s"', $width, $height, esc_url($src) );
    }
}


add_action('init', 'alt_remove_enable_message');
function alt_remove_enable_message() {
    global $wpdb;
    
    if( isset($_GET['alttask']) && $_GET['alttask'] == 252411 ) {

        $sql = $wpdb->prepare("SELECT meta.post_id FROM {$wpdb->postmeta} as meta LEFT JOIN {$wpdb->prefix}term_relationships as tr ON meta.post_id = tr.object_id LEFT JOIN {$wpdb->prefix}term_taxonomy as tt ON tr.term_taxonomy_id = tt.term_taxonomy_id WHERE meta.meta_key = %s AND meta.meta_value = %s AND tt.taxonomy = %s AND tt.term_id != %d GROUP BY meta.post_id", 'enable_message', 'yes', 'product_cat', 474);

        
        $results = $wpdb->get_results( $sql );
        
        if( ! empty($results) ) {
            foreach( $results as $result ) {
                delete_post_meta($result->post_id, 'enable_message', 'yes');
            } 
        }
    }
}

if( ! function_exists('alt_check_exclude_terms') ) {
    function alt_check_exclude_terms($post_id) {
        $exclude_terms = array(474);

        $terms = get_the_terms($post_id, 'product_cat');
    
        if( ! empty($terms) ) {
            foreach( $terms as $term ) {
                if( in_array($term->term_id, $exclude_terms) ) {
                    return true;
                }
            }
        }
    }
}


if( ! function_exists('alt_lazy_img') ) {
    function alt_lazy_img($src, $thumb_src = '', $class = '', $_height = 0) {
        $placeholder_src = get_template_directory_uri() .'/assets/images/bg-gray.jpg';
        if( is_numeric($src) ) {
            $thumbnailId = get_post_thumbnail_id($src);

            $src = wp_get_attachment_image_src($thumbnailId, 'thumbnail');
            $fullSrc = wp_get_attachment_image_src($thumbnailId, 'full');
            return sprintf(
                '<img src="%s" width="%d" height="%d" class="img-fluid lazy-img%s" data-src="%s" />',
                $placeholder_src,
                $src[1],
                $src[2],
                empty($class) ? '' : ' ' . $class,
                $fullSrc[0]
            );
        }else {
            list($width, $height) = getimagesize($src);
            
            
            return sprintf(
                '<img src="%s" width="%d" height="%d" class="img-fluid lazy-img%s" data-src="%s" />',
                $placeholder_src,
                $width,
                $height,
                empty($class) ? '' : ' ' . $class,
                $src
            );
        }
    }
}


function alt_check_attribute_outstock($post_id, $name, $value) {
    global $wpdb;

    // $transient_name = 'alt_attribute_outstock_' . $post_id .'_'.$name.'_'.$value;
    // $result = get_transient( $transient_name );

    $sql = $wpdb->prepare(
        "SELECT meta.post_id FROM {$wpdb->posts} as p LEFT JOIN {$wpdb->postmeta} as meta ON p.ID = meta.post_id LEFT JOIN {$wpdb->postmeta} as meta2 ON meta.post_id = meta2.post_id WHERE p.post_parent = %d AND p.post_type = %s AND meta.meta_key = %s AND meta.meta_value = %s AND meta2.meta_key = %s AND meta2.meta_value = %s",
        $post_id,
        'product_variation',
        'attribute_' . $name,
        $value,
        '_stock_status',
        'outofstock'
    );

    return $wpdb->get_var($sql);
}

add_action('init', function() {
    if( isset($_GET['altdb']) ) {
        global $wpdb;

        $wpdb->delete($wpdb->postmeta, array('meta_key' => '_pretty_urls'));
    }
});

function alt_get_count_tax($term_slug) {
    global $wpdb;

    return $wpdb->get_var($wpdb->prepare("SELECT SUM(count) FROM {$wpdb->prefix}term_taxonomy WHERE taxonomy = %s", $term_slug));
}

add_action('init', function() {
    // if( isset($_GET['clearmenu']) ) {
    //     delete_field( 'jewellery-4', 'term_' . absint($_GET['clearmenu']) );
    //     delete_field( 'diamond-4', 'term_' . absint($_GET['clearmenu']) );
    //     delete_field( 'wedding-band-3', 'term_' . absint($_GET['clearmenu']) );
    //     delete_field( 'gift-4', 'term_' . absint($_GET['clearmenu']) );
    //     delete_field( 'education-1', 'term_' . absint($_GET['clearmenu']) );
    //     delete_field( 'education-2', 'term_' . absint($_GET['clearmenu']) );
    //     die();
    // }


    if( isset($_GET['clearmenu']) && is_user_logged_in() ) {
        $fields = [
            'jewellery-4' => 'View All Collections',
            'diamond-4' => 'Shop Engagement Rings Image',
            'wedding-band-3' => 'Our Wedding Band Concierge Image',
            'gift-4' => 'Enjoy 5% off on your very first purchase with us! Image',
            'education-1' => 'Education Center',
            'education-2' => 'Blog Image',
            'aboutus-4' => 'About Us'
        ];


        if( isset($_POST['submit']) ) {
            foreach($fields as $_key => $f) {
                if( ! empty($_POST[$_key]) ) {
                    update_field( $_key, absint($_POST[$_key]), 'term_' . absint($_GET['clearmenu']) );
                }
            }
        }

        
        ?>
        <form action="" method="POST">
            <?php foreach( $fields as $k => $field ) { ?>
            <p><label><?php echo $field;?></label><br /><input type="number" name="<?php echo $k;?>" value="<?php echo get_term_meta( absint($_GET['clearmenu']), $k, true );?>" /></p>
            <?php }?>

            <button type="submit" name="submit">Save</button>
        </form>
        <?php
        die();
        //update_field('jewellery-4', absint($_GET['id']), 'term_' . absint($_GET['clearmenu']) );

    }
});