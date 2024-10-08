<?php

use App\Http\Controllers\Api\AirlineController;
use Illuminate\Support\Facades\Route;

Route::apiResource('airlines', AirlineController::class);
