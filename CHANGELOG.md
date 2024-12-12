## v1.0.95

``Previous version v1.0.94``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 6c83831 | 2024-12-11 17:27:29 CET | HorstOeko | Significantly increased PDF file size | #211
| e2ee3d1 | 2024-12-11 17:15:15 CET | HorstOeko | Significantly increased PDF file size -> Changed to smaller ICC profile | #211

:exclamation: _There is one internal commit_

## v1.0.94

``Previous version v1.0.93``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| ce4b854 | 2024-12-11 12:20:56 CET | HorstOeko | Customizable PDF Metadata -> Added Templates and Callback Function | #208
| 3735ae8 | 2024-12-11 06:01:52 CET | HorstOeko | Customizable PDF Metadata -> Additionally using FPDF-BuiltIn-Metadata methods (Fix UTF8) | #208
| 17edaa7 | 2024-12-11 05:52:04 CET | HorstOeko | Customizable PDF Metadata -> Additionally using FPDF-BuiltIn-Metadata methods | #208
| 7a9ade1 | 2024-12-11 05:29:46 CET | HorstOeko | Customizable PDF Metadata -> Removed unused variable in PdfBuilderEn16931Test::testCustomMetaInformation | #208
| fa686e9 | 2024-12-11 05:02:40 CET | HorstOeko | Customizable PDF Metadata -> Added Templates and Callback Function | #208

## v1.0.93

``Previous version v1.0.92``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| d1f0782 | 2024-12-09 18:04:39 CET | HorstOeko | [ENH] Added tests for deterministic mode | 
| 9aaebf3 | 2024-12-09 17:50:12 CET | HorstOeko | [ENH] Improved PDF-Tests | 
| 3ed50a4 | 2024-12-09 16:39:59 CET | HorstOeko | [ENH] Use DateTime values with correct timezone | 
| 9f42bf5 | 2024-12-09 14:49:54 CET | HorstOeko | Fix DateTime-Handling (strings with linebreaks) | #206
| 28f312c | 2024-12-09 14:43:34 CET | HorstOeko | Fix DateTime-Handling (strings with linebreaks) | #206

:exclamation: _There are 2 internal commit(s)_

## v1.0.92

``Previous version v1.0.91``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 5c67f6b | 2024-12-08 13:18:54 CET | HorstOeko | [ENH] Add deterministic Mode to ZugferdDocumentPdfBuilderAbstract | 
| fcf7ffc | 2024-12-07 10:36:47 CET | HorstOeko | [ENH] Add deterministic Mode to ZugferdDocumentPdfBuilderAbstract (and derived classes). This mode should only used for testing purposes | 
| d799b4c | 2024-12-08 10:00:57 CET | HorstOeko | [ENH] Changed InvalidArgumentException to ZugferdInvalidArgumentException | 
| 38ea3f7 | 2024-12-07 10:36:47 CET | HorstOeko | [ENH] Add deterministic Mode to ZugferdDocumentPdfBuilderAbstract (and derived classes). This mode should only used for testing purposes | 
| e5e0498 | 2024-12-06 14:16:47 CET | HorstOeko | [ENH] Added ZugferdSpecificationVersions to get the latest used specification versions | 
| 2a2ff79 | 2024-12-06 05:06:00 CET | HorstOeko | [FIX] Typo in variable Name | 

:exclamation: _There are 2 internal commit(s)_

## v1.0.91

``Previous version v1.0.90``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| d66ee79 | 2024-12-05 05:40:27 CET | HorstOeko | [ENH] Added new methods addDocumentPaymentMeanToCreditTransferNonSepa and addDocumentPaymentMeanToDirectDebitNonSepa to ZugferdDocumentBuilder | 
| 1e5ffc9 | 2024-12-03 11:38:35 CET | HorstOeko | Merged PR | #195
| dc5a881 | 2024-12-02 17:04:33 CET | Carsten Schmitz | Fixed issue: Using addDocumentAllowanceCharge with Code SERVICE_OUTSIDE_SCOPE_OF_TAX never passes validation as the Taxtype is omitted if you pass no VAT rate | 

:exclamation: _There are 6 internal commit(s)_

## v1.0.90

``Previous version v1.0.89``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 2dfebcb | 2024-12-03 05:52:07 CET | HorstOeko | [ENH] Added ZugferdDocumentReader::getDocumentPositionLineSummationExt to satisfy the EXTENDED profile | 
| ea74726 | 2024-12-03 05:45:20 CET | HorstOeko | [ENH] Added ZugferdDocumentBuilder::setDocumentPositionLineSummationExt to satisfy the EXTENDED profile | 
| 75ae647 | 2024-12-03 05:35:33 CET | HorstOeko | [ENH] More parameters for LineMonetarySummation to satisfy the EXTENDED profile | 

## v1.0.89

``Previous version v1.0.88``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| f728e97 | 2024-12-02 17:48:08 CET | HorstOeko | [CS] Internal variables renamed to match the code style | 

:exclamation: _There are 4 internal commit(s)_

## v1.0.88

``Previous version v1.0.87``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 015544a | 2024-12-02 05:00:26 CET | HorstOeko | [DEPR] deprecated ZugferdDocumentReader::getDocumentPositionLineSummation, use ZugferdDocumentReader::getDocumentPositionLineSummationSimple | 

## v1.0.87

``Previous version v1.0.86``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 513d3b8 | 2024-12-01 12:37:49 CET | HorstOeko | [FEAT] Added methods ZugferdDocumentReader::getDocumentQuotationReferencedDocument and ZugferdDocumentReader::getDocumentPositionQuotationReferencedDocument | 
| f408494 | 2024-12-01 12:08:28 CET | HorstOeko | Added methods ZugferdDocumentBuiler::setDocumentQuotationReferencedDocument and ZugferdDocumentBuiler::setDocumentPositionQuotationReferencedDocument | 
| 7bd41ae | 2024-12-01 11:44:23 CET | HorstOeko | [FEAT] Added method ZugferdDocumentReader::getDocumentPositionSellerOrderReferencedDocument | 
| c35cdda | 2024-12-01 11:36:24 CET | HorstOeko | [FEAT] Added method ZugferdDocumentBuilder::setDocumentPositionSellerOrderReferencedDocument | 
| dee76ec | 2024-12-01 11:24:28 CET | HorstOeko | Added industryAssignedID to ZugferdDocumentReader::getDocumentPositionReferencedProduct | 
| 8ebd056 | 2024-12-01 11:13:32 CET | HorstOeko | [FEAT] Added industryAssignedID to ZugferdDocumentBuilder::addDocumentPositionReferencedProduct | 

:exclamation: _There is one internal commit_

## v1.0.86

``Previous version v1.0.85``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 02d0e4c | 2024-11-29 05:36:43 CET | HorstOeko | Added addDocumentSellerVATRegistrationNumber and addDocumentSellerTaxNumber to ZugferdDocumentBuilder | 
| 9d6d67a | 2024-11-29 05:02:54 CET | HorstOeko | Fix method visibillity in ZugferdDocumentPdfMerger | 
| 574abeb | 2024-11-28 13:43:22 CET | HorstOeko | Fix composer autoload psr-4 mapping | 
| f7e2293 | 2024-11-28 09:58:36 CET | Fabian Boensch | Fix composer autoload psr-4 mapping | 
| c2f6b17 | 2024-11-28 05:22:40 CET | HorstOeko | Use DeliveryTermsCodeType in getTradeDeliveryTermsType | 

:exclamation: _There is one internal commit_

## v1.0.85

