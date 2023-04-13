<?php

use Illuminate\Support\HtmlString;

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
        if (config('app.env') === 'production') {
            return 'https://dashboard.stripe.com/search?query=' . $text;
        }

        return 'https://dashboard.stripe.com/test/search?query=' . $text;
    }
}

if (! function_exists('array_shove')) {
    function array_shove(array $array, $selected_key, $direction)
    {
        $new_array = [];

        foreach ($array as $key => $value) {
            if ($key !== $selected_key) {
                $new_array["{$key}"] = $value;
                $last = ['key' => $key, 'value' => $value];
                unset($array["{$key}"]);
            } else {
                if ($direction !== 'up') {
                    // Value of next, moves pointer
                    $next_value = next($array);

                    // Key of next
                    $next_key = key($array);

                    // Check if $next_key is null,
                    // indicating there is no more elements in the array
                    if ($next_key !== null) {
                        // Add -next- to $new_array, keeping -current- in $array
                        $new_array["{$next_key}"] = $next_value;
                        unset($array["{$next_key}"]);
                    }
                } else {
                    if (isset($last['key'])) {
                        unset($new_array["{$last['key']}"]);
                    }
                    // Add current $array element to $new_array
                    $new_array["{$key}"] = $value;
                    // Re-add $last to $new_array
                    $new_array["{$last['key']}"] = $last['value'];
                }
                // Merge new and old array
                return $new_array + $array;
            }
        }
    }
}

if (! function_exists('recordLink')) {
    function recordLink($record, $route, $label)
    {
        $url = route('filament.resources.' . $route, $record);

        return filamentLink($url, $label);
    }
}

if (! function_exists('filamentLink')) {
    function filamentLink($url, $label) {
        return new HtmlString("<a class='filament-link inline-flex items-center justify-center font-medium outline-none hover:underline focus:underline text-sm text-primary-600 hover:text-primary-500 dark:text-primary-500 dark:hover:text-primary-400' href='{$url}'>{$label}</a>");
    }
}
