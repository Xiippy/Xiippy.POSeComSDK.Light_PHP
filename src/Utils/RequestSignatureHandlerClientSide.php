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

class RequestSignatureHandlerClientSide
{
    /**
     * Generates a detached signature for an HTTP request by combining the request body and timestamp.
     *
     * @param string $body The request body
     * @param int|string $momentInMilliseconds The current time in milliseconds
     * @param string $privateKey The Ed25519 private key seed or secret key
     * @return string Raw signature bytes
     */
    public static function GenerateSignatureForRequest($body, $momentInMilliseconds, $privateKey)
    {
        $moment = (string) $momentInMilliseconds;
        $dataToSign = self::CombineBodyAndMoment($body, $moment);

        return self::SignDetached($dataToSign, $privateKey);
    }

    /**
     * Combines the request body and moment using the format: {body}#{moment}
     *
     * @param string $body
     * @param string $momentBytes
     * @return string
     */
    public static function CombineBodyAndMoment($body, $momentBytes)
    {
        return $body . '#' . $momentBytes;
    }

    /**
     * Signs the message with an Ed25519 private key.
     *
     * @param string $message
     * @param string $privateKey 32-byte seed or 64-byte secret key, optionally hex encoded
     * @return string Raw signature bytes
     */
    public static function SignDetached($message, $privateKey)
    {
        if (!function_exists('sodium_crypto_sign_detached')) {
            throw new \RuntimeException('The sodium extension is required for Ed25519 signing.');
        }

        $privateKey = self::NormalizePrivateKey($privateKey);

        if (strlen($privateKey) === 32) {
            if (!function_exists('sodium_crypto_sign_seed_keypair')) {
                throw new \RuntimeException('The sodium extension must support seed keypair generation.');
            }

            $keypair = sodium_crypto_sign_seed_keypair($privateKey);
            $secretKey = sodium_crypto_sign_secretkey($keypair);
            return sodium_crypto_sign_detached($message, $secretKey);
        }

        if (strlen($privateKey) === 64) {
            return sodium_crypto_sign_detached($message, $privateKey);
        }

        throw new \InvalidArgumentException('Private key must be a 32-byte seed or a 64-byte Ed25519 secret key.');
    }

    /**
     * Normalizes a private key by decoding it from hex when appropriate.
     *
     * @param string $privateKey
     * @return string
     */
    private static function NormalizePrivateKey($privateKey)
    {
        $trimmed = trim($privateKey);

        if (ctype_xdigit($trimmed) && (strlen($trimmed) === 64 || strlen($trimmed) === 128)) {
            $decoded = hex2bin($trimmed);
            if ($decoded !== false) {
                return $decoded;
            }
        }

        return $privateKey;
    }
}
