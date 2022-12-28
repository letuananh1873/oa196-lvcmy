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

use SkyVerge\WooCommerce\PluginFramework\v5_5_4 as Framework;
use SkyVerge\WooCommerce\Cybersource\API\Responses;
use SkyVerge\WooCommerce\Cybersource\API\Requests;

defined( 'ABSPATH' ) or exit;

/**
 * CyberSource Base Gateway Class
 *
 * @since 2.0.0
 */
abstract class Gateway extends Framework\SV_WC_Payment_Gateway_Hosted {


	/** @var string the flex form feature */
	const FEATURE_FLEX_FORM = 'flex_form'; 

	/** @var string production merchant ID */
	protected $merchant_id; 
	

	// /** @var string production API key */
	// protected $api_key;

	// /** @var string production API shared secret */
	// protected $api_shared_secret;

	// /** @var string Token Management Service profile ID */
	// protected $tokenization_profile_id;

	// /** @var string test merchant ID */
	protected $test_merchant_id; 


	// /** @var string test API key */
	// protected $test_api_key;

	// /** @var string test API shared secret */
	// protected $test_api_shared_secret;

	// /** @var string test Token Management Service profile ID */
	// protected $test_tokenization_profile_id;

	// /** @var string whether the flex form is enabled */
	// protected $enable_flex_form;

	// /** @var API instance */
	// protected $api;

	/** @var array shared settings names */
	protected $shared_settings_names = [ 'merchant_id', 'test_merchant_id'];


