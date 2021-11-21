<?php
    if(!function_exists('format_money')){
        function getCurrencyFmt($currency){
            $currency_fmt= new \NumberFormatter("en-US@currency=$currency", \NumberFormatter::CURRENCY);
            return $currency_fmt;
        }
        
        function format_money($amount){
            $currency= session('currency');
            $currency_fmt = getCurrencyFmt($currency);
            $amount = floatval($amount);

            return $currency_fmt->formatCurrency($amount, $currency);      
        }

        function currency_symbol(){
            $currency= session('currency');
            $currency_fmt = getCurrencyFmt($currency);
            return $currency_fmt->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
        }
    }
