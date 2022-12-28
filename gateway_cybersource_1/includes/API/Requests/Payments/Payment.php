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

use SkyVerge\WooCommerce\Cybersource\API\Requests\Payments;
use SkyVerge\WooCommerce\PluginFramework\v5_5_4 as Framework;

defined( 'ABSPATH' ) or exit;

/**
 * CyberSource API transaction request.
 *
 * @since 2.0.0
 */
abstract class Payment extends Payments {


	/**
	 * Creates a new payment.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 * @param bool $settlement_type
	 */
	public function create_payment( \WC_Order $order, $settlement_type = true ) {

		$this->method = self::REQUEST_METHOD_POST;
		$this->order  = $order;

		$this->data = [
			'clientReferenceInformation' => $this->get_client_reference_information(),
			'orderInformation'           => $this->get_order_information(),
			'paymentInformation'         => $this->get_payment_information(),
			'processingInformation'      => $this->get_processing_information( $settlement_type ),
			'buyerInformation'           => $this->get_buyer_information(),
			'deviceInformation'          => $this->get_device_information(),
		];
	}


	/**
	 * Gets order information (amount, items and billing details).
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	protected function get_order_information() {

		$data = [
			'amountDetails' => $this->get_amount_details( $this->get_order()->payment_total ),
			'billTo'        => $this->get_billing_information(),
		];

		if ( $this->get_order()->has_shipping_address() ) {
			$data['shipTo'] = $this->get_shipping_information();
		}

		$data['lineItems'] = $this->get_items_information();

		return $data;
	}


	/**
	 * Gets billing information.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	protected function get_billing_information() {

		return $this->get_order_address_data( $this->get_order() );
	}


	/**
	 * Gets billing information.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	protected function get_shipping_information() {

		return $this->get_order_address_data( $this->get_order(), 'shipping' );
	}


	/**
	 * Gets items information.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	protected function get_items_information() {

		$items = [];

		if ( $order = $this->get_order() ) {

			foreach ( Framework\SV_WC_Helper::get_order_line_items( $order ) as $line_item ) {

				$item = [
					'productName'    => $line_item->item->get_name(),
					'unitPrice'      => $line_item->item_total,
					'quantity'       => $line_item->quantity,
					'taxAmount'      => $line_item->item->get_total_tax(),
				];

				// if we have a product object, add the SKU if available
				if ( $line_item->product instanceof \WC_Product && $line_item->product->get_sku() ) {
					$item['productSku'] = $line_item->product->get_sku();
				}

				$items[] = $item;
			}

			foreach ( $order->get_shipping_methods() as $shipping_method ) {

				$items[] = [
					'productCode' => 'shipping_and_handling',
					'productName' => $shipping_method->get_name(),
					'productSku'  => $shipping_method->get_method_id(),
					'unitPrice'   => $shipping_method->get_total(),
					'quantity'    => 1,
					'taxAmount'   => $shipping_method->get_total_tax(),
				];
			}

			foreach ( $order->get_fees() as $fee ) {

				$items[] = [
					'productName' => $fee->get_name(),
					'unitPrice'   => $fee->get_total(),
					'quantity'    => 1,
					'taxAmount'   => $fee->get_total_tax(),
				];
			}
		}

		// sanitize dynamic values: quotes, question marks and other characters could trigger an API error
		foreach ( $items as $key => $item ) {

			$items[ $key ]['productName'] = $this->sanitize_item_name( $item['productName'] );

			if ( ! empty( $item['productSku'] ) ) {
				$items[ $key ]['productSku'] = $this->sanitize_item_name( $item['productSku'] );
			}
		}

		return $items;
	}


	/**
	 * Sanitizes an item name or SKU for API use.
	 *
	 * @see Payment::get_items_information()
	 *
	 * @since 2.0.6
	 *
	 * @param string $original_name original string
	 * @return string
	 */
	private function sanitize_item_name( $original_name ) {

		// strip unsupported characters
		$sanitized_name = str_replace( '?', '', $original_name );
		// convert special characters to HTML entities
		$sanitized_name = htmlentities( $sanitized_name );
		// trim down to max 255 characters
		return Framework\SV_WC_Helper::str_truncate( trim( $sanitized_name ), 255 );
	}


	/**
	 * Gets the payment information.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	protected function get_payment_information() {

		$payment = $this->get_order()->payment;
		$data    = null;

		if ( ! empty( $payment->token ) || ! empty( $payment->js_token ) ) {

			$data = [
				'customer' => [
					'customerId' => ! empty( $payment->token ) ? $payment->token : $payment->js_token,
				],
			];

		} else {

			$data = $this->get_payment_data();
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
	abstract protected function get_payment_data();


	/**
	 * Gets processing information.
	 *
	 * @since 2.0.0
	 *
	 * @param bool $settlement_type true = auth/capture, false = auth-only
	 * @return array
	 */
	protected function get_processing_information( $settlement_type = false ) {

		if ( $settlement_type ) {

			$processing_information = [
				'capture'           => true,
				'commerceIndicator' => 'internet',
			];

		} else {

			$processing_information = [
				'commerceIndicator' => 'internet',
			];
		}

		$payment = $this->get_order()->payment;

		// if paying with a stored credential
		if ( ! empty( $payment->token ) ) {

			if ( ! empty( $this->get_order()->payment->recurring ) ) {

				$processing_information['authorizationOptions'] = [
					'initiator' => [
						'type'                 => 'merchant',
						'storedCredentialUsed' => true,
					],
				];

			} else {

				$processing_information['authorizationOptions'] = [
					'initiator' => [
						'type' => 'customer',
					],
				];
			}
		}

		return $processing_information;
	}


	/**
	 * Gets buyer information.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	protected function get_buyer_information() {

		$buyer_information = [];

		if ( $this->get_order()->get_user_id() ) { 
		}

		return $buyer_information;
	}


	/**
	 * Gets device information.
	 *
	 * @since 2.0.0-dev.6
	 *
	 * @return array
	 */
	protected function get_device_information() {

		return [
			'ipAddress' => $this->get_order()->get_customer_ip_address(),
			'userAgent' => $this->get_order()->get_customer_user_agent(),
		];
	}


}

