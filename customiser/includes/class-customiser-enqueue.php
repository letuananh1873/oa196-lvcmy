<?php
class Customiser_enqueue {
    function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'add_enqueue']);
    }

    function add_enqueue() {
        if(is_page(array('name-customiser', 'my-creations'))) {
            wp_enqueue_style('name-customiser', get_template_directory_uri() . '/customiser/assets/css/customiser.css', array(), date('h:m:i'));
        } 
        if(is_page('name-customiser'))  {
            wp_enqueue_script('name-customiser', get_template_directory_uri() . '/customiser/assets/js/customiser.js', array('jquery'), date('h:m:i'), true);
            wp_localize_script( 'name-customiser', 'customiser_script', array( 
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'customiser_page' => home_url('/'.PAGE_NAME.'/'),
                'domain' => home_url()
            ));
        }

    }
}

new Customiser_enqueue;