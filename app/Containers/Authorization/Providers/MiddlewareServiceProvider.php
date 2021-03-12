<?php

namespace App\Containers\Authorization\Providers;

use App\Ship\Parents\Providers\MiddlewareProvider;
use Illuminate\Auth\Middleware\Authorize;

class MiddlewareServiceProvider extends MiddlewareProvider
{
    /**
     * Register Middleware's
     *
     * @var  array
     */
    protected array $middlewares = [
        // ..
    ];

    /**
     * Register Container Middleware Groups
     *
     * @var  array
     */
    protected array $middlewareGroups = [
        'web' => [

        ],
        'api' => [

        ],
    ];

    protected array $routeMiddleware = [
        // Laravel default route middleware's:
        'can' => Authorize::class,
    ];
}
