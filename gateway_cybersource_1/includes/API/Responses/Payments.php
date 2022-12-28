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

namespace SkyVerge\WooCommerce\Cybersource\API\Responses;

defined( 'ABSPATH' ) or exit;

/**
 * CyberSource Payments API response.
 *
 * @since 2.0.0
 */
abstract class Payments extends Transaction {


	/**
	 * status values from CyberSource
	 * @see PtsV2PaymentsPost201Response::setStatus
	 */ 
	const STATUS_ACCEPT = "ACCEPT";
	const STATUS_AUTHORIZED_PENDING_REVIEW = "REVIEW";
	const STATUS_DECLINED = "DECLINE";
	const STATUS_ERROR = "ERROR";
	const STATUS_CANCEL = "CANCEL"; 


	/**
	 * Gets the response status message, or null if there is no status message
	 * associated with this transaction.
	 *
	 * @since 1.0.0
	 *
	 * @return string status message
	 */
	public function get_status_message(){
		return isset($this->response_data->message) ? $this->response_data->message : "";
	}


	/**
	 * Gets the response status code, or null if there is no status code
	 * associated with this transaction.
	 *
	 * @since 1.0.0
	 *
	 * @return string status code
	 */
	public function get_status_code(){
		return isset($this->response_data->decision) ? $this->response_data->decision : "";
	}


	/**
	 * Gets the response transaction id, or null if there is no transaction id
	 * associated with this transaction.
	 *
	 * @since 1.0.0
	 *
	 * @return string transaction id
	 */
	public function get_transaction_id(){
		return isset($this->response_data->transaction_id) ? $this->response_data->transaction_id : "";
	}


	/**
	 * Gets the payment type: 'credit-card', 'echeck', etc...
	 *
	 * @since 5.0.0
	 *
	 * @return string
	 */
	public function get_payment_type(){
		return isset($this->response_data->req_payment_method) ? $this->response_data->req_payment_method : "";
	}


	/**
	 * Returns a message appropriate for a frontend user.  This should be used
	 * to provide enough information to a user to allow them to resolve an
	 * issue on their own, but not enough to help nefarious folks fishing for
	 * info.
	 *
	 * @see SV_WC_Payment_Gateway_API_Response_Message_Helper
	 *
	 * @since 2.2.0
	 *
	 * @return string user message, if there is one
	 */
	public function get_user_message(){
		return "";
	}


}
