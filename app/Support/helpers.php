<?php

use Illuminate\Support\Str;

if (! function_exists('str_snake')) {
    /**
     * Generate a HTML link.
     *
     * @param $string
     *
     * @return string
     */
    function str_snake($string)
    {
        return strtolower(str_replace(' ', '_', $string));
    }
}

if (! function_exists('str_title')) {
    /**
     * Generate a HTML link.
     *
     * @param $string
     *
     * @return string
     */
    function str_title($string)
    {
        return Str::title(str_replace('_', ' ', $string));
    }
}

if (! function_exists('cannot')) {
    /**
     * Generate a HTML link.
     *
     * @param $user
     * @param $permission
     *
     * @return string
     */
    function cannot($user, $permission)
    {
        if ($user->cannot($permission)) {
            flash('You do not have permission to '.str_title($permission), 'danger');

            return true;
        }

        return false;
    }
}

if (! function_exists('getStripeKey')) {
    function getStripeKey($group)
    {
        return config("$group.stripe.key");
    }
}

if (! function_exists('getStripeSecret')) {
    function getStripeSecret($group)
    {
        return config("$group.stripe.secret");
    }
}

if (! function_exists('getNameFromGroup')) {
    function getNameFromGroup($group)
    {
        return config("{$group}.short_name");
    }
}

if (! function_exists('markdown')) {
    function markdown($text)
    {
        return (new Parsedown)->text($text);
    }
}
