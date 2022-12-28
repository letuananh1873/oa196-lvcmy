<?php
class Custom_core {
    function __construct() {
        add_action('init', [$this, 'create_product_taxonomy']);
        add_action( 'woocommerce_product_query', [$this, 'hidden_name_necklace_in_shop_page'] );     
        add_action('wp', [$this, 'my_creations_page_check_logged_in']);
    }
    
    public function create_product_taxonomy() {
        $labels = array(
            'name' => _x( 'Name Necklace', 'taxonomy general name' ),
            'singular_name' => _x( 'Name Necklace', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Name Necklace' ),
            'all_items' => __( 'All Name Necklace' ),
            'parent_item' => __( 'Parent Name Necklace' ),
            'parent_item_colon' => __( 'Parent Name Necklace:' ),
            'edit_item' => __( 'Edit Name Necklace' ), 
            'update_item' => __( 'Update Name Necklace' ),
            'add_new_item' => __( 'Add New Name Necklace' ),
            'new_item_name' => __( 'New Name Necklace Name' ),
            'menu_name' => __( 'Name Necklace' ),
          );    
         
          register_taxonomy('name_necklace',array('product'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'name_necklace' ),
          ));
         
    }

    function hidden_name_necklace_in_shop_page( $q ) {

        $tax_query = (array) $q->get( 'tax_query' );
    
        $tax_query[] = array(
               'taxonomy' => 'name_necklace',
               'field' => 'slug',
               'terms' => array( 'birthstone','design-name-necklace' ), // Don't display products in the clothing category on the shop page.
               'operator' => 'NOT IN'
        );
        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => array( 'engagement-rings' ), // Don't display products in the clothing category on the shop page.
            'operator' => 'NOT IN'
        );
        $q->set( 'tax_query', $tax_query );
    
    }

    function my_creations_page_check_logged_in() {
        if ( !is_user_logged_in() && is_page(CREATION_PAGE_SLUG) ) {
            wp_redirect(home_url('/login'));
            exit;
        }
    }
}
new Custom_core;