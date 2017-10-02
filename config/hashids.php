<?php

/*
 * This file is part of Laravel Hashids.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'tickets',

    /*
    |--------------------------------------------------------------------------
    | Hashids Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'tickets' => [
            'salt' => 'TGE2Wu0wNPZxKB6FfPAQr3THbbRE3A119VJVOy2mhzJJwO7gZV',
            'length' => '5',
            'alphabet' => 'ABCDEFGHJKLMNPQRSTUVWXYZ2345789'
        ],

        'donations' => [
            'salt' => 'm8sxWjB5ld9bmIYrAgclcjD5NI5dG6FC01GMgLvhcdZmW8Bamr',
            'length' => '8',
            'alphabet' => 'ABCDEFGHJKLMNPQRSTUVWXYZ2345789'
        ],

    ],

];
