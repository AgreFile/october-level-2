<?php
use AppUser\User\Http\Controllers\UsersController;

Route::group(
    [
        "prefix" => "api/v1"
    ],
    function () {
        Route::post("register", [UsersController::class, "registerUser"]);
        Route::post("login", [UsersController::class, "loginUser"]);
        Route::post("logout", [UsersController::class, "logOut"]);
    }
);