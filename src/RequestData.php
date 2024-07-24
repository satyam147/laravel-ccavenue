<?php

namespace Satyam147\LaravelCcavenue;

class RequestData
{
    public ?string $card_name = "NA";
    public ?string $billing_address = "NA";
    public ?string $billing_city = "NA";
    public ?string $billing_zip = "NA";
    public string $order_id;
    public int $amount;
    public string $redirect_url;
    public string $cancel_url;
}
