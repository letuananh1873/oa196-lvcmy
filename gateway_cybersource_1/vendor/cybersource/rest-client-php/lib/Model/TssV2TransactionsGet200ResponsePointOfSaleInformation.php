<?php
/**
 * TssV2TransactionsGet200ResponsePointOfSaleInformation
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
 * TssV2TransactionsGet200ResponsePointOfSaleInformation Class Doc Comment
 *
 * @category    Class
 * @package     CyberSource
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class TssV2TransactionsGet200ResponsePointOfSaleInformation implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'tssV2TransactionsGet200Response_pointOfSaleInformation';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'entryMode' => 'string',
        'terminalCapability' => 'int'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerFormats = [
        'entryMode' => null,
        'terminalCapability' => null
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
        'entryMode' => 'entryMode',
        'terminalCapability' => 'terminalCapability'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'entryMode' => 'setEntryMode',
        'terminalCapability' => 'setTerminalCapability'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'entryMode' => 'getEntryMode',
        'terminalCapability' => 'getTerminalCapability'
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
        $this->container['entryMode'] = isset($data['entryMode']) ? $data['entryMode'] : null;
        $this->container['terminalCapability'] = isset($data['terminalCapability']) ? $data['terminalCapability'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];

        if (!is_null($this->container['entryMode']) && (strlen($this->container['entryMode']) > 11)) {
            $invalid_properties[] = "invalid value for 'entryMode', the character length must be smaller than or equal to 11.";
        }

        if (!is_null($this->container['terminalCapability']) && ($this->container['terminalCapability'] > 5)) {
            $invalid_properties[] = "invalid value for 'terminalCapability', must be smaller than or equal to 5.";
        }

        if (!is_null($this->container['terminalCapability']) && ($this->container['terminalCapability'] < 1)) {
            $invalid_properties[] = "invalid value for 'terminalCapability', must be bigger than or equal to 1.";
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

        if (strlen($this->container['entryMode']) > 11) {
            return false;
        }
        if ($this->container['terminalCapability'] > 5) {
            return false;
        }
        if ($this->container['terminalCapability'] < 1) {
            return false;
        }
        return true;
    }


    /**
     * Gets entryMode
     * @return string
     */
    public function getEntryMode()
    {
        return $this->container['entryMode'];
    }

    /**
     * Sets entryMode
     * @param string $entryMode Method of entering credit card information into the POS terminal. Possible values:   - `contact`: Read from direct contact with chip card.  - `contactless`: Read from a contactless interface using chip data.  - `keyed`: Manually keyed into POS terminal.  - `msd`: Read from a contactless interface using magnetic stripe data (MSD).  - `swiped`: Read from credit card magnetic stripe.  The contact, contactless, and msd values are supported only for EMV transactions.  For details, see the `pos_entry_mode` field description in [Card-Present Processing Using the SCMP API.](https://apps.cybersource.com/library/documentation/dev_guides/Retail_SCMP_API/html/wwhelp/wwhimpl/js/html/wwhelp.htm)
     * @return $this
     */
    public function setEntryMode($entryMode)
    {
        if (!is_null($entryMode) && (strlen($entryMode) > 11)) {
            throw new \InvalidArgumentException('invalid length for $entryMode when calling TssV2TransactionsGet200ResponsePointOfSaleInformation., must be smaller than or equal to 11.');
        }

        $this->container['entryMode'] = $entryMode;

        return $this;
    }

    /**
     * Gets terminalCapability
     * @return int
     */
    public function getTerminalCapability()
    {
        return $this->container['terminalCapability'];
    }

    /**
     * Sets terminalCapability
     * @param int $terminalCapability POS terminal???s capability. Possible values:   - `1`: Terminal has a magnetic stripe reader only.  - `2`: Terminal has a magnetic stripe reader and manual entry capability.  - `3`: Terminal has manual entry capability only.  - `4`: Terminal can read chip cards.  - `5`: Terminal can read contactless chip cards.  The values of 4 and 5 are supported only for EMV transactions. * Applicable only for CTV for Payouts.  For processor-specific details, see the `terminal_capability` field description in [Card-Present Processing Using the SCMP API.](https://apps.cybersource.com/library/documentation/dev_guides/Retail_SCMP_API/html/wwhelp/wwhimpl/js/html/wwhelp.htm)
     * @return $this
     */
    public function setTerminalCapability($terminalCapability)
    {

        if (!is_null($terminalCapability) && ($terminalCapability > 5)) {
            throw new \InvalidArgumentException('invalid value for $terminalCapability when calling TssV2TransactionsGet200ResponsePointOfSaleInformation., must be smaller than or equal to 5.');
        }
        if (!is_null($terminalCapability) && ($terminalCapability < 1)) {
            throw new \InvalidArgumentException('invalid value for $terminalCapability when calling TssV2TransactionsGet200ResponsePointOfSaleInformation., must be bigger than or equal to 1.');
        }

        $this->container['terminalCapability'] = $terminalCapability;

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


