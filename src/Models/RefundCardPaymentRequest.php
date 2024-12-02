<?php
namespace Xiippy\POSeComSDK\Light\Models {
    class RefundCardPaymentRequest
    {
        public $RandomStatementID;
        public $StatementTimestamp;
        public $MerchantGroupID;
        public $MerchantID;
        public $AmountInDollars;

        // public function __construct($RandomStatementID, $StatementTimestamp, $MerchantGroupID, $MerchantID, $AmountInDollars = null)
        // {
        //     if (empty($RandomStatementID)) {
        //         throw new \InvalidArgumentException('RandomStatementID is required.');
        //     }
        //     if (empty($StatementTimestamp)) {
        //         throw new \InvalidArgumentException('StatementTimestamp is required.');
        //     }
        //     if (empty($MerchantGroupID)) {
        //         throw new \InvalidArgumentException('MerchantGroupID is required.');
        //     }
        //     if (empty($MerchantID)) {
        //         throw new \InvalidArgumentException('MerchantID is required.');
        //     }

        //     $this->RandomStatementID = $RandomStatementID;
        //     $this->StatementTimestamp = $StatementTimestamp;
        //     $this->MerchantGroupID = $MerchantGroupID;
        //     $this->MerchantID = $MerchantID;
        //     $this->AmountInDollars = $AmountInDollars;
        // }
    }
}
?>