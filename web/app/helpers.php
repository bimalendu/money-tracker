<?php
    if(!function_exists('format_money')){
        function getCurrencyFmt($currency="INR"){
            $currency_fmt= new \NumberFormatter("en-US@currency=$currency", \NumberFormatter::CURRENCY);
            return $currency_fmt;
        }
        function format_money($amount,$currency="INR"){
            $currency_fmt = getCurrencyFmt();
            $amount = floatval($amount);
            return $currency_fmt->formatCurrency($amount, $currency);      
        }

        function currency_symbol(){
            $currency_fmt = getCurrencyFmt();
            return $currency_fmt->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
        }
    }
?>