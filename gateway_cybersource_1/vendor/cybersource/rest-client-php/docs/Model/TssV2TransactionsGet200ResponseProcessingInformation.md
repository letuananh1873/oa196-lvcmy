# TssV2TransactionsGet200ResponseProcessingInformation

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**paymentSolution** | **string** | Type of digital payment solution for the transaction. Possible Values:   - &#x60;visacheckout&#x60;: Visa Checkout. This value is required for Visa Checkout transactions. For details, see &#x60;payment_solution&#x60; field description in [Visa Checkout Using the SCMP API.](https://apps.cybersource.com/library/documentation/dev_guides/VCO_SCMP_API/html/wwhelp/wwhimpl/js/html/wwhelp.htm)  - &#x60;001&#x60;: Apple Pay.  - &#x60;004&#x60;: Cybersource In-App Solution.  - &#x60;005&#x60;: Masterpass. This value is required for Masterpass transactions on OmniPay Direct. For details, see \&quot;Masterpass\&quot; in the [Credit Card Services Using the SCMP API Guide.](https://apps.cybersource.com/library/documentation/dev_guides/CC_Svcs_SCMP_API/html/wwhelp/wwhimpl/js/html/wwhelp.htm)  - &#x60;006&#x60;: Android Pay.  - &#x60;007&#x60;: Chase Pay.  - &#x60;008&#x60;: Samsung Pay.  - &#x60;012&#x60;: Google Pay. | [optional] 
**commerceIndicator** | **string** | Type of transaction. Some payment card companies use this information when determining discount rates. When you omit this field for **Ingenico ePayments**, the processor uses the default transaction type they have on file for you instead of the default value listed here. | [optional] 
**businessApplicationId** | **string** | Payouts transaction type. Required for OCT transactions. This field is a pass-through, which means that CyberSource does not verify the value or modify it in any way before sending it to the processor. **Note** When the request includes this field, this value overrides the information in your CyberSource account.  For valid values, see the &#x60;invoiceHeader_businessApplicationID&#x60; field description in [Payouts Using the Simple Order API.](http://apps.cybersource.com/library/documentation/dev_guides/payouts_SO/Payouts_SO_API.pdf) | [optional] 
**authorizationOptions** | [**\CyberSource\Model\TssV2TransactionsGet200ResponseProcessingInformationAuthorizationOptions**](TssV2TransactionsGet200ResponseProcessingInformationAuthorizationOptions.md) |  | [optional] 
**bankTransferOptions** | [**\CyberSource\Model\TssV2TransactionsGet200ResponseProcessingInformationBankTransferOptions**](TssV2TransactionsGet200ResponseProcessingInformationBankTransferOptions.md) |  | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


