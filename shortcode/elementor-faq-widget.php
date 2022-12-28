<?php
class Elementor_FAQ_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'alt-faq';
	}

	public function get_title() {
		return esc_html__( 'ALT FAQ', 'elementor-currency-control' );
	}

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'wolfactive-extend-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title', [
				'label' => esc_html__( 'Title', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'List Title' , 'plugin-name' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_content', [
				'label' => esc_html__( 'Content', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'List Content' , 'plugin-name' ),
				'show_label' => false,
			]
		);

		$repeater->add_control(
			'list_color',
			[
				'label' => esc_html__( 'Color', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'list',
			[
				'label' => esc_html__( 'Repeater List', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => esc_html__( 'Title #1', 'plugin-name' ),
						'list_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'plugin-name' ),
					],
					[
						'list_title' => esc_html__( 'Title #2', 'plugin-name' ),
						'list_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'plugin-name' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
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
		$settings = $this->get_settings_for_display();
        if ( $settings['list'] ) {
            echo '<div class="pp-advanced-accordion">';
            foreach (  $settings['list'] as $item ) {?>
            <div class="pp-accordion-item">
                <div class="pp-accordion-tab-title elementor-repeater-item-<?php echo esc_attr( $item['_id'] );?>" data-id="pp-accordion-<?php echo esc_attr( $item['_id'] );?>">
                    <span><?php echo $item['list_title'];?></span>
                    <div class="pp-accordion-toggle-icon"> <span class="pp-accordion-toggle-icon-close pp-icon"> <i aria-hidden="true" class="fas fa-plus"></i> </span> <span class="pp-accordion-toggle-icon-open pp-icon"> <i aria-hidden="true" class="fas fa-minus"></i> </span> </div>
                </div>
                <div id="pp-accordion-<?php echo esc_attr( $item['_id'] );?>" class="pp-accordion-tab-content"><?php echo $item['list_content'];?></div>
            </div>
            <?php
            }
            echo '</div>';
        }
	}

    protected function content_template() {
		?>
		<# if ( settings.list.length ) { #>
		<div class="pp-advanced-accordion">
			<# _.each( settings.list, function( item ) { #>
            <div class="pp-accordion-item">
				<div class="pp-accordion-tab-title elementor-repeater-item-{{ item._id }}">
                    <span>{{{ item.list_title }}}</span>
                    <div class="pp-accordion-toggle-icon"> <span class="pp-accordion-toggle-icon-close pp-icon"> <i aria-hidden="true" class="fas fa-plus"></i> </span> <span class="pp-accordion-toggle-icon-open pp-icon"> <i aria-hidden="true" class="fas fa-minus"></i> </span> </div>
                </div>
				<div class="pp-accordion-tab-content">{{{ item.list_content }}}</div>
            </div>
			<# }); #>
        </div>
		<# } #>
		<?php
	}
}
