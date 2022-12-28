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

defined( 'ABSPATH' ) or exit;

use SkyVerge\WooCommerce\PluginFramework\v5_5_4 as Framework;

/**
 * WooCommerce CyberSource Gateway main plugin class.
 *
 * @since 2.0.0
 */
class Plugin extends Framework\SV_WC_Payment_Gateway_Plugin {


	/** version number */
	const VERSION = '2.0.7';

	/** @var Plugin single instance of this plugin */
	protected static $instance;

	/** gateway id */
	const PLUGIN_ID = 'cybersource';

	/** class name to load as gateway, can be base or subscriptions class */
	const CREDIT_CARD_GATEWAY_CLASS_NAME = Gateway\Credit_Card::class;

	/** string gateway id */
	const CREDIT_CARD_GATEWAY_ID = 'cybersource_credit_card';

	/** class name to load as gateway, can be base or subscriptions class */
	const ECHECK_GATEWAY_CLASS_NAME = Gateway\Electronic_Check::class;

	/** string gateway id */
	const ECHECK_GATEWAY_ID = 'cybersource_echeck';

	/** class name to load as legacy gateway, for existing installations */
	const LEGACY_GATEWAY_CLASS_NAME = Legacy\Gateway::class;

	/** string gateway id */
	const LEGACY_GATEWAY_ID = 'cybersource';


	/**
	 * Initializes the main plugin class.
	 *
	 * @since 1.0
	 */
	public function __construct() {

		parent::__construct(
			self::PLUGIN_ID,
			self::VERSION,
			[
				'text_domain'  => 'woocommerce-gateway-cybersource',
				'gateways'     => $this->get_active_gateways(),
				'dependencies' => $this->get_active_dependencies(),
				'supports'     => $this->get_active_features(),
				'require_ssl'  => true,
			]
		);

		// handle toggling legacy integration
		add_action( 'admin_action_wc_' . $this->get_id() . '_toggle_legacy', [ $this, 'toggle_legacy' ] );

		// handle migrating historical orders
		add_action( 'wp_ajax_wc_' . $this->get_id() . '_migrate_orders', [ $this, 'migrate_legacy_orders' ] );
	}

 
	/**
	 * Gets the currently active gateways.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	private function get_active_gateways() {

		if ( $this->is_legacy_active() ) {

			$gateways = [
				self::LEGACY_GATEWAY_ID => self::LEGACY_GATEWAY_CLASS_NAME,
			];

		} else {

			$gateways = [
				self::CREDIT_CARD_GATEWAY_ID => self::CREDIT_CARD_GATEWAY_CLASS_NAME,
				self::ECHECK_GATEWAY_ID      => self::ECHECK_GATEWAY_CLASS_NAME,
			];
		}

		return $gateways;
	}


	/**
	 * Gets the dependencies for the currently active gateway.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	private function get_active_dependencies() {

		if ( $this->is_legacy_active() ) {

			$dependencies = [
				'php_extensions' => [
					'soap',
					'dom',
				],
			];

		} else {

			$dependencies = [
				'php_extensions' => [
					'curl',
					'json',
					'mbstring',
				],
			];

		}

		return $dependencies;
	}


	/**
	 * Gets the supported features for the currently active gateways.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	private function get_active_features() {

		$features = [];

		if ( ! $this->is_legacy_active() ) {

			$features = [
				self::FEATURE_CAPTURE_CHARGE,
				self::FEATURE_MY_PAYMENT_METHODS,
			];
		}

		return $features;
	}


	/**
	 * Determines if the legacy integration is active.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	private function is_legacy_active() {

		// note: Framework\SV_WC_Plugin::get_id() cannot be used as it's not set early enough in some cases
		return 'yes' === get_option( 'wc_' . self::PLUGIN_ID . '_legacy_active', 'no' );
	}


	/**
	 * Gets the plugin action links.
	 *
	 * @since 2.0.0
	 *
	 * @param array $actions action names => anchor tags
	 * @return array
	 */
	public function plugin_action_links( $actions ) {

		$actions = parent::plugin_action_links( $actions );

		// if the legacy gateway is active, offer switching to the new gateway
		if ( $this->is_legacy_active() ) {

			$toggle_link_text = __( 'Use the new CyberSource Gateway', 'woocommerce-gateway-cybersource' );
			$insert_after_key = 'configure_' . self::LEGACY_GATEWAY_ID;

		// or allow switching to the Legacy gateway if it was previously configured
		// we only want to check that the option exists, regardless of value
		} elseif ( get_option( 'wc_' . self::PLUGIN_ID . '_legacy_active', false ) ) {

			$toggle_link_text = __( 'Use CyberSource Legacy', 'woocommerce-gateway-cybersource' );
			$insert_after_key = 'configure_' . self::ECHECK_GATEWAY_ID;

		// otherwise for new installs, consider the latest gateways the only option
		} else {

			return $actions;
		}

		$url = wp_nonce_url( add_query_arg( 'action', 'wc_' . $this->get_id() . '_toggle_legacy', 'admin.php' ), $this->get_file() );

		$toggle_link = [
			'toggle_legacy' => sprintf( '<a href="%1$s" title="%2$s">%2$s</a>', esc_url( $url ), esc_html( $toggle_link_text ) ),
		];

		return Framework\SV_WC_Helper::array_insert_after( $actions, $insert_after_key, $toggle_link );
	}


