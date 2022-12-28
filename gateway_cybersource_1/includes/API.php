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

namespace SkyVerge\WooCommerce\Cybersource;

use CyberSource\ApiClient;
use CyberSource\ApiException;
use CyberSource\Authentication\Core\MerchantConfiguration;
use CyberSource\Authentication\Util\GlobalParameter;
use CyberSource\Configuration;
use SkyVerge\WooCommerce\Cybersource\API\Helper;
use SkyVerge\WooCommerce\Cybersource\API\Requests;
use SkyVerge\WooCommerce\Cybersource\API\Responses;
use SkyVerge\WooCommerce\PluginFramework\v5_5_4 as Framework;

defined( 'ABSPATH' ) or exit;

/**
 * CyberSource API Class
 *
 * This is a pseudo-wrapper around the CyberSource PHP SDK
 *
 * @link https://github.com/CyberSource/cybersource-rest-client-php
 * @link https://github.com/CyberSource/cybersource-rest-samples-php
 *
 * @since 2.0.0
 *
 * @method Responses\Flex\Key_Generation|Responses\Payments\Authorization_Reversal|Responses\Payments\Refund|Responses\Payments\Capture|Responses\Payments\Credit_Card_Payment|Responses\Payments\Electronic_Check_Payment|Responses\Payment_Instruments|Responses\Flex\Tokenize perform_request( $request )
 */
class API extends Framework\SV_WC_API_Base implements Framework\SV_WC_Payment_Gateway_API {


	/** @var Gateway class instance */
	protected $gateway;

	/** @var \WC_Order order associated with the request, if any */
	protected $order;

	/** @var ApiClient instance of the SDK API client */
	protected $sdk_api_client;


	/**
	 * Constructor - setup request object and set endpoint
	 *
	 * @since 2.0.0
	 *
	 * @param Gateway $gateway class instance
	 */
	public function __construct( $gateway ) {

		$this->gateway = $gateway;

		$this->set_request_content_type_header( 'application/json' );
		$this->set_request_accept_header( 'application/json' );
	}


	/** API Methods ***********************************************************/


	/**
	 * Creates a new credit card charge transaction.
	 *
	 * @see SV_WC_Payment_Gateway_API::credit_card_charge()
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order
	 * @return Responses\Payments\Credit_Card_Payment
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function credit_card_charge( \WC_Order $order ) {

		$this->order = $order;

		$request = $this->get_new_payment_request( Gateway::PAYMENT_TYPE_CREDIT_CARD );

		$request->create_credit_card_charge( $order );

		return $this->perform_request( $request );
	}


	/**
	 * Creates a new credit card auth transaction.
	 *
	 * @see SV_WC_Payment_Gateway_API::credit_card_authorization()
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order
	 * @return Responses\Payments\Credit_Card_Payment
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function credit_card_authorization( \WC_Order $order ) {

		$this->order = $order;

		$request = $this->get_new_payment_request( Gateway::PAYMENT_TYPE_CREDIT_CARD );

		$request->create_credit_card_auth( $order );

		return $this->perform_request( $request );
	}


	/**
	 * Captures funds for a credit card authorization.
	 *
	 * @see SV_WC_Payment_Gateway_API::credit_card_capture()
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order
	 * @return Responses\Payments\Credit_Card_Payment
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function credit_card_capture( \WC_Order $order ) {

		$this->order = $order;

		$request = $this->get_new_capture_request();

		$request->create_credit_card_capture( $order );

		return $this->perform_request( $request );
	}


	/**
	 * Performs a customer check debit transaction.
	 *
	 * An amount will be debited from the customer's account to the merchant's account.
	 *
	 * @since 2.0.0-dev.5
	 *
	 * @param \WC_Order $order order object
	 * @return Responses\Payments\Electronic_Check_Payment
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function check_debit( \WC_Order $order ) {

		$this->order = $order;

		$request = $this->get_new_payment_request( Gateway::PAYMENT_TYPE_ECHECK );

		$request->create_payment( $order );

		return $this->perform_request( $request );
	}


	/**
	 * Performs a refund for the given order.
	 *
	 * @since 2.0.0-dev.4
	 *
	 * @param \WC_Order $order order object
	 * @return Responses\Payments\Refund
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function refund( \WC_Order $order ) {

		$this->order = $order;

		$request = $this->get_new_refund_request();

		$request->create_refund( $order );

		return $this->perform_request( $request );
	}


	/**
	 * Performs a void for the given order.
	 *
	 * @since 2.0.0-dev.4
	 *
	 * @param \WC_Order $order order object
	 * @return Responses\Payments\Authorization_Reversal
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function void( \WC_Order $order ) {

		$this->order = $order;

		$request = $this->get_new_void_request();

		$request->create_authorization_reversal( $order );

		return $this->perform_request( $request );
	}


	/**
	 * Creates a transaction specific public key used to initiate the Flex Microform.
	 *
	 * @since 2.0.0
	 *
	 * @param string $encryption_type type of encryption to use
	 * @return Responses\Flex\Key_Generation
	 * @throws Framework\SV_WC_API_Exception
	 */
	public function generate_public_key( $encryption_type = 'RsaOaep256' ) {

		$request = $this->get_new_key_generation_request();

		$request->set_generate_public_key_data( $encryption_type );

		return $this->perform_request( $request );
	}