	/** Admin settings methods ************************************************/

	
	/**
	 * Initialize the gateway
	 *
	 * See parent constructor for full method documentation
	 *
	 * @since 2.1.0
	 * @see SV_WC_Payment_Gateway::__construct()
	 * @param string $id the gateway id
	 * @param SV_WC_Payment_Gateway_Plugin $plugin the parent plugin class
	 * @param array $args gateway arguments
	 */
	public function __construct( $id, $plugin, $args ) {
		
		// parent constructor
		parent::__construct( $id, $plugin, $args );

		// payment notification listener hook
		if ( ! has_action( 'woocommerce_api_cybersource_credit_card', array( $this, 'trigger_handle_transaction_response_request' ) ) ) {
		 
			add_action( 'woocommerce_api_cybersource_credit_card', array( $this, 'trigger_handle_transaction_response_request' ) );
		} 

	}
	public function trigger_handle_transaction_response_request(){
		do_action('woocommerce_api_' . strtolower( get_class( $this ) ));
	}
	/**
	 * Returns an array of form fields specific for this method.
	 *
	 * @see SV_WC_Payment_Gateway::get_method_form_fields()
	 *
	 * @since 2.0.0
	 *
	 * @return array of form fields
	 */
	protected function get_method_form_fields() {

		$fields = [

			// production
			'merchant_id' => [
				'title'    => __( 'Merchant IDrr', 'woocommerce-gateway-cybersource' ),
				'type'     => 'text',
				'class'    => 'environment-field production-field',
				'desc_tip' => __( 'The Merchant ID for your CyberSource account.', 'woocommerce-gateway-cybersource' ),
			],

			'access_key' => [
				'title'    => __( 'Access Key Detail', 'woocommerce-gateway-cybersource' ),
				'type'     => 'text',
				'class'    => 'environment-field production-field',
				'desc_tip' => __( 'The Access Key for your CyberSource account.', 'woocommerce-gateway-cybersource' ),
			],
			'profile_id' => [
				'title'    => __( 'Profile Id Detail', 'woocommerce-gateway-cybersource' ),
				'type'     => 'text',
				'class'    => 'environment-field production-field',
				'desc_tip' => __( 'The Profile Id for your CyberSource account.', 'woocommerce-gateway-cybersource' ),
			],


			'secret_key' => [
				'title'    => __( 'API Shared Secret Key', 'woocommerce-gateway-cybersource' ),
				'type'     => 'password',
				'class'    => 'environment-field production-field',
				'desc_tip' => __( 'The API shared secret key for your CyberSource account.', 'woocommerce-gateway-cybersource' ),
			],

			// TEST
			'test_merchant_id' => [
				'title'    => __( 'Test Merchant ID', 'woocommerce-gateway-cybersource' ),
				'type'     => 'text',
				'class'    => 'environment-field test-field',
				'desc_tip' => __( 'The Merchant ID for your CyberSource sandbox account.', 'woocommerce-gateway-cybersource' ),
			],
			'test_access_key' => [
				'title'    => __( 'Test Access Key Detail', 'woocommerce-gateway-cybersource' ),
				'type'     => 'text',
				'class'    => 'environment-field test-field',
				'desc_tip' => __( 'The Test Access Key for your CyberSource account.', 'woocommerce-gateway-cybersource' ),
			],
			'test_profile_id' => [
				'title'    => __( 'Test Profile Id Detail', 'woocommerce-gateway-cybersource' ),
				'type'     => 'text',
				'class'    => 'environment-field test-field',
				'desc_tip' => __( 'The Test Profile Id for your CyberSource account.', 'woocommerce-gateway-cybersource' ),
			],

			/*'test_api_key' => [
				'title'    => __( 'Test API Key Detail', 'woocommerce-gateway-cybersource' ),
				'type'     => 'text',
				'class'    => 'environment-field test-field',
				'desc_tip' => __( 'The API key ID for your CyberSource sandbox account.', 'woocommerce-gateway-cybersource' ),
			],*/

			'test_secret_key' => [
				'title'    => __( 'Test API Shared Secret Key', 'woocommerce-gateway-cybersource' ),
				'type'     => 'password',
				'class'    => 'environment-field test-field',
				'desc_tip' => __( 'The API shared secret key for your CyberSource sandbox account.', 'woocommerce-gateway-cybersource' ),
			],
		];

		// if ( $this->supports_flex_form() ) {

		// 	$fields['enable_flex_form'] = [
		// 		'title'   => __( 'Flex Microform', 'woocommerce-gateway-cybersource' ),
		// 		'label'   => __( 'Use Flex Microform (a hosted form field) to collect payment information on checkout and reduce PCI-compliance assessment scope.', 'woocommerce-gateway-cybersource' ),
		// 		'type'    => 'checkbox',
		// 		'default' => 'yes',
		// 	];
		// }

		// if it was migrated from legacy or SOP (if either option exist, regardless of value),
		// add a button to migrate historical orders
		// $migrated        = get_option( 'wc_' . $this->get_plugin()->get_id() . '_legacy_active', false ) ||
		//                    get_option( 'wc_' . $this->get_plugin()->get_id() . '_migrated_from_sop', false );
		// $orders_migrated = get_option( 'wc_' . $this->get_id() . '_legacy_orders_migrated', false );

		// if ( $migrated && ! $orders_migrated ) {

		// 	$fields['migrate_legacy_orders'] = [
		// 		'title' => __( 'Migrate historical orders', 'woocommerce-gateway-cybersource' ),
		// 		'type'  => 'migrate_orders_button',
		// 	];

		// }

		return $fields;
	}

	/**
	 * Gets the hosted pay page url to redirect to, to allow the customer to
	 * remit payment.  This is generally the bare URL, without any query params.
	 *
	 * This method may be called more than once during a single request.
	 *
	 * @since 2.1.0
	 *
	 * @see SV_WC_Payment_Gateway_Hosted::get_hosted_pay_page_params()
	 * @param \WC_Order $order optional order object, defaults to null
	 * @return string hosted pay page url, or false if it could not be determined
	 */
	public function get_hosted_pay_page_url( $order = null ){ 
		if ($this->get_environment() == 'test') {
			return "https://testsecureacceptance.cybersource.com/pay";
		} else {
			return "https://secureacceptance.cybersource.com/pay";
		}
	}