``Previous version v1.0.84``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| b79c5c7 | 2024-11-27 18:00:44 CET | HorstOeko | Merged PR | #191
| 0ef5615 | 2024-11-27 17:38:17 CET | HorstOeko | Allow adding empty ShipTo nodes to the document without enforcing a TradeParty name | #189
| 380709c | 2024-11-27 17:01:45 CET | HorstOeko | Allow adding empty ShipTo nodes to the document without enforcing a TradeParty name | #189
| 90f7072 | 2024-11-27 16:07:52 CET | HorstOeko | Updated DocBlocks in ZugferdQuickDescriptor | 
| 2bf73cb | 2024-11-27 04:59:52 CET | HorstOeko | Updated XRechnung Quick Examples | 

## v1.0.84

``Previous version v1.0.83``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| fe84c3a | 2024-11-26 18:26:40 CET | HorstOeko | Added ZugferdQuickDescriptor::doSetSupplyChainEvent | 
| 41ce2be | 2024-11-26 17:04:59 CET | HorstOeko | Merged PR | #187

:exclamation: _There are 4 internal commit(s)_

## v1.0.83

``Previous version v1.0.82``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| def6f29 | 2024-11-26 11:16:21 CET | HorstOeko | Merged PR | #186
| 3a7aeec | 2024-11-26 11:10:41 CET | HorstOeko | Fixed duplicated VAT Breakdown in QuickDescriptor | #185

:exclamation: _There is one internal commit_

## v1.0.82

``Previous version v1.0.81``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 5b581b6 | 2024-11-26 05:07:32 CET | HorstOeko | Merged PR | #183
| ed98443 | 2024-11-25 20:16:38 CET | GM | Removed implicitly nullable parameter declarations | 

:exclamation: _There are 3 internal commit(s)_

## v1.0.81

``Previous version v1.0.80``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 98a89ec | 2024-11-25 17:34:03 CET | HorstOeko | Merged PR | #182
| a8ae46f | 2024-11-25 17:23:59 CET | HorstOeko | Add method for adding payment terms in special XRechnung-Syntax | #181
| 31fc364 | 2024-11-25 05:28:47 CET | HorstOeko | Updated example for XRechnung 3 | 
| 0976dd4 | 2024-11-22 15:16:53 CET | HorstOeko | Fixed Inconsistent Naming in Parameters | #177
| 43dff88 | 2024-11-22 15:15:57 CET | HorstOeko | Fixed Inconsistent Naming in Parameters | #177
| aee61fe | 2024-11-22 05:45:16 CET | HorstOeko | Better handling of mimetypes in ReferencedDocumentType | 
| 2ebe0d3 | 2024-11-21 15:16:21 CET | HorstOeko | Better handling of not readable files | 

:exclamation: _There are 25 internal commit(s)_

## v1.0.80

``Previous version v1.0.79``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 1542533 | 2024-11-16 13:01:47 CET | HorstOeko | Fix method visibillity in ZugferdKositValidator | 

:exclamation: _There are 11 internal commit(s)_

## v1.0.79

``Previous version v1.0.78``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 6e5901e | 2024-11-16 07:41:07 CET | HorstOeko | Merged PR | #170
| 0b101f8 | 2024-11-16 07:34:43 CET | HorstOeko | Handle Decimals of the measure type | #169
| cf43e13 | 2024-11-14 16:12:56 CET | HorstOeko | Fix Exception in ZugferdDocumentPdfMerger | 
| 7d8f01d | 2024-11-12 16:58:21 CET | HorstOeko | Better message handling in ZugferdKositValidator | 

:exclamation: _There are 2 internal commit(s)_

## v1.0.78

``Previous version v1.0.77``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| bacbe67 | 2024-11-11 11:59:22 CET | HorstOeko | Reset internal pointers | 
| 6c102e6 | 2024-11-11 11:58:44 CET | HorstOeko | Reset internal pointers | 

## v1.0.77

``Previous version v1.0.76``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| f615cf4 | 2024-11-05 16:34:37 CET | HorstOeko | Removed duplicate context parameter | #164
| da21b65 | 2024-11-05 05:05:57 CET | HorstOeko | Pre-assignment of 'BusinessProcessSpecifiedDocumentContextParameter' for profile EXTENDED | #159
| d209690 | 2024-11-04 16:30:49 CET | HorstOeko | Pre-assignment of 'BusinessProcessSpecifiedDocumentContextParameter' with 'urn:fdc:peppol.eu:2017:poacc:billing:01:1.0' in extended profile | #159
| 1646873 | 2024-11-04 05:42:51 CET | HorstOeko | Pre-assignment of 'BusinessProcessSpecifiedDocumentContextParameter' with 'urn:fdc:peppol.eu:2017:poacc:billing:01:1.0' in all profiles | #159

:exclamation: _There is one internal commit_

## v1.0.76

``Previous version v1.0.75``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 74bd98c | 2024-11-03 10:05:21 CET | HorstOeko | Breaking Change: ZugferdPdfReader does not return null-values for "readAndGuessFromFile", "readAndGuessFromContent", "getXmlFromFile" and "getXmlFromContent" anymore. Now always exceptions are raised. | 

## v1.0.75

``Previous version v1.0.74``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| f3b99d7 | 2024-11-02 08:13:19 CET | HorstOeko | Reverted changes to ZugferdKositValidator | 
| 6a9ba32 | 2024-11-01 14:13:47 CET | HorstOeko | Improved ZugferdKositValidator -> added direct content validation, deprecated direct call of constructor, added new methods fromDocument and fromString | 
| 4cfa20f | 2024-11-01 12:59:28 CET | HorstOeko | Deprecated addNewTextPosition by version >= 1.0.75 | 
| ce20454 | 2024-11-01 12:29:11 CET | HorstOeko | Added more validation calls to example/XsdValidator | 

:exclamation: _There are 3 internal commit(s)_

## v1.0.74

``Previous version v1.0.73``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| b1ab332 | 2024-11-01 10:17:24 CET | HorstOeko | An option has been created to attach additional attachments to a PDF | 
| 7a54537 | 2024-11-01 09:52:25 CET | HorstOeko | Possibility to add additional documents (attachments) to a PDF in the classes ``ZugferdDocumentPdfBuilder`` and ``ZugferdDocumentPdfMerger``. (See Issue ) | #153
| 0d97519 | 2024-11-01 09:14:42 CET | HorstOeko | Possibility to add additional documents (attachments) to a PDF in the classes ``ZugferdDocumentPdfBuilder`` and ``ZugferdDocumentPdfMerger``. (See Issue ) | #153
| e03f663 | 2024-10-31 15:53:18 CET | HorstOeko | Fix sample file | #155

:exclamation: _There is one internal commit_

## v1.0.73

``Previous version v1.0.72``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| b6aa5cb | 2024-10-30 18:48:35 CET | HorstOeko | Merged PR | #152
| 0a1420f | 2024-10-30 16:27:17 CET | HorstOeko | Added support for alternative context parameters | 

:exclamation: _There are 4 internal commit(s)_

## v1.0.72

``Previous version v1.0.71``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 4895eac | 2024-10-24 18:50:47 CEST | HorstOeko | Merged PR | #149
| 9f550dc | 2024-10-24 16:07:15 CEST | HorstOeko | Allow "Source" for XML attachment relationship, added quick accessor to switch to "Data", "Alternative" or "Source" relation ship | #147

:exclamation: _There is one internal commit_

## v1.0.71

