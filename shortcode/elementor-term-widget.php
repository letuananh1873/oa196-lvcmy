<?php
class Elementor_Term_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'alt-term';
	}

	public function get_title() {
		return esc_html__( 'ALT Term', 'elementor-currency-control' );
	}
	
	protected function _register_controls() {

	    $data_taxs = [];
	    $taxonomies = get_object_taxonomies( 'product' );
	    foreach( $taxonomies as $taxonomy ){
	        if( ! preg_match('/^pa_(.*)/', $taxonomy) ) {
                $tax = get_taxonomy( $taxonomy );
                
                if( $tax->public ) {
                    $data_taxs[$taxonomy] = $tax->label;
                }
	        }
	    }
	    
	    
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'taxonomy',
			[
				'label' => esc_html__( 'Taxonomy', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $data_taxs,
			]
		);
		
		$this->add_responsive_control(
			'text_align',
			[
				'label' => esc_html__( 'Alignment', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'plugin-name' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'plugin-name' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'plugin-name' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'toggle' => true,
        		'selectors' => [
        			'{{WRAPPER}}' => 'text-align: {{VALUE}};',
        		],
        		'devices' => [ 'desktop', 'tablet', 'mobile' ]
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
	    global $post;
        
        $settings = $this->get_settings_for_display();
        
		$terms = get_the_terms( $post->ID, $settings['taxonomy'] );
		if( ! empty($terms) ) {
		    $string = [];
		    foreach( $terms as $term ) {
		        $string[] = sprintf('<a href="%s">%s</a>', get_term_link($term, $settings['taxonomy']), $term->name);
		    }
		    
		    if( ! empty($string) ) {
		        echo '<div class="alt-post-terms">' . implode(', ', $string) . '</div>';
		    }
		}
		
	}
}
