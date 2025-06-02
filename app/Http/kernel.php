<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Auth\Middleware\Authenticate;

class Kernel extends HttpKernel
{
    // …

    protected $routeMiddleware = [
        'auth'      => Authenticate::class,
        // register exactly this key:
        'is_admin'  => \App\Http\Middleware\IsAdmin::class,
        // you can alias it again if you like, but be consistent:
        'admin'     => \App\Http\Middleware\IsAdmin::class,
        // …
    ];
}