<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\HotelActiveMiddleware;
use App\Http\Middleware\RoomOwnershipMiddleware;
use Illuminate\Foundation\Application;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\HotelOwnershipMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            "user" => UserMiddleware::class,
            "auth" => AuthenticateMiddleware::class,
            "guest" => GuestMiddleware::class,
            "hotelOwnership" => HotelOwnershipMiddleware::class,
            "admin" => AdminMiddleware::class,
            "hotelActive" => HotelActiveMiddleware::class,
            "roomOwnership" => RoomOwnershipMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
