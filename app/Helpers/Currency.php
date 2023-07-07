<?php

if (! function_exists('convertCurrency')) {
    function convertCurrency($amount, $from_currency, $to_currency)
    {
        $url = "https://api.exchangerate-api.com/v4/latest/$from_currency";
        $exchange_rates = file_get_contents($url);
        $exchange_rates = json_decode($exchange_rates, true);

        $rate = $exchange_rates['rates'][$to_currency];

        $converted_amount = $amount * $rate;

        return $converted_amount;
    }
}
