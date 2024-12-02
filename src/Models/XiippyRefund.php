<?php
// *******************************************************************************************
// Copyright © 2019 Xiippy.ai. All rights reserved. Australian patents awarded. PCT patent pending.
//
// NOTES:
//
// - No payment gateway SDK function is consumed directly. Interfaces are defined out of such interactions and then the interface is implemented for payment gateways. Design the interface with the most common members and data structures between different gateways. 
// - A proper factory or provider must instantiate an instance of the interface that is interacted with.
// - Any major change made to SDKs should begin with the c sharp SDK with the mindset to keep the high-level syntax, structures and class names the same to minimise porting efforts to other languages. Do not use language specific features that do not exist in other languages. We are not in the business of doing the same thing from scratch multiple times in different forms.
// - Pascal Case for naming conventions should be used for all languages
// - No secret or passwords or keys must exist in the code when checked in
//
// *******************************************************************************************



namespace Xiippy\POSeComSDK\Light\Models;

class XiippyRefund
{
    public $XiippyPaymentContextID;
    public $XiippyPaymentChargeID;
    public $Id;
    public $Object;
    public $Amount;
    public $BalanceTransaction;
    public $Charge;
    public $Created;
    public $Currency;
    public $Metadata;
    public $PaymentIntent;
    public $Reason;
    public $ReceiptNumber;
    public $SourceTransferReversal;
    public $Status;
    public $TransferReversal;

    public function __construct(
        $XiippyPaymentContextID = null,
        $XiippyPaymentChargeID = null,
        $Id = null,
        $Object = null,
        $Amount = null,
        $BalanceTransaction = null,
        $Charge = null,
        $Created = null,
        $Currency = null,
        $Metadata = [],
        $PaymentIntent = null,
        $Reason = null,
        $ReceiptNumber = null,
        $SourceTransferReversal = null,
        $Status = null,
        $TransferReversal = null
    ) {
        $this->XiippyPaymentContextID = $XiippyPaymentContextID;
        $this->XiippyPaymentChargeID = $XiippyPaymentChargeID;
        $this->Id = $Id;
        $this->Object = $Object;
        $this->Amount = $Amount;
        $this->BalanceTransaction = $BalanceTransaction;
        $this->Charge = $Charge;
        $this->Created = $Created instanceof \DateTime ? $Created : ($Created ? new \DateTime($Created) : null);
        $this->Currency = $Currency;
        $this->Metadata = is_array($Metadata) ? $Metadata : [];
        $this->PaymentIntent = $PaymentIntent;
        $this->Reason = $Reason;
        $this->ReceiptNumber = $ReceiptNumber;
        $this->SourceTransferReversal = $SourceTransferReversal;
        $this->Status = $Status;
        $this->TransferReversal = $TransferReversal;
    }
}
