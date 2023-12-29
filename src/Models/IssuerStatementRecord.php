<?php
/*******************************************************************************************
Copyright © 2019 Xiippy.ai. All rights reserved. Australian patents awarded. PCT patent pending.

NOTES:

- No payment gateway SDK function is consumed directly. Interfaces are defined out of such interactions and then the interface is implemented for payment gateways. Design the interface with the most common members and data structures between different gateways. 
A proper factory or provider must instantiate an instance of the interface that is interacted with.
- Any major change made to SDKs should begin with the c# SDK with the mindset to keep the high-level syntax, structures and class names the same to minimise porting efforts to other languages. Do not use language specific features that don't exist in other languages. We are not in the business of doing the same thing from scratch multiple times in different forms.
- Pascal Case for naming conventions should be used for all languages
- No secret or passwords or keys must exist in the code when checked in

*******************************************************************************************/

namespace Xiippy\POSeComSDK\Light\Models
{
    class IssuerStatementRecord
    {

        public string $RandomStatementID ;

        // optional nullable foreign key 
        /*         public long? PaymentProcessingRequestID ;
          public PaymentProcessingRequestPersisted PaymentProcessingRequest ;
         public PaymentNameAddressResponsePersisted PaymentNameAddressResponse ;

         public List<InitiatePaymentResponsePersisted> InitiatePaymentResponses ;
         public Shift? Sift ;*/


        public array $StatementItems ;
        public array $ElectronicPayments ;
        public array $CashPayments ;

        public array $TotalBillVariations ;



        // foreign key to the Shift table
        public string $ShiftID ;





        public string $StatementTimeStamp = "";

        #region IssuerStatementRecord


        public array $IssuersPrivateMetadata ;



        /*
                public string $IssuerDigitalSingatureKeyId ;

                public string $TransactionMarker ;  // set when saving the statement from the session state record
                public string $RecipientDigitalSignature ;
                public string $StatementTransferRequestSignature ;

                public string $IssuersDigitalSingatureInBase58AsSent ;

                /// <summary>
                /// The agreed upon encryption key used to encrypt the statement between issuer and recipient, needed for purchase proof validation
                /// </summary>
                public array $RecipientDigitalSignatureMACKey ;

                /// <summary>
                /// The EC key used by the recipient to receive the statement. Needed for purchase proof validation in future while other keys are disposed of.
                /// </summary>
                public array $PublicMessageTransferKey ;

                public string $POSMachineID ;
        */


        #endregion IssuerStatementRecord







        #region Statement


        // should be set internally by SDK when converting this into an internal type

        public int $ProtocolVersion ;


        // public uint StatementRecordVersion = 1;



        public string $ShortStatementID = "";





        // should be set internally by SDK when converting this into an internal type
        // public string $RetailerCognitoID = "";



        public string $StatementCreationDate = "";



        public string $StatementText = "";



        public string $Description = "";







        public string $PersonResponsible = "";



        public string $IssuerLogoUrl = "";



        public string $DetailsInHeader = "";


        public Float $TotalAmount ;


        public Float $TotalTaxAmount ;




        public string $DetailsInBodyBeforeItems = "";



        public string $DetailsInBodyAfterItems = "";



        public string $DetailsInFooter = "";



        public string $StatementIdentifier = "";



        public string $StatementIdentifier2 = "";



        public string $StatementIdentifier3 = "";





        public string $ExtraInfo1 = "";



        public string $ExtraInfo2 = "";



        public string $ExtraInfo3 = "";



        public string $ExtraInfo4 = "";



        public string $ExtraInfo5 = "";



        public string $ExtraInfo6 = "";



        public string $ExtraInfo7 = "";



        public string $ExtraInfo8 = "";



        public string $ExtraInfo9 = "";



        public string $ExtraInfo10 = "";


        public array $AttachmentPageTop ;



        public string $AttachmentPageTopMimeType = "";


        public array $AttachmentItemsTop ;



        public string $AttachmentItemsTopMimeType = "";


        public array $AttachmentItemsBottom ;



        public string $AttachmentItemsBottomMimeType = "";


        public array $AttachmentPageBottom ;



        public string $AttachmentPageBottomMimeType = "";


        public Float $TotalLoyaltyPoints ;


        public int $PaymentProcessingResult ;



        public string $PaymentProcessingMsg = "";



        public string $UniqueStatementID = "";



        public  PaymentNameAddressRequest $PaymentNameAddressRequestObject ;




        public string $RetailerGroupID = "";









        public array $MetaDataExtras ;




        // new fields
        // should be set internally by SDK when converting this into an internal type

        //public string $RetailerID ;


        /// <summary>
        /// Logical cluster ID for the issuer/merchant/payee/retailer (e.g. Shopping Centre 1), used to help identify a buyer for a Shopping Center in a privacy-preserving fashion
        /// </summary>
        // should be set internally by SDK when converting this into an internal type

        //public string $ClusterID1 ;
        /// <summary>
        /// Logical cluster ID2 for the issuer/merchant/payee/retailer (e.g. All super markets), used to help identify a buyer for a Shopping Center in a privacy-preserving fashion
        /// </summary>
        // should be set internally by SDK when converting this into an internal type

        //public string $ClusterID2 ;
        /// <summary>
        /// Logical cluster ID3 for the issuer/merchant/payee/retailer (e.g. Shopping Centre 2), used to help identify a buyer for a Shopping Center in a privacy-preserving fashion
        /// </summary>
        // should be set internally by SDK when converting this into an internal type

        //        public string $ClusterID3 ;
        /// <summary>
        /// Logical cluster ID4 for the issuer/merchant/payee/retailer (e.g. Shopping Centre 3), used to help identify a buyer for a Shopping Center in a privacy-preserving fashion
        /// </summary>
        // should be set internally by SDK when converting this into an internal type

        //public string $ClusterID4 ;
        /// <summary>
        /// Logical cluster ID5 for the issuer/merchant/payee/retailer (e.g. Shopping Centre 4), used to help identify a buyer for a Shopping Center in a privacy-preserving fashion
        /// </summary>
        // should be set internally by SDK when converting this into an internal type

        //public string $ClusterID5 ;
        // should be set internally by SDK when converting this into an internal type

        //public int LevelInHierarchy ;
        // should be set internally by SDK when converting this into an internal type

        //public string $RetailerSubgroupID ; // franchise or chain cognito id


        // should be set internally by SDK when converting this into an internal type

        //public string $RetailerCardID ;  // the retailer's private identifier of the cards    

        // should be set internally by SDK when converting this into an internal type

        //public string $RetailerNodeID ;  // the retailer's private identifier of the cards    


        // should be set internally by SDK when converting this into an internal type

        // public bool $IsTest ;




        #endregion Statement

    }




}
?>