``Previous version v1.0.70``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 8180c5a | 2024-10-24 16:17:20 CEST | HorstOeko | Merged PR | #148
| 0da33d0 | 2024-10-24 16:07:15 CEST | HorstOeko | Added "setAttachmentRelationshipType" to ZugferdDocumentPdfBuilderAbstract for setting up an alternative relationship type for the XML attachment. Allowed values are 'Data' and 'Alternative' | #147

## v1.0.70

``Previous version v1.0.69``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 78a896e | 2024-10-23 20:23:47 CEST | HorstOeko | Fix result type of DocumentLanguage in ZugferdDocumentReader::getDocumentInformation | 
| 65ce898 | 2024-10-23 19:56:46 CEST | HorstOeko | Fix result type of DocumentNo in ZugferdDocumentReader::getDocumentInformation | 

## v1.0.69

``Previous version v1.0.68``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 31877c6 | 2024-10-22 05:33:57 CEST | HorstOeko | Fixed typo in TestCase method | 
| c025d0c | 2024-10-22 04:55:38 CEST | HorstOeko | Merged PR | #146
| 629c879 | 2024-10-22 04:50:46 CEST | HorstOeko | Sealed class ZugferdDocument | 
| 509f503 | 2024-10-19 09:27:59 CEST | HorstOeko | Update Codelist "ZugferdReferenceCodeQualifiers" (UNTDID 1153) | 
| 6c9ce73 | 2024-10-19 09:22:44 CEST | HorstOeko | Update Codelist "ZugferdReferenceCodeQualifiers" (UNTDID 1153) | 

:exclamation: _There are 2 internal commit(s)_

## v1.0.68

``Previous version v1.0.67``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 01e7fcc | 2024-10-16 05:50:28 CEST | HorstOeko | Merged PR | #140
| c61b141 | 2024-10-16 05:44:12 CEST | HorstOeko | Fixed ZugferdDocumentPdfBuilder brakes Hyperlink | #139

:exclamation: _There are 2 internal commit(s)_

## v1.0.67

``Previous version v1.0.66``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| ef86636 | 2024-10-13 15:23:56 CEST | HorstOeko | Consolidated exceptions with horstoeko/orderx | 

:exclamation: _There is one internal commit_

## v1.0.66

``Previous version v1.0.65``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 2a009cd | 2024-10-11 11:37:47 CEST | HorstOeko | Merged PR | #137
| 765fb73 | 2024-10-11 11:23:09 CEST | HorstOeko | Added "getDocumentSellerCommunication" and "getDocumentBuyerCommunication" to ZugferdDocumentReader | #136
| 1140e93 | 2024-10-06 12:05:26 CEST | HorstOeko | Fix ProfileResolverTest | 

:exclamation: _There are 3 internal commit(s)_

## v1.0.65

``Previous version v1.0.64``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| ccafcda | 2024-10-06 11:56:35 CEST | HorstOeko | Added test for Issue | #133
| 1f2910a | 2024-10-06 11:37:51 CEST | HorstOeko | Fix ZugferdDocumentPdfBuilder::getXmlContent | 
| a913361 | 2024-10-06 10:12:03 CEST | HorstOeko | Fix imports (Namespaces) | 
| 32f641b | 2024-10-06 10:01:43 CEST | HorstOeko | Added more PDF tests | 
| eaa7907 | 2024-10-05 18:24:16 CEST | HorstOeko | Added new evaluation methods hasNoValidationErrors and hasValidationErrors to ZugferdXsdValidator, deprecated validationPased and validationFailed | 

:exclamation: _There are 4 internal commit(s)_

## v1.0.64

``Previous version v1.0.63``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 9fbb454 | 2024-10-04 20:49:47 CEST | HorstOeko | Merged PR | #134
| ef1bb65 | 2024-10-04 16:47:55 CEST | Daniel Marschall | Update ZugferdProfileResolver.php | 

:exclamation: _There are 4 internal commit(s)_

## v1.0.63

``Previous version v1.0.62``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| c1b4d7f | 2024-10-02 17:38:51 CEST | HorstOeko | Merged PR | #131
| dddad3d | 2024-10-02 17:18:59 CEST | HorstOeko | Fix name parameter in additional referenced documents -> Improved tests | #130
| 73c0eb3 | 2024-10-02 17:01:37 CEST | HorstOeko | Fix name parameter in additional referenced documents | #130

:exclamation: _There are 2 internal commit(s)_

## v1.0.62

``Previous version v1.0.61``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 552600e | 2024-09-26 05:16:45 CEST | HorstOeko | Improved tests for LogisticsServiceCharge | 
| f46e964 | 2024-09-25 05:32:32 CEST | HorstOeko | Added exchangeRate parameter to ZugferdDocumentBuilder::setForeignCurrency | 
| f2766ed | 2024-09-24 17:13:44 CEST | HorstOeko | Added tests for foreign currency | 
| d52dfea | 2024-09-24 16:13:45 CEST | HorstOeko | ZugferdDocumentPdfReader now contains additional methods for extracting the XML content | #120
| c44f617 | 2024-09-24 16:07:22 CEST | HorstOeko | ZugferdDocumentPdfReader now contains additional methods for extracting the XML content -> better method names | #120
| 10fc7d3 | 2024-09-24 05:21:35 CEST | HorstOeko | ZugferdDocumentPdfReader now contains additional methods for extracting the XML content | #120
| 1422fc1 | 2024-09-23 16:38:42 CEST | HorstOeko | Implemented changes from ZUGFeRD 2.3 | #119
| 42cbe91 | 2024-09-23 06:16:24 CEST | HorstOeko | Update to ZUGFeRD 2.3 (PHPCS, PHPStan) | #119
| 10520c3 | 2024-09-23 05:23:56 CEST | HorstOeko | Update to ZUGFeRD 2.3 (Support for InvoiceReferencedDocument) | #119
| d7fe3bd | 2024-09-21 13:45:10 CEST | HorstOeko | Update to ZUGFeRD 2.3 | #119

:exclamation: _There are 4 internal commit(s)_

## v1.0.61

``Previous version v1.0.60``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| e3c0d2b | 2024-09-12 16:13:26 CEST | HorstOeko | Merged PR | #114
| 178a51b | 2024-09-12 16:04:09 CEST | HorstOeko | Fix provided (Tests) | #113
| a160f93 | 2024-09-12 16:03:45 CEST | HorstOeko | Fix provided | #113
| aa40db6 | 2024-09-10 06:09:17 CEST | HorstOeko | Merged PR | #112

:exclamation: _There are 5 internal commit(s)_

## v1.0.60

``Previous version v1.0.59``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 10c2296 | 2024-09-06 12:26:03 CEST | HorstOeko | Merged PR | #110
| be7780f | 2024-09-06 12:21:15 CEST | HorstOeko | Added missing call to libxml_clear_errors in ZugferdProfileResolver | #108
| dbafaab | 2024-09-06 12:17:31 CEST | HorstOeko | Merged PR | #109
| 1355220 | 2024-09-06 12:13:26 CEST | HorstOeko | Added readAndGuessFromContent to ZugferdDocumentPdfReader | #107

:exclamation: _There is one internal commit_

## v1.0.59

``Previous version v1.0.58``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| d967bfe | 2024-09-04 05:04:52 CEST | HorstOeko | Merged PR | #106
| c05d6d4 | 2024-09-03 17:08:19 CEST | HorstOeko | Use LibXML Internal errors in ProfileResolver | #104

:exclamation: _There are 7 internal commit(s)_

## v1.0.58

