<?php

namespace Satyam147\LaravelCcavenue;

use Satyam147\LaravelCcavenue\Utils\Crypto;

class CcAvenue
{
    private string $productionUrl = 'https://secure.ccavenue.com';
    private string $sandboxUrl = 'https://test.ccavenue.com';

    public function __construct(
        public RequestData $paymentData,
        public ?string     $merchantId = null,
        public ?string     $workingKey = null,
        public ?string     $accessCode = null
    ) {
    }

    private function getUrl(): string
    {
        return config('ccavenue.environment') === 'sandbox' ? $this->sandboxUrl : $this->productionUrl;
    }

    private function encryptRequestData(): string
    {
        $merchantId = $this->merchantId ?: config('ccavenue.merchant_id');
        $workingKey = $this->workingKey ?: config('ccavenue.working_key');
        $data = '';
        foreach ($this->paymentData as $key => $value) {
            $data .= $key . '=' . urlencode($value) . '&';
        }
        $data .= 'merchant_id' . '=' . urlencode($merchantId) . '&';
        $data .= 'language' . '=' . urlencode(config('ccavenue.language')) . '&';
        $data .= 'currency' . '=' . urlencode(config('ccavenue.currency')) . '&';
        $data .= 'integration_type=iframe_normal';

        return Crypto::encrypt($data, $workingKey);
    }

    public static function decryptResponse(string $encRes, ?string $workingKey = null,): array
    {
        $workingKey = $workingKey ?: config('ccavenue.working_key');
        $res = Crypto::decrypt($encRes, $workingKey);
        $data = [];
        foreach (explode('&', $res) as $pair) {
            [$key, $value] = explode('=', $pair);
            $data[$key] = urldecode($value);
        }
        return $data;
    }


    public function generatePaymentLink(): string
    {
        $accessCode = $this->accessCode ?: config('ccavenue.access_code');
        $link = $this->getUrl() . '/transaction/transaction.do';
        $link .= '?command=initiateTransaction';
        $link .= '&encRequest=' . $this->encryptRequestData();
        $link .= '&access_code=' . $accessCode;
        return $link;
    }
}