	/**
	 * Returns an API response object for the current response request
	 *
	 * @since 2.1.0
	 * @param array $request_response_data the current request response data
	 * @return SV_WC_Payment_Gateway_API_Payment_Notification_Response the response object
	 */
	protected function get_transaction_response( $request_response_data ){
		return new Responses\Payments\Credit_Card_Payment($request_response_data);
		 //wp_mail('devtest0909@gmail.com','abdef','Lorem ipsum, dolor sit amet consectetur adipisicing elit. Corporis omnis explicabo, saepe veniam recusandae magni architecto nostrum ad, voluptatem quisquam, quae et laborum. Neque esse a voluptas eius nobis ipsa.');
	}
	
	
	/**
	 * Returns true if this gateway uses a form-post from the pay
	 * page to "redirect" to a hosted payment page
	 *
	 * @since 2.1.0
	 * @return boolean true if this gateway uses a form post, false if it
	 *         redirects directly to the hosted pay page from checkout
	 */
	public function use_form_post() {
		return true;
	}
	/**
	 * Get the auto post form display arguments.
	 *
	 * @since 4.3.0
	 * @see SV_WC_Payment_Gateway_Hosted::render_auto_post_form() for args
	 *
	 * @param \WC_Order $order the order object
	 * @return array
	 */
	protected function get_auto_post_form_args( \WC_Order $order ) {

		$args = array(
			'submit_url'     => $this->get_hosted_pay_page_url( $order ),
			'cancel_url'     => $order->get_cancel_order_url(),
			'message'        => __( 'Thank you for your order, please click the button below to pay.', 'woocommerce-plugin-framework' ),
			'thanks_message' => __( 'Payment in progress, please do not refresh!', 'woocommerce-plugin-framework' ),
			'button_text'    => __( 'Pay Now', 'woocommerce-plugin-framework' ),
			'cancel_text'    => __( 'Cancel Order', 'woocommerce-plugin-framework' ),
		);

		/**
		 * Filter the auto post form display arguments.
		 *
		 * @since 4.3.0
		 * @param array $args {
		 *     The form display arguments.
		 *
		 *     @type string $submit_url     Form submit URL
		 *     @type string $cancel_url     Cancel payment URL
		 *     @type string $message        The message before the form
		 *     @type string $thanks_message The message displayed when the form is submitted
		 *     @type string $button_text    Submit button text
		 *     @type string $cancel_text    Cancel link text
		 * }
		 * @param \WC_Order $order the order object
		 */
		return (array) apply_filters( 'wc_payment_gateway_' . $this->get_id() . '_auto_post_form_args', $args, $order );
	}
	/**
	 * Renders the gateway auto post form.  This is used for gateways that
	 * collect no payment information on-site, but must POST parameters to a
	 * hosted payment page where payment information is entered.
	 *
	 * @since 2.2.0
	 * @see SV_WC_Payment_Gateway_Hosted::use_auto_form_post()
	 *
	 * @param \WC_Order $order the order object
	 * @param array $request_params associative array of request parameters
	 */
	public function render_auto_post_form( \WC_Order $order, $request_params ) {

		$args = $this->get_auto_post_form_args( $order );

		// attempt to automatically submit the form and redirect
		wc_enqueue_js('
			$( "body" ).block( {
					message: "<img src=\"' . esc_url( get_template_directory_uri().'/gateway_cybersource_1/assets/images/ajax-loader.gif' ) . '\" alt=\"Redirecting&hellip;\" style=\"float:left; margin-right: 10px;\" />' . esc_html( $args['thanks_message'] ) . '",
					overlayCSS: {
						background: "#fff",
						opacity: 0.6
					},
					css: {
						padding:         20,
						textAlign:       "center",
						color:           "#555",
						border:          "3px solid #aaa",
						backgroundColor: "#fff",
						cursor:          "wait",
						lineHeight:      "32px"
					}
				} );

			$( "#submit_' . $this->get_id() . '_payment_form" ).click();
		');

		echo '<p>' . esc_html( $args['message'] ) . '</p>';
		echo '<form action="' . esc_url( $args['submit_url'] ) . '" method="post">';

			// Output the param inputs
			echo $this->get_auto_post_form_params_html( $request_params );

			echo '<input type="submit" class="button alt button-alt" id="submit_' . $this->get_id() . '_payment_form" value="' . esc_attr( $args['button_text'] ) . '" />';
			echo '<a class="button cancel" href="' . esc_url( $args['cancel_url'] ) . '">' . esc_html( $args['cancel_text'] ) . '</a>';

		echo '</form>';
	}

	public function map_hosted_params(Requests\Payments\Credit_Card_Payment $request){
		

		$secret_key = $this->secret_key ?? '';
		$access_key = $this->access_key ?? '';
		$profile_id = $this->profile_id  ?? '';
		if ($this->get_environment() == 'test') {
			$access_key = $this->test_access_key ?? '';
			$profile_id = $this->test_profile_id  ?? '';
			$secret_key = $this->test_secret_key  ?? '';
		}

		$params = array(
			"transaction_type"=>"sale",
			"access_key"=>$access_key,
			"profile_id"=>$profile_id,
			"secret_key"=>$secret_key,
			"transaction_uuid"=>uniqid(),
			"signed_field_names"=>"",
			"unsigned_field_names"=>"",
			"signed_date_time"=>gmdate("Y-m-d\TH:i:s\Z"),
			"locale"=>"en",
			"payment_method"=>"card", 
			"payer_authentication_challenge_code"=>"03"
		);

		$merchant_descriptor = get_field("merchant_descriptor","option");
		$merchant_descriptor_alternate  = get_field("merchant_descriptor_alternate","option");
		$merchant_descriptor_city = get_field("merchant_descriptor_city","option");
		$merchant_descriptor_contact = get_field("merchant_descriptor_contact","option");
		$merchant_descriptor_country = get_field("merchant_descriptor_country","option");
		$merchant_descriptor_state = get_field("merchant_descriptor_state","option");
		$merchant_descriptor_postal_code = get_field("merchant_descriptor_postal_code","option");
		$merchant_descriptor_street = get_field("merchant_descriptor_street","option");
		/*if($merchant_descriptor){
			$params["merchant_descriptor"] = $merchant_descriptor;
		}*/
		if($merchant_descriptor_alternate){
			$params["merchant_descriptor_alternate"] = $merchant_descriptor_alternate;
		}
		if($merchant_descriptor_city){
			$params["merchant_descriptor_city"] = $merchant_descriptor_city;
		}
		if($merchant_descriptor_contact){
			$params["merchant_descriptor_contact"] = $merchant_descriptor_contact;
		}
		if($merchant_descriptor_country){
			$params["merchant_descriptor_country"] = $merchant_descriptor_country;
		}
		if($merchant_descriptor_state){
			$params["merchant_descriptor_state"] = $merchant_descriptor_state;
		}
		if($merchant_descriptor_postal_code){
			$params["merchant_descriptor_postal_code"] = $merchant_descriptor_postal_code;
		}
		if($merchant_descriptor_street){
			$params["merchant_descriptor_street"] = $merchant_descriptor_street;
		}
		$request_data = $request->get_data(); 
		$order_information = $request_data["orderInformation"];
		$payment_information = $request_data["paymentInformation"];
		$processing_information = $request_data["processingInformation"];
		$buyer_information = $request_data["buyerInformation"];
		$device_information = $request_data["deviceInformation"];

		// order_information
		foreach($order_information["billTo"] as $k => $v){ 
				$params["bill_to_".$k] = $v; 
		}
		foreach($order_information["shipTo"] as $k => $v){
			$params["ship_to_".$k] = $v;
		}
 
		$line_item_count = count($order_information["lineItems"]);
		if($line_item_count){
			$params["line_item_count"] = $line_item_count;
			foreach($order_information["lineItems"] as $k => $v){ 
				if(isset($v["productCode"])){
					$medium = "";
					$medium = $v["productCode"];
					$params["item_".$k."_code"] = $medium; 
				}
				if(isset($v["productName"])){
					$medium = "";
					$medium = $v["productName"];
					$params["item_".$k."_name"] = $medium; 
				}
				if(isset($v["productSku"])){
					$medium = "";
					$medium = $v["productSku"];
					$params["item_".$k."_sku"] = $medium;
				}
				if(isset($v["unitPrice"])){
					$medium = "";
					$medium = $v["unitPrice"];
					$params["item_".$k."_unit_price"] = $medium;
				}
				if(isset($v["quantity"])){
					$medium = "";
					$medium = $v["quantity"];
					$params["item_".$k."_quantity"] = $medium;
				} 
				if(isset($v["taxAmount"])){
					$medium = "";
					$medium = $v["taxAmount"];
					$params["item_".$k."_tax_amount"] = $medium;
				}  
			}
		}
		$params["amount"] = $order_information["amountDetails"]["totalAmount"];
		$params["currency"] = $order_information["amountDetails"]["currency"];
		$params["tax_amount"] = $order_information["amountDetails"]["taxAmount"];
		$params["customer_ip_address"] = $device_information["ipAddress"]; 

		$country_bill = isset($params["bill_to_address_country"]) ??'MY';
		$country_ship = isset($params["ship_to_address_country"]) ??'MY';
		$check_bill_postcode = ($country_bill == 'US' || $country_bill == 'CA' ) ? false : true;
		$check_ship_postcode = ($country_bill ==  'US' || $country_bill == 'CA') ? false : true;
		

		// unset fields
		if(isset($params["bill_to_address_state"])){
			unset($params["bill_to_address_state"]);
		}  
		if( $check_bill_postcode && isset($params["bill_to_address_postal_code"])){
			unset($params["bill_to_address_postal_code"]);

		} 
		if( $check_ship_postcode && isset($params["ship_to_address_postal_code"])){
			unset($params["ship_to_address_postal_code"]);
		} 

		return $params;
	}  
	/**
	 * Returns the gateway hosted pay page parameters, if any
	 *
	 * @since 2.1.0
	 *
	 * @param \WC_Order $order the order object
	 * @return array associative array of name-value parameters
	 */
	protected function get_hosted_pay_page_params( $order ) {
		// stub method\


		$request = new Requests\Payments\Credit_Card_Payment();
		$request->create_credit_card_charge($order);
		$params = $this->map_hosted_params($request); 
		$country_bill = $params["bill_to_address_country"] ??'MY';
		$country_ship = $params["ship_to_address_country"] ??'MY';
		$check_bill_postcode = ($country_bill == 'US' || $country_bill == 'CA' ) ? false : true;
		$check_ship_postcode = ($country_bill ==  'US' || $country_bill == 'CA') ? false : true;
		

		// unset fields
		if(isset($params["bill_to_address_state"])){
			unset($params["bill_to_address_state"]);
		}  
		if( $check_bill_postcode && isset($params["bill_to_address_postal_code"])){
			unset($params["bill_to_address_postal_code"]);
		} 
		// unset fields

		if($check_ship_postcode && isset($params["ship_to_address_postal_code"])){
			unset($params["ship_to_address_postal_code"]);
		}  

		if(isset($params["ship_to_address_state"])){
			unset($params["ship_to_address_state"]);
		} 
		/*if(isset($params["merchant_descriptor"])){
			unset($params["merchant_descriptor"]);
		} */ 

		$params["reference_number"] = $order->get_id();
		$params['signed_field_names'] = implode(",",array_keys($params)); 
		$client_signature = new Cybersource_Sign($params);
		$params['signature'] = $client_signature->get_signature();
		
		foreach($params as $k => $v){
			$this->update_order_meta($order,$k,$v);
		} 
		return $params;
	} 

	/**
	 * Adds the tokenization feature form fields for gateways that support it.
	 *
	 * @since 2.0.0
	 *
	 * @param array $form_fields form fields
	 * @return array
	 */
	protected function add_tokenization_form_fields( $form_fields ) {

		$form_fields = parent::add_tokenization_form_fields( $form_fields );

		$form_fields['tokenization_profile_id'] = array(
			'title'       => __( 'Tokenization Profile ID', 'woocommerce-gateway-cybersource' ),
			'description' => __( 'Your Token Management Server profile ID, provided by CyberSource.', 'woocommerce-gateway-cybersource' ),
			'type'        => 'text',
			'class'       => 'environment-field production-field profile-id-field',
			'placeholder' => 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX',
		);

		$form_fields['test_tokenization_profile_id'] = array(
			'title'       => __( 'Tokenization Profile ID', 'woocommerce-gateway-cybersource' ),
			'description' => __( 'Your Token Management Server profile ID, provided by CyberSource.', 'woocommerce-gateway-cybersource' ),
			'type'        => 'text',
			'class'       => 'environment-field test-field profile-id-field',
			'placeholder' => 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX',
		);

		return $form_fields;
	}


	/**
	 * Displays the admin options.
	 *
	 * Overridden to add a little extra JS for toggling dependant settings.
	 *
	 * @since 2.0.0
	 */
	public function admin_options() {

		parent::admin_options();

		if ( isset( $this->form_fields['tokenization'] ) ) {

			// add inline javascript to show/hide any shared settings fields as needed
			ob_start(); ?>

			$( '#woocommerce_<?php echo esc_js( $this->get_id() ); ?>_tokenization' ).change( function() {

				var enabled     = $( this ).is( ':checked' );
				var environment = $( '#woocommerce_<?php echo esc_js( $this->get_id() ); ?>_environment' ).val()

				if ( enabled ) {
					$( '.profile-id-field.' + environment + '-field' ).closest( 'tr' ).show();
				} else {
					$( '.profile-id-field.' + environment + '-field' ).closest( 'tr' ).hide();
				}

			} ).change();

			<?php

			wc_enqueue_js( ob_get_clean() );
		}
	}


	/**
	 * Generates a "Migrate historical orders" button.
	 *
	 * @since 2.0.0
	 *
	 * @param string $key the field key
	 * @param array $data the field params
	 * @return false|string
	 */
	public function generate_migrate_orders_button_html( $key, $data ) {

		$data = wp_parse_args( $data, [
			'title'       => '',
			'class'       => '',
			'description' => '',
		] );

		$migrate_button_text = __( 'Update records', 'woocommerce-gateway-cybersource' );
		$disabled_text       = __( 'Please save your API credentials before migrating your historical orders', 'woocommerce-gateway-cybersource' );

		if ( $this->get_plugin()->is_subscriptions_active() ) {
			$migrate_text      = __( 'Migrate orders and subscriptions to use this gateway instead of the legacy CyberSource plugin', 'woocommerce-gateway-cybersource' );
			$confirmation_text = __( 'This action will update the payment method on historical orders and subscriptions to use the new CyberSource gateway. This allows you to capture existing payments or process refunds for historical transactions. For subscription records with manual renewals, this will not enable automatic renewals, as customers need to save a payment method first.', 'woocommerce-gateway-cybersource' );
		} else {
			$migrate_text      = __( 'Migrate orders to use this gateway instead of the legacy CyberSource plugin', 'woocommerce-gateway-cybersource' );
			$confirmation_text = __( 'This action will update the payment method on historical orders to use the new CyberSource gateway. This allows you to capture existing payments or process refunds for historical transactions.', 'woocommerce-gateway-cybersource' );
		}

		wp_enqueue_script( 'wc-cybersource-admin', $this->get_plugin()->get_plugin_url() . '/assets/js/admin/wc-cybersource-admin.min.js', [ 'jquery' ], $this->get_plugin()->get_version() );

		wp_localize_script( 'wc-cybersource-admin', 'wc_cybersource_admin', [
			'ajax_url'              => admin_url( 'admin-ajax.php' ),
			'migrate_nonce'         => wp_create_nonce( 'wc_cybersource_migrate_orders' ),
			'gateway_id'            => $this->get_id(),
			'confirmation_text'     => $confirmation_text,
			'migrate_disabled'      => ! $this->is_configured(),
			'migrate_disabled_text' => $disabled_text,
			'migrate_error_message' => __( 'Error executing the migration, please check the debug logs.', 'wc_cybersource_admin' ),
		] );

		ob_start();

		?>

		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $key ); ?>"><?php echo wp_kses_post( $data['title'] ); ?></label>
			</th>
			<td class="forminp <?php echo esc_attr( $data['class'] ); ?>">
				<p class="description">
					<?php echo esc_html( $migrate_text ); ?>
				</p>
				<br />
				<a id="js-wc-cybersource-migrate-orders"
				   href="#"
				   class="button <?php echo ( ! $this->is_configured() ? 'disabled' : '' ); ?>">
					<?php echo esc_html( $migrate_button_text ); ?>
				</a>
				<p id="wc-cybersource-migrate-status" class="description">
					<?php if ( ! $this->is_configured() && ! empty( $disabled_text ) ): ?>
						<?php echo esc_html( $disabled_text ); ?>
					<?php endif; ?>
				</p>
			</td>
		</tr>

		<?php

		return ob_get_clean();
	}


