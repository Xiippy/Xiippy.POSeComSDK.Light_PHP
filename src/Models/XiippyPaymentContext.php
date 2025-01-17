<?php
/**
 * Copyright © 2019 Xiippy.ai. All rights reserved. Australian patents awarded. PCT patent pending.
 *
 * NOTES:
 *
 * - No payment gateway SDK function is consumed directly. Interfaces are defined out of such interactions and then the interface is implemented for payment gateways. Design the interface with the most common members and data structures between different gateways. 
 * - A proper factory or provider must instantiate an instance of the interface that is interacted with.
 * - Any major change made to SDKs should begin with the c sharp SDK with the mindset to keep the high-level syntax, structures and class names the same to minimise porting efforts to other languages. Do not use language specific features that do not exist in other languages. We are not in the business of doing the same thing from scratch multiple times in different forms.
 * - Pascal Case for naming conventions should be used for all languages
 * - No secret or passwords or keys must exist in the code when checked in
 */

namespace Xiippy\POSeComSDK\Light\Models;

class XiippyPaymentContext
{
    // MW region
    public $MWTransactionID;

    // Main properties
    public $Currency;
    public $Amount;
    public $AmountCapturable;
    public $AmountReceived;
    public $Application;
    public $ApplicationFeeAmount;
    public $CanceledAt;
    public $CancellationReason;
    public $CaptureMethod;
    public $Charges;  // Array of XiippyCharge objects
    public $ClientSecret;
    public $ConfirmationMethod;
    public $Created;
    public $TransferGroup;
    public $Description;
    public $Id;
    public $Invoice;
    public $LastPaymentError;  // XiippyApiError object
    public $Livemode;
    public $Metadata;  // Array (equivalent to Dictionary<string, string>)
    public $OnBehalfOf;
    public $PaymentMethodData;  // XiippyPaymentMethodData object
    public $PaymentMethodId;
    public $ReceiptEmail;
    public $Review;
    public $StatementDescriptor;
    public $Status;  // XiippyPaymentContextStatus value
    public $Customer;

    // Server-side region
    public $Object;
    public $ReviewId;
    public $SetupFutureUsage;
    public $SourceId;
    public $PaymentMethodTypes;  // Array of strings
    public $StatementDescriptorSuffix;
    public $CustomerId;
    public $OnBehalfOfId;
    public $ApplicationId;
    public $InvoiceId;
    public $_OriginalJason;

    public function __construct() 
    {
        $this->Charges = [];
        $this->Metadata = [];
        $this->PaymentMethodTypes = [];
    }
}