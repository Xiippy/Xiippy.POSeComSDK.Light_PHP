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


namespace Xiippy\POSeComSDK\Light\Models {
    require_once 'XiippyRefund.php';

    use Xiippy\POSeComSDK\Light\Models\XiippyRefund;

    class RefundCardPaymentResponse
    {
        public $Refund;

        public function __construct($Refund = null)
        {
            if ($Refund instanceof XiippyRefund || $Refund === null) {
                $this->Refund = $Refund;
            } else {
                throw new \InvalidArgumentException("Refund must be an instance of XiippyRefund or null.");
            }
        }
    }
}
?>