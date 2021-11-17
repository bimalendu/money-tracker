<?php
    if(!function_exists('format_money')){
        function format_money($amount){
            $currency = "INR";
            $currency_fmt= new \NumberFormatter("en", \NumberFormatter::CURRENCY);
            return $currency_fmt->formatCurrency($amount, $currency);      
        }
    }
?>