	/**
	 * Adds transaction data to the order that's specific to this gateway.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 * @param Framework\SV_WC_Payment_Gateway_API_Customer_Response $response API response object
	 */
	public function add_payment_gateway_transaction_data( $order, $response ) {

		if ( ! empty( $order->payment->instrument_identifier ) ) {
			$this->update_order_meta( $order, 'instrument_identifier_id', $order->payment->instrument_identifier->id );
			$this->update_order_meta( $order, 'instrument_identifier_new', $order->payment->instrument_identifier->new ? 'yes' : 'no' );
			$this->update_order_meta( $order, 'instrument_identifier_state', $order->payment->instrument_identifier->state );
		}

		// if the transaction is pending review, it could still be captured if the merchant deems it legitimate
		if ( $response instanceof API\Responses\Payments ) {

			if ( $reconciliation_id = $response->get_reconciliation_id() ) {
				$this->update_order_meta( $order, 'reconciliation_id', $reconciliation_id );
			}

			if ( $transaction_id = $response->get_processor_transaction_id() ) {
				$this->update_order_meta( $order, 'processor_transaction_id', $transaction_id );
			}

			if ( $response->transaction_held() && API\Responses\Payments\Payment::STATUS_AUTHORIZED_PENDING_REVIEW === $response->get_status_code() ) {
				$this->update_order_meta( $order, 'charge_captured', 'no' );
			}
		}
	}


