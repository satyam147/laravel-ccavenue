<?php

namespace Satyam147\LaravelCcavenue;

use Satyam147\LaravelCcavenue\Utils\Crypto;

class CcAvenue
{
    private $productionUrl = 'https://secure.ccavenue.com';
    private $sandboxUrl = 'https://test.ccavenue.com';
    private RequestData $paymentData;
    public function __construct(RequestData $paymentData)
    {
        $this->paymentData = $paymentData;
    }

    private function getUrl() : string
    {
        return config('ccavenue.environment') === 'sandbox' ? $this->sandboxUrl : $this->productionUrl;
    }

    private function encryptRequestData() : string
    {
        $data = '';
        foreach ($this->paymentData as $key => $value) {
            $data .= $key . '=' . $value . '&';
        }
        $data.= 'merchant_id' . '=' . config('ccavenue.merchant_id') . '&';
        $data.= 'language' . '=' . config('ccavenue.language') . '&';
        $data.= 'currency' . '=' . config('ccavenue.currency') . '&';
        $data.= 'integration_type=iframe_normal';

        return Crypto::encrypt($data, config('ccavenue.working_key'));
    }


    public function generatePaymentLink() : string
    {
        $link = $this->getUrl() . '/transaction/transaction.do';
        $link .= '?command=initiateTransaction';
        $link .= '&encRequest=' . $this->encryptRequestData();
        $link .= '&access_code=' . config('ccavenue.access_code');
        return $link;
    }
}
