<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | Each Filter Set is related to a user. If you use a different class for
    | your user model you can specify it here.
    |
    */

    'models' => [
        'user' => App\Models\User::class,
        // 'filterSet' => null,
        // 'filterSetUser => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Filter Set Resource
    |--------------------------------------------------------------------------
    |
    | The Filter Set Resource provides a convenient way to view the Filter Sets
    | used throughout your application. If you extend the resource you can
    | disable the plug-in's resource here.
    |
    */

    'filter-set-resource' => [
        'enabled' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Favorites Bar Theme
    |--------------------------------------------------------------------------
    |
    | Filter Sets comes with three different themes for the Favorites Bar.
    | Select the theme you would like to use for your Favorites Bar.
    | Options are:
    | 1. links (default)
    | 2. tabs-brand
    | 3. tabs
    |
    */

    'favorites' => [
        'view' => 'links',
    ],

    /*
    |--------------------------------------------------------------------------
    | Forms
    |--------------------------------------------------------------------------
    |
    | The Filter Sets Create and Edit forms include helper_text for each input.
    | If you prefer not to display the helper text you can do that here. You
    | can edit the actual text by publishing and editing the lang files.
    |
    */

    'forms' => [
        'display_helper_text' => [
            'name' => false,
            'filters' => false,
            'public' => true,
            'favorite' => true,
            'global_favorite' => true,
        ],
    ],
];
