<?php
/**
 * TssV2TransactionsPost201ResponseEmbeddedRiskInformationProvidersFingerprint
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
 * TssV2TransactionsPost201ResponseEmbeddedRiskInformationProvidersFingerprint Class Doc Comment
 *
 * @category    Class
 * @package     CyberSource
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class TssV2TransactionsPost201ResponseEmbeddedRiskInformationProvidersFingerprint implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'tssV2TransactionsPost201Response__embedded_riskInformation_providers_fingerprint';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'trueIpaddress' => 'string',
        'hash' => 'string',
        'smartId' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerFormats = [
        'trueIpaddress' => null,
        'hash' => null,
        'smartId' => null
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
        'trueIpaddress' => 'true_ipaddress',
        'hash' => 'hash',
        'smartId' => 'smartId'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'trueIpaddress' => 'setTrueIpaddress',
        'hash' => 'setHash',
        'smartId' => 'setSmartId'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'trueIpaddress' => 'getTrueIpaddress',
        'hash' => 'getHash',
        'smartId' => 'getSmartId'
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
        $this->container['trueIpaddress'] = isset($data['trueIpaddress']) ? $data['trueIpaddress'] : null;
        $this->container['hash'] = isset($data['hash']) ? $data['hash'] : null;
        $this->container['smartId'] = isset($data['smartId']) ? $data['smartId'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];

        if (!is_null($this->container['trueIpaddress']) && (strlen($this->container['trueIpaddress']) > 255)) {
            $invalid_properties[] = "invalid value for 'trueIpaddress', the character length must be smaller than or equal to 255.";
        }

        if (!is_null($this->container['hash']) && (strlen($this->container['hash']) > 255)) {
            $invalid_properties[] = "invalid value for 'hash', the character length must be smaller than or equal to 255.";
        }

        if (!is_null($this->container['smartId']) && (strlen($this->container['smartId']) > 255)) {
            $invalid_properties[] = "invalid value for 'smartId', the character length must be smaller than or equal to 255.";
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

        if (strlen($this->container['trueIpaddress']) > 255) {
            return false;
        }
        if (strlen($this->container['hash']) > 255) {
            return false;
        }
        if (strlen($this->container['smartId']) > 255) {
            return false;
        }
        return true;
    }


    /**
     * Gets trueIpaddress
     * @return string
     */
    public function getTrueIpaddress()
    {
        return $this->container['trueIpaddress'];
    }

    /**
     * Sets trueIpaddress
     * @param string $trueIpaddress Customer???s true IP address detected by the application.  For details, see the `true_ipaddress` field description in [CyberSource Decision Manager Device Fingerprinting Guide.](https://www.cybersource.com/developers/documentation/fraud_management)
     * @return $this
     */
    public function setTrueIpaddress($trueIpaddress)
    {
        if (!is_null($trueIpaddress) && (strlen($trueIpaddress) > 255)) {
            throw new \InvalidArgumentException('invalid length for $trueIpaddress when calling TssV2TransactionsPost201ResponseEmbeddedRiskInformationProvidersFingerprint., must be smaller than or equal to 255.');
        }

        $this->container['trueIpaddress'] = $trueIpaddress;

        return $this;
    }

    /**
     * Gets hash
     * @return string
     */
    public function getHash()
    {
        return $this->container['hash'];
    }

    /**
     * Sets hash
     * @param string $hash The unique identifier of the device that is returned in the `riskInformation.providers.fingerprint.device_fingerprint_hash` API reply field.  NOTE: For details about the value of this field, see the `decision_provider_#_field_#_value` field description in the _Decision Manager Using the SCMP API Developer Guide_ on the [CyberSource Business Center.](https://ebc2.cybersource.com/ebc2/) Click **Decision Manager** > **Documentation** > **Guides** > _Decision Manager Using the SCMP API Developer Guide_ (PDF link).  For more details about this field, see the `device_fingerprint_hash` field description in the _CyberSource Decision Manager Device Fingerprinting Guide_on the [CyberSource Business Center.](https://ebc2.cybersource.com/ebc2/) Click **Decision Manager** > **Documentation** > **Guides** > _Decision Manager Using the SCMP API Developer Guide_ (PDF link)
     * @return $this
     */
    public function setHash($hash)
    {
        if (!is_null($hash) && (strlen($hash) > 255)) {
            throw new \InvalidArgumentException('invalid length for $hash when calling TssV2TransactionsPost201ResponseEmbeddedRiskInformationProvidersFingerprint., must be smaller than or equal to 255.');
        }

        $this->container['hash'] = $hash;

        return $this;
    }

    /**
     * Gets smartId
     * @return string
     */
    public function getSmartId()
    {
        return $this->container['smartId'];
    }

    /**
     * Sets smartId
     * @param string $smartId The device identifier generated from attributes collected during profiling. Returned by a 3rd party when you use device fingerprinting.  For details, see the `device_fingerprint_smart_id` field description in [CyberSource Decision Manager Device Fingerprinting Guide.](https://www.cybersource.com/developers/documentation/fraud_management)
     * @return $this
     */
    public function setSmartId($smartId)
    {
        if (!is_null($smartId) && (strlen($smartId) > 255)) {
            throw new \InvalidArgumentException('invalid length for $smartId when calling TssV2TransactionsPost201ResponseEmbeddedRiskInformationProvidersFingerprint., must be smaller than or equal to 255.');
        }

        $this->container['smartId'] = $smartId;

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


