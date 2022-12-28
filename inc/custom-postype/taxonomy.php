<?php
function cptui_register_my_taxes_store_location() {

	/**
	 * Taxonomy: Store Locations.
	 */

	$labels = [
		"name" => __( "Store Locations", "astra" ),
		"singular_name" => __( "Store Location", "astra" ),
	];

	$args = [
		"label" => __( "Store Locations", "astra" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'store_location', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "store_location",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		];
	register_taxonomy( "store_location", [ "store_locator" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_store_location' );

function cptui_register_my_taxes_blog_cate() {

	/**
	 * Taxonomy: Blog Categories.
	 */

	$labels = [
		"name" => __( "Blog Categories", "astra" ),
		"singular_name" => __( "Blog Category", "astra" ),
	];

	$args = [
		"label" => __( "Blog Categories", "astra" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'blog_cate', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "blog_cate",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		];
	register_taxonomy( "blog_cate", [ "blogs" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_blog_cate' );


function cptui_register_my_taxes_review_stars() {

	/**
	 * Taxonomy: Stars.
	 */

	$labels = [
		"name" => __( "Stars", "astra" ),
		"singular_name" => __( "Star", "astra" ),
	];

	$args = [
		"label" => __( "Stars", "astra" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'review_stars', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "review_stars",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		];
	register_taxonomy( "review_stars", [ "customer_review" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_review_stars' );


function cptui_register_my_taxes_designer_collections() {

	/**
	 * Taxonomy: Designer Collections.
	 */

	$labels = [
		"name" => __( "Designer Collections", "astra" ),
		"singular_name" => __( "Designer Collection", "astra" ),
	];

	$args = [
		"label" => __( "Designer Collections", "astra" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'designer_collections', 'with_front' => true,  'hierarchical' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "designer_collections",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		];
	register_taxonomy( "designer_collections", [ "product" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_designer_collections' );


function cptui_register_my_taxes_material() {

	/**
	 * Taxonomy: Materials.
	 */

	$labels = [
		"name" => __( "Materials", "astra" ),
		"singular_name" => __( "Material", "astra" ),
	];

	$args = [
		"label" => __( "Materials", "astra" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'material', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "material",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		];
	register_taxonomy( "material", [ "product" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_material' );


function cptui_register_my_taxes_occasions() {

	/**
	 * Taxonomy: Occasions.
	 */

	$labels = [
		"name" => __( "Occasions", "astra" ),
		"singular_name" => __( "Occasions", "astra" ),
	];

	$args = [
		"label" => __( "Occasions", "astra" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'occasions', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "occasions",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		];
	register_taxonomy( "occasions", [ "product" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_occasions' );
/* emma add color taxonomy */
function cptui_register_my_taxes_color() {

	/**
	 * Taxonomy: Color.
	 */

	$labels = [
		"name" => __( "Color", "astra" ),
		"singular_name" => __( "Color", "astra" ),
	];

	$args = [
		"label" => __( "Color", "astra" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'colour', 'with_front' => true, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"rest_base" => "colour",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => true,
		];
	register_taxonomy( "colour", [ "product" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_color' );


/* emma add color taxonomy */