``Previous version v1.0.57``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| e5ebbec | 2024-09-02 17:21:11 CEST | HorstOeko | Merged PR | #105
| 702b12e | 2024-09-02 17:11:36 CEST | HorstOeko | ProfileResolver should raise ZugferdUnknownXmlContentException when XML content is not valid | #104

:exclamation: _There are 17 internal commit(s)_

## v1.0.57

``Previous version v1.0.56``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 272e9ba | 2024-07-10 05:39:20 CEST | HorstOeko | Merged PR | #100
| 7401eca | 2024-07-09 22:07:13 CEST | Daniel Marschall | Fix ZugferdPdfWriter not outputting metadata if there are no files | 

:exclamation: _There are 2 internal commit(s)_

## v1.0.56

``Previous version v1.0.55``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| ae34e64 | 2024-06-15 07:49:47 CEST | HorstOeko | Merged PR | #97
| 34b7698 | 2024-06-15 07:36:21 CEST | HorstOeko | Add multiple IDs for several trade parties () | #96

## v1.0.55

``Previous version v1.0.54``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 3dd9617 | 2024-06-14 22:32:06 CEST | HorstOeko | Merged PR | #95
| deba063 | 2024-06-14 22:18:41 CEST | HorstOeko | Added methods "addDocumentSellerId" and "addDocumentBuyerId" for addings additional ids (not global ids) for seller and buyer () | #90
| 127f1de | 2024-06-14 21:30:51 CEST | HorstOeko | Merged PR | #94
| e2938a4 | 2024-06-14 20:31:12 CEST | HorstOeko | Multiple Deprecation Warnings in 1.0.54 () | #89
| fe43910 | 2024-06-14 18:14:07 CEST | HorstOeko | Merged PR | #93
| c9875bb | 2024-06-14 18:11:00 CEST | HorstOeko | Revert "Update ZugferdDocumentBuilder.php" | 
| d1f475b | 2024-06-14 18:04:50 CEST | HorstOeko | Merged PR | #91
| 00cc2fb | 2024-06-14 17:01:18 CEST | OLLIVAULT | Update ZugferdDocumentBuilder.php | 
| 116fc5f | 2024-06-12 05:27:52 CEST | HorstOeko | Added example for how to handle AdditionalReferencedDocument | 
| 15da379 | 2024-06-11 15:52:16 CEST | HorstOeko | Added example for BASIC Profile | 
| a853ac9 | 2024-06-11 09:27:47 CEST | HorstOeko | Merged PR | #86
| 56af827 | 2024-06-10 16:42:16 CEST | OLLIVAULT | Update ZugferdDocumentBuilder.php | 

## v1.0.54

``Previous version v1.0.53``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 91547c8 | 2024-06-07 09:47:18 CEST | HorstOeko | Merged PR | #85
| fa2691d | 2024-06-06 19:13:44 CEST | OLLIVAULT | Update ZugferdDocumentBuilder.php | 

## v1.0.53

``Previous version v1.0.52``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 939e93a | 2024-06-05 18:49:22 CEST | HorstOeko | Merged PR | #84
| c8ea81d | 2024-06-05 18:45:24 CEST | HorstOeko | Merged PR | #83
| cb724a0 | 2024-06-05 18:44:32 CEST | HorstOeko | Merged PR | #82
| a5d69dc | 2024-06-05 18:43:46 CEST | HorstOeko | Merged PR | #81
| 66e1f9c | 2024-06-05 17:00:35 CEST | OLLIVAULT | Create ZugferdElectronicAddressScheme.php | 
| 67af479 | 2024-06-05 16:42:18 CEST | OLLIVAULT | Create ZugferdVATExemptionReasonCode.php | 
| c30973f | 2024-06-05 16:07:05 CEST | OLLIVAULT | Update ZugferdInvoiceType.php | 
| 296022d | 2024-06-05 16:02:33 CEST | OLLIVAULT | Update ZugferdInvoiceType.php | 
| 2069cf8 | 2024-06-05 15:46:53 CEST | OLLIVAULT | Update ZugferdSchemeIdentifiers.php | 
| 6b24e46 | 2024-06-05 15:36:34 CEST | HorstOeko | Merged PR | #80
| 15fbe68 | 2024-06-05 15:09:28 CEST | OLLIVAULT | Detailed Input Value References in DocumentBuilder | 
| 99af9f9 | 2024-06-05 15:03:53 CEST | OLLIVAULT | Detailed Input Value References in DocumentBuilder | 

## v1.0.52

``Previous version v1.0.51``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 63d1108 | 2024-05-31 19:29:34 CEST | HorstOeko | ZugferdDocumentPdfBuilder -> Clean | 

## v1.0.51

``Previous version v1.0.49``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 9e036d4 | 2024-05-31 19:20:07 CEST | HorstOeko | Fix ZugferdDocumentPdfBuilder -> static::fromPdfFile | 
| 4b4342b | 2024-05-31 18:36:34 CEST | HorstOeko | Merged PR | #77
| a285998 | 2024-05-31 18:32:08 CEST | HorstOeko | Merged PR | #74
| 8f7e8f1 | 2024-05-31 16:55:28 CEST | OLLIVAULT | Detailed Input Value References in DocumentBuilder (Up to EN 16931, Work in Progress) | 
| ac76dba | 2024-05-30 14:31:22 CEST | OLLIVAULT | Detailed Input Value References in DocumentBuilder | 

:exclamation: _There is one internal commit_

## v1.0.50

``Previous version v1.0.48``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| bc4f918 | 2024-05-30 16:58:49 CEST | HorstOeko | Merged PR | #76
| cb23bc1 | 2024-05-30 16:07:02 CEST | HorstOeko | Merged PR | #75
| 04a4d79 | 2024-05-30 15:47:58 CEST | Daniel Marschall | Fixed problem with ZugferdSettings special decimal places. Fixes | #73
| f0c6840 | 2024-05-29 19:37:14 CEST | HorstOeko | Merged PR | #71
| 3aa3fc8 | 2024-05-29 19:24:15 CEST | Daniel Marschall | Fix typo | 

:exclamation: _There are 2 internal commit(s)_

## v1.0.48

``Previous version v1.0.47``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 32233f8 | 2024-05-29 17:12:06 CEST | HorstOeko | Merged PR | #70
| c018035 | 2024-05-29 17:03:11 CEST | HorstOeko | Fix for "Cannot access private property" | 
| 6e05993 | 2024-05-29 16:44:09 CEST | HorstOeko | Merged PR | #69
| 41f69cd | 2024-05-29 15:57:22 CEST | Daniel Marschall | Remove unnecessary comment | 
| ffa5204 | 2024-05-29 15:56:06 CEST | Daniel Marschall | Fix CI | 
| 538397b | 2024-05-29 15:16:57 CEST | Daniel Marschall | Fixed problem with Country ID at profile minimum (Fixes ) | #66
| 0f4b2d5 | 2024-05-29 13:10:09 CEST | HorstOeko | Merged PR | #64
| a0f8b04 | 2024-05-29 05:12:17 CEST | HorstOeko | Added method setUnitAmountDecimals to ZugferdSettings | 
| d21a4c5 | 2024-05-28 18:01:29 CEST | HorstOeko | Merged PR | #63
| d5b192a | 2024-05-28 17:59:58 CEST | HorstOeko | Define decimal places for node paths | 
| 3efed44 | 2024-05-28 16:29:18 CEST | Fabian Blechschmidt | Fix typo taxCategpryCodes -> taxCategoryCodes | 
| 0ae838a | 2024-05-27 07:45:16 CEST | HorstOeko | Merged PR | #61
| d292f8a | 2024-05-26 10:16:55 CEST | Daniel Marschall | ZugferdDocumentPdfReader aceepts ZUGFeRD 1.0 filenames on unix systems | 
| a42cdc6 | 2024-05-24 15:46:49 CEST | HorstOeko | Add static factory for existing files | 
| 4d9485a | 2024-05-24 12:41:22 CEST | Fabian Blechschmidt | Add second static factory | 
| 07adeac | 2024-05-24 10:28:18 CEST | Fabian Blechschmidt | Add static factory for existing files | 