	/* Tokenization methods *******************************************************************************************/


	/**
	 * Tokenizes the order's payment method.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order the order
	 * @return Responses\Flex\Tokenize
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	public function tokenize_payment_method( \WC_Order $order ) {

		if ( 'credit_card' === $order->payment->type ) {

			if ( ! empty( $order->payment->js_token ) ) {

				$data = [
					'token'                => $order->payment->js_token,
					'maskedPan'            => $order->payment->account_number,
					'cardType'             => Helper::convert_card_type_to_code( $order->payment->card_type ),
					'instrumentIdentifier' => [],
				];

				if ( ! empty( $order->payment->instrument_identifier ) ) {
					$data['instrumentIdentifier']['id']    = $order->payment->instrument_identifier->id;
					$data['instrumentIdentifier']['state'] = $order->payment->instrument_identifier->state;
					$data['instrumentIdentifier']['new']   = $order->payment->instrument_identifier->new ? 'Y' : 'N';
				}

				$response = new Responses\Flex\Tokenize( json_encode( $data ) );

			} else {

				$key_id = $this->generate_public_key( 'None' )->get_key_id();

				$request = $this->get_new_flex_tokenize_request();

				$request->tokenize_card( $key_id, $order );

				$response = $this->perform_request( $request );
			}

			$response->set_order( $order );

		} else {

			$request = $this->get_new_payment_instrument_request();

			$request->set_create_payment_instrument( $order );

			$response = $this->perform_request( $request );
		}

		return $response;
	}


	/**
	 * Gets the tokenized payment methods - no-op
	 *
	 * @since 2.0.0
	 *
	 * @param string $customer_id unique
	 */
	public function get_tokenized_payment_methods( $customer_id ) { }


	/**
	 * Updates tokenized payment method - no-op
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order
	 *
	 * @return API\Responses\Payment_Instruments
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	public function update_tokenized_payment_method( \WC_Order $order ) {

		$request = $this->get_new_payment_instrument_request();

		$request->set_update_payment_instrument( $order );

		return $this->perform_request( $request );
	}


	/**
	 * Determines whether updating tokenized methods is supported.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function supports_update_tokenized_payment_method() {

		return true;
	}


	/**
	 * Removes tokenized payment method - no-op
	 *
	 * @since 2.0.0
	 *
	 * @param string $token the payment method token
	 * @param string $customer_id unique
	 * @return API\Responses\Payment_Instruments
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	public function remove_tokenized_payment_method( $token, $customer_id ) {

		$request = $this->get_new_payment_instrument_request();

		$request->set_delete_payment_instrument( $token );

		return $this->perform_request( $request );
	}


	/**
	 * Determines whether retrieving tokenized methods is supported.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function supports_get_tokenized_payment_methods() {

		return false;
	}


	/**
	 * Determines whether removing tokenized methods is supported.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function supports_remove_tokenized_payment_method() {

		return false;
	}


	/** Request/Response Methods **********************************************/


