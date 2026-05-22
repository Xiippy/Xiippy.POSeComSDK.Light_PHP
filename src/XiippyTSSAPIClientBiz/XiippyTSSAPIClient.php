<?php
namespace Xiippy\POSeComSDK\Light\XiippyTSSAPIClientBiz;

use Xiippy\POSeComSDK\Light\Utils\XiippySigv2Util;

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

class XiippyTSSAPIClient
{
    public const XiippyReqSignatureHeader = 'client-request-signature';
    public const XiippyReqMomentHeader = 'request-moment';
    public const XiippyReqClientID = 'client-id';

    private const ApplicationJson = 'application/json';
    private const ValidatePayersCardDetailsPath = 'api/TSS/ValidatePayersCardDetails';
    private const ValidateMerchantsCardDetailsPath = 'api/TSS/ValidateMerchantsCardDetails';

    private $bridgeBaseUrl;
    private $privateED25519APIKey;
    private $clientId;

    public function __construct($privateED25519APIKey, $bridgeBaseUrl, $clientId)
    {
        $this->privateED25519APIKey = $this->normalizePrivateKey($privateED25519APIKey);
        $this->bridgeBaseUrl = rtrim($bridgeBaseUrl, '/');
        $this->clientId = $clientId;
    }

    public function ValidatePayersCardDetails($req)
    {
        return $this->sendRequest(self::ValidatePayersCardDetailsPath, $req);
    }

    public function ValidateMerchantsCardDetails($req)
    {
        return $this->sendRequest(self::ValidateMerchantsCardDetailsPath, $req);
    }

    private function sendRequest($path, $req)
    {
        $jsonContent = json_encode($req, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if ($jsonContent === false) {
            throw new \RuntimeException('Unable to serialize request: ' . json_last_error_msg());
        }

        $signatureHeaders = XiippySigv2Util::AddXiippyV2RequestSignatureToClient($jsonContent, $this->clientId, $this->privateED25519APIKey);

        $headers = [
            'Content-Type: ' . self::ApplicationJson,
            'Accept: ' . self::ApplicationJson,
        ];

        foreach ($signatureHeaders as $name => $value) {
            $headers[] = $name . ': ' . $value;
        }

        $url = $this->bridgeBaseUrl . '/' . ltrim($path, '/');

        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_POSTFIELDS =>  mb_convert_encoding($jsonContent,"UTF-8") ,
            CURLOPT_HTTPHEADER => $headers,
             CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => 1,
                CURLOPT_RETURNTRANSFER => 1,
        ]);

        $response = curl_exec($curl);
        if ($response === false) {
            $errorMessage = curl_error($curl);
            curl_close($curl);
            throw new \RuntimeException('HTTP request failed: ' . $errorMessage);
        }

        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($statusCode !== 200) {
            throw new \RuntimeException('Response Code: ' . $statusCode . ' Body: ' . $response);
        }

        $decoded = json_decode($response, true);
        if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Unable to decode response JSON: ' . json_last_error_msg());
        }

        return $decoded;
    }

    private function normalizePrivateKey($privateKey)
    {
        if (is_string($privateKey)) {
            $trimmed = trim($privateKey);
            if (ctype_xdigit($trimmed) && (strlen($trimmed) === 64 || strlen($trimmed) === 128)) {
                $decoded = hex2bin($trimmed);
                if ($decoded !== false) {
                    return $decoded;
                }
            }
        }

        return $privateKey;
    }
}