	/**
	 * Gets a gateway's settings link.
	 *
	 * @since 2.0.0
	 *
	 * @param string|null $gateway_id gateway ID
	 * @return string
	 */
	public function get_settings_link( $gateway_id = null ) {

		switch ( $gateway_id ) {

			case self::LEGACY_GATEWAY_ID:
				$label = __( 'Configure', 'woocommerce-gateway-cybersource' );
				break;

			case self::ECHECK_GATEWAY_ID:
				$label = __( 'Configure eChecks', 'woocommerce-gateway-cybersource' );
				break;

			default:
				$label = __( 'Configure Credit Cards', 'woocommerce-gateway-cybersource' );
		}

		return sprintf( '<a href="%s">%s</a>',
			$this->get_settings_url( $gateway_id ),
			esc_html( $label )
		);
	}


	/**
	 * Handles toggling the legacy integration.
	 *
	 * @since 2.0.0
	 */
	public function toggle_legacy() {

		// security check
		if ( ! wp_verify_nonce( $_GET['_wpnonce'], $this->get_file() ) || ! current_user_can( 'manage_woocommerce' ) ) {
			wp_redirect( wp_get_referer() );
			exit;
		}

		update_option( 'wc_' . self::PLUGIN_ID . '_legacy_active', $this->is_legacy_active() ? 'no' : 'yes' );

		// switching to the new gateway
		if ( $this->is_legacy_active() ) {

			// delete option to show the Migrate Orders button again for credit card orders
			// (no need to clear the analogous e-check option, as the legacy gateway does not support e-check orders)
			delete_option( 'wc_' . self::CREDIT_CARD_GATEWAY_ID . '_legacy_orders_migrated' );
		}

		$return_url = add_query_arg( [ 'legacy_toggled' => 1 ], 'plugins.php' );

		// back from whence we came
		wp_redirect( $return_url );
		exit;
	}


	/**
	 * Handles migrating historical orders (Legacy or SOP).
	 *
	 * @since 2.0.0-dev.5
	 */
	public function migrate_legacy_orders() {

		check_admin_referer( 'wc_cybersource_migrate_orders', 'nonce' );

		if ( self::CREDIT_CARD_GATEWAY_ID === $_REQUEST[ 'gateway_id' ] ) {

			// from legacy to new credit card
			$this->get_lifecycle_handler()->migrate_legacy_cc_orders();

			// from SOP credit card to new credit card
			$this->get_lifecycle_handler()->migrate_sop_cc_orders();

		} else {

			// from SOP e-check to new e-check
			$this->get_lifecycle_handler()->migrate_sop_echeck_orders();

		}

		delete_option( 'wc_' . $this->get_id() . '_migrated_from_sop' );

		// option not to show the action anymore
		update_option( 'wc_' . $_REQUEST['gateway_id'] . '_legacy_orders_migrated', 'yes' );

		// arg to go back whence we came and display the success message once
		wp_send_json_success( add_query_arg( [ 'legacy_orders_migrated' => 1 ], $this->get_settings_url( $_REQUEST['gateway_id'] ) ) );

		wp_die();
	}


	/**
	 * Builds the lifecycle handler instance.
	 *
	 * @since 1.9.0
	 */
	protected function init_lifecycle_handler() {

		$this->lifecycle_handler = new Lifecycle( $this );
	}


	/**
	 * Gets the plugin documentation url, which for CyberSource is non-standard.
	 *
	 * @since 1.2
	 *
	 * @return string documentation URL
	 */
	public function get_documentation_url() {

		return 'http://docs.woocommerce.com/document/cybersource-payment-gateway/';
	}


	/**
	 * Gets the plugin sales page URL.
	 *
	 * @since 1.9.0
	 *
	 * @return string
	 */
	public function get_sales_page_url() {

		return 'https://woocommerce.com/products/cybersource-payment-gateway/';
	}


	/**
	 * Gets the plugin support URL.
	 *
	 * @since 1.4.0
	 *
	 * @return string
	 */
	public function get_support_url() {

		return 'https://woocommerce.com/my-account/marketplace-ticket-form/';
	}


