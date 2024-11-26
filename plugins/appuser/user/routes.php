<?php

use AppUser\User\Http\Controllers\UsersController;
use AppUser\User\Http\Middleware\RegisterMiddleware;
use AppUser\User\Http\Middleware\LoginMiddleware;
use Appuser\User\Http\Middleware\AuthMiddleware;

Route::group(
    [
        "prefix" => "api/v1"
    ],
    function () {
        Route::post("register", [UsersController::class, "registerUser"])->middleware(RegisterMiddleware::class);
        Route::post("login", [UsersController::class, "loginUser"])->middleware(LoginMiddleware::class);
        Route::get("test", [UsersController::class, "test"])->middleware(AuthMiddleware::class);
        Route::post("logout", [UsersController::class, "logOut"]);
    }
);