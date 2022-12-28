<?php
defined( 'ABSPATH' ) || exit;
// files edited
// shortcode/shop-filterby.php
// inc/compatibility/woocommerce/woocommerce-common-functions.php line 'astra_woo_woocommerce_template_loop_product_title'
// woocommerce\loop\price.php:<div class="list_viewmoreWrap">
// sửa file header.php
// note: sp cha, check khi add to cart và nếu có trong cart rồi thì phải remove
// mon.js line 75

require get_template_directory() . '/func-custom/dianmond/add-metabox-variation.php';
add_filter("body_class", "diamond_type1_custom_body_class", 10, 2);
// change breadcrumb for diamond product
add_filter( 'woocommerce_get_breadcrumb', 'diamond_single_product_edit_prod_name_breadcrumbs', 9999, 2 );
/* custom price html parents diamond product */
//add_filter( 'woocommerce_get_price_html', 'custom_price_format', 10, 2 );
//add_filter( 'woocommerce_variable_price_html', 'custom_price_format', 10, 2 );
/* remove quantity in product diamond */
//add_filter( 'woocommerce_is_sold_individually','custom_remove_all_quantity_fields', 10, 2 );
/* disable add to cart in enganering parents product */
add_filter('woocommerce_is_purchasable', 'filter_is_purchasable', 10, 2);
/* check before add to cart for language*/
add_filter( 'woocommerce_add_to_cart_validation', 'add_the_date_validation', 10, 5 );
add_filter( 'woocommerce_product_data_store_cpt_get_products_query', 'diamond_handle_custom_query_var', 10, 2 );
/* variation_threshold */
//add_filter( 'woocommerce_ajax_variation_threshold', 'ww_ajax_variation_threshold', 8, 2 );
add_action('wp_enqueue_scripts', 'oa_dianmon_css',16);
add_action('wp_enqueue_scripts', 'oa_dianmon_js',16);
add_filter('woocommerce_show_variation_price', function() {return true;});

/*if (function_exists('acf_add_options_page')) {

	

	acf_add_options_page(array(
		'page_title' 	=> 'abc Settings',
		'menu_title'	=> 'abc Settings',
		'menu_slug' 	=> 'abc-settings',
		'parent_slug'=>'theme-settings',
		'redirect'		=> false
	));
		
}*/

// function list_product()
function posts_per_page_variation() {
	return 24;
}

function get_id_variation_valid($product_id,$_metal_type,$_casing,$_dianmond_shapes ,$_diamond_type) {	
         global $wpdb;
    return $wpdb->get_var( "
        SELECT p.ID
        FROM {$wpdb->prefix}posts as p
        JOIN {$wpdb->prefix}postmeta as pm ON p.ID = pm.post_id
        JOIN {$wpdb->prefix}postmeta as pm2 ON p.ID = pm2.post_id
        JOIN {$wpdb->prefix}postmeta as pm3 ON p.ID = pm3.post_id
        JOIN {$wpdb->prefix}postmeta as pm4 ON p.ID = pm4.post_id
        WHERE pm.meta_key = 'attribute_pa_metal-type'
        AND pm.meta_value LIKE '$_metal_type'

        AND pm2.meta_key = 'attribute_pa_diamond-type'
        AND pm2.meta_value LIKE '$_diamond_type'

        AND pm3.meta_key = 'attribute_pa_casing'
        AND pm3.meta_value LIKE '$_casing'

        AND pm4.meta_key = 'attribute_pa_shapes'
        AND pm4.meta_value LIKE '$_dianmond_shapes'

        AND p.post_parent = $product_id
    " );
}

function get_id_thumbnail($product_id) {
	global $wpdb;
        $_metal_type = $_GET['_metal_type'] ?? '';
        $_casing = $_GET['_casing'] ?? '';
        $_dianmond_shapes = $_GET['_dianmond_shapes'] ?? '';
        $wc_query = "SELECT wp_posts.ID FROM `wp_posts` INNER JOIN wp_postmeta 
        WHERE  wp_posts.post_parent = $product_id  
        AND wp_posts.ID = wp_postmeta.post_id 
        AND (SELECT wp_postmeta.meta_value FROM wp_postmeta WHERE wp_postmeta.meta_key = 'attribute_pa_metal-type' AND wp_postmeta.post_id = wp_posts.ID)  = '$_metal_type' 
        AND (SELECT wp_postmeta.meta_value FROM wp_postmeta WHERE wp_postmeta.meta_key = 'attribute_pa_casing' AND wp_postmeta.post_id = wp_posts.ID)  = '$_casing' 
        AND (SELECT wp_postmeta.meta_value FROM wp_postmeta WHERE wp_postmeta.meta_key = 'attribute_pa_shapes' AND wp_postmeta.post_id = wp_posts.ID)  = '$_dianmond_shapes' 
        GROUP by wp_posts.ID;";
        $wc_query = $wpdb->get_results($wc_query);
        $wc_product_id = $product_id;

        if($wc_query) {
            $wc_product_id = $wc_query[0]->ID;
        }

       return $wc_product_id;
}

function get_meta_product_child($product_id,$_metal_type,$_casing,$_dianmond_shapes,$_diamond_type) {	
        $price_field = get_field('price_field')??'';        
        $product_price_html = !empty($price_field) ? '$'.number_format($price_field):'';
        $product_cuts = get_field('attribute_cut',$product_id)??array();        
        $product_url = get_permalink( $product_id ); 
        $class = get_slug_term_in_product($product_id,'designer_collections');
        $product_collection = get_field("attribute_collection", $product_id) ?? array();
        $class_str = '';    
        if (is_array($class) && count($class)>0) {
            foreach ($class as $key => $value) {
                    $class_str .= ' data_attr_'.$value;
            }
        }    
        $wc_product_id =  get_id_variation_valid($product_id,$_metal_type,$_casing,$_dianmond_shapes,$_diamond_type); 

       // var_dump($product_id.'-'.$wc_product_id)   ;   
        if (empty($wc_product_id)) $wc_product_id = $product_id;
        $thumb_url = get_the_post_thumbnail_url($wc_product_id);
       if(!$thumb_url) {
            $thumb_url = get_the_post_thumbnail_url($product_id);
       }
        $collection = array(
        	'lab_diamond' =>'Lab Diamond',
        	'mined_diamond' =>'Mined Diamond',
        );
        $key_collection = get_post_meta($product_id,'attribute_collection',true) ?? "lab_diamond";

        $items = array(
                'product_id' => $product_id, 
                'product_thumb_url' => $thumb_url,              
                'product_url' => $product_url,              
                'product_price' => $price_field,
                'product_price_html' => $product_price_html,
                'product_carats' => get_field('attribute_carats',$product_id)??'',
                'product_clarity' => get_field('attribute_clarity',$product_id),
                'product_color' => get_field('attribute_color',$product_id),
                'product_cut' =>(is_array($product_cuts) && count($product_cuts) > 0 ) ? $product_cuts[0]:'',
                'product_collection' => $collection[$key_collection],               
            );   
        return $items;
}

function class_active_selected($selected,$current) {
	return $selected == $current ? 'active' : '';
}
function attribute_name_slug() {
	return array(
		'pa_shapes' => 'shapes',
		'pa_metal-type' => 'metal_type',
		'pa_casing' => 'casing',
		'pa_diamond-type' => 'diamond-type',
	);
}
function attribute_name_slug2($product_id) {
	$product = wc_get_product($product_id)	;
	$variations = $product->get_variation_attributes();	
    $var = [];
    foreach ($variations as $key => $variation) {
    	$value = str_replace('pa_', '', $key) ;
    	$value = str_replace('-', '_', $key) ;
        $var[$key] = $value ;
    }
    return $var;    
}

function slug_attribute2($product_id) {
	$product = wc_get_product($product_id)	;
	$variations = $product->get_variation_attributes();	
    $var = [];
    foreach ($variations as $key => $variation) {
    	$value = str_replace('pa_', '', $key) ;
    	$value = '_'.str_replace('-', '_', $key) ;
        $var[$key] = $value ;
    }
	return $var;
}

function slug_attribute() {
	return array(
		'pa_shapes' => '_dianmond_shapes',
		'pa_metal-type' => '_metal_type',
		'pa_ring-size' => '_ring_size',
		'pa_casing' => '_casing',
		'pa_diamond-type' => '_diamond_type',
	);
}

function str_filter_variation_diamond_selected() {
	$str_filter = '';
	$str_filter_arr= array();
	$filter_arr = get_selected_variation();

	if (is_array($filter_arr) && count($filter_arr) > 0) {
	  foreach ($filter_arr as $key => $value) {
	    $str_filter_arr[] = $key.'='.$value;
	  }
	}
	$str_filter = implode("&",$str_filter_arr);
	return $str_filter;
}
function get_att_variation($variation_id,$parent_id) {
	$url_extral = get_permalink( $parent_id).'?p_id='.$parent_id;
	$atts = slug_attribute();
	unset($atts['pa_ring-size']);	
	foreach ($atts as $key => $att) {
		$att_key = 'attribute_'.$key;		
		$value = get_post_meta( $variation_id, $att_key, true );
		$url_extral .= '&'.$atts[$key].'='.$value;		
	}	
	return $url_extral;
}
function url_extral_diamond($product_id) {
$paras = array();
		$para_url = '';
		$_dianmond_shapes = $_GET['_dianmond_shapes'] ?? '';
		$_metal_type = $_GET['_metal_type'] ?? '';
		$_casing = $_GET['_casing'] ?? '';
		$_diamond_type = $_GET['_diamond_type'] ?? '';
		if (!empty($_dianmond_shapes)) {
			$paras[] = '_dianmond_shapes='.$_dianmond_shapes;
		}
		if (!empty($_metal_type)) {
			$paras[] = '_metal_type='.$_metal_type;
		}

		if (!empty($_casing)) {
			$paras[] = '_casing='.$_casing;
		}
		if (!empty($_diamond_type)) {
			$paras[] = '_diamond_type='.$_diamond_type;
		}

		if (count($paras) == 1) {
		$para_url .= '?'.$paras[0];
		} else if (count($paras) > 1) {
			foreach ($paras as $key => $value) {
				if ($key == 0) {
					$para_url .= '?'.$value;
				} else {
					$para_url .= '&'.$value;
				}
			}
		}
	if (!empty($product_id)) {
		$url = get_permalink($product_id).$para_url;
	} else {
		return $para_url;
	}
	
	return $url;
}

function get_selected_variation() {

	$paras = array();
	$para_url = '';
	$_dianmond_shapes = $_GET['_dianmond_shapes'] ?? '';
	$_metal_type = $_GET['_metal_type'] ?? '';
	$_casing = $_GET['_casing'] ?? '';
	$_diamond_type = $_GET['_diamond_type'] ?? '';
	if (!empty($_dianmond_shapes)) {
		$paras['pa_shapes'] = $_dianmond_shapes;
	}
	if (!empty($_metal_type)) {
		$paras['pa_metal-type'] = $_metal_type;
	}
	if (!empty($_casing)) {
		$paras['pa_casing'] = $_casing;
	}
	if (!empty($_diamond_type)) {
		$paras['pa_diamond-type'] = $_diamond_type;
	}

	return $paras;
}
function get_cate_in_diamond() {
	$arr_show = array();
    $terms =  get_terms( array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'fields' => 'ids'
    ) );

    if (count($terms) > 0) {
        foreach ($terms as $key => $term_id) {
        	$diamon_type = get_field('template','term_' . $term_id) ?? '';
        	if ($diamon_type == 'type1'){
        		$arr_show[] = $term_id;
        	} 
    	}    
	}

	return $arr_show;
}
function get_slug_term_in_product($product_id,$taxonomy) {
	$terms_slug = array();
	$term_list = wp_get_post_terms($product_id,$taxonomy,array( 'fields' => 'all' ));
		if (!is_wp_error( $term_list ) && count($term_list) > 0) {
			foreach($term_list as $term)	 {
				$terms_slug[] = $term->slug;
			}
		}
	return $terms_slug;
}
function get_term_product_in_diamond($product_id) {
	$term_list = array();
	$cate_diamonds = get_cate_in_diamond();
	if (count($cate_diamonds) > 0) {
		$term_list = wp_get_post_terms($product_id,'product_cat',array('fields'=>'ids'));
		if (!is_wp_error( $term_list ) && count($term_list) > 0) {
			$term_list = array_intersect( $cate_diamonds,$term_list );	
		}
	}
	return $term_list;
}
function is_product_dianmond($product_id) {
	$check = false;
	if (is_product()) {
		$terms_diamond = get_term_product_in_diamond($product_id);
		if (count($terms_diamond) > 0) {
			$check = true;
		}
	}
	return $check;
}
function diamond_single_product_edit_prod_name_breadcrumbs( $crumbs, $breadcrumb ) {
    
   if ( is_product() ) {
      global $product;
      if (is_product_dianmond($product->get_id())) {
      	$index = count( $crumbs ) - 1; // product name is always last item
      $value = $crumbs[$index];
      $crumbs[$index][0] = 'Select Casing';
      }
      
   }
    
   return $crumbs;
}
function class_child_product($product_id) {
	$terms_product = get_term_product_in_diamond($product_id);
	if (count($terms_product) > 0 ) {
		if (get_field('is_parents',$product_id) == 1){
			return "";
		} else { return "single_diamond_type1_child";}
	} else { return '';}
}
function diamond_type1_custom_body_class($classes,$class){
	global $product;
	if ( is_tax() && get_queried_object()) {
		$id = get_prefix_block();
		$diamon_type = get_field('template',$id) ?? '';
        	if ($diamon_type == 'type1'){
        		$classes[] = "body_diamond_type1";
        	}
	}
	if (is_product()) {
		global $product;
		$terms_product = get_term_product_in_diamond(get_the_ID());		
		if (count($terms_product) > 0 ) {
			$classes[] = "product_diamond";
			if (get_field('is_parents',get_the_ID(),true) == 1){
				$classes[] = "product_diamond_type1";
			}			
		else {
			$classes[] = "product_diamond_type1_child";
		}
		}

	}
	return $classes;
}
function ww_ajax_variation_threshold( $default, $product ) {
	return 150;
}
function get_prefix_block() {
	if ( is_search() ) {
			return '';
		} elseif ( is_tax() && get_queried_object()) {
			return 'term_'.get_queried_object()->term_id;
		} else {
			return wc_get_page_id( 'shop' );
		}
}