	/** Tokenization methods ******************************************************************************************/


	/**
	 * Determines if tokenization is enabled.
	 *
	 * Overridden to check configuration for the Profile ID.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function tokenization_enabled() {

		return false;
	}


	/**
	 * Tokenize before sale.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function tokenize_before_sale() {

		return false;
	}


	/**
	 * Gets a user's customer ID.
	 *
	 * CyberSource does not support customer IDs.
	 *
	 * @since 2.0.0
	 *
	 * @param int $user_id WordPress user ID
	 * @param array $args customer ID args
	 * @return false
	 */
	public function get_customer_id( $user_id, $args = [] ) {

		return false;
	}


	/**
	 * Gets a guest customer ID.
	 *
	 * CyberSource does not support customer IDs.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 * @return false
	 */
	public function get_guest_customer_id( \WC_Order $order ) {

		return false;
	}


	/** Getters ***************************************************************/


	/**
	 * Gets the order's transaction URL for use in the admin.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 * @return string
	 */
	public function get_transaction_url( $order ) {

		// build the URL to the test/production environment
		if ( self::ENVIRONMENT_TEST === $this->get_order_meta( $order, 'environment' ) ) {
			$base_url = 'https://ubctest.cybersource.com/ebc2/app/TransactionManagement/details';
		} else {
			$base_url = 'https://ubc.cybersource.com/ebc2/app/TransactionManagement/details';
		}

		$this->view_transaction_url = $base_url . '?requestId=%s&merchantId=' . $this->get_merchant_id();

		return parent::get_transaction_url( $order );
	}


