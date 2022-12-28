<?php
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