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
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Xiippy\POSeComSDK\Light\XiippyTSSAPIClientBiz\XiippyTSSAPIClient;
use Xiippy\POSeComSDK\Light\Models\CardDetails;
use Xiippy\POSeComSDK\Light\Models\CardTypes;
use Xiippy\POSeComSDK\Light\Models\ValidatePayersCardDetailsRequest;
use Xiippy\POSeComSDK\Light\Models\ValidateMerchantsCardDetailsRequest;

class XiippyTSSAPIClientTests extends TestCase
{
    private $tssApiClient;
    private $baseUrl;
    private $clientId;
    private $privateAPIKey;

    protected function setUp(): void
    {
        putenv('TSSAPI_BASE_URL=https://apiv2.xiippy.ai/');  
        putenv('TSSAPI_CLIENT_ID=YourDeveloperID'); // get yours at https://developers.xiippy.ai/ aftrer creating an account and application
        putenv('TSSAPI_PRIVATE_API_KEY=YourPrivateAPIKey'); // get yours at https://developers.xiippy.ai/DeveloperApiKeys

        $this->baseUrl = (string) (getenv('TSSAPI_BASE_URL') ?: 'https://apiv2.xiippy.ai/');
        $this->clientId = (string) (getenv('TSSAPI_CLIENT_ID') ?: '');
        $privateKeyHex = (string) (getenv('TSSAPI_PRIVATE_API_KEY') ?: '');
        $this->privateAPIKey = $this->convertHexStringToBinary($privateKeyHex);

        if ($this->clientId === '' || $this->privateAPIKey === '') {
            $this->markTestSkipped('TSS API integration tests are skipped because TSSAPI_CLIENT_ID or TSSAPI_PRIVATE_API_KEY is not configured.');
        }

        $this->tssApiClient = new XiippyTSSAPIClient(
            $this->privateAPIKey,
            $this->baseUrl,
            $this->clientId
        );
    }

    private function convertHexStringToBinary($hex)
    {
        $trimmed = trim((string) $hex);
        if ($trimmed === '') {
            return '';
        }

        if (strlen($trimmed) % 2 !== 0 || !ctype_xdigit($trimmed)) {
            throw new InvalidArgumentException('Hex string must be an even-length hexadecimal string.');
        }

        $decoded = hex2bin($trimmed);
        if ($decoded === false) {
            throw new RuntimeException('Unable to decode hex string to binary.');
        }

        return $decoded;
    }

    public function testValidatePayersCardDetailsWithValidCardDetailsReturnsSuccessResponse()
    {
        $cardDetails = new CardDetails();
        $cardDetails->CardNumber = 'Your Valid Card Number';
        $cardDetails->CardExpiryMonth = 11;
        $cardDetails->CardExpiryYear = 2028;
        $cardDetails->CardType = CardTypes::TSSVIC;

        $request = new ValidatePayersCardDetailsRequest();
        $request->CardDetails = $cardDetails;
        $request->AmountIntendedToCharge = 20.0;

        $response = $this->tssApiClient->ValidatePayersCardDetails($request);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('CardDetails', $response);
        $this->assertEquals($cardDetails->CardNumber, $response['CardDetails']['CardNumber']);
        $this->assertEquals(CardTypes::TSSVIC, $response['CardDetails']['CardType']);
    }

    public function testValidateMerchantsCardDetailsWithValidCardDetailsReturnsSuccessResponse()
    {
        $cardDetails = new CardDetails();
        $cardDetails->CardNumber = 'Your Valid Card Number';
        $cardDetails->CardExpiryMonth = 5;
        $cardDetails->CardExpiryYear = 2027;
        $cardDetails->CardType = CardTypes::TSSVIC;

        $request = new ValidateMerchantsCardDetailsRequest();
        $request->CardDetails = $cardDetails;

        $response = $this->tssApiClient->ValidateMerchantsCardDetails($request);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('CardDetails', $response);
        $this->assertEquals($cardDetails->CardNumber, $response['CardDetails']['CardNumber']);
        $this->assertEquals(CardTypes::TSSVIC, $response['CardDetails']['CardType']);
    }

    public function testValidatePayersCardDetailsWithInvalidCardNumberThrowsException()
    {
        $this->expectException(Exception::class);

        $cardDetails = new CardDetails();
        $cardDetails->CardNumber = '111111111111111111';
        $cardDetails->CardExpiryMonth = 11;
        $cardDetails->CardExpiryYear = 2028;
        $cardDetails->CardType = CardTypes::TSSVIC;

        $request = new ValidatePayersCardDetailsRequest();
        $request->CardDetails = $cardDetails;
        $request->AmountIntendedToCharge = 20.0;

        $this->tssApiClient->ValidatePayersCardDetails($request);
    }

    public function testValidateMerchantsCardDetailsWithInvalidCardNumberThrowsException()
    {
        $this->expectException(Exception::class);

        $cardDetails = new CardDetails();
        $cardDetails->CardNumber = '111111111111111111';
        $cardDetails->CardExpiryMonth = 11;
        $cardDetails->CardExpiryYear = 2028;
        $cardDetails->CardType = CardTypes::TSSVIC;

        $request = new ValidateMerchantsCardDetailsRequest();
        $request->CardDetails = $cardDetails;

        $this->tssApiClient->ValidateMerchantsCardDetails($request);
    }

    public function testValidatePayersCardDetailsWithExpiredCardThrowsException()
    {
        $this->expectException(Exception::class);

        $cardDetails = new CardDetails();
        $cardDetails->CardNumber = 'Your Valid Card Number';
        $cardDetails->CardExpiryMonth = 11;
        $cardDetails->CardExpiryYear = 2020;
        $cardDetails->CardType = CardTypes::TSSVIC;

        $request = new ValidatePayersCardDetailsRequest();
        $request->CardDetails = $cardDetails;
        $request->AmountIntendedToCharge = 20.0;

        $this->tssApiClient->ValidatePayersCardDetails($request);
    }

    public function testValidateMerchantsCardDetailsWithExpiredCardThrowsException()
    {
        $this->expectException(Exception::class);

        $cardDetails = new CardDetails();
        $cardDetails->CardNumber = 'Your Valid Card Number';
        $cardDetails->CardExpiryMonth = 11;
        $cardDetails->CardExpiryYear = 2020;
        $cardDetails->CardType = CardTypes::TSSVIC;

        $request = new ValidateMerchantsCardDetailsRequest();
        $request->CardDetails = $cardDetails;

        $this->tssApiClient->ValidateMerchantsCardDetails($request);
    }

    public function testValidatePayersCardDetailsOnApiErrorThrowsExceptionWithStatusCode()
    {
        $cardDetails = new CardDetails();
        $cardDetails->CardNumber = '000000000000000000';
        $cardDetails->CardExpiryMonth = 13;
        $cardDetails->CardExpiryYear = 2028;
        $cardDetails->CardType = CardTypes::TSSVIC;

        $request = new ValidatePayersCardDetailsRequest();
        $request->CardDetails = $cardDetails;
        $request->AmountIntendedToCharge = 20.0;

        try {
            $this->tssApiClient->ValidatePayersCardDetails($request);
            $this->fail('Expected exception was not thrown.');
        } catch (Exception $exception) {
            $this->assertStringContainsString('Response Code:', $exception->getMessage());
        }
    }
}