	/**
	 * Determines if the gateway is properly configured to perform transactions.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function is_configured() {

		$is_configured = parent::is_configured();

		if ( ! $this->get_merchant_id()) {
			$is_configured = false;
		}

		return $is_configured;
	}


	/**
	 * Gets the API object.
	 *
	 * @see SV_WC_Payment_Gateway::get_api()
	 *
	 * @since 2.0.0
	 *
	 * @return API instance
	 */
	public function get_api() {

		// if ( is_object( $this->api ) ) {
		// 	return $this->api;
		// }

		// return $this->api = new API( $this );
	}


	/**
	 * Returns the merchant account ID based on the current environment.
	 *
	 * @since 2.0.0
	 *
	 * @param string $environment_id optional one of 'test' or 'production', defaults to current configured environment
	 * @return string
	 */
	public function get_merchant_id( $environment_id = null ) {

		if ( null === $environment_id ) {
			$environment_id = $this->get_environment();
		}

		return self::ENVIRONMENT_PRODUCTION === $environment_id ? $this->merchant_id : $this->test_merchant_id;
	}


	/**
	 * Returns the API key ID based on the current environment.
	 *
	 * @since 2.0.0
	 *
	 * @param string $environment_id optional one of 'test' or 'production', defaults to current configured environment
	 * @return string
	 */
	// public function get_api_key( $environment_id = null ) {