function lvc_banner($queried_object) {
	ob_start();
	if( get_field('lvc_banner',$queried_object) ): ?>
        <div class="proudct_overview_top_banner diamon-functions">
            <div class="top_banner_bg"><img<?php echo alt_size_img(get_field('lvc_banner', $queried_object)); ?> ></div>
            <div class="top_banner_textBox" style="align-items: <?php
                    if( get_field('lvc_text_box_vertical_alignment', $queried_object) == 'Top' ) { 
                        echo "flex-start";
                    }else if( get_field('lvc_text_box_vertical_alignment', $queried_object) == 'Bottom' ) { 
                        echo "flex-end";
                    } else if( get_field('lvc_text_box_vertical_alignment', $queried_object) == 'Middle' ) { 
                        echo "center";
                    }
                ?> ; justify-content: <?php
                    if( get_field('lvc_text_box_horizontal_alignment', $queried_object) == 'Left' ) { 
                        echo "flex-start";
                    }else if( get_field('lvc_text_box_horizontal_alignment', $queried_object) == 'Right' ) { 
                        echo "flex-end";
                    } else if( get_field('lvc_text_box_horizontal_alignment', $queried_object) == 'Middle' ) { 
                        echo "center";
                    }
                ?> ;">
                <div class="textbox_moving">
                    <?php if( get_field('lvc_banner_title_image', $queried_object) ) { ?>
                        <div class="lvc_title_img"><img<?php echo alt_size_img(get_field('lvc_banner_title_image', $queried_object)); ?>></div>
                    <?php }  ?>
                    <?php if( get_field('lvc_banner_title_text', $queried_object) ) { ?>
                        <h1 class="lvc_title_text" style="color: <?php the_field('lvc_banner_title_color'); ?> !important; " ><?php the_field('lvc_banner_title_text', $queried_object); ?></h1>
                    <?php }  ?>
                    <div class="lvc_banner_desc"><?php the_field('lvc_banner_description', $queried_object); ?></div>

					<?php 
					// #92755
					$mobile_desc = get_field('lvc_banner_description_mobile', $queried_object) ?? get_field('lvc_banner_description', $queried_object) ?: get_field('lvc_banner_description', $queried_object);
					?>
					<div class="lvc_banner_desc lvc_banner_desc-mb"><?php echo $mobile_desc; ?></div>
					<?php // End #92755 ?>
                </div>
            </div>
        </div>

        <div class="proudct_overview_top_banner_sp">
            <div class="top_banner_bg_sp"><img src="<?php the_field('lvc_banner_mobile', $queried_object); ?>"></div>
            <div class="top_banner_textBox_sp">
                <?php if( get_field('lvc_banner_title_image', $queried_object) ) { ?>
                    <div class="lvc_title_img_sp"><img src="<?php the_field('lvc_banner_title_image', $queried_object); ?>"></div>
                <?php }  ?>
                <?php if( get_field('lvc_banner_title_text', $queried_object) ) { ?>
                    <h1 class="lvc_title_text_sp alt-listing-heading"><?php the_field('lvc_banner_title_text', $queried_object); ?></h1>
                <?php }  ?>  
                <div class="lvc_banner_desc"><?php the_field('lvc_banner_description', $queried_object); ?></div>
				<?php 
				// #92755
				$mobile_desc = get_field('lvc_banner_description_mobile', $queried_object) ?? get_field('lvc_banner_description', $queried_object) ?: get_field('lvc_banner_description', $queried_object);
				?>
				<div class="lvc_banner_desc lvc_banner_desc-mb"><?php echo $mobile_desc; ?></div>
				<?php // End #92755 ?>
				<?php do_action('shop_before_heading');?>
            </div>
        </div>


<?php endif;


	$lvc_banner = ob_get_contents();
	ob_clean();
	ob_end_flush();
	return $lvc_banner;
}

