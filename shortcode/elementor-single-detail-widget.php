<?php
class Elementor_Single_Detail_Widget extends \Elementor\Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'alt-single-detail';
	}

	public function get_title() {
		return esc_html__( 'ALT - Single Detail', 'elementor-currency-control' );
	}

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Settings', 'wolfactive-extend-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
			'booking_appointment',
			[
				'label' => __( 'Book Appointment', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Disable', 'elementor-pro' ),
				'label_off' => __( 'Enable', 'elementor-pro' ),
				'render_type' => 'template',
				'return_value' => 'yes',
				'default' => '',
				'prefix_class' => '',
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

        include get_template_directory() . '/template-parts/woocommerce/single-product-detail.php';

		if( ! empty($settings['booking_appointment']) && $settings['booking_appointment'] == 'yes' ) {
		?>
		<script>
			var buttonBooking = document.getElementById('alt-button-book-appointment');
			if( buttonBooking ) {
				console.log('buttonBooking');
				buttonBooking.style.display = 'none';
			}
		</script>
		<?php
		}

	}
}
