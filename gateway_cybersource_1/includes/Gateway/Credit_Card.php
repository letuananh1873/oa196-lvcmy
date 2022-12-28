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

use SkyVerge\WooCommerce\Cybersource\API\Helper;
use SkyVerge\WooCommerce\Cybersource\Gateway;
use SkyVerge\WooCommerce\Cybersource\Cybersource_Sign;
use SkyVerge\WooCommerce\Cybersource\Plugin;
use SkyVerge\WooCommerce\PluginFramework\v5_5_4 as Framework;
use SkyVerge\WooCommerce\PluginFramework\v5_5_4\SV_WC_Payment_Gateway_Apple_Pay_Payment_Response;

defined( 'ABSPATH' ) or exit;

/**
 * CyberSource Credit Card Gateway Class
 *
 * @since 3.0.0
 */
class Credit_Card extends Gateway {


	/** @var string whether hosted tokenization (Flex Microform) is enabled, 'yes' or 'no' */
	protected $hosted_tokenization;

	/**
	 * Constructs the gateway.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

		$card_type_options    = [];
		$supported_card_types = [
			Framework\SV_WC_Payment_Gateway_Helper::CARD_TYPE_VISA,
			Framework\SV_WC_Payment_Gateway_Helper::CARD_TYPE_MASTERCARD,
			Framework\SV_WC_Payment_Gateway_Helper::CARD_TYPE_AMEX,
			Framework\SV_WC_Payment_Gateway_Helper::CARD_TYPE_DISCOVER,
			Framework\SV_WC_Payment_Gateway_Helper::CARD_TYPE_DINERSCLUB,
			Framework\SV_WC_Payment_Gateway_Helper::CARD_TYPE_MAESTRO,
			Framework\SV_WC_Payment_Gateway_Helper::CARD_TYPE_JCB,
		];

		foreach ( $supported_card_types as $type ) {
			$card_type_options[ $type ] = Framework\SV_WC_Payment_Gateway_Helper::payment_type_to_name( $type );
		}

		parent::__construct(
			Plugin::CREDIT_CARD_GATEWAY_ID,
			wc_cybersource(),
			[
				'method_title'       => __( 'CyberSource Credit Card', 'woocommerce-gateway-cybersource' ),
				'method_description' => __( 'Allow customers to securely pay using their credit cards with CyberSource.', 'woocommerce-gateway-cybersource' ),
				'supports'           => [
					self::FEATURE_PRODUCTS,
					self::FEATURE_CARD_TYPES,
					// self::FEATURE_PAYMENT_FORM, 
					self::FEATURE_CREDIT_CARD_CHARGE,
					self::FEATURE_CREDIT_CARD_CHARGE_VIRTUAL,
					self::FEATURE_CREDIT_CARD_AUTHORIZATION,
					// self::FEATURE_CREDIT_CARD_CAPTURE,
					self::FEATURE_DETAILED_CUSTOMER_DECLINE_MESSAGES,
					// self::FEATURE_REFUNDS,
					// self::FEATURE_VOIDS, 
					self::FEATURE_ADD_PAYMENT_METHOD, 
					// self::FEATURE_APPLE_PAY,
				],
				'environments' => [
					self::ENVIRONMENT_PRODUCTION => esc_html_x( 'Production', 'software environment', 'woocommerce-gateway-cybersource' ),
					self::ENVIRONMENT_TEST       => esc_html_x( 'Test', 'software environment', 'woocommerce-gateway-cybersource' ),
				],
				'payment_type' => self::PAYMENT_TYPE_CREDIT_CARD,
				'card_types'   => $card_type_options,
			]
		);
	}


	/**
	 * Gets the order with Apple Pay data attached.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 * @param SV_WC_Payment_Gateway_Apple_Pay_Payment_Response $response
	 * @return \WC_Order
	 */
	public function get_order_for_apple_pay( \WC_Order $order, SV_WC_Payment_Gateway_Apple_Pay_Payment_Response $response ) {

		$order = parent::get_order_for_apple_pay( $order, $response );

		$order->payment->apple_pay = base64_encode( json_encode( $response->get_payment_data() ) );

		return $order;
	}


