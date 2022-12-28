<?php
/**
 * ReportingV3PurchaseRefundDetailsGet200ResponseSettlements
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
 * ReportingV3PurchaseRefundDetailsGet200ResponseSettlements Class Doc Comment
 *
 * @category    Class
 * @package     CyberSource
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class ReportingV3PurchaseRefundDetailsGet200ResponseSettlements implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'reportingV3PurchaseRefundDetailsGet200Response_settlements';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'requestId' => 'string',
        'transactionType' => 'string',
        'submissionTime' => '\DateTime',
        'amount' => 'string',
        'currencyCode' => 'string',
        'paymentMethod' => 'string',
        'walletType' => 'string',
        'paymentType' => 'string',
        'accountSuffix' => 'string',
        'cybersourceBatchTime' => '\DateTime',
        'cybersourceBatchId' => 'string',
        'cardType' => 'string',
        'debitNetwork' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerFormats = [
        'requestId' => null,
        'transactionType' => null,
        'submissionTime' => 'date-time',
        'amount' => null,
        'currencyCode' => null,
        'paymentMethod' => null,
        'walletType' => null,
        'paymentType' => null,
        'accountSuffix' => null,
        'cybersourceBatchTime' => 'date-time',
        'cybersourceBatchId' => null,
        'cardType' => null,
        'debitNetwork' => null
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
        'requestId' => 'requestId',
        'transactionType' => 'transactionType',
        'submissionTime' => 'submissionTime',
        'amount' => 'amount',
        'currencyCode' => 'currencyCode',
        'paymentMethod' => 'paymentMethod',
        'walletType' => 'walletType',
        'paymentType' => 'paymentType',
        'accountSuffix' => 'accountSuffix',
        'cybersourceBatchTime' => 'cybersourceBatchTime',
        'cybersourceBatchId' => 'cybersourceBatchId',
        'cardType' => 'cardType',
        'debitNetwork' => 'debitNetwork'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'requestId' => 'setRequestId',
        'transactionType' => 'setTransactionType',
        'submissionTime' => 'setSubmissionTime',
        'amount' => 'setAmount',
        'currencyCode' => 'setCurrencyCode',
        'paymentMethod' => 'setPaymentMethod',
        'walletType' => 'setWalletType',
        'paymentType' => 'setPaymentType',
        'accountSuffix' => 'setAccountSuffix',
        'cybersourceBatchTime' => 'setCybersourceBatchTime',
        'cybersourceBatchId' => 'setCybersourceBatchId',
        'cardType' => 'setCardType',
        'debitNetwork' => 'setDebitNetwork'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'requestId' => 'getRequestId',
        'transactionType' => 'getTransactionType',
        'submissionTime' => 'getSubmissionTime',
        'amount' => 'getAmount',
        'currencyCode' => 'getCurrencyCode',
        'paymentMethod' => 'getPaymentMethod',
        'walletType' => 'getWalletType',
        'paymentType' => 'getPaymentType',
        'accountSuffix' => 'getAccountSuffix',
        'cybersourceBatchTime' => 'getCybersourceBatchTime',
        'cybersourceBatchId' => 'getCybersourceBatchId',
        'cardType' => 'getCardType',
        'debitNetwork' => 'getDebitNetwork'
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
        $this->container['requestId'] = isset($data['requestId']) ? $data['requestId'] : null;
        $this->container['transactionType'] = isset($data['transactionType']) ? $data['transactionType'] : null;
        $this->container['submissionTime'] = isset($data['submissionTime']) ? $data['submissionTime'] : null;
        $this->container['amount'] = isset($data['amount']) ? $data['amount'] : null;
        $this->container['currencyCode'] = isset($data['currencyCode']) ? $data['currencyCode'] : null;
        $this->container['paymentMethod'] = isset($data['paymentMethod']) ? $data['paymentMethod'] : null;
        $this->container['walletType'] = isset($data['walletType']) ? $data['walletType'] : null;
        $this->container['paymentType'] = isset($data['paymentType']) ? $data['paymentType'] : null;
        $this->container['accountSuffix'] = isset($data['accountSuffix']) ? $data['accountSuffix'] : null;
        $this->container['cybersourceBatchTime'] = isset($data['cybersourceBatchTime']) ? $data['cybersourceBatchTime'] : null;
        $this->container['cybersourceBatchId'] = isset($data['cybersourceBatchId']) ? $data['cybersourceBatchId'] : null;
        $this->container['cardType'] = isset($data['cardType']) ? $data['cardType'] : null;
        $this->container['debitNetwork'] = isset($data['debitNetwork']) ? $data['debitNetwork'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];

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

        return true;
    }


    /**
     * Gets requestId
     * @return string
     */
    public function getRequestId()
    {
        return $this->container['requestId'];
    }

    /**
     * Sets requestId
     * @param string $requestId An unique identification number assigned by CyberSource to identify the submitted request.
     * @return $this
     */
    public function setRequestId($requestId)
    {
        $this->container['requestId'] = $requestId;

        return $this;
    }

    /**
     * Gets transactionType
     * @return string
     */
    public function getTransactionType()
    {
        return $this->container['transactionType'];
    }

    /**
     * Sets transactionType
     * @param string $transactionType Transaction Type
     * @return $this
     */
    public function setTransactionType($transactionType)
    {
        $this->container['transactionType'] = $transactionType;

        return $this;
    }

    /**
     * Gets submissionTime
     * @return \DateTime
     */
    public function getSubmissionTime()
    {
        return $this->container['submissionTime'];
    }

    /**
     * Sets submissionTime
     * @param \DateTime $submissionTime Submission Date
     * @return $this
     */
    public function setSubmissionTime($submissionTime)
    {
        $this->container['submissionTime'] = $submissionTime;

        return $this;
    }

    /**
     * Gets amount
     * @return string
     */
    public function getAmount()
    {
        return $this->container['amount'];
    }

    /**
     * Sets amount
     * @param string $amount Amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->container['amount'] = $amount;

        return $this;
    }

    /**
     * Gets currencyCode
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->container['currencyCode'];
    }

    /**
     * Sets currencyCode
     * @param string $currencyCode Valid ISO 4217 ALPHA-3 currency code
     * @return $this
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->container['currencyCode'] = $currencyCode;

        return $this;
    }

    /**
     * Gets paymentMethod
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->container['paymentMethod'];
    }

    /**
     * Sets paymentMethod
     * @param string $paymentMethod payment method
     * @return $this
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->container['paymentMethod'] = $paymentMethod;

        return $this;
    }

    /**
     * Gets walletType
     * @return string
     */
    public function getWalletType()
    {
        return $this->container['walletType'];
    }

    /**
     * Sets walletType
     * @param string $walletType Solution Type (Wallet)
     * @return $this
     */
    public function setWalletType($walletType)
    {
        $this->container['walletType'] = $walletType;

        return $this;
    }

    /**
     * Gets paymentType
     * @return string
     */
    public function getPaymentType()
    {
        return $this->container['paymentType'];
    }

    /**
     * Sets paymentType
     * @param string $paymentType Payment Type
     * @return $this
     */
    public function setPaymentType($paymentType)
    {
        $this->container['paymentType'] = $paymentType;

        return $this;
    }

    /**
     * Gets accountSuffix
     * @return string
     */
    public function getAccountSuffix()
    {
        return $this->container['accountSuffix'];
    }

    /**
     * Sets accountSuffix
     * @param string $accountSuffix Account Suffix
     * @return $this
     */
    public function setAccountSuffix($accountSuffix)
    {
        $this->container['accountSuffix'] = $accountSuffix;

        return $this;
    }

    /**
     * Gets cybersourceBatchTime
     * @return \DateTime
     */
    public function getCybersourceBatchTime()
    {
        return $this->container['cybersourceBatchTime'];
    }

    /**
     * Sets cybersourceBatchTime
     * @param \DateTime $cybersourceBatchTime Cybersource Batch Time
     * @return $this
     */
    public function setCybersourceBatchTime($cybersourceBatchTime)
    {
        $this->container['cybersourceBatchTime'] = $cybersourceBatchTime;

        return $this;
    }

    /**
     * Gets cybersourceBatchId
     * @return string
     */
    public function getCybersourceBatchId()
    {
        return $this->container['cybersourceBatchId'];
    }

    /**
     * Sets cybersourceBatchId
     * @param string $cybersourceBatchId Cybersource Batch Id
     * @return $this
     */
    public function setCybersourceBatchId($cybersourceBatchId)
    {
        $this->container['cybersourceBatchId'] = $cybersourceBatchId;

        return $this;
    }

    /**
     * Gets cardType
     * @return string
     */
    public function getCardType()
    {
        return $this->container['cardType'];
    }

    /**
     * Sets cardType
     * @param string $cardType Card Type
     * @return $this
     */
    public function setCardType($cardType)
    {
        $this->container['cardType'] = $cardType;

        return $this;
    }

    /**
     * Gets debitNetwork
     * @return string
     */
    public function getDebitNetwork()
    {
        return $this->container['debitNetwork'];
    }

    /**
     * Sets debitNetwork
     * @param string $debitNetwork Debit Network
     * @return $this
     */
    public function setDebitNetwork($debitNetwork)
    {
        $this->container['debitNetwork'] = $debitNetwork;

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


