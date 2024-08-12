<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;

Route::controller(RouteController::class)->group(function () {
    Route::get('/', 'index');
});


