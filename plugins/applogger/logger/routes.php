<?php

use AppLogger\Logger\Http\Controllers\LogsController;
use Appuser\User\Http\Middleware\AuthMiddleware;

Route::group(
    [
        "prefix" => "api/v1",
        "middleware" => AuthMiddleware::class
    ],
    function () {
        Route::post("log", [LogsController::class, "log"]);
        Route::get("getLogs", [LogsController::class, "getLogs"]);
    }
);