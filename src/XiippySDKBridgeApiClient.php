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
namespace Xiippy\POSeComSDK\Light {
    require_once __DIR__ . '/Utils\XiippySigv1Util.php';
    require_once __DIR__ . '/Models\PaymentProcessingRequest.php';
    require_once __DIR__ . '/Models\PaymentProcessingResponse.php';
    require_once __DIR__ . '/Models\RefundCardPaymentRequest.php';
    require_once __DIR__ . '/Models\RefundCardPaymentResponse.php';
    require_once __DIR__ .'/XiippySDKBridgeApiClient/Constants.php';

    use Exception;
    use Xiippy\POSeComSDK\Light\Models\PaymentProcessingRequest;
    use Xiippy\POSeComSDK\Light\Utils\XiippySigv1Util;
    use Xiippy\POSeComSDK\Light\Models\PaymentProcessingResponse;
    use Xiippy\POSeComSDK\Light\Models\RefundCardPaymentRequest;
    use Xiippy\POSeComSDK\Light\Models\RefundCardPaymentResponse;
    use Xiippy\POSeComSDK\Light\XiippySDKBridgeApiClient\Constants;

    class XiippySDKBridgeApiClient
    {
        public string $XiippyReqSignatureHeader = "XIIPPY-API-SIG-V1";
        public string $XiippyReqMomentHeader = "XIIPPY-MOMENT-V1";


        private string $ApplicationJson = "application/json";
        private string $BridgeBaseUrl = "https://localhost:19019";
        private bool $IsTest;
        private string $BridgeAPIKey;
        private string $MerchantID;
        private string $MerchantGroupID;

        public function __construct(bool $_IsTest, string $_BridgeAPIKey, string $_BridgeBaseUrl, string $_MerchantID, string $_MerchantGroupID)
        {
            $this->BridgeAPIKey = $_BridgeAPIKey;
            $this->BridgeBaseUrl = $_BridgeBaseUrl;
            $this->IsTest = $_IsTest;
            $this->MerchantID = $_MerchantID;
            $this->MerchantGroupID = $_MerchantGroupID;

        }



        public function InitiateXiippyPayment(PaymentProcessingRequest $req): PaymentProcessingResponse
        {
            $httpContent = json_encode($req);
            $opts = array(
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_HTTPHEADER => XiippySigv1Util::AddXiippyV1RequestSignatureToClient($httpContent, $this->BridgeAPIKey),
                CURLOPT_POSTFIELDS => mb_convert_encoding($httpContent,"UTF-8")
            );

            $ch = curl_init($this->BridgeBaseUrl . Constants::$InitiateXiippyPaymentPath);
            curl_setopt_array($ch, $opts);
            $response = curl_exec($ch);

            // Check for cURL errors
            if ($response === false) {
                $error_msg = curl_error($ch);
                // Log the error message or handle it accordingly
                //echo "cURL Error: " . $error_msg;
                throw new Exception("cURL Error: " . $error_msg);
            } else {
                // Check HTTP status code
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($http_status != 200) {
                    // Handle non-200 HTTP status codes
                    //echo "HTTP Status Code: " . $http_status;
                    throw new Exception($response. " HTTP Status Code: " . $http_status);
                } else {
                    // Process the response
                    // echo "Response: " . $response;

                    $data = json_decode($response, true);

                    // this may require automapper instead!
                    $returnedObj = new PaymentProcessingResponse();
                    foreach ($data as $key => $value)
                        if (isset($value))
                            $returnedObj->{$key} = $value;

                    return $returnedObj;

                }
            }

            // Close the cURL session
            curl_close($ch);

            return null;
        }



        public function RefundCardPayment(RefundCardPaymentRequest $req)
        {
            // Serialize request object to JSON
            $resInStr = json_encode($req, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    
            // Prepare cURL options
            $opts = array(
                CURLOPT_URL => $this->BridgeBaseUrl . Constants::$RefundCardPaymentPath,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => array_merge(
                    XiippySigv1Util::AddXiippyV1RequestSignatureToClient($resInStr, $this->BridgeAPIKey),
                    [
                        "Accept: application/json",
                        "Content-Type: application/json"
                    ]
                ),
                CURLOPT_POSTFIELDS => $resInStr,
                CURLOPT_SSL_VERIFYPEER => false, // Disable SSL verification for testing (set to true in production)
            );
    
            // Initialize cURL session
            $ch = curl_init();
            curl_setopt_array($ch, $opts);
            $response = curl_exec($ch);
    
            // Check for cURL errors
            if ($response === false) {
                $error_msg = curl_error($ch);
                curl_close($ch);
                throw new Exception("cURL Error: " . $error_msg);
            }
    
            // Check HTTP status code
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
    
            if ($http_status !== 200) {
                throw new Exception("HTTP Status Code: {$http_status} Body: {$response}");
            }
    
            // Deserialize JSON response into RefundCardPaymentResponse
            $data = json_decode($response, true);
            if ($data === null) {
                throw new Exception("Failed to decode response: {$response}");
            }
    
            $returnedObj = new RefundCardPaymentResponse();
            foreach ($data as $key => $value) {
                if (isset($value)) {
                    $returnedObj->{$key} = $value;
                }
            }
    
            return $returnedObj;
        }

    }
}