<?php
require_once __DIR__ . '/../vendor/autoload.php';


use PHPUnit\Framework\TestCase;
use Xiippy\POSeComSDK\Light\XiippySDKBridgeApiClient;
use Xiippy\POSeComSDK\Light\Models\RefundCardPaymentRequest;
use Xiippy\POSeComSDK\Light\Models\GetPaymentStatusRequest;

class XiippySDKBridgeApiClientTest extends TestCase
{
    private $bridgeApiClient;

    protected function setUp(): void
    {
        $this->bridgeApiClient = new XiippySDKBridgeApiClient(
            true,                            // IsTest
            "TestApiKey",                    // BridgeAPIKey
            "https://localhost:19019",       // BridgeBaseUrl
            "TestMerchant123",               // MerchantID
            "TestGroup123"                   // MerchantGroupID
        );
    }

    // Test 1: Test ApplicationJson member
    public function testApplicationJsonProperty()
    {
        $reflectionClass = new ReflectionClass($this->bridgeApiClient);
        $property = $reflectionClass->getProperty('ApplicationJson');
        $property->setAccessible(true);

        $this->assertEquals(
            'application/json',
            $property->getValue($this->bridgeApiClient),
            'ApplicationJson property does not match expected value.'
        );
    }

    // Test 2: Test RefundCardPayment functionality
    public function testRefundCardPayment()
    {
        $mockRequest = new RefundCardPaymentRequest();
        $mockRequest->RandomStatementID = "TestStatement123";
        $mockRequest->StatementTimestamp = "2024-11-28T10:00:00Z";
        $mockRequest->MerchantGroupID = "TestGroup123";
        $mockRequest->MerchantID = "TestMerchant123";
        $mockRequest->AmountInDollars = 100.00;

        // Mocking the actual API call
        $this->bridgeApiClient = $this->getMockBuilder(XiippySDKBridgeApiClient::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['RefundCardPayment'])
            ->getMock();

        $mockResponse = $this->createMock(\Xiippy\POSeComSDK\Light\Models\RefundCardPaymentResponse::class);

        $this->bridgeApiClient->expects($this->once())
            ->method('RefundCardPayment')
            ->with($mockRequest)
            ->willReturn($mockResponse);

        $response = $this->bridgeApiClient->RefundCardPayment($mockRequest);

        $this->assertInstanceOf(
            \Xiippy\POSeComSDK\Light\Models\RefundCardPaymentResponse::class,
            $response,
            'RefundCardPayment did not return an instance of RefundCardPaymentResponse.'
        );
    }


    // Test 2: Test GetPaymentStatus functionality
    public function testGetPaymentStatus()
    {
        $mockRequest = new GetPaymentStatusRequest();
        $mockRequest->RandomStatementID = "b67ace18-564e-4189-bce7-56265d210934";
        $mockRequest->Timestamp = "20250117012122";
        $mockRequest->MerchantGroupID = "rg_bdffa371-be4b-41b4-a4de-e3d7b139605a";
        $mockRequest->MerchantID = "r_bdffa371-be4b-41b4-a4de-e3d7b139605a";
        

        // Mocking the actual API call
        $this->bridgeApiClient = $this->getMockBuilder(XiippySDKBridgeApiClient::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['GetPaymentStatus'])
            ->getMock();

        $mockResponse = $this->createMock(\Xiippy\POSeComSDK\Light\Models\GetPaymentStatusResponse::class);

        $this->bridgeApiClient->expects($this->once())
            ->method('GetPaymentStatus')
            ->with($mockRequest)
            ->willReturn($mockResponse);

        $response = $this->bridgeApiClient->GetPaymentStatus($mockRequest);

        $this->assertInstanceOf(
            \Xiippy\POSeComSDK\Light\Models\GetPaymentStatusResponse::class,
            $response,
            'GetPaymentStatus did not return an instance of GetPaymentStatusResponse.'
        );
    }
}
