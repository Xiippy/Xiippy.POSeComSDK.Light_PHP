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

    class ElectronicPaymentPersisted
    {

        public INT $ElectronicPaymentID ;

        public string $RandomStatementID ;


        public string $Bank  = "";



        public string $MerchantAccountOwnerDetail = "";



        public string $Terminal = "";



        public string $Reference = "";



        public string $CardNO = "";



        public string $AccountType = "";



        public string $CardExpiry = "";



        public string $Aid = "";



        public string $Atc = "";



        public string $Tvr = "";



        public string $Csn = "";



        public string $AuthNo = "";



        public string $PosRefNo = "";



        public string $MAccountNumber = "";



        public string $Mrrn = "";



        public string $Mauth = "";



        public string $PaymentType = "";



        public string $MLocationCode = "";



        public string $MAccountType = "";



        public string $Apsn = "";



        public string $Arqc = "";



        public string $CurrencyCode = "";



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


        public float $Purchase ;


        public float $Total ;



        public string $TransactionType = "";



        public string $StatusId = "";



        public string $TxnStatusId = "";



        public string $Complete = "";



        public string $StatementText = "";


        public bool $ApprovedFlag ;



        public string $ExpectedSettlementDate = "";



        public string $ExpectedSettlementDateTimeZone = "";



        public string $DateOfTransaction = "";



        public string $DateOfTransactionTimeZone = "";


        public string $Stan = "";



        public string $DpsBillingId = "";



        public string $ResponseCode = "";



        public string $ResponseText = "";


        public float $AmtSurcgarge ;


        public float $AmtTip ;


        public float $AmtCashOut ;



        public string $CardType = "";


        public array $MetaDataExtras ;
        public string $Tsi ;
        public string $DedicatedFileName ;
        public string $Cvm ;
        public string $AuthorizationCode ;
        public string $ApplicationPreferredName ;
    }
}
?>