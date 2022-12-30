<?php
/**
 * Astra functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Define Constants
 */
define( 'ASTRA_THEME_VERSION', '2.1.4' );
define( 'ASTRA_THEME_SETTINGS', 'astra-settings' );
define( 'ASTRA_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'ASTRA_THEME_URI', trailingslashit( esc_url( get_template_directory_uri() ) ) );


/**
 * Minimum Version requirement of the Astra Pro addon.
 * This constant will be used to display the notice asking user to update the Astra addon to latest version.
 */
define( 'ASTRA_EXT_MIN_VER', '2.0.0' );

require_once ASTRA_THEME_DIR . 'func-custom/alt-functions.php';
require_once ASTRA_THEME_DIR . 'func-custom/alt-swatches.php';
require_once ASTRA_THEME_DIR . 'shortcode/elementor.php';
require_once ASTRA_THEME_DIR . 'func-custom/alt-product-bulk-price.php';
require_once ASTRA_THEME_DIR . 'func-custom/alt-gird-layout.php';
require_once ASTRA_THEME_DIR . 'func-custom/alt-gift-box.php';


/**
 * Setup helper functions of Astra.
 */
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-theme-options.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-theme-strings.php';
require_once ASTRA_THEME_DIR . 'inc/core/common-functions.php';
require_once ASTRA_THEME_DIR . 'inc/custom-function.php';


/**
 * Update theme
 */
require_once ASTRA_THEME_DIR . 'inc/theme-update/class-astra-theme-update.php';
require_once ASTRA_THEME_DIR . 'inc/theme-update/astra-update-functions.php';
require_once ASTRA_THEME_DIR . 'inc/theme-update/class-astra-theme-background-updater.php';
require_once ASTRA_THEME_DIR . 'inc/theme-update/class-astra-pb-compatibility.php';


/**
 * Custom Function
 */

require_once ASTRA_THEME_DIR . 'func-custom/adminimizeee.php';
// require_once ASTRA_THEME_DIR . 'func-custom/admin-login/oangle-custom-dashboard.php';

/**
 * Fonts Files
 */
require_once ASTRA_THEME_DIR . 'inc/customizer/class-astra-font-families.php';
if ( is_admin() ) {
	require_once ASTRA_THEME_DIR . 'inc/customizer/class-astra-fonts-data.php';
}

require_once ASTRA_THEME_DIR . 'inc/customizer/class-astra-fonts.php';

require_once ASTRA_THEME_DIR . 'inc/core/class-astra-walker-page.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-enqueue-scripts.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-gutenberg-editor-css.php';
require_once ASTRA_THEME_DIR . 'inc/class-astra-dynamic-css.php';

/**
 * Custom template tags for this theme.
 */
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-attr.php';
require_once ASTRA_THEME_DIR . 'inc/template-tags.php';

require_once ASTRA_THEME_DIR . 'inc/widgets.php';
require_once ASTRA_THEME_DIR . 'inc/core/theme-hooks.php';
require_once ASTRA_THEME_DIR . 'inc/admin-functions.php';
require_once ASTRA_THEME_DIR . 'inc/core/sidebar-manager.php';

/**
 * Markup Functions
 */
require_once ASTRA_THEME_DIR . 'inc/extras.php';
require_once ASTRA_THEME_DIR . 'inc/blog/blog-config.php';
require_once ASTRA_THEME_DIR . 'inc/blog/blog.php';
require_once ASTRA_THEME_DIR . 'inc/blog/single-blog.php';
/**
 * Markup Files
 */
require_once ASTRA_THEME_DIR . 'inc/template-parts.php';
require_once ASTRA_THEME_DIR . 'inc/class-astra-loop.php';
require_once ASTRA_THEME_DIR . 'inc/class-astra-mobile-header.php';

/**
 * Functions and definitions.
 */
require_once ASTRA_THEME_DIR . 'inc/class-astra-after-setup-theme.php';

// Required files.
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-admin-helper.php';

require_once ASTRA_THEME_DIR . 'inc/schema/class-astra-schema.php';
/**
 * gdexpress api
 */
require ASTRA_THEME_DIR . '/inc/gdex-api.php';
require ASTRA_THEME_DIR . '/inc/gdex.php';

require get_template_directory() . '/gateway_cybersource_1/woocommerce-gateway-cybersource.php';

if ( is_admin() ) {

	/**
	 * Admin Menu Settings
	 */
	require_once ASTRA_THEME_DIR . 'inc/core/class-astra-admin-settings.php';
	require_once ASTRA_THEME_DIR . 'inc/lib/notices/class-astra-notices.php';

	/**
	 * Metabox additions.
	 */
	require_once ASTRA_THEME_DIR . 'inc/metabox/class-astra-meta-boxes.php';
}

require_once ASTRA_THEME_DIR . 'inc/metabox/class-astra-meta-box-operations.php';


/**
 * Customizer additions.
 */
require_once ASTRA_THEME_DIR . 'inc/customizer/class-astra-customizer.php';


/**
 * Compatibility
 */
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-jetpack.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/woocommerce/class-astra-woocommerce.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/edd/class-astra-edd.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/lifterlms/class-astra-lifterlms.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/learndash/class-astra-learndash.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-beaver-builder.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-bb-ultimate-addon.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-contact-form-7.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-visual-composer.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-site-origin.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-gravity-forms.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-bne-flyout.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-ubermeu.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-divi-builder.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-amp.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-yoast-seo.php';
require_once ASTRA_THEME_DIR . 'inc/addons/transparent-header/class-astra-ext-transparent-header.php';
require_once ASTRA_THEME_DIR . 'inc/addons/breadcrumbs/class-astra-breadcrumbs.php';
require_once ASTRA_THEME_DIR . 'inc/class-astra-filesystem.php';

// Elementor Compatibility requires PHP 5.4 for namespaces.
if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
	require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-elementor.php';
	require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-elementor-pro.php';
}

// Beaver Themer compatibility requires PHP 5.3 for anonymus functions.
if ( version_compare( PHP_VERSION, '5.3', '>=' ) ) {
	require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-beaver-themer.php';
}

/**
 * Load deprecated functions
 */
require_once ASTRA_THEME_DIR . 'inc/core/deprecated/deprecated-filters.php';
require_once ASTRA_THEME_DIR . 'inc/core/deprecated/deprecated-hooks.php';
require_once ASTRA_THEME_DIR . 'inc/core/deprecated/deprecated-functions.php';
/**
 * Custom coupon
 */
require_once ASTRA_THEME_DIR . 'inc/custom-coupon.php';
require_once ASTRA_THEME_DIR . 'func-custom/custom-coupon/custom-coupon.php';
require_once ASTRA_THEME_DIR . 'func-custom/dianmond/dianmon-functions.php';
require_once ASTRA_THEME_DIR . 'func-custom/dianmond/dianmon-functions.php';
require_once ASTRA_THEME_DIR . 'func-custom/walker-facewp.php';
//require_once ASTRA_THEME_DIR . 'func-custom/dht-lvc-woo-order-add-status-shipped.php';
//require_once ASTRA_THEME_DIR . 'func-custom/dht-shippit/lvc-shippit.php';
require_once ASTRA_THEME_DIR . 'func-custom/cybersource-hook.php';


//include file content
//[include slug="shortcode/filename_without_extension"]
function include_file($atts) {
	$a = shortcode_atts( array(
		'slug' => 'NULL',
	), $atts );

	if( $a['slug'] != 'NULL'){
		ob_start();
		get_template_part($a['slug']);
		return ob_get_clean();
	}
}
add_shortcode('include', 'include_file');