	/**
	 * Shows admin notices.
	 *
	 * @internal
	 *
	 * @since 1.9.0
	 */
	public function add_admin_notices() {

		parent::add_admin_notices();

		if ( 'yes' === get_option( 'woocommerce_cybersource_show_timeout_notice', 'no' ) ) {

			$message = sprintf(
			/* translators: Placeholders: %1$s - <strong> tag, %2$s - </strong> tag, %3$s - <code> tag, %4$s - </code> tag */
				__( '%1$sCyberSource Gateway%2$s: A request to CyberSource timed out. Try increasing the value of %3$sdefault_socket_timeout%4$s in your PHP configuration to prevent future timeouts.', 'woocommerce-gateway-cybersource' ),
				'<strong>', '</strong>',
				'<code>', '</code>'
			);

			$this->get_admin_notice_handler()->add_admin_notice( $message, 'increase-socket-timeout', [
				'notice_class' => 'notice-warning',
			] );
		}

		// legacy toggle notice
		if ( isset( $_GET['legacy_toggled'] ) ) {

			$message = $this->is_legacy_active() ? __( 'CyberSource Legacy Gateway is now active.', 'woocommerce-gateway-cybersource' ) : __( 'CyberSource Gateway is now active.', 'woocommerce-gateway-cybersource' );

			$this->get_admin_notice_handler()->add_admin_notice( $message, 'legacy-toggled', [ 'dismissible' => false ] );
		}

		// orders migration notice
		if ( isset( $_GET['legacy_orders_migrated'] ) ) {

			$this->get_admin_notice_handler()->add_admin_notice(
				__( 'Migration successful! Your historical orders will now use the new CyberSource gateway.', 'woocommerce-gateway-cybersource' ),
				'orders-migration-notice',
				[ 'notice_class' => 'updated' ]
			);

		}

		// SOP migration notice
		if ( get_option( 'wc_' . $this->get_id() . '_migrated_from_sop', false ) ) {

			$this->get_admin_notice_handler()->add_admin_notice(
				sprintf(
					/* translators: Placeholders: %1$s - <strong> tag, %2$s - </strong> tag, %3$s - <a> tag, %4$s - </a> tag, %5$s - <a> tag, %6$s - </a> tag */
					__( '%1$sMigration successful!%2$s The new WooCommerce CyberSource plugin has been installed and activated on your site. %3$sClick here to learn how to retrieve the credentials needed to start accepting payments.%4$s Once you\'ve saved these credentials in the %5$splugin settings%6$s, you can migrate orders from SOP if you\'d like to manage those on the new gateway and deactivate the SOP plugin.', 'woocommerce-gateway-cybersource' ),
					'<strong>', '</strong>',
					'<a href="https://docs.woocommerce.com/document/cybersource-payment-gateway/#section-5">', '</a>',
					'<a href="' . esc_url( $this->get_settings_url( self::CREDIT_CARD_GATEWAY_ID ) ) . '">', '</a>'
				),
				'sop-migration-notice',
				[
					'notice_class'            => 'updated',
					'always_show_on_settings' => false,
				]
			);
		}

		if ( empty( get_option( 'woocommerce_' . self::CREDIT_CARD_GATEWAY_ID . '_settings', [] ) ) && empty( get_option( 'woocommerce_' . self::ECHECK_GATEWAY_ID . '_settings', [] ) ) ) {

			$this->get_admin_notice_handler()->add_admin_notice(
				sprintf(
					/** translators: Placeholders: %1$s - settings <a> tag, %2$s - settings </a> tag, %3$s - <a> documentation tag, %4$s - </a> documentation tag */
					__( 'Thank you for installing the WooCommerce CyberSource Gateway! To start accepting payments, %1$sset your CyberSource API credentials%2$s. Need help? See the %3$sdocumentation%4$s.', 'woocommerce-gateway-cybersource' ),
					'<a href="' . $this->get_settings_url() . '">', '</a>',
					'<a target="_blank" href="' . $this->get_documentation_url() . '">', '</a>'
				),
				'install-notice'
			);
		}
	}


	/**
	 * Returns the main CyberSource Instance.
	 *
	 * Ensures only one instance is/can be loaded.
	 *
	 * @since 1.3.0
	 *
	 * @return Plugin
	 */
	public static function instance() {

		if ( null === self::$instance ) {

			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * Returns the plugin name, localized.
	 *
	 * @since 1.2
	 *
	 * @return string the plugin name
	 */
	public function get_plugin_name() {

		return __( 'WooCommerce CyberSource', 'woocommerce-gateway-cybersource' );
	}


	/**
	 * Returns __FILE__.
	 *
	 * @since 1.2
	 *
	 * @return string the full path and filename of the plugin file
	 */
	protected function get_file() {

		return __DIR__;
	}

	
	/**
	 * Returns the loaded payment gateway framework path, without trailing slash.
	 *
	 * This is the highest version payment gateway framework that was loaded by
	 * the bootstrap.
	 *
	 * @since 4.0.0
	 *
	 * @return string
	 */
	public function get_payment_gateway_framework_path() {

		return get_template_directory()."/gateway_cybersource_1/vendor/skyverge/wc-plugin-framework/woocommerce/payment-gateway";
	}

	/**
	 * Returns the loaded payment gateway framework assets URL, without a trailing slash
	 *
	 * @since 4.0.0
	 *
	 * @return string
	 */
	public function get_payment_gateway_framework_assets_url() {

		return get_template_directory_uri()."/gateway_cybersource_1/vendor/skyverge/wc-plugin-framework/woocommerce/payment-gateway/assets";
	}

}
