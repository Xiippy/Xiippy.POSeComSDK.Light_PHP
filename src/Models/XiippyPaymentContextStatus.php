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

class XiippyPaymentContextStatus
{
    private const CANCELED = 'Canceled';
    private const REQUIRES_CAPTURE = 'RequiresCapture';
    private const REQUIRES_CONFIRMATION = 'RequiresConfirmation';
    private const REQUIRES_PAYMENT_METHOD = 'RequiresPaymentMethod';
    private const SUCCEEDED = 'Succeeded';

    private static $instances = null;
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function Canceled(): self
    {
        return self::instance(self::CANCELED);
    }

    public static function RequiresCapture(): self
    {
        return self::instance(self::REQUIRES_CAPTURE);
    }

    public static function RequiresConfirmation(): self
    {
        return self::instance(self::REQUIRES_CONFIRMATION);
    }

    public static function RequiresPaymentMethod(): self
    {
        return self::instance(self::REQUIRES_PAYMENT_METHOD);
    }

    public static function Succeeded(): self
    {
        return self::instance(self::SUCCEEDED);
    }

    public static function values(): array
    {
        return [
            self::Canceled(),
            self::RequiresCapture(),
            self::RequiresConfirmation(),
            self::RequiresPaymentMethod(),
            self::Succeeded(),
        ];
    }

    public static function fromValue(string $value): self
    {
        foreach (self::values() as $status) {
            if ($status->getValue() === $value) {
                return $status;
            }
        }

        throw new \InvalidArgumentException("Invalid XiippyPaymentContextStatus value: {$value}");
    }

    public static function isValid(string $value): bool
    {
        foreach (self::values() as $status) {
            if ($status->getValue() === $value) {
                return true;
            }
        }

        return false;
    }

    private static function instance(string $value): self
    {
        if (self::$instances === null) {
            self::$instances = [];
        }

        if (!isset(self::$instances[$value])) {
            self::$instances[$value] = new self($value);
        }

        return self::$instances[$value];
    }
}
