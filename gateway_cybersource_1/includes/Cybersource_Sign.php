<?php

namespace SkyVerge\WooCommerce\Cybersource;
defined( 'ABSPATH' ) or exit;
class Cybersource_Sign{
	const HMAC_SHA256 = "sha256";	
    private $signature = "";   

    /**
     * Undocumented function
     *
     * @param array $params
     */
    public function __construct($params){   
    	/*echo '<pre>';
    	var_dump($params);
    	echo '</pre>';
    	exit;*/

        $this->signature = $this->sign($params);
    }
    function get_signature(){
        return $this->signature;
    }

	protected function sign ($params) {
		$secret_key = $params['secret_key'];
		
		return $this->signData($this->buildDataToSign($params), $secret_key);
	}
	
	protected function signData($data, $secretKey) {
		return base64_encode(hash_hmac('sha256', $data, $secretKey, true));
	}
	
	protected function buildDataToSign($params) {
		if(is_array($params)){ 
			$signedFieldNames = explode(",",$params["signed_field_names"]);
			foreach ($signedFieldNames as $field) {
				$dataToSign[] = $field . "=" . $params[$field];
			}
		}else if(is_object($params)){
			$signedFieldNames = explode(",",$params->signed_field_names);
			foreach ($signedFieldNames as $field) {
				$dataToSign[] = $field . "=" . $params->$field;
			}
		}
		return $this->commaSeparate($dataToSign);
	}
	
	protected function commaSeparate ($dataToSign) {
		return implode(",",$dataToSign);
	}

}