// filter meta_query in wc_get_product
function diamond_handle_custom_query_var( $query, $query_vars ) {
    if ( ! empty( $query_vars['is_parent'] ) ) {
        $query['meta_query'][] = array(
            'key' => 'is_parents',
            'value' => esc_attr( $query_vars['is_parent'] ),
        );
    }

    return $query;
}
function return_tax_query_diamond($filters) {
	$tax_query = array(
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => 'create-engagement-rings',
		)
	);
	
	foreach ($filters as $key => $value) { 	
		if (!empty($value)) {
			$tax_query[] = 
			array(
				'taxonomy' => $key,
				'field'    => 'slug',
				'terms'    => $value,
			);
		}
		
	}
	return $tax_query;        
}

function get_parents_engagement() {
    $args = array(
        'category' => array( 'create-engagement-rings' ),
        'return' => 'ids',
        'status' => 'publish',
        'is_parent' => 1,
        'limit' => -1,
    );
    $products = wc_get_products( $args );    
    return $products;
}
function products_diamond_variation($str_filter,$sortby,$paged,$posts_per_page,$parent_product) {
	//var_dump($str_filter);
	$paged = $paged ??get_query_var('paged') ;
	//pa_shapes=round&pa_metal-type=rose-gold
	$meta_query = array();
	$args = array(
	    'post_type'       => 'product_variation',
	    'post_status'     => 'publish',
	    'posts_per_page'  => $posts_per_page,
	    'paged' => $paged,
	    'post_parent__in' => $parent_product, 
	    
	) ;
	if (!empty($sortby)) {
		$args['meta_key'] = '_price';
		$args['orderby'] = 'meta_value_num';
		$args['ignore_custom_sort'] = true;

		if ($sortby == 'bestsellers') {
			$args['meta_key'] = '_is_bestsellers';
			$args['orderby'] = 'meta_value_num';
			$args['order'] = 'DESC';
		} elseif ($sortby == 'price') $args['order'] = 'ASC';
		else $args['order'] = 'DESC';
	} else {
		/*$args['ignore_custom_sort'] = true;
		$args['meta_key'] = '_is_order';
		$args['orderby'] = 'meta_value_num';
		$args['order'] = 'ASC';*/
		/*$args['ignore_custom_sort'] = true;
		$args['meta_key'] = 'attribute_pa_ring-size';
		$args['orderby'] = 'meta_value_num';	
		$args['order'] = 'ASC';*/
	}
	$args['meta_query'] = array(
		'relation' => 'AND'
	);
	$args['meta_query'][] = array(
            'key'     => '_price',
        'value'   => '',
        //'type'    => 'meta_value_num',
        'compare' => '!='
        );

	
if (!empty($str_filter)) {	
	$filters = explode("&",$str_filter);
	foreach ($filters as $key => $filter) {
		$filter_item = explode("=",$filter);
		$args['meta_query'][] = array(
            'key'     => 'attribute_'.$filter_item[0],
            'value'   => $filter_item[1],
        );
	}
}

$query = new WP_Query( $args);
//var_dump($query->query);
return $query;
}
// end function list_product()

function get_meta_centerstone_item_cart ($product_id){
	$meta_keys = array(
		'attribute_carats' => 'Carat',
		'attribute_color' => 'Color',
		'attribute_clarity' => 'Clarity',
		'attribute_cut' => 'Cut',

	);
	$str_meta = array();
	foreach ($meta_keys as $key => $value) {
		$meta_value = get_field($key,$product_id);	
		$item_meta = array('label' => $value,'value'=>'');	
		if (is_object($meta_value)) {
		$item_meta['value'] = $meta_value->name;
		} elseif (is_array($meta_value)) {
			foreach ($meta_value as $key => $value) {
				if (is_object($value)) {
					$item_meta['value'] = $value->name;
				} else {
					$item_meta['value'] = $value;
				}
			}
		}else { $item_meta['value'] = $meta_value; }
		$str_meta[] = $item_meta;
	}
return $str_meta;
}


function get_meta_centerstone ($product_id){
	$meta_keys = array('attribute_carats','attribute_color','attribute_clarity');
	$str_meta = array();
	foreach ($meta_keys as $key => $value) {
		$meta_value = get_field($value,$product_id);		
		if (is_object($meta_value)) {
		$str_meta[] = $meta_value->name;
		} elseif (is_array($meta_value)) {
			foreach ($meta_value as $key => $value) {
				if (is_object($value)) {
					$str_meta[] = $value->name;
				} else {
					$str_meta[] = $value;
				}
			}
		}else { $str_meta[] = $meta_value; }
	}
return implode(", ",$str_meta);
}

function custom_img_variation($attributes,$product,$slug,$attribute_name,$selected) {		
		$term = get_term_by('slug', $slug, $attribute_name);
		if ($term):				
		$name = $term->name;
		$term_id = $term->term_id;
		$active = $selected == $slug ? 'active' : '';
		// only casing
		if ($attribute_name == 'pa_casing'):
			$selected_metal = '';
			foreach ( $attributes as $attribute_name2 => $options2 ) {				
				if ($attribute_name2 == 'pa_metal-type') {	
					$selected_metal = $product->get_variation_default_attribute( $attribute_name2 );
					$variation_selected = get_selected_variation();
					if (array_key_exists($attribute_name,$variation_selected)) {					
					 $selected_metal =  wc_clean( urldecode( $variation_selected[$attribute_name2] ) ) ;
					}					
					if (empty($selected_metal)) {					
					$selected_metal = array_shift(array_values($options2));
				}
				}
			}
			$metal_id = '';
			if (!empty($selected_metal)) {
				$term_metal = get_term_by('slug', $selected_metal, 'pa_metal-type');
				$metal_id = $term_metal->term_id;
			}
			if( have_rows('shapes','term_'.$term_id) ):

				$name = '';

				while( have_rows('shapes','term_'.$term_id) ) : the_row();	

					$metal = get_sub_field('select_type_metarial');
					$show = $metal_id == $metal ?'show':'';
					$img_casing = get_sub_field('icon_shape');
					$name .= '<img class="img_att img_'.$attribute_name.' term_'.$metal.' '.$show.' " src="'.$img_casing.'"/>';
				endwhile;
			endif;	

		?>
			
		<?php else:
			$icon_shape = get_field('icon_shate','term_'.$term_id) ?? '';
		if (!empty($icon_shape)) {
			$name = '<img src="'.$icon_shape.'"/>';
		}			
		
		endif;	

		?>
		<div data-att="<?php echo $attribute_name; ?>" data-slug = "<?php echo $slug; ?>" data-nameAtt="<?php echo $term->name; ?>" data-id = "<?php echo $term_id; ?>" class=" <?php echo $active; ?> item-att <?php echo $slug; ?> <?php echo 'item_'.$attribute_name; ?>" id="term_<?php echo $term->term_id; ?>" ><?php echo $name; ?></div>	
		<?php	
	 endif; 
}

