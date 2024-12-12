<?php declare(strict_types=1);

/**
 * @author Farsang Balázs <farsang.balazs617@gmail.com>
 */

return [
    [
        'route'     => '/v1/secret',
        'method'    => 'post',
        'class'     => 'SecretServer\Controllers\SecretController',
        'function'  => 'create'
    ],
    [
        'route'     => '/v1/secret/{hash}',
        'method'    => 'get',
        'class'     => 'SecretServer\Controllers\SecretController',
        'function'  => 'view'
    ],
];
