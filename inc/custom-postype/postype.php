<?php
function cptui_register_my_cpts() {

	/**
	 * Post Type: Reviews.
	 */

	$labels = [
		"name" => __( "Reviews", "astra" ),
		"singular_name" => __( "Review", "astra" ),
	];

	$args = [
		"label" => __( "Reviews", "astra" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "customer_review", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "thumbnail", "custom-fields" ],
	];

	register_post_type( "customer_review", $args );

	/**
	 * Post Type: Stores.
	 */

	$labels = [
		"name" => __( "Stores", "astra" ),
		"singular_name" => __( "Store", "astra" ),
	];

	$args = [
		"label" => __( "Stores", "astra" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "store_locator", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "thumbnail" ],
		"taxonomies" => [ "store_location" ],
	];

	register_post_type( "store_locator", $args );

	/**
	 * Post Type: Blogs.
	 */

	$labels = [
		"name" => __( "Blogs", "astra" ),
		"singular_name" => __( "Blog", "astra" ),
	];

	$args = [
		"label" => __( "Blogs", "astra" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "blogs", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "thumbnail", "custom-fields" ],
	];

	register_post_type( "blogs", $args );

	/**
	 * Post Type: News & Media.
	 */

	$labels = [
		"name" => __( "News & Media", "astra" ),
		"singular_name" => __( "News & Media", "astra" ),
	];

	$args = [
		"label" => __( "News & Media", "astra" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "news_media", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "custom-fields" ],
	];

	register_post_type( "news_media", $args );

	/**
	 * Post Type: Instagram Photos.
	 */

	$labels = [
		"name" => __( "Instagram Photos", "astra" ),
		"singular_name" => __( "Instagram Photo", "astra" ),
	];

	$args = [
		"label" => __( "Instagram Photos", "astra" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "instagram_photos", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "custom-fields" ],
	];

	register_post_type( "instagram_photos", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );
