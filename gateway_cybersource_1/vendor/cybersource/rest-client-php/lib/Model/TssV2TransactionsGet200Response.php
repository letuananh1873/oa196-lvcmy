<?php
/**
 * TssV2TransactionsGet200Response
 *
 * PHP version 5
 *
 * @category Class
 * @package  CyberSource
 * @author   Swaagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * CyberSource Merged Spec
 *
 * All CyberSource API specs merged together. These are available at https://developer.cybersource.com/api/reference/api-reference.html
 *
 * OpenAPI spec version: 0.0.1
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace CyberSource\Model;

use \ArrayAccess;

/**
 * TssV2TransactionsGet200Response Class Doc Comment
 *
 * @category    Class
 * @package     CyberSource
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class TssV2TransactionsGet200Response implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'tssV2TransactionsGet200Response';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'id' => 'string',
        'rootId' => 'string',
        'reconciliationId' => 'string',
        'merchantId' => 'string',
        'status' => 'string',
        'submitTimeUTC' => 'string',
        'applicationInformation' => '\CyberSource\Model\TssV2TransactionsGet200ResponseApplicationInformation',
        'buyerInformation' => '\CyberSource\Model\TssV2TransactionsGet200ResponseBuyerInformation',
        'clientReferenceInformation' => '\CyberSource\Model\TssV2TransactionsGet200ResponseClientReferenceInformation',
        'consumerAuthenticationInformation' => '\CyberSource\Model\TssV2TransactionsGet200ResponseConsumerAuthenticationInformation',
        'deviceInformation' => '\CyberSource\Model\TssV2TransactionsGet200ResponseDeviceInformation',
        'errorInformation' => '\CyberSource\Model\TssV2TransactionsGet200ResponseErrorInformation',
        'installmentInformation' => '\CyberSource\Model\TssV2TransactionsGet200ResponseInstallmentInformation',
        'fraudMarkingInformation' => '\CyberSource\Model\TssV2TransactionsGet200ResponseFraudMarkingInformation',
        'merchantDefinedInformation' => '\CyberSource\Model\Ptsv2paymentsMerchantDefinedInformation[]',
        'merchantInformation' => '\CyberSource\Model\TssV2TransactionsGet200ResponseMerchantInformation',
        'orderInformation' => '\CyberSource\Model\TssV2TransactionsGet200ResponseOrderInformation',
        'paymentInformation' => '\CyberSource\Model\TssV2TransactionsGet200ResponsePaymentInformation',
        'processingInformation' => '\CyberSource\Model\TssV2TransactionsGet200ResponseProcessingInformation',
        'processorInformation' => '\CyberSource\Model\TssV2TransactionsGet200ResponseProcessorInformation',
        'pointOfSaleInformation' => '\CyberSource\Model\TssV2TransactionsGet200ResponsePointOfSaleInformation',
        'riskInformation' => '\CyberSource\Model\TssV2TransactionsGet200ResponseRiskInformation',
        'senderInformation' => '\CyberSource\Model\TssV2TransactionsGet200ResponseSenderInformation',
        'links' => '\CyberSource\Model\TssV2TransactionsGet200ResponseLinks'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerFormats = [
        'id' => null,
        'rootId' => null,
        'reconciliationId' => null,
        'merchantId' => null,
        'status' => null,
        'submitTimeUTC' => null,
        'applicationInformation' => null,
        'buyerInformation' => null,
        'clientReferenceInformation' => null,
        'consumerAuthenticationInformation' => null,
        'deviceInformation' => null,
        'errorInformation' => null,
        'installmentInformation' => null,
        'fraudMarkingInformation' => null,
        'merchantDefinedInformation' => null,
        'merchantInformation' => null,
        'orderInformation' => null,
        'paymentInformation' => null,
        'processingInformation' => null,
        'processorInformation' => null,
        'pointOfSaleInformation' => null,
        'riskInformation' => null,
        'senderInformation' => null,
        'links' => null
    ];

    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[]
     */
    protected static $attributeMap = [
        'id' => 'id',
        'rootId' => 'rootId',
        'reconciliationId' => 'reconciliationId',
        'merchantId' => 'merchantId',
        'status' => 'status',
        'submitTimeUTC' => 'submitTimeUTC',
        'applicationInformation' => 'applicationInformation',
        'buyerInformation' => 'buyerInformation',
        'clientReferenceInformation' => 'clientReferenceInformation',
        'consumerAuthenticationInformation' => 'consumerAuthenticationInformation',
        'deviceInformation' => 'deviceInformation',
        'errorInformation' => 'errorInformation',
        'installmentInformation' => 'installmentInformation',
        'fraudMarkingInformation' => 'fraudMarkingInformation',
        'merchantDefinedInformation' => 'merchantDefinedInformation',
        'merchantInformation' => 'merchantInformation',
        'orderInformation' => 'orderInformation',
        'paymentInformation' => 'paymentInformation',
        'processingInformation' => 'processingInformation',
        'processorInformation' => 'processorInformation',
        'pointOfSaleInformation' => 'pointOfSaleInformation',
        'riskInformation' => 'riskInformation',
        'senderInformation' => 'senderInformation',
        'links' => '_links'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'id' => 'setId',
        'rootId' => 'setRootId',
        'reconciliationId' => 'setReconciliationId',
        'merchantId' => 'setMerchantId',
        'status' => 'setStatus',
        'submitTimeUTC' => 'setSubmitTimeUTC',
        'applicationInformation' => 'setApplicationInformation',
        'buyerInformation' => 'setBuyerInformation',
        'clientReferenceInformation' => 'setClientReferenceInformation',
        'consumerAuthenticationInformation' => 'setConsumerAuthenticationInformation',
        'deviceInformation' => 'setDeviceInformation',
        'errorInformation' => 'setErrorInformation',
        'installmentInformation' => 'setInstallmentInformation',
        'fraudMarkingInformation' => 'setFraudMarkingInformation',
        'merchantDefinedInformation' => 'setMerchantDefinedInformation',
        'merchantInformation' => 'setMerchantInformation',
        'orderInformation' => 'setOrderInformation',
        'paymentInformation' => 'setPaymentInformation',
        'processingInformation' => 'setProcessingInformation',
        'processorInformation' => 'setProcessorInformation',
        'pointOfSaleInformation' => 'setPointOfSaleInformation',
        'riskInformation' => 'setRiskInformation',
        'senderInformation' => 'setSenderInformation',
        'links' => 'setLinks'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'id' => 'getId',
        'rootId' => 'getRootId',
        'reconciliationId' => 'getReconciliationId',
        'merchantId' => 'getMerchantId',
        'status' => 'getStatus',
        'submitTimeUTC' => 'getSubmitTimeUTC',
        'applicationInformation' => 'getApplicationInformation',
        'buyerInformation' => 'getBuyerInformation',
        'clientReferenceInformation' => 'getClientReferenceInformation',
        'consumerAuthenticationInformation' => 'getConsumerAuthenticationInformation',
        'deviceInformation' => 'getDeviceInformation',
        'errorInformation' => 'getErrorInformation',
        'installmentInformation' => 'getInstallmentInformation',
        'fraudMarkingInformation' => 'getFraudMarkingInformation',
        'merchantDefinedInformation' => 'getMerchantDefinedInformation',
        'merchantInformation' => 'getMerchantInformation',
        'orderInformation' => 'getOrderInformation',
        'paymentInformation' => 'getPaymentInformation',
        'processingInformation' => 'getProcessingInformation',
        'processorInformation' => 'getProcessorInformation',
        'pointOfSaleInformation' => 'getPointOfSaleInformation',
        'riskInformation' => 'getRiskInformation',
        'senderInformation' => 'getSenderInformation',
        'links' => 'getLinks'
    ];

    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    public static function setters()
    {
        return self::$setters;
    }

    public static function getters()
    {
        return self::$getters;
    }

    

    

    /**
     * Associative array for storing property values
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['id'] = isset($data['id']) ? $data['id'] : null;
        $this->container['rootId'] = isset($data['rootId']) ? $data['rootId'] : null;
        $this->container['reconciliationId'] = isset($data['reconciliationId']) ? $data['reconciliationId'] : null;
        $this->container['merchantId'] = isset($data['merchantId']) ? $data['merchantId'] : null;
        $this->container['status'] = isset($data['status']) ? $data['status'] : null;
        $this->container['submitTimeUTC'] = isset($data['submitTimeUTC']) ? $data['submitTimeUTC'] : null;
        $this->container['applicationInformation'] = isset($data['applicationInformation']) ? $data['applicationInformation'] : null;
        $this->container['buyerInformation'] = isset($data['buyerInformation']) ? $data['buyerInformation'] : null;
        $this->container['clientReferenceInformation'] = isset($data['clientReferenceInformation']) ? $data['clientReferenceInformation'] : null;
        $this->container['consumerAuthenticationInformation'] = isset($data['consumerAuthenticationInformation']) ? $data['consumerAuthenticationInformation'] : null;
        $this->container['deviceInformation'] = isset($data['deviceInformation']) ? $data['deviceInformation'] : null;
        $this->container['errorInformation'] = isset($data['errorInformation']) ? $data['errorInformation'] : null;
        $this->container['installmentInformation'] = isset($data['installmentInformation']) ? $data['installmentInformation'] : null;
        $this->container['fraudMarkingInformation'] = isset($data['fraudMarkingInformation']) ? $data['fraudMarkingInformation'] : null;
        $this->container['merchantDefinedInformation'] = isset($data['merchantDefinedInformation']) ? $data['merchantDefinedInformation'] : null;
        $this->container['merchantInformation'] = isset($data['merchantInformation']) ? $data['merchantInformation'] : null;
        $this->container['orderInformation'] = isset($data['orderInformation']) ? $data['orderInformation'] : null;
        $this->container['paymentInformation'] = isset($data['paymentInformation']) ? $data['paymentInformation'] : null;
        $this->container['processingInformation'] = isset($data['processingInformation']) ? $data['processingInformation'] : null;
        $this->container['processorInformation'] = isset($data['processorInformation']) ? $data['processorInformation'] : null;
        $this->container['pointOfSaleInformation'] = isset($data['pointOfSaleInformation']) ? $data['pointOfSaleInformation'] : null;
        $this->container['riskInformation'] = isset($data['riskInformation']) ? $data['riskInformation'] : null;
        $this->container['senderInformation'] = isset($data['senderInformation']) ? $data['senderInformation'] : null;
        $this->container['links'] = isset($data['links']) ? $data['links'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];

        if (!is_null($this->container['id']) && (strlen($this->container['id']) > 26)) {
            $invalid_properties[] = "invalid value for 'id', the character length must be smaller than or equal to 26.";
        }

        if (!is_null($this->container['rootId']) && (strlen($this->container['rootId']) > 26)) {
            $invalid_properties[] = "invalid value for 'rootId', the character length must be smaller than or equal to 26.";
        }

        if (!is_null($this->container['reconciliationId']) && (strlen($this->container['reconciliationId']) > 60)) {
            $invalid_properties[] = "invalid value for 'reconciliationId', the character length must be smaller than or equal to 60.";
        }

        return $invalid_properties;
    }

    /**
     * validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {

        if (strlen($this->container['id']) > 26) {
            return false;
        }
        if (strlen($this->container['rootId']) > 26) {
            return false;
        }
        if (strlen($this->container['reconciliationId']) > 60) {
            return false;
        }
        return true;
    }


    /**
     * Gets id
     * @return string
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     * @param string $id An unique identification number assigned by CyberSource to identify the submitted request. It is also appended to the endpoint of the resource.
     * @return $this
     */
    public function setId($id)
    {
        if (!is_null($id) && (strlen($id) > 26)) {
            throw new \InvalidArgumentException('invalid length for $id when calling TssV2TransactionsGet200Response., must be smaller than or equal to 26.');
        }

        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets rootId
     * @return string
     */
    public function getRootId()
    {
        return $this->container['rootId'];
    }

    /**
     * Sets rootId
     * @param string $rootId Payment Request Id
     * @return $this
     */
    public function setRootId($rootId)
    {
        if (!is_null($rootId) && (strlen($rootId) > 26)) {
            throw new \InvalidArgumentException('invalid length for $rootId when calling TssV2TransactionsGet200Response., must be smaller than or equal to 26.');
        }

        $this->container['rootId'] = $rootId;

        return $this;
    }

    /**
     * Gets reconciliationId
     * @return string
     */
    public function getReconciliationId()
    {
        return $this->container['reconciliationId'];
    }

    /**
     * Sets reconciliationId
     * @param string $reconciliationId The reconciliation id for the submitted transaction. This value is not returned for all processors.
     * @return $this
     */
    public function setReconciliationId($reconciliationId)
    {
        if (!is_null($reconciliationId) && (strlen($reconciliationId) > 60)) {
            throw new \InvalidArgumentException('invalid length for $reconciliationId when calling TssV2TransactionsGet200Response., must be smaller than or equal to 60.');
        }

        $this->container['reconciliationId'] = $reconciliationId;

        return $this;
    }

    /**
     * Gets merchantId
     * @return string
     */
    public function getMerchantId()
    {
        return $this->container['merchantId'];
    }

    /**
     * Sets merchantId
     * @param string $merchantId Your CyberSource merchant ID.
     * @return $this
     */
    public function setMerchantId($merchantId)
    {
        $this->container['merchantId'] = $merchantId;

        return $this;
    }

    /**
     * Gets status
     * @return string
     */
    public function getStatus()
    {
        return $this->container['status'];
    }

    /**
     * Sets status
     * @param string $status The status of the submitted transaction.
     * @return $this
     */
    public function setStatus($status)
    {
        $this->container['status'] = $status;

        return $this;
    }

    /**
     * Gets submitTimeUTC
     * @return string
     */
    public function getSubmitTimeUTC()
    {
        return $this->container['submitTimeUTC'];
    }

    /**
     * Sets submitTimeUTC
     * @param string $submitTimeUTC Time of request in UTC. Format: `YYYY-MM-DDThh:mm:ssZ` Example `2016-08-11T22:47:57Z` equals August 11, 2016, at 22:47:57 (10:47:57 p.m.). The `T` separates the date and the time. The `Z` indicates UTC.
     * @return $this
     */
    public function setSubmitTimeUTC($submitTimeUTC)
    {
        $this->container['submitTimeUTC'] = $submitTimeUTC;

        return $this;
    }

    /**
     * Gets applicationInformation
     * @return \CyberSource\Model\TssV2TransactionsGet200ResponseApplicationInformation
     */
    public function getApplicationInformation()
    {
        return $this->container['applicationInformation'];
    }

    /**
     * Sets applicationInformation
     * @param \CyberSource\Model\TssV2TransactionsGet200ResponseApplicationInformation $applicationInformation
     * @return $this
     */
    public function setApplicationInformation($applicationInformation)
    {
        $this->container['applicationInformation'] = $applicationInformation;

        return $this;
    }

    /**
     * Gets buyerInformation
     * @return \CyberSource\Model\TssV2TransactionsGet200ResponseBuyerInformation
     */
    public function getBuyerInformation()
    {
        return $this->container['buyerInformation'];
    }

    /**
     * Sets buyerInformation
     * @param \CyberSource\Model\TssV2TransactionsGet200ResponseBuyerInformation $buyerInformation
     * @return $this
     */
    public function setBuyerInformation($buyerInformation)
    {
        $this->container['buyerInformation'] = $buyerInformation;

        return $this;
    }

    /**
     * Gets clientReferenceInformation
     * @return \CyberSource\Model\TssV2TransactionsGet200ResponseClientReferenceInformation
     */
    public function getClientReferenceInformation()
    {
        return $this->container['clientReferenceInformation'];
    }

    /**
     * Sets clientReferenceInformation
     * @param \CyberSource\Model\TssV2TransactionsGet200ResponseClientReferenceInformation $clientReferenceInformation
     * @return $this
     */
    public function setClientReferenceInformation($clientReferenceInformation)
    {
        $this->container['clientReferenceInformation'] = $clientReferenceInformation;

        return $this;
    }

    /**
     * Gets consumerAuthenticationInformation
     * @return \CyberSource\Model\TssV2TransactionsGet200ResponseConsumerAuthenticationInformation
     */
    public function getConsumerAuthenticationInformation()
    {
        return $this->container['consumerAuthenticationInformation'];
    }

    /**
     * Sets consumerAuthenticationInformation
     * @param \CyberSource\Model\TssV2TransactionsGet200ResponseConsumerAuthenticationInformation $consumerAuthenticationInformation
     * @return $this
     */
    public function setConsumerAuthenticationInformation($consumerAuthenticationInformation)
    {
        $this->container['consumerAuthenticationInformation'] = $consumerAuthenticationInformation;

        return $this;
    }

    /**
     * Gets deviceInformation
     * @return \CyberSource\Model\TssV2TransactionsGet200ResponseDeviceInformation
     */
    public function getDeviceInformation()
    {
        return $this->container['deviceInformation'];
    }

    /**
     * Sets deviceInformation
     * @param \CyberSource\Model\TssV2TransactionsGet200ResponseDeviceInformation $deviceInformation
     * @return $this
     */
    public function setDeviceInformation($deviceInformation)
    {
        $this->container['deviceInformation'] = $deviceInformation;

        return $this;
    }

    /**
     * Gets errorInformation
     * @return \CyberSource\Model\TssV2TransactionsGet200ResponseErrorInformation
     */
    public function getErrorInformation()
    {
        return $this->container['errorInformation'];
    }

    /**
     * Sets errorInformation
     * @param \CyberSource\Model\TssV2TransactionsGet200ResponseErrorInformation $errorInformation
     * @return $this
     */
    public function setErrorInformation($errorInformation)
    {
        $this->container['errorInformation'] = $errorInformation;

        return $this;
    }

    /**
     * Gets installmentInformation
     * @return \CyberSource\Model\TssV2TransactionsGet200ResponseInstallmentInformation
     */
    public function getInstallmentInformation()
    {
        return $this->container['installmentInformation'];
    }

    /**
     * Sets installmentInformation
     * @param \CyberSource\Model\TssV2TransactionsGet200ResponseInstallmentInformation $installmentInformation
     * @return $this
     */
    public function setInstallmentInformation($installmentInformation)
    {
        $this->container['installmentInformation'] = $installmentInformation;

        return $this;
    }

    /**
     * Gets fraudMarkingInformation
     * @return \CyberSource\Model\TssV2TransactionsGet200ResponseFraudMarkingInformation
     */
    public function getFraudMarkingInformation()
    {
        return $this->container['fraudMarkingInformation'];
    }

    /**
     * Sets fraudMarkingInformation
     * @param \CyberSource\Model\TssV2TransactionsGet200ResponseFraudMarkingInformation $fraudMarkingInformation
     * @return $this
     */
    public function setFraudMarkingInformation($fraudMarkingInformation)
    {
        $this->container['fraudMarkingInformation'] = $fraudMarkingInformation;

        return $this;
    }

    /**
     * Gets merchantDefinedInformation
     * @return \CyberSource\Model\Ptsv2paymentsMerchantDefinedInformation[]
     */
    public function getMerchantDefinedInformation()
    {
        return $this->container['merchantDefinedInformation'];
    }

    /**
     * Sets merchantDefinedInformation
     * @param \CyberSource\Model\Ptsv2paymentsMerchantDefinedInformation[] $merchantDefinedInformation The object containing the custom data that the merchant defines.
     * @return $this
     */
    public function setMerchantDefinedInformation($merchantDefinedInformation)
    {
        $this->container['merchantDefinedInformation'] = $merchantDefinedInformation;

        return $this;
    }

    /**
     * Gets merchantInformation
     * @return \CyberSource\Model\TssV2TransactionsGet200ResponseMerchantInformation
     */
    public function getMerchantInformation()
    {
        return $this->container['merchantInformation'];
    }

    /**
     * Sets merchantInformation
     * @param \CyberSource\Model\TssV2TransactionsGet200ResponseMerchantInformation $merchantInformation
     * @return $this
     */
    public function setMerchantInformation($merchantInformation)
    {
        $this->container['merchantInformation'] = $merchantInformation;

        return $this;
    }

    /**
     * Gets orderInformation
     * @return \CyberSource\Model\TssV2TransactionsGet200ResponseOrderInformation
     */
    public function getOrderInformation()
    {
        return $this->container['orderInformation'];
    }

    /**
     * Sets orderInformation
     * @param \CyberSource\Model\TssV2TransactionsGet200ResponseOrderInformation $orderInformation
     * @return $this
     */
    public function setOrderInformation($orderInformation)
    {
        $this->container['orderInformation'] = $orderInformation;

        return $this;
    }

    /**
     * Gets paymentInformation
     * @return \CyberSource\Model\TssV2TransactionsGet200ResponsePaymentInformation
     */
    public function getPaymentInformation()
    {
        return $this->container['paymentInformation'];
    }

    /**
     * Sets paymentInformation
     * @param \CyberSource\Model\TssV2TransactionsGet200ResponsePaymentInformation $paymentInformation
     * @return $this
     */
    public function setPaymentInformation($paymentInformation)
    {
        $this->container['paymentInformation'] = $paymentInformation;

        return $this;
    }

    /**
     * Gets processingInformation
     * @return \CyberSource\Model\TssV2TransactionsGet200ResponseProcessingInformation
     */
    public function getProcessingInformation()
    {
        return $this->container['processingInformation'];
    }

    /**
     * Sets processingInformation
     * @param \CyberSource\Model\TssV2TransactionsGet200ResponseProcessingInformation $processingInformation
     * @return $this
     */
    public function setProcessingInformation($processingInformation)
    {
        $this->container['processingInformation'] = $processingInformation;

        return $this;
    }

    /**
     * Gets processorInformation
     * @return \CyberSource\Model\TssV2TransactionsGet200ResponseProcessorInformation
     */
    public function getProcessorInformation()
    {
        return $this->container['processorInformation'];
    }

    /**
     * Sets processorInformation
     * @param \CyberSource\Model\TssV2TransactionsGet200ResponseProcessorInformation $processorInformation
     * @return $this
     */
    public function setProcessorInformation($processorInformation)
    {
        $this->container['processorInformation'] = $processorInformation;

        return $this;
    }

    /**
     * Gets pointOfSaleInformation
     * @return \CyberSource\Model\TssV2TransactionsGet200ResponsePointOfSaleInformation
     */
    public function getPointOfSaleInformation()
    {
        return $this->container['pointOfSaleInformation'];
    }

    /**
     * Sets pointOfSaleInformation
     * @param \CyberSource\Model\TssV2TransactionsGet200ResponsePointOfSaleInformation $pointOfSaleInformation
     * @return $this
     */
    public function setPointOfSaleInformation($pointOfSaleInformation)
    {
        $this->container['pointOfSaleInformation'] = $pointOfSaleInformation;

        return $this;
    }

    /**
     * Gets riskInformation
     * @return \CyberSource\Model\TssV2TransactionsGet200ResponseRiskInformation
     */
    public function getRiskInformation()
    {
        return $this->container['riskInformation'];
    }

    /**
     * Sets riskInformation
     * @param \CyberSource\Model\TssV2TransactionsGet200ResponseRiskInformation $riskInformation
     * @return $this
     */
    public function setRiskInformation($riskInformation)
    {
        $this->container['riskInformation'] = $riskInformation;

        return $this;
    }

    /**
     * Gets senderInformation
     * @return \CyberSource\Model\TssV2TransactionsGet200ResponseSenderInformation
     */
    public function getSenderInformation()
    {
        return $this->container['senderInformation'];
    }

    /**
     * Sets senderInformation
     * @param \CyberSource\Model\TssV2TransactionsGet200ResponseSenderInformation $senderInformation
     * @return $this
     */
    public function setSenderInformation($senderInformation)
    {
        $this->container['senderInformation'] = $senderInformation;

        return $this;
    }

    /**
     * Gets links
     * @return \CyberSource\Model\TssV2TransactionsGet200ResponseLinks
     */
    public function getLinks()
    {
        return $this->container['links'];
    }

    /**
     * Sets links
     * @param \CyberSource\Model\TssV2TransactionsGet200ResponseLinks $links
     * @return $this
     */
    public function setLinks($links)
    {
        $this->container['links'] = $links;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     * @param  integer $offset Offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     * @param  integer $offset Offset
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     * @param  integer $offset Offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(\CyberSource\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }

        return json_encode(\CyberSource\ObjectSerializer::sanitizeForSerialization($this));
    }
}