function diamond_custom_variable($attributes,$product,$attribute_name,$class_child,$name_default,$selected,$options) {
	ob_start();
	if ($attribute_name !== 'pa_diamond-type'):
		$slug_attributes = slug_attribute();
		$param = '';
		if (array_key_exists($attribute_name,$slug_attributes)) {						
		$param =   $slug_attributes[$attribute_name] ;
		}	
		?>
		<div class="wrapper-item-attr diamond_<?php echo $attribute_name; ?>" data-params = "<?php echo $param; ?>">
			<div class="tax-attribute-item">
				<div class="taxonomy-name"><strong><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?>:</strong></div>
				<?php //var_dump($name_default); ?>

				<div class="attribute-item-name"><?php echo $name_default; ?></div>
				<?php if (!empty($class_child) && $attribute_name != 'pa_ring-size'&& $attribute_name != 'pa_shapes'): ?>
				<div class="extral-attr modyfy-select">Modify</div>
			<?php endif; ?>
			<?php if ($attribute_name == 'pa_ring-size'): ?>
				<div class="extral-attr size-guide"><span> Size Guide </span></div>

				<div class="filter_popup_wrap guide-side-diamond" id="guide-side-diamond">
				
				<div class="filter_popup_inner">
					<div class="modal__close"><img src="https://oanglelab.com/oa147-lvcmy/ebase-theme/assets/images/icon-close.svg"></div>
					<div class="filter_item_popup">
						<?php echo do_shortcode( '[elementor-template id="2349"]' ); ?>
					</div>
				</div>
			</div>	
			<?php endif; ?>
			</div> 
			<div class="list-att <?php if ($attribute_name != 'pa_ring-size') echo $class_child; ?> ">
				<?php 			
				$total = sizeof($options);
				$size = 0;
				$extral_size = array();
				if ($attribute_name == 'pa_ring-size' && $total > 8) {
					$size = $total - 8;				
					$s = 0;
					foreach ($options as $key => $value) {
						$s++;
						if ($s > 8) {
							$extral_size[] = $options[$key];
							unset($options[$key]);
						}
					}					
				}			
				
				if ($attribute_name == 'pa_ring-size') {
					echo '<div class="list_'.$attribute_name.'">';
				}			

				foreach ($options as $key => $slug) { 
					custom_img_variation($attributes,$product,$slug,$attribute_name,$selected);
				} ?>
				<?php
				if ($attribute_name == 'pa_ring-size') {
					echo '</div>';
				} ?>
				<?php if ($attribute_name == 'pa_ring-size'): ?>
					<p>For ring sizes not listed, please enquire from Love & Co. for more details.</p>
				<?php endif; ?>

				<!-- add show more size -->

				<!-- add show more size -->
				<?php
				if (count($extral_size) > 0) {
					echo '<div class="more-size"><span>Show more sizes</span></div>';
					echo '<div class="wrapper-more-size ">';	
					echo '<div class="list_'.$attribute_name.'">';			
					foreach ($extral_size as $key => $slug) { ?>
					<?php
					//$k++;
					$term = get_term_by('slug', $slug, $attribute_name);
					$slug = $term->slug;
					$name = $term->name;
					$term_id = $term->term_id;
					$active = $selected == $slug ? 'active' : '';
					$icon_shape = get_field('icon_shate','term_'.$term_id) ?? '';
					if (!empty($icon_shape)) {
						$name = '<img src="'.$icon_shape.'"/>';
					}				
					?>
					<div data-slug = "<?php echo $slug; ?>" data-nameAtt="<?php echo $term->name; ?>" data-id = "<?php echo $term_id; ?>" class=" <?php echo $active; ?> item-att" id="term_<?php echo $term->term_id; ?>" ><?php echo $name; ?></div>				
				<?php } 
				echo '</div>';
				echo '</div>';
				}
				?>
			</div>
		</div><!-- end wrapper-item-attr -->
		<?php
	endif;
	$diamond_custom_variable = ob_get_contents();
	ob_clean();
	ob_end_flush();
	return $diamond_custom_variable;
}

function oa_dianmon_css() {
	if(is_tax('product_cat','create-engagement-rings') || is_product() || is_page('select-diamond') || is_tax('designer_collections')){
		wp_enqueue_style('dianmond-css', get_template_directory_uri() . '/func-custom/dianmond/diamond.css',strtotime('now'),true);		
	}	
	if(is_page('select-diamond')){	
		wp_enqueue_style('dianmond-ui-css', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
	}	
}

function oa_dianmon_js() {	
	if (is_page('select-diamond')) {
		wp_enqueue_script( 'jquery-ui-slider', false, array('jquery'));		
		wp_enqueue_script( 'dianmond-js-isotope','https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js', array(), date('ymdhsi'), true );		
		wp_enqueue_script( 'dianmond-js-lottie','https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.5.3/lottie.js', array(), date('ymdhsi'), true );		
		wp_enqueue_script( 'dianmond-js-mode.pkgd', get_template_directory_uri() . '/assets/js/packery-mode.pkgd.min.js', array(), date('ymdhsi'), true );	
	}
	if(is_tax('product_cat','create-engagement-rings')|| is_product() || is_page('select-diamond') || is_tax('designer_collections') ){
		wp_enqueue_script( 'dianmond-js', get_template_directory_uri() . '/func-custom/dianmond/dianmond-js.js', array(), date('ymdhsi'), true );
		wp_localize_script( 'dianmond-js', 'dianmond_params',
			array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'home_url' => get_home_url(),
			'nonce' => wp_create_nonce('ajax-nonce')
			) );
	}
}

function admin_order_list_top_bar_button( $which ) {
    global $typenow;
    $engagement_rings = isset($_GET['product_cat']) ? $_GET['product_cat'] : '';

    if ( 'product' === $typenow && 'top' === $which && $engagement_rings == 'create-engagement-rings') {
    	
        ?>
        <div class="alignleft actions custom">
            <button id="update_engagement_rings" type="submit" name="update_engagement_rings" style="height:32px;" class="button" value=""><?php
                echo __( 'Update Engagement Rings', 'woocommerce' ); ?></button>
        </div>

        <div class="processing dffafa">
        	<div class="loading-wait"><span class="spinner"></span></div>
        	<?php for ($i = 1; $i <= 15; $i++) { ?>
        	<div data-order="<?php echo $i; ?>" class="process-item process-item-<?php echo $i; ?>">
        		<?php } ?>
        </div>
        </div>

        <?php
    }
}





function diamond_scripts_update_product() {	
	?>
		<script type='text/javascript'>
	 	 jQuery(document).ready( function(){ 	 	 	
	 	 var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	 	if (jQuery("#update_engagement_rings").length) { 	
	 		var order = 0;	
	 		var update = 1;	
	 		jQuery('#update_engagement_rings').click(function(e){ 	 		
	 			e.preventDefault();	
				jQuery(".processing").addClass("active");
	 			jQuery(".edit-tag-actions").addClass("disable");
					jQuery.ajax({
				    url: ajaxurl,
				    data : {
				        action: "update_engagement_rings",	        
				        page : order,	
				       	        
				    }
				})
				.done(function (response) {  
					//jQuery('.update_product_gst').trigger("click");
					if (response == '') {						
						order += 1;
						var process_item = '.process-item-'+order;
						jQuery(process_item).addClass('active');
						jQuery('#update_engagement_rings').trigger("click");
					} else {
						jQuery(".process-item").removeClass('active');
						jQuery(".processing").removeClass("active");
						jQuery(".edit-tag-actions").removeClass("disable");
					}
				});				
			});	
	 	}
	 	});
 	 	
	 </script>
	<?php 
}


function handle_custom_query_var( $query, $query_vars ) {
    if ( isset( $query_vars['like_name'] ) && ! empty( $query_vars['like_name'] ) ) {
        $query['s'] = esc_attr( $query_vars['like_name'] );
    }

    return $query;
}

function update_engagement_rings() {
		
	$page  = $_REQUEST['page'] ?? '';
	global $post;

	$args = array(
		'paginate' 	=> true,
		'limit' 	=> 1,
		'status' 	=> array('publish'),
		'category' 	=> array('create-engagement-rings'),
		'visibility' => 'visible',  
		'paged' 	=> $page,  
	);
	$products2 = wc_get_products( $args );
	$products = $products2->products;		
	if (count($products) > 0):
		foreach ($products as $key => $product2) {
			$product_id = $product2->get_id();
			$tittle = $product2->get_title();
			$similar_product_selection = get_field('similar_product_selection',$product_id) ??'';
			if (empty($similar_product_selection)):
				$arr_posts = array();			
				$args_kid = array(
					'limit' => -1,
					'status' => array('publish'),
					'exclude' => array($product_id),
					'like_name' => $tittle,
					'category' => array('create-engagement-rings'),
				);
				$products_kids = wc_get_products( $args_kid );
				if (count($products_kids) > 0):
					foreach ($products_kids as $key => $kid) {
						$kid_id = $kid->get_id();
						$tittle_kid = $kid->get_title();
						$arr_posts[] = $kid_id;
					}
				endif;	
				if (count($arr_posts) > 0) {		
					update_post_meta($product_id, 'similar_product_selection', $arr_posts );
				}

			endif;
		}
	else :
		echo 'abc';
		endif;	
	wp_reset_postdata();
	wp_die();
}

