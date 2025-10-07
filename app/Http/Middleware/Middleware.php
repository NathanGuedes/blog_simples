<?php

namespace Http\Middleware;

use Exception;

class Middleware
{
    protected const array MAP = [
        'auth' => Auth::class,
        'guest' => Guest::class,
        'active' => Active::class,
        'notActive' => NotActive::class
    ];

    /**
     * @throws Exception
     */
    public static function resolve($key): void
    {
        if (! $key){
            return;
        }

        $middleware = static::MAP[$key] ?? false;

        if (! $middleware){
            throw new Exception('middleware not found');
        }

        (new $middleware)->handle();

    }
}