//PSG Grand
add_filter('admin_footer_text', 'psg_grant');
add_filter( 'update_footer',     '__return_empty_string', 11 );
function psg_grant() {
	return '<a target="_blank" href="https://i-concept.com.sg/">I Concept</a> Ecommerce Solution Version 1 - Package (Premium)';
}


//Remove Unused Fields / Other Roles Fields in User
add_filter( 'ure_show_additional_capabilities_section', '__return_false' );
// Removes ability to change Theme color for the users
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
add_filter('user_contactmethods','hide_profile_fields',10,1);
function hide_profile_fields( $contactmethods ) {
unset($contactmethods['aim']);
unset($contactmethods['jabber']);
unset($contactmethods['yim']);
return $contactmethods;
}
function remove_personal_options(){
    echo '<script type="text/javascript">jQuery(document).ready(function($) {
  
$(\'form#your-profile tr.user-rich-editing-wrap\').hide(); // hide the "Visual Editor" field
  
$(\'form#your-profile tr.user-admin-color-wrap\').hide(); // hide the "Admin Color Scheme" field
  
$(\'form#your-profile tr.user-comment-shortcuts-wrap\').hide(); // hide the "Keyboard Shortcuts" field
  
$(\'form#your-profile tr.user-admin-bar-front-wrap\').hide(); // hide the "Toolbar" field
  
$(\'form#your-profile tr.user-language-wrap\').hide(); // hide the "Language" field
  
$(\'table.form-table tr.user-url-wrap\').hide();// hide the "Website" field in the "Contact Info" section
  
$(\'h2:contains("About Yourself"), h2:contains("About the user")\').hide(); // hide the "About Yourself" and "About the user" titles
  
$(\'form#your-profile tr.user-description-wrap\').hide(); // hide the "Biographical Info" field
  
$(\'form#your-profile tr.user-profile-picture\').hide(); // hide the "Profile Picture" field
  
$(\'h2:contains("Name")\').hide(); // hide the "Name" heading
 
$(\'h2:contains("Contact Info")\').hide(); // hide the "Contact Info" heading
 
});</script>';
  
}
  
add_action('admin_head','remove_personal_options');



//Debug
function debug($array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

//Allow Breakline conversion using '|'
// add_filter( 'the_title', 'custom_the_title', 99, 2 );
// function custom_the_title( $title, $post_id ){
//     $post_type = get_post_field( 'post_type', $post_id, true );
//     if( $post_type == 'product' || $post_type == 'product_variation' )
//         $title = str_replace( '|', '<br/>', $title );
//     return $title;
// }

/* Lets Shop Managers edit users with these user roles */
function wws_allow_shop_manager_role_edit_capabilities( $roles ) {
    global $wp_roles;

    $all_roles = $wp_roles->roles;
    $remove = array('administrator','editor','author','contributor','subscriber','wpseo_manager','wpseo_editor');
    foreach($all_roles as $key=>$single_roles){
        if(in_array($key, $remove)){
        }else{
            $roles[] = $key;
        }
    }
    return $roles;
}
add_filter( 'woocommerce_shop_manager_editable_roles', 'wws_allow_shop_manager_role_edit_capabilities' );


//Wordpress Redirect Shop Manager to Woo-Dashboard
add_action( 'admin_init', 'redirect_woodashboard' );
function redirect_woodashboard(){
	global $pagenow;
	if($pagenow == 'index.php'){
		$user = wp_get_current_user();
		if ( isset( $user->roles[0] ) && $user->roles[0] == 'shop_manager' ) {
			wp_redirect(admin_url( 'admin.php?page=wc-admin', 'https' ));
		} 
	}
}

/*Hook user to Member by Default. (This for guest Price issue quick fix)
* Used for Gawler Wine
* Used when Wholesale is activated.
*/
// function member_hook( $customer_id, $new_customer_data, $password_generated ) { 
// 	$user = new WP_User($customer_id);
// 	$user->set_role('member');
// }
// add_action( 'woocommerce_created_customer', 'member_hook', 10, 3 );


/**
 * Remove product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['description'] );      	// Remove the description tab
    //unset( $tabs['reviews'] ); 			// Remove the reviews tab
    unset( $tabs['additional_information'] );  	// Remove the additional information tab

    return $tabs;
}

/**
 * Rename product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {

	$tabs['reviews']['title'] = __( 'Reviews' );				// Rename the reviews tab
	return $tabs;

}

/**
 * Add a custom product data tab
 */
add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {
	// Adds the new tab
	$tabs['details'] = array(
		'title' 	=> __( 'Details', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'woo_new_product_tab_details_content'
	);

	// Adds the new tab
	$tabs['loveco'] = array(
		'title' 	=> __( 'Love & Co. Promise', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'woo_new_product_tab_loveco_content'
	);
	return $tabs;
}

function woo_new_product_tab_details_content() {
	// The new tab content
	echo do_shortcode( '[include slug="shortcode/product-details-tab"]' );
}

function woo_new_product_tab_loveco_content() {
	// The new tab content
	//echo the_field('love_co_promise'); 
	echo do_shortcode( '[elementor-template id="3343"]' );
}


/**
 * Reorder product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_reorder_tabs', 98 );
function woo_reorder_tabs( $tabs ) {
	
	$tabs['details']['priority'] = 10;
	$tabs['reviews']['priority'] = 20;
	$tabs['loveco']['priority'] = 30;

	return $tabs;
}




/**
 * @snippet       WooCommerce Add New Tab @ My Account
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 3.5.7
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
  
// ------------------
// 1. Register new endpoint to use for My Account page
// Note: Resave Permalinks or it will give 404 error
function add_preferences_endpoint() {
    add_rewrite_endpoint( 'preferences', EP_ROOT | EP_PAGES );
}
add_action( 'init', 'add_preferences_endpoint' );
  
  
// ------------------
// 2. Add new query var
function preferences_query_vars( $vars ) {
    $vars[] = 'preferences';
    return $vars;
}
add_filter( 'query_vars', 'preferences_query_vars', 0 );
  
  
// ------------------
// 3. Insert the new endpoint into the My Account menu
function add_preferences_link_my_account( $items ) {
	// Remove the logout menu item.
	$logout = $items['customer-logout'];
	unset( $items['customer-logout'] );
		
	// Insert your custom endpoint.
	$items['preferences'] = 'Preferences';
		
	// Insert back the logout item.
	$items['customer-logout'] = $logout;
		
	return $items;
}
add_filter( 'woocommerce_account_menu_items', 'add_preferences_link_my_account' );
	
  
// ------------------
// 4. Add content to the new endpoint
function preferences_content() {
	echo do_shortcode( '[elementor-template id="3759"]' );
}
add_action( 'woocommerce_account_preferences_endpoint', 'preferences_content' );
// Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format


  

//Hide Dashboard Widgets
function remove_dashboard_widgets() {
	global $wp_meta_boxes;
	// debug($wp_meta_boxes);
 
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['yith_dashboard_products_news']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['yith_dashboard_blog_news']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
}
 
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );


//make woocommerce product tags hierarchical
function my_woocommerce_taxonomy_args_product_tag( $array ) {
    $array['hierarchical'] = true;
    return $array;
};
add_filter( 'woocommerce_taxonomy_args_product_tag', 'my_woocommerce_taxonomy_args_product_tag', 2, 1 );





function add_to_cart_form_shortcode( $atts ) {
	if ( empty( $atts ) ) {
		return '';
	}

	if ( ! isset( $atts['id'] ) && ! isset( $atts['sku'] ) ) {
		return '';
	}

	$args = array(
		'posts_per_page'      => 1,
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'no_found_rows'       => 1,
	);

	if ( isset( $atts['sku'] ) ) {
		$args['meta_query'][] = array(
			'key'     => '_sku',
			'value'   => sanitize_text_field( $atts['sku'] ),
			'compare' => '=',
		);

		$args['post_type'] = array( 'product', 'product_variation' );
	}

	if ( isset( $atts['id'] ) ) {
		$args['p'] = absint( $atts['id'] );
	}

	$single_product = new WP_Query( $args );

	$preselected_id = '0';


	if ( isset( $atts['sku'] ) && $single_product->have_posts() && 'product_variation' === $single_product->post->post_type ) {

		$variation = new WC_Product_Variation( $single_product->post->ID );
		$attributes = $variation->get_attributes();


		$preselected_id = $single_product->post->ID;


		$args = array(
			'posts_per_page'      => 1,
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'no_found_rows'       => 1,
			'p'                   => $single_product->post->post_parent,
		);

		$single_product = new WP_Query( $args );
	?>
		<script type="text/javascript">
			jQuery( document ).ready( function( $ ) {
				var $variations_form = $( '[data-product-page-preselected-id="<?php echo esc_attr( $preselected_id ); ?>"]' ).find( 'form.variations_form' );
				<?php foreach ( $attributes as $attr => $value ) { ?>
					$variations_form.find( 'select[name="<?php echo esc_attr( $attr ); ?>"]' ).val( '<?php echo esc_js( $value ); ?>' );
				<?php } ?>
			});
		</script>
	<?php
	}

	$single_product->is_single = true;
	ob_start();
	global $wp_query;

	$previous_wp_query = $wp_query;

	$wp_query          = $single_product;

	wp_enqueue_script( 'wc-single-product' );
	while ( $single_product->have_posts() ) {
		$single_product->the_post()
		?>
		<div class="single-product" data-product-page-preselected-id="<?php echo esc_attr( $preselected_id ); ?>">
			<?php woocommerce_template_single_add_to_cart(); ?>
		</div>
		<?php
	}

	$wp_query = $previous_wp_query;

	wp_reset_postdata();
	return '<div class="woocommerce">' . ob_get_clean() . '</div>';
}
add_shortcode( 'add_to_cart_form', 'add_to_cart_form_shortcode' );


// add first thumbnail image for hover effect.
add_action( 'woocommerce_before_shop_loop_item_title', 'add_on_hover_shop_loop_image' ) ; 

function add_on_hover_shop_loop_image() {

    $image_id = count(wc_get_product()->get_gallery_image_ids()) > 0 ? wc_get_product()->get_gallery_image_ids()[0] : false; 

    if ( $image_id ) {

        echo wp_get_attachment_image( $image_id,  $size = 'shop_catalog', "", array('class' => 'first-gallery-img')) ;

    } else {  //assuming not all products have galleries set

        echo wp_get_attachment_image( wc_get_product()->get_image_id() ) ; 

    }

}

//make thumbnail size bigger
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
    return array(
        'width' => 600,
        'height' => 600,
        'crop' => 0,
    );
} );



//Remove choose an option at variables
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'filter_dropdown_option_html', 12, 2 );
function filter_dropdown_option_html( $html, $args ) {
	global $product;
	$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __( 'Choose an option.', 'woocommerce' );
	$show_option_none_html = '<option value="">' . esc_html( $show_option_none_text ) . '</option>';
	$html = str_replace($show_option_none_html, '', $html);
    return $html;
}


//Facet Sorting 
add_filter( 'facetwp_sort_options', function( $options, $params ) {
	$options = array(
		'default' => array(
			'label' => __( 'Date (Newest)', 'fwp' ),
			'query_args' => array(
				'orderby' => 'date',
				'order' => 'DESC',
			)
		),
		'date_asc' => array(
			'label' => __( 'Date (Oldest)', 'fwp' ),
			'query_args' => array(
				'orderby' => 'date',
				'order' => 'ASC',
			)
		),
		'title_asc' => array(
			'label' => __( 'Title (A-Z)', 'fwp' ),
			'query_args' => array(
				'orderby' => 'title',
				'order' => 'ASC',
			)
		),
		'title_desc' => array(
			'label' => __( 'Title (Z-A)', 'fwp' ),
			'query_args' => array(
				'orderby' => 'title',
				'order' => 'DESC',
			)
		)
	);
	
    return $options;
}, 10, 2 );


/* update by emma */

if ( ! is_admin() ) {
	//add_filter('get_term', 'filter_term_name', 2, 2);
}

function filter_term_name($term, $taxonomy) {
	if ($taxonomy == 'product_cat' || $taxonomy == 'designer_collections' || $taxonomy == 'material' || $taxonomy == 'occasions') {
		$term_id = $term -> term_id;
		$custom_title = get_field('lvc_banner_title_text','term_'.$term_id);
		if (!empty($custom_title)) {
			$term->name = $custom_title;
		}		
	}

	
    return $term;
}

function eeewalk( $elements,$temps ) {
 	$result = []; 	
 	foreach ($elements as $key => $item) {
 		$id = $item['term_id'];
 		foreach ($temps as $key2 => $value) {
 			
 			if ( $value['term_id'] == $id) {
 				$result[] = $value; 				
 				unset($elements[$key]);
 				unset($temps[$key2]);
 			}
 		}

 	}
 	return $result;
	}

add_filter( 'facetwp_facet_html', function( $output, $params ) {	


	if ( 'product_categories' == $params['facet']['name'] || 'designer_collections' == $params['facet']['name'] || 'material' == $params['facet']['name'] || 'occasions' == $params['facet']['name'] ) {
		$taxonomy_slug = '';
		$face_slug = $params['facet']['name'];
		switch ($face_slug) {
			case 'product_categories':
				$taxonomy_slug = 'product_cat';	
				break;
			case 'designer_collections':
				$taxonomy_slug = 'designer_collections';
				break;
			case 'material':
				$taxonomy_slug = 'material';
				break;
			case 'occasions':
				$taxonomy_slug = 'occasions';		
			default:
			
		}
		

	$output = '';
        $facet = $params['facet'];
        $values = (array) $params['values'];
        $values_terms2 = wp_terms_wp_select2( $post_id = 0, $args = array(),$taxonomy_slug );

        $selected_values = (array) $params['selected_values'];

        if ( FWP()->helper->facet_is( $facet, 'hierarchical', 'yes' ) ) {
            $values = FWP()->helper->sort_taxonomy_values( $params['values'], $facet['orderby'] );
        }

        $multiple = FWP()->helper->facet_is( $facet, 'multiple', 'yes' ) ? ' multiple="multiple"' : '';
        $label_any = empty( $facet['label_any'] ) ? __( 'Any', 'fwp-front' ) : $facet['label_any'];
        $label_any = facetwp_i18n( $label_any );        

        $output .= '<select class="facetwp-dropdown"' . $multiple . '>';
        $output .= '<option value="">' . esc_html( $label_any ) . '</option>';      

       $value_params = eeewalk( $values_terms2,$values );

        foreach ( $value_params as $result ) {
            $selected = in_array( $result['facet_value'], $selected_values ) ? ' selected' : '';
            $selected .= ( 0 == $result['counter'] && '' == $selected ) ? ' disabled' : '';

            // Determine whether to show counts

            $term_id = $result ['term_id'];
	$custom_title = $result['facet_display_value'];
		 $custom_title22 = get_field('lvc_banner_title_text','term_'.$term_id) ?? '';
		if (!empty($custom_title22)) {
			$custom_title = $custom_title22;
		} 


            $display_value = esc_html( $custom_title );
            $show_counts = apply_filters( 'facetwp_facet_dropdown_show_counts', true, [ 'facet' => $facet ] );

            if ( $show_counts ) {
                $display_value .= ' (' . $result['counter'] . ')';
            }

            $output .= '<option value="' . esc_attr( $result['facet_value'] ) . '" class="d' . $result['depth'] . '"' . $selected . '>' . $display_value . '</option>';
        }

        $output .= '</select>';
    }
	
	
	return $output;
	
}, 20, 2 );

// rewrite url
if (function_exists('acf_add_options_page')) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-settings',
		'redirect'		=> false
	));
	acf_add_options_page(array(
		'page_title' 	=> 'Product Settings',
		'menu_title'	=> 'Product Settings',
		'menu_slug' 	=> 'product-settings',
		'parent_slug'=>'theme-settings',
		'redirect'		=> false
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Gdex Setting',
		'menu_title'	=> 'Gdex Setting',
		'parent_slug'	=> 'theme-settings',
		'menu_slug' 	=> 'Gdex-Setting',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Cybersource Setting',
		'menu_title'	=> 'Cybersource Setting',
		'parent_slug'	=> 'theme-settings',
		'menu_slug' 	=> 'Cybersource-Setting',
	));
	acf_add_options_page(array(
		'page_title' 	=> 'Woo Settings',
		'menu_title'	=> 'Woo Settings',
		'menu_slug' 	=> 'lvc2-woo-settings',
		'parent_slug'=>'theme-settings',
		'redirect'		=> false
	));

	
}

function oa_slug_change() {
	
	$array_item = array(
		'taxonomy' => 'designer_collections',
		'taxonomy_replace' => 'shop/collections',
		'items_old' => array(
			'lovemarque' 		=> 'designer_collections/lovemarque',			
			'lvc-charmes'		=>'designer_collections/lvc-charmes',
			'lvc-classique'		=>'designer_collections/lvc-classique',
			'lvc-desirio'		=>'designer_collections/lvc-desirio',
			'lvc-destiny'		=>'designer_collections/lvc-destiny',			
			'eterno-gifting'	=>'designer_collections/lvc-eterno/eterno-gifting',
			'eterno-wedding-band'=>'designer_collections/lvc-eterno/eterno-wedding-band',
			'lvc-joie'			=>'designer_collections/lvc-joie',
			'lvc-mini-ring'		=>'designer_collections/lvc-mini-ring',			
			'noeud-gifting'		=>'designer_collections/lvc-noeud/noeud-gifting',
			'noeud-wedding-band'=>'designer_collections/lvc-noeud/noeud-wedding-band',
			'lvc-perfection'	=>'designer_collections/lvc-perfection',
			'lvc-precieux'		=>'designer_collections/lvc-precieux',			
			'lvc-promise'	=>'designer_collections/lvc-promise',
			'promise-gifting'	=>'designer_collections/lvc-promise/promise-gifting',
			'promise-wedding-band'=>'designer_collections/lvc-promise/promise-wedding-band',
			'lvc-purete'		=>'designer_collections/lvc-purete',			
			'lvc-soleil'		=>'designer_collections/lvc-soleil',
			'teddy-bear'		=>'designer_collections/teddy-bear',		
		),
		'items_new' => array(
			'lovemarque' 		=> 'shop/collection/lovemarque',			
			'lvc-charmes'		=>'shop/collection/lvc-charmes',
			'lvc-classique'		=>'shop/collection/lvc-classique',
			'lvc-desirio'		=>'shop/collection/lvc-desirio',
			'lvc-destiny'		=>'shop/collection/lvc-destiny',			
			'eterno-gifting'	=>'shop/collection/lvc-eterno-gifting',
			'eterno-wedding-band'=>'shop/collection/lvc-eterno',
			'lvc-joie'			=>'shop/collection/lvc-joie',
			'lvc-mini-ring'		=>'shop/collection/lvc-mini-ring',			
			'noeud-gifting'		=>'shop/collection/lvc-noeud-gifting',
			'noeud-wedding-band'=>'shop/collection/lvc-noeud',
			'lvc-perfection'	=>'shop/collection/lvc-perfection',
			'lvc-precieux'		=>'shop/collection/lvc-precieux',	
			'lvc-promise'	=>'shop/collection/lvc-promise',		
			'promise-gifting'	=>'shop/collection/lvc-promise-gifting',
			'promise-wedding-band'=>'shop/collection/lvc-promise-wedding-band',
			'lvc-purete'		=>'shop/collection/lvc-purete',			
			'lvc-soleil'		=>'shop/collection/lvc-soleil',
			'teddy-bear'		=>'shop/collection/lvc-teddy-bear',		
		)
	);

		$array_item2 = array(
			'taxonomy' => 'category',
			'taxonomy_replace' => 'shop/category',
			'items_old' => array(
				'wedding-bands'			=>'category/wedding-bands',			
				'necklaces-pendants'	=>'category/necklaces-pendants',
				'earrings'				=>'category/earrings',
				'bangles-bracelets'		=>'category/bangles-bracelets',
				'womens-wedding-bands'	=>'category/wedding-bands/womens-wedding-bands',			
				'mens-wedding-bands'	=>'category/wedding-bands/mens-wedding-bands',
				'new-in'				=>'category/new-in'
			),
			'items_new' => array(
				'wedding-bands'			=>'shop/category/wedding-bands',			
				'necklaces-pendants'	=>'shop/category/necklaces-pendants',
				'earrings'				=>'shop/category/earrings',
				'bangles-bracelets'		=>'shop/category/bracelets-bangles',
				'womens-wedding-bands'	=>'shop/category/female-wedding-bands',			
				'mens-wedding-bands'	=>'shop/category/male-wedding-bands',
				'new-in'				=>'shop/category/new'
			)
		);

		$array_item3 = array(
		'taxonomy' => 'material',
		'taxonomy_replace' => 'shop/category',		
			'items_old' => array(
				'silver'=>'material/silver',
				'white-gold'=>'material/white-gold',
				'yellow-gold'=>'material/yellow-gold',
				'rose-gold'=>'material/rose-gold',
				'platinum'=>'material/platinum',
				'dual-tone'=>'material/dual-tone'
			),
			'items_new' => array(
				'silver'=>'shop/category/silver',
				'white-gold'=>'shop/category/white-gold',
				'yellow-gold'=>'shop/category/yellow-gold',
				'rose-gold'=>'shop/category/rose-gold',
				'platinum'=>'shop/category/platinum',
				'dual-tone'=>'shop/category/duo-tone'
			)
		);

	return array(
		'designer_collections' => $array_item,
		'product_cat' =>$array_item2,
		'material' =>$array_item3	
	);
}
add_filter( 'term_link', 'lvc_product_cat_permalink', 10, 3 );
function lvc_product_cat_permalink( $url, $term, $taxonomy ){
	
	$terms_change = oa_slug_change();
	if (isset($terms_change[$taxonomy])) {
		
		$arr_terms = $terms_change[$taxonomy];
		$term_slug = $term -> slug;
        $items_old = $arr_terms['items_old'];
        $items_new = $arr_terms['items_new'];
        if (isset($items_old[$term_slug]) && isset($items_new[$term_slug])) {
        	$old_slug = $items_old[$term_slug];  
        	$new_slug = $items_new[$term_slug];  
        	$url = str_replace('/' . $old_slug, '/'.$new_slug, $url);
        }
	}
	 
    return $url;
}


add_filter( 'init', 'lvc_product_category_base_same_shop_base',20 );
function lvc_product_category_base_same_shop_base( $flash = false ){
	$terms_change = oa_slug_change();
	foreach ($terms_change as $key => $items) {	
		
		$taxonomy = $key;
		/*$terms_id = $items['items'];
		$tax_replace = $items['taxonomy_replace'];*/

		$items_old = $items['items_old'];
        $items_new = $items['items_new'];

		$terms = get_terms( array(
			'taxonomy' 		=> $taxonomy,
			'post_type' 	=> 'product',
			'hide_empty' 	=> false,
			'fields' 		=> 'slugs'
		) );

		//$result=array_intersect($terms_id,$terms);
		foreach ($terms as $key2 => $term_slug) {		

			if (isset($items_old[$term_slug]) && isset($items_new[$term_slug])) {
	        	$old_slug = $items_old[$term_slug];  
	        	$new_slug = $items_new[$term_slug];
	        	//debug($old_slug.' ++++ '.$new_slug);

	        	$siteurl = esc_url( home_url( '/' ) );  
				$baseterm = str_replace( $siteurl, '', get_term_link( $term_slug, $taxonomy ) ); 	
				//debug($baseterm);		
				$baseterm = str_replace($old_slug, $new_slug, $baseterm);
				
				$check_strpos = strpos($baseterm,"shop/shop/");

				if (isset($check_strpos)) {
					$baseterm = str_replace("shop/shop/", "shop/", $baseterm);					
				}
					

	        	//$url = str_replace('/' . $old_slug, '/'.$new_slug, $url);
	        	add_rewrite_rule( $baseterm . '?$','index.php?'.$taxonomy.'=' . $term_slug,'top' );
				add_rewrite_rule( $baseterm . 'page/([0-9]{1,})/?$', 'index.php?'.$taxonomy.'=' . $term_slug . '&paged=$matches[1]','top' );
				add_rewrite_rule( $baseterm . '(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?'.$taxonomy.'=' . $term_slug . '&feed=$matches[1]','top' );  
				
	        }
			    
		}
		if ( $flash == true )
		flush_rewrite_rules( false );
}
}

function rudr_url_redirects2() {
	$terms_change = oa_slug_change();
	foreach ($terms_change as $key => $items) {	
		$items_old = $items['items_old'];
        $items_new = $items['items_new'];
        foreach ($items_old as $key2 => $value) {

        	$page = home_url( $value );
        	if (is_page($page)) {
        		$new_site = home_url( $items_new[$key2] );
        		wp_redirect( $new_site, 301 );
			exit();
        	}
        	
        }
       }
}

function plugins_product_cat_old_term_redirect() {
	$terms_change = oa_slug_change();
	$server_uri = str_replace('/oa128-lvc/', '', $_SERVER['REQUEST_URI']);
	$server_uri = rtrim($server_uri,"/");	
	if ($server_uri == 'product/gift-cards') {
		$new_site = home_url( 'shop/category/gift-card' );
		wp_safe_redirect( $new_site, 301 );
		exit;
	}
	foreach ($terms_change as $key => $items) {	
		$taxonomy_name = $key;
		$taxonomy_slug = _x( $taxonomy_name, 'slug', 'woocommerce' );
		$items_old = $items['items_old'];
		$items_new = $items['items_new'];

		 if (is_tax($key)  ) :
			foreach ($items_old as $key2 => $value) {
				
				if ($server_uri == '/'.$value) {
					$new_site = home_url( $items_new[$key2] );
					wp_safe_redirect( $new_site, 301 );
					exit;
				}				      	
			}
		endif; 

		}
	}

	add_action('template_redirect', 'plugins_product_cat_old_term_redirect');


 
add_action( 'create_term', 'lvc_product_cat_same_shop_edit_success', 10, 2 );
function lvc_product_cat_same_shop_edit_success( $term_id, $taxonomy ) {
	if (function_exists('ywp_product_category_base_same_shop_base')) {
		 ywp_product_category_base_same_shop_base( true );
	}
   
}




add_filter('post_type_link', 'change_permalink_giftcard', 9, 3);

function change_permalink_giftcard( $link, $post = 0 ){
    if ( $post->post_type == 'product' && $post -> ID == 891 ){
        return home_url( 'shop/category/' . $post->post_name );
    } else {
        return $link;
    }
}

add_action( 'init', 'rewrite_product_giftcards',20 );

function rewrite_product_giftcards(){
	 add_rewrite_rule(
        'shop/category/gift-cards?$',
        'index.php?post_type=product&p=891',
        'top' );	
    
}
function custom_redirects() {    
 
    if ( is_page('wedding-bands') ) {
        wp_redirect( home_url( '/shop/category/wedding-bands/' ) );
        die;
    }
 
}
//add_action( 'template_redirect', 'custom_redirects' );
/* end rewrite url */

/* collection store */


add_action('wp_footer', 'add_new_button_free_bracelet');
function add_new_button_free_bracelet () { ?>
  <script type='text/javascript'>
    jQuery(document).ready( function(){ 
    	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>"; 
    	 jQuery(document).on("change",".select_stores input", function() {	
    	 var shipping_method = jQuery(".shipping_method:checked").val();		
    	 console.log(shipping_method);
    	 if (shipping_method == 'local_pickup:8')	{
		var store = jQuery(this)	.val();
		console.log(store);
			jQuery.ajax({
				url: ajaxurl,
				data: {
						'action' : 'update_store_in_session',
						'shipping_method' : shipping_method,
						'store' : store
						},

			})
			.done(function (response) {  	
				if (response != '')	{
					console.log(response);
				}
			});
			} 

        }); 
        }); 
      </script>
      <?php 
      
    }
add_action( 'wp_ajax_update_store_in_session', 'update_store_in_session' );
add_action('wp_ajax_nopriv_update_store_in_session', 'update_store_in_session');
function update_store_in_session() {
	global $woocommerce;
	$store = $_REQUEST['store'];
	$shipping_method = $_REQUEST['shipping_method'];
	if ($shipping_method == 'local_pickup:8') {
		WC()->session->set( 'shipping_store', $store);
	} else {
		WC()->session->set( 'shipping_store', '');
	}
	echo WC()->session->get( 'shipping_store');
	wp_die();

}

//add_action('init','filter_name',99);
function filter_name() {
	
	add_filter('get_term', 'filter_term_name', 20, 2);

}
// admin footer
add_action('admin_footer', 'my_admin_footer_function');
function my_admin_footer_function() { ?>

    <script type="text/javascript">
    jQuery(document).ready(function($){
   		if ($("body.post-type-shop_order").length)  {
   			$(".edit-order-item").click(function(){
   				$(this).parents(".shipping").find(".change_stores").show();
   				$(this).parents(".shipping").find(".view_title_store").hide();
   			});

   			$(".shipping_method").change(function(){
   				var value = $(this).val();
   				if (value != 'local_pickup') {
   					$(this).parents(".shipping").find(".change_stores").hide();
   				} else {
   					$(this).parents(".shipping").find(".change_stores").show();
   				}
   			});
   		}
    });
    </script> 
<?php } 

add_action( 'woocommerce_process_shop_order_meta', 'update_store_shipping',20,1 );

function update_store_shipping( $order_id ){
	$shipping = $_POST['shipping_method'] ?? '';
	$store = $_POST['change_store'] ?? '';
	if (is_array($shipping) && count($shipping) > 0) {
		$shipping =  reset($shipping);
	}
	if ($shipping == 'local_pickup' && !empty($store)) {
		update_post_meta( $order_id, 'select_store', $store );
	} else {
		
	}
}

function get_stores() {
	global $post;
		$stores = array();
		$args = array(
			'post_type'      	=> 'store_locator',
			'posts_per_page' 	=> -1,
			'post_status' 		=> 'publish',
			'fields' 			=> 'ids',
			'tax_query' => array(
		        array(
		            'taxonomy' => 'store_location',
		            'field'    => 'slug',
		            'terms'    => 'malaysia',
		        ),
    ),
			
		);
	 $the_query = new WP_Query( $args );
	while ($the_query->have_posts() ) : $the_query->the_post();
		$stores[] = $post;
	endwhile;
	wp_reset_postdata();
	return $stores;

}

function get_html_select_stores() {
	global $woocommerce;
	$stores = get_stores();
	$shipping_store = WC()->session->get( 'shipping_store') ?? '';
	if (count($stores) > 0)  {
		echo '<div class="select_stores">';
			foreach ($stores as $key => $store_id) { ?>
				<div class="store_info"><label for="store_<?php echo $store_id; ?>">
				<input type="radio" data-curr = "<?php echo $shipping_store; ?>" <?php echo checked($shipping_store,$store_id); ?> name="select_store[]" id="store_<?php echo $store_id; ?>" value="<?php echo $store_id; ?>" >
				<span><?php echo get_the_title($store_id); ?></span><br/>
				<div class="opening-hours">
					<?php 
					echo 'Opening Hours:'. wpautop(get_field('store_opening_hours',$store_id),true);
					?>
				
				</div>
				</label>
			</div>
			<?php }
		echo '</div>';
	}
}

add_action( 'woocommerce_checkout_process', 'my_custom_checkout_field_process' );
function my_custom_checkout_field_process( ) {
	global $woocommerce;	
	$shipping = $_POST['shipping_method'][0] ?? '';
	$select_store = $_POST['select_store'][0] ?? '';
	
	 if ( $shipping == 'local_pickup:8' && empty($select_store)) {wc_add_notice( __( 'Please select Store.' ), 'error' );}	
}

add_action( 'woocommerce_checkout_update_order_meta', 'hear_about_us_field_update_order_meta' );
function hear_about_us_field_update_order_meta( $order_id ) {
	$shipping = $_POST['shipping_method'][0] ?? '';
	$select_store = $_POST['select_store'][0] ?? '';
	
	 if ( $shipping == 'local_pickup:8' && !empty($select_store)) {
	 	$name_store = get_the_title($select_store);
	 	update_post_meta( $order_id, 'select_store', $select_store );
	 } else {
	 	update_post_meta( $order_id, 'select_store', '' );
	 }
}


function store_infor($store_id) {
	$name_store = get_the_title($store_id);
	$store_address = get_field('store_address',$store_id);
	$store_opening_hours = get_field('store_opening_hours',$store_id);//Opening Hours
	$store_phone_no = get_field('store_phone_no',$store_id);//Phone No.
	$store_direction = get_field('store_direction',$store_id);//Directions
	return '<ul class="store_tel_directions">
	<li><label>Store Name: </label>'.$name_store.'</li>
	<li><label>Store Address: </label>'.$store_address.'</li>
	<li><label>Store Phone: </label>'.$store_phone_no.'</li>
</ul>';
}

add_action('woocommerce_before_order_itemmeta','add_store_backend',90,3);
function add_store_backend($aa,$i,$order_id) {
	global $woocommerce;
	$data = $i -> get_data();
	if (isset($data['method_id']) && $data['method_id'] == 'local_pickup') {
		$order_id = $data['order_id'];
		$id_store = get_post_meta($order_id,'select_store',true);

		echo '<p class="view_title_store"> <strong>Store: </strong> '.get_the_title($id_store).'</p>';
		$stores = get_stores();
		?>
		<div class="change_stores" style="display: none;">
			<select name="change_store" id="change_store">
				<?php
					foreach ( $stores as $key => $store_id) {
						echo '<option '.selected($id_store,$store_id).' value="'.$store_id.'">'.get_the_title($store_id).'</option>';
					}
				?>
			</select>
		</div>
		<?php
	}
	
}
/* end collection store */


/* end update by emma 2020-12-14*/

/*echo '<pre>';
var_dump(get_post_meta(3400));
echo '</pre>';*/

function subscriptions_get_order_meta_keys() {

		return array(
			'_order_number',
			'_order_number_formatted'
		);
	}


function order_number_format($order) {
		$order_date = mysql2date('Ymd',$order->get_date_created());
		$frefix = 'IC-'.$order_date;
		return $frefix. $order->get_id();
}


add_filter( 'woocommerce_order_number', 'prefix_woocommerce_order_number', 1, 2 );

function prefix_woocommerce_order_number( $oldnumber, $order ) {
	$old_format = get_post_meta( $order->get_id(), '_order_number_formatted', true ) ?? '';
	if (!empty($old_format)) {
		return $old_format;
	} else {		
		return order_number_format($order);
	}
    
}

// process meta when change order id
add_action( 'woocommerce_checkout_update_order_meta',  'set_sequential_order_number' , 10, 2 );
//add_action( 'woocommerce_process_shop_order_meta',     'set_sequential_order_number' , 35, 2 );
//add_action( 'woocommerce_before_resend_order_emails',  'set_sequential_order_number' , 10, 1 );

// set the custom order number for orders created by WooCommerce Deposits
add_filter( 'wcs_renewal_order_created',  'subscriptions_set_sequential_order_number' , 9 );

function set_sequential_order_number( $post_id, $post = array() ) {

	// when creating an order from the admin don't create order numbers for auto-draft
	//  orders, because these are not linked to from the admin and so difficult to delete
	if ( is_array( $post ) || is_null( $post ) || ( 'shop_order' === $post->post_type && 'auto-draft' !== $post->post_status ) ) {

		$order        = $post_id instanceof \WC_Order ? $post_id : wc_get_order( $post_id );
		$order_number = $order ? $order->get_meta( '_order_number' ) : '';

		// if no order number has been assigned, this will be an empty array
		if ( empty( $order_number ) ) {

			$order->update_meta_data( '_order_number', $post_id );
			$order->update_meta_data( '_order_number_formatted', order_number_format($order) );
					$order->save_meta_data();
		}
	}
}
function subscriptions_set_sequential_order_number( $renewal_order ) {
	$order_post = get_post( $renewal_order->get_id() );
	set_sequential_order_number( $order_post->ID, $order_post );
	return $renewal_order;
}

/**
 * Custom Admin Login Page acf
*/
if (function_exists('acf_add_options_page')) {

	acf_add_options_page(array(
		'page_title' 	=> 'Admin Login',
		'menu_title'	=> 'Admin Login',
		'menu_slug' 	=> 'custom-admin-login',
		'parent_slug'=>'theme-settings',
		'redirect'		=> false
	));
}

function oa_disable_comment_status( $open, $post_id ) {
    $post = get_post( $post_id );
    if( $post->post_type == 'attachment' || $post->post_type == 'post' ) {
        return false;
    }
    return $open;
}
//add_filter( 'comments_open', 'oa_disable_comment_status', 10 , 2 );
/* speed */

function tg_enable_strict_transport_security_hsts_header_wordpress() {
    header( 'Content-Security-Policy: default-src https:' );
}
// add_action( 'send_headers', 'tg_enable_strict_transport_security_hsts_header_wordpress' );

/* emma - product recommeder */
add_filter( 'facetwp_query_args', function( $query_args, $class ) {
	
    $check = false;
    $locking_for = '';
    $that_is = '';
    $price = '';
    $ajax_params = $class->ajax_params['facets'];   
    if (isset($class->ajax_params['facets'])) {
    	foreach ($ajax_params as $key => $item) {
			if (isset($item['facet_name']) && $item['facet_name'] == 'looking_for') {
				$locking_for = $item['selected_values'][0];
			}
			if (isset($item['facet_name']) && $item['facet_name'] == 'that_is') {
				$that_is = $item['selected_values'][0];
			}
			if (isset($item['facet_name']) && $item['facet_name'] == 'my_price_point_is') {
				$price = $item['selected_values'][0];
			}
	}
    	
    }
    if (!empty($locking_for) || !empty($that_is) || !empty($price)) {
    	$query_args['tax_query'] = array();
    }
    
    if (isset($class->ajax_params['http_params'])) {
    	$ajax_params = $class->ajax_params['http_params']['url_vars'];
		
		foreach ($ajax_params as $key => $items) {		
			if ($key == 'looking_for' ) {
					$locking_for = $items[0];
				}
				if ($key == 'that_is' ) {
					$that_is = $items[0];
				}
				if ($key == 'my_price_point_is' ) {
					$price = $items[0];
				}
		}

    }
    if (!empty($locking_for) && !empty($that_is))  {
    	//$query_args['fields'] => 'ids',
    	$query_args['tax_query'] = array(
    		'relation' => 'AND',

    	);
    }
    if (!empty($locking_for) )  {
    		$query_args['tax_query'][] =     		
            array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => array($locking_for)
        );
            
        
    }
    if (!empty($that_is) )  {
    		$query_args['tax_query'][] =     		
            array(
            'taxonomy' => 'product_tag',
            'field'    => 'slug',
            'terms'    => array($that_is)
        );
            
        
    }

    if (!empty($price)) {
    	$price_range = explode("-", $price);
			$query_args['meta_query'][] = array(
							        'key' 		=> '_price',
							        'type'    	=> 'NUMERIC',
							        'value' 	=> $price_range,
							        'compare' 	=> 'BETWEEN'
							    );
		}   
		 /*$query_args['posts_per_page'] = -1;
		 $query_args['fields'] = 'ids';
		 $posts = get_posts ($query_args);
		 foreach ($posts as $key => $id) {
		 	echo $id.'<br/>';
		 }*/
		//debug(get_posts ($query_args));
		//debug(get_product_filter());

    return $query_args;
}, 20, 2 );
/* end emma - product recommeder */


//////////////////////////////////////////////////////////////////////////
/* import/export csv product */
function custom_wp_loaded(){
	prepare_add_taxonomy_column_to_importer();
	prepare_taxonomy_add_export_column();
	prepare_taxonomy_add_export_data();
}
add_action("wp_loaded","custom_wp_loaded");
/**
 *
 *
 * @param [type] $temp_list_name
 * @param [type] $term
 * @param [type] $taxonomy
 * @return void
 */
function encode_list_term_name(&$temp_list_name,$term,$taxonomy){
	$temp_term  = get_term($term,$taxonomy);
	$temp_name = array();
	if($temp_term->parent){
		encode_list_term_name($temp_list_name,$temp_term->parent,$taxonomy);
	}
	array_push($temp_list_name,$temp_term->name);
}
/**
 * get term ids with hierarchical term of taxonomy
 *
 * 	example
 *  term - term 1 - term 2 - term 3
 *  term - term 1 - term 2 - term 4
 * @param array $temp_list_name
 * @param string $taxonomy
 * @return array term ids
 */
function get_list_term_id($term_ids,$term_name,$taxonomy){
	$temp_term_ids = array();
	foreach($term_ids as $term_id){
		$args = array(
			"taxonomy"=>$taxonomy,
			"name"=>$term_name,
			"parent"=>$term_id,
			'hide_empty' => false,
		);
		$terms = get_terms($args);
		foreach($terms as $term){
			array_push($temp_term_ids,$term->term_id);
		}
	}
	return $temp_term_ids;
}
/**
 * get term ids with $temp_list_name
 *
 * @param array $temp_list_name Hierarchical with parent > parent > current term
 * @param string $taxonomy
 * @return void
 */
function decode_list_term_name($temp_list_name,$taxonomy){
	$term_ids = array(0);
	while(count($temp_list_name) > 0){
		$term_name = array_shift($temp_list_name);
		$term_ids = get_list_term_id($term_ids,$term_name,$taxonomy);
	}
	return $term_ids;
}


function add_export_data( $value, $product, $taxonomy_key) {
	// $value = $product->get_meta( 'custom_column', true, 'edit' );
	$terms = get_the_terms($product->get_id(),$taxonomy_key);
	$value = array();
	if($terms){
		foreach($terms as $term_value){
			$temp_list_name = array();
			encode_list_term_name($temp_list_name,$term_value,$taxonomy_key);
			$temp_name = implode(" > ",$temp_list_name);
			array_push($value,$temp_name);
			// vdump($term_value->parent);
		}
	}
	return implode(", ",$value);
}

function prepare_taxonomy_add_export_data(){
	$list_taxonomy = list_taxonomy_custom_taxonomy();
	foreach($list_taxonomy as $taxonomy_key => $taxonomy_value){
		add_filter( 'woocommerce_product_export_product_column_'.$taxonomy_key, 'add_export_data', 10, 3 );
	}
}

function prepare_taxonomy_add_export_column(){

		function add_export_column( $columns ) {
		$list_taxonomy = list_taxonomy_custom_taxonomy();
			foreach($list_taxonomy as $taxonomy_key => $taxonomy_value){
				$columns[$taxonomy_key] = $taxonomy_value;
			}
			return $columns;
		}
		add_filter( 'woocommerce_product_export_column_names', 'add_export_column' );
		add_filter( 'woocommerce_product_export_product_default_columns', 'add_export_column' );
}
function prepare_add_taxonomy_column_to_importer(){
	add_filter( 'woocommerce_csv_product_import_mapping_options', 'add_column_to_importer' );
	add_filter( 'woocommerce_csv_product_import_mapping_default_columns', 'add_column_to_mapping_screen' );
	add_filter( 'woocommerce_product_import_inserted_product_object', 'process_import', 10, 2 );
}

function add_column_to_importer( $options ) {
	$list_taxonomy = list_taxonomy_custom_taxonomy();
	foreach($list_taxonomy as $taxonomy_key => $taxonomy_value){
		$options[$taxonomy_key] = $taxonomy_value;
	}
	return $options;
}
function add_column_to_mapping_screen( $columns ) {

	// potential column name => column slug

	$list_taxonomy = list_taxonomy_custom_taxonomy();
	foreach($list_taxonomy as $taxonomy_key => $taxonomy_value){
		$taxonomy_value_ucwords = ucwords($taxonomy_value);
		$columns[$taxonomy_value_ucwords] = $taxonomy_key;
		$taxonomy_value_strtolower = strtolower($taxonomy_value);
		$columns[$taxonomy_value_strtolower] = $taxonomy_key;
	}

	return $columns;
}
function process_import( $object, $data ) {
	$list_taxonomy = list_taxonomy_custom_taxonomy();
	foreach($list_taxonomy as $taxonomy_key => $taxonomy_value){

		if(isset($data[$taxonomy_key])){
			$list_term_name = explode(",",$data[$taxonomy_key]);

			$list_term_ids = array();
			foreach($list_term_name as $term_name){
				if(empty($term_name)){
					$term_ids = array();
				}else{
					$term_name = explode(" > ",$term_name);
					$term_ids = decode_list_term_name($term_name,$taxonomy_key);
				}
				 $list_term_ids = array_merge($list_term_ids,$term_ids);
			}
			wp_set_post_terms($object->get_id(),$list_term_ids,$taxonomy_key);
		}
	}
	return $object;
}

function list_taxonomy_custom_taxonomy() {
	return  array(
		'designer_collections' => 'Designer Collections',
		'material' => 'Material',
		'occasions' => 'Occassion',
		'design' => 'Design',
        'price' => 'Price',
        'diamond-shape' => 'Diamond Shape'
	);
}

/* end import/export csv product */

add_filter( 'rocket_htaccess_mod_rewrite', '__return_false' );


/**
 * Updates .htaccess, regenerates WP Rocket config file.
 *
 * @author Caspar Hübinger
 */
function flush_wp_rocket() {

	if ( ! function_exists( 'flush_rocket_htaccess' )
	  || ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_wp_rocket' );

/**
 * Removes customizations, updates .htaccess, regenerates config file.
 *
 * @author Caspar Hübinger
 */
function deactivate() {

	// Remove all functionality added above.
	remove_filter( 'rocket_htaccess_mod_rewrite', '__return_false' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );


/*=========================== emma update csv  ========= */
function metabox_convert() {
	return array(
		'attribute_clarity' => 'clarity',
		'attribute_color' => 'color',
		'attribute_cut' => 'cut'
		);
}

add_filter( 'woocommerce_product_export_meta_value', 'custom_acf_metavalue', 10, 4 );
function custom_acf_metavalue($value, $meta, $product, $row) {
	//debug2($meta->key);
	if (array_key_exists($meta->key, metabox_convert())) {
	$p_id = $product->get_id();
		$att = get_field($meta->key,$p_id);
		if ($att) {
			return $att->name;
		}		
	}
	return $value;
}



add_filter( 'woocommerce_product_export_skip_meta_keys', 'get_meta_skip', 10, 2 );
function get_meta_skip($arr,$product) {
	$p_id = $product->get_id();
	$metas = get_post_meta($p_id);
	//$arr[] = array('_attribute_carats','_attribute_color','_attribute_clarity','_attribute_cut');
	$arr[] = '_attribute_carats';
	$arr[] = '_attribute_color';
	$arr[] = '_attribute_clarity';
	$arr[] ='_attribute_cut';
	foreach ($metas as $key=>$meta) {
		
		if (strpos($meta[0], 'field_')!== false) {
			//var_dump($meta[0]);
		    $arr[] = $key;
		}
			}
	
			$arr = array_unique($arr);

	return $arr;
}

add_filter( 'woocommerce_product_import_inserted_product_object', 'process_import2', 10, 2 );
function process_import2( $object, $data ) {	
	foreach (metabox_convert() as $key1 => $att) {
		if (array_search($key1,$data)) {
			$product_id = $object->get_id();
			
			$name = get_post_meta($product_id,$key1,true);
			$term = get_term_by('name',$name,'pa_'.$att);
			
			// var_dump('========================');

			if (!is_wp_error( $term ) && $term) {
				update_field($key1,$term->term_id,$product_id);
			} 
		}
	}


	return $object;
}

/*===========================end emma update csv  ========= */

require_once ASTRA_THEME_DIR . 'func-custom/import_and_export_product_custom_fields.php';
require_once ASTRA_THEME_DIR . 'func-custom/custom_class.php';
require_once ASTRA_THEME_DIR . 'customiser/customiser.php';
require_once ASTRA_THEME_DIR . 'func-custom/import-product/import-products.php';

/* function rocket_loader_attributes( $url )
{
    
    $ignore = array (
        'https://love-and-co.com/wp-includes/js/jquery/jquery.js?ver=1.12.4-wp'
    );

    

    if ( in_array( $url, $ignore ) )
    { 
        return "$url' data-cfasync='false";
    }

    return $url;
}*/
//gravity_form_enqueue_scripts( 4, true );
/*add_filter( 'clean_url', 'rocket_loader_attributes', 11, 1 );
    add_filter( 'script_loader_tag', function ( $tag, $handle ) {
    	
		if(!is_user_logged_in()){
			
		
			if ( strpos( $tag, "frontend-modules.min" )) {
				return str_replace( ' src', ' data-cfasync="true"  src', $tag );
			} 

			if ( strpos( $tag, "frontend.min" )) {
				return str_replace( ' src', ' data-cfasync="true" defer src', $tag );
			} 


			
		}
        return $tag;
    }, 10, 2 );*/



add_filter( 'login_redirect', function( $url, $query, $user ) {
	return home_url();
}, 10, 3 );

add_action('admin_head', 'add_admin_css');
	function add_admin_css() {?>
	<style>
		#posts-filter table.wp-list-table .column-name {
		   width: 22% !important;
		}
	</style>
	<?php
	}

//var_dump(attachment_url_to_postid( 'https://phase2.love-and-co.com/ebase-uploads/2021/07/Round_WG_Double_Pave_SVR081_B.jpg' ));

/*add_filter('woocommerce_hidden_order_itemmeta', function($metas) {
	global $order;
	$extra_metas = array(
		'pa_shapes',
		'pa_diamond-type',
		'pa_casing',
		'pa_metal-type'
	);


	return array_merge($metas, $extra_metas);
}, 99, 1);*/

add_action( 'woocommerce_checkout_update_order_meta', function($order_id ) {
	global $wpdb;

	$ring_name = 'engagement-rings';

	$order = wc_get_order( $order_id  );

	if( ! empty($order) ) {
		$isRing = false;
		foreach ( $order->get_items() as $item_id => $item ) {
			$product_id = $item->get_product_id();

			$term_list = wp_get_post_terms( $product_id, 'product_cat', array( 'fields' => 'slugs' ) );

			if( in_array($ring_name, $term_list) ) {
				$isRing = true;
			}
		}

		if( ! empty($isRing) ) {
			$line_items_shippings = $order->get_items( 'shipping' );

			if( ! empty($line_items_shippings) ) {
				foreach( $line_items_shippings as $shipping_id => $shipping ) {
					if( $shipping->get_method_id() == 'free_shipping' ) {
						$item = $wpdb->get_row($wpdb->prepare(
							"SELECT * FROM {$wpdb->prefix}woocommerce_order_items WHERE order_id = %d AND order_item_type = %s",
							$order->get_id(),
							'shipping'
						));

						if( ! empty($item) ) {
							$wpdb->update( $wpdb->prefix . 'woocommerce_order_items', array(
								'order_item_name' => new_title_shipping(date_shipping_diamond())
							), array(
								'order_item_id' => $item->order_item_id
							));
						}
					}
				}
			}
		}
	}
});

add_filter( 'woocommerce_product_export_product_column_description', 'woocommerce_product_export_product_column_description', 10, 2 );
function woocommerce_product_export_product_column_description($value,$product) {
	
	return html_entity_decode(strip_tags($product->description));
}

add_filter( 'woocommerce_product_export_product_column_short_description', 'change_short_description', 10, 2 );
function change_short_description( $value, $product ) {   
	return html_entity_decode(strip_tags($product->short_description));
}