function custom_price_format( $price, $product ) {
	$product_id = $product->get_id();
	$parent_id = $product->get_parent_id() ;
	if (empty($parent_id)) $parent_id = $product_id;
	if (is_product_dianmond($parent_id)):
		if(get_field('is_parents',$parent_id) == 1) {
			$price= 'Starting at '.wc_price($product->get_price());
		}	
		
	endif;
	return $price;
}
/* disable add to cart in enganering product */

function filter_is_purchasable($is_purchasable, $product ) {
if (is_product_dianmond($product->get_id()) && get_field('is_parents',$product->get_id()) == 1):
	return false;
endif;

return $is_purchasable;
}

/* remove quantity in product diamond */

function custom_remove_all_quantity_fields( $return, $product ) {
	if (is_product_dianmond($product->get_id()) && get_field('is_parents',$product->get_id()) != 1):
	return false;
endif;
	return true;
}


/* check before add to cart */
function add_the_date_validation( $passed ) { 
	if ( !empty( $_REQUEST['engraving_message'] )) {
		$text = $_REQUEST['engraving_message'];
		$lang = $_REQUEST['lag_active'];	
		$passed = check_language($text,$lang);   
	}
	return $passed;
}

/* end check before add to cart */

function check_language($text,$lang) {	
	$passed = true;
	if ($lang == 'cn') {
		if(!preg_match("/\p{Han}+/u", $text)){
		 wc_add_notice( __( 'You must enter Chinese.', 'woocommerce' ), 'error' );
		   $passed = false;
		} 		
	}
	if ($lang == 'eng') {		
		if (!preg_match("/^[_a-zA-Z ]+$/", $text)){
		    wc_add_notice( __( 'You must enter English.', 'woocommerce' ), 'error' );
		    $passed = false;
		}
	}
	return $passed;

}

function find_matching_product_variation_id($product_id, $attributes)
{
    return (new \WC_Product_Data_Store_CPT())->find_matching_product_variation(
        new \WC_Product($product_id),
        $attributes
    );
}

function attribute_diamond_child_default($product_id) {
	$attributes = array();
	$atts = slug_attribute();
	foreach ($atts as $key => $att) {
		$value = $_GET[$att]??'';
		if (empty($value)) {
			$value = get_tribute_product($product_id,$key);
		}		
			$key_att = 'attribute_'.$key;
			$attributes[$key_att] = $value;
		
	}
	return $attributes;
}

