<?php



/**
 * Register Currency Control.
 *
 * Include control file and register control class.
 *
 * @since 1.0.0
 * @param \Elementor\Controls_Manager $controls_manager Elementor controls manager.
 * @return void
 */
function register_faq_widget( $controls_manager ) {
    require_once get_template_directory() . '/shortcode/elementor-faq-widget.php';
    require_once get_template_directory() . '/shortcode/elementor-featured-widget.php';
    require_once get_template_directory() . '/shortcode/elementor-single-detail-widget.php';
    require_once get_template_directory() . '/shortcode/elementor-product-images-widget.php';
    require_once get_template_directory() . '/shortcode/elementor-term-widget.php';

	\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_FAQ_Widget() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_Featured_Widget() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_Single_Detail_Widget() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_Product_Image_Widget() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_Term_Widget() );
}

add_action( 'elementor/widgets/widgets_registered', 'register_faq_widget' );