	/**
	 * Gets the payment form handler instance.
	 *
	 * @since 2.0.0
	 *
	 * @return Payment_Form
	 */
	public function get_payment_form_instance() {

		return new Payment_Form( $this );
	}


	/**
	 * Gets the payment method defaults.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	public function get_payment_method_defaults() {

		$defaults = parent::get_payment_method_defaults();

		if ( $this->is_test_environment() ) {
			$defaults['account-number'] = '41111111111111111';
		}

		return $defaults;
	}


	/**
	 * Validates the credit card number.
	 *
	 * Bypass credit card number validation if Flex Microform is enabled.
	 *
	 * @since 2.0.0
	 *
	 * @param string $account_number account number to validate
	 * @return bool
	 */
	protected function validate_credit_card_account_number( $account_number ) {

		if ( $this->is_flex_form_enabled() ) {
			$is_valid = (bool) Framework\SV_WC_Helper::get_posted_value( 'wc-' . $this->get_id_dasherized() . '-flex-token' );
		} else {
			$is_valid = parent::validate_credit_card_account_number( $account_number );
		}

		return $is_valid;
	}


	/**
	 * Gets an order with payment data added.
	 *
	 * @since 2.0.0
	 *
	 * @param int $order_id order ID
	 * @return \WC_Order $order order object
	 */
	public function get_order( $order_id ) {

		$order = parent::get_order( $order_id );

		if ( empty( $order->payment->token ) && $this->is_flex_form_enabled() ) {

			$order->payment->js_token       = Framework\SV_WC_Helper::get_posted_value( 'wc-' . $this->get_id_dasherized() . '-flex-token' );
			$order->payment->account_number = Framework\SV_WC_Helper::get_posted_value( 'wc-' . $this->get_id_dasherized() . '-masked-pan' );
			$order->payment->last_four      = substr( $order->payment->account_number, -4 );
			$order->payment->first_six      = substr( $order->payment->account_number, 0, 6 );

			if ( $code = Framework\SV_WC_Helper::get_posted_value( 'wc-' . $this->get_id_dasherized() . '-card-type' ) ) {
				$order->payment->card_type = Helper::convert_code_to_card_type( $code );
			}

			$order->payment->instrument_identifier = new \stdClass();

			$order->payment->instrument_identifier->id    = Framework\SV_WC_Helper::get_posted_value( 'wc-' . $this->get_id_dasherized() . '-instrument-identifier-id' );
			$order->payment->instrument_identifier->new   = 'Y' === Framework\SV_WC_Helper::get_posted_value( 'wc-' . $this->get_id_dasherized() . '-instrument-identifier-new' );
			$order->payment->instrument_identifier->state = Framework\SV_WC_Helper::get_posted_value( 'wc-' . $this->get_id_dasherized() . '-instrument-identifier-state' );

			// handle single expiry field formatted like "MM / YY" or "MM / YYYY"
			if ( Framework\SV_WC_Helper::get_posted_value( 'wc-' . $this->get_id_dasherized() . '-expiry' ) ) {
				list( $order->payment->exp_month, $order->payment->exp_year ) = array_map( 'trim', explode( '/', Framework\SV_WC_Helper::get_posted_value( 'wc-' . $this->get_id_dasherized() . '-expiry' ) ) );
			}
		}

		// if testing and a specific amount was set
		if ( $this->is_test_environment() && $test_amount = Framework\SV_WC_Helper::get_posted_value( 'wc-' . $this->get_id_dasherized() . '-test-amount' ) ) {
			$order->payment_total = Framework\SV_WC_Helper::number_format( $test_amount );
		}

		return $order;
	}


}