function custom_nav($the_query,$a,$current_page) {
  $current_page = $current_page ? $current_page : max( 1, get_query_var('paged') );
  $big = 999999999;
  $base2 = home_url( '/category/create-engagement-rings/page/999999999' );
  $base = str_replace( $big, '%#%', esc_url( $base2 ) );
 
  $rs_paginate_links = paginate_links( array(
    'base' 		=> $base,
    'format' 	=> '?paged=%#%',
    'current' 	=> $current_page,
    'total' 	=> $the_query->max_num_pages,
    'prev_text'    => __('<span class="skinny__arrow flip_vertical">
								<span class="skinny__arrow-top"></span>
								<span class="skinny__arrow-bottom"></span>
							</span> Previous Page','yup'),
    'next_text'    => __('Next Page <span class="skinny__arrow">
								<span class="skinny__arrow-top"></span>
								<span class="skinny__arrow-bottom"></span>
							</span>','yup')
    ) );
   if($rs_paginate_links) :
 ?>
    <div class="e-pagination clearfix">
    <?php echo $rs_paginate_links ?>
  </div>
<?php endif;
}

function custom_nav_child($the_query,$base2,$current_page) {
  $current_page = $current_page ? $current_page : max( 1, get_query_var('paged') );
  $big = 999999999;
  $base = str_replace( $big, '%#%', esc_url( $base2 ) );
  //var_dump(get_pagenum_link( $big ));
 
  $rs_paginate_links = paginate_links( array(
    'base' 		=> $base,
    'format' 	=> '?paged=%#%',
    'current' 	=> $current_page,
    'total' 	=> $the_query->max_num_pages,
    'prev_text'    => __('<span class="skinny__arrow flip_vertical">
								<span class="skinny__arrow-top"></span>
								<span class="skinny__arrow-bottom"></span>
							</span> Previous Page','yup'),
    'next_text'    => __('Next Page <span class="skinny__arrow">
								<span class="skinny__arrow-top"></span>
								<span class="skinny__arrow-bottom"></span>
							</span>','yup')
    ) );
   if($rs_paginate_links) :
 ?>
    <div class="e-pagination clearfix">
    <?php echo $rs_paginate_links ?>
  </div>
<?php endif;
}

function get_tribute_product($product_id,$att) {
	$term_list = wp_get_post_terms($product_id,$att,array( 'fields' => 'all' ));
		if (!is_wp_error( $term_list ) && count($term_list) > 0) {
			return $term_list[0]->slug;
		} else return '';
}

function shape_round_alpha() {
	return ', Diamond Type: None';
}



function arr_new_title_option($name,$sub_name_arr) {
	$ar = array();

	if( have_rows($name,'option') ):		    // Loop through rows.
		    while( have_rows($name,'option') ) : the_row();
		       $sub_str = '';
		        foreach ($sub_name_arr as $key => $sub) {
		        	$sub_str.=get_sub_field($sub)->slug;
		        }
		        $ar[$sub_str] = get_sub_field('new_title');
		    // End loop.
		    endwhile;
		endif;
		//var_dump($ar);
		return $ar;
}

function get_new_title2($product_id,$variation_id) {
	$title_new = '';
	$term_list = get_term_product_in_diamond($product_id);	
	if (count($term_list) > 0) {
		$type_text = '';
		$material_text = '';
		$casing_text = '';
		$shape = get_post_meta($variation_id,'attribute_pa_shapes',true).get_post_meta($variation_id,'attribute_pa_diamond-type',true);
		$material = get_post_meta($variation_id,'attribute_pa_metal-type',true);
		$casing = get_post_meta($variation_id,'attribute_pa_casing',true);
		
		$arr_type_text = arr_new_title_option('type_text',array('shape','meta_type'));		
		if (array_key_exists($shape,$arr_type_text)) {
			$type_text = $arr_type_text[$shape];
		}

		$arr_material_text = arr_new_title_option('material_title',array('select_material'));
		if (array_key_exists($material,$arr_material_text)) {
			$material_text = $arr_material_text[$material];
		}

		$arr_casing_text = arr_new_title_option('casing_title',array('select_casing'));		
		if (array_key_exists($casing,$arr_casing_text)) {
			$casing_text = $arr_casing_text[$casing];
		}
		
		if (empty($casing_text) || empty($material_text) || empty($type_text)) {
			return '';
		}
		$url = get_permalink( $variation_id );
		return $type_text.' in '.$material_text.' with '.$casing_text;
	}

	return $title_new;
}


function variation_product_html($variation) {
	$parent_id = $variation -> post_parent;
	
	$title = $variation -> post_title;
	$sub = $variation -> post_excerpt;	
	$variation_id = $variation -> ID;	
	$sub =  get_new_title2($parent_id,$variation_id);
	if (empty($sub)) {
		$sub = str_replace(shape_round_alpha(), '', $variation -> post_excerpt);
	}
	$gallery = get_post_meta($variation_id,'rtwpvg_images',true) ?? '';
	$thum_id = get_post_thumbnail_id( $variation_id );
	$meta_att = '';
	$link = get_att_variation($variation_id,$parent_id);
	//var_dump($link);
	?>

	<li class="ast-col-sm-12 ast-article-post product type-product post-27850 status-publish first instock product_cat-new-in sold-individually shipping-taxable product-type-simple add-to-wishlist-before_image">    
		<!-- wishtlist here -->
		<!-- end wishtlist -->
		<div class="astra-shop-thumbnail-wrap product-1-image">
			<a href="<?php echo $link; ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
			<?php 
			//var_dump( get_post_meta($variation_id,'_is_order',true)); 
			
			if ( !empty($thum_id) ) {
				$image = wp_get_attachment_image( $thum_id, 'woocommerce_thumbnail', false, '' );
			} elseif ( $parent_id ) {
				$parent_product = wc_get_product( $parent_id );
				if ( $parent_product ) {
					$image = $parent_product->get_image( 'woocommerce_thumbnail', array(), '' );
				}
			}
				echo $image;							
				if (is_array($gallery) && count($gallery) > 0) {					
					$gallery_id = $gallery[0];
					$img_gallery =  wp_get_attachment_image( $gallery_id, 'woocommerce_thumbnail', false, array('class' => 'first-gallery-img') );
				} else {
					if ( !empty($thum_id) ) {
				$img_gallery = wp_get_attachment_image( $thum_id, 'woocommerce_thumbnail', false, array('class' => 'first-gallery-img' ));				
				} elseif ( $parent_id ) {
					$parent_product = wc_get_product( $parent_id );
					if ( $parent_product ) {						
					
						$img_gallery = get_the_post_thumbnail($parent_id,'woocommerce_thumbnail', array('class' => 'first-gallery-img'));					
					}
				}
				}
				
				echo $img_gallery;
			?>
			</a>
		</div>
		<div class="astra-shop-summary-wrap fgfgfg">
			<a data-url="<?php echo $link; ?>" href="<?php echo $link; ?>" class=" dfff ast-loop-product__link">
			<h2 class="woocommerce-loop-product__title"><?php echo $sub; ?></h2></a>
			<div class="list_viewmoreWrap">
				<a href="<?php echo $link; ?>" class="list_viewmoreBtn">SELECT RING</a>
			</div>
		</div>
	</li>
<?php
}
function url_new_filter_varaiton($str_filter) {
	if (!empty($str_filter)) {
		 $selected_atts = slug_attribute();
		 $a = array();
		$filters = explode("&",$str_filter);
		foreach ($filters as $key => $filter) {
			$filter_item = explode("=",$filter);
			$a[] = $selected_atts[$filter_item[0]].'='.$filter_item[1];			
		}
	}
	return $a;
}

function result_filter_diamin_html($total,$page2) {
	$limit = posts_per_page_variation();
	$start = ($page2 - 1)*$limit +1;
	$end = $page2 * $limit;
	if ($total < $end) $end = $total;
	if ($total == 0) $result = $total.' products found.';
	else $result = 'Showing '.$start.'–'.$end.' of '.$total.' results';
	return $result;
}
add_action( 'wp_ajax_filter_diamond_by_att', 'filter_diamond_by_att' );
add_action('wp_ajax_nopriv_filter_diamond_by_att', 'filter_diamond_by_att');
function filter_diamond_by_att() {
	/*if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'ajax-nonce' ) ) {
         die('Permission denied');
     }*/
	$str_filter = $_REQUEST['str_filter'] ?? '';	
	$url_current = $_REQUEST['url_current'] ?? '';	
	$sortby = $_REQUEST['sortby'] ?? '';	
	$page2 = $_REQUEST['page'] ?? 1;
	$shape_id = $_REQUEST['shape_id'] ?? '';
	/*banner*/
	
	if (!empty($shape_id)) {
		$queried_object = 'term_'.$shape_id;
		if( get_field('lvc_banner',$queried_object) ):			
			$lvc_banner =  lvc_banner($queried_object);
		else: $lvc_banner =  lvc_banner('term_474');
	endif;
	} 	else {
		$lvc_banner =  lvc_banner('term_474');
	}	
	


	$posts_per_page = posts_per_page_variation();
	$parent_product = get_parents_engagement() ;
	$query_variation =products_diamond_variation($str_filter,$sortby,$page2,$posts_per_page,$parent_product);
	$variations = $query_variation->posts;		
	ob_start();
	foreach ($variations as $key => $variation) {
		variation_product_html($variation);  
	}
	$products_variation = ob_get_contents();
	ob_clean();
	ob_end_flush();	

	ob_start();
	custom_nav($query_variation,$url_current,$page2);
	$page_variation = ob_get_contents();
	ob_clean();
	ob_end_flush();	
	$total = $query_variation -> found_posts;
	$result = result_filter_diamin_html($total,$page2);

	// url 
	$url_filter = '';
	$param_page = 'page/'.$page2.'/';
	if (empty($page2) || $page2 == 1) {
		$param_page = '';
	}
	
	$url = !empty($str_filter) ? url_new_filter_varaiton($str_filter) : '';	
	$key_sortby = '';
	if ($sortby == 'bestsellers') {
		$order_by = 'bestsellers';
		$key_sortby = '_bestsellers';

	}elseif ($sortby == 'price'){
		$key_sortby = '_price';
		$order_by = 'low-to-high';
	} 
	elseif ($sortby == 'price-desc') {
		$key_sortby = '_price';
		$order_by = 'high-to-low';
	}
	else $order_by = '';
	$url_sortby = !empty($sortby) ? $key_sortby.'='.$order_by : '';
	
	if (!empty($url)) {
		$url = '?'.implode("&",$url).'&'.$url_sortby;
	} else {
		if (!empty($sortby)) {
			$url = '?'.$url_sortby;
		}
	}	

	$url_filter = $param_page.$url;	
	$url_filter =  str_replace('//','/',$url_filter);
	wp_send_json_success(array('products_variation' => $products_variation,'url'=>$url_filter,'page_variation'=>$page_variation,'result' =>$result,'lvc_banner'=>$lvc_banner));

	wp_die();
}

function limit_child_product() {
	return 6;
}
function arr_attribute_meta_child_product($taxonomy_att){
	$item_term_arr = array();
	$item_term = get_terms( array( 
                    'taxonomy' => $taxonomy_att,
                    'hide_empty' => false
                ) );
    if (!is_wp_error( $item_term )) {
        foreach ($item_term as $key => $item_cut) {
            $item_term_arr[$item_cut->term_id] = $item_cut->name ;
        }
         
    }
    return $item_term_arr;
}


add_action( 'wp_ajax_filter_child_product', 'filter_child_product' );
add_action('wp_ajax_nopriv_filter_child_product', 'filter_child_product');
function filter_child_product() {
	if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'ajax-nonce' ) ) {
         die('Permission denied');
     }
     global $post;
	$collection = $_REQUEST['collection'] ?? '';
	$product_id = $_REQUEST['product_id'] ?? '';	
	$cut = $_REQUEST['cut'] ?? '';	
	$clarity = $_REQUEST['clarity'] ?? '';	
	$min_carats = $_REQUEST['carats-min'] ?? '';	
	$max_carats = $_REQUEST['carats-max'] ?? '';	
	$min_price = $_REQUEST['price-min'] ?? '';	
	$max_price = $_REQUEST['price-max'] ?? '';
	$clarity = $_REQUEST['clarity'] ?? '';	
	$page_current = $_REQUEST['page'] ?? 1	;
	$filters = $_REQUEST['filters'] ?? ''	;
	$post_exclude = $_REQUEST['post_exclude'] ?? ''	;
	$filter_arr = array();
	$_metal_type = '';
	$_casing ='';
	$_dianmond_shapes='';
	$_diamond_type='';

	if (!empty($filters)) {
		$filters = explode('&', $filters);
		foreach ($filters as $key => $filter) {
			if (!empty($filter)) {

				$filter_item = explode('=', $filter);
				$k = $filter_item[0];
				$filter_arr[$k] = $filter_item[1];
				if ($k == 'pa_shapes') $_dianmond_shapes = $filter_item[1];
				if ($k == 'pa_metal-type') $_metal_type = $filter_item[1];
				if ($k == 'pa_casing') $_casing = $filter_item[1];
				if ($k == 'pa_diamond-type') $_diamond_type = $filter_item[1];
			}
		}
	}
	$args = array(
	    'post_type'       => 'product',
	    'post_status'     => 'publish',
	    'posts_per_page'  => limit_child_product(),
	    'paged' 		  => $page_current,   
	    'tax_query'       => array(
        	'relation'        => 'AND',
        )
	    
	) ;
	if (!empty($post_exclude)) {
		$post_exclude = explode(',', $post_exclude);
		$args['post__not_in'] = $post_exclude;
	}
	if (count($filter_arr) > 0) {
		$args['tax_query'][]=return_tax_query_diamond($filter_arr);
	}
	$args['meta_query']['relation'] = 'AND';
	
	if (!empty($collection)) {
		$meta_query_collection = array(
        'relation'=>'OR'
        );
		$collection_value = [];
		foreach ($collection as $key => $value) {
			// $meta_query_collection[] = array(
			// 	'key'     => 'attribute_collection',
			// 	'value'   => $value,
			// );
			$collection_value[$key] = $value;

		}
		$args['meta_query'][] = array(
			'key' => 'attribute_collection',
			'value' => $collection_value,
			'compare' => 'IN'
		);			
	}


	if (!empty($cut)) {
		$meta_query_cut = array(
        'relation'=>'OR'
        );
		foreach ($cut as $key => $value) {
			$meta_query_cut[] = array(
            'key'     => 'attribute_cut',
            'value'   => sprintf('%s', $value),
            'compare' 	=> 'LIKE'
        );
		}
		  $args['meta_query'][]=$meta_query_cut;
			
	}
	if (!empty($clarity)) {
		$meta_query_clarity = array(
        'relation'=>'OR'
        );
		foreach ($clarity as $key => $value) {
			$meta_query_clarity[] = array(
            'key'     => 'attribute_clarity',
             'value'   => sprintf('%s', $value),
            'compare' 	=> 'LIKE'
           // 'value'   => $value,
        );
		}
		  $args['meta_query'][]=$meta_query_clarity;			
	}

	if (!empty($min_carats) && !empty($max_carats)) {
		$range_carat = array(floatval($min_carats),floatval($max_carats));
			$meta_query_carats  = array(
                'key' 		=> 'attribute_carats',
                'type' => 'DECIMAL(10,3)',
                'value' 	=> $range_carat,
                'compare' 	=> 'BETWEEN' 
            );	
		
		  $args['meta_query'][]=$meta_query_carats;			
	}
	if (!empty($min_price) && !empty($max_price)) {
		$min_price = str_replace(",","",ltrim($min_price,'$'));
		$max_price = str_replace(",","",ltrim($max_price,'$'));
		$range_price = array($min_price,$max_price);		
			$range_price  = array(
                'key' 		=> 'price_field',
                'type'    	=> 'NUMERIC',
                'value' 	=> $range_price,
                'compare' 	=> 'BETWEEN' 
            );	
		
		  $args['meta_query'][]=$range_price;			
	}

	$query = new WP_Query( $args);		
	ob_start();
	if($query->have_posts()) :
	while($query->have_posts()) : $query->the_post();
		$product_id = $post->ID;        
    $items = get_meta_product_child($product_id,$_metal_type,$_casing,$_dianmond_shapes,$_diamond_type);     
    $GLOBALS['items'] = $items ;  
    get_template_part( 'func-custom/dianmond/shortcode/content','child-product' ); 
	endwhile;			
else:
	echo '<h3>No product found!</h3><br/><br/>';
		endif;
		$products_child = ob_get_contents();
	ob_clean();
	ob_end_flush();	
	ob_start();	 
         $base2 = home_url( '/select-diamond/page/999999999' );
        custom_nav_child($query,$base2,$page_current);
        
	$page_child = ob_get_contents();
	ob_clean();
	ob_end_flush();
	wp_send_json_success(array('products_child' => $products_child,'page_child'=>$page_child, 'ahihi' => $query->request));
	wp_die();
}

function check_product_in_diamond($product_id) {
	$term_list = get_term_product_in_diamond($product_id);
		if (!is_wp_error( $term_list ) && count($term_list) > 0) return true;
		else return false;
}

add_filter( 'woocommerce_product_title', 'add_custom_name',10,2 );
function add_custom_name( $title ,$product) {
    //return get_new_title($product);
    $product_id = $product -> get_id();
    $_dianmond_shapes = $_GET['_dianmond_shapes'] ?? '';
	$_metal_type = $_GET['_metal_type'] ?? '';
	$_casing = $_GET['_casing'] ?? '';
	$_diamond_type = $_GET['_diamond_type'] ?? '';
	/*if (isset($_GET['attribute_pa_shapes']) && isset($_GET['attribute_pa_diamond-type']) && isset($_GET['attribute_pa_casing']) && isset($_GET['attribute_pa_metal-type'])  && isset($_GET['attribute_pa_ring-size']) ) {

		$_dianmond_shapes = $_GET['attribute_pa_shapes'];
	$_metal_type = $_GET['attribute_pa_metal-type'];
	$_casing = $_GET['attribute_pa_casing'];
	$_diamond_type = $_GET['attribute_pa_metal-type'];

	}*/
	//attribute_pa_shapes=round&attribute_pa_diamond-type=4-prong-nsew&attribute_pa_casing=double-pave&attribute_pa_metal-type=yellow-gold&attribute_pa_ring-size=8

    $variation_id = get_id_variation_valid($product_id,$_metal_type,$_casing,$_dianmond_shapes ,$_diamond_type);
    $new_title = get_new_title2($product_id,$variation_id);
    if (!empty($new_title)) return $new_title;
    return $title;
}

function param_url_diamond($product_id,$variation_id,$new_title) {
	//?_dianmond_shapes=round&_metal_type=yellow-gold&_casing=tapered-plain&_diamond_type=4-prong-square&p_id=486344
	$shape = get_post_meta($variation_id,'attribute_pa_shapes',true);
	$metal_type = get_post_meta($variation_id,'attribute_pa_metal-type',true);
	$casing = get_post_meta($variation_id,'attribute_pa_casing',true);
	$diamond_type = get_post_meta($variation_id,'attribute_pa_diamond-type',true);
	$url = get_permalink( $product_id ).'?_dianmond_shapes='.$shape.'&_metal_type='.$metal_type.'&_casing='.$casing.'&_diamond_type='.$metal_type.'&p_id='.$product_id;
	return '<a href="'.$url.'">'.$new_title.'</a>';
}

add_filter('woocommerce_order_item_get_name', 'a_woocommerce_order_item_name_get', 10, 2 );
function a_woocommerce_order_item_name_get($title,$item) {
	$sub_title = '';
	$meta_value = $item->get_meta( 'sub_title_reng', true )??'';
	if (!empty($meta_value)) {
		$sub_title =  $meta_value;
	}
	$product      = $item->get_product();
	
	if ($product) {
	 if( $product->is_type('variation') ){
		$variation_id = $item->get_product()->get_id();
		$product_id = $item->get_product()->get_parent_id();
		if (check_product_in_diamond($product_id) ) {
			if (!empty($sub_title)) {
				return $sub_title;
			} else {
				$new_title = get_new_title2($product_id,$variation_id);			
	    		if (!empty($new_title)) {
	    			return $new_title;
	    		}
	    	}
		}
	}
} else {
	if (!empty($sub_title)) {
		return $sub_title;
	}
}
	

	
	return $title;
}

add_filter( 'woocommerce_order_item_name', 'a_woocommerce_order_item_name', 10, 2 );
function a_woocommerce_order_item_name($title,$item) {		
	$product      = $item->get_product();
	 if( $product->is_type('variation') ){
		$variation_id = $item->get_product()->get_id();
		$product_id = $item->get_product()->get_parent_id();
		if (check_product_in_diamond($product_id)) {
			 return param_url_diamond($product_id,$variation_id,$title); 
		}
	}	
	return $title;
}

add_filter( 'woocommerce_cart_item_name', 'a_woocommerce_cart_item_name', 10, 2 );
function a_woocommerce_cart_item_name( $title, $cart_item ){

	if ($cart_item['data']->is_type( 'variation' )) {
		$product_id = $cart_item['product_id'];
		$variation_id = $cart_item['variation_id'];
		if (check_product_in_diamond($product_id)) {
			$new_title = get_new_title2($product_id,$variation_id);
    		if (!empty($new_title)) return param_url_diamond($product_id,$variation_id,$new_title);
		}
		

	}
    return $title;
}

add_filter('woocommerce_display_item_meta','engagement_rings_display_item_meta',10,3);
function engagement_rings_display_item_meta($html, $item, $args) {
	if ($item->get_product()->is_type( 'variation' )) {
		//$variation_id = $item['variation_id'];
		$variation_id = $item->get_product()->get_id();
		$product_id = $item->get_product()->get_parent_id();
		if (check_product_in_diamond($product_id)) {
			 $strings = array();
			 $metas = $item->get_formatted_meta_data();
			    foreach ( $metas as $meta_id => $meta ) { 			    	
			    	if ($meta->key == 'pa_shapes' || $meta->key == 'pa_diamond-type' || $meta->key == 'pa_casing' || $meta->key == 'pa_metal-type' || $meta->key == 'sub_title_reng') {
			    		unset($metas[$meta_id]);
			    	}
			    } 

			    foreach ( $metas as $meta_id => $meta ) { 
			        $value = $args['autop'] ? wp_kses_post( $meta->display_value ) : wp_kses_post( make_clickable( trim( strip_tags( $meta->display_value ) ) ) ); 
			        $strings[] = '<strong class="wc-item-meta-label">' . wp_kses_post( $meta->display_key ) . ':</strong> ' . $value; 
			    } 
			        if ( $strings ) { 
			        	$centerstone_html = '';

 				$meta_products = get_meta_centerstone_item_cart ($product_id); 
				if (count($meta_products) > 0) : 				
				$centerstone_html .= '<div  class="engagement-rings-infor">';
					$centerstone_html .= '<table><tr>';
						
						foreach ($meta_products as $key => $meta) {
							$lable = $meta['label'];
							$value = $meta['value'];
							if (!empty($value)):
							$centerstone_html .=  '<td style="padding-right: 15px;"><strong>'.$lable.'<br/></strong>'.$value.'</td>';
							endif;
						}
						
						
					$centerstone_html .= '</tr></table>';
				$centerstone_html .= '</div>';
			endif; 




        return $args['before'] . implode( $args['separator'], $strings ) . $args['after'].$centerstone_html; 
    } 
		}
	}
	return $html;
}

function html_meta_centerstone_item_cart($product_id,$type) {
	ob_start();
	if (check_product_in_diamond($product_id)) { ?>
		<?php $meta_products = get_meta_centerstone_item_cart ($product_id); 
		if (count($meta_products) > 0) : ?>
			<?php if ($type == 1): ?>
		<tr class="show_pc">
		<td colspan="6" class="engagement-rings-infor">
		<?php endif; ?>
			<ul class="list_centerstone">
				<?php
				foreach ($meta_products as $key => $meta) {
					$lable = $meta['label'];
					$value = $meta['value'];
					if (!empty($value)):
					echo '<li><strong>'.$lable.'</strong>'.$value.'</li>';
					endif;
				}
				?>
				
			</ul>
			<?php if ($type == 1): ?>
		</td>
	</tr>
<?php endif; ?>
	<?php endif; ?>
		<?php
	}
	$html_meta_centerstone = ob_get_contents();
	ob_clean();
	ob_end_flush();
	return $html_meta_centerstone;
			

}
add_action( 'wp_ajax_replace_title_product_diamond', 'replace_title_product_diamond' );
add_action('wp_ajax_nopriv_replace_title_product_diamond', 'replace_title_product_diamond');
function replace_title_product_diamond() {

	/*if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'ajax-nonce' ) ) {
         die('Permission denied');
     }*/
    $new_title = '';
	$product_id = $_REQUEST['product_id'] ?? '';
	$variation_id = $_REQUEST['variation_id'] ?? '';
	if (check_product_in_diamond($product_id)) {
		$new_title = get_new_title2($product_id,$variation_id);
		//var_dump($new_title);

    		if (empty($new_title))  $new_title = get_the_title($product_id);
		}
		wp_send_json_success(array('new_title' => $new_title));
	wp_die();
}

function your_add_to_cart_message() {
if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) :
    $message = sprintf( '%s<a href="%s" class="your-style">%s</a>', __( 'Successfully added to cart.', 'woocommerce' ), esc_url( get_permalink( woocommerce_get_page_id( 'shop' ) ) ), __( 'Continue Shopping', 'woocommerce' ) );
else :
    $message = sprintf( '%s<a href="%s" class="your-class">%s</a>', __( 'Successfully added to cart.' , 'woocommerce' ), esc_url( get_permalink( woocommerce_get_page_id( 'cart' ) ) ), __( 'View Cart', 'woocommerce' ) );
endif;
return $message;
}
add_filter( 'wc_add_to_cart_message', 'your_add_to_cart_message' );


function check_diamond_in_cart() {
	global $woocommerce;
	$check = false;
	$cart1 = WC()->cart->get_cart();
    foreach ($cart1 as $key1 => $cart1_item) {
    	$product_id = $cart1_item['product_id']; 
    	if (check_product_in_diamond($product_id)) {
    		$check =  true;
    	}    	
    }
	return $check;
}

function check_diamond_in_order($order) {
	$items = $order->get_items();
	$check = false;
	if (count($items) > 0) {		
		foreach ($items as $key => $item) {
		$product_id = $item->get_product()->get_parent_id();
		if (check_product_in_diamond($product_id)) {
    		return true;
    	}
	}
	}
	return $check;
	
}
/*add_filter( 'woocommerce_package_rates', 'change_title_shipping_method_when_cart_has_dimond', 50, 2 );
function change_title_shipping_method_when_cart_has_dimond( $rates, $package ){

    //if ( is_admin() && ! defined( 'DOING_AJAX' ) )
       // return;
   //if (check_diamond_in_cart($package['contents'])) {
    	$rate_label = __('Flat rate shipping fee');
   	foreach ( $rates as $rate_key => $rate ) {
        // Targetting specific rate Id
        if( $targeted_rate_id === $rate_key ) {
            
            if ( isset($rate_label) ) {
                $rates[$rate_key]->label = $rate_label;
            }
        }
    }
    return $rates;
}*/

function date_shipping_diamond() {
	$current_time = new DateTime('now', new DateTimeZone('Asia/Singapore'));
		$current_time = $current_time->format('Y-m-d');
		return date('M d, Y', strtotime("+56 days", strtotime($current_time)));
}

add_filter( 'woocommerce_cart_shipping_method_full_label','change_title_shipping_method_when_cart_has_dimond' ,15,2);
function change_title_shipping_method_when_cart_has_dimond($label, $method) {
	if (check_diamond_in_cart()) {		
		if ($method->get_method_id() == 'free_shipping') {
			return new_title_shipping(date_shipping_diamond());
		}		
	}
	
	return $label;
}
add_filter( 'woocommerce_order_item_display_meta_value', 'filter_order_item_display_meta_value', 10, 3 );
function filter_order_item_display_meta_value( $meta_value, $meta_object, $order_item ) { 


    if ( is_admin() && $order_item->is_type('shipping') ) {

        $order = $order_item->get_order();
        if (check_diamond_in_order($order)):
        	  $meta_values = [];
	        $order_items = $order->get_items();
	        foreach( $order_items as $order_item ){
	            $quantity   = $order_item->get_quantity();
	            $product    = $order_item->get_product();	           
	            $name       = $product->get_name();
	            $variation_id = $order_item->get_product()->get_id();
				$product_id = $order_item->get_product()->get_parent_id();
	            $new_title = get_new_title2($product_id,$variation_id);				

	    		if (!empty($new_title)) 
	    			$meta_values[] = $new_title.' x1';
	    		 else $name = $new_title.' x1';

	        }
	    endif;

        return implode( ', ', $meta_values );

    }

    return $meta_value;
}




add_filter( 'woocommerce_order_item_get_formatted_meta_data', 'unset_specific_order_item_meta_data', 10, 2);
function unset_specific_order_item_meta_data($formatted_meta, $item){
	if (is_admin() && $item->is_type('line_item')) {
		//var_dump($item->get_type());
		$product_id = $item->get_product()->get_parent_id();
		if (check_product_in_diamond($product_id)) {			
    		foreach( $formatted_meta as $key => $meta ){
    			//var_dump($meta);
		        if( $meta->key == 'pa_shapes' || $meta->key == 'pa_diamond-type' || $meta->key == 'pa_casing' || $meta->key == 'pa_metal-type' || $meta->key == 'sub_title_reng'  || $meta->key == 'centerstone_key' ) 
		            unset($formatted_meta[$key]);
		    }
		    $obj = (object) [
			    'key' => 'centerstone_key',
			    'value' =>html_meta_centerstone_item_cart($product_id,0),
			     'display_key' => 'Centerstone',
			    'display_value' =>html_meta_centerstone_item_cart($product_id,0),
			  ];
		   
			$formatted_meta['centerstone'] = $obj;
    	}
	}
    
    return $formatted_meta;
}

add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

function my_custom_checkout_field_update_order_meta( $order_id ) {
	$order = new WC_Order($order_id);
	$order_date = $order->order_date;
	$total_day_ship = "+56 days";
	$date_shipp = date('M d, Y', strtotime($total_day_ship, strtotime($order_date)));
	update_post_meta( $order_id, 'date_ship_diamon', new_title_shipping($date_shipp) );
	}

	//var_dump(get_post_meta(842714,'date_ship_diamon',true));


function new_title_shipping($date_str) {
	return 'Free Delivery ('.$date_str.')';
}


add_action( 'woocommerce_add_order_item_meta', 'misha_order_item_meta', 10, 2 );

// $item_id – order item ID
// $cart_item[ 'product_id' ] – associated product ID (obviously)
function misha_order_item_meta( $item_id, $cart_item ) {
	if ($cart_item['data']->is_type( 'variation' )) {
		$product_id = $cart_item['product_id'];
		$variation_id = $cart_item['variation_id'];
		if (check_product_in_diamond($product_id)) {
			$new_title = get_new_title2($product_id,$variation_id);
    		if (!empty($new_title)) {
    			wc_update_order_item_meta( $item_id, 'sub_title_reng', $new_title );
    		}
		}
		

	}


	
	
}