:exclamation: _There is one internal commit_

## v1.0.47

``Previous version v1.0.45``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 7a5a8b7 | 2024-05-23 05:12:53 CEST | Daniel Marschall | Added $paymentReference to addDocumentPaymentMeanToCreditTransfer() () | #55
| 8f86816 | 2024-05-23 05:07:08 CEST | Daniel Marschall | addDocumentPaymentMeanToDirectDebit() now contains $creditorReferenceID parameter () | #54

## v1.0.46

``Previous version v1.0.44``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| b778941 | 2024-05-21 16:57:41 CEST | HorstOeko | Merged PR | #50
| c9eb2f2 | 2024-05-21 16:19:59 CEST | Daniel Marschall | Typo | 
| a60c731 | 2024-05-21 16:18:43 CEST | Daniel Marschall | Introduced ZugferdDocumentPdfBuilderAbstract::getCreatorToolName() | 
| a40ce4f | 2024-05-21 11:48:40 CEST | Daniel Marschall | Added setAdditionalCreatorTool() to the PDF builder | 

:exclamation: _There is one internal commit_

## v1.0.44

``Previous version v1.0.43``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| a0d82cc | 2024-05-16 18:19:44 CEST | HorstOeko | More granular eception (class) for several error situations | 
| 5daa391 | 2024-05-16 11:41:32 CEST | HorstOeko | Fix filename of ExtendedPdfReader,php example | 
| e87f749 | 2024-05-16 05:41:43 CEST | HorstOeko | Example with the different possibilities to work with discounts/surcharges added | 

:exclamation: _There is one internal commit_

## v1.0.43

``Previous version v1.0.42``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 1ddaf73 | 2024-05-13 15:32:59 CEST | HorstOeko | Merged PR | #46

:exclamation: _There is one internal commit_

## v1.0.42

``Previous version v1.0.41``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 2c1f188 | 2024-05-11 11:26:10 CEST | HorstOeko | Added Seeker and Getter to ZugferdDocumentReader for Product Characteristics, Product Classifications and Referenced Products (at position level) | 
| 63d794b | 2024-05-07 17:12:04 CEST | HorstOeko | Merged PR | #44
| 5ed8d50 | 2024-05-07 17:02:07 CEST | HorstOeko | Added Test for Issue | #43
| 00d4c79 | 2024-05-07 05:53:36 CEST | HorstOeko | Merged PR | #42
| bfa1560 | 2024-05-07 05:50:06 CEST | HorstOeko | ZugferdKositValidator -> Made message bag type constants private | 
| 429a990 | 2024-05-06 12:04:09 CEST | HorstOeko | Merged PR | #41
| e077217 | 2024-05-06 11:18:29 CEST | Markus Gärtner | Wrong Tax | 

:exclamation: _There is one internal commit_

## v1.0.41

``Previous version v1.0.40``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| fdc381c | 2024-04-18 05:54:58 CEST | HorstOeko | Added codelist for "Accounting Accounts Classification" (EDIFICASEU_AccountingAccountsClassificationType_D10A) | 

:exclamation: _There is one internal commit_

## v1.0.40

``Previous version v1.0.39``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| f18db8b | 2024-04-13 08:54:35 CEST | HorstOeko | Merged PR | #39
| ac81ad1 | 2024-04-13 08:45:07 CEST | HorstOeko | KositValidator -> Better message handling, New method to retrieve the output of the JAVA-Validator-Output (getProcessOutput) | 

## v1.0.39

``Previous version v1.0.38``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| da94b22 | 2024-04-12 13:24:58 CEST | HorstOeko | Merged PR | #38
| 30c593c | 2024-04-12 12:58:48 CEST | HorstOeko | KositValidator -> Cache downloaded versions | 
| 504a43b | 2024-04-12 11:19:08 CEST | HorstOeko | Merged PR | #37
| e802b0a | 2024-04-12 11:11:54 CEST | HorstOeko | KositValidator -> Fix download filename | 
| 2e8fc63 | 2024-04-12 09:37:38 CEST | HorstOeko | Merged PR | #36
| fc27ef7 | 2024-04-12 08:48:43 CEST | HorstOeko | KostValidator -> Improvements, Better message handling, Updated usage example | 
| dd4e4cc | 2024-04-10 05:19:37 CEST | HorstOeko | KositValidator Optimizations | 
| d8f3dfe | 2024-04-09 05:44:07 CEST | HorstOeko | Made more options configurable in KositValidator | 
| 0ff5c09 | 2024-04-09 05:36:27 CEST | HorstOeko | Improvements, Restructuring on ZugferdKositValidator | 
| 5b25a3d | 2024-04-08 05:47:25 CEST | HorstOeko | Added prototype of kosIT Validator | 

:exclamation: _There are 3 internal commit(s)_

## v1.0.38

``Previous version v1.0.37``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 47730d3 | 2024-04-05 05:38:38 CEST | HorstOeko | Added method "setDocumentBusinessProcess" to ZugferdDocumentBuilder for setting the BusinessProcessSpecifiedDocumentContextParameter-Element | 
| a4acca4 | 2024-03-28 14:41:16 CET | HorstOeko | Added moew unit tests for better test coverage | 

## v1.0.37

``Previous version v1.0.36``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 05f58ad | 2024-03-24 12:31:03 CET | HorstOeko | Merged PR | #33
| 6e1d4d0 | 2024-03-24 12:26:00 CET | HorstOeko | Added Fix and a Test for Issue 32 | 
| eb570a0 | 2024-03-24 11:17:34 CET | HorstOeko | Added Scripts for generating Codelists | 
| f05021f | 2024-03-12 05:20:50 CET | HorstOeko | Fix some PHPStan issues | 

## v1.0.36

``Previous version v1.0.35``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 0d15c30 | 2024-03-11 05:34:59 CET | HorstOeko | Added new ZugferdXsdValidator | 

## v1.0.35

``Previous version v1.0.34``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 56bc31d | 2024-03-10 08:15:59 CET | HorstOeko | Internal changes of InvoiceObject Handling | 
| bd47b83 | 2024-03-10 08:02:00 CET | HorstOeko | Members "invoiceObject" and "objectHelper" of ZugferdDocument now private (changed visibillity) | 
| f25afe1 | 2024-03-09 09:34:28 CET | HorstOeko | Adding method "getProfileDefinitionParameter" to ZugferdDocument for resolving options for the specific profile | 
| 32a3ab3 | 2024-03-09 08:50:29 CET | HorstOeko | Made properties "profileId", "profileDefinition", "serializerBuilder" and "serializer" private | 

:exclamation: _There is one internal commit_

## v1.0.34

``Previous version v1.0.33``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 963b8ab | 2024-01-27 10:14:13 CET | HorstOeko | Make XMP Meta Data filename configurable | 

:exclamation: _There is one internal commit_

## v1.0.33

``Previous version v1.0.32``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 0b08db6 | 2024-01-23 16:44:16 CET | HorstOeko | Merged PR | #28
| 3de47f4 | 2024-01-23 16:40:45 CET | HorstOeko | Merged PR | #29
| 9663fa5 | 2024-01-23 10:18:35 CET | Dominik Kohler | Fixed php requirement (caret constraint) | 
| abd8f69 | 2024-01-23 09:53:12 CET | Dominik Kohler | Run tests also for newer PHP releases | 

