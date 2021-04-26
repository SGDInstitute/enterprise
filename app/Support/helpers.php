<?php

use function GuzzleHttp\json_encode;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

if (! function_exists('isInternetExplorer')) {
    function isInternetExplorer()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            return preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) ||
            (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false) ||
            (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; Touch; rv:11.0') !== false);
        }
    }
}

if (! function_exists('hyphenate')) {
    function hyphenate($str, $number = 4, $deliminator = '-')
    {
        return implode($deliminator, str_split($str, $number));
    }
}

if (! function_exists('markdown')) {
    function markdown($text)
    {
        return (new ParsedownExtra)->text($text);
    }
}

if (! function_exists('stripeUrl')) {
    function stripeUrl($text)
    {
        if (env('APP_ENV') === 'production') {
            return 'https://dashboard.stripe.com/search?query='.$text;
        }

        return 'https://dashboard.stripe.com/test/search?query='.$text;
    }
}