	/**
	 * Performs a remote request using the CyberSource SDK. Overrides the standard
	 * wp_remote_request() as the SDK already provides a cURL implementation
	 *
	 * @see SV_WC_API_Base::do_remote_request()
	 *
	 * @since 2.0.0
	 *
	 * @param string $callback SDK callback, e.g. `PaymentsApi->createPayment`
	 * @param array $callback_params parameters to pass to the callback
	 * @return \Exception|mixed
	 */
	protected function do_remote_request( $callback, $callback_params ) {

		try {

			return $this->get_sdk_api_client()->callApi(
				$this->get_request()->get_path(),
				$this->get_request()->get_method(),
				$this->get_request()->get_params(),
				$this->get_request()->get_data(),
				$this->get_request_headers()
			);

		} catch ( \Exception $e ) {

			$response = $e;
		}

		return $response;
	}


	/**
	 * Validates the response data before it's been parsed.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 * @throws Framework\SV_WC_API_Exception
	 */
	protected function do_pre_parse_response_validation() {
		//wp_mail('devtest0909@gmail.com','respon code',$this->get_response_code());

		// 404s will never have additional information
		if ( 404 === $this->get_response_code() ) {
			throw new Framework\SV_WC_API_Exception( $this->get_response_message() );
		}

		return true;
	}


	/**
	 * Validates the response after it's been parsed.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 * @throws Framework\SV_WC_API_Exception
	 */
	protected function do_post_parse_response_validation() {

		$response = $this->get_response();

		// Payments API server errors
		if ( $response instanceof Responses\Payments && Responses\Payments::STATUS_ERROR === $response->get_status_code() ) {
			throw new Framework\SV_WC_API_Exception( $response->get_status_message() . ' [' . $response->get_reason_code() . ']' );
		}

		return true;
	}


	/**
	 * Handles and parses the response.
	 *
	 * @since 2.0.0
	 *
	 * @param mixed $response directly from CyberSource SDK
	 * @return API\Response
	 * @throws Framework\SV_WC_API_Exception
	 */
	protected function handle_response( $response ) {

		if ( $response instanceof ApiException ) {

			$code    = $response->getCode();
			$message = $response->getMessage();
			$body    = $response->getResponseBody();
			$headers = $response->getResponseHeaders();

			$body = json_encode( $body, true );

		} elseif ( is_array( $response ) ) {

			list( $data, $code, $headers ) = $response;

			$body = json_encode( $data, true );

			$message = '';

		} else {

			throw new Framework\SV_WC_API_Exception( 'Invalid response data' );
		}

		$this->response_code     = $code;
		$this->response_headers  = $headers;
		$this->response_message  = $message;
		$this->raw_response_body = $body;

		// allow child classes to validate response prior to parsing -- this is useful
		// for checking HTTP status codes, etc.
		$this->do_pre_parse_response_validation();

		$handler_class = $this->get_response_handler();

		// parse the response body and tie it to the request
		$this->response = new $handler_class( $this->raw_response_body );

		$this->do_post_parse_response_validation();

		$this->broadcast_request();

		return $this->response;
	}