:exclamation: _There is one internal commit_

## v1.0.32

``Previous version v1.0.31``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| f678186 | 2024-01-22 11:35:33 CET | HorstOeko | Merged PR | #27
| aa6db69 | 2024-01-22 10:47:46 CET | Daniel Khalil | Add inline file output | 
| 6dfbc96 | 2023-12-17 13:50:08 CET | HorstOeko | Renamed file | 
| 19deb90 | 2023-10-18 06:15:01 CEST | HorstOeko | Fix type in variable name in ZugferdDocumentPdfBuilder | 

:exclamation: _There are 6 internal commit(s)_

## v1.0.31

``Previous version v1.0.30``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| d1cdb21 | 2023-10-12 18:05:51 CEST | HorstOeko | Centralisation of profile recognition -> Fix self vs. static | #25
| ebb3357 | 2023-10-12 17:46:52 CEST | HorstOeko | Centralisation of profile recognition -> Renamed variables | #25
| bf6765c | 2023-10-12 17:45:44 CEST | HorstOeko | Centralisation of profile recognition -> Removed constructor from ZugferdDocumentBuilder | #25
| 9c69850 | 2023-10-12 17:41:33 CEST | HorstOeko | Centralisation of profile recognition -> Fixed malformed use clauses | #25
| 170ebb0 | 2023-10-12 17:38:29 CEST | HorstOeko | Centralisation of profile recognition -> Some internal fixes | #25
| cc3bc1a | 2023-10-12 17:26:18 CEST | HorstOeko | Centralisation of profile recognition -> Use in ZugferdDocument and ZugferdObjectHelper | #25
| e13d6e0 | 2023-10-12 06:23:28 CEST | HorstOeko | Centralisation of profile recognition -> Added methods to ZugferdProfileResolver for resolving profile definition by profile id | #25
| e3c1953 | 2023-10-12 06:06:09 CEST | HorstOeko | Centralisation of profile recognition -> Using ZugferdProfileResolver in ZugferdDocumentPdfMerger and ZugferdDocumentReader | #25
| 7af4d01 | 2023-10-12 05:52:26 CEST | HorstOeko | Centralisation of profile recognition -> Added tests to phpunit.xml | #25
| 8db2564 | 2023-10-12 05:48:53 CEST | HorstOeko | Centralisation of profile recognition -> Added ZugferdProfileResolver, Added tests for the new ZugferdProfileResolver | #25
| 6fe3b13 | 2023-10-09 05:50:54 CEST | HorstOeko | For more clarity, internal variables have been renamed | 
| 8090763 | 2023-10-09 05:24:57 CEST | HorstOeko | Creating new pdf builder tests (internal methods) | 
| 1d8899c | 2023-10-03 14:36:08 CEST | HorstOeko | Removed is_writable in ZugferdDocumentReader::setBinaryDataDirectory | 

:exclamation: _There are 4 internal commit(s)_

## v1.0.30

``Previous version v1.0.29``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| b5e8565 | 2023-09-30 15:42:02 CEST | HorstOeko | Added __toString-Tests for all Builder-Tests | 
| 73b0ace | 2023-09-30 15:17:12 CEST | HorstOeko | Added magic method __toString to ZugferdDocumentBuilder to receive the XML content | 
| 85a4a19 | 2023-09-30 07:00:26 CEST | HorstOeko | More clarity in the ZugferdDocumentPdfMerger example | 
| dbc5ff8 | 2023-09-24 09:26:15 CEST | HorstOeko | Merged PR | #24

:exclamation: _There are 35 internal commit(s)_

## v1.0.29

``Previous version v1.0.28``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 9fb81e2 | 2023-09-23 08:15:04 CEST | HorstOeko | Removed dependency to adrienrn/php-mimetyper and replaced it with horstoeko/mimedb | 
| 22d8422 | 2023-09-22 05:35:14 CEST | HorstOeko | Fix parameter declarations in ObjectHelper | 
| 7e30f6a | 2023-09-14 16:16:49 CEST | HorstOeko | Added new CI.YML for multiple php versions | 
| 0b8f201 | 2023-09-14 16:16:05 CEST | HorstOeko | Added new CI.YML for multiple php versions | 
| 562cc39 | 2023-09-14 06:23:31 CEST | HorstOeko | Rework/Cleanup Examples | 
| 25736f4 | 2023-09-13 06:09:14 CEST | HorstOeko | Added Example for the JSON Exporter | 

:exclamation: _There are 4 internal commit(s)_

## v1.0.28

``Previous version v1.0.27``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| be78b1b | 2023-09-12 16:54:01 CEST | HorstOeko | Added methods for buyers and sellers electronic communication information in QuickDescriptors | 
| 48a4103 | 2023-09-12 16:33:28 CEST | HorstOeko | Merged PR | #23
| 55135c2 | 2023-09-12 16:25:59 CEST | HorstOeko | Better Schematron-Checks-Cleanup | 

:exclamation: _There is one internal commit_

## v1.0.27

``Previous version v1.0.26``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| e23117b | 2023-09-12 07:22:10 CEST | HorstOeko | Merged PR | #22
| ef6c00f | 2023-09-12 07:15:56 CEST | HorstOeko | Failonerror="false" for Schematron Checks | 
| 295ada2 | 2023-09-12 07:08:52 CEST | HorstOeko | Added QuickDescriptor for XRechnung 3 | 
| dc8e42a | 2023-09-12 06:49:49 CEST | HorstOeko | Updated to Validation Tool 1.5.0, New validation config | 
| d63c94e | 2023-09-11 18:26:46 CEST | HorstOeko | Revert "Updated to validationtool-1.5.0-standalone.jar" | 
| 89001a1 | 2023-09-11 18:22:15 CEST | HorstOeko | Updated to validationtool-1.5.0-standalone.jar | 
| d4bfa66 | 2023-09-11 18:09:01 CEST | HorstOeko | Revert "Actions -< use 2.3.1 validation config" | 
| bdff92c | 2023-09-11 18:06:06 CEST | HorstOeko | Actions -< use 2.3.1 validation config | 
| 4e44b09 | 2023-09-11 17:59:41 CEST | HorstOeko | Revert "Use the latest Kosit-Validation tool" | 
| 7ca201b | 2023-09-11 17:55:46 CEST | HorstOeko | Use older validation tool | 
| 86026ac | 2023-09-11 17:40:24 CEST | HorstOeko | Use the latest Kosit-Validation tool | 
| aa68cc2 | 2023-09-08 15:26:09 CEST | HorstOeko | Set DocumentFileName in XMP-Metadata by profile definition | 
| 9b4474e | 2023-09-07 07:07:12 CEST | HorstOeko | Add support for UniversalCommunication (Seller and Buyer) | 
| d08a0a1 | 2023-09-06 15:35:34 CEST | HorstOeko | Merged PR | #20
| c7f6e7f | 2023-09-06 15:30:11 CEST | HorstOeko | Define businessprocess in profiles | 
| 2ddb02b | 2023-09-06 14:23:14 CEST | HorstOeko | Merged PR | #19
| ed2106c | 2023-09-06 13:30:49 CEST | HorstOeko | Added Profile "PROFILE_XRECHNUNG_3" | #18
| d89d4a4 | 2023-09-06 13:22:57 CEST | HorstOeko | Added Profile "PROFILE_XRECHNUNG_2_3" | #18

