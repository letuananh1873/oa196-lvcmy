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

namespace SkyVerge\WooCommerce\Cybersource\API\Requests\Payments;

defined( 'ABSPATH' ) or exit;

class Credit_Card_Payment extends Payment {


	/** auth and capture transaction type */
	const AUTHORIZE_AND_CAPTURE = true;

	/** authorize-only transaction type */
	const AUTHORIZE_ONLY = false;


	/**
	 * Creates a credit card charge request.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 */
	public function create_credit_card_charge( \WC_Order $order ) {

		$this->create_payment( $order, self::AUTHORIZE_AND_CAPTURE );
	}


	/**
	 * Creates a credit card auth request.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 */
	public function create_credit_card_auth( \WC_Order $order ) {

		$this->create_payment( $order, self::AUTHORIZE_ONLY );
	}


	/**
	 * Gets the payment information.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	protected function get_payment_information() {

		$data = parent::get_payment_information();

		if ( ! empty( $data['customer']['customerId'] ) && ! empty( $this->get_order()->payment->csc ) ) {

			$data['card'] = [
				'securityCode' => $this->get_order()->payment->csc,
			];
		}

		return $data;
	}


	/**
	 * Gets the payment method data.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	protected function get_payment_data() {

		$payment = $this->get_order()->payment;

		if ( ! empty( $this->get_order()->payment->apple_pay ) ) {

			$data = [
				'fluidData' => [
					'value' => $this->get_order()->payment->apple_pay,
				],
			];

		} else {

			$data = [
				'card' => [
					'expirationYear'  => "",
					'number'          => "",
					'securityCode'    => '',
					'expirationMonth' => "",
				],
			];
		}

		return $data;
	}


	/**
	 * Gets the processing information.
	 *
	 * Sets the Apple Pay payment solution if paying with Apple Pay.
	 *
	 * @since 2.0.0
	 *
	 * @param bool $settlement_type settlement type
	 * @return array
	 */
	protected function get_processing_information( $settlement_type = false ) {

		$data = parent::get_processing_information( $settlement_type );

		if ( ! empty( $this->get_order()->payment->apple_pay ) ) {
			$data['paymentSolution'] = self::PAYMENT_SOLUTION_APPLE_PAY;
		}

		return $data;
	}


	/**
	 * Gets the string representation of this request with all sensitive information masked.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function to_string_safe() {

		$string = $this->to_string();
		$data   = $this->get_data();

		// card number
		if ( isset( $data['paymentInformation']['card']['number'] ) ) {

			$number = $data['paymentInformation']['card']['number'];

			$string = str_replace( $number, str_repeat( '*', strlen( $number ) - 4 ) . substr( $number, -4 ), $string );
		}

		// csc
		if ( isset( $data['paymentInformation']['card']['securityCode'] ) ) {

			$csc = $data['paymentInformation']['card']['securityCode'];

			$string = str_replace( $csc, str_repeat( '*', strlen( $csc ) ), $string );
		}

		return $string;
	}


}
