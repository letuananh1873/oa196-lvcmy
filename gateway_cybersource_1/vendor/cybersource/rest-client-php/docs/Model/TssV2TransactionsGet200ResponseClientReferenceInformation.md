# TssV2TransactionsGet200ResponseClientReferenceInformation

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**code** | **string** | Client-generated order reference or tracking number. CyberSource recommends that you send a unique value for each transaction so that you can perform meaningful searches for the transaction.  For information about tracking orders, see \&quot;Tracking and Reconciling Your Orders\&quot; in [Getting Started with CyberSource Advanced for the SCMP API.](https://apps.cybersource.com/library/documentation/dev_guides/Getting_Started_SCMP/html/wwhelp/wwhimpl/js/html/wwhelp.htm)  #### FDC Nashville Global Certain circumstances can cause the processor to truncate this value to 15 or 17 characters for Level II and Level III processing, which can cause a discrepancy between the value you submit and the value included in some processor reports. | [optional] 
**applicationVersion** | **string** | The description for this field is not available. | [optional] 
**applicationName** | **string** | The application name of client which is used to submit the request. | [optional] 
**applicationUser** | **string** | The description for this field is not available. | [optional] 
**comments** | **string** | Brief description of the order or any comment you wish to add to the order. | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)