:exclamation: _There are 5 internal commit(s)_

## v1.0.26

``Previous version v1.0.25``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 2a7541a | 2023-08-18 05:05:43 CEST | HorstOeko | Fix ZugferdDocumentPdfBuilderAbstract | 

## v1.0.25

``Previous version v1.0.24``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 04aeb4f | 2023-08-18 04:59:52 CEST | HorstOeko | Renamed ZugferdDocumentAbstractPdfBuilder to ZugferdDocumentPdfBuilderAbstract | 

## v1.0.24

``Previous version v1.0.23``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| be26511 | 2023-08-17 05:11:15 CEST | HorstOeko | Adding XMLDataCache to ZugferdDocumentPdfBuilder (like ZugferdDocumentPdfMerger) | 

:exclamation: _There is one internal commit_

## v1.0.23

``Previous version v1.0.21``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| bb55417 | 2023-08-16 19:39:36 CEST | HorstOeko | Removed useless cache-options from ZugferdDocumentPdfMerger | 

## v1.0.22

``Previous version v1.0.20``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 346a3c9 | 2023-08-16 16:55:37 CEST | HorstOeko | Merged PR | #17
| a0eaa90 | 2023-08-16 16:37:49 CEST | HorstOeko | Added Example for ZugferdDocumentPdfMerger (En16931PdfMerger) | #14
| 75e7ff6 | 2023-08-16 16:29:29 CEST | HorstOeko | Final ZugferdDocumentPdfMerger | #14
| cec9e77 | 2023-08-16 16:24:25 CEST | HorstOeko | Introducing the ZugferdDocumentPdfMerger | #14
| 5ee0f3c | 2023-08-16 14:06:41 CEST | HorstOeko | Merged PR | #16
| 2d27efa | 2023-08-16 12:23:41 CEST | David Bomba | Add string output as option | 

:exclamation: _There is one internal commit_

## v1.0.20

``Previous version v1.0.19``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 725c130 | 2023-07-04 17:21:32 CEST | HorstOeko | Merged PR | #13
| 4a5446e | 2023-07-04 17:10:47 CEST | HorstOeko | Added method setDocumentRoutingId to ZugferdDocumentBuilder | #12
| ff48359 | 2023-07-04 16:59:06 CEST | HorstOeko | Added \minimum\udt\AmountType to ZugferdTypesHandler | #11
| e87cdd8 | 2023-07-03 16:47:16 CEST | HorstOeko | Removed useless code from Issue10Test | 
| b8fad9a | 2023-07-03 16:40:53 CEST | HorstOeko | Added Unit-Testss | #10

:exclamation: _There is one internal commit_

## v1.0.19

``Previous version v1.0.18``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 2432b4f | 2023-05-16 06:16:15 CEST | HorstOeko | Added Tests for MINIMUM-Profile, Fix YAML Definitions | 
| 0ab1a9b | 2023-05-15 17:22:12 CEST | HorstOeko | Added missing FACTUR-X_MINIMUM_codedb.xml | 
| f1bc40e | 2023-05-15 06:05:57 CEST | HorstOeko | Always enable auto resizing | #9
| de15bc4 | 2023-05-15 05:49:17 CEST | HorstOeko | Add minimum profile, no tests | 

## v1.0.18

``Previous version v1.0.17``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 24b636b | 2023-04-17 11:58:12 CEST | HorstOeko | Merged PR | #8
| 569b4f5 | 2023-04-17 10:54:05 CEST | UP | Version bump of smalot/pdfparser to allow php >=8.0 | 
| bce6df1 | 2023-02-17 20:09:24 CET | HorstOeko | Fix namespace for ReaderXRechnungSimpleTest | 

## v1.0.17

``Previous version v1.0.16``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 35ce9d0 | 2023-02-17 16:45:17 CET | HorstOeko | Fixed several code issues issued by PHPStan | 
| 0d609d3 | 2023-02-17 16:20:04 CET | HorstOeko | Merge with PDFWriter of Order-X-Library | 
| c7712a4 | 2023-02-17 05:31:39 CET | HorstOeko | Wrapper for deprecated utf8_encode function in PdfWriter | 
| 2c2e360 | 2023-02-17 05:26:00 CET | HorstOeko | Wrapper for deprecated utf8_encode function in PdfWriter | 
| bf68404 | 2023-02-16 05:33:51 CET | HorstOeko | Removed direct access to document properties | 
| cee9070 | 2023-02-16 05:33:09 CET | HorstOeko | Rework JSON exporter | 
| 83ab16a | 2023-02-15 17:00:50 CET | HorstOeko | Optimized PDF Build | 

:exclamation: _There are 7 internal commit(s)_

## v1.0.16

``Previous version v1.0.15``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 7f05d1b | 2023-02-14 06:22:14 CET | HorstOeko | Fix null-value for CardID in addDocumentPaymentMean of ZugferdDocumentBuilder | 
| 51741fc | 2023-02-14 05:24:32 CET | HorstOeko | Added missing tests for ZugferdSettings and ZugferdPackageVersion classes | 
| 8275a2b | 2023-02-13 19:59:06 CET | HorstOeko | Introducing ZugferdSettings class for configuring the library | 

:exclamation: _There are 6 internal commit(s)_

## v1.0.15

``Previous version v1.0.14``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 008dd6d | 2023-02-12 13:05:32 CET | HorstOeko | Removed docs - the will be deployed within the release process | 

:exclamation: _There are 5 internal commit(s)_

## v1.0.14

:exclamation: _There are 19 internal commit(s)_

## v1.0.13

``Previous version v1.0.12``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 0a99d41 | 2023-01-26 06:10:45 CET | HorstOeko | Publish package version to PDF, Therefore add a new class ZugferdPackageVersion | 

:exclamation: _There are 4 internal commit(s)_

## v1.0.12

``Previous version v1.0.11``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 9849ef3 | 2022-12-25 21:03:21 CET | HorstOeko | Fix for getDocumentSummation -> taxTotalAmount | 

:exclamation: _There are 4 internal commit(s)_

## v1.0.11

``Previous version v1.0.10``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 19af7d0 | 2022-10-21 11:39:54 CEST | HorstOeko | Merged PR | #6
| 6e5f3aa | 2022-10-21 11:39:12 CEST | HorstOeko | Merged PR | #7
| efeb516 | 2022-09-26 10:36:04 CEST | Brice Flaceliere | Fix context parameter for wasic-wl profile | 

:exclamation: _There is one internal commit_

## v1.0.10

``Previous version v1.0.9``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 1fc45b6 | 2022-06-18 10:08:50 CEST | HorstOeko | Added a json export class for exporting ZugferdDocument as a json string, a json object or a pretty printed json string, Added an example for this feature | 
| 2e90762 | 2022-06-18 10:04:42 CEST | HorstOeko | Added a json export class for exporting ZugferdDocument as a json string, a json object or a pretty printed json string, Added an example for this feature | 
| d9fb576 | 2022-06-18 09:07:20 CEST | HorstOeko | Fix example En16931ReaderPdf | 
| 6abf0fb | 2022-06-16 18:46:09 CEST | HorstOeko | Added new example: Read a PDF-document with embedded XML | 

:exclamation: _There are 3 internal commit(s)_

## v1.0.9

