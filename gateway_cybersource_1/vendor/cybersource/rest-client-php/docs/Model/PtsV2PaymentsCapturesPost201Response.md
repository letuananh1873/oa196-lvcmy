# PtsV2PaymentsCapturesPost201Response

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**links** | [**\CyberSource\Model\PtsV2PaymentsCapturesPost201ResponseLinks**](PtsV2PaymentsCapturesPost201ResponseLinks.md) |  | [optional] 
**id** | **string** | An unique identification number assigned by CyberSource to identify the submitted request. It is also appended to the endpoint of the resource. | [optional] 
**submitTimeUtc** | **string** | Time of request in UTC. Format: &#x60;YYYY-MM-DDThh:mm:ssZ&#x60; Example &#x60;2016-08-11T22:47:57Z&#x60; equals August 11, 2016, at 22:47:57 (10:47:57 p.m.). The &#x60;T&#x60; separates the date and the time. The &#x60;Z&#x60; indicates UTC. | [optional] 
**status** | **string** | The status of the submitted transaction.  Possible values:  - PENDING | [optional] 
**reconciliationId** | **string** | The reconciliation id for the submitted transaction. This value is not returned for all processors. | [optional] 
**clientReferenceInformation** | [**\CyberSource\Model\PtsV2PaymentsPost201ResponseClientReferenceInformation**](PtsV2PaymentsPost201ResponseClientReferenceInformation.md) |  | [optional] 
**processorInformation** | [**\CyberSource\Model\PtsV2PaymentsCapturesPost201ResponseProcessorInformation**](PtsV2PaymentsCapturesPost201ResponseProcessorInformation.md) |  | [optional] 
**orderInformation** | [**\CyberSource\Model\PtsV2PaymentsCapturesPost201ResponseOrderInformation**](PtsV2PaymentsCapturesPost201ResponseOrderInformation.md) |  | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


