<?php
/**
 * WooCommerce CyberSource
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce CyberSource to newer
 * versions in the future. If you wish to customize WooCommerce CyberSource for your
 * needs please refer to http://docs.woocommerce.com/document/cybersource-payment-gateway/
 *
 * @author      SkyVerge
 * @copyright   Copyright (c) 2012-2020, SkyVerge, Inc. (info@skyverge.com)
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

namespace SkyVerge\WooCommerce\Cybersource\Gateway;

use SkyVerge\WooCommerce\Cybersource\Gateway;
use SkyVerge\WooCommerce\PluginFramework\v5_5_4 as Framework;

defined( 'ABSPATH' ) or exit;

/**
 * Handles the custom CyberSource payment form.
 *
 * This overrides the framework's implementation to support CyberSource Flex Microform,
 * which uses iframes for the card inputs.
 *
 * @since 2.0.0
 *
 * @method Gateway get_gateway()
 */
class Payment_Form extends Framework\SV_WC_Payment_Gateway_Payment_Form {


	/**
	 * Renders the payment form description.
	 *
	 * Adds content for easier testing in sandbox mode.
	 *
	 * @since 2.0.0
	 */
	public function render_payment_form_description() {

		parent::render_payment_form_description();

		// render a test card number in test mode when the flex form is used, since we can pre-fill it
		if ( $this->get_gateway()->is_test_environment() && $this->get_gateway()->is_flex_form_enabled() ) : ?>
				<p><?php printf( esc_html__( 'Test card number: %s', 'woocommerce-gateway-cybersource' ), '<code>4111111111111111</code>' ); ?></p>
		<?php endif;
	}


	/**
	 * Renders the payment fields.
	 *
	 * Overridden to add the hidden fields for Flex Microform tokenization.
	 *
	 * @see Framework\SV_WC_Payment_Gateway_Payment_Form::render_payment_fields()
	 *
	 * @since 2.0.0
	 */
	public function render_payment_fields() {

		$input_id = 'wc-' . $this->get_gateway()->get_id_dasherized();

		parent::render_payment_fields();

		$hidden_fields = [
			'flex-token',
			'masked-pan',
			'card-type',
			'instrument-identifier-id',
			'instrument-identifier-new',
			'instrument-identifier-state',
		];

		foreach ( $hidden_fields as $field ) {
			echo '<input type="hidden" name="' . $input_id . '-' . sanitize_html_class( $field ) . '" />';
		}

		// display a test amount field for error testing
		if ( $this->get_gateway()->is_test_environment() && ! is_add_payment_method_page() ) : ?>

			<div class="form-row form-row-wide">
				<label for="<?php echo sanitize_html_class( "{$input_id}-test-amount" ); ?>"><?php esc_html_e( 'Test Amount', 'woocommerce-gateway-cybersource' ); ?></label>
				<input type="text" id="<?php echo sanitize_html_class( "{$input_id}-test-amount" ); ?>" name="<?php echo esc_attr( "{$input_id}-test-amount" ); ?>" />
				<div style="font-size: 10px;" class="description"><?php esc_html_e( 'Enter a test amount to trigger a specific error response, or leave blank to use the order total.', 'woocommerce-gateway-cybersource' ); ?></div>
			</div>

		<?php endif;
	}


	/**
	 * Renders the payment fields.
	 *
	 * Overridden to replace the card number input with the Flex Microform container div.
	 *
	 * @since 2.0.0
	 *
	 * @param array $field payment field params
	 */
	public function render_payment_field( $field ) {

		if ( $this->get_gateway()->is_flex_form_enabled() && isset( $field['id'] ) && 'wc-cybersource-credit-card-account-number' === $field['id'] ) {

			?>
			<div class="form-row <?php echo implode( ' ', array_map( 'sanitize_html_class', $field['class'] ) ); ?>">
				<label id="<?php echo esc_attr( $field['id'] ) . '-label'; ?>" for="<?php echo esc_attr( $field['id'] ) . '-hosted'; ?>"><?php echo esc_html( $field['label'] ); if ( $field['required'] ) : ?><abbr class="required" title="required">&nbsp;*</abbr><?php endif; ?></label>
				<div id="<?php echo esc_attr( $field['id'] ) . '-hosted'; ?>" class="<?php echo implode( ' ', array_map( 'sanitize_html_class', $field['input_class'] ) ); ?>" data-placeholder="<?php echo isset( $field['placeholder'] ) ? esc_attr( $field['placeholder'] ) : ''; ?>"></div>
			</div>
			<?php

		} else {

			parent::render_payment_field( $field );
		}
	}


