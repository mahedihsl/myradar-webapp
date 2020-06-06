<?php

/*
 * This file is part of Laravel Pusher.
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

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Pusher Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'main' => [
            'auth_key' => 'e104f912331445995538',
            'secret' => '19444a266995cce93b46',
            'app_id' => '350227',
            'options' => ['encrypted'=>false,'cluster'=>'ap1'],
            'host' => null,
            'port' => null,
            'timeout' => null,
        ],

        'alternative' => [
            'auth_key' => '760c2def4d7b570c8841',
            'secret' => '943f771ed3c6b8162a3d',
            'app_id' => '430671',
            'options' => ['encrypted'=>false,'cluster'=>'ap1'],
            'host' => null,
            'port' => null,
            'timeout' => null,
        ],

    ],

];