	// 	if ( null === $environment_id ) {
	// 		$environment_id = $this->get_environment();
	// 	}

	// 	return self::ENVIRONMENT_PRODUCTION === $environment_id ? $this->api_key : $this->test_api_key;
	// }


	/**
	 * Returns the API shared secret based on the current environment.
	 *
	 * @since 2.0.0
	 *
	 * @param string $environment_id optional one of 'test' or 'production', defaults to current configured environment
	 * @return string
	 */
	// public function get_api_shared_secret( $environment_id = null ) {

	// 	if ( null === $environment_id ) {
	// 		$environment_id = $this->get_environment();
	// 	}

	// 	return self::ENVIRONMENT_PRODUCTION === $environment_id ? $this->api_shared_secret : $this->test_api_shared_secret;
	// }


	/**
	 * Gets the Token Management Server Profile ID.
	 *
	 * @since 2.0.0
	 *
	 * @param string $environment_id optional one of 'test' or 'production', defaults to current configured environment
	 * @return string
	 */
	public function get_tokenization_profile_id( $environment_id = null ) {
 
		return false;
	}


	/**
	 * Determines whether the flex form is enabled.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function is_flex_form_enabled() {

		return $this->supports_flex_form() && 'yes' === $this->enable_flex_form;
	}


	/**
	 * Determines whether the flex form is supported by this gateway.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function supports_flex_form() {

		return false;
	}

	/**
	 * Returns the gateway icon markup
	 *
	 * @since 1.0.0
	 * @see WC_Payment_Gateway::get_icon()
	 * @return string icon markup
	 */
	public function get_icon() {

		$icon = '';

		// specific icon
		if ( $this->icon ) {

			// use icon provided by filter
			$icon = sprintf( '<img src="%s" alt="%s" class="sv-wc-payment-gateway-icon wc-%s-payment-gateway-icon" />', esc_url( \WC_HTTPS::force_https_url( $this->icon ) ), esc_attr( $this->get_title() ), esc_attr( $this->get_id_dasherized() ) );
		}

		// credit card images
		if ( ! $icon && $this->supports_card_types() && $this->get_card_types() ) {

			// display icons for the selected card types
			foreach ( $this->get_card_types() as $k => $card_type ) { 
					$card_type = Framework\SV_WC_Payment_Gateway_Helper::normalize_card_type( $card_type );
					$url = $this->get_payment_method_image_url( $card_type );
					if(Framework\SV_WC_Payment_Gateway_Helper::CARD_TYPE_VISA == $card_type){
						$url = get_template_directory_uri()."/gateway_cybersource_1/assets/images/visa_logo.png";
					}
					if(Framework\SV_WC_Payment_Gateway_Helper::CARD_TYPE_MASTERCARD == $card_type){
						$url = get_template_directory_uri()."/gateway_cybersource_1/assets/images/mastercard_logo.png";
					}
					if ( $url ) {
						$icon .= sprintf( '<img src="%s" alt="%s" class="sv-wc-payment-gateway-icon wc-%s-payment-gateway-icon" width="55" height="auto" style="width: 55px; height: auto;" />', esc_url( $url ), esc_attr( $card_type ), esc_attr( $this->get_id_dasherized() ) );
					} 
			}
		}

		// echeck image
		if ( ! $icon && $this->is_echeck_gateway() ) {

			if ( $url = $this->get_payment_method_image_url( 'echeck' ) ) {
				$icon .= sprintf( '<img src="%s" alt="%s" class="sv-wc-payment-gateway-icon wc-%s-payment-gateway-icon" width="40" height="25" style="width: 40px; height: 25px;" />', esc_url( $url ), esc_attr( 'echeck' ), esc_attr( $this->get_id_dasherized() ) );
			}
		}

		/* This filter is documented in WC core */
		return apply_filters( 'woocommerce_gateway_icon', $icon, $this->get_id() );
	}


}