``Previous version v1.0.8``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 5a0b24b | 2022-03-29 13:49:37 CEST | HorstOeko | Make tests compatible to PHP 7.x and PHP 8.x | 
| a66d02c | 2022-03-29 13:41:15 CEST | HorstOeko | Make tests compatible to PHP 7.x and PHP 8.x | 
| 483042c | 2022-03-29 13:16:14 CEST | HorstOeko | Fixing PHP8 issues -> filemtime issues | 
| a958238 | 2022-03-29 12:47:32 CEST | HorstOeko | Fixing PHP8 issues -> is_file issues | 
| 734acf3 | 2022-03-29 12:21:31 CEST | HorstOeko | Fixing PHP8 issues -> method_exists wrapped | 
| 9835961 | 2022-03-29 12:12:57 CEST | HorstOeko | Fixing PHP8 issues | 
| 11a47e4 | 2022-03-29 12:08:01 CEST | HorstOeko | Fixing PHP8 issues | 
| 9975990 | 2022-03-29 12:04:19 CEST | HorstOeko | Revert "Fixing PHP8 issues" | 
| 0cdd79a | 2022-03-29 12:00:27 CEST | HorstOeko | Fixing PHP8 issues | 
| ef2673a | 2022-03-29 11:09:02 CEST | HorstOeko | Require PHP 7.3 or 8.0 or 8.1 | 
| eea7a80 | 2022-03-29 10:52:24 CEST | HorstOeko | Removed restriction to php 7.3 -> Fix Action Title | 
| ad7bd75 | 2022-03-29 10:51:22 CEST | HorstOeko | Removed restriction to php 7.3 | 

:exclamation: _There is one internal commit_

## v1.0.8

``Previous version v1.0.7``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| ac004db | 2022-03-08 11:21:02 CET | HorstOeko | Added tests for payment means (EN16931, Extended) | 
| 39df44f | 2022-03-08 09:21:53 CET | HorstOeko | Added more Builder-Tests for other tradeparty contacts | 
| c9c2921 | 2022-03-08 07:45:46 CET | HorstOeko | Added more Builder-Tests for Seller- and Buyer-Contact handling | 
| 305ae87 | 2022-03-06 14:57:48 CET | HorstOeko | Removed unused code | 
| 9424557 | 2022-03-06 14:39:33 CET | HorstOeko | Method call fixtures | 
| ea2f8fb | 2022-03-06 12:00:55 CET | HorstOeko | Added seekers (first/next) for tradeparty contact information. Useful in EXTENDED Profile which allows multiple contacts per TradeParty | 
| 94541cf | 2022-03-05 09:21:44 CET | HorstOeko | TradeContact Handling | 
| 7442316 | 2022-03-04 20:45:43 CET | HorstOeko | Code optimization in Document Pdf Builder | 
| 7815f90 | 2022-03-04 20:45:43 CET | HorstOeko | Code optimization in Document Pdf Builder | 
| d36f713 | 2022-03-04 18:34:47 CET | HorstOeko | Removed changes | 
| 117049d | 2022-03-04 18:07:37 CET | HorstOeko | Initial Commit for ZUGFeRD 2.2 and Factur-X 1.0.06 | 
| e1b6ba4 | 2022-03-04 15:24:49 CET | HorstOeko | Reset Counters for position-subinformation on firstDocumentPosition and nextDocumentPosition | 
| 6ccdfe5 | 2022-03-04 12:53:14 CET | HorstOeko | genclasses Script for WIndows | 
| 23be2d3 | 2022-03-04 12:06:30 CET | HorstOeko | Fixed Directory Separator in Test | 
| ba986c7 | 2022-02-20 11:08:16 CET | HorstOeko | Added workflows/build.ant.yml | 
| ab76c49 | 2022-02-20 11:01:24 CET | HorstOeko | Added workflows/build.ant.yml | 

:exclamation: _There are 13 internal commit(s)_

## v1.0.7

``Previous version v1.0.6``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 066c308 | 2022-02-20 10:05:06 CET | HorstOeko | Fix test code (BuilderEn16931Test) | 
| 66fbbe8 | 2022-02-20 09:05:43 CET | HorstOeko | Added profile XRechnung 2.1 and XRechnung 2.2 | 
| d6f2738 | 2022-02-19 16:30:57 CET | HorstOeko | Fix codelists | 
| 17c380f | 2022-02-19 16:30:21 CET | HorstOeko | Fixed method names | 

:exclamation: _There are 7 internal commit(s)_

## v1.0.6

``Previous version v1.0.5``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| f87212e | 2021-01-07 17:05:36 CET | HorstOeko | Added three new methods to the builder for adding quick payment means for SEPA Direct Debit, SEPA Credit Transfer and Payment Card | 
| cda68a9 | 2020-12-22 01:01:54 CET | HorstOeko | Some more test for empty value | 

:exclamation: _There are 4 internal commit(s)_

## v1.0.5

``Previous version v1.0.4``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 8421903 | 2020-12-12 11:26:31 CET | HorstOeko | Fix type hinting in PDFReader | 
| d7ef4d5 | 2020-12-10 09:30:21 CET | HorstOeko | Charge Indicator fixes | 
| b4995e9 | 2020-12-09 06:41:50 CET | HorstOeko | More PDF builder tests | 
| 65b8dd8 | 2020-12-08 17:44:34 CET | HorstOeko | Added simple test for pdf builder | 
| c5043bd | 2020-12-08 06:47:10 CET | HorstOeko | Added Test for the Basic Profile | 
| 5c55159 | 2020-12-07 06:15:56 CET | HorstOeko | Added more tests for BinaryAttachedObjects | 
| cdd0de9 | 2020-12-06 14:18:17 CET | HorstOeko | Added tests for AdditionalReferencedDocuments (binary data) | 
| 3c34218 | 2020-12-06 13:05:06 CET | HorstOeko | Using StringManagement package | 

:exclamation: _There are 8 internal commit(s)_

## v1.0.4

``Previous version v1.0.2``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 24f10df | 2020-12-05 11:50:11 CET | HorstOeko | Added mimetype restrictions for binary attached objects | 
| b530c10 | 2020-12-05 10:48:43 CET | HorstOeko | Removed validation from Reader -> looking for a better and more generic solutions | 
| 1191015 | 2020-12-05 10:42:38 CET | HorstOeko | Removed validation from Reader -> looking for a better and more generic solutions | 

:exclamation: _There are 2 internal commit(s)_

## v1.0.2

``Previous version v1.0.1``

| Hash    | Date    | Author  | Subject  | Issue(s)
| :------ | :------ | :------ | :------- | :-----------: 
| 066daba | 2020-12-03 17:01:16 CET | HorstOeko | Added XRechnung_2-Profile for XRechnung version 2.0, Added examples for XRechnung 2.0 | 
| fc9d629 | 2020-12-03 06:36:53 CET | HorstOeko | Switched profile of XRechnung back to 1.2 due errors | 
| d79f28c | 2020-12-03 06:24:19 CET | HorstOeko | Added schematron validation to ANT buildscript, Changed XRechnung Profile from 1.2 to 2.0 | 
| 8a26dbf | 2020-12-02 06:17:41 CET | HorstOeko | Added Quick-Descriptor for the Extended-Profile | 
| 69eaf2f | 2020-12-02 06:14:29 CET | HorstOeko | Added Quick-Descriptor for the Extended-Profile | 
| 928f917 | 2020-12-01 17:39:56 CET | HorstOeko | Added position note for the quick descriptor | 
| 6a3e50d | 2020-12-01 17:29:58 CET | HorstOeko | Added position note for the quick descriptor | 
| 0dc02e7 | 2020-12-01 17:07:58 CET | HorstOeko | Removed non-working schemaValidate for schematron -> replace by TODO | 

:exclamation: _There are 3 internal commit(s)_
