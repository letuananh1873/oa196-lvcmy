<?php  
  class GDEX_Consignment_Data{ 
        public $shipmentType="Parcel";
        public $totalPiece=0;        
        public $shipmentValue=0;
        public $shipmentWeight=0;        
        public $isDangerousGoods = false;        
        public $receiverName ="";        
        public $receiverAddress1 = "";
        public $receiverAddress2 = "";       
        public $receiverPostcode = "";       
        public $receiverCountry = "";
         

        public function __construct($order){
            $this->update_order($order);
        }
        public function update_order($order){ 
          $this->update_properties($order);
        } 
        protected function update_properties($order){
            $this->shipmentType="Parcel";
            $this->totalPiece=1;            
            $this->shipmentValue = floatval($order->get_total());
            $this->shipmentWeight=0.5; 
            $this->isDangerousGoods = false;             
            $this->receiverName = $order->get_shipping_last_name()." ".$order->get_shipping_first_name();
            
            $this->receiverMobile = preg_replace("/[^0-9\+]/","",get_post_meta($order->get_id(),"_shipping_phone",true) ? get_post_meta($order->get_id(),"_shipping_phone",true) : $order->get_billing_phone());
            // $this->receiverMobile2 ="";
            $this->receiverEmail = $order->get_billing_email();
            $this->receiverAddress1 = $order->get_shipping_address_1();
            $this->receiverAddress2 = $order->get_shipping_address_2();
            // $this->receiverAddress3 = "";
            $this->receiverPostcode = $order->get_shipping_postcode(); 
            $this->receiverCity = $order->get_shipping_city();
            $this->receiverState = $order->get_shipping_state();
            $this->receiverCountry =  WC()->countries->countries[ $order->get_shipping_country() ];
            $note1 = get_field("gdex_customer_note_1","option") ? get_field("gdex_customer_note_1","option") : "";
            $this->note1=$note1;
           
            $this->orderID= strval($order->get_id());
            
        }
  }
  class GDEX_Consignment{ 
        protected $data = array();
        protected $headers_default =  array(
          // Request headers
          'ApiToken: ',
        'Subscription-Key: ',
        );  
        public $response;
        public $response_get_consignment_status_detail;
        public $response_cancel_consignment;
        public $schema;
        public $validate;
        
        public $schema_json = '{
          "uniqueItems": false,
          "type": "array",
          "items": {
            "required": [
              "shipmentType",
              "totalPiece",
              "shipmentWeight",
              "receiverName",
              "receiverAddress1",
              "receiverPostcode",
              "receiverCountry"
            ],
            "type": "object",
            "properties": {
              "shipmentType": {
                "enum": [
                  "Document",
                  "Parcel",
                  "DocumentAndParcel",
                  "Pallet",
                  "ChequeForGDEX"
                ],
                "type": "string"
              },
              "totalPiece": {
                "format": "int32",
                "type": "integer"
              },
              "shipmentContent": {
                "maxLength": 100,
                "minLength": 0,
                "type": "string"
              },
              "shipmentValue": {
                "format": "double",
                "type": "number"
              },
              "shipmentWeight": {
                "format": "double",
                "type": "number"
              },
              "shipmentLength": {
                "format": "double",
                "type": "number"
              },
              "shipmentWidth": {
                "format": "double",
                "type": "number"
              },
              "shipmentHeight": {
                "format": "double",
                "type": "number"
              },
              "isDangerousGoods": {
                "type": "boolean"
              },
              "companyName": {
                "maxLength": 40,
                "minLength": 0,
                "type": "string"
              },
              "receiverName": {
                "maxLength": 100,
                "minLength": 0,
                "type": "string"
              },
              "receiverMobile": {
                "maxLength": 15,
                "minLength": 0,
                "type": "string"
              },
              "receiverMobile2": {
                "maxLength": 13,
                "minLength": 0,
                "type": "string"
              },
              "receiverEmail": {
                "type": "string"
              },
              "receiverAddress1": {
                "maxLength": 255,
                "minLength": 0,
                "type": "string"
              },
              "receiverAddress2": {
                "maxLength": 255,
                "minLength": 0,
                "type": "string"
              },
              "receiverAddress3": {
                "maxLength": 255,
                "minLength": 0,
                "type": "string"
              },
              "receiverPostcode": {
                "maxLength": 5,
                "minLength": 0,
                "type": "string"
              },
              "receiverCity": {
                "maxLength": 60,
                "minLength": 0,
                "type": "string"
              },
              "receiverState": {
                "maxLength": 60,
                "minLength": 0,
                "type": "string"
              },
              "receiverCountry": {
                "enum": [
                  "Aruba",
                  "AntiguaAndBarbuda",
                  "Algeria",
                  "Azerbaijan",
                  "Albania",
                  "Armenia",
                  "Andorra",
                  "AmericanSamoa",
                  "Argentina",
                  "Australia",
                  "Austria",
                  "Anguilla",
                  "Bahrain",
                  "Barbados",
                  "Botswana",
                  "Bermuda",
                  "Belgium",
                  "Bahamas",
                  "The",
                  "Bangladesh",
                  "Belize",
                  "BosniaAndHerzegovina",
                  "Bolivia",
                  "Myanmar",
                  "Benin",
                  "Belarus",
                  "SolomonIslands",
                  "Brazil",
                  "Bulgaria",
                  "Brunei",
                  "Canada",
                  "Cambodia",
                  "Chad",
                  "SriLanka",
                  "Congo",
                  "RepublicOfThe",
                  "China",
                  "Chile",
                  "CaymanIslands",
                  "Cameroon",
                  "Colombia",
                  "NorthernMarianaIslands",
                  "CostaRica",
                  "CentralAfricanRepublic",
                  "CapeVerde",
                  "CookIslands",
                  "Cyprus",
                  "Denmark",
                  "Djibouti",
                  "Dominica",
                  "DominicanRepublic",
                  "Ecuador",
                  "Egypt",
                  "Ireland",
                  "EquatorialGuinea",
                  "Estonia",
                  "Eritrea",
                  "ElSalvador",
                  "Ethiopia",
                  "CzechRepublic",
                  "FrenchGuiana",
                  "Finland",
                  "Fiji",
                  "Micronesia",
                  "FaroeIslands",
                  "FrenchPolynesia",
                  "France",
                  "Gambia",
                  "Gabon",
                  "Georgia",
                  "Ghana",
                  "Gibraltar",
                  "Grenada",
                  "Greenland",
                  "Germany",
                  "Guadeloupe",
                  "Guam",
                  "Greece",
                  "Guatemala",
                  "Guinea",
                  "Guyana",
                  "Haiti",
                  "HongKong",
                  "Honduras",
                  "Croatia",
                  "Hungary",
                  "Iceland",
                  "Indonesia",
                  "India",
                  "Italy",
                  "CoteDIvoire",
                  "Japan",
                  "Jamaica",
                  "Jordan",
                  "Kenya",
                  "Kyrgyzstan",
                  "Kiribati",
                  "Korea",
                  "South",
                  "Kuwait",
                  "Kazakhstan",
                  "Laos",
                  "Lebanon",
                  "Latvia",
                  "Lithuania",
                  "Liberia",
                  "Slovakia",
                  "Liechtenstein",
                  "Lesotho",
                  "Luxembourg",
                  "Libya",
                  "Madagascar",
                  "Martinique",
                  "Macau",
                  "Moldova",
                  "Mongolia",
                  "Montserrat",
                  "Malawi",
                  "Macedonia",
                  "Mali",
                  "Monaco",
                  "Morocco",
                  "Mauritius",
                  "Mauritania",
                  "Malta",
                  "Oman",
                  "Maldives",
                  "Mexico",
                  "Malaysia",
                  "Mozambique",
                  "NewCaledonia",
                  "NorfolkIsland",
                  "Niger",
                  "Vanuatu",
                  "Nigeria",
                  "Netherlands",
                  "Norway",
                  "Nepal",
                  "Suriname",
                  "NetherlandsAntilles",
                  "Nicaragua",
                  "NewZealand",
                  "Paraguay",
                  "Peru",
                  "Pakistan",
                  "Poland",
                  "Panama",
                  "Portugal",
                  "PapuaNewGuinea",
                  "Palau",
                  "GuineaBissau",
                  "Qatar",
                  "Reunion",
                  "MarshallIslands",
                  "Romania",
                  "Philippines",
                  "PuertoRico",
                  "Rwanda",
                  "SaudiArabia",
                  "SaintKittsAndNevis",
                  "Seychelles",
                  "SouthAfrica",
                  "Senegal",
                  "Slovenia",
                  "SierraLeone",
                  "SanMarino",
                  "Singapore",
                  "Spain",
                  "SaintLucia",
                  "Sweden",
                  "Switzerland",
                  "UnitedArabEmirates",
                  "TrinidadAndTobago",
                  "Thailand",
                  "Tajikistan",
                  "TurksAndCaicosIslands",
                  "Tonga",
                  "Togo",
                  "Tunisia",
                  "Turkey",
                  "Tuvalu",
                  "Taiwan",
                  "Tanzania",
                  "Uganda",
                  "UnitedKingdom",
                  "UnitedStatesOfAmerica",
                  "BurkinaFaso",
                  "Uruguay",
                  "Uzbekistan",
                  "StVincentandTheGrenadines",
                  "Venezuela",
                  "BritishVirginIslands",
                  "Vietnam",
                  "VirginIslands",
                  "Namibia",
                  "WallisAndFutuna",
                  "WakeIsland",
                  "Samoa",
                  "Swaziland",
                  "Yemen",
                  "Zambia",
                  "Zimbabwe"
                ],
                "type": "string"
              },
              "IsInsurance": {
                "type": "boolean"
              },
              "note1": {
                "maxLength": 50,
                "minLength": 0,
                "type": "string"
              },
              "note2": {
                "maxLength": 50,
                "minLength": 0,
                "type": "string"
              },
              "orderID": {
                "maxLength": 30,
                "minLength": 0,
                "type": "string"
              },
              "doNumber1": {
                "maxLength": 20,
                "minLength": 0,
                "type": "string"
              },
              "doNumber2": {
                "maxLength": 20,
                "minLength": 0,
                "type": "string"
              },
              "doNumber3": {
                "maxLength": 20,
                "minLength": 0,
                "type": "string"
              },
              "doNumber4": {
                "maxLength": 20,
                "minLength": 0,
                "type": "string"
              },
              "doNumber5": {
                "maxLength": 20,
                "minLength": 0,
                "type": "string"
              },
              "doNumber6": {
                "maxLength": 20,
                "minLength": 0,
                "type": "string"
              },
              "doNumber7": {
                "maxLength": 20,
                "minLength": 0,
                "type": "string"
              },
              "doNumber8": {
                "maxLength": 20,
                "minLength": 0,
                "type": "string"
              },
              "doNumber9": {
                "maxLength": 20,
                "minLength": 0,
                "type": "string"
              }
            },
            "example": {
              "shipmentType": "Parcel",
              "totalPiece": 3,
              "shipmentContent": "Office Document",
              "shipmentValue": 200,
              "shipmentWeight": 10,
              "shipmentLength": 5,
              "shipmentWidth": 0,
              "shipmentHeight": 0,
              "isDangerousGoods": true,
              "companyName": "myGDEX Prime",
              "receiverName": "Seng See",
              "receiverMobile": "01139167123",
              "receiverMobile2": "",
              "receiverEmail": "myGDexPrime@Example.com",
              "receiverAddress1": "No 23, Mardan Road",
              "receiverAddress2": "Golder Park",
              "receiverAddress3": "",
              "receiverPostcode": "46000",
              "receiverCity": "Petaling jaya",
              "receiverState": "Selangor",
              "receiverCountry": "Malaysia",
              "IsInsurance": false,
              "note1": "",
              "note2": "",
              "orderID": "",
              "doNumber1": "",
              "doNumber2": "",
              "doNumber3": "",
              "doNumber4": "",
              "doNumber5": "",
              "doNumber6": "",
              "doNumber7": "",
              "doNumber8": "",
              "doNumber9": ""
            }
          }
        }';
        public $error = array();
        private $mode_production;
        protected $url = array(

        );
      public function __construct(){  
        $mode_production = get_field("gdex_mode_production","option");
        $this->mode_production = $mode_production ? true : false; 
        if($this->mode_production){
          $gdex_api_key = get_field("gdex_api_key","option"); 
          $gdex_subscription_key = get_field("gdex_subscription_key","option"); 
          $this->url = array(
            "CreateConsignment"=>"https://myopenapi.gdexpress.com/api/prime/CreateConsignment",
            "GetLastShipmentStatus"=>"https://myopenapi.gdexpress.com/api/prime/GetLastShipmentStatus",
            "CancelConsignment"=>"https://myopenapi.gdexpress.com/api/prime/CancelConsignment?consignmentNumber=",
            "GetPostCodeLocation"=>"https://myopenapi.gdexpress.com/api/prime/GetPostCodeLocation/"
          );
        }else{
          $gdex_api_key = get_field("gdex_api_key_test","option"); 
          $gdex_subscription_key = get_field("gdex_subscription_key_test","option");
          $this->url = array(
            "CreateConsignment"=>"https://myopenapi.gdexpress.com/api/demo/prime/CreateConsignment",
            "GetLastShipmentStatus"=>"https://myopenapi.gdexpress.com/api/demo/prime/GetLastShipmentStatus",
            "CancelConsignment"=>"https://myopenapi.gdexpress.com/api/demo/prime/CancelConsignment?consignmentNumber=",
            "GetPostCodeLocation"=>"https://myopenapi.gdexpress.com/api/demo/prime/GetPostCodeLocation/"
          );
        }
        if($gdex_api_key && $gdex_subscription_key){ 
          $this->headers_default[0] .= $gdex_api_key;
          $this->headers_default[1] .= $gdex_subscription_key; 
        }
      }
      
      function process_response($order){
        $state = false;
         if(isset($this->response)){
           if($this->response->s == "success"){
              $this->consignmentNumber = $this->response->r[0];
              $state = true;
           }
         }
         if(!$state){
          //  save error  
              $message = "error :".json_encode($this->response);
              $this->order_log($order->get_id(),$message); 
         }else{ 
              $message = "success :".json_encode($this->response);
              $this->order_log($order->get_id(),$message);  
              update_post_meta( $order->get_id(), '_order_tracking_id', $this->consignmentNumber );
         }
      }
      function order_log($order_id,$message){ 
        // $gdex_note = get_field("gdex_log",$order_id) ? get_field("gdex_log",$order_id) : "";
        $gdex_note ="";
        $gdex_note .=$message;
        update_post_meta($order_id,"_order_gdex_log",$gdex_note);  
      }
      public function validate($k,$v){
            $properties = $this->schema->items->properties; 
            // var_dump($k);
            // var_dump($v);
            foreach($properties as $k2 => $v2){ 
                if($k2 == $k){
                  if(isset($v2->enum)){  
                        if(!in_array($v,$v2->enum)){ 
                          $this->error[] = "not exists property in enum. ".$v;  
                        }
                  } 
                  if(isset($v2->type)){
                    if($v2->type == "string"){ 
                      if(!is_string($v)){ 
                        $this->error[] = "not is string. ".$k."-".$v; 
                      } 
                      if(isset($v2->maxLength)){
                        if(strlen($v) > $v2->maxLength){ 
                        $this->error[] = "greater than maxLength. ".$v; 
                        }
                      }
                    }else if($v2->type == "integer"){
                      if(!is_int($v)){
                        
                        $this->error[] = "not is int. ".$v; 
                      } 
                    }else if($v2->type == "number" && $v2->format == "double"){
                      if(!is_float($v) && !is_int($v)){
                        
                        $this->error[] = "not is float. ".$v; 
                      } 
                    }else if($v2->type == "boolean"){
                      if(!is_bool($v)){
                        $this->error[] = "not is bool. ".$v; 
                      }
                    }
                  }
                }
            } 
      }
      public function validates($obj){
        if(!is_object($obj)) return false; 
        foreach($obj as $k => $v){   
          $this->validate($k,$v);
        }   
      } 
      public function update_data($order){
        $data_item = new GDEX_Consignment_Data($order); 
        $this->validates($data_item);
        // var_dump($this->validate);
        // var_dump($this->error); 
        array_push($this->data,$data_item);

      } 
      public function create_consignment_order($order){
        $order_id = $order->get_id();
        $order_tracking = get_post_meta($order_id,"_order_tracking_id",true);
        $flag = true;
        if($order_tracking){ 
          $this->get_consignment_status_detail(array( $order_id => $order_tracking));
          $consignment_note_status =  get_post_meta($order_id,"_gdex_consignment_note_status",true) ?  strtolower(get_post_meta($order_id,"_gdex_consignment_note_status",true)) : "";
          if($consignment_note_status != "cancelled" || $consignment_note_status != ""){
            $flag = false;
            $message = "error: Consignment not status not is cancel. Status is ".$consignment_note_status;
            $this->order_log($order_id,$message);
          }
        }
        if($flag){
          $this->schema = json_decode($this->schema_json); 
          $this->update_data($order);   
          $this->send_create_consignment_order();
          $this->process_response($order); 
        }
        
      }
      public function send_create_consignment_order(){
        $headers = $this->headers_default;
        $headers[] = "Content-Type: application/json-patch+json";   
        $url = $this->url["CreateConsignment"]; 
        $ch = curl_init();  
        $data = json_encode($this->data); 
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
        curl_setopt($ch, CURLOPT_POST, true);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = json_decode(curl_exec($ch));  
        curl_close($ch);   
        $this->response = $response;   
      }
      public function get_consignment_status_detail($orders_tracking){
        $this->send_get_shipment_status_detail($orders_tracking);   
        return $this->process_response_get_consignment_status_detail($orders_tracking); 
      }
      function process_response_get_consignment_status_detail($orders_tracking){  
        if(isset($this->response_get_consignment_status_detail)){
          if($this->response_get_consignment_status_detail->s == "success"){ 
            return $this->process_response_get_consignment_status_detail_success($orders_tracking);
          }
        }else{
          return array();
        }
      }
      function process_response_get_consignment_status_detail_success($orders_tracking){ 
        $rt = array(); 
        if($this->response_get_consignment_status_detail->r){  
          foreach($this->response_get_consignment_status_detail->r as $v){ 
            
            $order_id = array_search($v->consignmentNote,$orders_tracking); 
            $is_email_sent_gdex_shipped_order = get_post_meta($order_id,"_is_email_sent_gdex_shipped_order",true); 
            if("out for delivery" == strtolower($v->consignmentNoteStatus)){
                $shipment_status = false; 
                if($is_email_sent_gdex_shipped_order != "1"){
                  $order = new WC_Order($order_id);
                  $order->set_status("shipped");
                  $order->save();
                	update_post_meta($order_id,"_is_email_sent_gdex_shipped_order","1");
                }
            } 
            update_post_meta($order_id,"_gdex_consignment_note_status",$v->consignmentNoteStatus);
            $obj = new stdClass();
            $obj->consignmentNoteStatus = $v->consignmentNoteStatus; 
            $is_email_sent_gdex_shipped_order = get_post_meta($order_id,"_is_email_sent_gdex_shipped_order",true);
            if($is_email_sent_gdex_shipped_order != "1"){ 
              $obj->send_email_status = "waiting";
            }else{
              $obj->send_email_status = "sent";
            }
            $rt[$order_id] = $obj;
          }
        }  
        return $rt;
      }
      public function send_get_shipment_status_detail($orders_tracking){ 
        $headers = $this->headers_default;
        $headers[] = "Content-Type: application/json-patch+json";  
        $url = $this->url["GetLastShipmentStatus"]; 
        $ch = curl_init();   
        $data = json_encode(array_values($orders_tracking)); 
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
        curl_setopt($ch, CURLOPT_POST, true);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = json_decode(curl_exec($ch));  
        curl_close($ch);   
        $this->response_get_consignment_status_detail = $response; 
      }
      public function cancel_consignment($consignmentNumber){
        $headers = $this->headers_default;  
        $url = $this->url["CancelConsignment"].$consignmentNumber;
        $ch = curl_init();   
        // $data = json_encode(array_values($orders_tracking)); 
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);   
        $response = json_decode(curl_exec($ch));  
        // var_dump($ch);
        // $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);    
        // var_dump($response);
        // var_dump($status);
        $this->response_cancel_consignment = $response; 
      }
      public function validate_postcode($postcode){
        $validate_postcode = $this->send_validate_postcode($postcode); 
        return $validate_postcode;
      }
      private function send_validate_postcode($postcode){
          $headers = $this->headers_default; 
          $url = $this->url["GetPostCodeLocation"].$postcode;
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);     
          $response = json_decode(curl_exec($ch));     

          $validate_postcode = true; 
          if(isset($response) && isset($response->e) && strtolower($response->e) === "invalid postcode"){
            $validate_postcode = false;
          }
          curl_close($ch);  
          return $validate_postcode;
      }
        
  }  
  
  
// function test_post_form(){

//   $url = "https://link.singaporeairshow.com/u/register.php?CID=290059827&f=5558&p=2&a=r&SID=&el=&llid=&counted=&c=&optin=y&interest[]=&inp_1=test&inp_2=test1&inp_3=fabianknknkn1@gmail.com";
//   $crl = curl_init($url);
//   curl_setopt($crl,CURLOPT_RETURNTRANSFER,true); 
//   $response = curl_exec($crl);
//   $info = curl_getinfo($crl);
//   curl_close($crl);      
//   var_dump($info);
//   var_dump($response);

// }
// if(isset($_GET) && isset($_GET["debug"])){
//   test_post_form();
// }