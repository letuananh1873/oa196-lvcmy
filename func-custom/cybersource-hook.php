<?php
/**
 * Create Live Chat Webhook Enpoint
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if(!class_exists('Cybersource_hook')) {
    
    class Cybersource_hook {
        function __construct() {
            $this::add_hooks();
        }

        function add_hooks() {
            add_action( 'rest_api_init', [$this, 'create_endpoint']);
        }


        function create_endpoint() {
            register_rest_route( 'cbs_pg', '/update_order', array(
                'methods' => 'POST',
                'callback' => [$this, 'update_order'],
                // 'permission_callback' => function() { return ''; }
            ) );
        }

        function update_order($req) {
            $data = $req->get_body();
            update_option('start_cybersource_data', json_encode($data));
            $data_arr = explode("&", $data);
            $new_data = [];
            foreach($data_arr as $item) {
                $item_arr = explode("=", $item);
                $new_data[$item_arr[0]] = $item_arr[1];
            }

            $decision = $new_data['decision'];
            wp_mail('devtest0909@gmail.com','test cybercouser',$decision);
            $req_reference_number = $new_data['req_reference_number'];
            $decision_reason_code = $new_data['decision_reason_code'];
            
            $order = new WC_Order($req_reference_number);
            if(isset($new_data["transaction_id"])) {
                update_post_meta( $order->get_id(), '_wc_cybersource_trans_id', $new_data["transaction_id"]);
            }
            if($decision === "ACCEPT") {
                $order->update_status('processing', "Credit Card Transaction Approved.");
            } else if($decision === "REVIEW") {
                $order->update_status('on-hold', "The authorization request was approved by the issuing bank but declined by CyberSource because it did not pass the CVN check.  
                You must log into your CyberSource account and decline or settle the transaction.");
            } else {
                $note = "";
				switch( $decision_reason_code ) {
					case 202: $note = 'The provided card is expired.';
					case 203: $note = 'The provided card was declined.';
					case 204: $note = 'Insufficient funds in account.';
					case 208: $note = 'The card is inactivate or not authorized for card-not-present transactions.';
					case 210: $note = 'The credit limit for the card has been reached.';
					case 211: $note = 'The card verification number is invalid.';
					case 231: $note = 'The provided card number was invalid, or card type was incorrect.';
					case 232: $note = 'That card type is not accepted.';
					case 240: $note = 'The card type is invalid or does not correlate with the credit card number.';
				}

                $order->update_status("failed", $note);
            }

            return $data;
        }
    }
    
    new Cybersource_hook;
}