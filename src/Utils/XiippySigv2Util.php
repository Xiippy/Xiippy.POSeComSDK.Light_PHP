<?php
namespace Xiippy\POSeComSDK\Light\Utils;

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

class XiippySigv2Util
{
    public const XIIPPY_REQ_SIGNATURE_HEADER = 'client-request-signature';
    public const XIIPPY_REQ_MOMENT_HEADER = 'request-moment';
    public const XIIPPY_REQ_CLIENT_ID_HEADER = 'client-id';

    /**
     * Builds the headers required for a Xiippy V2 signed request.
     *
     * @param string $jsonContent
     * @param string $clientId
     * @param string $privateKey
     * @return array<string,string>
     */
    public static function AddXiippyV2RequestSignatureToClient($jsonContent, $clientId, $privateKey)
    {
        $requestMoment = (string) round(microtime(true) * 1000);
        $signature = RequestSignatureHandlerClientSide::GenerateSignatureForRequest($jsonContent, $requestMoment, $privateKey);
        $signatureHex = strtolower(bin2hex($signature));

        return [
            self::XIIPPY_REQ_CLIENT_ID_HEADER => $clientId,
            self::XIIPPY_REQ_MOMENT_HEADER => $requestMoment,
            self::XIIPPY_REQ_SIGNATURE_HEADER => $signatureHex,
        ];
    }
}
