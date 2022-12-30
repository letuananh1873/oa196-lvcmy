<?php
class Elementor_Featured_Widget extends \Elementor\Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
  
		wp_register_style( 'style-handle', ALT_SWATCHES_URL . 'vendor/owl.carousel.min.css');
		wp_register_script( 'script-handle', ALT_SWATCHES_URL . 'vendor/owl.carousel.min.js', [ 'elementor-frontend' ], '1.0.0', true );
	}

	public function get_script_depends() {
		return [ 'script-handle' ];
	} 

	public function get_style_depends() {
		return [ 'style-handle' ];
	}

	public function get_name() {
		return 'alt-featured';
	}

	public function get_title() {
		return esc_html__( 'ALT Featured', 'elementor-currency-control' );
	}

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'wolfactive-extend-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->add_responsive_control(
			'per_page',
			[
				'label' => esc_html__( 'Per Page', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 5,
				'step' => 1,
				'default' => 4,
				'devices' => [ 'desktop', 'tablet', 'mobile' ]
			]
		);

		$this->add_control(
			'limit', [
				'label' => esc_html__( 'Limit', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
			]
		);

        $this->end_controls_section();
    }

	/**
	 * Render currency widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		wp_reset_query();
		wp_reset_postdata();
		global $post;

		$settings = $this->get_settings_for_display();

		$per_page = isset($settings['per_page']) ? absint($settings['per_page']) : 4;
		$per_page_tablet = isset($settings['per_page_tablet']) ? absint($settings['per_page_tablet']) : 2;
		$per_page_mobile = isset($settings['per_page_mobile']) ? absint($settings['per_page_mobile']) : 1;

        $json_config = '{
            "per_page" : ' . $per_page . ',
            "slides_to_show_tablet" : ' . $per_page_tablet . ',
            "slides_to_show_mobile" : ' . $per_page_mobile . '
        }';





		$terms = get_the_terms($post->ID, 'designer_collections');

		$new_terms = array();
		if( ! empty($terms) ) {
			foreach( $terms as $term ) {
				$new_terms[] = $term->slug;
			}
		}

		$args2 = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'post__not_in' => array($post->ID),
			'tax_query'      => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => array('outofstock'),
					'operator' => 'NOT IN'
				),
				array(
					'taxonomy' => 'designer_collections',
					'field'    => 'slug',
					'terms'    => $new_terms,
					//'operator' => 'LIKE'
				),
			),
			'posts_per_page' => $settings['limit']
		);

		


		$loop = new WP_Query($args2);
		// if( isset($_GET['altdev']) ) {
		// 	echo '<pre>';
		// 	var_dump($args2);
		// 	echo '</pre>';
		// 	$latest_books = get_posts( $args2 );
		// 	foreach ($latest_books as $post_item) {
		// 		var_dump($post_item->post_title);
		// 		echo '<br/>';
		// 	}
			
		// }

		if($loop->have_posts()) {
		?>
		<div class="alt-product-featured">
			<div class="alt-product-featured-heading">
				<h3><?php echo esc_attr( $settings['title'] );?></h3>

				<div class="alt-product-featured-nav">
					<button class="alt-product-featured-nav-prev"><img src="<?php echo get_template_directory_uri();?>/assets/images/arrow-left.svg" /></button>
					<button class="alt-product-featured-nav-next"><img src="<?php echo get_template_directory_uri();?>/assets/images/arrow-right.svg" /></button>
				</div>
			</div>

			<div class="alt-product-featured-slider-wrapper">
				<div class="alt-product-featured-slider owl-carousel" data-config='<?php echo esc_attr($json_config); ?>'>
					<?php while ($loop->have_posts()) : $loop->the_post();
					$product = wc_get_product($post->ID);
					
					$stock_quantity = $product->get_stock_quantity();
					$attachment_ids = $product->get_gallery_image_ids();
					$thumbnail_id = $product->get_image_id();?>
					<div class="alt-product-featured-slider-item yyyyyyyy">
						<a href="<?php echo esc_url(get_permalink($product->get_id()));?>" class="product-thumbnail">
							<img src="<?php echo esc_url( wp_get_attachment_image_url($thumbnail_id, 'full') );?>" class="alt-product-featured-slider-thumbnail-main" />
							<?php
							if( ! empty($attachment_ids[0]) ) {
								printf(
									'<img src="%s" class="alt-product-featured-slider-thumbnail-hover" />',
									esc_url( wp_get_attachment_image_url($attachment_ids[0], 'full') )
								);
							}else {
								printf(
									'<img src="%s" class="alt-product-featured-slider-thumbnail-hover" />',
									esc_url( wp_get_attachment_image_url($thumbnail_id, 'full') )
								);
							}?>
						</a>

						<h3 itemprop="name"><a href="<?php echo esc_url(get_permalink($product->get_id()));?>"><?php echo $post->post_title;?></a></h3>
						<!--<p class="product-excerpt"><?php echo get_the_excerpt();?></p>-->
						<p class="product-price"><?php echo $product->get_price_html();?></span></p>
						<?php
						// if( $product->is_in_stock() ) {
						// 	if( $stock_quantity < 5) {
						// 		echo '<div class="product-badge">Low Stock</div>';
						// 	}
						// }else {
						// 	echo '<div class="product-badge">Sold Out</div>';
						// }
						
						?>
						
					</div>
					<?php endwhile;?>
				</div>
			</div>
		</div>

		<script>
			var url_sheet = '<?php echo get_template_directory_uri();?>/';
		</script>
		<?php
		}
		wp_reset_postdata();
	}
}
