<?php

if (! function_exists('convertCurrency')) {
    function convertCurrency($amount, $from_currency, $to_currency)
    {
        $url = "https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json";
        $exchange_rates = file_get_contents($url);
        $exchange_rates = json_decode($exchange_rates, true);

        $rate = findExchangeRate($exchange_rates, $from_currency, $to_currency);

        if ($rate === null) {
            return null; // Return null if the conversion rate is not found
        }

        $converted_amount = $amount * $rate;

        return $converted_amount;
    }

    function findExchangeRate($exchange_rates, $from_currency, $to_currency)
    {
        foreach ($exchange_rates as $rate) {
            if ($rate['cc'] === $from_currency && $rate['cc'] !== $to_currency) {
                return $rate['rate'];
            }
        }

        return null;
    }
}
