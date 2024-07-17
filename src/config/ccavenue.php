<?php
return [
    "merchant_id" => env("CCAVENUE_MERCHANT_ID", ""),
    "access_code" => env("CCAVENUE_ACCESS_CODE", ""),
    "working_key" => env("CCAVENUE_WORKING_KEY", ""),
    "redirect_url" => env("CCAVENUE_REDIRECT_URL", ""),
    "cancel_url" => env("CCAVENUE_CANCEL_URL", ""),
    "language" => env("CCAVENUE_LANGUAGE", "EN"),
    "currency" => env("CCAVENUE_CURRENCY", "INR"),
    "environment" => env("CCAVENUE_ENVIRONMENT", "sandbox"),
];
