<?php

use App\Http\Controllers\Api\CityController;
use Illuminate\Support\Facades\Route;

Route::apiResource('cities', CityController::class);
