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

namespace SkyVerge\WooCommerce\Cybersource\API;

use SkyVerge\WooCommerce\PluginFramework\v5_5_4 as Framework;

defined( 'ABSPATH' ) or exit;

/**
 * CyberSource API Abstract Request Class
 *
 * Provides functionality common to all requests
 *
 * @since 2.0.0
 */
abstract class Request extends Framework\SV_WC_API_JSON_Request {


	const REQUEST_METHOD_POST = 'POST';

	const REQUEST_METHOD_PUT = 'PUT';

	const REQUEST_METHOD_PATCH = 'PATCH';

	const REQUEST_METHOD_GET = 'GET';

	const REQUEST_METHOD_DELETE = 'DELETE';


	/** @var \WC_Order order associated with the request, if any */
	protected $order;


	/**
	 * Gets an order's address data, formatted for the CyberSource API.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 * @param string $type address type - billing or shipping
	 * @return array
	 */
	protected function get_order_address_data( \WC_Order $order, $type = 'billing' ) {

		$address = [];
		$fields  = [
			'first_name',
			'last_name',
			'company',
			'address_1',
			'address_2',
			'city',
			'state',
			'postcode',
			'country',
			'email',
			'phone',
		];

		foreach( $fields as $field ) {

			$method = "get_{$type}_{$field}";

			if ( is_callable( [ $order, $method ] ) ) {
				$address[ $field ] = $order->$method();
			}
		}

		return $this->get_formatted_address_data( $address );
	}


	/**
	 * Formats a WooCommerce address for the CyberSource API.
	 *
	 * @since 2.0.0
	 *
	 * @param array $address WooCommerce address data
	 * @return array
	 */
	protected function get_formatted_address_data( array $address = [] ) {

		$address = wp_parse_args( $address, [
			'first_name' => '',
			'last_name'  => '',
			'company'  => '',
			'address_1' => '',
			'address_2' => '',
			'city'      => '',
			'state'     => '',
			'postcode'  => '',
			'country'   => '',
			'email'     => '',
			'phone'   => '',
		] );  

		// $region = get_terms( array(
		// 	"taxonomy"=>"region",
		// 	'hide_empty' => false, 
		// 	"slug"=>$address["state"]
		//   ) );
		// $region_term_id = array_column($region,"term_id")[0];
		// $state = get_field("state_abbreviation","region_".$region_term_id);
		$formatted_address = [
			'forename'          => Framework\SV_WC_Helper::str_truncate( $address['first_name'], 60, '' ),
			'surname'           => Framework\SV_WC_Helper::str_truncate( $address['last_name'], 60, '' ),
			'company_name'            => Framework\SV_WC_Helper::str_truncate( $address['company'], 60, '' ),
			'address_line1'           => Framework\SV_WC_Helper::str_truncate( $address['address_1'], 60, '' ),
			'address_line2'           => Framework\SV_WC_Helper::str_truncate( $address['address_2'], 60, '' ),
			'address_city'           => Framework\SV_WC_Helper::str_truncate( $address['city'], 50, '' ),
			'address_state' => Framework\SV_WC_Helper::str_truncate( $address["state"], 3, '' ),
			'address_postal_code'         => Framework\SV_WC_Helper::str_truncate( $address['postcode'], 10, '' ),
			'address_country'            => Framework\SV_WC_Helper::str_truncate( $address['country'], 3, '' ),
			'email'              => Framework\SV_WC_Helper::str_truncate( $address['email'], 320, '' ),
			'phone'        => Framework\SV_WC_Helper::str_truncate( preg_replace( '/[^-\d().]/', '', $address['phone'] ), 32, '' ),
		];

		return array_filter( $formatted_address );
	}


	/**
	 * Gets the request data.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	public function get_data() {

		/**
		 * CyberSource API Request Data.
		 *
		 * Allow actors to modify the request data before it's sent to CyberSource
		 *
		 * @since 2.0.0
		 *
		 * @param array|mixed $data request data to be filtered
		 * @param \WC_Order $order order instance
		 * @param Request $this, API request class instance
		 */
		$this->data = apply_filters( 'wc_cybersource_api_request_data', $this->data, $this );

		return $this->data;
	}


	/**
	 * Gets the order associated with the request, if any.
	 *
	 * @since 2.0.0
	 *
	 * @return \WC_Order|null
	 */
	public function get_order() {

		return $this->order;
	}


}