	/**
	 * Renders the payment form JS.
	 *
	 * Overridden to enqueue the custom CyberSource form handler.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 * @see Framework\SV_WC_Payment_Gateway_Payment_Form::render_js()
	 *
	 */
	public function render_js() {

		if ( $this->get_gateway()->is_flex_form_enabled() ) {

			try {

				$jwk = $this->get_gateway()->get_api()->generate_public_key()->get_jwk_array();

			} catch ( Framework\SV_WC_API_Exception $exception ) {

				// TODO: log/display an error

				return;
			}

			$url = $this->get_gateway()->is_production_environment() ?
				'https://flex.cybersource.com/cybersource/assets/microform/0.4/flex-microform.min.js' :
				'https://testflex.cybersource.com/cybersource/assets/microform/0.4/flex-microform.min.js';
			wp_enqueue_script( 'wc-cybersource-flex-microform', $url, [], null );

			$args = [
				'plugin_id'               => $this->get_gateway()->get_plugin()->get_id(),
				'id'                      => $this->get_gateway()->get_id(),
				'id_dasherized'           => $this->get_gateway()->get_id_dasherized(),
				'type'                    => $this->get_gateway()->get_payment_type(),
				'csc_required'            => $this->get_gateway()->csc_enabled(),
				'csc_required_for_tokens' => $this->get_gateway()->csc_enabled_for_tokens(),
				'general_error'           => __( 'An error occurred, please try again or try an alternate form of payment.', 'woocommerce-gateway-authorize-net-cim' ),
				'jwk'                     => $jwk,
				'placeholder'             => '•••• •••• •••• ••••',
				'styles'                  => [
					'input' => [
						'font-size'   => '1.5em',
						'font-weight' => '400',
						'color'       => '#43454b',
					]
				]
			];

			if ( $this->get_gateway()->supports_card_types() ) {
				$args['enabled_card_types'] = array_map( [ Framework\SV_WC_Payment_Gateway_Helper::class, 'normalize_card_type' ], $this->get_gateway()->get_card_types() );
			}

			/**
			 * Payment Gateway Payment Form JS Arguments Filter.
			 *
			 * Filter the arguments passed to the Payment Form handler JS class
			 *
			 * @since 2.0.0
			 *
			 * @param array $result {
			 *   @type string $plugin_id plugin ID
			 *   @type string $id gateway ID
			 *   @type string $id_dasherized gateway ID dasherized
			 *   @type string $type gateway payment type (e.g. 'credit-card')
			 *   @type bool $csc_required true if CSC field display is required
			 *   @type bool $csc_required_for_tokens true if CSC field display is required for saved payment methods
			 *   @type string $general_error general error message
			 *   @type array $jwk used by CyberSource Flex Microform setup (do not change this)
			 *   @type string $placeholder credit card number input placeholder
			 *   @type array $styles styles to be applied to CyberSource Flex Microform (@see https://developer.cybersource.com/api/developer-guides/dita-flex/SAFlexibleToken/FlexMicroform/Styling.html)
			 * }
			 * @param Payment_Form $this payment form instance
			 */
			$args = apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_js_args', $args, $this );

			wc_enqueue_js( sprintf( 'window.wc_%s_payment_form_handler = new WC_Cybersource_Payment_Form_Handler( %s );', esc_js( $this->get_gateway()->get_id() ), json_encode( $args ) ) );

		} else {
			parent::render_js();
		}
	}


}
