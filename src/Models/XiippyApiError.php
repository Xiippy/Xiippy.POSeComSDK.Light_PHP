<?php
// *******************************************************************************************
// Copyright © 2019 Xiippy.ai. All rights reserved. Australian patents awarded. PCT patent pending.
//
// NOTES:
//
// - No payment gateway SDK function is consumed directly. Interfaces are defined out of such interactions and then the interface is implemented for payment gateways. Design the interface with the most common members and data structures between different gateways. 
// - A proper factory or provider must instantiate an instance of the interface that is interacted with.
// - Any major change made to SDKs should begin with the PHP SDK with the mindset to keep the high-level syntax, structures and class names the same to minimise porting efforts to other languages. Do not use language specific features that do not exist in other languages. We are not in the business of doing the same thing from scratch multiple times in different forms.
// - Pascal Case for naming conventions should be used for all languages
// - No secret or passwords or keys must exist in the code when checked in
//
// *******************************************************************************************

namespace Xiippy\POSeComSDK\Light\Models;

class XiippyApiErrorType
{
    public const ApiConnectionError = 'ApiConnectionError';
    public const ApiError = 'ApiError';
    public const AuthenticationError = 'AuthenticationError';
    public const CardError = 'CardError';
    public const IdempotencyError = 'IdempotencyError';
    public const InvalidRequestError = 'InvalidRequestError';
    public const RateLimitError = 'RateLimitError';

    public static function isValid(string $value): bool
    {
        static $values = null;
        if ($values === null) {
            $values = [
                self::ApiConnectionError,
                self::ApiError,
                self::AuthenticationError,
                self::CardError,
                self::IdempotencyError,
                self::InvalidRequestError,
                self::RateLimitError,
            ];
        }
        return in_array($value, $values, true);
    }
}

class XiippyApiError {
    public string $Charge;
    public string $Code;
    public string $DeclineCode;
    public string $DocUrl;
    public string $Message;
    public string $Param;
    public XiippyPaymentContext $PaymentIntent;
    public string $Type;

    // Server-side
    public string $PaymentMethodType;
    public string $Error;
    public string $ErrorDescription;

    public function __construct(
        string $Charge,
        string $Code,
        string $DeclineCode,
        string $DocUrl,
        string $Message,
        string $Param,
        XiippyPaymentContext $PaymentIntent,
        string $Type,
        string $PaymentMethodType,
        string $Error,
        string $ErrorDescription
    ) {
        if (!XiippyApiErrorType::isValid($Type)) {
            throw new \InvalidArgumentException("Invalid XiippyApiErrorType: {$Type}");
        }

        $this->Charge = $Charge;
        $this->Code = $Code;
        $this->DeclineCode = $DeclineCode;
        $this->DocUrl = $DocUrl;
        $this->Message = $Message;
        $this->Param = $Param;
        $this->PaymentIntent = $PaymentIntent;
        $this->Type = $Type;
        $this->PaymentMethodType = $PaymentMethodType;
        $this->Error = $Error;
        $this->ErrorDescription = $ErrorDescription;
    }
}