	/**
	 * Gets a new payment API request.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type payment type
	 * @return Requests\Payments\Credit_Card_Payment|Requests\Payments\Electronic_Check_Payment
	 * @throws Framework\SV_WC_API_Exception
	 */
	protected function get_new_payment_request( $type ) {

		$this->set_request_accept_header( 'application/hal+json' );

		switch ( $type ) {

			case Gateway::PAYMENT_TYPE_CREDIT_CARD:
				$request  = Requests\Payments\Credit_Card_Payment::class;
				$response = Responses\Payments\Credit_Card_Payment::class;
			break;

			case Gateway::PAYMENT_TYPE_ECHECK:
				$request  = Requests\Payments\Electronic_Check_Payment::class;
				$response = Responses\Payments\Electronic_Check_Payment::class;
			break;

			default:
				throw new Framework\SV_WC_API_Exception( 'Invalid payment type' );
		}

		return $this->get_new_request( [
			'request_class'  => $request,
			'response_class' => $response,
		] );
	}


	/**
	 * Gets a new Flex API tokenization request.
	 *
	 * @since 2.0.0
	 *
	 * @return Requests\Flex\Tokenize
	 * @throws Framework\SV_WC_API_Exception
	 */
	protected function get_new_flex_tokenize_request() {

		return $this->get_new_request( [
			'request_class'  => Requests\Flex\Tokenize::class,
			'response_class' => Responses\Flex\Tokenize::class,
		] );
	}


	/**
	 * Gets a new capture request.
	 *
	 * @since 2.0.0
	 *
	 * @return Requests\Payments\Capture
	 * @throws Framework\SV_WC_API_Exception
	 */
	protected function get_new_capture_request() {

		$this->set_request_accept_header( 'application/hal+json' );

		return $this->get_new_request( [
			'request_class'  => Requests\Payments\Capture::class,
			'response_class' => Responses\Payments\Capture::class,
		] );
	}


	/**
	 * Gets a new refund request.
	 *
	 * @since 2.0.0
	 *
	 * @return Requests\Payments\Refund
	 * @throws Framework\SV_WC_API_Exception
	 */
	protected function get_new_refund_request() {

		$this->set_request_accept_header( 'application/hal+json' );

		return $this->get_new_request( [
			'request_class'  => Requests\Payments\Refund::class,
			'response_class' => Responses\Payments\Refund::class,
		] );
	}


	/**
	 * Gets a new void request.
	 *
	 * @since 2.0.0
	 *
	 * @return Requests\Payments\Authorization_Reversal
	 * @throws Framework\SV_WC_API_Exception
	 */
	protected function get_new_void_request() {

		$this->set_request_accept_header( 'application/hal+json' );

		return $this->get_new_request( [
			'request_class'  => Requests\Payments\Authorization_Reversal::class,
			'response_class' => Responses\Payments\Authorization_Reversal::class,
		] );
	}


	/**
	 * Gets a new key generation request.
	 *
	 * @since 2.0.0
	 *
	 * @return Requests\Payment_Instruments
	 * @throws Framework\SV_WC_API_Exception
	 */
	protected function get_new_payment_instrument_request() {

		$this->set_request_header( 'profile-id', $this->get_gateway()->get_tokenization_profile_id() );

		$request = $this->get_new_request( [
			'request_class'  => Requests\Payment_Instruments::class,
			'response_class' => Responses\Payment_Instruments::class,
		] );

		return $request;
	}


	/**
	 * Gets a new key generation request.
	 *
	 * @since 2.0.0
	 *
	 * @return Requests\Flex\Key_Generation
	 * @throws Framework\SV_WC_API_Exception
	 */
	protected function get_new_key_generation_request() {

		return $this->get_new_request( [
			'request_class'  => Requests\Flex\Key_Generation::class,
			'response_class' => Responses\Flex\Key_Generation::class,
		] );
	}


	/**
	 * Gets a new request object.
	 *
	 * @since 2.0.0
	 *
	 * @param array $args request args
	 *
	 * @return Requests\Flex\Key_Generation|Requests\Payments\Authorization_Reversal|Requests\Payments\Refund|Requests\Payments\Capture|Requests\Payments\Credit_Card_Payment|Requests\Payments\Electronic_Check_Payment|Requests\Payment_Instruments|Requests\Flex\Tokenize
	 * @throws Framework\SV_WC_API_Exception
	 */
	protected function get_new_request( $args = [] ) {

		$args = wp_parse_args( $args, [
			'request_class'  => '',
			'response_class' => '',
		] );

		if ( ! class_exists( $args['request_class'] ) ) {
			throw new Framework\SV_WC_API_Exception( 'Invalid request class' );
		}

		if ( ! class_exists( $args['response_class'] ) ) {
			throw new Framework\SV_WC_API_Exception( 'Invalid response class' );
		}

		$this->set_response_handler( $args['response_class'] );

		return new $args['request_class']( $this->order );
	}


