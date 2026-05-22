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

class XiippyReadMethod {
    public const ContactlessEmv = 'ContactlessEmv';
    public const ContactlessMagstripeMode = 'ContactlessMagstripeMode';
    public const ContactEmv = 'ContactEmv';
    public const MagneticStripeFallback = 'MagneticStripeFallback';
    public const MagneticStripeTrack2 = 'MagneticStripeTrack2';

    public static function isValid(string $value): bool
    {
        static $values = null;
        if ($values === null) {
            $values = [
                self::ContactlessEmv,
                self::ContactlessMagstripeMode,
                self::ContactEmv,
                self::MagneticStripeFallback,
                self::MagneticStripeTrack2,
            ];
        }
        return in_array($value, $values, true);
    }
}

class XiippySwipeReason {
    public const ChipError = 'ChipError';
    public const EmptyCandidateList = 'EmptyCandidateList';

    public static function isValid(string $value): bool
    {
        return in_array($value, [self::ChipError, self::EmptyCandidateList], true);
    }
}

class XiippyPaymentMethodData {
    public string $Cryptogram;
    public string $EncryptedTrack2;
    public bool $IsInterac;
    public string $Ksn;
    public string $ReadMethod;
    public string $SwipeReason;
    public string $Tlv;
    public string $Track2;

    public function __construct(
        string $Cryptogram,
        string $EncryptedTrack2,
        bool $IsInterac,
        string $Ksn,
        string $ReadMethod,
        string $SwipeReason,
        string $Tlv,
        string $Track2
    ) {
        if (!XiippyReadMethod::isValid($ReadMethod)) {
            throw new \InvalidArgumentException("Invalid ReadMethod: {$ReadMethod}");
        }
        if (!XiippySwipeReason::isValid($SwipeReason)) {
            throw new \InvalidArgumentException("Invalid SwipeReason: {$SwipeReason}");
        }

        $this->Cryptogram = $Cryptogram;
        $this->EncryptedTrack2 = $EncryptedTrack2;
        $this->IsInterac = $IsInterac;
        $this->Ksn = $Ksn;
        $this->ReadMethod = $ReadMethod;
        $this->SwipeReason = $SwipeReason;
        $this->Tlv = $Tlv;
        $this->Track2 = $Track2;
    }
}
