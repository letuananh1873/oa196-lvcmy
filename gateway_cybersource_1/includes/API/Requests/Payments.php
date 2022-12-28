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

namespace SkyVerge\WooCommerce\Cybersource\API\Requests;

use SkyVerge\WooCommerce\PluginFramework\v5_5_4 as Framework;

defined( 'ABSPATH' ) or exit;

/**
 * CyberSource API payments request.
 *
 * @since 2.0.0
 */
abstract class Payments extends Transaction {


	/** @var string code for the Apple Pay payment solution */
	const PAYMENT_SOLUTION_APPLE_PAY = '001';


	/**
	 * Payments constructor.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

		$this->path = '/pts/v2/payments/';
	}


	/**
	 * Gets client reference information element.
	 *
	 * @since 2.0.0
	 * @return array
	 */
	protected function get_client_reference_information() {

		return [ 'code' => Framework\SV_WC_Helper::str_truncate( ltrim( $this->get_order()->get_order_number(), _x( '#', 'hash before order number', 'woocommerce-gateway-cybersource' ) ), 50, '' ) ];
	}


	/**
	 * Gets amount details.
	 *
	 * @since 2.0.0
	 *
	 * @param string|float $amount transaction amount
	 * @return array
	 */
	protected function get_amount_details( $amount ) {

		return [
			'totalAmount' => $amount,
			'currency'    => $this->get_order()->get_currency(),
			'taxAmount'   => $this->get_order()->get_total_tax(),
		];
	}


}

