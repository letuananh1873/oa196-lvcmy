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

namespace SkyVerge\WooCommerce\Cybersource\API\Responses\Payments;

use SkyVerge\WooCommerce\Cybersource\Cybersource_Sign;
use SkyVerge\WooCommerce\Cybersource\Gateway;
use SkyVerge\WooCommerce\PluginFramework\v5_5_4 as Framework;

defined( 'ABSPATH' ) or exit;

/**
 * CyberSource API Credit Card Payments Response Class
 *
 * Handles parsing credit card transaction responses
 *
 * @see https://developer.cybersource.com/api-reference-assets/index.html#Payments
 *
 * @since 2.0.0
 */
 
class Credit_Card_Payment extends Payment implements Framework\SV_WC_Payment_Gateway_API_Payment_Notification_Credit_Card_Response {

 
	private $is_cybersource = false;
	public function __construct($raw_response_data){
		$raw_response_json = json_encode($raw_response_data);
		parent::__construct($raw_response_json);
		$cybersource_signature = $this->response_data->signature;
		$cybersource_sign = new Cybersource_Sign($raw_response_data);
		$server_signature = $cybersource_sign->get_signature();
		if($server_signature === $cybersource_signature){
			$this->is_cybersource = true;
		} 

		update_post_meta($this->response_data->req_reference_number,"_is_cybersource","---".json_encode($this->is_cybersource)."--");
	}
	/**
	 * Checks if the transaction was successful.
	 *
	 * Note that exceptions are handled prior to response "parsing" so there's no
	 * handling for them here.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function transaction_approved() { 
		return $this->get_status_code() === self::STATUS_ACCEPT && $this->is_cybersource;
	}
	/**
	 * Returns the order id associated with this response.
	 *
	 * @since 2.1.0
	 *
	 * @return int|null the order id associated with this response, or null if it could not be determined
	 * @throws \Exception if there was a serious error finding the order id
	 */
	public function get_order_id(){ 
		return $this->response_data->req_reference_number ?  $this->response_data->req_reference_number : null;
	}


	/**
	 * Returns true if the transaction was cancelled, false otherwise.
	 *
	 * @since 2.1.0
	 *
	 * @return bool true if cancelled, false otherwise
	 */
	public function transaction_cancelled(){
		return false;
	}
	/**
	 * Checks if the transaction is pending review.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function transaction_held() {
		if($this->get_status_code() === self::STATUS_ACCEPT && !$this->is_cybersource){
			return true;
		}
		return $this->get_status_code() === self::STATUS_AUTHORIZED_PENDING_REVIEW;
	}


	/**
	 * Returns the card PAN or checking account number, if available.
	 *
	 * @since 2.2.0
	 *
	 * @return string|null PAN or account number or null if not available
	 */
	public function get_account_number(){
		return isset($this->response_data->req_card_number) ?  $this->response_data->req_card_number : null;
	}


	/**
	 * Determines if this is an IPN response.
	 *
	 * Intentionally commented out to prevent fatal errors in older plugins
	 *
	 * @since 4.3.0
	 *
	 * @return bool
	 */
	public function is_ipn(){
		return false;
	}
	/**
	 * Gets the response payment type.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_payment_type() {

		return Gateway::PAYMENT_TYPE_CREDIT_CARD;
	}
	/**
	 * Returns the card type, if available, i.e., 'visa', 'mastercard', etc.
	 *
	 * @see SV_WC_Payment_Gateway_Helper::payment_type_to_name()
	 *
	 * @since 2.2.0
	 *
	 * @return string|null card type or null if not available
	 */
	public function get_card_type(){
			return $this->response_data->card_type_name ? $this->response_data->card_type_name : null;
	}


	/**
	 * Returns the card expiration month with leading zero, if available.
	 *
	 * @since 2.2.0
	 *
	 * @return string|null card expiration month or null if not available
	 */
	public function get_exp_month(){
		return $this->response_data->req_card_expiry_date ? substr($this->response_data->req_card_expiry_date,0,2) : null;
	}


	/**
	 * Returns the card expiration year with four digits, if available.
	 *
	 * @since 2.2.0
	 *
	 * @return string|null card expiration year or null if not available
	 */
	public function get_exp_year(){
		return $this->response_data->req_card_expiry_date ? substr($this->response_data->req_card_expiry_date,3,4) : null;
	}
	
	/**
	 * The authorization code is returned from the credit card processor to
	 * indicate that the charge will be paid by the card issuer.
	 *
	 * @since 1.0.0
	 *
	 * @return string credit card authorization code
	 */
	public function get_authorization_code(){
		return !empty($this->response_data->auth_code) ? $this->response_data->auth_code : "";
	}


	/**
	 * Returns the result of the AVS check.
	 *
	 * @since 1.0.0
	 *
	 * @return string result of the AVS check, if any
	 */
	public function get_avs_result(){
		return !empty($this->response_data->auth_avs_code) ? $this->response_data->auth_avs_code : "";
	}


	/**
	 * Returns the result of the CSC check.
	 *
	 * @since 1.0.0
	 *
	 * @return string result of CSC check
	 */
	public function get_csc_result(){
		return "";
	}


	/**
	 * Returns true if the CSC check was successful.
	 *
	 * @since 1.0.0
	 *
	 * @return boolean true if the CSC check was successful
	 */
	public function csc_match(){
		return false;
	}

	/**
	 * Gets the transaction status message.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_status_message() {

		$message    = '';
		$error_info = $this->get_error_information();

		if ( $error_info && ! empty( $error_info->message ) ) {

			$message = $error_info->message;

		} elseif ( ! empty( $this->response_data->message ) ) {

			$message = $this->response_data->message;
		}

		return $message;
	}


	/**
	 * Gets the response reason code.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_reason_code() {

		$reason     = '';
		$error_info = $this->get_error_information();

		if ( $error_info && ! empty( $error_info->reason ) ) {

			$reason = $error_info->reason;

		} elseif ( ! empty( $this->response_data->reason ) ) {

			$reason = $this->response_data->reason;
		}

		return $reason;
	}


	/**
	 * Gets the error information, if any.
	 *
	 * @since 2.0.0
	 *
	 * @return \stdClass|null
	 */
	public function get_error_information() {
		if(!$this->is_cybersource){
			return "";
		}
		return ! empty( $this->response_data->message ) ? $this->response_data->message : null;
	}

}
