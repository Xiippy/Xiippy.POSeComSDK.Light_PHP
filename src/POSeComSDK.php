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
// - No secret or passwords or returnedObj must exist in the code when checked in
//
// *******************************************************************************************
    
namespace Xiippy\POSeComSDK\Light
{

    use Xiippy\POSeComSDK\Light\XiippySDKBridgeApiClient\Constants;
    use Xiippy\POSeComSDK\Light\XiippySDKBridgeApiClient;
    use Xiippy\POSeComSDK\Light\Models\PaymentProcessingRequest;
    use Xiippy\POSeComSDK\Light\Models\PaymentRecordCustomer;
    use Xiippy\POSeComSDK\Light\Models\IssuerStatementRecord;
    use Xiippy\POSeComSDK\Light\Models\PaymentRecordCustomerAddress;
    use Xiippy\POSeComSDK\Light\Models\StatementItem;

    use Xiippy\POSeComSDK\Light\Models\RefundCardPaymentRequest;
    use Xiippy\POSeComSDK\Light\Models\RefundCardPaymentResponse;

    define("XiippyReqSignatureHeader", "XIIPPY-API-SIG-V1");
    define("XiippyReqMomentHeader", "XIIPPY-MOMENT-V1");
    define("InitiateXiippyPaymentPath", "/api/PaymentsV1/InitiateXiippyPayment");
    define("RefundCardPaymentPath", "/api/PaymentsV1/RefundCardPayment");

    
    class POSeComSDK
    {
        public static function GUID()
        {
            if (function_exists('com_create_guid') === true)
            {
                return trim(com_create_guid(), '{}');
            }
            return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
        }


        public static function build_http_query( $query ){
            $query_array = array();
            foreach( $query as $key => $key_value ){
                $query_array[] = urlencode( $key ) . '=' . urlencode( $key_value );
            }
            return implode( '&', $query_array );
        }


      
    }
}