	/** Helper methods ********************************************************/


	/**
	 * Initializes (if needed) and returns an instance of the SDK API client.
	 *
	 * Ensures only one instance is/can be loaded.
	 *
	 * @since 2.0.0
	 *
	 * @return ApiClient
	 */
	public function get_sdk_api_client() {

		if ( null === $this->sdk_api_client ) {

			$merchant_config = new MerchantConfiguration();

			if ( $this->gateway->is_test_environment() ) {
				$merchant_config->setRunEnvironment( GlobalParameter::RUNENVIRONMENT );
			} else {
				$merchant_config->setRunEnvironment( GlobalParameter::RUNPRODENVIRONMENT );
			}

			/**
			 * Filters the API Merchant ID used when initializing the SDK API client.
			 *
			 * @since 2.0.2
			 *
			 * @param string $merchant_id the merchant ID
			 * @param \WC_Order $order order instance
			 */
			$merchant_config->setMerchantID( apply_filters( 'wc_cybersource_api_credentials_merchant_id', $this->get_gateway()->get_merchant_id(), $this->get_order() ) );

			/**
			 * Filters the API Key used when initializing the SDK API client.
			 *
			 * @since 2.0.2
			 *
			 * @param string $api_key the API key
			 * @param \WC_Order $order order instance
			 */
			$merchant_config->setApiKeyID( apply_filters( 'wc_cybersource_api_credentials_api_key', $this->get_gateway()->get_api_key(), $this->get_order() ) );

			/**
			 * Filters the API Shared Secret used to Initialize the SDK API client.
			 *
			 * @since 2.0.2
			 *
			 * @param string $api_shared_secret the shared secret
			 * @param \WC_Order $order order instance
			 */
			$merchant_config->setSecretKey( apply_filters( 'wc_cybersource_api_credentials_api_shared_secret', $this->get_gateway()->get_api_shared_secret(), $this->get_order() ) );

			$merchant_config->setAuthenticationType( GlobalParameter::HTTP_SIGNATURE );

			$config = new Configuration();
			$config = $config->setHost( $merchant_config->getHost() );
			// TODO: set based on the show debug setting {2019-08-01 DM}
			//$config = $config->setDebug( $merchant_config->getDebug() );
			// TODO: set based on the log debug setting {2019-08-01 DM}
			//$config = $config->setDebugFile( $merchant_config->getDebugFile() . DIRECTORY_SEPARATOR . $merchant_config->getLogFileName() );

			$this->sdk_api_client = new ApiClient( $config, $merchant_config );
		}

		return $this->sdk_api_client;
	}


	/**
	 * Returns the order associated with the request, if any.
	 *
	 * @since 2.0.0
	 *
	 * @return \WC_Order
	 */
	public function get_order() {

		return $this->order;
	}


	/**
	 * Gets the ID for the API, used primarily to namespace the action name
	 * for broadcasting requests.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	protected function get_api_id() {

		return $this->get_gateway()->get_id();
	}


	/**
	 * Returns the gateway plugin.
	 *
	 * @since 2.0.0
	 *
	 * @return Framework\SV_WC_Payment_Gateway_Plugin
	 */
	public function get_plugin() {

		return $this->get_gateway()->get_plugin();
	}


	/**
	 * Returns the gateway class associated with the request.
	 *
	 * @since 2.0.0
	 *
	 * @return Gateway class instance
	 */
	public function get_gateway() {

		return $this->gateway;
	}


}
